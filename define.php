<?php   
if ( ! defined( 'ABSPATH' ) ) exit; 

// defines

if (!defined('WizShop')) define('WizShop','wizshop');
if (!defined('wizshopPluginVersion')) define('wizshopPluginVersion','3.02');

if (!defined('wizshopShopUrl')) define('wizshopShopUrl', 'https://shop3.wizsoft.com/VSHOP/WizCgi.cgi?API=Yes&HTTPREQ=99&UC=');

if (!defined('wizshopPluginUrl')) define('wizshopPluginUrl', plugin_dir_url(__FILE__));
if (!defined('wizshopPluginPath')) define('wizshopPluginPath', dirname(__FILE__));
if (!defined('wizshopPluginTemplate')) define('wizshopPluginTemplate', wizshopPluginPath . '/templates');
if (!defined('wizshopPluginAdmin')) define('wizshopPluginAdmin', wizshopPluginPath . '/admin');
if (!defined('wizshopPluginInclude')) define('wizshopPluginInclude', wizshopPluginPath . '/include');
if (!defined('wizshopPluginWidgets')) define('wizshopPluginWidgets', wizshopPluginPath . '/widgets');
if (!defined('wizshopPluginComponents')) define('wizshopPluginComponents', wizshopPluginPath . '/components');

if (!defined('wizshopPluginDefault')) define('wizshopPluginDefault', wizshopPluginPath . '/default');
if (!defined('wizshopDefaultImgDir')) define('wizshopDefaultImgDir', wizshopPluginDefault . '/img');

if (!defined('wizshopStyle')) define('wizshopStyle', get_stylesheet_directory() . '/wizshop');
if (!defined('wizshopStyleInclude')) define('wizshopStyleInclude', wizshopStyle . '/include');
if (!defined('wizshopStyleTemplates')) define('wizshopStyleTemplates', wizshopStyle . '/templates');
if (!defined('wizshopStyleWidgets')) define('wizshopStyleWidgets', wizshopStyle . '/widgets');
if (!defined('wizshopStyleLanguages')) define('wizshopStyleLanguages', wizshopStyle . '/languages');
if (!defined('wizshopStyleImg')) define('wizshopStyleImg', wizshopStyle . '/img');

if (!defined('wizshopNotices')) define('wizshopNotices', 'wizshop_notices');
if (!defined('wizshopShopPostType')) define('wizshopShopPostType','wizshop');

if (!defined('wizshopShopPageKey')) define('wizshopShopPageKey','v-shop');

//image
if (!defined('wizshopDefaultImage')) define('wizshopDefaultImage','wiz-default-image.jpg');
	
//langs
if (!defined('wizshop_lang_en')) define('wizshop_lang_en', 'en');
if (!defined('wizshop_lang_he')) define('wizshop_lang_he', 'he');

//shortcode menus 
if (!defined('wizshopShortcodeMenu')) define('wizshopShortcodeMenu', 'sh_menus');
//Components menus 
if (!defined('wizshopComponentsMenu')) define('wizshopComponentsMenu', '');

//query vars 
if (!defined('wizshop_id_qvar')) 	define('wizshop_id_qvar', 'wiz_id');
if (!defined('wizshop_filter_qvar')) define('wizshop_filter_qvar', 'wiz_filter');
if (!defined('wizshop_count_qvar')) define('wizshop_count_qvar', 'wiz_count');
if (!defined('wizshop_view_qvar')) define('wizshop_view_qvar', 'wiz_view');
if (!defined('wizshop_product_tag')) define('wizshop_product_tag', 'p_id');

// pages text domain
if (!defined('wizshop_pages')) define('wizshop_pages','wizshop-pages');
?>