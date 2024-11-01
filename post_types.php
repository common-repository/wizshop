<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/*-----------------------*/ 
/* class  WizShop_PostTypes */
/*-----------------------*/ 
class WizShop_PostTypes {
	public function __construct() {
		add_action( 'init', array( $this, 'create_taxonomies' ), 0 );
		add_action( 'init', array( $this, 'create_post_types' ), 0 );
		add_filter('query_vars', array( $this, 'add_query_vars' ));
		add_action('rewrite_rules_array', array( $this, 'add_rewrite_rules' ));
	}		
		
	static public function create_taxonomies() {
		global $wizshop_cat_taxonomies;
		foreach ($wizshop_cat_taxonomies as $key => $tax) {
			if(!taxonomy_exists($tax['name']) && wizshop_is_shop_lang($key)) {
				register_taxonomy($tax['name'], wizshopShopPostType, array(
					'labels' => array(
						'name' => translate($tax['ui_name'],WizShop),
						'singular_name' =>  translate($tax['ui_singular_name'],WizShop),
						'menu_name'		=>  translate($tax['ui_menu_name'],WizShop),
					),
					'show_ui' => wizshop_is_shop_lang($key),
					'show_in_menu' => false,
					'show_in_nav_menus' => true,
					'show_tagcloud' => false,
					'hierarchical' => true,
					'rewrite' => array(
						'slug' => $tax['slug'], 
						'hierarchical' => true
						)
				));	
			}
		}
		add_filter('pll_get_taxonomies', array('WizShop_PostTypes', 'pll_add_tax' ));		
	}

	static function pll_add_tax($taxonomies) {
		global $wizshop_cat_taxonomies;
		foreach ($wizshop_cat_taxonomies as $key => $tax ) {
			$taxonomies[$tax['name']] = $tax['name'];
		}
		return $taxonomies;
	}
	
	
	static public function create_post_types() {
		global $wizshop_product_posttype;
		global $wizshop_posttype;
		global $wizshop_component_posttype;
	
		foreach ($wizshop_product_posttype as $key => $pst ) {
			if(!post_type_exists($pst['name']) && wizshop_is_shop_lang($key)){
				register_post_type($pst['name'], array(
				'labels' => array(
				'name' =>  translate($pst['ui_name'],WizShop),
				'singular_name' => translate($pst['ui_singular_name']),
				),
			   'public' => true,
				'has_archive' => true,
				'hierarchical'  => false,
				'publicly_queryable' 	=> true,
				'query_var'  => true,
				'show_ui' => false,
				'show_in_nav_menus' => false,
				'rewrite' =>  array( 'slug' => $pst['slug'] ),
				));
			}
		}
		
		if(!post_type_exists(wizshopShopPostType)){
			register_post_type(wizshopShopPostType, array(
			'labels' => array(
				'name' =>  translate($wizshop_posttype['ui_name'],WizShop),
				'singular_name' =>  translate($wizshop_posttype['ui_singular_name'],WizShop),
			),
		   'public' => true,
			'has_archive' => false,
			'hierarchical'  => false,
			'publicly_queryable' 	=> true,
			'query_var'  => true,
			'show_ui' => true,
			'show_in_nav_menus' => false,
			'supports' => array('title'),
			'show_in_menu'	=> true,
			'menu_icon' => 'dashicons-cart'
			));
		}
		
		if( defined('wizshopComponentsMenu') && !post_type_exists($wizshop_component_posttype['name'])){
			register_post_type($wizshop_component_posttype['name'], array(
			'labels' => array(
				'name' =>  translate($wizshop_component_posttype['ui_name'],WizShop),
				'singular_name' =>  translate($wizshop_component_posttype['ui_singular_name'],WizShop),
			),
		   'public' => true,
			'has_archive' => false,
			'hierarchical'  => false,
			'publicly_queryable' => true,
			'query_var'  => true,
			'show_ui' => false,
			'show_in_nav_menus' => true,
			'supports' => array('title'),
			'show_in_menu'	=> true,
			));
		}
		
		add_filter('pll_get_post_types', array('WizShop_PostTypes', 'pll_add_post_types' ));;		
	}
	
	static function pll_add_post_types($posts) {
		global $wizshop_product_posttype;
		global $wizshop_component_posttype;
		foreach ($wizshop_product_posttype as $key => $pst ) {
			$posts[$pst['name']] = $pst['name'];
		}
		$posts[wizshopShopPostType] = wizshopShopPostType;
		if(defined('wizshopComponentsMenu')){
			$posts[$wizshop_component_posttype['name']] = $wizshop_component_posttype['name'];
		}
		return $posts;
	}
	
	function add_rewrite_rules($rules) {
		$newrules = array();
		global $wizshop_product_posttype;
		foreach ($wizshop_product_posttype as $key => $pst ) {
			$newrules[$pst['slug'].'/(.*/?)$'] = 'index.php?post_type='. $pst['name'].'&'.wizshop_product_tag.'=$matches[1]';
		}
		return $newrules + $rules;
	}		
	
	function add_query_vars($vars) {
		array_push($vars, wizshop_product_tag, wizshop_id_qvar, wizshop_view_qvar,
			wizshop_filter_qvar, wizshop_count_qvar, 'new');
		return $vars;
	}
}
new WizShop_PostTypes();

?>