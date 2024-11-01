//main.js
(function(){

	if(window.addEventListener){
		document.addEventListener('readystatechange',function () {
			if (document.readyState=='complete'){
				run();
			}},false);
		
	}else if(window.attachEvent){
		document.attachEvent('onreadystatechange', function(){
			if (document.readyState=='complete'){
				run();
			}
		});
	}

	function run(){
		
		var _grid_view;
		if(window['vshop_cat_view_json']){
			_grid_view = new gridView();
		}
		
		jQuery('[data-win]').on('click', function(e)  {
			var content = jQuery(this).data('win');
			jQuery(this).toggleClass( "active" );
			jQuery(content).toggleClass("active");
		});

		jQuery(window).on("message",function(e) {
			var storage_name = "wizshop-stat100-uri";
			var data = null;
			try{
				if(e.originalEvent) 
					data = JSON.parse(e.originalEvent.data);
			}catch (e){
				data = null;
			}		
			if (data && data.wizshop) { 	
				//shop status
				if(data.shop_status && data.code == 100){
					try {
						jQuery.post(_wiz_main.ajaxurl, {action: 'wiz_shop_status', code: data.code, wp_nonce: _wiz_main.wp_nonce}, function(response) {
						var data1 = JSON.parse(response);
						if(data1 && data1.stat_url) {
							if(data1.stat_url != window.location.href){
								sessionStorage.setItem(storage_name,window.location.href);
								window.location = data1.stat_url;
							}else{
								var ref = sessionStorage.getItem(storage_name);
								if(ref){
									sessionStorage.removeItem(storage_name);
									var htm = jQuery("#v_link100").html();
									if(htm){
										jQuery("#v_link100").html(htm.replace(/{{Link}}/g, ref));
										jQuery("#v_link100").removeClass('v_ihide');
									}
								}
								jQuery("#v_status100").removeClass('v_ihide');
							}
						}	
					});	
					}catch (e1) {}		
				}else if(data.cpPainted){
					//hide grid view options when items count in (non filtered) grid ==0
					if(data.id && data.hasOwnProperty('count') && 0 === data.count &&
							((jQuery('#'+ data.id).attr('data-wiz-grid') !== undefined)) && 	
								!jQuery('#'+ data.id).attr('data-wiz-filter')){
						jQuery('[data-but-container]').addClass('v_ihide'); 
					}
					if((jQuery('#'+ data.id).attr('data-wiz-product') !== undefined)){
						setSharingBtns(data.id);
					}
					// components ver 1.77: each grid's item sends cpPainted event. 
					// No verifyImages needed
					if((jQuery('#'+ data.id).attr('data-wiz-grid') === undefined))
						verifyImages(data.id);
				}
			}
		});  
		
		function verifyImages(id){
			jQuery('#'+id).find('[data-img-size]').on('error',function(e) {
				var key = jQuery(this)[0].getAttribute("data-img-key");
				var size = jQuery(this)[0].getAttribute("data-img-size");
				var parent_a = '';
				if(key && 0 != key.indexOf("#")){
					if(size){
						//1st step
						jQuery(this).attr("src", _wiz_main.upload_url + _wiz_main.def_img.replace(".","-"+size+"."));
						jQuery(this).attr("data-img-size",'');
						parent_a = _wiz_main.upload_url + _wiz_main.def_img;
					}else{
						//1st step or 2nd step
						jQuery(this).attr("data-img-key",'#'+ key);
						jQuery(this).attr("src", _wiz_main.upload_url + key); 
						parent_a = _wiz_main.upload_url + key;
					}
				}else if(null != size){
					parent_a = _wiz_main.upload_url + _wiz_main.def_img;
					if(size != ""){
						//1st step if no valid key
						jQuery(this).attr("data-img-size",'');
					}else{
						//last step - origin def
						jQuery(this).removeAttr("data-img-size");
					}	
					jQuery(this).attr("src", _wiz_main.upload_url + 
						((size) ? _wiz_main.def_img.replace(".","-"+size+"."):_wiz_main.def_img ));
				}
				if(parent_a && 'A' == jQuery(this).parent().prop("tagName") && (null != jQuery(this).parent()[0].getAttribute("data-img-key"))){
					jQuery(this).parent().prop("href", parent_a);
				}
				
			});
		}
		
		function gridView(){

			init();
			
			if(jQuery('[data-grid-scripts]')[0]){
				refresh(vshop_cat_view_json.default);
			}else{
				if(0 == jQuery('[data-grid-view]').html().trim().length){
					change_view(vshop_cat_view_json.default);
				}else{
					keep_type(vshop_cat_view_json.default);
					refresh(vshop_cat_view_json.default);
				}
			}
				
			function change_view(type){
				if(jQuery('[data-grid-scripts]')[0]){
					local_render(type);
				}else {
					ajax_render(type);
				}
			}	

			function init(){
				var total_count = 0;
				var hidden_count= 0;
				for (key in vshop_cat_view_json) {
					if("default" == key) continue;
					total_count++;
					var itemjQuery = jQuery('[data-view-btn=' + key +']');
					if(0 != parseInt(vshop_cat_view_json[key])){
						itemjQuery.click(function(e) {
							if(!jQuery(this).hasClass('v_iselect'))
								change_view(e.target.getAttribute("data-view-btn"));
						});				
					}else{
						hidden_count++;
						itemjQuery.addClass('v_ihide'); 
					}
				}
				if((total_count - hidden_count) <= 1){
					jQuery('[data-but-container]').addClass('v_ihide'); 
				}
				return;
			}
			
			function refresh(type){
				if(jQuery('[data-but-container]').hasClass('v_ihide')) return;
				for (key in vshop_cat_view_json){
					if("default" == key) continue;
					var itemjQuery = jQuery('[data-view-btn=' + key +']');
					if (!itemjQuery.hasClass('v_ihide')){
						(type == key) ? itemjQuery.addClass('v_iselect') : itemjQuery.removeClass('v_iselect');
					}
				}	
			}
			
			function notify(){
				postMessage(JSON.stringify({ newComponent:true, wizshop:true}),'*');	
				if(_vsc_static_cat_json && _vsc_static_cat_json.cat.path){
					postMessage(JSON.stringify(_vsc_static_cat_json), "*");
				}else if(_vsc_static_query_json && _vsc_static_query_json.text){
					postMessage(JSON.stringify(_vsc_static_query_json), "*")
				}
			}
			
			function local_render(type){
				if(!type) return;
				refresh(type);
				jQuery('[data-grid-view]').html(decodeURIComponent(jQuery('#wiz_script-'+ type).html()));
				keep_type(type);
				notify();
			}
			
			function ajax_render(type){
				if(!type) return;
				keep_type(type);
				var jq_grid_view = jQuery('[data-grid-view]');
				var post_data = {
					action: 'wiz_template_load',
					wp_nonce: _wiz_main.wp_nonce,
					part: 	jq_grid_view.attr('data-grid-view'),
					lang: 	jq_grid_view.attr('data-grid-lang'),
					filter: (null != jq_grid_view.attr('data-wiz-filter')) ? jq_grid_view.attr('data-wiz-filter') : "" ,
					count: 	(null != jq_grid_view.attr('data-wiz-count')) ? jq_grid_view.attr('data-wiz-count') : "" ,
					id: 	(null != jq_grid_view.attr('data-wiz-id')) ? jq_grid_view.attr('data-wiz-id') : "" ,
				};
				jQuery.post(_wiz_main.ajaxurl, post_data, function(result){
					if(result){
						refresh(type);
						jQuery('[data-grid-view]').html(result);
						notify();
					}
				});
			}
			
			function cookieName(){
				return  (_vsc_static_cat_json && _vsc_static_cat_json.cat.path) ? _wiz_main.cat_view_type_cookie : 
							((_vsc_static_query_json && _vsc_static_query_json.text) ? _wiz_main.search_view_type_cookie : "");
			}

			function keep_type(type){
				if(type){
					document.cookie = cookieName()+"="+type+";path="+_wiz_main.cookie_path+";";
				}
			}
		}

		var networks = {
				facebook: { href: 'https://www.facebook.com/sharer.php?u={{u}}', width: 570, height: 570},
				twitter:  { href: 'https://twitter.com/intent/tweet?url={{u}}&text={{d}}', width: 570, height: 570 },
				linkedin: { href: 'https://www.linkedin.com/shareArticle?mini=true&url={{u}}&title={{t}}&summary={{d}}&source={{u}}', width: 570, height :570 },
				whatsapp: { href: 'https://api.whatsapp.com/send?text=*{{t}}*\n{{d}}\n{{u}}', width: 570, height: 570},
				email: 	  { href: 'mailto:?subject={{t}}&body={{d}}\n{{u}}', width: 570, height: 570}
			};
					
		function setSharingBtns(id){
			if(null != window["_vsc_static_item_json"].res){
				jQuery('#'+id).find('[data-share-btn]').each(function(index, el){
					network = el.getAttribute("data-share-btn");
					if(el.getAttribute("data-key") == window["_vsc_static_item_json"].item && networks[network]){
						on_click(el, network);
					}
				});
				
				function on_click(el, name){
					jQuery(el).on('click', function() {
						open_link(name);
					} );					
				}
				
				function open_link(network){
					var u = __wizshop_vc_meta.url;
					var t = __wizshop_vc_meta.title;
					var d = __wizshop_vc_meta.description;
					if(d == t) d="";
					var n_link = networks[network].href.replace(/{{u}}/g,u).replace(/{{t}}/g,t).replace(/{{d}}/g,d);
					if(u && n_link){
						var op = 'menubar=no,toolbar=0,resizable=yes,scrollbars=yes,status=0'
										 +',height='+networks[network].height
										 +',width='+networks[network].width
										 +',top='+(screen.height/2-networks[network].height/2)
										 +',left='+(screen.width/2-networks[network].width/2)
						open(encodeURI(n_link), (n_link).startsWith("https://") ? "" : "_self", op);
					}
				}
			}
		}
	}
})();