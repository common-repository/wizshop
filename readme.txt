=== WizShop ===
Contributors: hashshop
link: https://shop.wizshop.co.il/
Tags:  store, sales, sell, shop, cart, checkout,credit card, payments, ecommerce, e-commerce, WizSoft, WizShop
Requires at least: 4.4.0      
Tested up to: 6.0
Requires PHP: 5.6
Stable tag: 3.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

WizShop is a free eCommerce plugin developed by WizSoft®, to be integrated in WizCount (Hashavshevet)’s virtual store (in a WordPress website). 

== Description ==

WizShop is a free eCommerce plugin developed by WizSoft®, to be integrated in WizCount (Hashavshevet)’s virtual store (in a WordPress website).
The items to be sold in the virtual store are managed in the back-office by WizCount, and the sales are synchronized with the WizCount data.  
The WizShop plugin imports to the WordPress site all the relevant data from the back-office, and updates the back-office about the sales in the virtual store. 

= styling =
WizShop includes a default styling which enables a proper performance and responsivity in any WordPress theme. The designer may modify and customize the styling. (It is an open source).

= support =
Free support through email and phone to WizCount users.

= payment options =
WizShop includes the option of accepting payments through the major credit cards.


== Installation ==

= Minimum Requirements =

* WordPress 4.4 or greater
* PHP version 5.4 or greater
* MySQL version 5.0 or greater

= Installation =

1. Install the plugin through the WordPress plugins screen directly, or upload the plugin files to the `/wp-content/plugins/wizshop` directory.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Set permalinks to Post Name (Setting -> Permalink Settings -> Post Name) 
4. Optional: Create at least one menu (Design -> Menus)
5. Connect the plugin to your WizShop (WizShop -> Settings -> set the your shop ID) 
6. Import your WizShop categories (WizShop -> Categories)
7. Optional: Assign categories to the menu you've created at step #4

== Frequently Asked Questions ==

== Screenshots ==

1. Connect the plugin to your WizShop
2. Import your WizShop categories. You can also update a selected menu for categories
3. Choose the right way to present your products

== Changelog ==
= 3.0.2
* Tested: Up to WordPress 6.0
* Fix: Category pages canonical tag 

= 3.0.1
* Tested: Up to WordPress 5.9.2
* Fix: PHP 8.0 support

= 3.0.0
* Add: Supporting all new WizCount (Hashavshevet) 2020 version new features including guest checkout, coupons, newsletter subscription and more. 
	   Visit wizshop.co.il for detailed information. 

= 2.1.3
* Improvement: New Donations page (Donor Details page canceled)

= 2.1.2
* Improvement: Checkout page UI.
* Improvement: Sign In Widgets - Automatically hide the widget when other type of client (B2C/B2B) enters the system.
	   
= 2.1.1
* Add: Schema.org vocab to breadcrumbs.
* Fix: Admin menu bar - Components migration.
* Minor changes

= 2.1.0
* Add: Admin menu bar Components. 
* Add: Products view defaults on Search derived from Categories view options.  
* Fix: Document Title for Product/Products pages (backward compatibility).
* Fix: Price hiding (back-office compatibility).
* Improvement: Image managment (Media settings).
* Improvement: Donations page UI.

= 2.0.5
* Add: Full English support for WizShop Default pages.
* Add: Manage Product image gallery in WP (alternate to back office image management) 
* Add: Open Graph tags on Product page
* Add: Top Filters on Products page
* Add: Mini quick view (properties on hover) in gallery view
* Fix: WizShop Media conflict with same images on WP Media.
* Fix: Customer's cookie sent to API on direct HTTP calls.
* Improvement: Server side Product’s data loading.

= 2.0.4
* Fix: WizShop images sizes bug 
* Fix: Dashboard Multi language support 
* Add: Text Domain for WizShop pages ("wizshop-pages")

= 2.0.3
* Add: Products List Widget
* Add: Default image selection (Media settings)
* Add: Tabbed settings - New "Customers" tab 
* Add: Search Widget - placeholder field 
* Fix: Admin notice duplicates
* Fix: "wiz-grid" id removed from data-wiz-grid (Default View system) 
* Minor changes

= 2.0.2
* Fix: Pages check removed from admin_init action
* Minor changes

= 2.0.1
* Fix: Documentation link for Shop Elements
* Add: Script element in Shop page
* Fix: Sub categories display in categories filter 


= 2.0.0
* Add: Support for Default View system
* Add: New pages - Checkout, Accounting Statement, Item Transactions, Personal Area, Agents
* Add: New widget - Item filter
* Add: Support WizSoft-Search (only if set in back-office)
* Add: Tabbed settings - General,  Shop Elements, Shop Pages, Products, Other Settings
* Add: New Components folder with components ready to be added to the site menus
* Add: Support English language (pages/postypes/taxonomies)
* Add: Support Polylang language switcher
* Add: New image size for category item (Media settings)
* Improvement: Switch products view without Ajax call
* Improvement: Change product(s) pages construction via new template pages (Product Template, Products Template, Search Products Template) in Include folder, instead of origin in Templates folder
* Dev: Get/Find image url via wizshop_img_file_url() - ...stylesheet/wizshop/img[/lang] or ...plugins/wizshop/default/img[/lang]
* Dev: Use Shop Components configuration object - _wizshop_vc_config { defaut_image (default image for items without image ID in back-office) , ex_item_url (product url), ex_meta_desc (SEO)}
* Dev: Ensure Shop Components 'hide' style before loading components
* Fix: Cancel category key filtering (back-office compatibility)
* Fix: Display full categories tree in  Categories -> Settings




= Earlier versions =
For the changelog of earlier versions, please contact WizShop support.

== Upgrade Notice ==


