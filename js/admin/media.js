//media.js
function wiz_getSize(id){
	var $it = jQuery('#'+id);
	var val = $it.val().trim();
	if(!val || isNaN(val) || parseInt(val) <= 0){
		var ph = $it.attr('placeholder');
		if(ph) {
			$it.val(ph);
			val = ph;
		}
	}
	return val;
}


function saveMediaSettings() {
	jQuery("#overlay").fadeIn(300);
	
	var grid_crop = 0;
	var product_crop = 0;
	var thumb_crop = 0;
	var cat_crop = 0;
	
	if (jQuery("#grid_crop").prop("checked") == true) grid_crop = 1;
	if (jQuery("#product_crop").prop("checked") == true) product_crop = 1;
	if (jQuery("#thumb_crop").prop("checked") == true) thumb_crop = 1;
	if (jQuery("#cat_crop").prop("checked") == true) cat_crop = 1;
	
	var data = {
		'action': 'wiz_set_image_sizes',
		'grid_w': wiz_getSize('grid_w'),
		'grid_h': wiz_getSize('grid_h'),
		'grid_crop': grid_crop,
		'product_w': wiz_getSize('product_w'),
		'product_h': wiz_getSize('product_h'),
		'product_crop': product_crop,
		'thumb_w': wiz_getSize('thumb_w'),
		'thumb_h': wiz_getSize('thumb_h'),
		'thumb_crop': thumb_crop,
		'cat_w': wiz_getSize('cat_w'),
		'cat_h': wiz_getSize('cat_h'),
		'cat_crop': cat_crop,
		'item_gallery': (jQuery("#item_gallery").prop("checked") == true) ? 1 : 0,
	};
	
	jQuery.post(ajaxurl, data, function(result){
		//show_alert_box(result == "1");
		location.reload();
	});
}

jQuery(document).ready(function($) {
	var attachments_uploaded = [];	
	var frame;

	$('[data-upload-btn]').click(function(e) {
		e.preventDefault();
		if(frame) {
            frame.open();
            return;
        }
		var title = $(this).attr('data-upload-title');
		var is_def_img =  $(this).attr('data-def-img');
		frame  = wp.media({ 
			frame: 'select',
			title: (title) ? title : '',
			library : { type : 'image'},
			multiple: false
		});
		frame.on('select', function(){
			var uploaded_image = frame.state().get('selection').first();
			if(uploaded_image){
				var json_image = uploaded_image.toJSON();
				if(is_def_img){
					jQuery.post(ajaxurl, {'action': 'wiz_set_def_img', 'img_id' : json_image.id}, function(response){
						try{
							var res = JSON.parse(response);
							if(res.reload) {
								location.reload();	
							}	
						}catch (e) {}	
					});
				}else{
					setTimeout(function(){			
						$('[data-image-url]').val(json_image.url);
						$('[data-image-src]').attr('src',json_image.url);
						$('[data-image-id]').val(json_image.id);
						$('[data-image-file]').val(json_image.title);
					},100);	
				}
			}
		});
		frame.open();
	});	
	
	$('[data-remove-btn]').click(function(e) {
		e.preventDefault();
		$('[data-image-src]').attr('src','');
		$('[data-image-id]').val('');
		$('[data-image-url]').val('');
		$('[data-image-file]').val($('[data-image-file]').attr('def-val'));
		//$(this).addClass('hidden');
	});	
			
	if(wp.Uploader){
		
		wp.Uploader.queue.on( 'add', function ( attachment ) {
			attachments_uploaded.push( attachment );
		});
			
		wp.Uploader.queue.on( 'reset', function () {
			if(attachments_uploaded.length > 0){		
				var got_one=true; //check here
				var models = wp.media.frame.content.get().collection.models;
				for(var i=0; i< attachments_uploaded.length && !got_one; i++){
					var f_name = attachments_uploaded[i].attributes.filename.toLowerCase();
					for(var j= models.length-1; j >=0; j--){
						if(attachments_uploaded[i].id != models[j].id &&
								models[j].attributes.filename.toLowerCase() == f_name){
							got_one = true;
							break;
						}
					}
				}
				attachments_uploaded = [];
				if(got_one){
					if(wp.media.frame.content.get()!==null){
					   wp.media.frame.content.get().collection.props.set({ignore: (+ new Date())});
					   wp.media.frame.content.get().options.selection.reset();
					}else{
					   wp.media.frame.library.props.set({ignore: (+ new Date())});
					}
				}
			}
		});
	}
		
});