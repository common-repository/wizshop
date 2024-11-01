//pages.js
jQuery(document).ready(function($) {    

	//--------------------------------------------------------
	//window props
	//--------------------------------------------------------
	var $page_con	= $('#v_page_con');
	var $page_select= $('#v_page_item_select');
	var $lang_select= $('#v_pages_lang');

	if($page_select[0]){
		$page_select.find('option').remove().end().
			append($('<option />').text(_wiz_pages.no_page.name).val(_wiz_pages.no_page.id)).
			append($('<option />').text(_wiz_pages.def_page.name).val(_wiz_pages.def_page.id)).
			append($('<optgroup />').attr('label', _wiz_pages.pages_sep));
			
		var $grp = $page_select.find('optgroup');	
		if(_wiz_pages.user_pages){
			for(var i=0; i < _wiz_pages.user_pages.length; i++){
				$grp.append($('<option />').text(_wiz_pages.user_pages[i].title).val(_wiz_pages.user_pages[i].id));
			}
		}
	}	
	
	$('#v_page_close').click(function(e) {
		var ok = false;
		var index = parseInt($page_con.attr('wiz-index'));
		var id = parseInt($page_select.val());
		
		if(id > 0 &&  id != _wiz_pages.info[index].def_id && _wiz_pages.info[index].user_pages){
			if(!confirm(_wiz_pages.alert_new)){
				return;
			}
		}
		
		var data = JSON.parse(JSON.stringify(_wiz_pages.info[index]));
		data.id = id;
		_wiz_pages.info[index].id = (-2 == id) ? _wiz_pages.info[index].def_id : id;
		$page_con.addClass('v_ihide');
		update(data, 'wiz_set_page');
		paintList();
	});

	$('#v_page_cancel').click(function(e) {
		$page_con.attr('wiz-index', -1);
		$page_con.addClass('v_ihide');
		paintList();
	});	

	$lang_select.change(function() {
		$page_con.addClass('v_ihide');
		paintList();
	});
	
	function update(data, action){
		data['action'] = action;
		jQuery.post(ajaxurl, data, function(response){
			try{
				var res = JSON.parse(response);
				if(res.reload) {
					location.reload();	
				}else {
				}	
			}catch (e) {}	
		});
	}
	//--------------------------------------------------------
	
	//--------------------------------------------------------
	//list props
	//--------------------------------------------------------
	var _page_html = $('#v_page_html').html();
	var $pages_list = $('#v_page_list');
	
	function paintItem(i, cb){
		if(i >= _wiz_pages.info.length) cb("");
		getPageItem(_wiz_pages.info[i].id,function(item){
			var info_title = _wiz_pages.info[i].title;
			var page_title = ""
			if(-1 != _wiz_pages.info[i].id){
				if(item){
					page_title = item.title;
					if(_wiz_pages.info[i].id==_wiz_pages.info[i].def_id){
						page_title += " (" + _wiz_pages.def_page.name + ")";
					}
				}
			}else{
				page_title = _wiz_pages.no_page.name;
			}	
			var html_item = _page_html;
			html_item = html_item.replace(/{{index}}/g, i);
			html_item = html_item.replace(/{{is_tmpl}}/g, _wiz_pages.info[i].is_tmpl);
			html_item = html_item.replace(/{{wiz_page}}/g,info_title);
			html_item = html_item.replace(/{{user_page}}/g, page_title);
			html_item = html_item.replace(/{{link}}/g,(item) ? item.link : "");
			cb(html_item);		
		});
	}
	
	function getPageItem(id, cb){
		var item;
		var j = -1;
		if(-1 != id){
			++j;
			for (	;  j < _wiz_pages.user_pages.length; j++) {
				if(_wiz_pages.user_pages[j] && _wiz_pages.user_pages[j].id === id){
					item = _wiz_pages.user_pages[j];
					break;
				}
			}
		}
		cb(item,j);
	}
	
	function paintList(){
		var lang = $lang_select.val();
		$("[data-wiz-page-info-item]").remove();
		var html_block = "";
		if($pages_list[0]){
			for(var i=0; i< _wiz_pages.info.length; i++){
				if(lang == _wiz_pages.info[i].lang){
					paintItem(i,function(htm){
						html_block += htm;
					});
				}
			}
			$pages_list.append(html_block);
		}
	
		$('[data-wiz-edit-page-info-item]').click(function(e) {
			if(!$page_con.hasClass('v_ihide')){
				paintList();
			}
			var index = parseInt(e.target.getAttribute('data-wiz-edit-page-info-item'));
			if(-1 == index) return;
			$page_con.attr('wiz-index', index.toString());
			getPageItem(_wiz_pages.info[index].id,function(item, page_index){
				$("#v_page_title").html(_wiz_pages.info[index].title);
				$tr = $('[data-wiz-page-info-item=\"'+index.toString() + '\"]');
				$page_con.insertAfter($tr);
				$tr.remove();
				$page_con.removeClass('v_ihide');
				$page_select.prop('selectedIndex',(item) ? ((item.id==_wiz_pages.info[index].id) ? pageIndexToSelect(page_index) : 1) : 0);
				$page_select.focus();			
			});
		});	
	}
	
	function pageIndexToSelect(index){
		return index+2;
	}
	
	//--------------------------------------------------------
	//init
	//--------------------------------------------------------
	$page_con.addClass('v_ihide');
	
	paintList();	
});
