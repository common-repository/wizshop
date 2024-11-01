<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/*---------------------------*/ 
/* class  WizShop_Categories */
/*---------------------------*/ 
class WizShop_Categories {

	public function __construct() {
	}
	
	static public function setTaxonomyTerms($options, &$err = null){ 
		global  $wizshop_settings;
		if(!$options ||!is_array($options)) return false;
		$shop_options = wizshop_get_option( $wizshop_settings['name']);
		if(!WizShop_Api::checkServer($shop_options,$err)){
			return false;
		}
		if(self::is_old_terms_options($options['taxonomy'])){
			self::check_old_terms_options($options['taxonomy']);
		}
		delete_option($options['taxonomy']."_children");	
		$root = WizShop_Api::get_categories($options['lang'],$err);
		if(false === $root){
			return false;
		}
		$ret = true;
		if(is_array($root[10]) && count($root[10]) > 0){
			self::test_categories($options['taxonomy'],false);
			$ret = self::update_categories($root,$options['lang'],$options['taxonomy'],$options['v_img_upd'],$shop_options,$err);
			if($ret){
				self::test_categories($options['taxonomy'],true/*delete*/);
				flush_rewrite_rules();
			}
		}
		return $ret;
	}	

	static public function get_term_option_field($taxonomy,$term_id){
		return $taxonomy .'_$' . $term_id;
	}
	
	static public function get_cat_info($taxonomy,$term_id) {
		global $wpdb;
		$ret =  $wpdb->get_var($wpdb->prepare("SELECT t.meta_value FROM $wpdb->termmeta AS t
					INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id
					WHERE t.term_id = %d AND tt.taxonomy = %s",intval($term_id), $taxonomy));
		return ($ret) ? (object)json_decode($ret) : null;
	}
	
 	static public function update_term_meta($term_id, $taxonomy, $catObj) {
		return self::update_term_meta_item($term_id, $taxonomy. '_0', json_encode($catObj));
	}
	
	static public function clearTaxonomyTerms($taxonomy){ 
		global $wpdb;
		$wpdb->query( 
			$wpdb->prepare( 
				"DELETE t, tt, ttt FROM $wpdb->terms AS t 
				INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id
				LEFT JOIN $wpdb->termmeta AS ttt ON t.term_id = ttt.term_id
				WHERE tt.taxonomy = %s", $taxonomy
			)
		);
		self::delete_old_terms_options($taxonomy);
	}
	
	static  function test_categories($taxonomy, $del){ 
		global $wpdb;
		if(!$del){
			$wpdb->query( 
				$wpdb->prepare( 
					"UPDATE $wpdb->termmeta as t
					INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id
					SET t.meta_key = %s 
					WHERE tt.taxonomy = %s", $taxonomy. '_1', $taxonomy
				)
			);
		}else{
			$wpdb->query( 
				$wpdb->prepare( 
					"DELETE t, tt, ttt FROM $wpdb->terms AS t 
					INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id
					LEFT JOIN $wpdb->termmeta AS ttt ON t.term_id = ttt.term_id
					WHERE ttt.meta_key = %s AND tt.taxonomy = %s", $taxonomy. '_1', $taxonomy
				)	
			);
		}
	}	
		
	static function catObj($id, $cat,$cat_path, $type, $cookie, $view_options=-1, $img=0) {
		return (object) array('id' => $id, 'cat' => $cat, 'cat_path' => $cat_path, 'type' =>$type, 
							'cookie'=>$cookie, 'view_options' =>$view_options, 'img' =>$img );
	}

	static function catSlug($cat_key) {
		$ret = '';
		$arr = explode('||',$cat_key);
		foreach ($arr as $value) {
			$temp = trim($value);
			if('' != $temp){
				if('' != $ret ){
					$ret .= '-';
				}
				$ret .= $temp;
			}
		}
		return $ret;
	}
		
	
	static function update_categories(&$root, $lang ,$taxonomy, $update_img_name, $shop_options, &$err) { 
		$ret = true;
		$term = false;
		if(!is_array($root[10]) || count($root[10]) == 0){
			return $ret;	
		}
		$cat_stack = array(array('parent_id' => 0, 'arr' => &$root[10]));
		while($ret && (($item = array_pop($cat_stack)) != null)){
			foreach ($item["arr"] as &$col) {
				$name = trim($col[1]);
				$slug = self::catSlug(trim($col[0]));
				$trans_slug = "";
				
				if( isset($col[9]) && is_array($col[9]) && count($col[9]) > 0){
					$slug = self::catSlug(trim((wizshop_lang_he == $lang) ? $col[0] : $col[9][1]));
					$trans_slug =  self::catSlug(trim((wizshop_lang_he == $lang) ? $col[9][1] : $col[0]));
				}

				if (isset($name) &&  $name != '' && $name != 'NON') {
					 $term_id = '';
					 $term = self::get_term_by_slug($slug, $taxonomy);
					 if (!$term) {
						 $insert_ret = self::insert_term($name,$taxonomy,
							  array(
								//'description'=> ,
								'slug' => $slug,
								'parent'=> $item["parent_id"]
							  )
						);
						if(is_wp_error( $insert_ret )){
							if(!is_null($err)) $err = $insert_ret->get_error_message();
							$ret = false;
						}else {
							$term_id = $insert_ret; 
							if (function_exists('pll_set_term_language')){
								pll_set_term_language($term_id,$lang);
							}
						}
					 }else {
						$term_id = $term[0];
						$upd_ret = self::update_term(intval($term_id), $taxonomy, 
							array(
								'slug' => $slug,
								'parent'=> $item["parent_id"]
							  )
							);
						if(is_wp_error($upd_ret)){
							if(!is_null($err)) $err = $upd_ret->get_error_message();
							$ret = false;
						}else{
						
							if (function_exists('pll_set_term_language')){
								pll_set_term_language($term_id,$lang);
							}					
						}
					 }
					if($ret){
						$obj = ($term && $term[1]) ? (object)json_decode($term[1]) : self::get_cat_info($taxonomy,$term_id); 
						if(isset($obj)){
							$obj->id = $col[0]; //sanitize_text_field(trim($col[0]));
							$obj->cat = sanitize_text_field(trim($col[1]));
							$obj->cat_path = $col[2]. '@@'. $col[0] /*sanitize_text_field(trim($col[2]) . '@@' . trim($col[0]))*/;
							$obj->type = sanitize_text_field(trim($col[5]));
							$obj->cookie = "0"; 
							if(!property_exists($obj,'view_options')) $obj->view_options = -1;
							if(!property_exists($obj,'img'))  $obj->img = 0;
							if(1 == $update_img_name){
								WizShop_Api::update_cat_img(/*trim(*/$col[0]/*)*/, $obj->img, $shop_options);
							}
						}else{
							$obj = self::catObj($col[0] /*sanitize_text_field(trim($col[0]))*/,
												sanitize_text_field(trim($col[1])), 
												$col[2]. '@@'. $col[0] /*sanitize_text_field(trim($col[2]) . '@@' . trim($col[0]))*/,
												sanitize_text_field(trim($col[5])),
												"0");
						}					
						self::update_term_meta($term_id,$taxonomy,$obj);
						self::set_tax_trans($term_id, $trans_slug, $lang);
						
						if(is_array($col[10]) && count($col[10]) > 0){
							array_push($cat_stack, array('parent_id' => intval($term_id), 'arr' => &$col[10]));
						}
					}
				}
				if(!$ret) break;
			}//for
		}//while
		return $ret;
	}

	static function insert_term( $term, $taxonomy, $args) {
		global $wpdb;
		$defaults = array( 'alias_of' => '', 'description' => '', 'parent' => 0, 'slug' => '');
		$args = wp_parse_args( $args, $defaults );
		$args['name'] = $term;
		$args['taxonomy'] = $taxonomy;
		$args['description'] = (string) $args['description'];
		$args = sanitize_term($args, $taxonomy, 'db');
		$name = wp_unslash( $args['name'] );
		$description = wp_unslash( $args['description'] );
		$parent = (int) $args['parent'];
		$slug = $args['slug'];
		$term_group = 0;
		if ( false === $wpdb->insert( $wpdb->terms, compact( 'name', 'slug', 'term_group' ) ) ) {
			  return new WP_Error( 'db_insert_error', _e( 'Could not insert term into the database' ), $wpdb->last_error );
		}
		$term_id = (int) $wpdb->insert_id;
		$wpdb->insert( $wpdb->term_taxonomy, compact('term_id', 'taxonomy', 'description', 'parent') + array( 'count' => 0 ) );
		return $term_id;
	}		
	
	static function update_term($term_id, $taxonomy, $args) {
		global $wpdb;
		$defaults = array('parent' => 0, 'slug' => '');
		$args = wp_parse_args( $args, $defaults );
		$args['taxonomy'] = $taxonomy;
		$args = sanitize_term($args, $taxonomy, 'db');
		$parent = (int) $args['parent'];
		$tt_id = (int) $wpdb->get_var( $wpdb->prepare("SELECT tt.term_taxonomy_id FROM $wpdb->term_taxonomy AS tt INNER JOIN $wpdb->terms AS t ON tt.term_id = t.term_id WHERE tt.taxonomy = %s AND t.term_id = %d", $taxonomy, $term_id) );
		$wpdb->update($wpdb->term_taxonomy, compact( 'term_id', 'taxonomy', 'parent' ), array( 'term_taxonomy_id' => $tt_id ));
		return $term_id;
	}	
		
	static function update_term_meta_item($term_id, $meta_key, $meta_value) {
		$result = false;
		global $wpdb;
		
		if(0 == $wpdb->get_var( $wpdb->prepare("SELECT COUNT(*) FROM $wpdb->termmeta WHERE term_id = %d", $term_id ) ) ){
			$result = $wpdb->insert( $wpdb->termmeta, array(
				'term_id' => $term_id,
				'meta_key' => $meta_key,
				'meta_value' => $meta_value
	        ) );		
		}else{
			$data  = compact( 'meta_value' ,'meta_key');
			$where = array( 'term_id' => $term_id);
			$result = $wpdb->update($wpdb->termmeta, $data, $where);
		}
		return $result;
	}	

	static public function get_term_by_slug($slug, $taxonomy){
		global $wpdb;
		$slug = sanitize_title($slug);
		$query = "SELECT t.term_id, ttt.meta_value FROM {$wpdb->terms} AS t 
				INNER JOIN {$wpdb->term_taxonomy} AS tt ON t.term_id = tt.term_id
				LEFT JOIN {$wpdb->termmeta} AS ttt ON t.term_id = ttt.term_id
				WHERE t.slug = '$slug' AND tt.taxonomy ='$taxonomy'";
		$ret = $wpdb->get_results($query,ARRAY_N);
		return ($ret && is_array($ret))? $ret[0] : false;
	}
	
	static function set_tax_trans($term_id, $trans_slug, $lang){
	
		global $wizshop_is_multi_lang;
		global $wizshop_languages;
		global $wizshop_cat_taxonomies;
		if(isset($trans_slug) && $wizshop_is_multi_lang && function_exists('pll_get_term_translations') && function_exists('pll_save_term_translations') ){
			$trans_lang = ($lang == $wizshop_languages[0]) ? $wizshop_languages[1] : $wizshop_languages[0];
			if(isset($trans_lang) && $trans_lang != $lang){
				$write = false;
				$trans_term = self::get_term_by_slug($trans_slug, $wizshop_cat_taxonomies[$trans_lang]['name']);
				$term_op = pll_get_term_translations($term_id);
			
				if(!isset($term_op) || !is_array($term_op)){
					$term_op =  array($lang => $term_id);
					$write = true;
				}
				
				if(array_key_exists($trans_lang,$term_op)){
					if($trans_term){
						if(intval($term_op[$trans_lang]) != intval($trans_term[0])){
							$term_op[$trans_lang] = $trans_term[0];
							$write = true;
						}					
					}else{
						$write = true; //clear
					}
				}else if($trans_term){
					$term_op[$trans_lang] = $trans_term[0];
					$write = true;
				}
		
				if($write){
					pll_save_term_translations($term_op);
				}
			}
		}
	}
	
	static public function is_old_terms_options($taxonomy){
		global $wpdb;
		return (0 != $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $wpdb->options WHERE $wpdb->options.option_name LIKE %s", $taxonomy ."_$%")));
	}

	static function check_old_terms_options($taxonomy){
		global $wpdb;
		$query = "SELECT t.term_id FROM {$wpdb->terms} AS t 
					INNER JOIN {$wpdb->term_taxonomy} AS tt ON t.term_id = tt.term_id
					WHERE tt.taxonomy ='$taxonomy'";
		$ret = $wpdb->get_results($query);
		if($ret){
			foreach ($ret as $k ){
				$op_id = self::get_term_option_field($taxonomy,intval($k->term_id));
				$cat_obj = get_option($op_id);
				if($cat_obj){
					self::update_term_meta(intval($k->term_id),$taxonomy,$cat_obj);
				}
			}
		}
		self::delete_old_terms_options($taxonomy);
	}
	
	static function delete_old_terms_options($taxonomy){
		global $wpdb;
		$wpdb->query( 
				$wpdb->prepare( 
					"DELETE FROM $wpdb->options WHERE $wpdb->options.option_name LIKE %s", $taxonomy ."_$%"
					)
			);
	}

	static function getKeyOnFilter($catkey){
		if(isset($catkey) && (0 == strncasecmp("#c",$catkey, 2))){
			$arr = explode('/',$catkey);
			$catkey = end($arr);
		}
		return $catkey;
	}
	
	static public function get_cat_term_by_key($catkey, $taxonomy = null){
		if(!$taxonomy){
			$tax = self::current_lang_tax();
			if($tax){
				$taxonomy = $tax['name'];
			}
		}
		if(!$taxonomy){
			return null;
		}
		$catkey = self::getKeyOnFilter($catkey);
		if(!isset($catkey)) return null;
		$slug = self::catSlug($catkey);
		return self::get_term_by_slug($slug, $taxonomy);
	}
	
	static public function get_cat_info_by_key($catkey, $taxonomy = null){
		$term =  self::get_cat_term_by_key($catkey, $taxonomy);
		return ($term) ?  (object)json_decode($term[1]) : null;
	}
	
	static public function current_lang_tax(){
		global $wizshop_cat_taxonomies;
		$lang = wizshop_cur_lang();
		return array_key_exists($lang,$wizshop_cat_taxonomies) ? $wizshop_cat_taxonomies[$lang] : false;
	}
	
}; 
?>