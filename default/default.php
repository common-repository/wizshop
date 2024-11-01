<?php   
/*-----------------------*/
/* class WizShop_Default */
/*-----------------------*/
class WizShop_Default {

	public function __construct() {
		add_filter('body_class',array( $this, 'body_class' ));
	}

	static public function include_files() {
	}
	
	static public function init_scripts($lang) {
		$wiz_debug = isset($_GET['wiz-debug']);
		if(wizshop_checkout_final_page()){
			wp_enqueue_script('wiz-checkout-script', trailingslashit(wizshopPluginUrl) . 'default/js/checkout' . ($wiz_debug ? '.js' : '.min.js'), array(), wizshopPluginVersion);
		}
		$css_handle = '';
		if(wizshop_use_default_css()){
			$css_handle = 'wiz-default-style';
			wp_enqueue_style($css_handle, trailingslashit(wizshopPluginUrl) . 'default/css/'
					. ((wizshop_lang_en == $lang) ? 'default_en.css' : 'default.css') , array(), wizshopPluginVersion);
		}
		$them_style = wizshop_lang_path(trailingslashit(wizshopStyle) . 'css', 'style.css', $lang );  
		if($them_style) {
			wp_enqueue_style('wiz_theme-style', trailingslashit(get_stylesheet_directory_uri()). 'wizshop/css/' .
					(($lang) ? trailingslashit($lang) : "") . 'style.css', '' != $css_handle ? array($css_handle) : array());
		}	
	}
	
	function body_class($classes) {
		if(wizshop_lang_en == wizshop_cur_lang()){
			$classes[] = 'vshop-body-en';
		}else{
			$classes[] = 'vshop-body';
		}
		return array_unique( $classes );
	}
};
//class
new WizShop_Default();
?>