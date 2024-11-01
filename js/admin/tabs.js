//tabs.js
jQuery(document).ready(function($) {    
	
	//auto options submit
	check_submit();
	
	function check_submit(){
		if("#wiz-settings-submit" == location.hash){
			location.hash = "";
			$('#wiz-settings-submit').click();
		}
	}
	
	$( window ).on( 'hashchange', function( e ) {check_submit()} );	
	
	//ajax
	function update(obj, cb){
		var data = JSON.parse(JSON.stringify(obj));
		data['action'] = 'wiz_products_view_settings';
		jQuery.post(ajaxurl, data, function(response){
			try{
				var res = JSON.parse(response);
				if(res.reload) {
					location.reload();	
				}else if(cb){
					cb(res);
				}	
			}catch (e) {}	
		});
	}	
	
	function get_sum_val(att){
		var val = 0;
		$('['+att+']').each(function() {
			if($(this).prop( "checked" )){
				val += parseInt($(this).attr(att));
			}
		});
		return val;
	}
	//--------------------------------------------------------
	// manage tabs
	//--------------------------------------------------------
	$(".pages-tab-scroll").css({'height': ($(window).height()-460) + 'px'}).css({'overflow': 'auto'});
	
	$('.tabs .tab-links a').on('click', function(e)  {
		var tab = $(this).attr('href');
		$('.tabs ' + tab).show().siblings().hide();
		$(this).parent('li').addClass('active').siblings().removeClass('active');
    });

	//--------------------------------------------------------
	//views
	//--------------------------------------------------------

	//--------------------------------------------------------
	//seo (doc title)
	$('[data-wiz-seo-flag]').change(function(e) {
		set_seo_but();
	});
	$('#v_seo_save').click(function(e) {
		var val = get_seo_val();
		update_seo_val(val, function(res){
				if(res.success){
					$('#v_seo_save').attr('data-wiz-seo-prev', val);
					set_seo_but();
				}
			});
	});	
	$('#v_seo_def').click(function(e) {
		var val = parseInt($(this).attr('data-wiz-seo-def'));
		update_seo_val(val, function(res){
			if(res.success){
				$('[data-wiz-seo-flag]').each(function() {
					$(this).prop("checked", val & parseInt($(this).attr('data-wiz-seo-flag')) );
				});
				$('#v_seo_save').attr('data-wiz-seo-prev', val);
				set_seo_but();
			}
		});
	});	
	function update_seo_val(val, cb){
		update({'doc_title': val},cb);
	}
	function get_seo_val(){
		return get_sum_val('data-wiz-seo-flag');
	}
	function set_seo_but(){
	}		
	
	//--------------------------------------------------------
	var _last_disp_type = "";
	
	//product view
	$('[data-wiz-prdoducts-view-sec] :input').change(function(e) {
		set_products_view_but();
	});
	$('#v_pview_save').click(function(e) {
		if(!is_view_changed()) return;
		
		var val = get_products_html_obj();
		
		var upd_val = get_products_view_prev_obj();
		upd_val[_last_disp_type] = JSON.parse(JSON.stringify(val));
		upd_val.last = _last_disp_type;
		
		val['products_view'] = _last_disp_type;

		update(val, function(res){
				if(res.success){
					$('#v_pview_save').attr('data-wiz-products-view-prev', JSON.stringify(upd_val));
					set_products_view_but();
				}
			});
	});	
	$('#v_pview_def').click(function(e) {
		var val =  get_products_view_def_obj()[_last_disp_type];
		
		var upd_val = get_products_view_prev_obj();
		upd_val[_last_disp_type] = JSON.parse(JSON.stringify(val));
		upd_val.last = _last_disp_type;
		
		val['products_view'] = _last_disp_type;

		update(val, function(res){
			if(res.success){
				$('#v_pview_save').attr('data-wiz-products-view-prev', JSON.stringify(upd_val));
				set_cur_product_view(_last_disp_type);
				set_products_view_but();
			}
		});
	});	
	
	$("[data-wiz-navigation]").click( function(){
		var nav = parseInt($(this).attr('data-wiz-navigation'));
		if($(this).prop("checked") && (nav & 6) ){
			$("[data-wiz-navigation='"+((2==nav) ? 4 : 2).toString()+"']").prop("checked", false);
		}
	});
	
	$('#v_product_device').change(function(e) {
		if(is_view_changed() && confirm(_wiz_tabs.products_save)){
			$('#v_pview_save').click();
			_last_disp_type = $(this).find('option:selected').val();
		}else{
			_last_disp_type = $(this).find('option:selected').val();
		}
		set_cur_product_view(_last_disp_type);
	});
	
	
	function get_products_html_obj(){
		var val = {};
		$('[data-wiz-prdoducts-view-sec] :input').each(function() {
			var id = $(this).prop("id");
			if(id){
				if($(this).prop("type") == "checkbox"){
					val[id] = $(this).prop("checked") ? 1 : 0;
				}else if($(this).prop("type") == "number"){
					val[id] =  parseInt($(this).prop("value"));
				}else{
					val[id] =  $(this).prop("value");
				}
			}
		});
		val['gallery_line'] = parseInt($('#gallery_line').find('option:selected').val());
		val["navigation"] = get_sum_val("data-wiz-navigation");
		val["sidebar"] = get_sum_val("data-wiz-sidebar-page");
		val["quick_view"] = $('#v_quick_view').prop("checked") ? 1 : 0;
		val["min_quick_view"] = $('#v_min_quick_view').prop("checked") ? 1 : 0;
		val["top_filter"] = $('#v_top_filter').prop("checked") ? 1 : 0;
		
		return val;
	}
	//--------------------------------------------------------
	function get_products_view_def_obj(){
		return JSON.parse($('#v_pview_def').attr('data-wiz-products-view-def'));
	}
	//--------------------------------------------------------
	function get_products_view_prev_obj(min){
		return JSON.parse($('#v_pview_save').attr('data-wiz-products-view-prev'));
	}
	//--------------------------------------------------------
	function set_products_view_but(){
		//var val = get_products_html_obj();
		//(JSON.stringify(get_products_view_def_obj()) == JSON.stringify(val)) ? $('#v_pview_def').addClass('v_ihide') : $('#v_pview_def').removeClass('v_ihide');
		//(JSON.stringify(get_products_view_prev_obj()) == JSON.stringify(val)) ? $('#v_pview_save').addClass('v_ihide') : $('#v_pview_save').removeClass('v_ihide');
	}	
	//--------------------------------------------------------
	function init_products_disp_type(){
		var prev = get_products_view_prev_obj();
		for (var key in _wiz_tabs.disp_options ){
			$('#v_product_device').append($('<option>', {value: key, text : _wiz_tabs.disp_options[key].ui_name, selected: (key==prev.last)}));
		}
		_last_disp_type = prev.last;
	}
	//--------------------------------------------------------
	function set_cur_product_view(disp){
		var prev = get_products_view_prev_obj();
		if(!disp) disp = prev['last'];
		var cur_view = prev[disp];
		
		$('#gallery_page').prop("value",cur_view['gallery_page']);
		$("#gallery_line").empty();
		
		for(var i=0; i< _wiz_tabs.disp_options[disp]['num_in_line'].length; i++){
			var val = _wiz_tabs.disp_options[disp]['num_in_line'][i];
			$('#gallery_line').append($('<option>', {
					value: val, 
					text: val, 
					selected: (val == cur_view['gallery_line'])
				}
			));
		}
		
		$('#table_page').prop("value",cur_view['table_page']);
		$('#lines_page').prop("value",cur_view['lines_page']);
		
		$('#v_nav_pagination').attr("checked", (cur_view['navigation'] & 1) ? true : false );
		$('#v_nav_scrolling').attr("checked", (cur_view['navigation'] & 4) ? true :false);
		$('#v_nav_button').attr("checked", (cur_view['navigation'] & 2)? true : false );
		
		$('#v_quick_view').attr("checked", (cur_view['quick_view'] == 1)? true : false );
		$('#v_min_quick_view').attr("checked", (cur_view['min_quick_view'] == 1)? true : false );
		$('#v_top_filter').attr("checked", (cur_view['top_filter'] == 1)? true : false );

		$('#v_sidebar_shop').attr("checked", (cur_view['sidebar'] & 1) ? true : false );
		$('#v_sidebar_product').attr("checked", (cur_view['sidebar'] & 4) ? true :false);
		$('#v_sidebar_grid').attr("checked", (cur_view['sidebar'] & 2)? true : false );

	}
	//--------------------------------------------------------
	function is_view_changed(){
		var old_obj = get_products_view_prev_obj()[_last_disp_type];
		var new_obj = get_products_html_obj();
		for (var key in old_obj){
			if(new_obj[key] != old_obj[key])
				return true;
		}
		return false;
	}
	
	
	//--------------------------------------------------------
	//init
	//--------------------------------------------------------
	if($('#v_pview_save')[0]){
		init_products_disp_type();
		set_cur_product_view();
	
		set_seo_but();
		set_products_view_but();

		if(location.hash){
			$('.tabs ' + location.hash).show().siblings().hide();
			$('[href='+location.hash+']').parent('li').addClass('active').siblings().removeClass('active');
		}else{
			$('.tab-links :first-child').addClass('active').siblings().removeClass('active');
		}
	}
	
});