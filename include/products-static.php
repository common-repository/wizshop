<?php
//  input vars : 
//	$wiz_custom_id
//	$wiz_custom_filter
//	$wiz_custom_count
// 	$wiz_custom_view

if ( ! defined( 'ABSPATH' ) ) { exit; }
	global $wp_query;
	$id_var = wizshop_get_id_var();
	if(!isset($wiz_custom_id) || "" == $wiz_custom_id){
		$wiz_custom_id =  'wiz_id_qvar_' .strval(rand());
	}
	$wiz_custom_view = (!isset($wiz_custom_view) || "" == $wiz_custom_view) ? 'grid' : strtolower($wiz_custom_view);
	$count = (!isset($wiz_custom_count) || "" == $wiz_custom_count || "0" == $wiz_custom_count) ? 0 : intval($wiz_custom_count);
	$var_arr = array('wiz_products_view' => $wiz_custom_view,
					'wiz_items_in_page' =>  $wiz_custom_count ,
					'wiz_items_in_line' =>  -1,
					'wiz_display_type'  =>  '',
					'wiz_custom_id'  => $wiz_custom_id,
					'wiz_custom_filter'  => $wiz_custom_filter,
			);
	$view_op = wizshop_get_view_settings();
	if("grid" == $wiz_custom_view){
		$var_arr['wiz_items_in_line'] = $view_op['gallery_line'];
		if(0 == $count) $var_arr['wiz_items_in_page'] = $view_op['gallery_page'];
	}else if("table" ==$wiz_custom_view){
		if(0 == $count)  $var_arr['wiz_items_in_page'] = $view_op['table_page'];
	}else if("lines" == $wiz_custom_view){
		if(0 == $count) $var_arr['wiz_items_in_page'] = $view_op['lines_page'];
	}else{
		return;
	}
	wizshop_get_template_part('products-inner','',$var_arr);
	wizshop_get_template_part('quick-view');
?>