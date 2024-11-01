<?php   
/* 	
Plugin Name: WizShop
Plugin URI: https://shop.wizshop.co.il/
Description: WizShop eCommerce plugin allows WizCount (Hashavshevet) users to integrate their virtual store in a WordPress website
Author: WizSoft, Inc
Text Domain: wizshop
Domain Path: /languages/
Version: 3.0.2
*/  

/*-----------------------*/ 
/* class  WizShop_Plugin  */
/*-----------------------*/ 
class WizShop_Plugin {
		
	var $options;
	var $don_pass;
	
	public function __construct() {
		
		$this->pre_init();
		
		register_activation_hook(__FILE__, array( 'WizShop_Plugin', 'activation'));
		register_deactivation_hook( __FILE__, array( 'WizShop_Plugin', 'deactivation'));
		register_uninstall_hook(    __FILE__, array('WizShop_Plugin', 'uninstall' ));
		add_action( is_multisite() ? 'network_admin_menu' : 'admin_menu', array( $this, 'admin_menu' ) );
		add_action('wp_loaded',array( $this, 'flush_rules' ));
		add_action('wp_enqueue_scripts', array( $this, 'init_scripts' ) );
		add_action('admin_enqueue_scripts', array( $this, 'admin_init_scripts') );
		add_action('init', array( $this, 'init' ) );
		if (!is_admin() ){
			add_filter('wp_nav_menu_items', array( $this, 'nav_menu_items' ), 10, 2 );
			add_filter('wp_get_nav_menu_items', array( $this, 'get_nav_menu_items' ), 10, 2 );
		}
		add_action('after_setup_theme', array( $this, 'register_images') );
		add_action('plugins_loaded', array( $this, 'on_loaded') );
	}
	
	function admin_menu() {
		remove_submenu_page( 'edit.php?post_type='. wizshopShopPostType, 'edit.php?post_type='. wizshopShopPostType);
		remove_submenu_page( 'edit.php?post_type='. wizshopShopPostType, 'post-new.php?post_type=' . wizshopShopPostType );
	}	
	
    public static function activation() {
		global $wizshop_cat_taxonomies;
		update_option(wizshopNotices,'');
		self::prepare_wiz_upload_dir();
  		WizShop_PostTypes::create_taxonomies();
		foreach ($wizshop_cat_taxonomies as $key => $tax ) {
			WizShop_Menus::setTaxMenus(get_option($tax['settings']['name']));
		}
	}

	public static function deactivation() {
		global $wizshop_cat_taxonomies;
		foreach ($wizshop_cat_taxonomies as $key => $tax ){
			WizShop_Menus::removeTaxMenus($tax['name']);
		}
    }
	
	public static function uninstall() {
		global $wizshop_cat_taxonomies;
		self::deactivation();
		WizShop_Pages::remove_pages();
		WizShop_Pages::set_user_pages(0, true);
		$c_cats = new WizShop_Categories();
		foreach ($wizshop_cat_taxonomies as $key => $tax ){
			$c_cats->clearTaxonomyTerms($tax['name']);
		}
		WizShop_Menus::remove_component_items(true);
		WizShop_Settings::remove_default_image();
		self::flush_rules();
		wizshop_delete_options();
    }
		

	static function flush_rules() {
		global $wp_rewrite;
		$wp_rewrite->flush_rules(); 
	}
	
	function admin_init_scripts() {
		wp_enqueue_media();
	}

	function form_admin() {
	    if ( !current_user_can( 'manage_options' ) )  {
		    wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	    }
    }	
	
	function init_scripts() {
		if(!is_admin()){
			$this->init_wizjs();
		}
		WizShop_Default::init_scripts(wizshop_cur_lang());
	}

	function init_wizjs() {
		global $wizshop_upload_path;
		$uc = $this->options['shop_id'];
		$hs_server = $this->options['shop_server'];
		$lang = wizshop_cur_lang();
 		if($uc != null and trim($uc) != ""){
			$wiz_debug = isset($_GET['wiz-debug']);
			wp_register_script('wiz-load', $hs_server . '/udiver/css/' . ($wiz_debug ? 'vsc_load.js' : 'vsc_load.min.js') .'?mode=static&uc=' . $uc .'&lang=' . $lang ,array(),wizshopPluginVersion);
			if(1 == $this->options['wiz_search']){
				wp_register_script('wiz-search-lib', 'https://wzsrch.wizcloud.co.il/clientLib.js', array('jquery'), null, true);
			}
			wp_register_script('wiz-main', wizshopPluginUrl . ($wiz_debug ? 'js/main.js' : 'js/main.min.js'), array('wiz-load','jquery'), wizshopPluginVersion,true);
			wp_localize_script('wiz-main', '_wiz_main', 
				array('wp_nonce' => wp_create_nonce('wizshop-nonce'), 
					  'ajaxurl' => admin_url('admin-ajax.php'),
					  'upload_url' => trailingslashit($wizshop_upload_path['url']),
					  'def_img' => wizshop_def_image_name(),
					  'cookie_path' => COOKIEPATH,
					  'cat_view_type_cookie' => "wizshop-grid-view",
					  'search_view_type_cookie' => "wizshop-search-type-view",
					  )
			);
			wp_enqueue_script('wiz-load');
			wp_enqueue_script('wiz-main');
			if(1 == $this->options['wiz_search']){
				wp_enqueue_script('wiz-search-lib');
			}
		}
	}
	 
	function pre_init(){
		global $wizshop_settings;

		include_once(dirname(__FILE__) . '/define.php');
		include_once(wizshopPluginPath . '/globals.php');
		include_once(wizshopPluginPath . '/helpers.php');
		include_once(wizshopPluginPath . '/functions.php');
		include_once(wizshopPluginPath . '/shop-api.php');
	
		if (is_admin() ){
			wizshop_get_version();
		}
		
		wizshop_create_options();
		$this->options = wizshop_get_option($wizshop_settings['name']);
		wizshop_set_shop_langs($this->options);
		
		if (is_admin() ){
			include_once(wizshopPluginAdmin . '/cat-meta.php');
			include_once(wizshopPluginAdmin . '/settings.php');
		}		
		include_once(wizshopPluginPath . '/ajax/shop-stat.php');
		include_once(wizshopPluginPath . '/ajax/template-load.php');
		include_once(wizshopPluginPath . '/ajax/item-gallery.php');
		include_once(wizshopPluginPath . '/categories.php');
		include_once(wizshopPluginPath . '/pages.php');
		include_once(wizshopPluginPath . '/shortcodes.php');
		include_once(wizshopPluginPath . '/menus.php');
		include_once(wizshopPluginPath . '/wiz_widget.php'); 
		include_once(wizshopPluginPath . '/shop_widgets.php'); 
		
		include_once(wizshopPluginPath . '/template_loader.php');	
		include_once(wizshopPluginPath . '/post_types.php');
		
		include_once(wizshopPluginDefault . '/default.php');
		WizShop_Default::include_files();
		
		$custom_style =  wizshopStyleTemplates . '/'. wizshop_cur_lang() .'/custom-scripts.php';
		if ( file_exists( $custom_style ) ){
			include_once($custom_style);
		}else{
			$custom_style =  wizshopStyleTemplates . '/custom-scripts.php';
			if ( file_exists( $custom_style ) ){
				include_once($custom_style);
			}
		}				
	}
	
	 
	function init(){

		if(is_admin()){
			global $wizshop_cat_taxonomies;
			global $wizshop_image_settings;
			WizShop_PostTypes::create_taxonomies();
			foreach ($wizshop_cat_taxonomies as $key => $tax ) {
				if(wizshop_is_shop_lang($tax['lang']) && WizShop_Categories::is_old_terms_options($tax['name'])){
					WizShop_Settings::add_admin_notice( sprintf(__('Please update shop categories on %s options page.',WizShop), translate($tax['ui_menu_name'], WizShop)), "notice is-dismissible notice-warning");
				}
			}
			$op_img = wizshop_get_option($wizshop_image_settings['name']);
			if(!isset($op_img["def_img_id"]) || 0 == $op_img["def_img_id"]){
				wizshop_register_images_size();
				$img_id = WizShop_Settings::upload_default_image();
				if($img_id){
					$op_img["def_img_id"] = intval($img_id);
					update_option($wizshop_image_settings['name'],$op_img);
				}
			}
		}else{
			if(!load_textdomain(wizshop_pages, wizshopStyleLanguages ."/". wizshop_pages.'-'.get_locale().'.mo' )){
				load_plugin_textdomain(wizshop_pages, false, dirname(plugin_basename(__FILE__)) . '/languages' );
			}
		}
		WizShop_Shortcodes::init();
		$this->checkCustInfo();
	}	
 	
	function checkCustInfo(){ 
		$shop_id = $this->options['shop_id'];
		if(!isset($_COOKIE['CDet_'. $shop_id]) || !isset($_COOKIE['CReg_'. $shop_id])  ||
					!isset($_COOKIE['Cust_'. $shop_id])){
					
			$res = WizShop_Api::sendReq('&HTTPREQ=10&ExInfo=1',$this->options, wizshop_cur_lang()); 
			if(false !== $res && is_object($res)) {
				if(isset($res->CustCookieVal)){
					setcookie('Cust_'. $shop_id, $res->CustCookieVal, 0, COOKIEPATH, COOKIE_DOMAIN);
				}
				if('Yes' == $res->Status && isset($res->CustCookieVal) && isset($res->B2BSwCustDet)){
					setcookie('CDet_'. $shop_id, $res->B2BSwCustDet , 0, COOKIEPATH, COOKIE_DOMAIN);
					setcookie('CReg_'. $shop_id, (substr($res->CustCookieVal,0,1) != '0') ? '1': '2' ,0, COOKIEPATH, COOKIE_DOMAIN);
				
				}else{
					setcookie('CDet_'. $shop_id, '3', 0, COOKIEPATH, COOKIE_DOMAIN);
					setcookie('CReg_'. $shop_id, '0', 0, COOKIEPATH, COOKIE_DOMAIN);
				}
			}
		
		}
		return;
	}	
	
	public function isCustRegistered(){
		$cook = 'CReg_'. $this->options['shop_id'];
		return isset($_COOKIE[$cook ]) ? intval($_COOKIE[$cook ]) : 0;
	}

	public function getB2BSCustDet(){
		$cook = 'CDet_'. $this->options['shop_id'];
		return isset($_COOKIE[$cook ]) ? intval($_COOKIE[$cook ]) : 3 ;
	}
		
	public function isDonatePass(){ 
		if(!isset($this->don_pass)){
			$res = WizShop_Api::sendReq('&HTTPREQ=44&VSGetCountries=0'. WizShop_Api::getWizCustomerPart(), $this->options, wizshop_cur_lang()); 
			if(false !== $res && is_object($res)) {
				$this->don_pass =  ($res->DNPassMode == '1') ;
			}
		}
		return $this->don_pass;
	}	
		
	function nav_menu_items($items,$args) {
		WizShop_Menus::add_shortcode_menus($items,$args);	
		$this->filter_categories($items);
		return $items;
	}
	
	function get_nav_menu_items($items, $menu) {
		WizShop_Menus::prepare_shortcode_menus($items,$menu);
		return $items;
	}

	function filter_categories(&$items) {
		$disp_type = $this->isCustRegistered();
		if($disp_type == 1){ /*b2b*/
			$items = str_replace ('wiz_cat_menu_disp_1','v_ihide', $items);
		}else if($disp_type == 2 || $disp_type == 0)/*b2c or not reg*/{
			$items = str_replace ('wiz_cat_menu_disp_2','v_ihide', $items);
		}
	}
		
	static function prepare_wiz_upload_dir() {
		$upload = wp_upload_dir();
		$upload_dir = $upload['basedir'];
		$upload_dir = $upload_dir . '/wizshop';
		if (! is_dir($upload_dir)) {
		   wp_mkdir_p( $upload_dir);
		}
	}
	
	function register_images() {
		wizshop_register_images_size();
	}	

	function on_loaded() {
		load_plugin_textdomain(WizShop, false, dirname(plugin_basename(__FILE__)) . '/languages' ); 
	}	
	
}; 
//class
$wizshop_plugin = new WizShop_Plugin();
?>