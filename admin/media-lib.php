<?php
global $wizshop_media_settings;
global $wizshop_image_settings;
$view_op = wizshop_get_view_options();
$v_arr = wizshop_get_images_size();
if ($v_arr['grid_crop']) $v_arr['grid_crop'] = 'checked';
if ($v_arr['product_crop']) $v_arr['product_crop'] = 'checked';
if ($v_arr['thumb_crop']) $v_arr['thumb_crop'] = 'checked';
if ($v_arr['cat_crop']) $v_arr['cat_crop'] = 'checked';

$op_img = wizshop_get_option($wizshop_image_settings['name']);
$def_img_id = $op_img["def_img_id"];
$img_att = wp_get_attachment_image_src( ($def_img_id > 0) ? $def_img_id : '','thumbnail',false);
?>
<div id="overlay"></div>
<div class="wrap" id="wizshop-wrapper">
		
	<h1><?php echo __("WizShop Media Settings", WizShop)?></h1>
	

	
	<p class="sub-header"><?php echo __("The dimensions set here are the maximum sizes (in pixels) for item pictures", WizShop)?></p>
    <div class="media-settings">
     	<form>
        	<table border="0" cellspacing="2" cellpadding="0">
              <thead>
              	<tr>
                  <th width="140"></th>
                  <th width="80"><?php _e('Width')?></th>
                  <th width="100"><?php _e('Height')?></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><?php _e('Thumbnail')?></td>
                  <td><input type="text" id="thumb_w" placeholder="<?php echo esc_attr($wizshop_media_settings['defaults']['thumb_w']); ?>" value="<?php echo esc_attr($v_arr['thumb_w']); ?>"> x </td>
                  <td><input type="text" id="thumb_h" placeholder="<?php echo esc_attr($wizshop_media_settings['defaults']['thumb_h']); ?>" value="<?php echo esc_attr($v_arr['thumb_h']); ?>"> px</td>
                  <td style="display:none;"><label><input type="checkbox" id="thumb_crop" value="true" <?php echo esc_attr($v_arr['thumb_crop']); ?>><?php _e('Crop')?></label></td>
                </tr>
                <tr>
                  <td><?php echo __('Grid image', WizShop)?></td>
                  <td><input type="text" id="grid_w" placeholder="<?php echo esc_attr($wizshop_media_settings['defaults']['grid_w']); ?>" value="<?php echo esc_attr($v_arr['grid_w']); ?>"> x </td>
                  <td><input type="text" id="grid_h" placeholder="<?php echo esc_attr($wizshop_media_settings['defaults']['grid_h']); ?>" value="<?php echo esc_attr($v_arr['grid_h']); ?>"> px</td>
                  <td style="display:none;"><label><input type="checkbox" id="grid_crop" value="true" <?php echo esc_attr($v_arr['grid_crop']); ?>><?php _e('Crop')?></label></td>
                </tr>
                <tr>
                  <td><?php echo __('Product image', WizShop)?></td>
                  <td><input type="text" id="product_w" placeholder="<?php echo esc_attr($wizshop_media_settings['defaults']['product_w']); ?>" value="<?php echo esc_attr($v_arr['product_w']); ?>"> x </td>
                  <td><input type="text" id="product_h" placeholder="<?php echo esc_attr($wizshop_media_settings['defaults']['product_h']); ?>" value="<?php echo esc_attr($v_arr['product_h']); ?>"> px</td>
                  <td style="display:none;"><label><input type="checkbox" id="product_crop" value="true" <?php echo esc_attr($v_arr['product_crop']); ?>><?php _e('Crop')?></label></td>
                <tr>
                  <td><?php echo __('Category image', WizShop)?></td>
                  <td><input type="text" id="cat_w" placeholder="<?php echo esc_attr($wizshop_media_settings['defaults']['cat_w']); ?>" value="<?php echo esc_attr($v_arr['cat_w']); ?>"> x </td>
                  <td><input type="text" id="cat_h" placeholder="<?php echo esc_attr($wizshop_media_settings['defaults']['cat_h']); ?>" value="<?php echo esc_attr($v_arr['cat_h']); ?>"> px</td>
                  <td style="display:none;"><label><input type="checkbox" id="cat_crop" value="true" <?php echo esc_attr($v_arr['cat_crop']); ?>><?php _e('Crop')?></label></td>
                </tr>
                </tr>
               </tbody>
            </table>
        </form> 
		<p class="sub-header">
		
		<input type="checkbox" id="item_gallery" value="1"  <?php echo (1 == $view_op['item_gallery'])? ' checked/>' :'>' ?>
		<label for="item_gallery">
		 
		   <?php echo __("Use WP Media for Product's additional images", WizShop);?>	
		</label>	
		</p>
		<p>
			<?php
				echo __("Learn <a href='https://wizshop.co.il/%d7%94%d7%95%d7%a1%d7%a4%d7%aa-%d7%aa%d7%9e%d7%95%d7%a0%d7%95%d7%aa-%d7%a0%d7%95%d7%a1%d7%a4%d7%95%d7%aa-%d7%9c%d7%a4%d7%a8%d7%99%d7%98/' target='_blank'>more</a> about Product's additional images.", WizShop)
				." ".__("Web Designers can find more about Image Sizes <a href='https://wizshop.co.il/%d7%94%d7%a2%d7%9c%d7%90%d7%aa-%d7%aa%d7%9e%d7%95%d7%a0%d7%95%d7%aa-%d7%9e%d7%95%d7%a6%d7%a8%d7%99%d7%9d/' target='_blank'>here</a>.", WizShop);
			?>
		</p>
        <button class="button button-primary" onclick="saveMediaSettings();"><i class="fa fa-save"></i><?php _e("Save")?></button>   
    </div>
	
	<h1><?php echo __("WizShop Media Files", WizShop)?></h1>    
    <p class="sub-header"><?php echo __("Here you can upload new images and edit the media library", WizShop)?></p>
	<p class="help dashicons-before dashicons-info"><?php echo __("The images will appear in the general media folder", WizShop)?></p>
	<div class="uploader">
	<div class="media-settings">
		<div class="media-settings-inner">
			<input type="text" style="display:none;"  data-image-url></input>
			<button data-upload-btn data-upload-title="<?php _e('Media')?>" id="upload-btn" class="button button-primary">
				<i class="fa fa-upload"></i><?php echo __('Insert Media', WizShop)?>
			</button>
		</div>
	</div>
	</div> 
		
	<h1><?php echo __("WizShop Default Image", WizShop)?></h1>    
    <p class="sub-header"><?php echo __("Set default fallback image", WizShop)?></p>
	<div>
		<img data-image-src  src="<?php echo isset($img_att[0]) ? esc_attr($img_att[0]) : '' ; ?>" width="150" height="150">
		<div>
		<input data-image-file 
			value="<?php echo isset($img_att[0]) ? esc_attr(get_the_title($def_img_id)) : _e('No image set'); ?>"		
			def-val = "<?php  _e('No image set')?>"  type="text" readonly />
		<input data-image-id name="image-id" type="hidden" value="<?php echo isset($def_img_id) ? esc_attr($def_img_id) : ''; ?>">
		</div>
		<div>
		<p>
		<button data-upload-btn data-def-img="1" data-upload-title="<?php echo esc_attr($def_img_id)?>" id="upload-btn" class="button button-primary">
			<i class="fa fa-upload"></i><?php echo __('Choose Image', WizShop)?>
		</button>
		</p>
		</div>
	</div>		
		
		
</div>