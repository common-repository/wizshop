<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/*----------------------------*/ 
/* class  WizShop_Shortcodes  */
/*----------------------------*/ 
class WizShop_Shortcodes {
		
	public static function init() {
		add_shortcode('wizshop-element', __CLASS__.'::template_shortcode' );
	}
	public static function template_shortcode($atts, $content = null) {
		$variables = array();
		global $wp_query;
		$ret = '';
		$a = shortcode_atts( array(
			'name' => '',
			'id' => '',
			'filter' => '',
			'count' => '',
			'view' => '',
			'lang' =>'',
		), $atts );
		
		if(isset($atts['static']) && '1' == $atts['static']){
			$variables = array(
				'wiz_custom_id' 	=> 	isset($a['id']) ?  sanitize_text_field($a['id']) :  '',
				'wiz_custom_filter' => 	isset($a['filter']) ?  sanitize_text_field($a['filter']) :  '',
				'wiz_custom_count' 	=> 	isset($a['count']) ?  sanitize_text_field($a['count']) :  '',
				'wiz_custom_view' 	=> 	isset($a['view']) ?  sanitize_text_field($a['view']) :  '',
			);
			
		}else{
			if(isset($a['id']) && "" != $a['id']){$wp_query->set(wizshop_id_qvar ,sanitize_text_field($a['id']));}
			if(isset($a['filter']) && "" != $a['filter']){$wp_query->set(wizshop_filter_qvar ,sanitize_text_field($a['filter']));}
			if(isset($a['count']) && "" != $a['count']){$wp_query->set(wizshop_count_qvar ,intval($a['count']));}
			if(isset($a['view']) && "" != $a['view']){$wp_query->set(wizshop_view_qvar ,sanitize_text_field($a['view']));}
		}
		
		$lang = isset($a['lang']) ?  sanitize_text_field($a['lang']) : '';
		if(wizshop_is_shop_lang($lang)){
			$wp_query->set('wiz_lang',$lang);
		}else{
			$lang = '';
		}
		
		if(isset($a['name'])){
			ob_start();
			if(isset($atts['is_component']) && '1' == $atts['is_component']){
				//component
				wizshop_get_component_part(sanitize_text_field($a['name']), $lang, $variables);
			}else{
				//default
				wizshop_get_template_part(sanitize_text_field($a['name']), $lang, $variables);
			}
			$ret = ob_get_clean();
		}
		return $ret;
	}   			
};
?>