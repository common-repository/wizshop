<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/*-------------------------*/ 
/* class  WizShop_Cat_Meta */
/*-------------------------*/ 
class WizShop_Cat_Meta {
	
	public function __construct() {
	
		global $wizshop_cat_taxonomies;
		
        add_action( 'admin_init', array( $this, 'admin_init' ) );

		add_action( $wizshop_cat_taxonomies[wizshop_lang_he]['name']  . '_edit_form_fields', array( $this, 'action_edit_category_term' ), 10, 2);
		add_action( 'edited_' . $wizshop_cat_taxonomies[wizshop_lang_he]['name'] , array( $this, 'action_post_category_update' ), 10, 2);
		add_action($wizshop_cat_taxonomies[wizshop_lang_he]['name']  . '_pre_add_form', array( $this, 'action_add_import_fields'));

		add_action( $wizshop_cat_taxonomies[wizshop_lang_en]['name']  . '_edit_form_fields', array( $this, 'action_edit_category_en_term' ), 10, 2);
		add_action( 'edited_' . $wizshop_cat_taxonomies[wizshop_lang_en]['name'] , array( $this, 'action_post_category_en_update' ), 10, 2);
		add_action($wizshop_cat_taxonomies[wizshop_lang_en]['name']  . '_pre_add_form', array( $this, 'action_add_import_fields_en'));

		add_action( 'wp_ajax_wiz_get_cats', array( $this,'wiz_get_cats_callback') );
		add_action( 'wp_ajax_wiz_view_options', array( $this,'wiz_view_options_callback') );
		add_action( 'wp_ajax_wiz_set_image_sizes', array( $this,'wiz_set_image_sizes_callback') );
		add_action( 'wp_ajax_wiz_set_def_img', array( $this,'wiz_set_def_img_callback') );
		add_action( 'wp_ajax_wiz_set_menus', array( $this,'wiz_set_menus_callback'));
		add_action( 'wp_ajax_wiz_set_page', array( $this,'wiz_set_page_callback'));
		add_action( 'wp_ajax_wiz_products_view_settings', array( $this,'wiz_products_view_settings_callback'));
		add_action( 'wp_ajax_wiz_customers_settings', array( $this,'wiz_customers_settings_callback'));
	}
	
	public function admin_init() {        
		global $wizshop_cat_taxonomies;
		global $wp_query;
		
		wp_register_script('wiz-cat-import-js',wizshopPluginUrl . '/js/admin/cat_meta.js', array('jquery'), wizshopPluginVersion, true);
		
		if(!isset($_GET['tag_ID'])){
			$cur_tax = isset($_GET['taxonomy'])? wizshop_is_cat_tax($_GET['taxonomy']) : false;
			if($cur_tax && ($cat_options = wizshop_get_option($cur_tax['settings']['name']))){
				$term = get_taxonomy($_GET['taxonomy']);
				if(isset($term)){
					$term->labels->name = translate($term->labels->name, WizShop);
				}
				$menu_opt = wizshop_admin_get_tax_menus($cur_tax['name']);
				if(!$menu_opt && isset($cat_options['v_menu_id'])){
					$menu_opt = array(array('v_menu_id' => $cat_options['v_menu_id'], 
													'v_item_id' => $cat_options['v_item_id'], 
													'v_menu_depth' => $cat_options['v_menu_depth']))	;				
					unset($cat_options['v_menu_id']);
					unset($cat_options['v_item_id']);
					unset($cat_options['v_menu_depth']);
					update_option($cur_tax['settings']['name'],$cat_options);
					wizshop_admin_set_tax_menus($cur_tax['name'],$menu_opt);
				}
				if(!$menu_opt){
					$menu_opt = array(array('v_menu_id' => -1, 'v_item_id' => -1,'v_menu_depth' => 2));				
				}
				
				if(isset($cat_options['v_shop_item']) && 1 == $cat_options['v_shop_item']){
					if(WizShop_Menus::checkShopMenuItem($cat_options, $menu_opt[0])){
						update_option($cur_tax['settings']['name'],$cat_options);
						wizshop_admin_set_tax_menus($cur_tax['name'],$menu_opt);
					}
				}
				wp_register_script('wiz-menus-js',wizshopPluginUrl . '/js/admin/menus.js', array('jquery'), wizshopPluginVersion, true);
				wp_localize_script('wiz-menus-js', '_wiz_menus', 
						array( 'menus' => WizShop_Menus::getSysMenus(),
								'no_menu' => array('id'=> -1, 'name' =>__('Select Menu', WizShop)),
								'no_item' => array('id'=> -1, 'name' => __('Select Item', WizShop)),
								'depth_all' => array('id'=> -1, 'name' => __('All', WizShop)),
								'max_list' => 5,
								'type' => $cur_tax['name'],
								'io' => $menu_opt,
								'upd_alert' =>__('Please note, Updating the menu may delete categories from this menu. On sites where Mega-Menu is integrated, this update may reset the design. Update menu?', WizShop),
								'del_alert' => __('Delete item ?', WizShop)
						)
					);
				wp_enqueue_script('wiz-menus-js');
			}
		}
		wp_enqueue_script('wiz-cat-import-js');
	}	

	function action_edit_category_term($tag){
		global $wizshop_cat_taxonomies;
		$this->edit_category_term($wizshop_cat_taxonomies[wizshop_lang_he]['name'] ,$tag);
	}
	function action_edit_category_en_term($tag){
		global $wizshop_cat_taxonomies;
		$this->edit_category_term($wizshop_cat_taxonomies[wizshop_lang_en]['name'] ,$tag);
	}
	
	function edit_category_term($taxonomy, $tag){
		global $wizshop_cat_view;
		$cat_obj = WizShop_Categories::get_cat_info($taxonomy,$tag->term_id);
		if(!$cat_obj)
			return;
		$img_att = wp_get_attachment_image_src( (isset($cat_obj->img) && $cat_obj->img > 0) ? $cat_obj->img : '','thumbnail',false);
		if(!property_exists($cat_obj,'view_options')) $cat_obj->view_options = -1;
		?>
		<tr class="form-field">
		<th scope="row"><?php echo __('Products display', WizShop)?></th>
		<td>
			<label for="view-type-def">
			<input type="checkbox" id="view-type-def" name="view-type-def" value="1" 
			   <?php echo ($cat_obj->view_options == -1)? ' checked>' :'>' ?>
			   <?php echo  __('Default', WizShop);?>	
			</label>
			<p class="description"><?php echo __('Or select from options below:', WizShop);?></p>
			<?php foreach ($wizshop_cat_view as $key => $val){ ?>
				<div>
				<label for="<?php echo esc_attr($key . $val['value']) ?>">
				<input type="checkbox" name="view-type[]" id="<?php echo esc_attr($key . $val['value'])?>" value="<?php echo esc_attr($val['value'])?>" 
				   <?php echo ($cat_obj->view_options != -1 && ($cat_obj->view_options & $val['value']))? ' checked>' :'>' ?>
				   <?php echo esc_html(translate($val['label'], WizShop));?>	
				</label>
				</div>
			<?php } ?>
		</td>
		</tr>
		<tr class="form-field">
		<th scope="row"><label for="image-id"><?php _e('Image')?></label></th>
		<td>
			<input data-image-file 
				value="<?php echo isset($img_att[0]) ? esc_attr(get_the_title($cat_obj->img)) : _e('No image set'); ?>"		
				def-val = "<?php  _e('No image set')?>"  type="text" readonly />
			<img data-image-src  src="<?php echo isset($img_att[0]) ? esc_attr($img_att[0]) : '' ; ?>" width="150" height="150">
			<input data-image-id name="image-id" type="hidden" value="<?php echo isset($cat_obj->img) ? esc_attr($cat_obj->img) : ''; ?>">
			<div>
			<button data-upload-btn data-upload-title="<?php echo esc_attr($cat_obj->cat)?>" id="upload-btn" class="button">
				<i class="fa fa-upload"></i><?php echo __('Choose Image', WizShop)?>
			</button>
			<button data-remove-btn id="remove-btn" class="button">
				<i class="fa fa-times"></i><?php echo __('Remove Image', WizShop)?>
			</button>
			</div>
		</td>
		</tr>
		<?php
	}	

	function action_post_category_update($term_id){
		global $wizshop_cat_taxonomies;
		$this->post_category_update($wizshop_cat_taxonomies[wizshop_lang_he]['name'] ,$term_id);
	}
	
	function action_post_category_en_update($term_id){
		global $wizshop_cat_taxonomies;
		$this->post_category_update($wizshop_cat_taxonomies[wizshop_lang_en]['name'] ,$term_id);
	}
		
	function post_category_update($taxonomy, $term_id){
		$cat_obj = WizShop_Categories::get_cat_info($taxonomy,$term_id);
		if(!$cat_obj)
			return;
		if(isset($_POST['view-type-def']) && intval($_POST['view-type-def'])==1){
			$cat_obj->view_options = -1;
		}
		else if(isset($_POST['view-type'])){
			$val = 0; 
			foreach ($_POST['view-type'] as $v) $val += intval($v);
			$cat_obj->view_options = $val;
		}
		if ( isset($_POST['image-id']) && "" != $_POST['image-id']) {
			$new_id = intval($_POST['image-id']);
			$cat_obj->img = $new_id;
			$update_shop_img = true;
		}else{
			$cat_obj->img = 0;
			$update_shop_img = true;
		}
		
		global  $wizshop_settings;
		$shop_options = wizshop_get_option($wizshop_settings['name']);
		$msg = "";
		$path_arr = explode('@@',$cat_obj->cat_path);
		
		if(!WizShop_Api::update_cat_img(end($path_arr) /*$cat_obj->id*/, $cat_obj->img, $shop_options,$msg)){
			WizShop_Settings::add_admin_notice($msg, "notice is-dismissible notice-error");
		}
	
		WizShop_Categories::update_term_meta($term_id,$taxonomy,$cat_obj);
	}

	function action_add_import_fields(){
		global $wizshop_cat_taxonomies;
		$this->add_import_fields( $wizshop_cat_taxonomies[wizshop_lang_he]['settings']['name']);
	}
	
	function action_add_import_fields_en(){
		global $wizshop_cat_taxonomies;
		$this->add_import_fields( $wizshop_cat_taxonomies[wizshop_lang_en]['settings']['name']);
	}
	
	function add_import_fields($cat_options_name){
		global $wizshop_settings;
		global $wizshop_cat_view;
		$options = wizshop_get_option($wizshop_settings['name']);
		$cat_options = wizshop_get_option($cat_options_name);
		
		if(!isset($cat_options['view_options'])) $cat_options['view_options']= 0;
		if(!isset($cat_options['v_img_upd'])) $cat_options['v_img_upd']= 1;

		$page_inf = wizshop_get_page_info(wizshopShopPageKey);
		?>
		<div id="overlay"></div>
		<script id="v_menu_html" type="text/html"">
			<tbody  data-wiz-menu-item="{{index}}">
				<tr>
					<td><span class='readonly' style='width: 80px;' >{{menu_text}}</span></td>
					<td><span class='readonly'>{{item_text}}</span></td>
					<td><span class='readonly' style='width: 50px;'>{{depth_text}}</span></td>
				</tr>
				<tr>
					<td colspan="3">
					<a href="javascript:void(0);" class="button" data-wiz-update-menu-item="{{index}}"><?php echo __("Assign categories", WizShop)?></a>
					<a href="javascript:void(0);" class="button" data-wiz-edit-menu-item="{{index}}"><?php _e("Edit")?></a>
					<a href="javascript:void(0);" class="button" data-wiz-del-menu-item="{{index}}"><?php _e("Delete")?></a>
					</td>
				</tr>
			</tbody>
		</script>		
		<input type="hidden" id="shop_id"  value="<?php echo esc_attr($options['shop_id']) ?>"/>
		<input type="hidden" id="cat_opt"  value="<?php echo esc_attr($cat_options_name) ?>"/>
		<div class="form-wrap">
			<h3><?php echo __("Import Categories", WizShop)?></h3>
			<div class="form-field">
				<?php echo __("Import Categories from Shop server(without updating the menus):", WizShop)?>
			</div>
			<div class="form-field">
				<label for="v_img_upd">
				<input type="checkbox" id="v_img_upd" value="1" <?php echo ($cat_options['v_img_upd'] == 1)? ' checked>' :'>' ?>
			   <?php printf( __("Update image names on WizShop back office", WizShop));?>
				</label>
			</div>
			<div class="form-field">
				<label for="v_del_cats">
				<input type="checkbox" id="v_del_cats" value="1">
			   <?php printf( __("Delete current categories. <b>Warning!</b> All categories data wil be deleted", WizShop));?>
				</label>
			</div>
            <div class="form-field">
				<label for="last_update"><?php echo __("Last updated date", WizShop)?></label>
				<input type="text" id="last_update"  value="<?php echo esc_attr($cat_options['last_update']) ?>" readonly />
			</div>
			<button class="button button-primary" onclick="ajaxImportCategories('wiz_get_cats');">
				<i class="fa fa-save"></i><?php echo __('Update Categories', WizShop) ?>
			</button>
		</div>
		<div class="form-wrap">
			<h3><?php echo __("Assign categories to menus", WizShop)?></h3>
			<div class="form-field">
				<table border="0" cellspacing="2" cellpadding="0" id="v_menu_list">
				<thead>
              	<tr>
                  <th width="90"><?php echo __("Menu Name", WizShop)?></th>
                  <th width="150"><?php echo __("Parent item", WizShop)?></th>
                  <th width="70"><?php echo __("Menu Levels", WizShop)?></th>
				  <th width="100"></th>
				  <th width="50"></th>
				  <th width="50"></th>
                </tr>
				</thead>
				
					<?php WizShop_Menus::menuSelection("depth=true") ?> 
				
				</table>
				<a href="javascript:void(0);" data-wiz-add-menu class="button button-primary"><?php echo __("Add menu", WizShop)?></a>
			</div>
		</div>
		<div class="form-wrap">
			<h3><?php echo __("Products display", WizShop)?></h3>
			<?php foreach ($wizshop_cat_view as $key => $val){ ?>
				<div class="form-field">
				<label for="<?php echo esc_attr($key . $val['value']) ?>">
				<input type="checkbox" name="view-type[]" id="<?php echo esc_attr($key . $val['value'])?>" value="<?php echo esc_attr($val['value']) ?>" 
				   <?php echo ($cat_options['view_options'] == 0 || ($cat_options['view_options'] & $val['value']))? ' checked>' :'>' ?>
				   <?php echo esc_html(translate($val['label'], WizShop));?>	
				</label>
				</div>
			<?php } ?>
			<button class="button button-primary" onclick="ajaxUpdateViewOptions('wiz_view_options');">
				<i class="fa fa-save"></i><?php echo __('Update Display Options', WizShop) ?>
			</button>
		</div>
		<?php
	}
	
	function wiz_get_cats_callback() {
	
		register_shutdown_function(array( $this, 'get_cats_shut' ));
		
		$shop_id = wizshop_validate_uc($_POST['shop_id'] );
		$cat_opt = sanitize_text_field($_POST['cat_opt'] );
		$v_del_cats = intval($_POST['v_del_cats'] );
		$v_img_upd = intval($_POST['v_img_upd'] );
		
		if(!$shop_id){
			$this->finalize_ajax_callback(false, __('Please <a href="/wp-admin/edit.php?post_type=wizshop&page=wizshop_settings">provide your Shop ID</a> to connect to the WizShop database.', WizShop));
		}
		$cat_options = wizshop_get_option($cat_opt);
		if(!$cat_options){
			$this->finalize_ajax_callback(false, __('Invalid Categories option name.', WizShop));
		}
		
		remove_action( 'edited_' . $cat_options['taxonomy'] , array( $this, 'action_post_category_update' ), 10);
		
		$cat_options['v_img_upd'] = $v_img_upd;
		
		if((1 == $v_del_cats) || $shop_id != $cat_options['cat_shop_id']){
			WizShop_Categories::clearTaxonomyTerms($cat_options['taxonomy']);
		}
		
		$cat_msg = '';
		if(WizShop_Categories::setTaxonomyTerms($cat_options, $cat_msg)){
			$cat_options['last_update'] = current_time('mysql');
			$cat_options['cat_shop_id'] = $shop_id;
			update_option($cat_opt, $cat_options);
			$this->finalize_ajax_callback(true, __("Categories updated.", WizShop));
		}else{
			$this->finalize_ajax_callback(false,$cat_msg);		
		}
	}	
	
	function wiz_set_image_sizes_callback() {
		global $wizshop_view_settings;
		if(isset($_POST['item_gallery'])){
			$view_op = wizshop_get_view_options();
			$view_op['item_gallery']= intval($_POST['item_gallery']);
			update_option($wizshop_view_settings['name'],$view_op);			
		}
		$this->finalize_ajax_callback(false !== wizshop_set_images_size(), "");
	}
	
	function wiz_set_def_img_callback() {
		global $wizshop_image_settings;
		$op = wizshop_get_option($wizshop_image_settings['name']);
		$id = $_POST['img_id']; 
		if(isset($id)){
			$op["def_img_id"] = intval($id);
		}
		$reload = update_option($wizshop_image_settings['name'],$op);
		if($reload){
			$this->finalize_ajax_callback(true, "", true);
		}else{
			echo json_encode(array('success' => true, 'msg' => "OK"));
			die();
		}
	}
	
	function sanitize_menu_option(&$mn) {
		if(isset($mn['v_menu_id'])) 	$mn['v_menu_id'] = intval($mn['v_menu_id']);
		if(isset($mn['v_item_id'])) 	$mn['v_item_id'] = intval($mn['v_item_id']);
		if(isset($mn['v_menu_depth'])) 	$mn['v_menu_depth'] = intval($mn['v_menu_depth']);
		if(isset($mn['v_menu_meta'])) 	$mn['v_menu_meta'] = stripslashes(sanitize_text_field($mn['v_menu_meta']));
	}
	
	function sanitize_menu_options(&$io) {
		foreach ($io as $key => &$mn ){
			$this->sanitize_menu_option($mn);
		}				
	}

	function wiz_set_menus_callback() {
		$done = false;
		global  $wizshop_menu_settings;
		$opt = wizshop_get_option($wizshop_menu_settings['name']);
		$type = $_POST['type'];
		if(isset($type)){
			$io = isset( $_POST['menus']) ?  $_POST['menus'] : array();
			if(wizshopShortcodeMenu == $type || wizshop_is_cat_tax($type)){
				$this->sanitize_menu_options($io);
				$opt[ $type] = $io;
				update_option($wizshop_menu_settings['name'],$opt);
			}
			if(wizshop_is_cat_tax($type)){
				$cat_opt = sanitize_text_field($_POST['cat_opt'] );
				$cat_options = wizshop_get_option($cat_opt);
				$shop_id = wizshop_validate_uc($_POST['shop_id'] );
				if(!$shop_id){
					$this->finalize_ajax_callback(false, __('Please <a href="/wp-admin/edit.php?post_type=wizshop&page=wizshop_settings">provide your Shop ID</a> to connect to the WizShop database.', WizShop));
					$done = true;
				}else if(!$cat_options){
					$this->finalize_ajax_callback(false, __('Invalid Categories option name.', WizShop));
					$done = true;
				}else if(isset($_POST['delete_1'])){
					$del1 = $_POST['delete_1'];
					$this->sanitize_menu_option($del1);
					WizShop_Menus::removeOneTaxMenu($cat_options['taxonomy'],$del1);
					$this->finalize_ajax_callback(true, __("Menu updated.", WizShop));
					$done = true;
				}else if(isset($_POST['update_1'])){
					$menu_msg = '';
					$upd1 = $_POST['update_1'];
					$this->sanitize_menu_option($upd1);
					if(WizShop_Menus::setOneTaxMenu($upd1, $cat_options['taxonomy'],$menu_msg)){
						$this->finalize_ajax_callback(true, __("Menu updated.", WizShop));
					}else{
						$this->finalize_ajax_callback(false,$menu_msg);
					}
					$done = true;
				}
			}
		}
		if(!$done){
			echo json_encode(array('success' => true));
			die();
		}
	}
	
	function wiz_set_page_callback() {
		global $wizshop_pages;
		$done = true;
		$reload = false;
		$key = sanitize_text_field($_POST['key'] );
		$lang = sanitize_text_field($_POST['lang'] );
		$id = intval($_POST['id'] );
		$def_id = intval($_POST['def_id'] );
		$msg = "OK";
		
		if(!array_key_exists($key,$wizshop_pages)){
			$msg = "Invalid page key: " . $key;
			$done = false;
		}else if(!wizshop_is_shop_lang($lang)){
			$msg = "Invalid language: " . $lang;
			$done = false;
		}else{
			if(-1 == $id){
				//no page
				update_option(WizShop_Pages::user_page_option_key($key, $lang),-1);
			}else if(-2 == $id){
				//default
				if(-1 == $def_id){
					//not exist
					WizShop_Pages::create_page($key, $wizshop_pages[$key]);
					$reload = true;
				}
				//set default
				update_option(WizShop_Pages::user_page_option_key($key, $lang),WizShop_Pages::get_page_option($key, $lang));
			}else if($id > 0){				
				$content = $wizshop_pages[$key]['use_shortcode'] ? '[wizshop-element name=\'' . $key . '\' lang=\'' .$lang. '\']' : false;
				if($content){
					$post = array(
						'ID' => $id,
						'post_content' => $content,
						);
					$done = 0 != wp_update_post($post);	
				}
				update_option(WizShop_Pages::user_page_option_key($key, $lang),$id);			
	
			}else{
				$done = false;
			}
		}
		echo json_encode(array('success' => $done, 'reload' => $reload, 'msg' => $msg));
		die();
	}

	function wiz_products_view_settings_callback(){
		global  $wizshop_view_settings;
		$op = wizshop_get_option($wizshop_view_settings['name']);
		
		if(isset($_POST['products_view'])){
			$disp_type = $_POST['products_view'];
			$op['products_view']['last'] = $disp_type ;
			foreach ($op['products_view'][$disp_type] as $key => $val){
				if(isset($_POST[$key])){
					$op['products_view'][$disp_type][$key] = intval($_POST[$key]);
				}
			}
		}else{
			foreach ($op as $key => $val){
				if(isset($_POST[$key])){
					$op[$key] = intval($_POST[$key]);
				}
			}
		}
		$reload = update_option($wizshop_view_settings['name'],$op);
		if($reload){
			$this->finalize_ajax_callback(true, "", true);
		}else{
			echo json_encode(array('success' => true, 'msg' => "OK"));
			die();
		}
	}
	
	function wiz_customers_settings_callback(){
		global  $wizshop_customers;
		$lang 	= sanitize_text_field($_POST['lang']);
		$op = wizshop_get_customer_options($lang);
		if(1 == intval($_POST['default'])){
			$op = $wizshop_customers[$lang]['settings']['defaults'];
		}else{
			foreach ($op as $key => $val){
				if(isset($_POST[$key])){
					$op[$key] = sanitize_text_field($_POST[$key]);
				}
			}			
		}
		$changed = update_option($wizshop_customers[$lang]['settings']['name'],$op);
		WizShop_Settings::add_admin_notice($changed ? translate('Saved.') :  __("Unchanged.", WizShop) , "notice is-dismissible notice-success");
		echo json_encode(array('success' => true));
		die();
	}

	function wiz_view_options_callback() {
		$cat_opt = sanitize_text_field($_POST['cat_opt'] );
		$cat_options = wizshop_get_option($cat_opt);
		if(!$cat_options){
			$this->finalize_ajax_callback(false, __('Invalid Categories option name.', WizShop));
		}		
		if(isset($cat_options['view_options']) 
			&& $cat_options['view_options'] == intval($_POST['view_options'] )){
			$this->finalize_ajax_callback(true, __("Unchanged.", WizShop) );
		}else{
			$cat_options['view_options'] = intval($_POST['view_options']);
			$this->finalize_ajax_callback(update_option($cat_opt, $cat_options), "");
		}
	}
	
	function finalize_ajax_callback($success, $text, $reload = false) {
		$msg = ($success) ? ($text ? $text : translate('Saved.') ) : 
					($text ? $text : __('Error while saving the changes.', WizShop));
		WizShop_Settings::add_admin_notice($msg, "notice is-dismissible ". ($success ? 'notice-success' : 'notice-error'));
		echo json_encode(array('success' => $success, 'reload' =>$reload ));
		die();
	}
	

	function get_cats_shut() {
		$error = error_get_last();
		if($error && ($error['type'] & E_ERROR)){
			$this->finalize_ajax_callback(false,__($error['message']));
		}	
	}	

}; 
 new WizShop_Cat_Meta();
?>