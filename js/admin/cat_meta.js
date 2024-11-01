//cat_meta.js
jQuery(document).ready(function($) {    
	//$('.form-wrap #addtag').parent().addClass('hidden');
	
	//category edit
	$("[name='view-type[]']").click(function() {
		$("#view-type-def").prop('checked',false);
	});
	//categories edit
	$("#view-type-def").click(function() {
		if($(this).is(':checked')) {
			$("[name='view-type[]").prop('checked',false);
		}
	});
	
	$( document ).ajaxError(function(event, jqxhr, settings, thrownError) {
	  	if(settings.data.indexOf('action=wiz_get_cats') > -1){
			location.reload();	
		}
	});	
});
function catmeta_post(ajax_data){
	jQuery.post(ajaxurl, ajax_data, function(response) {
		try{
			var data = JSON.parse(response);
			if(data.success) {
			}else{
			}	
		}catch (e) {}
		location.reload();	
	});	
}

function ajaxImportCategories(action){
	jQuery("#overlay").fadeIn(300);
	var ajax_data = {
		'action': action,
		'shop_id': jQuery('#shop_id').val(),
		'cat_opt': jQuery('#cat_opt').val(),
		'v_del_cats': jQuery('#v_del_cats').prop('checked') ? '1' : '0',
		'v_img_upd': jQuery('#v_img_upd').prop('checked') ? '1' : '0',
	};
	catmeta_post(ajax_data);
}

function ajaxUpdateViewOptions(action){
	jQuery("#overlay").fadeIn(300);
	var view_option = 0;
	jQuery("[name='view-type[]").each(function(i,vt){
		if(jQuery(vt).is(':checked')) {
			view_option += parseInt(jQuery(vt).val());
		}
	});
	var ajax_data = {
		'action': action,
		'view_options': view_option,
		'cat_opt': jQuery('#cat_opt').val(),
	};
	catmeta_post(ajax_data);
}