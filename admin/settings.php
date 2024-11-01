<?php
if ( ! defined( 'ABSPATH' ) ) {exit; }
/*-------------------------*/ 
/* class  WizShop_Settings */
/*-------------------------*/ 
class WizShop_Settings{

    var $options_name;
	var $options;
	var $version;
	
	public function __construct(){
		
		$this->version = wizshop_get_version();

		global $wizshop_settings;
		$this->options_name = $wizshop_settings['name'];
		$this->options = wizshop_get_option($this->options_name);
		
	
		if((wizshopPluginVersion > $this->version) && ($this->version > 0)){
			$s_page = 'edit.php?post_type='. wizshopShopPostType. '&page=' .$wizshop_settings['name'] . '#wiz-settings-submit' ;
			self::add_admin_notice(str_replace('#',$s_page,__('<a href="#">Update</a> WizShop plugin version data.', WizShop)), "notice  is-dismissible notice-warning");
		}
				
		add_action( is_multisite() ? 'network_admin_menu' : 'admin_menu', array( $this, 'admin_menu' ) );
        add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'admin_notices', array( $this, 'admin_notices' ) );
		add_action('init', array( $this, 'init' ), 11 );
		add_filter('posts_where', array( $this, 'media_filter' ), 10, 2 );
	}
	
	function init(){
		add_action('update_option_'.$this->options_name , array( $this,'after_settings_update'), 10, 2 );
		add_filter('pre_update_option_'. $this->options_name , array( $this,'before_settings_update'), 10, 2 );
		add_filter('wp_handle_upload_prefilter', array( 'WizShop_Settings','pre_upload'), 2);
		add_filter('wp_handle_upload', array( 'WizShop_Settings','post_upload'), 2);		
		
		foreach ( get_post_types(array('public'   => true,'_builtin' => false),'objects') as $post_type ) {
			if(wizshopShopPostType == $post_type->name){
				$post_type->labels->menu_name = translate($post_type->labels->menu_name, WizShop);
				break;
			}
		}	
	}
	
	function admin_menu() {
		global $wizshop_media_settings;
		global $wizshop_cat_taxonomies;
		add_submenu_page('edit.php?post_type='. wizshopShopPostType,__('Settings', WizShop),__('Settings', WizShop),'manage_options', $this->options_name, array( $this, 'create_admin_page' ));
		$page = add_submenu_page('edit.php?post_type='. wizshopShopPostType,__('Media', WizShop),__('Media', WizShop),'upload_files', $wizshop_media_settings['name'], array( $this, 'create_media_page' ));
		foreach ($wizshop_cat_taxonomies as $key => $tax) {
			if(taxonomy_exists($tax['name']) && wizshop_is_shop_lang($key)) {
				add_submenu_page('edit.php?post_type='. wizshopShopPostType, translate($tax['ui_name'], WizShop) ,translate($tax['ui_menu_name'], WizShop),'manage_categories','edit-tags.php?taxonomy=' . $tax['name'] .'&post_type='. wizshopShopPostType);
			}		
		}
	}
	
	public function admin_init() {    
		global $wizshop_disp_type;
		
		foreach ($wizshop_disp_type as $key => &$val){
			$val['ui_name'] = translate($val['ui_name'], WizShop);
		}
	
		wp_parse_str($_SERVER['QUERY_STRING'], $args);
		if(isset($args['wiz_s_refresh'])){
			self::check_shop_definitions($this->options);
		}
		
		$lang = wizshop_cur_lang();
		$admin_style = wizshop_lang_path(trailingslashit(wizshopPluginPath) . 'css', 'admin-style.css', $lang );  
		wp_register_style('wiz-admin-styles',trailingslashit(wizshopPluginUrl) . 'css/' . 
				(($lang) ? trailingslashit($lang) : "") . 'admin-style.css', null, wizshopPluginVersion);
		
		wp_register_script('wiz-image-settings', wizshopPluginUrl . 'js/admin/media.js', array('jquery'),  wizshopPluginVersion, true);
		wp_register_script('wiz-tabs-settings', wizshopPluginUrl . 'js/admin/tabs.js', array('jquery'),  wizshopPluginVersion, true);
		wp_localize_script('wiz-tabs-settings', '_wiz_tabs', 
			array( 
			'products_save' => __('Save Products Settings?',WizShop),
			'disp_options' => $wizshop_disp_type,
			)
		);
		$this->init_scripts();
		$this->init_styles();
		if ( current_user_can( 'manage_options' ) )  {		
			register_setting($this->options_name,$this->options_name, array( $this, 'sanitize'));

			add_settings_section('wizshop_section_shop',__('Link to WizShop', WizShop),'__return_false',__FILE__);  
			add_settings_field('shop_id',__('Shop ID', WizShop),array( $this, 'shop_id_callback' ),__FILE__,'wizshop_section_shop');
			add_settings_field('shop_pass',__('Password', WizShop),array( $this, 'shop_pass_callback' ),__FILE__,'wizshop_section_shop');
			
			add_settings_section('wizshop_section_lang',__('Shop languages', WizShop),'__return_false',__FILE__);  
			add_settings_field('shop_lang',__('Shop main language', WizShop),array( $this, 'shop_lang_callback' ),__FILE__,'wizshop_section_lang');
			add_settings_field('shop_lang2',__('Second language', WizShop),array( $this, 'shop_lang2_callback' ),__FILE__,'wizshop_section_lang');

			$css_field_title = sprintf('<input type="checkbox" id="default_css" name="%s" value="0" %s/><label for="default_css">%s<label>',	
						$this->options_name . "[default_css]",
							isset( $this->options['default_css'] ) && 0 == $this->options['default_css'] ? 'checked' : '',
							__('Ignore new design', WizShop)
				); 
			add_settings_section('wizshop_section_upgrade',__('Version Update', WizShop),'__return_false',__FILE__);  
			add_settings_field('default_css', $css_field_title, array( $this, 'shop_default_css_callback' ),__FILE__,'wizshop_section_upgrade');
		}
	}	
	
	public function create_admin_page() {
 		?>
		<div class="wrap">
		<div class="tabs">
			<ul class="tab-links">
				<li><a href="#store-tab"><?php echo _e('General') ?></a></li>
				<li><a href="#products-tab"><?php echo __('Products', WizShop) ?></a></li>
				<li><a href="#pages-tab"><?php echo __('Shop pages', WizShop) ?></a></li>
				<?php if(!defined('wizshopComponentsMenu')): ?>
					<li><a href="#menus-tab"><?php echo __('Shop Elements', WizShop) ?></a></li>
				<?php endif; ?>
				<li><a href="#customers-tab"><?php echo __('Shop Customers', WizShop) ?></a></li>
				<li><a href="#other-tab"><?php echo __('Other Settings', WizShop) ?></a></li>
			</ul>
			<h2></h2> <!-- Admin notice pos marker. Do not remove -->
			<div class="tab-content" >
			<div id="store-tab" class="tab active">
				<h1><?php echo __('Shop Settings', WizShop) ?></h1>
				<div class="wrap">
					<form method="post" action="options.php">
					<?php
						settings_fields($this->options_name);   
						do_settings_sections( __FILE__ );
						echo '<p class="submit"><input type="submit" name="submit" id="wiz-settings-submit" class="button button-primary" value="'; 
						_e("Save") ;
						echo '" /></p>';
						printf('<h1>%s</h1><ul>',__('General Information', WizShop));	
						printf('<li class="wrap"><b>%s:</b> %s</li>',__('Plugin version', WizShop), wizshopPluginVersion);	
						printf('<li class="wrap"><b>%s:</b> %s</li>',__('Shop manages Shipping', WizShop),(((1==$this->options['shipping']) ? __('Yes', WizShop) :__('No', WizShop))));
						printf('<li class="wrap"><b>%s:</b> %s</li>',__('Shop supports guest checkout', WizShop),(((1==$this->options['guests']) ? __('Yes', WizShop) :__('No', WizShop))));
						printf('<li class="wrap"><b>%s:</b> %s<br/>%s</li>',__('Product Search Engine', WizShop),
							((1==$this->options['wiz_search']) ? __('WizSoft Search', WizShop) : __('Default Search', WizShop)),
							__("Learn <a href='https://wizshop.co.il/%d7%97%d7%99%d7%a4%d7%95%d7%a9-%d7%9e%d7%95%d7%a6%d7%a8%d7%99%d7%9d-%d7%91%d7%97%d7%a0%d7%95%d7%aa/' target='_blank'>more</a> about Product Search", WizShop)
						);
						printf('<li class="wrap"><b>%s:</b> %s</li>',__('Shop address (WizShop use)', WizShop), isset( $this->options['shop_server'] ) ? strtolower (esc_attr( $this->options['shop_server'])) : '');	
						echo "</ul>";
						printf("<a onclick='(-1 == window.location.href.indexOf(\"wiz_s_refresh\")) ? window.location.assign(window.location.href += \"&wiz_s_refresh\") : window.location.reload(true);' 
									class='dashicons-before dashicons-update'>%s</a>",__('Refresh General Information', WizShop));	
					?>
					</form>
			</div>
			</div>
			<?php require_once("tabs.php"); ?>	
			</div>
		</div>
		</div>
        <?php
    }

	public function create_media_page() {
 		?>
        <div class="wrap">
			<?php require_once("media-lib.php"); ?>
        </div>
        <?php
    }	
	
	public function admin_notices() {  
		$notices = get_option(wizshopNotices);		
		if($notices && is_array($notices)){
			foreach ($notices as $notice) {
			 ?>
				<div class="<?php echo esc_attr($notice['cls']) ?>">
					<p><?php echo $notice['message'] ?></p>
				</div>
			<?php	
			}
			update_option(wizshopNotices, '');
		}
	}
	
	static public function add_admin_notice($message, $class){
		$notices = get_option(wizshopNotices);
		if(!$notices ||!is_array($notices)){
			$notices = array();
		}
		foreach ($notices as $note ) {
			if($note["message"] == $message){
				return;
			}
		}	
		$notices[] =  array('message' => $message, 'cls' => sanitize_text_field($class));
		update_option(wizshopNotices,$notices);
	}
	
	function before_settings_update($new_value, $old_value){
		update_option(wizshopNotices, '');
		$success = true;
	
		$new_value['shop_id'] = wizshop_validate_uc($new_value['shop_id']);
		if(!$new_value['shop_id']){
			$success = false;
			$new_value['shop_server'] = '';
			self::add_admin_notice( __('Please <a href="/wp-admin/edit.php?post_type=wizshop&page=wizshop_settings">provide your Shop ID</a> to connect to the WizShop database.', WizShop) , "notice is-dismissible notice-error");
		}else if(!$new_value['shop_pass']){
			$success = false;
			$new_value['shop_server'] = '';
			self::add_admin_notice( __('Shop password was not provided.', WizShop) , "notice is-dismissible notice-error");
		}else{
			//force shop server test
			$_msg = '';
			$new_value['shop_server'] = '';
			$success = WizShop_Api::checkServer($new_value, $_msg);
			if(!$success && ($new_value['shop_id'] == $old_value['shop_id']) && $old_value['shop_server']){
				$new_value['shop_server'] = $old_value['shop_server'];
			}
			self::add_admin_notice($_msg , "notice is-dismissible ". ($success ? 'notice-success' : 'notice-error'));
		}
		if(!wizshop_is_supported_lang($new_value['shop_lang'])){
			$success = false;
		}

		if('-1' != $new_value['shop_lang2'] &&  !wizshop_is_supported_lang($new_value['shop_lang2'])){
			$new_value['shop_lang2']= '-1';
		}
		
		if($new_value['shop_lang2'] == $new_value['shop_lang']){
			$new_value['shop_lang2']= '-1';
		}
	
		if(!array_key_exists('default_css',$new_value)){
			$new_value['default_css']= 1 ;
		}

		if($success){
			wizshop_set_shop_langs($new_value);
			WizShop_Pages::create_pages();
			WizShop_Pages::set_user_pages($this->version);
			if(wizshopPluginVersion !=  $this->version){
				self::update_version();
			}
		}
	
		return $new_value;
	}	
	
	function after_settings_update($old_value, $new_value){
		wizshop_set_shop_langs();
		self::check_shop_definitions($new_value);
	}	
		
	function init_scripts() {
		wp_enqueue_script('wiz-cat-import-js');
		wp_enqueue_script('wiz-image-settings');
		wp_enqueue_script('wiz-tabs-settings');
	}

	function init_styles() {
		wp_enqueue_style('wiz-admin-styles');
	}	

	function update_version() {
		global $wizshop_plugin_settings;
		$plug_o = wizshop_get_option($wizshop_plugin_settings['name']);
		$plug_o["version"] = (float)wizshopPluginVersion;
		update_option($wizshop_plugin_settings['name'],$plug_o);
	}
	
	static public function get_current_URL() {
		$current_url  = 'http';
		$server_https = $_SERVER["HTTPS"];
		$server_name  = $_SERVER["SERVER_NAME"];
		$server_port  = $_SERVER["SERVER_PORT"];
		$request_uri  = $_SERVER["REQUEST_URI"]; 
		if ($server_https == "on") $current_url .= "s";
		 $current_url .= "://";
		if ($server_port != "80") $current_url .= $server_name . ":" . $server_port . $request_uri;
		else $current_url .= $server_name . $request_uri;
		return $current_url;
	}
	
    public function sanitize( $input ) {
        $new_input = array();
		if( isset( $input['shop_server'] ) )
            $new_input['shop_server'] = sanitize_text_field( $input['shop_server'] );
		if( isset( $input['shop_id'] ) )
            $new_input['shop_id'] = sanitize_text_field( $input['shop_id'] );
		if( isset( $input['shop_pass'] ) )
            $new_input['shop_pass'] = sanitize_text_field( $input['shop_pass'] );
 		if( isset( $input['shop_lang'] ) )
            $new_input['shop_lang'] = sanitize_text_field( $input['shop_lang'] );
		if( isset( $input['shop_lang2'] ) )
            $new_input['shop_lang2'] = sanitize_text_field( $input['shop_lang2'] );
		if( isset( $input['default_css'] ) )
            $new_input['default_css'] =  $input['default_css'];
		return $new_input;
    }
    	
    public function shop_id_callback()  {
        printf(
            '<input type="text" dir="ltr" id="shop_id" name="%s"  value="%s" maxlength="%s"/>
			<span class="help dashicons-before dashicons-info">%s</span>',
			$this->options_name . "[shop_id]",
            isset( $this->options['shop_id'] ) ? esc_attr( $this->options['shop_id']) : '',
			30,
			__('Store ID as specified in WizShop back office', WizShop)
        );
    }

    public function shop_pass_callback()  {
        printf(
            '<input type="password" dir="ltr" id="shop_pass" name="%s"  value="%s" maxlength="%s"/>
			<span class="help dashicons-before dashicons-info">%s</span>',
			$this->options_name . "[shop_pass]",
            isset( $this->options['shop_pass'] ) ? esc_attr( $this->options['shop_pass']) : '',
			50,
			__('Wordpress password as specified in WizShop back office', WizShop)
        );
    }

	 public function shop_lang_callback()  {
		$val = isset( $this->options['shop_lang'] ) ? esc_attr( $this->options['shop_lang']) : '';
		$this->lang_select('shop_lang',$val);
	}
	 public function shop_lang2_callback()  {
		$val = isset( $this->options['shop_lang2'] ) ? esc_attr( $this->options['shop_lang2']) : '';
		$this->lang_select('shop_lang2',$val, true);
	}
	
	function lang_select($id, $val, $noLang=false){
		global $wizshop_support_lang;
		echo '<select id="'. $id. '" name="' . esc_attr($this->options_name) . '[' . esc_attr($id) . ']">';
		if($noLang){
			echo '<option value="-1" ';
			if ($val == '-1' ){
				echo 'selected="selected"';
			}
			echo '>' . __('Select Language', WizShop). '</option>';
		}
		foreach ($wizshop_support_lang as $lang => $ui ) {
			echo '<option value="'. $lang. '"';
			if ($val == $lang ){
				echo 'selected="selected"';
			}
			echo '>' . translate($ui['label'], WizShop) . '</option>';
		}	
		echo '</select>';
	}
	
	 public function shop_default_css_callback()  {
        printf('<span class="help dashicons-before dashicons-info">%s</span>',
			 __('Select this option if shop was built before version 2.00 and you wish to keep current design', WizShop)
	        );
    }
				
	static public function pre_upload($file){
		global $wizshop_upload_path;
		add_filter('upload_dir', array( 'WizShop_Settings','custom_upload_dir'));

		$upload = wp_upload_dir();
		if($wizshop_upload_path["dir"] == $upload['path']){
			wizshop_delete_image_by_name(sanitize_file_name($file['name']), true);
		}

		return $file;
	}
	
	static public function post_upload($fileinfo){
		remove_filter('upload_dir', array( 'WizShop_Settings' ,'custom_upload_dir'));		
		return $fileinfo;
	}
	
	static public function custom_upload_dir($path) {
		if(isset( $_SERVER['HTTP_REFERER'] )) {
			$referrer = parse_url($_SERVER['HTTP_REFERER']);
			$queries;
			if( isset($referrer['query'])){
				parse_str($referrer['query'], $queries);
				if( isset($queries['post_type']) && $queries['post_type'] == wizshopShopPostType ) {
					$mydir = '/wizshop';
					$path['subdir']  = $mydir;
					$path['path']   = $path['basedir'].$mydir; 
					$path['url']    = $path['baseurl'].$mydir;  
				}
			}
		}
		return $path; 
	}
	
	static public function remove_default_image() {		
		wizshop_delete_image_by_name(wizshopDefaultImage, true);
	}
	
	static public function upload_default_image() {		
		global $wizshop_upload_path;
		$orig_path = wizshopPluginPath . '/img/' . wizshopDefaultImage;
		$upd_path = $wizshop_upload_path['dir'] . '/' . wizshopDefaultImage;
		$upd_url  = $wizshop_upload_path['url'] . '/' . basename($upd_path);
		
		$old_props = wizshop_get_image_props(wizshopDefaultImage);
		$is_exists =  file_exists($upd_path);

		if(!$is_exists){
			//clear old attach
			wizshop_delete_image_by_name(wizshopDefaultImage);
			//no old image
			if(!copy($orig_path, $upd_path)){
				self::add_admin_notice(__('Failed to copy default image to \uploads\wizshop folder.', WizShop), 'notice is-dismissible notice-error');
			}

		}else{
			if($old_props && !empty($old_props)){
				if($old_props[1] == $upd_url){
					return $old_props[0]; //old image and attachment
				}else{
					wp_delete_post($old_props[0], true);
				}
			}
		}
		$filetype = wp_check_filetype(wizshopDefaultImage);
		$attachment = array(
			'post_mime_type' => $filetype['type'],
			'guid'           => $upd_url,
			'post_parent'    => 0,
			'post_title'     => __('Default Image', WizShop),
			'post_content'   => ''
		);
		
		$id = wp_insert_attachment($attachment, $upd_path);
		if (!is_wp_error($id)){
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
			$attach_data = wp_generate_attachment_metadata($id , $upd_path);
			wp_update_attachment_metadata( $id, $attach_data );
		}else{
			$id = false;
			self::add_admin_notice($id->get_error_message(), 'notice is-dismissible notice-error');
		}
		return $id;
	}
	
	function media_filter($where, $query){
		global $wizshop_media_settings;
		global $wizshop_upload_path;
		global $wpdb;
		global $pagenow;

		if( (('admin-ajax.php' == $pagenow) && 
			isset($_SERVER['HTTP_REFERER']) && !is_null($_SERVER['HTTP_REFERER']) &&
			isset($query->query_vars['post_mime_type']) && ($query->query_vars['post_mime_type']=='image')) &&
			((false !== strpos($_SERVER['HTTP_REFERER'],'page='.$wizshop_media_settings['name'])) ||
			 (false !== strpos($_SERVER['HTTP_REFERER'],'term.php?taxonomy=wizshop_categories')))
			){
			$filter = " {$wpdb->posts}.guid LIKE '" . trailingslashit($wizshop_upload_path['url']) ."%'";
			if(!$where){
				$where = $filter;
			}else{
				$where .= ' AND ' . $filter;
			}
		}
		return $where;
	}
	
	static function check_shop_definitions(&$options){
		$changed = false;
		if(!empty($options['shop_id'])){
			$def = WizShop_Api::get_definitions();
			if($def){
				if (property_exists($def,'WizSearchItm') && ($options['wiz_search'] != (("" != $def->WizSearchItm) ? 1: 0))){
					$options['wiz_search'] = ("" != $def->WizSearchItm) ? 1: 0;
					$changed = true;
				}
				if (property_exists($def,'VSManageShipping') && ($options['shipping'] != (("1" == $def->VSManageShipping) ? 1: 0))){
					$options['shipping'] = ("1" == $def->VSManageShipping) ? 1: 0;
					$changed = true;
				}
				if (property_exists($def,'VSGuestAllowed') && ($options['guests'] != (("1" == $def->VSGuestAllowed) ? 1: 0))){
					$options['guests'] = ("1" == $def->VSGuestAllowed) ? 1: 0;
					$changed = true;
				}
			}
		}
		if($changed){
			global $wizshop_settings;
			update_option($wizshop_settings['name'], $options);
		}
		return $changed;
	}
	
}
$s = new WizShop_Settings();
?>