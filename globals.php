<?php   
if ( ! defined( 'ABSPATH' ) ) exit; 

//globals	
global $wizshop_cur_lang;
global $wizshop_languages;	
global $wizshop_support_lang;
global $wizshop_is_multi_lang;
global $wizshop_pages;
global $wizshop_template_page_keys;
global $wizshop_cat_view;

global $wizshop_posttype;
global $wizshop_product_posttype;
global $wizshop_component_posttype;
global $wizshop_cat_taxonomies;

global $wizshop_settings;
global $wizshop_media_settings;
global $wizshop_manage_settings;
global $wizshop_menu_settings;
global $wizshop_view_settings;
global $wizshop_plugin_settings;
global $wizshop_image_settings;
global $wizshop_customers;
global $wizshop_upload_path;
if(is_admin()){
	global $wizshop_disp_type;
}

$wizshop_languages = array();

$wizshop_support_lang = array(wizshop_lang_he => array('label' => __('Hebrew', WizShop) ), 
								wizshop_lang_en => array('label' => __('English', WizShop)), 
								);
							
$wizshop_cat_view = array('grid' => array( 'value' => 1, 'label' => __('Grid', WizShop)),
							'table' => array( 'value' => 2,  'label' => __('Table', WizShop)),
							'lines' => array( 'value' => 4, 'label' => __('Lines', WizShop)),
							);
					
$wizshop_cat_taxonomies = array(
	wizshop_lang_he => array(
		'name' => 'wizshop_categories_he',
		'slug' => 'קטגוריות',
		'settings'=> array('name'=>'wizshop_cat_settings_he',
					'defaults' => array("cat_shop_id"=>"","lang"=>wizshop_lang_he,"taxonomy"=>"wizshop_categories_he", 
					"last_update"=>"","v_menu_id"=>-1, "v_item_id"=>-1, "v_menu_depth"=>2, 'view_options'=> 7, 'v_img_upd' =>1)),
		'lang' => wizshop_lang_he,
		'ui_name' => __('WizShop - Hebrew Categories',WizShop),
		'ui_menu_name' => __('Hebrew Categories',WizShop),
		'ui_singular_name' => __('Category',WizShop),
	),
	wizshop_lang_en => array(
		'name' => 'wizshop_categories_en',
		'slug' => 'categories',
		'settings'=> array('name'=>'wizshop_cat_settings_en',
					'defaults' => array("cat_shop_id"=>"","lang"=>wizshop_lang_en,"taxonomy"=>"wizshop_categories_en", 
					"last_update"=>"","v_menu_id"=>-1, "v_item_id"=>-1, "v_menu_depth"=>2, 'view_options'=> 7)),
		'lang' => wizshop_lang_en,
		'ui_name' => __('WizShop - English Categories',WizShop),
		'ui_menu_name' => __('English Categories',WizShop),
		'ui_singular_name' => 'Category',
	),	
);
	
$wizshop_posttype =	array(
		'ui_name' => __('WizShop',WizShop),
		'ui_singular_name' =>  __('WizShop',WizShop)	
	);

$wizshop_component_posttype =	array(
		'name' => 'wizshop_components',
		'ui_name' => __('WizShop Components',WizShop),
		'ui_singular_name' =>  __('WizShop Components',WizShop)	
);

	
$wizshop_product_posttype = array(
	wizshop_lang_he => array(
		'name' => 'wizshop_products_he',
		'slug' => 'מוצרים',
		'lang' => wizshop_lang_he,
		'ui_name' => __('Products',WizShop),
		'ui_singular_name' => __('Product',WizShop),
	),
	wizshop_lang_en => array(
		'name' => 'wizshop_products_en',
		'slug' => 'products',
		'lang' => wizshop_lang_en,
		'ui_name' => 'Products',
		'ui_singular_name' => 'Product',
	),
);	
	
$wizshop_settings = array(
		'name' => 'wizshop_settings',
		'defaults' => array("shop_server"=>"","shop_id"=>"", "shop_pass"=>"", "shop_lang"=>"he", "shop_lang2"=>"-1", 
							"wiz_search" =>0, "shipping" =>1, "default_css" => -1, "guests" => 0, 
		),
	);	

$wizshop_media_settings = array(
		'name' => 'wizshop_media_settings',
		'defaults' => array(	
			"grid_w"=>300, 	"grid_h"=>300,	"grid_crop"=>1,
			"product_w"=>500,	"product_h"=>500,	"product_crop"=>1,
			"thumb_w"=>100,	"thumb_h"=>100,	"thumb_crop"=>1,
			"cat_w"=>300, 	"cat_h"=>300, "cat_crop"=>1
		),
	);	
	
$wizshop_menu_settings = array(
		'name' => 'wizshop_menu_settings',
		'defaults' => array(wizshopShortcodeMenu => array()),
	);		

if(is_admin()){
$wizshop_disp_type	= array(
		"desktop" =>  array('ui_name' => __('Desktop',WizShop), "num_in_line" => [1,2,3,4,6]), 
		"tablet" =>   array('ui_name' => __('Tablet',WizShop),  "num_in_line" => [1,2,3,4]),
		"mobile" =>   array('ui_name' => __('Mobile',WizShop),  "num_in_line" => [1,2]),
	);
}

$wizshop_view_settings = array(
		'name' => 'wizshop_view_settings',
		'defaults' => array(
			/*SEO flags (doc_title)
				0-none, 	
				1-set title on categories, 
				2-set title on product, 
				4-set product desc on meta description tag
				8-use extended product url
				16-set og meta tags
			*/
			"doc_title"	=> 3, 		
			/*sidebar_pages
				not in use
			*/
			"sidebar_pages"	=> 0, 		
			/* products_view                                          
					desktop
					tablet
					mobile
						gallery_line:  products number in line, lines page                   
						lines_page  :  products number in lines page
						gallery_page:  products number in gallery page
						table_page  :  products number in table page
						navigation  :  0-none, 1-pagination , 2-button, 4-scrolling
						sidebar  	:  0-none, 1-shop, 2-grid, 4-product
						quick_view	:  0-disabled, 1-enabled (default)
						top_filter	:  0- default filter (default), 1- show top filter 
						min_quick_view:0-disabled, 1-enabled (default)
						
					last  		:  last updated products view
			*/
			"products_view" => array(
				"desktop" => array("gallery_line" => 4, "gallery_page" => 16, "table_page" => 20, "lines_page" => 15, "navigation" => 1, 
									"sidebar" => 7, "quick_view" => 1, "top_filter" => 0, "min_quick_view" => 1),
				"tablet" =>  array("gallery_line" => 3, "gallery_page" => 12, "table_page" => 20, "lines_page" => 15, "navigation" => 4,
									"sidebar" => 7, "quick_view" => 1, "top_filter" => 0, "min_quick_view" => 1),
				"mobile" =>  array("gallery_line" => 2, "gallery_page" => 12, "table_page" => 20, "lines_page" => 15, "navigation" => 4,
									"sidebar" => 7, "quick_view" => 1, "top_filter" => 0, "min_quick_view" => 1),
				"last" => "desktop",
				),
				
			/*use WP media for item gallery (0 - default) */
			"item_gallery"	=> 0, 		
			),
	);		
	
$wizshop_plugin_settings = array(
		'name' => 'wizshop_plugin_settings',
		'defaults' => array("version" => 0)
	);		
	
$wizshop_image_settings = array(
		'name' => 'wizshop_image_settings',
		'defaults' => array("def_img_id" => 0)
	);	
	
$wizshop_customers = array(
	wizshop_lang_he => array(
		'settings'=> array(
			'name'=>'wizshop_customers_settings_he',
			'defaults' => array(
				"b2b_link_text"=>"לקוחות עסקיים",
				"b2b_checkout_text"=>"לקוחות עסקיים",
				"b2c_link_text"=>"לקוחות פרטיים", 
				"b2c_checkout_text"=>"לקוחות פרטיים",
				"agents_link_text"=>"סוכנים", 
				"agents_checkout_text"=>"סוכנים",
				"b2c_donor_text"=>"תרומה לקוח פרטי", 
				"b2b_donor_text"=>"תרומה לקוח עסקי", 
			)
		),
	),
	wizshop_lang_en => array(
		'settings'=> array(
			'name'=>'wizshop_customers_settings_en',
			'defaults' => array(
				"b2b_link_text"=>"Business Customers",
				"b2b_checkout_text"=>"Business Customers",
				"b2c_link_text"=>"Private Customers", 
				"b2c_checkout_text"=>"Private Customers",
				"agents_link_text"=>"Salesperson", 
				"agents_checkout_text"=>"Salespersons",
				"b2c_donor_text"=>"Private Customer Donation", 
				"b2b_donor_text"=>"Business Customer Donation", 
			)
		),
	),	
);		
$wizshop_manage_settings = array(
		$wizshop_settings, 
		$wizshop_cat_taxonomies[wizshop_lang_he]['settings'],
		$wizshop_cat_taxonomies[wizshop_lang_en]['settings'],
		$wizshop_media_settings,
		$wizshop_menu_settings,
		$wizshop_view_settings,
		$wizshop_plugin_settings,
		$wizshop_image_settings,
		$wizshop_customers[wizshop_lang_he]['settings'],
		$wizshop_customers[wizshop_lang_en]['settings']
	);
		
$wizshop_template_page_keys = ['single-product', 'archive-product', 'search-product']; 
	
$wizshop_pages = array(
		'my-cart' => array(
			wizshop_lang_he => array(
				'slug' => 'סל-קניות',
				'title' => 'סל קניות',
			),
			wizshop_lang_en => array(
				'slug' => 'my-cart',
				'title' => 'Shopping Cart',
			),
			'template' => false,
			'use_shortcode' => true
		),
		'sign-in' => array(
			wizshop_lang_he => array(
				'slug' => 'כניסה-למערכת',
				'title' => 'כניסה למערכת',
			),
			wizshop_lang_en => array(
				'slug' => 'sign-in',
				'title' => 'Sign In',
			),
			'template' => false,
			'use_shortcode' => true
		),
		'sign-in-b2b' => array(
			wizshop_lang_he => array(
				'slug' => 'כניסה-למערכת-עסקיים',
				'title' => 'כניסה למערכת - לקוחות עסקיים',
			),
			wizshop_lang_en => array(
				'slug' => 'sign-in-b2b',
				'title' => 'Sign In - Business Customer',
			),
			'template' => false,
			'use_shortcode' => true
		),
		'user-details' => array(
			wizshop_lang_he => array(
				'slug' => 'פרטי-לקוח',
				'title' => 'פרטי לקוח',
			),
			wizshop_lang_en => array(
				'slug' => 'user-details',
				'title' => 'User Details',
			),
			'template' => false,
			'use_shortcode' => true
		),
		'b2b-customer' => array(
			wizshop_lang_he => array(
				'slug' => 'לקוחות-עסקיים',
				'title' => 'לקוחות עסקיים',
			),
			wizshop_lang_en => array(
				'slug' => 'b2b-customer',
				'title' => 'Business Customers',
			),
			'template' => false,
			'use_shortcode' => false /*!!!*/
		),				
		'wish-list' => array(
			wizshop_lang_he => array(
				'slug' => 'קניה-מאוחרת',
				'title' => 'רשימת משאלות',
			),
			wizshop_lang_en => array(
				'slug' => 'wish-list',
				'title' => 'Wish List',
			),
			'template' => false,
			'use_shortcode' => true
		),
		'past-purchases' => array(
			wizshop_lang_he => array(
				'slug' => 'קניות-קודמות',
				'title' => 'קניות קודמות',
			),
			wizshop_lang_en => array(
				'slug' => 'past-purchases',
				'title' => 'Past Purchase',
			),
			'template' => false,
			'use_shortcode' => true
		),
		'permanent-cart' => array(
			wizshop_lang_he => array(
				'slug' => 'סל-קבוע',
				'title' => 'סל קבוע',
			),
			wizshop_lang_en => array(
				'slug' => 'permanent-cart',
				'title' => 'Permanent Cart',
			),
			'template' => false,
			'use_shortcode' => true
		),
		'purchase' => array(
			wizshop_lang_he => array(
				'slug' => 'רכישה',
				'title' => 'רכישה',
			),
			wizshop_lang_en => array(
				'slug' => 'purchase',
				'title' => 'Purchase',
			),
			'template' => false,
			'use_shortcode' => true
		),
		'donations' => array(
			wizshop_lang_he => array(
				'slug' => 'תרומות',
				'title' => 'תרומות',
			),
			wizshop_lang_en => array(
				'slug' => 'donations',
				'title' => 'Donations',
			),
			'template' => false,
			'use_shortcode' => true
		),	
		'v-shop' => array(
			wizshop_lang_he => array(
				'slug' => 'חנות',
				'title' => 'חנות',
			),
			wizshop_lang_en => array(
				'slug' => 'v-shop',
				'title' => 'Shop',
			),
			'template' => false,
			'use_shortcode' => true
		),
		'cart-call' => array(
			wizshop_lang_he => array(
				'slug' => 'פרטי-התקשרות',
				'title' => 'פרטי התקשרות',
			),
			wizshop_lang_en => array(
				'slug' => 'cart-call',
				'title' => 'Contact Details',
			),
			'template' => false,
			'use_shortcode' => true
		),
		'checkout-final' => array(
			wizshop_lang_he => array(
				'slug' => 'סיום-רכישה',
				'title' => 'סיום רכישה',
			),
			wizshop_lang_en => array(
				'slug' => 'checkout',
				'title' => 'Checkout',
			),
			'template' => false,
			'use_shortcode' => true
		),
		'reports-acc' => array(
			wizshop_lang_he => array(
				'slug' => 'כרטסת-חשבונות',
				'title' => 'כרטסת הנהלת חשבונות',
			),
			wizshop_lang_en => array(
				'slug' => 'acc-report',
				'title' => 'Accounting Statement',
			),
			'template' => false,
			'use_shortcode' => true
		),
		'reports-item' => array(
			wizshop_lang_he => array(
				'slug' => 'דוח-פריט',
				'title' => 'דוח תנועות פריט',
			),
			wizshop_lang_en => array(
				'slug' => 'item-report',
				'title' => 'Item Transactions',
			),
			'template' => false,
			'use_shortcode' => true
		),
		'user-area' => array(
			wizshop_lang_he => array(
				'slug' => 'איזור-אישי',
				'title' => 'איזור אישי',
			),
			wizshop_lang_en => array(
				'slug' => 'personal-area',
				'title' => 'Personal Area',
			),
			'template' => false,
			'use_shortcode' => true
		),	
		'single-product' => array(
			wizshop_lang_he => array(
				'slug' => 'תבנית-מוצר',
				'title' => 'תבנית מוצר',
			),
			wizshop_lang_en => array(
				'slug' => 'single-product',
				'title' => 'Product Template',
			),
			'template' => false,
			'use_shortcode' => true
		),	
		'archive-product' => array(
			wizshop_lang_he => array(
				'slug' => 'תבנית-מוצרים',
				'title' => 'תבנית מוצרים',
			),
			wizshop_lang_en => array(
				'slug' => 'archive-product',
				'title' => 'Products Template',
			),
			'template' => false,
			'use_shortcode' => true
		),	
		'search-product' => array(
			wizshop_lang_he => array(
				'slug' => 'תבנית-חיפוש',
				'title' => 'תבנית חיפוש מוצרים',
			),
			wizshop_lang_en => array(
				'slug' => 'search-product',
				'title' => 'Search Products Template',
			),
			'template' => false,
			'use_shortcode' => true
		),	
		'agents' => array(
			wizshop_lang_he => array(
				'slug' => 'סוכנים',
				'title' => 'סוכנים',
			),
			wizshop_lang_en => array(
				'slug' => 'salespersons',
				'title' => 'Salespersons',
			),
			'template' => false,
			'use_shortcode' => true
		),	
	);
	
	$upload_dir = wp_upload_dir();
	$wizshop_upload_path = array('dir' => $upload_dir['basedir'].'/wizshop',
							  'url' => $upload_dir['baseurl'].'/wizshop');
?>