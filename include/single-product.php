<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
	if( !defined('ELEMENTOR_VERSION') || 
		!defined('ELEMENTOR_PRO_VERSION') ||
		!function_exists('elementor_theme_do_location')  || 
		!elementor_theme_do_location('single')) {
		
		wizshop_get_template_part('product-location');
		wizshop_get_template_part('product-item');
	}
?>