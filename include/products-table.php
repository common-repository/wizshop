<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
	$view_op = wizshop_get_view_settings();
	$var_arr = array(	'wiz_products_view' => 'table',
						'wiz_items_in_page' => $view_op['table_page'], 
						'wiz_items_in_line' => -1,
						'wiz_display_type'  => $view_op['disp_type'],
					); 
	wizshop_get_template_part('products-inner','',$var_arr);	
?>