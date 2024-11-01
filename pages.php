<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/*----------------------------*/ 
/* class  WizShop_Pages	 	  */
/*----------------------------*/ 
class WizShop_Pages {
	
	public function __construct() {
	}
	
	public static function get_page_id($key, $lang=''){
		if(!$lang){
			$lang = wizshop_cur_lang();
		}
		$id = self::get_user_page_option($key, $lang);
		return !$id  ? -1 : $id;
	}
	
	public static function get_page_url($key) {
		$id = self::get_page_id($key);
		return  ($id != -1) ? get_permalink($id) : '';
	}
	
	public static function page_option_key($key){
		return 'wizshop_' . $key . '_page_id';
	}

	public static function get_page_option($key, $lang){
		$page_op = get_option(self::page_option_key($key));
		return isset($page_op[$lang]) ? intval($page_op[$lang]) : -1;
	}

	public static function get_user_page_option($key, $lang){
		$page_op = get_option(self::user_page_option_key($key, $lang));
		return !$page_op  ? false : intval($page_op);
	}

	static function user_page_option_key($key, $lang){
		return 'wizshop_' . $key . '_user_page_id_' . $lang ;
	}
	
	public static function create_pages() {
		global $wizshop_pages;
		foreach ($wizshop_pages as $key => $val ) {
			self::create_page($key, $val);
		}
	}

	public static function create_page($name, $page){
		global $wizshop_languages;
		$option_key = self::page_option_key($name);
		$page_op = get_option($option_key);
		$write = false;
		
		//check old ver
		if(isset($page_op) && !is_array($page_op)){
			$page_op = array(wizshop_lang_he => $page_op);
			$write = true;
		}
			
		foreach ($wizshop_languages as $lang){
			$p_lang = "";
			if(!array_key_exists($lang,$page) || !is_array($page[$lang]) 
				 ||!array_key_exists('slug', $page[$lang])){
				continue;
			}
			
			$slug = $page[$lang]['slug'];
			$title = $page[$lang]['title'];
			$use_shortcode = $page['use_shortcode'];
			$template_file = $page['template'];
			
			$exist = self::is_page_exist($slug);
			
			$page_op_id = array_key_exists($lang,$page_op) ? $page_op[$lang] : false;
			if($page_op_id){
				$stat = get_post_status($page_op_id);
				if($stat){
					if($stat =='trash'){
						wp_delete_post($page_op_id,true);
						$page_op[$lang] = $page_op_id = -1;
					}else{
						if(function_exists('pll_get_post_language')){
							$p_lang = pll_get_post_language($page_op_id);
						}
					}
				}
			}

			if ( $exist){
				if(!$page_op_id || ($page_op_id != $exist)) {
					$page_op[$lang] = $exist;
					if(!$use_shortcode && $template_file){
						self::set_page_meta($page_op[$lang], $name, $lang);
					}
					$write = true;
					if (function_exists('pll_set_post_language')){
						pll_set_post_language($page_op[$lang],$lang);
					}					
				}else if($lang != $p_lang){
					$write = true;
					if (function_exists('pll_set_post_language')){
						pll_set_post_language($page_op[$lang],$lang);
					}					
				}
			}else {
				$content = ($use_shortcode) ? ('[wizshop-element name=\'' . $name . '\' lang=\'' .$lang. '\']') : "";
				$post = array(
					'post_title' 	=> $title,
					'post_name' 	=> $slug,
					'post_content' 	=> $content,
					'post_status' 	=> "publish",
					'post_type' 	=> 'page',
					'comment_status' => 'closed',
					'post_author'  	=> 1,
					'post_parent'  	=> 0,			
				);
				$page_op_id = wp_insert_post($post);
				if ($page_op_id && !is_wp_error($page_op_id)){
					if(!$use_shortcode && $template_file){
						self::set_page_meta($page_op_id, $name, $lang);
					}
					$page_op[$lang] = $page_op_id;
					$write = true;
					if (function_exists('pll_set_post_language')){
						pll_set_post_language($page_op_id,$lang);
					}					
				}
			}
		}
		if($write){
			update_option($option_key, $page_op);
			if (sizeof($page_op) > 0 && function_exists('pll_save_post_translations')){
				pll_save_post_translations($page_op);
			}					
		}
		return ;
	}

	static function set_user_pages($ver, $remove = false){
		global $wizshop_pages;
		global $wizshop_template_page_keys;
		foreach ($wizshop_pages as $key => $langs ) {
			foreach ($langs as $lang => $info ) {
				if(wizshop_is_shop_lang($lang)){
					$user_op_name = self::user_page_option_key($key, $lang);
					if(!$remove){
						$user_page_op = get_option($user_op_name);
						if(!$user_page_op){
							if($ver > 0 && $ver < 2.0 && in_array($key, $wizshop_template_page_keys)){
								update_option($user_op_name, -1); 
							}else{
								update_option($user_op_name,self::get_page_option($key, $lang));
							}
						}
					}else{
						delete_option($user_op_name);
					}
				}
			}
		}
	}

	//see wizshop_include_path() in functions.php
	static function set_page_meta($page_id, $name, $lang ){
		$file = $name.'.php';
		$part = '';
		if(file_exists(wizshopStyleInclude . '/' . $lang . '/' . $file )){
			$part = wizshop_include_part($lang) . $file;
		}else if(file_exists(wizshopStyleInclude . '/' . $file )){
			$part = wizshop_include_part() .$file;
		}
		if($part){
			update_post_meta($page_id, "_wp_page_template",$part);
		}
	}
	
	public static function is_page_exist($page_slug){
		$exist = false;
		$posts = get_posts(array(
            'name' => $page_slug,
            'posts_per_page' => 1,
            'post_type' => 'page',
			'post_status' => 'publish',
		));
		if($posts){
			$page = $posts[0];
			if(isset($page->ID)){
				$exist = intval($page->ID);
			}
		}
		return $exist;
	}
	

	public static function remove_pages() {
		global $wizshop_pages;
		foreach ($wizshop_pages as $key => $val) {
			$option_key = self::page_option_key($key);
			$page_op = get_option($option_key);
			//check old ver
			if(!is_array($page_op)){
				if ($page_op > 0){
					wp_delete_post($page_op,true);
				}
			}else{
				foreach ($page_op as $lang => $op){
					if ($op > 0){
						wp_delete_post($op,true);
					}
				}
			}
			delete_option($option_key);
		}
	}
	
};

/*----------------------------*/ 
/* helpers					  */
/*----------------------------*/ 

//------------------------------------------------------------
function wizshop_get_ref($ignore_arr){
	$ret = '';
	$url = wizshop_current_page_url();
	parse_str(parse_url($url,PHP_URL_QUERY), $result);
	if(isset($result) && isset($result['ref']) && $result['ref'] != ''){
		$ret = 'ref=' . wizshop_ref_filter($result['ref'], $ignore_arr);
	}else{
		$ref_path = str_replace(parse_url(home_url(),PHP_URL_PATH),'',parse_url($url,PHP_URL_PATH) );
		$ret = 'ref=' . wizshop_ref_filter($ref_path, $ignore_arr);
	}
	return $ret;
}
//------------------------------------------------------------
function wizshop_ref_filter($ref, $ignore_arr){
	$ret = '/';
	if($ref){
		if(!is_array($ignore_arr)){
			$ret = $ref;
		}else{
			$arr = explode('~',substr($ref,1));
			if(null !== ($page = array_shift($arr))){
				$skip_key = false;
				foreach($ignore_arr as $key) {
					$key = wizshop_get_page_slug($key);
					if($key){
						$key = rawurlencode($key);
						if(0 == strcasecmp($key, $page)){
							$skip_key = true;
							break;
						}
					}
				}
				if(!$skip_key){
					$ret .=  $page;
				}
			}
			if(count($arr) > 0){
				if($ret != '/'){
					$ret .=  '~';
				}
				$ret .= implode('~',$arr);
			}
		}
	}
	return $ret;
}
//------------------------------------------------------------
function wizshop_get_page_info($wiz_page_key){
	global $wizshop_pages;
	foreach ($wizshop_pages as $key => $val) {
		if($key == $wiz_page_key){
			return $val;
		}
	}
	return false;
}
//------------------------------------------------------------
function wizshop_get_page_slug($wiz_page_key){
	$page_inf = wizshop_get_page_info($wiz_page_key);
	return ($page_inf)?  $page_inf[wizshop_cur_lang()]['slug'] : false;
}

//------------------------------------------------------------
if ( ! function_exists( 'wizshop_current_page_url' ) ) {
function wizshop_current_page_url() {
  global $wp;
  return add_query_arg( $_SERVER['QUERY_STRING'], '', home_url( $wp->request ) );
}
}
//------------------------------------------------------------
//products
if (!function_exists('wizshop_get_products_url') ){
function wizshop_get_products_url($lang='') {
	global $wizshop_product_posttype;	
	if(!$lang){
		$lang = wizshop_cur_lang();
	}
	return get_post_type_archive_link((isset($wizshop_product_posttype[$lang]) ? 
					$wizshop_product_posttype[$lang]['name'] : ''));
}
}
//------------------------------------------------------------
//categories
if (!function_exists('wizshop_get_category_url') ){
function wizshop_get_category_url($lang='') {
	global $wizshop_cat_taxonomies;	
	if(!$lang){
		$lang = wizshop_cur_lang();
	}
	return trailingslashit(site_url()) . (isset($wizshop_cat_taxonomies[$lang]) ? 
					$wizshop_cat_taxonomies[$lang]['slug'] .'/' : '');
}
}
//------------------------------------------------------------
//cart
if (!function_exists('wizshop_cart_page')){
function wizshop_cart_page() {
	return is_page(WizShop_Pages::get_page_id('my-cart'));
}
}

if (!function_exists('wizshop_get_cart_url')){
function wizshop_get_cart_url() {
	return WizShop_Pages::get_page_url('my-cart');
}
}
//------------------------------------------------------------
//signin
if (!function_exists('wizshop_signin_page')){
function wizshop_signin_page() {
	return is_page(WizShop_Pages::get_page_id('sign-in'));
}
}

if (!function_exists('wizshop_get_signin_url')){
function wizshop_get_signin_url($getRefernce = true) {
	$qr = ($getRefernce) ? wizshop_get_ref(['sign-in', 'sign-in-b2b']) : '';
	if($qr!='') $qr = "?" . $qr;
	return WizShop_Pages::get_page_url('sign-in') . $qr;
}
}
//------------------------------------------------------------
//signinb2b
if (!function_exists('wizshop_signin_b2b_page')){
function wizshop_signin_b2b_page() {
	return is_page(WizShop_Pages::get_page_id('sign-in-b2b'));
}
}
if (!function_exists('wizshop_get_signin_b2b_url')){
function wizshop_get_signin_b2b_url($getRefernce = true) {
	$qr = ($getRefernce) ? wizshop_get_ref(['sign-in-b2b', 'sign-in']) : '';
	if($qr!='') $qr = "?" . $qr;
	return WizShop_Pages::get_page_url('sign-in-b2b') . $qr;
}
}
//------------------------------------------------------------
//user-details
if (!function_exists('wizshop_user_details_page')){
function wizshop_user_details_page() {
	return is_page(WizShop_Pages::get_page_id('user-details'));
}
}
//new user-details
if (!function_exists('wizshop_new_user_details_page')){
function wizshop_new_user_details_page() {
	return wizshop_user_details_page() && ('1' == get_query_var('new'));
}
}
if (!function_exists('wizshop_get_user_details_url')){
function wizshop_get_user_details_url($getRefernce = true) {
	$reg = wizshop_is_reg_customer();
	$qr = ($getRefernce) ? wizshop_get_ref(['user-details','sign-in-b2b', 'sign-in']) : '';
	if($qr!='') $qr = "?" . $qr;
	if(!$reg){
		$qr .= ($qr =='') ? '?new=1' : '&new=1';
	}	
	return WizShop_Pages::get_page_url('user-details'). $qr;
}
}
//------------------------------------------------------------
//wish-list
if (!function_exists('wizshop_wish_list_page')){
function wizshop_wish_list_page() {
	return is_page(WizShop_Pages::get_page_id('wish-list'));
}
}

if (!function_exists('wizshop_get_wish_list_url')){
function wizshop_get_wish_list_url() {
	return WizShop_Pages::get_page_url('wish-list');
}
}
//------------------------------------------------------------
//past-purchases
if (!function_exists('wizshop_past_purchases_page')){
function wizshop_past_purchases_page() {
	return is_page(WizShop_Pages::get_page_id('past-purchases'));
}
}

if (!function_exists('wizshop_get_past_purchases_url')){
function wizshop_get_past_purchases_url() {
	return WizShop_Pages::get_page_url('past-purchases');
}
}
//------------------------------------------------------------
//permanent-cart
if (!function_exists('wizshop_permanent_cart_page')){
function wizshop_permanent_cart_page() {
	return is_page(WizShop_Pages::get_page_id('permanent-cart'));
}
}

if (!function_exists('wizshop_get_permanent_cart_url')){
function wizshop_get_permanent_cart_url() {
	return WizShop_Pages::get_page_url('permanent-cart');
}
}
//------------------------------------------------------------
//purchase
if (!function_exists('wizshop_purchase_page')){
function wizshop_purchase_page() {
	return is_page(WizShop_Pages::get_page_id('purchase'));
}
}

if (!function_exists('wizshop_get_purchase_url')){
function wizshop_get_purchase_url() {
	$purch_slug = wizshop_get_page_slug('purchase');
	if(!wizshop_is_reg_customer()){
		$user_slug = wizshop_get_page_slug('user-details');
		return wizshop_get_signin_url(false). '?ref=/'.$user_slug. '~'. $purch_slug;
	}else if(wizshop_is_b2b_customer()){
		if(wizshop_b2b_customer_details()< 2){
			return WizShop_Pages::get_page_url('purchase');
		}
	}
	return wizshop_get_user_details_url(false) . '?ref=/'.$purch_slug;
}
}
//------------------------------------------------------------
//donations
if (!function_exists('wizshop_donations_page')){
function wizshop_donations_page() {
	return is_page(WizShop_Pages::get_page_id('donations'));
}
}

if (!function_exists('wizshop_get_donations_url')){
function wizshop_get_donations_url() {
	return WizShop_Pages::get_page_url('donations');
}
}
//------------------------------------------------------------
//donor-details
if (!function_exists('wizshop_donor_details_page')){
function wizshop_donor_details_page() {
	return false; //version 2.1.3
}
}
if (!function_exists('wizshop_get_donor_details_url')){
function wizshop_get_donor_details_url($getRefernce = true) {
	return ""; //version 2.1.3
}
}
//------------------------------------------------------------
//reference url
if (!function_exists('wizshop_get_reference_url')){
function wizshop_get_reference_url($ignore_arr = null) {
	$ret = '';
	$url = wizshop_current_page_url();
	parse_str(parse_url($url,PHP_URL_QUERY), $result);
	$cur_page = rawurldecode(basename(get_permalink()));
	if(isset($result) && isset($result['ref']) && $result['ref'] != ''){
		$ref = wizshop_ref_filter($result['ref'], $ignore_arr);
		$arr = explode('~',substr($ref,1));
		while( ( $page = array_shift( $arr ) ) !== null ){
			if($cur_page != $page)
				break;
		}
		$qr = implode('~',$arr);
		$ret = home_url($page) .( $qr ? ('?ref=/' . $qr) : '');
	}
	return $ret;
}
}
//------------------------------------------------------------
//v-shop
if (!function_exists('wizshop_shop_page')){
function wizshop_shop_page() {
	return is_page(WizShop_Pages::get_page_id(wizshopShopPageKey));
}
}
if (!function_exists('wizshop_get_shop_url')){
function wizshop_get_shop_url() {
	return WizShop_Pages::get_page_url(wizshopShopPageKey);
}
}
//------------------------------------------------------------
//cartcall
if (!function_exists('wizshop_cart_call_page')){
function wizshop_cart_call_page() {
	return is_page(WizShop_Pages::get_page_id('cart-call'));
}
}
if (!function_exists('wizshop_get_cart_call_url')){
function wizshop_get_cart_call_url() {
	return WizShop_Pages::get_page_url('cart-call');
}
}

//------------------------------------------------------------
function wizshop_is_title_page(){
	return ((wizshop_product_archive_type() && !is_search()) || wizshop_is_cat_tax() || wizshop_new_user_details_page());
}
//------------------------------------------------------------
//checkout-final
if (!function_exists('wizshop_checkout_final_page')){
function wizshop_checkout_final_page() {
	return is_page(WizShop_Pages::get_page_id('checkout-final'));
}
}
if (!function_exists('wizshop_get_checkout_final_url')){
function wizshop_get_checkout_final_url() {
	return WizShop_Pages::get_page_url('checkout-final');
}
}
//------------------------------------------------------------
//b2b-customer 
if (!function_exists('wizshop_get_b2b_customer_url')){
function wizshop_get_b2b_customer_url() {
	return WizShop_Pages::get_page_url('b2b-customer');
}
}
//------------------------------------------------------------
//reports-acc 
if (!function_exists('wizshop_get_acc_report_url')){
function wizshop_get_acc_report_url() {
	return WizShop_Pages::get_page_url('reports-acc');
}
}
//------------------------------------------------------------
//reports-item 
if (!function_exists('wizshop_get_item_report_url')){
function wizshop_get_item_report_url() {
	return WizShop_Pages::get_page_url('reports-item');
}
}
//------------------------------------------------------------
//user-area 
if (!function_exists('wizshop_get_personal_area')){
function wizshop_get_personal_area() {
	return is_page(WizShop_Pages::get_page_id('user-area'));
}
}
if (!function_exists('wizshop_get_personal_area_url')){
function wizshop_get_personal_area_url($getRefernce = true) {
	$qr = ($getRefernce) ? wizshop_get_ref(['user-area']) : '';
	if($qr!='') $qr = "?" . $qr;
	return WizShop_Pages::get_page_url('user-area') . $qr;
}
}
//------------------------------------------------------------
//single-product
if (!function_exists('wizshop_single_product_page')){
function wizshop_single_product_page() {
	return is_page(WizShop_Pages::get_page_id('single-product'));
}
}
//------------------------------------------------------------
//archive-product
if (!function_exists('wizshop_archive_product_page')){
function wizshop_archive_product_page() {
	return is_page(WizShop_Pages::get_page_id('archive-product'));
}
}
//------------------------------------------------------------
//search-product
if (!function_exists('wizshop_search_product_page')){
function wizshop_search_product_page() {
	return is_page(WizShop_Pages::get_page_id('search-product'));
}
}
//------------------------------------------------------------
function wizshop_is_template_page($id){
	$ret = false;
	global $wizshop_template_page_keys;
	foreach($wizshop_template_page_keys as $key) {
		if($id === WizShop_Pages::get_page_id($key)){
			$ret = true;
			break;
		}
	}	
	return $ret;
}
//------------------------------------------------------------
//agents 
if (!function_exists('wizshop_get_agents_url')){
function wizshop_get_agents_url() {
	return WizShop_Pages::get_page_url('agents');
}
}
?>