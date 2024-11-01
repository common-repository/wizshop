<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
	$wiz_products_view = wizshop_grid_view();
	if("grid" == $wiz_products_view){
		wizshop_get_template_part('products-grid');
	}else if("table" == $wiz_products_view){
		wizshop_get_template_part('products-table');
	}else if("lines" == $wiz_products_view){
		wizshop_get_template_part('products-lines');
	}
?>