<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/*-----------------------*/ 
/* class  WizShop_Menus  */
/*-----------------------*/ 
class WizShop_Menus {

	public function __construct() {
		add_action( 'admin_init', array( $this, 'admin_init' ) );
	}

	function admin_init(){
		if(defined('wizshopComponentsMenu')){
			self::check_component_items();
			self::shortcode_menus_to_components();
		}
	}
	
	static public function setTaxMenus($taxonomy, &$err = null){
		$menu_options = wizshop_admin_get_tax_menus($taxonomy);		
		if(!$menu_options){
			return true;
		}
		$item_count = count($menu_options);
		$ret = true;
		for($i = 0; $i < $item_count;  ++$i) {
			if($menu_opt && is_array($menu_opt) && '-1' != $menu_opt['v_menu_id']){
				self::setOneTaxMenu($menu_options[$i],$taxonomy,$err);
			}
		}
		return $ret;
	}
	
	static public function setOneTaxMenu($menu_opt, $taxonomy, &$err = null){
		$ret = true;
		if( -1 != $menu_opt['v_menu_id']){
			self::removeOneTaxMenu($taxonomy, $menu_opt);
			$menu = wp_get_nav_menu_object($menu_opt['v_menu_id']);
			if(!isset($menu)){
				if(!is_null($err)) $err .=__('Menu does not exist.',WizShop);
				$ret = false;
			}else{
				$menu_items = wp_get_nav_menu_items($menu->term_id, array( 'post_status' => 'publish,draft' ));
				if(!self::getTaxMenus($taxonomy, $menu_opt, $menu->term_id, $menu_items, 
							(-1 != $menu_opt['v_item_id']) ? $menu_opt['v_item_id'] : 0,0, 0, $err)){
					$ret = false;
				}
			}
		}
		return $ret;
	}
	

	static public function removeTaxMenus($taxonomy){
		$menu_options = wizshop_admin_get_tax_menus($taxonomy);
		if(!$menu_options){
			return ;
		}
		$item_count = count($menu_options);
		for($i = 0; $i < $item_count;  ++$i) {
			$menu_opt = $menu_options[$i];
			if($menu_opt && is_array($menu_opt) && '-1' != $menu_opt['v_menu_id']){
				self::removeOneTaxMenu($taxonomy, $menu_opt);
			}
		}		
	}
	
	static public function removeOneTaxMenu($taxonomy, $menu_opt ){
		if('-1' != $menu_opt['v_menu_id']){
			$menu = wp_get_nav_menu_object($menu_opt['v_menu_id']);
			if(isset($menu)){
				$menu_items = wp_get_nav_menu_items($menu->term_id, array( 'post_status' => 'publish,draft' ));
				self::deleteItemTree($taxonomy,$menu_items,
						(-1 == $menu_opt['v_item_id']) ? 0 : $menu_opt['v_item_id']);
			}
		}
	}
	
	static  function deleteItemTree($taxonomy, &$menu_items, $parent_id ){
		foreach ($menu_items as &$menu_item) {
			if((-99 != $menu_item->ID) && ($menu_item->object === $taxonomy)&& 
				($parent_id == 0 ||intval($menu_item->menu_item_parent) == $parent_id)){
				$id = $menu_item->ID ;
				$menu_item->ID = -99;
				self::deleteItemTree($taxonomy,$menu_items,$id);
				wp_delete_post($id, true);
			}
		}
	}
		
	static function getTaxMenus($taxonom, $menu_opt, $menu_id, $menu_items, $menu_parent_id, $parent_term_id, $depth, &$err) { 
		if( ($menu_opt['v_menu_depth'] != -1) && ($depth >= $menu_opt['v_menu_depth']) ){
			return true;
		}
		$terms = get_terms( array(
			'taxonomy' => $taxonom,
			'hide_empty' => false,
			'orderby' => 'id',
			'parent' =>  $parent_term_id
		) );
		
		if(is_wp_error( $terms )){
			if(!is_null($err)){ 
				$err .= $p_id->get_error_message();
			}
			return false;
		}
		
		if(!empty( $terms )) {
			foreach ( $terms as $term ) {
				if ( !$term->term_id || $term->term_id == 0 )
					continue;
				//$match = self::check_nav_menu_items( $term , $menu_items );
				//if (!$match) {
					$p_id = self::create_nav_menu_item( $menu_id , $term , $taxonom, $menu_parent_id);
					if(is_wp_error($p_id)){
						if(!is_null($err)){ 
							$err .= $p_id->get_error_message();
						}
						return false;
					}else if($p_id != -1){
						if(!self::getTaxMenus($taxonom, $menu_opt, $menu_id, $menu_items, $p_id, intval($term->term_id),
									$depth+1, $err)){
							return false;
						}
					}
				//}
			}
		}
		return true;
	}
	
	static function create_nav_menu_item($menu_id, $term, $taxonomy, $menu_parent_id=0, $args = array()){
		$ret = -1;
		$cls = '';
		$cat_obj = WizShop_Categories::get_cat_info($taxonomy,$term->term_id);
		if(isset($cat_obj)){
			if($cat_obj->type != '4'){
				$cls = 'wiz_cat_menu_disp_' . $cat_obj->type;
				$args = array(
				'menu-item-object-id' => $term->term_id,
				'menu-item-object' => $taxonomy,
				'menu-item-type' => 'taxonomy',
				'menu-item-status' => 'publish',
				'menu-item-parent-id' => $menu_parent_id,
				'menu-item-attr-title' => $term->name,
				'menu-item-description' =>'', //$term->description,
				'menu-item-title' => $term->name,
				'menu-item-target' => '',
				'menu-item-xfn' => '',
				'menu-item-classes' => $cls,
				);
				$ret = wp_update_nav_menu_item($menu_id, 0, $args);
			}
		}
		return $ret;
	}
	
	static function find_nav_menu_item($id ,$nav_menu_items ) {
		if('' != $id){
			foreach ( $nav_menu_items as $nav_menu_item ) {
				if ($id == $nav_menu_item->object_id){
					return $nav_menu_item;
				}
			}
		}
		return false;
	}
	
	static function check_nav_menu_items($term , $menu_items ) {
		$match = false;
		foreach ($menu_items as $item ) {
			if ( $term->term_id == $item->object_id ) {
				$match = true;
				break;
			}
		}
		return $match;
	}
	static public function checkShopMenuItem(&$options, &$menu_opt){
		if(!isset($options['v_shop_item']) || 0 == $options['v_shop_item']){
			return false;
		}
		$options['v_shop_item'] = 0;
		if(!isset($menu_opt['v_menu_id']) || -1 == $menu_opt['v_menu_id']) return true;
		if(!isset($menu_opt['v_item_id'])) $menu_opt['v_item_id']= -1;
		$menu = wp_get_nav_menu_object($menu_opt['v_menu_id']);
		if(!isset($menu)) return true;
		$menu_items = wp_get_nav_menu_items($menu->term_id, array( 'post_status' => 'publish,draft' ));
		$page_id = WizShop_Pages::get_page_id(wizshopShopPageKey,$options['lang']);
		if(-1 == $page_id) return true;
		$menu_i = self::find_nav_menu_item(strval($page_id),$menu_items);
		if(!is_object($menu_i)) return true;
		$menu_opt['v_item_id'] = $menu_i->ID;
		return $menu_i;
	}
	
	static public function getSysMenus($excludeWizCat = true) {
		global $wizshop_cat_taxonomies;
		$menu_arr = array();
		$nav_menus = get_terms( 'nav_menu', array( 'hide_empty' => false ));
		foreach ( $nav_menus as $nav_menu ) {
			$menu_arr[ $nav_menu->term_id ] = array('name' => $nav_menu->name, 'items' =>array());
			$menuitems =  wp_get_nav_menu_items($nav_menu->term_id);
			foreach ( $menuitems as $nav_item ) {
				$todo = true;
				if($excludeWizCat){
					foreach ($wizshop_cat_taxonomies as $key => $tax) {
						if(isset($nav_item->object) && $nav_item->object == $tax['name']){
							$todo = false;
							break;
						}
					}
				}
				if($todo)
					$menu_arr[ $nav_menu->term_id ]['items'] [ $nav_item->ID ] = $nav_item->title ;
			}
		}
		return $menu_arr;
	}
	
	static public function menuSelection($args=""){
		$defaults = array(
			"depth" => false, 
			"meta" => false
		);
		$args = wp_parse_args( $args, $defaults );
		echo '<tr id="v_menu_con" class="v_ihide">';
		echo '<td width="150"><select id="v_menu_id_select"></select></td>';
		echo '<td width="150"><select id="v_menu_item_id_select"></select></td>';
		if($args["depth"]){
			echo '<td width="150"><select id="v_menu_depth_select"></select></td>';
		}
		if($args["meta"]){
			echo '<td width="150"><select id="v_menu_meta_select"></select></td>';
		}
		echo '<td width="50"><a href="javascript:void(0);" class="button" id="v_menu_close">';
		_e("Save");
		echo '</a></td>';

		echo '<td width="50"><a href="javascript:void(0);" class="button" id="v_menu_cancel">';
		_e("Cancel Edit");
		echo '</a></td></tr>';
	}

	static public  function add_shortcode_menus(&$items,$args) {
		if(defined('wizshopComponentsMenu')){
			self::add_components_menus($items,$args);
		}else {
			global  $wizshop_menu_settings;
			$menu_opt = wizshop_get_option($wizshop_menu_settings['name']);
			if(isset($args->menu) && isset($menu_opt) && isset($menu_opt[wizshopShortcodeMenu])){
				$arg_menu_id = is_object($args->menu) ? $args->menu->term_id : $args->menu;
				if(is_string($arg_menu_id)){
					$nav_menu = wp_get_nav_menu_object($arg_menu_id);
					if($nav_menu){
						$arg_menu_id = $nav_menu->term_id;
					}
				}			
				$index=-1;
				foreach ($menu_opt[wizshopShortcodeMenu] as $key => $mn ){
					$index++;
					if($arg_menu_id == $mn['v_menu_id']){
						self::setShortcodeMmenuItem($items,self::unique_code_id($index),$mn['v_menu_meta']);
					}
				}
			}
		}
	}
	
	static public  function prepare_shortcode_menus(&$items,$menu) {
		if(defined('wizshopComponentsMenu')){
			self::prepare_components_menus($items,$menu);
		}else{
			global  $wizshop_menu_settings;
			$menu_opt = wizshop_get_option($wizshop_menu_settings['name']);
			if(isset($menu_opt) && isset($menu_opt[wizshopShortcodeMenu])){
				$index=-1;
				foreach ($menu_opt[wizshopShortcodeMenu] as $key => $mn ){
					$index++;
					if($menu->term_id == $mn['v_menu_id']){
						if(0 >= $mn['v_item_id']){
							$item_count = count($items);
							$order = ($item_count <= 0) ? 1 : $items[$item_count-1]->menu_order+1;
							$items[] = self::codeMenuObj($order, 0, self::unique_code_id($index));
						}else{
							$item_count = count($items);
							for($i = 0; $i < $item_count;  ++$i) {
								if ( $mn['v_item_id'] == $items[$i]->ID ) {
									$parent_id = $items[$i]->menu_item_parent;
									for($k = $i+1 ; $k < $item_count;  $k++){
										if($items[$k]->menu_item_parent == $mn['v_item_id']){
											$i++;
										}else{
											break;
										}
									}
									$obj = self::codeMenuObj($items[$i]->menu_order+1, $parent_id, self::unique_code_id($index));
									array_splice($items, $i+1, 0, [$obj]);
									for($j = $i+2; $j < $item_count+1;  ++$j) {
										$items[$j]->menu_order++;
									}
									break;
								}
							}
						}
					}
				}
			}
		}
	}
	
	static function unique_code_id($index){
		return "v_menu_id_" .$index;
	}
	
	static function codeMenuObj($menu_order, $parent, $uniqe){
		return (object) array(
			'ID'                => 100000000 + $menu_order, 
			'title'             => "",
			'url'               => "",
			'menu_item_parent'  => $parent,
			'menu_order'        => $menu_order,
			'type'              => '',
			'object'            => '',
			'object_id'         => '',
			'db_id'             => '',
			'target'			=> '',
			'attr_title'		=> '',
			'nav_menu_term_id' 	=> 0,
			'original_title'   	=> '',
			'xfn'             	=> '',
			'description'      	=> '',
			'status'           	=> '',
			'_invalid'         	=> false,
			'classes'           => [$uniqe],
		);	
	}

	static function setShortcodeMmenuItem(&$location_items, $unique, $file_name, $offset = 0){
		$e_pos = false;
		if(!$file_name || "-1" == $file_name) return false;
		$shortcode = '[wizshop-element name=\'' . basename($file_name, ".php") . '\' is_component=\'1\']';
		$pos = strpos($location_items, $unique, $offset);
		if($pos !== false) {
			$s_pos = strripos($location_items,"<li",-(strlen($location_items)-$pos));
			$e_pos = stripos($location_items,"</li>",$s_pos);
			if($s_pos !== false && $e_pos !== false) {
				$item = do_shortcode($shortcode);
				if($item){
					$e_pos +=5;
					$location_items = substr_replace($location_items,$item, $s_pos, $e_pos-$s_pos);
				}
			}
		}
		
		return $e_pos;
	}
	
	static public function prepare_components_menus(&$items, $menu) {
		global $wizshop_component_posttype;
		foreach ($items as $item => $mn ){
			if($wizshop_component_posttype['name'] ==  $mn->object){
				if($pst = get_post(intval($mn->object_id))){
					$items[$item] = self::codeMenuObj($mn->menu_order, $mn->menu_item_parent, "v_cp_id_". $pst->post_name ); 
				}
			}
		}
	}
	
	static public function add_components_menus(&$items, $args) {
		global $wizshop_component_posttype;
		$psts = get_posts(array('post_type' => $wizshop_component_posttype['name']));
		foreach ( $psts as $pst ){
			$pos = 0;
			while($pos = self::setShortcodeMmenuItem($items, "v_cp_id_". $pst->post_name, $pst->post_name));
		}
	}	
	
	static public function remove_component_items( $all = false) {
		global $wizshop_component_posttype;
		global $wizshop_languages;
		$psts = get_posts(array('post_type' => $wizshop_component_posttype['name']));
		foreach ( $psts as $pst ){
			if($all){
				wp_delete_post($pst->ID, true);
			}else{
				$exist = false;
				foreach ($wizshop_languages as $lang){
					if("" != wizshop_include_path($pst->post_name, wizshopPluginComponents,wizshopStyleInclude,$lang)){
						$exist = true;
						break;
					}
				}
				if(!$exist){
					wp_delete_post($pst->ID, true);
				}				
			}
		}	
	}
	
	static  function shortcode_menus_to_components() {
		global  $wizshop_menu_settings;
		global $wizshop_component_posttype;
		
		$menu_opt = wizshop_get_option($wizshop_menu_settings['name']);
		
		if(isset($menu_opt) && isset($menu_opt[wizshopShortcodeMenu])){
			$upd = false;
			foreach (array_reverse($menu_opt[wizshopShortcodeMenu]) as $key => $mn ){
				$parent_id = 0;
				$post_name = basename($mn['v_menu_meta'],".php");
				$post_id = wizshop_is_component_post($post_name);
				
				if(!$post_id){
					$post_id = wizshop_insert_component_post($post_name);
					if(!$post_id) continue;
				}
			
				$items = wp_get_nav_menu_items($mn['v_menu_id']);
				$item_count = count($items);
				$pos = -1;
				if(0 >= $mn['v_item_id']){
					$pos = ($item_count <= 0) ? 1 : $item_count;
				}else{
					for($i = 0; $i < $item_count;  ++$i) {
						if ( $mn['v_item_id'] == $items[$i]->ID ) {
							$parent_id = $items[$i]->menu_item_parent;
							if(0 != $parent_id){
								for($k = $i+1 ; $k < $item_count;  $k++){
									if($items[$k]->menu_item_parent == $mn['v_item_id']){
										$i++;
									}else{
										break;
									}
								}
								$pos = $i+1;
							}else{
								$pos = $items[$i]->menu_order+1;
							}
							break;
						}
					}//for
				}
				if(-1 !=$pos){
					wp_update_nav_menu_item($mn['v_menu_id'], 0, array(
						'menu-item-title' => $post_name,
						'menu-item-object-id' => $post_id,
						'menu-item-object' => $wizshop_component_posttype['name'],
						'menu-item-status' => 'publish',
						'menu-item-type' => 'post_type',
						'menu-item-position'=> $pos,
						'menu-item-parent-id' => $parent_id,
						'menu-item-classes' => "v_cp_id_". $post_name
						));	
					
					$upd = true;
				}
			}
			if($upd){
				unset($menu_opt[wizshopShortcodeMenu]);
				update_option($wizshop_menu_settings['name'],$menu_opt);
			}
		}
	}
	
	static function check_component_items() {
		
		self::remove_component_items();
		
		$file_arr = array();
		foreach( glob( wizshopPluginComponents.'/*.php') as $sh_file ){
			$file_arr[] =  basename($sh_file,".php");
		} 	
		$file_arr = apply_filters( 'wizshop_component_items', $file_arr );
		foreach( $file_arr as $cp ){
			if(!wizshop_is_component_post($cp)){
				wizshop_insert_component_post($cp);
			}
		} 	
		return $file_arr;	
	}

};
new WizShop_Menus(); 
?>