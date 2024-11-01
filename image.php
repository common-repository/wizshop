<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/*---------------------------------*/ 
/* class  WizShop_Image_Loader  */
/*---------------------------------*/ 
class WizShop_Image_Loader {
	public function __construct() {
		add_filter( 'query_vars', array($this, 'add_query_vars'), 0 );
		add_action('rewrite_rules_array',array($this,'add_rewrite_rules'));
		add_action( 'parse_request', array($this, 'parse_request'), 0 );
	}
		
	function add_rewrite_rules($rules) {
		$newrules = array();
		$newrules[wizshopImagesUrlPath] = 'index.php?wiz-image-load=1';
		return $newrules + $rules;
	}		

	function add_query_vars( $vars ) {
		$vars[] = 'wiz-image-load';
		return $vars;
	}

	function parse_request( $wp_query){
		global $wp;
		if(isset($wp->query_vars['wiz-image-load'])){
			$this->load_image();
		}
	}

	function load_image() {
		
		global $wizshop_upload_path;
		$attachments = false;
		$file_path = '';
		$def_img = false;
		$hasReq = false;
		$is_def_img = false;
		
		wp_parse_str($_SERVER['QUERY_STRING'], $args);

		$lang = (isset($args['lang']) && !empty($args['lang'])) ? wizshop_validate_text_field($args['lang'],2) : "";
		$size = (isset($args['size']) && !empty($args['size'])) ? wizshop_validate_text_field($args['size']) : "";
		
		if(wizshop_is_shop_lang($lang)){
			wizshop_cur_lang($lang);
		}
	
		if(isset($args['def'])){
			$def_img = true;
		}
		
		if(isset($args['name'])){
			$hasReq = true;
			if(!empty($args['name'])){
				$attachments = wizshop_get_image_by_name(sanitize_file_name(wizshop_validate_text_field($args['name'])),$size);
				if($attachments && !file_exists(str_replace($wizshop_upload_path['url'], $wizshop_upload_path['dir'], $attachments[0]))){
					$attachments = false;
				}
			}
		}else if(isset($args['cat'])){
			$hasReq = true;
			if(!empty($args["cat"])){
				$attachments = wizshop_get_cat_image(sanitize_title(wizshop_validate_text_field($args['cat'])),$size);
				if($attachments && !file_exists(str_replace($wizshop_upload_path['url'], $wizshop_upload_path['dir'], $attachments[0]))){
					$attachments = false;
				}
			}
		}
		
		//check default
		if(!$attachments && $hasReq && $def_img){
			$attachments = wizshop_get_def_image($size);
			if($attachments && isset($attachments[0]))
				$is_def_img = true;
			else
				$attachments = false;
		}
		// send image
		if($attachments){
			$file_path = str_replace($wizshop_upload_path['url'], $wizshop_upload_path['dir'], $attachments[0]);
			if(!file_exists($file_path)){
				header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404);
			}else{
				$file_time = filemtime($file_path);
				if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && (strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) >= $file_time)) {
					header('Last-Modified: '.gmdate('D, d M Y H:i:s', $file_time).' GMT', true, 304);
				}else{
					$file_type = wp_check_filetype($file_path);
					$file_size = filesize($file_path);
					$stat = ($hasReq && $is_def_img) ? 302 : 200 ;
					header('Last-Modified: '.gmdate('D, d M Y H:i:s', $file_time).' GMT', true, $stat);
					header("Content-type: ". $file_type['type']);
					if($hasReq && $is_def_img){
						header('Location: ' . $attachments[0]);
						header("Content-Length: 0");
					}else{
						header("Content-Length: ". "$file_size");
						header('Cache-Control: no-cache');
						readfile($file_path);
					}
				}
			}
		}
		else{
			header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found", true, 404); 
		}
		die();
	}
}
new WizShop_Image_Loader();	
?>