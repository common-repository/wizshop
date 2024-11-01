<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/*---------------------------------*/ 
/* class  WizShop_Template_Loader  */
/*---------------------------------*/ 


class WizShop_Template_Loader {
	
	var $item_res;
	var $title;
	var $cat_info;

	public function __construct() {

		$this->item_res = $this->title = $this->cat_info = false;
		
		add_filter('template_include', array($this, 'load_template' ) );
		add_action('wiz_single_product_init',array( $this, 'single_product_init'),10,0);
		add_action('wiz_archive_product_init',array( $this, 'archive_product_init'),10,0);
		add_action('wiz_cat_view_init',array( $this, 'cat_view_init'),10,1);
		add_action('wiz_search_product_init',array( $this, 'search_product_init'),10, 1);
		add_action('wiz_user_details_init',array( $this, 'user_details_init'),10,1);
		add_action('wiz_categories_init',array( $this, 'categories_init'),10);
		add_action('wp_head',array( $this, 'top_head'), 0);
		add_action('wp_head',array( $this, 'prepare_head'));
		add_filter('parse_query', array( $this, 'parse_query')) ;

		if (!is_admin()){
			add_filter('pll_the_language_link', array( $this, 'poly_lang_switch' ), 10, 2);
			add_filter('pll_get_current_language', array( $this, 'set_pll_lang' ));
			add_filter('the_title', array( $this, 'the_title'), 10, 2) ;
			add_filter('post_type_archive_title', array( $this, 'post_type_archive_title'), 10, 2 ); 
			add_filter('wpseo_title', array( $this, 'title'));
			add_filter('pre_get_document_title', array( $this, 'title'), 15 );
			add_filter('wp_title', array( $this, 'title'), 15, 3 );
			add_filter('wpseo_opengraph_title', array( $this, 'opengraph_title') );
			add_filter('wpseo_opengraph_url', array( $this, 'opengraph_url') );
			add_filter('wpseo_canonical', array( $this, 'opengraph_url') );
			
		}
	}
		
	function load_template($template) {

		$template_names = array();
		$page = '';

		if ( is_page()) {
			$post = get_post();
			if( $post && function_exists('pll_get_post_language')){
				$p_lang = pll_get_post_language($post->ID);
				if(wizshop_is_shop_lang($p_lang)){
					wizshop_cur_lang($p_lang);
				}
			}
		} elseif ($tax = wizshop_is_cat_tax()) {
			wizshop_cur_lang($tax['lang']);
			$term = get_queried_object();
			$page = 'archive-product.php';	
			$template_names[] = wizshop_template_part($tax['lang']) . $page;
			$template_names[] = wizshop_template_part() . $page;
		} elseif ($pst = wizshop_product_archive_type()) {
			wizshop_cur_lang($pst['lang']);
			$page 	= (is_search()) ? 'search-product.php' : 'single-product.php';
			$template_names[] = wizshop_template_part($pst['lang']) . $page;
			$template_names[] = wizshop_template_part() . $page;
		} else{
			if(function_exists('pll_current_language')){
				wizshop_cur_lang(pll_current_language());
			}
		}
		if ( $page ) {
			$template = locate_template( $template_names );
			if (!$template)
				$template = wizshopPluginTemplate . '/' . $page;
		}
		return $template;
	}
	
	function prepare_head(){
		if (wizshop_is_cat_tax()) {
			do_action('wiz_archive_product_init');
		} elseif (wizshop_product_archive_type()) {		
			if(is_search()){
				do_action('wiz_search_product_init', get_search_query());
			}else{
				do_action('wiz_single_product_init');
			}
		}
		else if(get_post_type() == 'page'){
			if(wizshop_single_product_page()){
				do_action('wiz_single_product_init');
			}else if(wizshop_archive_product_page()){
				do_action('wiz_archive_product_init');
			}else if(wizshop_search_product_page()){
				global $wp_query;
				do_action('wiz_search_product_init', isset($wp_query->query["s"]) ? $wp_query->query["s"] :"");
			}else if(wizshop_new_user_details_page()){
				do_action('wiz_user_details_init',__('Create account',WizShop));
			}
		}
	}
	
	function top_head(){
		
		global $wizshop_settings;
		$options = wizshop_get_option($wizshop_settings['name']);

		$this->head_preload([isset($_GET['wiz-debug']) ? 'VSComponents.js' : 'VSComponents.min.js', 
							 (isset($_GET['wiz-debug']) ? 'vsc_load.js' : 'vsc_load.min.js') . '?mode=static&uc=' . wizshop_get_setting('shop_id', $options) 
								.'&lang=' . wizshop_cur_lang(). '&ver='. wizshopPluginVersion,
							'MThreadReq.js' ], $options);
		
		$view_op = wizshop_get_view_options();
		$this->set_item_meta($view_op);
		$galley = (1 == $view_op['item_gallery'])?
				('window["__wizshop_item_gallery"] = { action: "wiz_item_gallery", url  :"' . 
					esc_js(admin_url('admin-ajax.php')) . '", wp_nonce:"' . wp_create_nonce('wizshop-item-nonce'). '"};' )	
					: '';
		echo '<script type="text/javascript">
					window["__wizshop_vc_config"] = window["__wizshop_vc_config"] ||
						{default_image: ' . json_encode(wizshop_def_image_name()).
						 ',ex_item_url: ' . json_encode(0 !=(8 & $view_op['doc_title'])).
						'};'
						. $galley .
						'</script>
				<style data-wiz-css="" type="text/css">[data-wizshop]{visibility:hidden;}</style>
				<style data-wiz-def-css="" type="text/css">.v_ihide, .hide0, .hiderev1 {display:none !important;}</style>
				';
	}
	
	function head_preload($js_files, $options){
 		$cp = wizshop_get_setting('shop_server', $options) . '/udiver/css/' ;
		foreach ($js_files as $f) {
			echo '<link rel="preload" href="'. $cp. $f.'" as = "script">';
		}
	}
	
	function archive_product_init() {
		$cat_info = $this->get_cat_info();
 		if($cat_info) {
			$this->set_cat_info_script($cat_info, wizshop_grid_view());
		}
	}
	
	function get_cat_info(){
		$cat_info = false;
		$term = get_queried_object();
		if(!is_object($term) || is_wp_error($term) || !wizshop_is_cat_tax($term->taxonomy)){
			global $wizshop_cat_taxonomies;
			$cat_key = get_query_var($wizshop_cat_taxonomies[wizshop_cur_lang()]['name']);
			if(isset($cat_key)) {
				$cat_info  = WizShop_Categories::get_cat_info_by_key($cat_key, $wizshop_cat_taxonomies[wizshop_cur_lang()]['name']);
			}
		}else{
			$cat_info = WizShop_Categories::get_cat_info($term->taxonomy,$term->term_id);
		} 
		return $cat_info;
	}
	
	function cat_view_init() {
		$cat_info = WizShop_Categories::get_cat_info_by_key(wizshop_get_filter_var());
		$this->set_cat_info_script($cat_info, wizshop_grid_view());
	}
	
	function set_cat_info_script($cat_info, $view_type_def){
		if(!$cat_info) return;
		echo '<script type="text/javascript">
				_vsc_static_cat_json.cat.path = "'. esc_js($cat_info->cat_path). '"; 
				_vsc_static_cat_json.cat.name = "' . esc_js($cat_info->cat) .'";
				window["vshop_cat_view_json"] = '. json_encode(wizshop_cat_view_options(false,$cat_info,$view_type_def)). 
				';</script>';
	}
	
	function single_product_init() {
		$p_id = wizshop_product_tag_var();
		if(isset($p_id)) {
			$op = wizshop_get_view_options();
			$gallery = "";
			if(1 == $op['item_gallery']){
				$js_arr = implode('","', wizshop_get_gallery_images($p_id));
				if("" != $js_arr ){
					$js_arr = '"' . $js_arr .'"';
				}
				$gallery = ' window["__wizshop_item_page_gallery"] = { key :"'. rawurldecode($p_id) . 
								'", images: [' . $js_arr . ']};';
			}
			echo '<script type="text/javascript">
					_vsc_static_item_json.item = "'. rawurldecode($p_id). '";'
					.'_vsc_static_item_json.res = '. ($this->item_res ? json_encode($this->item_res): null). ';'
					. $gallery .
					'</script>';
		}
	}
	
	function search_product_init($text) {
		if(isset($text)) {
			echo '<script type="text/javascript">
				_vsc_static_query_json.text = "'. esc_js($text). '";' .
				'window["vshop_cat_view_json"] = '. json_encode(wizshop_cat_view_options(true/*default tax->lang view*/,null,wizshop_search_view_cookie_val())). 
				';</script>';
		}
	}
	
	function user_details_init($new_title) {
		if(isset($new_title)) {
			echo '<script type="text/javascript">
				_vsc_static_title_json.text = "'. esc_js($new_title). 
				'";</script>';
		}
	}	

	function categories_init() {
		echo '<script type="text/javascript">
			_vsc_static_cat_paint_json.init=true;
			</script>';
	}
	
	function set_pll_lang($lang){
		$new_lang = '';
		if(!$lang){
			if ($pst = wizshop_product_archive_type()) {
				$new_lang = $pst['lang'];
			}
		}
		if($new_lang && function_exists('pll_languages_list')){
			$listlanguages = PLL()->model->get_languages_list(array('hide_empty' => false));
			foreach ($listlanguages as $language) {
				if($language->slug == $new_lang){
					 $lang = $language;
					 break;
				}
			}
		}
		return $lang;
	}
	
	function parse_query($query){	
		
		$view_op = wizshop_get_view_options();
		if ($tax = wizshop_is_cat_tax()){
			$sp = WizShop_Pages::get_page_id('archive-product', $tax["lang"]);
			$cat_info = $this->get_cat_info();
			$this->cat_info = $cat_info;
			$pst = null;
			if($sp != -1){
				
				if(function_exists("YoastSEO")){
					YoastSEO()->meta->for_current_page();
					$this->title = $yst->title;
				}
				
				$pst = get_post($sp);
				$query->query["post_type"] = $tax["name"];
				$query->query["pagename"] = $pst->post_title;
				$query->set('page','');
				$query->set('pagename', $pst->post_title);
				$query->queried_object = $pst;
				$query->queried_object_id = $sp;
				$query->queried_terms = null;
				$query->tax_query = null;
				$query->is_archive = false;
				$query->is_page = true;
				$query->is_single = false;
				$query->is_tax = false;
				$query->is_singular =true;
				$query->is_post_type_archive = false;
			}	
			if($cat_info) {
				if(empty($this->title)){
					$this->title = ($view_op['doc_title'] & 1) ? (get_bloginfo('name') . ' | ' . $cat_info->cat) : $cat_info->cat;
				}
				if($pst) $pst->post_title = $cat_info->cat;
			}	
			
		}else if($ap = wizshop_product_archive_type()){
			
			$page =  is_search() ? 'search-product' : 'single-product';
			$sp = WizShop_Pages::get_page_id($page, $ap["lang"]);
			$search = is_search();
			$s_query = "";
			$pst = null;
			if($sp != -1){
				$query->query["post_type"] =  $ap["name"];
				if(is_search()) {
					$s_query = $query->query_vars["s"];
					unset($query->query_vars["s"]);
				}				
				$pst = get_post($sp);
				$query->query["pagename"] = $pst->post_title;
				$query->set('page','');
				$query->set('post_type', 'page' );
				$query->set('pagename', $pst->post_title);
				$query->queried_object = $pst;
				$query->queried_object_id = $sp;
				$query->is_archive 	= false;
				$query->is_page 	= true;
				$query->is_single 	= false;
				$query->is_tax 		= false;
				$query->is_singular = true;
				$query->is_search	= false;
				$query->is_post_type_archive = false;
				
			}else if($search){
				$s_query = get_search_query();
			}
			
			if($search) {
				$this->title = get_bloginfo('name') . ' | Search: ' . $s_query;
			}else{
				$p_id = wizshop_product_tag_var();
				if(isset($p_id)) {
					if(false === $this->item_res){
						$this->item_res = WizShop_Api::get_item_info($p_id,  $ap["lang"]);
					}
					$this->title = ($view_op['doc_title'] & 2) ? (get_bloginfo('name') . ' | '. $this->get_item_title()) : $this->get_item_title();
					if($pst) $pst->post_title = $this->get_item_title();
				}
			}
		}else if(wizshop_new_user_details_page()){
			$pst = (object)get_post();
			$pst->post_title = __('Create account',WizShop);
		}
	}
	
	function poly_lang_switch($url, $lang) {
		global $wp_query;
		global $wizshop_is_multi_lang;
		if($wizshop_is_multi_lang && wizshop_is_shop_lang($lang)){
			if(null == $url){
				if(wizshop_is_cat_tax()){
					if(function_exists('pll_get_term_translations')){
						$term = get_queried_object();
						if(is_object($term)) {
							$term_op = pll_get_term_translations($term->term_id);
							if(isset($term_op) && is_array($term_op) && isset($term_op[$lang])){
								$url = get_term_link($term_op[$lang]);
							}
						}
					}
				} elseif (wizshop_product_archive_type() && ($prod_url = wizshop_get_products_url($lang)) ) {
					$p_id = wizshop_product_tag_var();
					$url = trailingslashit($prod_url) . (isset($p_id) ? $p_id :"") ;
				}
			}else if($pt = wizshop_template_page_orig_posttype()){

				if(wizshop_is_product_posttype($pt)){
					if(isset($wp_query->query[wizshop_product_tag])){
						$url = trailingslashit( wizshop_get_products_url($lang)) . wizshop_check_product_var($wp_query->query[wizshop_product_tag]) ;
					}else if(isset($wp_query->query["s"])){
						$url = trailingslashit( wizshop_get_products_url($lang)) . "?s=". $wp_query->query["s"] ;
					}
				}else if($tax = wizshop_is_cat_tax($pt)){
					$url= null;
					if(function_exists('pll_get_term_translations')){
						$cat_slug = get_query_var($tax["name"]);
						if(isset($cat_slug)) {
							$info  = WizShop_Categories::get_term_by_slug($cat_slug, $tax["name"]);
							if($info){
								$term_op = pll_get_term_translations($info[0]);
								if(isset($term_op) && is_array($term_op) && isset($term_op[$lang])){
									$url = trailingslashit(get_term_link($term_op[$lang])) ;
								}
							}
						}		
					}
				}
			}
		}
		return $url;
	}

	function the_title($title, $id){	
		global $post;
		if(isset($post) && $id == $post->ID){
			if(wizshop_is_template_page($id)){
				$title = "";
			}
		}
		return $title;
	}
		
	function post_type_archive_title($object_labels_name, $object_name){
		if(isset( $object_name) && wizshop_is_product_posttype($object_name)){
			$object_labels_name = $this->get_item_title();
		}
		return $object_labels_name;
	}

	function title($title){
		if($this->title){
			$title = (wizshop_lang_en != wizshop_cur_lang()) ?
				(str_replace("| Search: ", "| ". __('Search',WizShop).": ", $this->title)) : $this->title;		
		}
		return $title;
	}

	
	function set_item_meta($view_op = null){
		global $wizshop_upload_path;
		
		if(null == $view_op) $view_op = wizshop_get_view_options();
		
		if(false !== $this->item_res && is_object($this->item_res) && is_array($this->item_res->OutTab[0])) {
			
			$desc = $this->get_item_desc();
			$title = $this->get_item_title();
			if(!$desc){
				$desc = $title;
			}
			
			if(16 & $view_op['doc_title']){
				$tab = $this->item_res->OutTab[0];
				$image = wizshop_get_image_props($tab[5]) ? $tab[5] :  wizshop_def_image_name();
				$image_key = $image ? pathinfo($image, PATHINFO_FILENAME) : "";
				$image_ext = $image ? pathinfo($image, PATHINFO_EXTENSION) : "";
				echo '<meta property="og:locale" content="'. get_locale() .'"/>' . PHP_EOL;
				echo '<meta property="og:site_name" content="'. get_bloginfo() .'"/>' . PHP_EOL;
				echo '<meta property="og:url" content="'. esc_url(wizshop_current_page_url()) .'"/>' . PHP_EOL;
				echo '<meta property="og:type" content="product"/>' . PHP_EOL;
				echo '<meta property="og:description" content="'. esc_attr($desc) .'"/>' . PHP_EOL;
				echo '<meta property="og:title" content="'. esc_attr($title) .'"/>' . PHP_EOL;
				echo '<link rel="canonical"  href="'. esc_url(wizshop_current_page_url()) .'"/>' . PHP_EOL;
				if($image_key){
					$s_format = wizshop_format_image_sizeWH("medium");
					$makaf_format = ($s_format != "") ? ("-" . $s_format) : "";
					echo '<meta property="og:image" content="'.esc_url(trailingslashit($wizshop_upload_path['url']). 
							$image_key .  $makaf_format. (($image_ext) ? ("." . $image_ext) : "" ))  .'"/>' . PHP_EOL;
				}
			}
			
			if(4 & $view_op['doc_title']){
				echo '<meta name="description" content="'. esc_attr($desc) .'"/>' . PHP_EOL;
			}
			echo '<script type="text/javascript">
					window["__wizshop_vc_meta"] = window["__wizshop_vc_meta"] ||
						{ title: ' . json_encode($title).
						 ',description: ' . json_encode($desc).
						 ',url:' . json_encode(wizshop_current_page_url()).
						'};</script>';
		}
	}
		
	function get_item_note($name){
		$ret = false;
		if(is_array($this->item_res->VSNotesTab) && sizeof($this->item_res->VSNotesTab) > 1){
			$notesTab = $this->item_res->VSNotesTab[1];
			if(is_array($notesTab)){
				$item_count = sizeof($notesTab);
				for($i = 0; $i < $item_count;  ++$i) {
					if($notesTab[$i][0] == $name){
						$ret = $notesTab[$i][1];
						break;
					}
				}
			}	
		}
		return $ret;
	}	

	function get_item_title(){
		$title = "";
		if(false !== $this->item_res){
			$title = $this->get_item_note("wiz_title");
			if(!$title){
				$tab = $this->item_res->OutTab[0];
				$title = $tab[0];
			}
		}
		return $title;
	}
	
	function get_item_desc(){
		$desc = "";
		if(false !== $this->item_res){
			$desc = $this->get_item_note("wiz_desc");
			if(!$desc){
				$tab = $this->item_res->OutTab[0];
				$desc = $tab[1];
			}
			$desc = str_replace('%0A',PHP_EOL, $desc);
		}
		return $desc;
	}
	
	function opengraph_title($title){
		if(wizshop_archive_product_page() && $this->cat_info){
			if(empty($title)){
				$title = $this->cat_info->cat;
			}
		}else if(false !== $this->item_res){
			$title = $this->get_item_title();
		}
		return $title;
	}
	
	function opengraph_url($url){
		if(wizshop_archive_product_page() || false !== $this->item_res){
			$url = rawurlencode(wizshop_current_page_url());
		}
		return $url;
	}

}
new WizShop_Template_Loader();
?>