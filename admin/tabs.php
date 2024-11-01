<?php
	global  $wizshop_menu_settings;
	global 	$wizshop_is_multi_lang;
	global 	$wizshop_support_lang;
	global 	$wizshop_languages;
	global  $wizshop_view_settings;
	
	$view_op = wizshop_get_view_options();
	$products_view = $view_op['products_view'];
	
	if(!defined('wizshopComponentsMenu')){
		$meta_f = function(){
			$file_arr = array();
			foreach( glob( '{{'.wizshopStyleInclude.'/*.php,'.wizshopPluginComponents.'/*.php}}', GLOB_BRACE) as $sh_file ){
				$path_parts = pathinfo($sh_file);
				$file_arr[] =  $path_parts['basename'];
			}
			return array_values(array_unique( ($file_arr)));	
		};
		$opt = wizshop_get_option($wizshop_menu_settings['name']);
		wp_register_script('wiz-menus-js',wizshopPluginUrl . '/js/admin/menus.js', array('jquery'), wizshopPluginVersion, true);
		wp_localize_script('wiz-menus-js', '_wiz_menus', 
				array( 'menus' => WizShop_Menus::getSysMenus(),
						'no_menu' => array('id'=> -1, 'name' =>__('Select Menu', WizShop)),
						'no_item' => array('id'=> -1, 'name' => __('Select Item', WizShop)),
						'max_list' => 10,
						'validate_meta' => true,
						'meta' => $meta_f(),
						'no_meta' => array('id'=> -1, 'name' => __('Select File', WizShop)),
						'type' => wizshopShortcodeMenu,
						'io' => $opt[wizshopShortcodeMenu],
						'del_alert' => __('Delete item ?', WizShop)
				)
		);
	}
	
	$pages_f = function(){
		$pages_arr = array();
		$pages = get_pages(); 
		foreach ( $pages as $page ) {
			$pages_arr[] = array('id'=> $page->ID, 'title' => $page->post_title, 'link' => get_permalink( $page->ID ));
		}
		return $pages_arr;
	};
	
	$pages_inf = function(){
		global $wizshop_pages;
		$tmpl_keys = ['single-product', 'archive-product','search-product'];
		foreach ($wizshop_pages as $key => $fields ) {
			$use_shortcode = $fields['use_shortcode'];
			foreach ($fields as $field => $info ) {
				if(wizshop_is_shop_lang($field)){
					$lang = $field;
					$id = WizShop_Pages::get_user_page_option($key,$lang);

					$def_id = WizShop_Pages::is_page_exist($info['slug']);
					if(!$def_id) $def_id=-1;

					if(false === $id){
						if(-1 != $def_id){
							update_option(WizShop_Pages::user_page_option_key($key, $lang), $def_id);
							$id = $def_id;
						}
					}else if(-1 != $id){
						$stat = get_post_status($id);
						if(!$stat || "trash" == $stat){
							update_option(WizShop_Pages::user_page_option_key($key, $lang),-1);
							$id = -1;
						}
					}
					$pages_arr[] = array('key'=> $key, 'title' => $info['title'], 'id'=> $id, 
							'lang'=>$lang, 'def_id' => $def_id, 'use_shortcode' => $use_shortcode,
								'is_tmpl' => (in_array($key, $tmpl_keys)? 1: 0));
				}
			}
		}
		usort($pages_arr, function ($item1, $item2) {
			$eq_lang = strcmp($item1['lang'],$item2['lang']);
			if(0 > $eq_lang)
				return 1;
			else if(0 == $eq_lang){
				if($item1['is_tmpl'] > $item2['is_tmpl']){
					return -1;
				}else if($item1['is_tmpl'] == $item2['is_tmpl']){
					return  strcmp($item1['title'],$item2['title']) ;
				}else{
					return 1;
				}
			}
			return -1;
		});
		return $pages_arr;
	};


	wp_register_script('wiz-pages-js',wizshopPluginUrl . '/js/admin/pages.js', array('jquery'), wizshopPluginVersion, true);
	wp_localize_script('wiz-pages-js', '_wiz_pages', 
			array( 	'no_page' => array('id'=> -1, 'name' =>__('Select Page', WizShop)),
					'def_page' => array('id'=> -2, 'name' => __('Default', WizShop)),
					'pages_sep' => __('Pages', WizShop),
					'user_pages' => $pages_f(),
					'info' => $pages_inf(),
					'alert_new' => __('This is action will delete page contnet. Continue ?', WizShop),
			)
	);
	
	wp_register_script('wiz-customers-js',wizshopPluginUrl . '/js/admin/customers.js', array('jquery'), wizshopPluginVersion, true);
	wp_localize_script('wiz-customers-js', '_wiz_customers', 
			array( 	'text' => array( wizshop_lang_he => wizshop_get_customer_options(wizshop_lang_he), 
									 wizshop_lang_en => wizshop_get_customer_options(wizshop_lang_en)),
			)
	);

	if(!defined('wizshopComponentsMenu')){
		wp_enqueue_script('wiz-menus-js');
	}
	
	wp_enqueue_script('wiz-pages-js');
	wp_enqueue_script('wiz-customers-js');		
	
?>
<?php if(!defined('wizshopComponentsMenu')): ?>
<div id="menus-tab"  class="tab">
<h1><?php echo __("Adding WizShop Elements to Menus", WizShop)?></h1>
<!--<h3><?php echo __("Add items to selected menu", WizShop)?></h3>-->
<p class="sub-header"><?php printf(__("The plugin comes with several elements ready for your website's <b>menus</b>. <br/>
Each element is based on a .php file located in folder <i>'%s'</i>. <br/>
You can use existing elements or copy / add elements to theme's folder <i>'%s'</i>.<br/>
To add an element select the menu from the list, chose the menu item after which you'd like to add the element. <br/>
If none is chosen the element will be displayed at the end of the menu.", WizShop),wizshopPluginComponents, wizshopStyleInclude);?>
</p>
<div class="form-field">
	<script id="v_menu_html" type="text/html">
			<tr data-wiz-menu-item="{{index}}">
				<td width="150"><span class="readonly">{{menu_text}}</span></td>
				<td width="150" ><span class="readonly">{{item_text}}</span></td>
				<td width="150" ><span class="readonly">{{meta_text}}</span></td>
				<td width="50"><a href="javascript:void(0);" data-wiz-edit-menu-item="{{index}}" class="button" ><?php _e("Edit")?></a></td>
				<td width="80"><a href="javascript:void(0);" data-wiz-del-menu-item="{{index}}" class="button"><?php  _e("Delete")?></a></td>
			</tr>
	</script>	
	<div class="form-field">
		<table border="0" cellspacing="2" cellpadding="0">
		<thead>
		<tr>
			<th width="150"><?php echo __("Menu Name", WizShop)?></th>
			<th width="150"><?php echo __("Add after this item", WizShop)?></th>
			<th width="150"><?php echo __("File Name", WizShop)?></th>
			<th width="50"></th>
			<th width="80"></th>
		</tr>
		</thead>
		<tbody id="v_menu_list">
			<?php WizShop_Menus::menuSelection("meta=true") ?> 
		</tbody>
		</table>
		<p class="submit">
		<a href="javascript:void(0);" class="button button-primary" data-wiz-add-menu><?php _e("Add Items")?></a>
		</p>
        <div>
		</div>
	</div>
</div>
<p class="sub-header"><?php echo __("You can create and add an unlimited number of elements, read <a href='https://wizshop.co.il/%D7%A2%D7%A8%D7%99%D7%9B%D7%AA-%D7%A7%D7%91%D7%A6%D7%99-%D7%9E%D7%A7%D7%95%D7%A8/' target='_blank'>more</a> in our documentation.</a> <br/>\n
New elements will be automatically added to the list above.", WizShop)?></p>
</div>
<?php endif; ?>

<div id="pages-tab"  class="tab">
<h1><?php echo __("Page Settings", WizShop)?></h1>
<p class="sub-header"><?php echo __("When the plugin is installed it creates several <b>pages</b> with WizShop elements assigned to them. <br/>
You can change the page's assignment here", WizShop)?>
</p>
<div class="form-field" >
	<label for="v_pages_lang" class="<?php echo ($wizshop_is_multi_lang)? '' :'v_ihide' ?>"><?php _e("Language")?></label>
	<select id="v_pages_lang" class="<?php echo ($wizshop_is_multi_lang)? '' :'v_ihide' ?>">
		<?php
		foreach ($wizshop_support_lang as $lang => $ui ) {
			echo '<option value="'. $lang. '"';
			if ($wizshop_languages[0] == $lang ){
				echo 'selected="selected"';
			}
			echo '>' . translate($ui['label'], WizShop) . '</option>';
		}
		?>
	</select>
	<script id="v_page_html" type="text/html">
		<tr data-wiz-page-info-item="{{index}}">
			<td width="200" data-wiz-is-tmpl="{{is_tmpl}}">{{wiz_page}}</td>
			<td width="200"><span class="readonly">{{user_page}}</span></td>
			<td width="50"><a href="javascript:void(0);"  data-wiz-edit-page-info-item="{{index}}" class="button"><?php _e("Edit")?></a></td>
			<td width="50"><a href="{{link}}" target="_blank" class="button"><?php _e("View")?></a></td>
			<td width="100"></td>
		</tr>
	</script>	
	<div class="form-field pages-tab-scroll">
		<table border="0" cellspacing="2" cellpadding="0">
		<thead>
		<tr>
			<th width="200"><?php echo __("Element", WizShop)?></th>
			<th width="200"><?php echo __("Page", WizShop)?></th>
			<th width="50"></th>
			<th width="100"></th>
		</tr>
		</thead>
		<tbody id="v_page_list">
			<tr id="v_page_con" class="v_ihide">
				<td id="v_page_title" width="200"></td>
				<td width="200"><select id="v_page_item_select"></select></td>
				<td width="50"><a href="javascript:void(0);" id="v_page_close" class="button"><?php _e("Save")?></a></td>
				<td width="100"><a href="javascript:void(0);" id="v_page_cancel" class="button"><?php _e("Cancel Edit")?></a></td>
			</tr>
		</tbody>
		</table>
	</div>
</div>
</div>


<div id="products-tab"  class="tab">

<h1><?php echo __("Products View", WizShop)?></h1>

<label for="v_product_device"><?php echo __("To set products view, first select the device type.", WizShop)?></label>
<div><select id="v_product_device"></select></div>
<hr></hr>
<h2></h2>
<h2><?php echo __("Products Grid layout", WizShop)?></h2>
	
<div data-wiz-prdoducts-view-sec>
	<div>
	<h2 class="sub-header"><?php echo __("Gallery", WizShop)?></h2>

	<label for="gallery_page"><?php echo __("Products in page", WizShop)?></label>
	<input type="number" class="small-text" id="gallery_page" min="0">

	<label for="gallery_line"><?php echo __("Products in line", WizShop)?> </label>	
	<select id="gallery_line"></select>
	</div>
	
	<div>
	<h2 class="sub-header"><?php echo __("Table", WizShop)?></h2>
	<label for="table_page"><?php echo __("Products in page", WizShop)?></label>
	<input type="number" class="small-text" id="table_page" min="0">
	</div>

	<div>
	<h2 class="sub-header"><?php echo __("Lines", WizShop)?></h2>
	<label for="lines_page"><?php echo __("Products in page", WizShop)?></label>
	<input type="number" class="small-text" id="lines_page" min="0">
	</div>

</div>	
<div>
	<h2><?php echo __("Load additional products in Grid using", WizShop)?></h2>

	<p>
	<input type="checkbox"  id="v_nav_pagination" data-wiz-navigation="1">
	<label for="v_nav_pagination"><?php echo __("Pagination", WizShop)?></label>
	</p>	
	
	<p>
	<input type="checkbox"  id="v_nav_scrolling" data-wiz-navigation="4">
	<label for="v_nav_scrolling"><?php echo __("Infinite scrolling", WizShop)?></label>
	</p>	

	<p>
	<input type="checkbox"  id="v_nav_button" data-wiz-navigation="2">
	<label for="v_nav_button"><?php echo __("Dedicated button", WizShop)?></label>
	</p>	
</div>
<div>
	<h2><?php echo __("Quick View", WizShop)?></h2>
	<p>
		<input type="checkbox"  id="v_quick_view">
		<label for="v_quick_view"><?php echo __('Enable Product "Quick View"', WizShop)?></label>
	</p>
	<p>
		<input type="checkbox"  id="v_min_quick_view">
		<label for="v_min_quick_view"><?php echo __('Enable Product "Mini Quick View"', WizShop)?></label>
	</p>	
</div>

<div>
	<h2><?php echo __("Product Filtering", WizShop)?></h2>
	<input type="checkbox"  id="v_top_filter">
	<label for="v_top_filter"><?php echo __('Enable Top Product filtering', WizShop)?></label>
</div>


<div style="display:none">
	<h2><?php echo __("Sidebar", WizShop)?></h2>
	<p>
	<input type="checkbox"  id="v_sidebar_grid" data-wiz-sidebar-page="2">
	<label for="v_sidebar_grid"><?php echo __("Show on Products grid page", WizShop)?></label>
	</p>	
	<p>
	<input type="checkbox"  id="v_sidebar_product" data-wiz-sidebar-page="4">
	<label for="v_sidebar_product"><?php echo __("Show on Product pages", WizShop)?></label>
	</p>	
	<p>
	<input type="checkbox"  id="v_sidebar_shop" data-wiz-sidebar-page="1">
	<label for="v_sidebar_shop"><?php echo __("Show on Shop main page", WizShop)?></label>
	</p>	
</div>	

<p class="submit">
	<a href="javascript:void(0);" data-wiz-products-view-prev="<?php echo htmlentities(json_encode($products_view), ENT_QUOTES, 'UTF-8'); ?>" id="v_pview_save" class="button-primary" ><?php _e("Save")?></a>
	<a href="javascript:void(0);" data-wiz-products-view-def="<?php  echo htmlentities(json_encode($wizshop_view_settings['defaults']['products_view']), ENT_QUOTES, 'UTF-8') ?>" id="v_pview_def" class="button-primary" ><?php _e("Default")?></a>
</p>

</div>

<div id="other-tab"  class="tab">
<h1><?php echo __("SEO", WizShop)?></h1>
<div class="form-field" >
	<!--<h3 class="sub-header"><?php echo __("Force rewrite titles", WizShop)?></h3>-->
	<p>
		<input type="checkbox"  id="v_page_cat_doc_title" data-wiz-seo-flag="1"    <?php echo ($view_op['doc_title'] & 1)? ' checked' :'' ;?> >
		<label for="v_page_cat_doc_title"><?php	echo __("Set HTML Title for Products page (Template: Website Name | Category Name)", WizShop)  ?>	</label>
	</p>
	<p>
		<input type="checkbox"  id="v_page_product_doc_title" data-wiz-seo-flag="2"   <?php echo ($view_op['doc_title'] & 2)? ' checked' :'' ;?> >
		<label for="v_page_product_doc_title"><?php	echo __("Set HTML Title for Single product pages (Template: Website Name | Product Name)", WizShop)   ?> 	</label>
	</p>

	<p>
		<input type="checkbox"  id="v_ex_url" data-wiz-seo-flag="8"   <?php echo ($view_op['doc_title'] & 8)? ' checked' :'' ;?> >
		<label for="v_ex_url"><?php	echo __("Product URL - Append product Name to product Key (Template: ../products/key**name)", WizShop)  ?>	</label>
	</p>

	<p>
		<input type="checkbox"  id="v_meta_desc" data-wiz-seo-flag="4"   <?php echo ($view_op['doc_title'] & 4)? ' checked' :'' ;?> >
		<label for="v_meta_desc"><?php	echo __("Add product Description to HTML Meta description tag", WizShop)  ?>	</label>
	</p>

	<p>
		<input type="checkbox"  id="v_meta_og" data-wiz-seo-flag="16"   <?php echo ($view_op['doc_title'] & 16)? ' checked' :'' ;?> >
		<label for="v_meta_og"><?php echo __("Add Open Graph Tags to product page", WizShop)  ?>	</label>
	</p>
	
	<p class="submit">
	<a href="javascript:void(0);" class="button-primary" data-wiz-seo-prev="<?php echo $view_op['doc_title']?>" id="v_seo_save"><?php _e("Save")?></a>
	<a href="javascript:void(0);" class="button-primary" data-wiz-seo-def="<?php echo $wizshop_view_settings['defaults']['doc_title']?>" id="v_seo_def"><?php _e("Default")?></a>
	</p>
</div>
</div>
<div id="customers-tab"  class="tab">
<h1><?php echo __("Customers", WizShop)?></h1>
<p class="sub-header"><?php echo __("Enter text for customer login links in the following elements.", WizShop)?></p>
	<label for="v_customers_lang" class="<?php echo ($wizshop_is_multi_lang)? '' :'v_ihide' ?>"><?php _e("Language")?></label>
	<select id="v_customers_lang" class="<?php echo ($wizshop_is_multi_lang)? '' :'v_ihide' ?>">
		<?php
		foreach ($wizshop_support_lang as $lang => $ui ) {
			echo '<option value="'. $lang. '"';
			if ($wizshop_languages[0] == $lang ){
				echo 'selected="selected"';
			}
			echo '>' . translate($ui['label'], WizShop) . '</option>';
		}
		?>
	</select>
	<table>
		<tr colspan="2">
			<td>
				<h2 class="sub-header"><?php echo __("B2C Customers", WizShop)?></h2>
			</td>
		</tr>
			
		<tr>
			<td>	
				<label for="b2c_link_text"><?php echo __("Menu Link", WizShop)?></label>
			</td>
			<td>
				<input type="text" class="" id="b2c_link_text" size="20" maxlength="250" >
			</td>
		</tr>
	
		<tr>
			<td>
				<label for="b2c_checkout_text"><?php echo __("Checkout Page", WizShop)?> </label>	
			</td>
			<td>
				<input type="text" class="" id="b2c_checkout_text" size="20" maxlength="250">
			</td>
		</tr>

		<tr>
			<td>
				<label for="b2c_donor_text"><?php echo __("Donation Page", WizShop)?> </label>	
			</td>
			<td>
				<input type="text" class="" id="b2c_donor_text" size="20" maxlength="250">
			</td>
		</tr>

		
		<tr colspan="2">
			<td>
				<h2 class="sub-header"><?php echo __("B2B Customers", WizShop)?></h2>
			</td>
		</tr>
			
		<tr>
			<td>	
				<label for="b2b_link_text"><?php echo __("Menu Link", WizShop)?></label>
			</td>
			<td>
				<input type="text" class="" id="b2b_link_text" size="20" maxlength="250" >
			</td>
		</tr>
		<tr>
			<td>
				<label for="b2b_checkout_text"><?php echo __("Checkout Page", WizShop)?> </label>	
			</td>
			<td>
				<input type="text" class="" id="b2b_checkout_text" size="20" maxlength="250">
			</td>
		</tr>
		<tr>
			<td>
				<label for="b2b_donor_text"><?php echo __("Donation Page", WizShop)?> </label>	
			</td>
			<td>
				<input type="text" class="" id="b2b_donor_text" size="20" maxlength="250">
			</td>
		</tr>		
		
		<tr colspan="2">
			<td>
				<h2 class="sub-header"><?php echo __("Salespersons", WizShop)?></h2>
			</td>
		</tr>
		<tr>
			<td>
				<label for="agents_link_text"><?php echo __("Menu Link", WizShop)?></label>
			</td>
			<td>
				<input type="text" class="" id="agents_link_text" size="20" maxlength="250" >
			</tr>
		</table>

	<p class="submit">
		<a href="javascript:void(0);" id="v_cust_save" class="button-primary" ><?php _e("Save")?></a>
		<a href="javascript:void(0);" id="v_cust_def" class="button-primary" ><?php _e("Default")?></a>
	</p>	
</div>