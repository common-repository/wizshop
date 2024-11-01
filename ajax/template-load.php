<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_action('wp_ajax_wiz_template_load', 'wizshop_ajax_template_load');
add_action('wp_ajax_nopriv_wiz_template_load', 'wizshop_ajax_template_load');

function wizshop_ajax_template_load() {
	global $wp_query;
	$nonce = $_POST['wp_nonce'];
	if(wp_verify_nonce( $nonce,'wizshop-nonce')) {
		if(isset($_POST['part'])){
			if(isset($_POST['lang'])){
				$lang = wizshop_validate_text_field($_POST['lang'],2);
				if(wizshop_is_shop_lang($lang)) {
					wizshop_cur_lang($lang);
				}
			}
			if(isset($_POST['id'])){$wp_query->set(wizshop_id_qvar, sanitize_text_field($_POST['id']));}
			if(isset($_POST['filter'])){$wp_query->set(wizshop_filter_qvar , sanitize_text_field($_POST['filter']));}
			if(isset($_POST['count'])){$wp_query->set(wizshop_count_qvar, intval($_POST['count']));}

			$part = wizshop_validate_text_field($_POST['part']);
			wizshop_get_template_part($part);
		}
	}
	die();
}
?>