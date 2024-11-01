<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

add_action('wp_ajax_wiz_shop_status', 'wizshop_ajax_shop_status');
add_action('wp_ajax_nopriv_wiz_shop_status', 'wizshop_ajax_shop_status');

function wizshop_ajax_shop_status() {
	$nonce = $_POST['wp_nonce'];
	if(wp_verify_nonce( $nonce,'wizshop-nonce')) {
		if(isset($_POST['code']) && intval($_POST['code']) == 100){
				echo json_encode(array('stat_url' => esc_url(wizshop_get_shop_url())));
		}else{
			echo "";
		}
	}
	die();
}
?>