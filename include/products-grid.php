<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
	$view_op = wizshop_get_view_settings();
	$var_arr = array(	'wiz_products_view' => 'grid',
						'wiz_items_in_page' => $view_op['gallery_page'],
						'wiz_items_in_line' => $view_op['gallery_line'],
						'wiz_display_type'  => $view_op['disp_type'],
					);
	wizshop_get_template_part('products-inner','',$var_arr);	
?>