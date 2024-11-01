<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/*----------------------------*/ 
/* functions				  */
/*----------------------------*/ 

//------------------------------------------------------------
function wizshop_lang_path($dir, $file, &$lang){
	$path = "";
	if(file_exists(trailingslashit($dir) . trailingslashit($lang). $file )){
		$path = trailingslashit($dir) . trailingslashit($lang). $file;
	}else if(file_exists(trailingslashit($dir). $file)){
		$path = trailingslashit($dir). $file;
		$lang = "";
	}
	return $path;
}
//------------------------------------------------------------
function wizshop_include_path($name, $pluginPath, $stylePath, $lang){
	$template = '';
	if(!isset($name) || "" == $name){
		return $template;
	}
	$cur_lang = $lang;
	if(!$cur_lang) 
		$cur_lang = wizshop_cur_lang();

	$file = $name . '.php';
	$template = wizshop_lang_path($stylePath, $file, $cur_lang);
	if(!$template){
		$template = wizshop_lang_path($pluginPath, $file, $cur_lang);
	}
	return $template;
}
//------------------------------------------------------------
function wizshop_get_template_part($name, $lang='', $variables = array()) {
	$template = wizshop_include_path($name,wizshopPluginInclude,wizshopStyleInclude,$lang);
	if ( $template ) {
		if(0 == count($variables)){
			include( $template );
		}else{
			extract($variables);
			ob_start();
			include( $template );
			echo ob_get_clean();
		}
	}
}
//------------------------------------------------------------
function wizshop_get_widget_part($name, $lang='') {
	$template = wizshop_include_path($name,wizshopPluginWidgets,wizshopStyleWidgets,$lang);
	if ( $template ) {
		include( $template );
	}
}
//------------------------------------------------------------
function wizshop_get_component_part($name, $lang='') {
	$template = wizshop_include_path($name,wizshopPluginComponents,wizshopStyleInclude,$lang);
	if ( $template ) {
		include( $template );
	}
}
//------------------------------------------------------------
function wizshop_img_file_url($file, $lang='') {
	$ret = $file;
	$cur_lang = $lang;
	if(!$cur_lang) 
		$cur_lang = wizshop_cur_lang();
	$path = wizshop_lang_path(wizshopStyleImg, $file, $cur_lang);
	if($path){
		$ret = trailingslashit(get_stylesheet_directory_uri()). 'wizshop/img/' . (($cur_lang) ? trailingslashit($cur_lang) : "") . $file;
	}else{
		$path = wizshop_lang_path(wizshopDefaultImgDir, $file, $cur_lang);
		if($path){
			$ret = trailingslashit(wizshopPluginUrl) . 'default/img/' . (($cur_lang) ? trailingslashit($cur_lang) : "") . $file;
		}
	}
	return esc_url($ret);
}

//------------------------------------------------------------
function wizshop_template_part_string($name, $lang='',$variables = array()) {
	return wizshop_template_path_part_string($name, wizshopPluginInclude, wizshopStyleInclude, $lang, $variables);
}
//------------------------------------------------------------
function wizshop_template_path_part_string($name, $pluginPath, $stylePath, $lang, $variables) {
	$ret = "";
	$template = wizshop_include_path($name, $pluginPath, $stylePath, $lang);
	if ( $template ) {
		extract($variables);
		ob_start();
		include( $template );
		$ret = ob_get_contents();
		ob_get_clean();
	}
	return $ret;
}

//------------------------------------------------------------
function wizshop_get_filter_var() {
	$v = get_query_var(wizshop_filter_qvar);
	return isset($v) ? rawurldecode($v) : "";
}
//------------------------------------------------------------
function wizshop_get_id_var() {
	$v = get_query_var(wizshop_id_qvar);
	return isset($v) ? rawurldecode($v) : "";
}
//------------------------------------------------------------
function wizshop_get_count_var() {
	return get_query_var(wizshop_count_qvar);
}
//------------------------------------------------------------
function wizshop_get_view_var() {
	$v = get_query_var(wizshop_view_qvar);
	return isset($v) ? rawurldecode($v) : "";
}
//------------------------------------------------------------
function wizshop_product_tag_var() {
	$v = get_query_var(wizshop_product_tag);
	return wizshop_check_product_var($v);
}
//------------------------------------------------------------
function wizshop_check_product_var($v) {
	if(isset($v) && "" != $v){
		$arr = explode('**',$v);
		if($arr) $v = $arr[0];
	}
	return isset($v) ? rawurldecode($v) : "";
}
//------------------------------------------------------------
function wizshop_template_page_orig_posttype() {
	global $wp_query;
	$ret = false;
	if(is_page() && isset($wp_query->query["post_type"])){
		$ret = $wp_query->query["post_type"];
	}
	return $ret;
}

//------------------------------------------------------------
function wizshop_cat_description() {
	$ret = '';
	if(wizshop_is_cat_tax()){
		$term = get_queried_object();
		if(is_object($term)) {
			$ret = $term->description;
		}
	}else if($pt = wizshop_template_page_orig_posttype()){
		$cat_slug = get_query_var($pt);
		if(isset($cat_slug)){
			$info  = WizShop_Categories::get_term_by_slug($cat_slug, $pt);
			if($info){
				$ret = term_description($info[0], $pt);
			}
		}
	}
	return $ret;	
}
//------------------------------------------------------------
function wizshop_cur_cat_key() {
	$ret = '';
	if(wizshop_is_cat_tax()){
		$term = get_queried_object();
		if(is_object($term)) {
			$cat_obj = WizShop_Categories::get_cat_info($term->taxonomy,$term->term_id);
			if($cat_obj){
				$ret = $cat_obj->id;
			}
		}
	}else if($pt = wizshop_template_page_orig_posttype()){
		$cat_slug = get_query_var($pt);
		if(isset($cat_slug)){
			$info  = WizShop_Categories::get_term_by_slug($cat_slug, $pt);
			if($info){
				$cat_obj = WizShop_Categories::get_cat_info($pt, $info[0]);
				if($cat_obj){
					$ret = $cat_obj->id;
				}			
			}
		}
	}	
	return $ret;	
}
//------------------------------------------------------------
function wizshop_is_cat_tax($name=null) {
	global $wizshop_cat_taxonomies;
	foreach ($wizshop_cat_taxonomies as $key => $tax ) {
		if($name){
			if($tax['name'] == $name){
				return $tax;
			}
		}
		else if(is_tax($tax['name'])) {
			return $tax;
		}
	}	
	return false;
}
//------------------------------------------------------------
function wizshop_product_archive_type() {
	global $wizshop_product_posttype;
	foreach ($wizshop_product_posttype as $key => $pst ) {
		if(is_post_type_archive($pst['name'])) {
			return $pst;
		}
	}		
	return false;
}
//------------------------------------------------------------
function wizshop_is_product_posttype($name=null) {
	global $wizshop_product_posttype;
	$type = (null != $name) ? $name : get_post_type();
	if(isset($type)){
		foreach ($wizshop_product_posttype as $key => $pst ) {
			if($type == $pst['name']) {
				return $pst;
			}
		}	
	}
	return false;
}
//------------------------------------------------------------
function wizshop_get_option($op) {
	global $wizshop_manage_settings;
	foreach ($wizshop_manage_settings as $key => $val ) {
		if($op == $val['name']) {
			$ret = get_option($op,$val['defaults']);
			return wizshop_merge_args($ret,$val['defaults']);
		}
	}	
	return get_option($op);
}
//------------------------------------------------------------
function wizshop_merge_args(&$op, $def ) {
	$ret = $def;
	foreach($op as $key => &$val ) {
		if(is_array($val)&& isset($ret[$key])){
			$ret[$key] = wizshop_merge_args($val,$ret[$key]);
		}else{
			$ret[$key] = $val;
		}
	}
	return $ret;
}
//------------------------------------------------------------
function wizshop_create_options() {
	global $wizshop_manage_settings;
	if(!is_admin()) return;
	foreach ($wizshop_manage_settings as $key => $val ) {
		$ret = get_option($val['name']);
		if(!$ret){
			update_option($val['name'],$val['defaults']);
		}
	}	
}
//------------------------------------------------------------
function wizshop_delete_options() {
	global $wizshop_manage_settings;
	if(!is_admin()) return;
	foreach ($wizshop_manage_settings as $key => $val ) {
		delete_option($val['name']);
	}	
}

//------------------------------------------------------------
function wizshop_cur_lang($lang='') {
	global $wizshop_cur_lang;
	global $wizshop_languages;
	if($lang) 
		$wizshop_cur_lang = $lang;
	if(!$wizshop_cur_lang){
		if(function_exists('pll_current_language')){
			$wizshop_cur_lang = pll_current_language();
		}
		if(!$wizshop_cur_lang)
			$wizshop_cur_lang = $wizshop_languages[0];
	}
	return 	$wizshop_cur_lang;
}
//------------------------------------------------------------
function wizshop_is_shop_lang($lang) {
	global $wizshop_languages;
	foreach ($wizshop_languages as $key) {
		if($key == $lang){
			return true;
		}	
	}		
	return false;
}
//------------------------------------------------------------
function wizshop_is_supported_lang($lang) {
	global $wizshop_support_lang;
	foreach ($wizshop_support_lang as $key => $val) {
		if($key == $lang){
			return true;
		}	
	}		
	return false;
}
//------------------------------------------------------------
function wizshop_get_setting($key, $options = null) {
	if(is_null($options)){
		global $wizshop_settings;
		$options = wizshop_get_option($wizshop_settings['name']);
	}
	return $options[$key];
}
//------------------------------------------------------------
function wizshop_is_wizsearch($options = null) {
	return (1==wizshop_get_setting('wiz_search', $options));
}
//------------------------------------------------------------
function wizshop_is_shipping($options = null) {
	return (1==wizshop_get_setting('shipping', $options));
}
//------------------------------------------------------------
function wizshop_use_default_css($options = null) {
	return (1==wizshop_get_setting('default_css', $options));
}
//------------------------------------------------------------
function wizshop_is_guest_allowed($options = null) {
	return (1==wizshop_get_setting('guests', $options));
}
//------------------------------------------------------------
function wizshop_set_shop_langs($options = null) {
	global $wizshop_settings;
	global $wizshop_support_lang;
	global $wizshop_languages;
	global $wizshop_is_multi_lang;
	if(is_null($options)){
		$options = wizshop_get_option($wizshop_settings['name']);
	}
	$wizshop_languages = array();
	if(!isset($options['shop_lang']))
		$wizshop_languages[] = wizshop_lang_he;
	else
		$wizshop_languages[] = $options['shop_lang'];
	
	if(isset($options['shop_lang2']) && ($options['shop_lang2'] != "-1")
					&& $options['shop_lang2'] != $options['shop_lang']){
		$wizshop_languages[] = $options['shop_lang2'];
		$wizshop_is_multi_lang = true;
	}else{
		$wizshop_is_multi_lang = false;
	}
}
//------------------------------------------------------------
function wizshop_template_part($lang='') {
	return 'wizshop/templates/'. (($lang) ? ($lang . '/') :(''));
}
//------------------------------------------------------------
function wizshop_include_part($lang='') {
	return 'wizshop/include/'. (($lang) ? ($lang . '/') :(''));
}
//------------------------------------------------------------
// Backward support. See wizshop_get_image_name
function wizshop_cat_image_name($img_id, $full = false) {
	return wizshop_get_image_name($img_id, $full);
}
//------------------------------------------------------------
function wizshop_def_image_name() {
	global $wizshop_image_settings;
	$op = wizshop_get_option($wizshop_image_settings['name']);
	$name =  wizshop_get_image_name($op["def_img_id"]);
	return $name ? $name: wizshopDefaultImage ;
}
//------------------------------------------------------------
function wizshop_get_image_name($img_id, $full = false) {
	global $wpdb;
	global $wizshop_upload_path;
	$ret = false;
	if(isset($img_id) && $img_id > 0){
		$query = "SELECT meta_value FROM {$wpdb->postmeta} 
				INNER JOIN {$wpdb->posts} ON {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id
				WHERE  {$wpdb->postmeta}.meta_key ='_wp_attached_file' 
				AND  {$wpdb->posts}.ID = $img_id;";	
		$ret = $wpdb->get_var($query);
		if(isset($ret)){
			$ret= substr(strrchr($ret, "/"), 1);
			if($full){
				$ret = trailingslashit($wizshop_upload_path['url']). $ret;
			}
		}
	}
	return  $ret;
}

//------------------------------------------------------------
function wizshop_get_image_props($name) {
	global $wpdb;
	global $wizshop_upload_path;
	$img   = 'wizshop/'. sanitize_file_name($name);
	$query = "SELECT post_id, meta_value FROM {$wpdb->postmeta} 
				INNER JOIN {$wpdb->posts} ON {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id
				WHERE  {$wpdb->postmeta}.meta_key = '_wp_attached_file' AND 
				{$wpdb->postmeta}.meta_value = '$img';";	
	$ret = $wpdb->get_results($query,ARRAY_N);
	if($ret && is_array($ret)){
		$ret = $ret[0];
		$ret[1] = trailingslashit($wizshop_upload_path['url']). substr(strrchr($ret[1], "/"), 1);
	}else{
		$ret = false;
	}
	return $ret;
}

//------------------------------------------------------------
function wizshop_get_gallery_images($key) {
	global $wpdb;
	$ret = array();
	$img =   'wizshop/'. sanitize_file_name($key) . "%";
	$query = "SELECT meta_value FROM {$wpdb->postmeta} 
				INNER JOIN {$wpdb->posts} ON {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id
				WHERE  {$wpdb->postmeta}.meta_key ='_wp_attached_file' AND 
				{$wpdb->postmeta}.meta_value  LIKE  '$img'
				AND  {$wpdb->posts}.post_mime_type LIKE 'image/%';";
	$res = $wpdb->get_results($query,ARRAY_N);
	if($res && is_array($res)){
		foreach ($res as $value) {
		  if(isset($value[0])){
			array_push($ret, substr(strrchr($value[0], "/"), 1));
		  }
		}
	}		
	return $ret;
}

//------------------------------------------------------------
function wizshop_delete_image_by_name($name, $file = false) {
	$props = wizshop_get_image_props($name);
	if($props && !empty($props)){
		wp_delete_post($props[0], true);
	}
	if($file){
		wizshop_delete_image($name);
	}
	return $old_keys;
}
//------------------------------------------------------------
function wizshop_delete_image($name) {
	global $wizshop_upload_path;
	$file = trailingslashit($wizshop_upload_path['dir']). $name;
	if(file_exists($file))	unlink($file);
	$key = pathinfo($name, PATHINFO_FILENAME);
	$ext = pathinfo($name, PATHINFO_EXTENSION);
	$list = glob(trailingslashit($wizshop_upload_path['dir']).$key .'-*.'. $ext) ;
	foreach ($list as $l) { 
		unlink($l);
	} 
}
//------------------------------------------------------------
// Backward support version < 2.0
function wizshop_image_cat_link($wiz_tag, $size, $def=true) {
	wizshop_image_name_link("{{ImageFile}}",$size, $def);
}
//------------------------------------------------------------
function wizshop_image_link($size, $def=true) {
	wizshop_image_name_link("{{ImageFile}}",$size, $def);
}
//------------------------------------------------------------
function wizshop_image_name_link($wiz_tag, $size, $def=true) {
	global $wizshop_upload_path;
	$len = strlen($wiz_tag);
	if($len <=4) return;
	$s_format = wizshop_format_image_sizeWH($size);
	$new_tag = substr($wiz_tag,2,$len-4);
	$makaf_format = ($s_format != "") ? ("-" . $s_format) : "";
	echo trailingslashit($wizshop_upload_path['url']) .
		'{{'.$new_tag.'_name}}'.$makaf_format.'{{'.$new_tag.'_ext}}" data-img-key="'. $wiz_tag .'"' .
			((($def) ? (' data-img-size="'.$s_format) : ''));
}

//------------------------------------------------------------
function wizshop_grid_view() {
	$def = isset($_COOKIE['wizshop-grid-view']) ? sanitize_text_field($_COOKIE['wizshop-grid-view']) : '';
	$def = apply_filters( 'wizshop_grid_view', $def );
	return $def;
}
//------------------------------------------------------------
function wizshop_search_view_cookie_val() {
	$def = isset($_COOKIE['wizshop-search-type-view']) ? sanitize_text_field($_COOKIE['wizshop-search-type-view']) : '';
	$def = apply_filters( 'wizshop_search_type_view', $def );
	return $def;
}
//------------------------------------------------------------
function wizshop_cat_view_options($all = false,$cat_info = null, $def = false) {
	global $wizshop_cat_view;
	global $wizshop_cat_taxonomies;
	$val = 0;
	$ret = (false === $def) ? array() : array("default" => "");
	$term = null;
	$tax = false;
	if(!$all){
		if($tax = wizshop_is_cat_tax()){
			$term = get_queried_object();
			if(is_object($term)){
				$cat_info = WizShop_Categories::get_cat_info($term->taxonomy,$term->term_id);
				$tax = wizshop_is_cat_tax($term->taxonomy); 
			}
			
		}else if($cat_info){
			$tax = WizShop_Categories::current_lang_tax();
		}else if($pt = wizshop_template_page_orig_posttype()){
			$tax = wizshop_is_cat_tax($pt);
			if(isset($tax)){	
				$cat_slug = get_query_var($pt);
				if(isset($cat_slug)) {
					$info  = WizShop_Categories::get_term_by_slug($cat_slug, $pt);
					if($info){
						$cat_info = (object)json_decode($info[1]);
					}
				}
			}
		}
		if($tax && $cat_info) {
			if(!property_exists($cat_info,'view_options')) $cat_info->view_options = -1;
			if($cat_info->view_options > -1 ){
				$val = $cat_info->view_options;
			}else{
				$tax_options = wizshop_get_option($tax['settings']['name']);
				if(isset($tax_options['view_options'])){
					$val = $tax_options['view_options'];
				}else{
					$all= true;
				}
			}
		}
	}else{
		$tax = WizShop_Categories::current_lang_tax();
		if($tax){
			$tax_options = wizshop_get_option($tax['settings']['name']);
			if(isset($tax_options['view_options'])){
				$val = $tax_options['view_options'];
			}			
		}
	}

	$valid_def = false;
	foreach ($wizshop_cat_view as $key => $prop){
		$ret[$key] = ( (0 == $val) || ($val & $prop['value'])) ? 1 : 0;
		if((false !== $def)  && 1 == $ret[$key] ){
			if(""==$ret["default"]){
				$ret["default"] = $key;
			}
			if($def === $key){
				$valid_def = true;
			}
		}
	}
	if($valid_def) $ret["default"] = $def;
	
	return $ret;
}
//------------------------------------------------------------
function wizshop_widget_param($param) {
	$ret = '';
	if(isset($_POST['wiz_instance']) && array_key_exists($param,$_POST['wiz_instance'])){
		$ret = sanitize_text_field($_POST['wiz_instance'][$param]);
	}
	return $ret;
}
//------------------------------------------------------------
function wizshop_validate_uc($uc) {
	return wizshop_validate_text_field($uc,30);
}
//------------------------------------------------------------
function wizshop_validate_text_field($field, $max_len=-1) {
	if(!$field) return "";
	if(-1 == $max_len) $max_len = 64;
	$safe_field = sanitize_text_field($field);
	if(strlen($safe_field) > $max_len ) {
		$safe_field = substr($safe_field, 0, $max_len );
	}
	return $safe_field;
}
//------------------------------------------------------------
function wizshop_add_images_size($arr) {
	if(is_array($arr)){
		add_image_size( "wiz_grid", $arr['grid_w'], $arr['grid_h'], ($arr['grid_crop']=='1') ? true :false );
		add_image_size( "wiz_product", $arr['product_w'], $arr['product_h'], ($arr['product_crop']=='1') ? true :false );
		add_image_size( "wiz_thumb", $arr['thumb_w'], $arr['thumb_h'], ($arr['thumb_crop']=='1') ? true :false);
		add_image_size( "wiz_cat", $arr['cat_w'], $arr['cat_h'], ($arr['cat_crop']=='1') ? true :false); 		
	}
}
//------------------------------------------------------------
function wizshop_register_images_size() {
	wizshop_add_images_size(wizshop_get_images_size());
}
//------------------------------------------------------------
function wizshop_get_images_size() {
	global $wizshop_media_settings;
	$defs = $wizshop_media_settings['defaults'];
	$v_arr = wizshop_get_option($wizshop_media_settings['name']);

	$v_arr['grid_crop'] = $defs['grid_crop'];
	$v_arr['product_crop'] = $defs['product_crop'];
	$v_arr['thumb_crop'] = $defs['thumb_crop'];
	$v_arr['cat_crop'] = $defs['cat_crop'];
	
	return $v_arr;
}

//------------------------------------------------------------
function wizshop_set_images_size() {
	global $wizshop_media_settings;
	$arr = $wizshop_media_settings['defaults'];
	foreach ($arr as $key => $val ) {
		if(isset($_POST[$key])){
			$arr[$key] = intval($_POST[$key]);
		}
	}
	update_option($wizshop_media_settings['name'], $arr);
	wizshop_add_images_size($arr);
	return true;
}
//------------------------------------------------------------
function wizshop_get_reg_image_size($name) {
	global $_wp_additional_image_sizes;
	$sizes = array();
	foreach ( get_intermediate_image_sizes() as $_size ) {
		if($name == $_size){
			if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
				$sizes['width']  = get_option( "{$_size}_size_w" );
				$sizes['height'] = get_option( "{$_size}_size_h" );
				$sizes['crop']   = (bool) get_option( "{$_size}_crop" );
			} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
				$sizes = array(
					'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
					'height' => $_wp_additional_image_sizes[ $_size ]['height'],
					'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
				);
			}
			break;
		}
	}
	return $sizes;
}
//------------------------------------------------------------
function wizshop_format_image_sizeWH($size) {
	$formatWH = "";
	if(isset($size) && "" != $size){
		$sizes = wizshop_get_reg_image_size($size);
		if(isset($sizes['width']) && isset($sizes['height'])){
			$formatWH = $sizes['width']. "x" . $sizes['height'];
		}
	}
	return $formatWH;
}

//------------------------------------------------------------
function wizshop_get_view_settings($disp_type = null) {
	$ret = false;
	$op = wizshop_get_view_options();
	if(null == $disp_type){
		$disp_type = "desktop";
		if(wp_is_mobile()){
			if( (false !== stripos($_SERVER['HTTP_USER_AGENT'],"iPad")) || 
				 (false !== stripos($_SERVER['HTTP_USER_AGENT'],"Tablet"))){
				 $disp_type = "tablet"; 
			}else{
				$disp_type = "mobile"; 
			}
		}
	}
	if(isset($op['products_view'][$disp_type])){
		$ret = $op['products_view'][$disp_type];
		$ret['disp_type'] = $disp_type;
	}
	return $ret;
}
//------------------------------------------------------------
function wizshop_get_view_options() {
	global $wizshop_view_settings;
	return wizshop_get_option($wizshop_view_settings['name']);
}
//------------------------------------------------------------
function wizshop_get_customer_options($lang='') {
	global $wizshop_customers;
	if(!$lang) 
		$lang = wizshop_cur_lang();
	return wizshop_get_option($wizshop_customers[$lang]['settings']['name']);
}

if(is_admin()){
//------------------------------------------------------------
function wizshop_admin_get_tax_menus($tax) {
	global  $wizshop_menu_settings;
	$ret = false;
	if(wizshop_is_cat_tax($tax)){
		$menu_opt = wizshop_get_option($wizshop_menu_settings['name']);
		if(isset($menu_opt)){
			if(isset($menu_opt[ $tax])){
				$ret = $menu_opt[$tax];
			}
		}
	}
	return $ret;
}
//------------------------------------------------------------
function wizshop_admin_set_tax_menus($tax, $menus) {
	global  $wizshop_menu_settings;
	$ret = false;
	if(wizshop_is_cat_tax($tax)){
		$menu_opt = wizshop_get_option($wizshop_menu_settings['name']);
			$menu_opt[ $tax] = $menus;
		if(isset($menu_opt)){
			update_option($wizshop_menu_settings['name'],$menu_opt);
			$ret = true;
		}
	}
	return $ret;
}
//------------------------------------------------------------
function wizshop_get_version() {
	global $wizshop_settings;
	global $wizshop_plugin_settings;
	$plug_o = get_option($wizshop_plugin_settings['name'],null);
	if(null == $plug_o){
		$plug_o = $wizshop_plugin_settings['defaults'];
		//pre wizshop_plugin_settings
		if(null != get_option($wizshop_settings['name'],null)){
			$plug_o["version"] = 1.5;
		}
		update_option($wizshop_plugin_settings['name'], $plug_o);
	}
	return $plug_o["version"];
}
//------------------------------------------------------------
function wizshop_insert_component_post($cp) {
	$ret = false;
	global $wizshop_component_posttype;
	$post = array(
			'post_title' 	=> $cp,
			'post_name' 	=> $cp,
			'post_content' 	=> "",
			'post_status' 	=> "publish",
			'post_type' 	=>  $wizshop_component_posttype['name'],
			'comment_status' => 'closed',
			'post_author'  	=> 1,
			'post_parent'  	=> 0,			
			);
	$ret = wp_insert_post($post);
	return (is_wp_error($ret) || 0==$ret) ? false : $ret;
}
//------------------------------------------------------------
function wizshop_is_component_post($cp) {
	$ret = false;
	global $wizshop_component_posttype;
	$posts = get_posts(array(
				'name' => $cp,
				'posts_per_page' => 1,
				'post_type' => $wizshop_component_posttype['name'],
				'post_status' => 'publish',
			));
	if($posts){
		$ret = ($posts[0] && isset($posts[0]->ID)) ? $posts[0]->ID : false;
	}	
	return $ret;
}


}//is_admin
?>