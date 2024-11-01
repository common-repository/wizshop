<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
//  read vars defined in products-view.php: 
//	$wiz_products_view  	=> 	"grid" / "table" / "lines"
//	$wiz_items_in_page		=>	items in page 
//	$wiz_items_in_line		=>  gallery (grid) view: items in line 
// 	$wiz_display_type		=>  current display as detected by plugin: "desktop" / "mobile" / "tablet"

//	$wiz_custom_id
//	$wiz_custom_filter
	
	if(!isset($wiz_custom_id)) 		$wiz_custom_id = wizshop_get_id_var();
	if(!isset($wiz_custom_filter))	$wiz_custom_filter = wizshop_get_filter_var();

/*
 * Views types for CSS classes
 * */
$mobile = (!empty(wizshop_get_view_settings('mobile')['gallery_line'])) ? 12 / wizshop_get_view_settings('mobile')['gallery_line'] : 12;
$tablet = (!empty(wizshop_get_view_settings('tablet')['gallery_line'])) ? 12 / wizshop_get_view_settings('tablet')['gallery_line'] : 4;
$desktop = (!empty(wizshop_get_view_settings('desktop')['gallery_line'])) ? 12 / wizshop_get_view_settings('desktop')['gallery_line'] : 3;

?>

<?php if ($wiz_products_view == 'grid'): ?>
<div data-wizshop data-wiz-grid="<?php echo esc_attr($wiz_custom_id)?>" data-wiz-filter="<?php echo esc_attr($wiz_custom_filter)?>" class="container-fluid products-grid">
    <input data-wiz-items-in-page type="hidden" value="<?php echo $wiz_items_in_page; ?>">
    <div data-wiz-container class="row">
        <!-- Each item -->
        <div data-wiz-item class="col-xl-<?= $desktop ?> col-lg-<?= $desktop ?> col-md-<?= $tablet ?> col-sm-<?= $mobile ?> col-<?= $mobile ?> mb-4">
            <div data-wiz-item-data class="each-product text-center">
			<script type="text/html">
               	<a href="<?php echo esc_url(wizshop_get_products_url())?>{{Link}}" class="grid-link"> 
					<!-- Product image -->
					<img src="<?php esc_url(wizshop_image_name_link("{{ImageFile}}","wiz_grid"))?>" alt="{{Name}}" class="w-100">
					<!-- Product title -->
					<h4 class="p-0 m-0 product-title text-center"> {{Title}} </h4>
				
					<!-- Discount label -->
					<label class="v_iSale {{dispSale}} m-0 pt-2 discount-label"></label>
					
					<?php if(1 == wizshop_get_view_settings()['min_quick_view']): ?>
					<div  data-wiz-item-tab-prop-container class="mini-quick-view">
						<div data-wiz-item-prop class="col-12">
							<div class="param dsp-inlineblock">{{PropName}}</div>
							<div class="value dsp-inlineblock">{{PropVal}}</div>
						</div>
					</div>
					<?php endif; ?>
					<div class="{{dispPrice}}">
						<del data-wiz-item-full-price>{{FullPrice}}</del>
						<strong data-wiz-item-price class="price-color">{{FormatedPrice}}</strong>
						<div class="hide{{PreVat}} grid-vat"><?php _e('המחיר אינו כולל מע"מ', wizshop_pages)?></div>
					</div>
				</a>
				<div data-wiz-last-price>
					<a href="javascript:void(0);" data-wiz-show-last-price class="td-u"><?php _e('מחיר אחרון', wizshop_pages)?></a>
					<div data-wiz-last-price-view class="last-price-box-wrapper w-100 ">
					<div class="last-price-box b-1 p-2">
						<div data-wiz-last-price-data>
							<div name="{{lp-name}}" class="bb text-right  {{lp-name}} {{lp-class}} hide{{GeneralDiscountPrc}} ">
								<span class="last-price-title dsp-inlineblock hide{{GeneralDiscountPrc}}">{{lp-title}}</span> 
								{{lp-value}}
							</div>
						</div>
						<div data-wiz-item-report>
							<a href='<?php echo esc_url(wizshop_get_item_report_url())."?". wizshop_id_qvar. "={{Link}}"?>' class="td-u"><?php _e('לעמוד תנועות פריט', wizshop_pages)?></a>							
						</div>
						<a href="javascript:void(0);" data-wiz-close-last-price class="close-icon" >x</a>
					</div>
					</div>
				</div>
                <span class="grid-{{Status}}  pt-1 pb-3">
					<a href="<?php echo esc_url(wizshop_get_products_url())?>{{Link}}" class="btn primary grid-matrix{{MatrixType}} hesh{{Status}} w-100 mb-1 p-0 py-2"><?php _e('בחירת אפשרויות', wizshop_pages)?></a>
                    <a href="javascript:void(0);" data-wiz-item-to-cart="{{urlItemKey}}" data-wiz-packs-ctrl="{{PacksId}}" data-wiz-quant-ctrl="{{QuantId}}"
                       data-wiz-check-quant="1" data-wiz-item-row data-wiz-item-col class="btn primary {{dispCart}} to-cart w-100 mb-1">
                        <?php _e('הוספה לסל', wizshop_pages)?>
                    </a>
					
                    <a href="<?php echo esc_url(wizshop_get_products_url())?>{{Link}}" class="btn  primary-outline grid-more-info w-100 mb-1"><?php _e('מידע נוסף', wizshop_pages)?></a>
					<?php if(1 == wizshop_get_view_settings()['quick_view']): ?>
					<a href="javascript:void(0);" data-wiz-view-item='{{urlItemKey}}' class="btn primary show quick-view w-100 "><?php _e('מבט מהיר', wizshop_pages)?></a>
					<?php endif; ?>
                </span>
				<a href="<?php echo esc_url(wizshop_get_cart_url())?>" data-wiz-view-list='{{urlItemKey}}' class="v_ihide btn"><?php _e('הצגת סל', wizshop_pages)?></a>
            </script>
            </div>
        </div>
    </div>
</div>

<?php elseif ($wiz_products_view == 'table'): ?>
<div data-wizshop data-wiz-grid="<?php echo esc_attr($wiz_custom_id)?>" data-wiz-filter="<?php echo esc_attr($wiz_custom_filter)?>" class="container-fluid products-table">
    <input data-wiz-items-in-page type="hidden" value="<?php echo $wiz_items_in_page; ?>">
    <section data-wiz-container class="container-fluid">
            <!-- Each item -->
            <article data-wiz-item class="mb-1">
                <div data-wiz-item-data class="row align-items-center">
				<script type="text/html">
                    <!-- Picture -->
                    <aside class="col-2 col-md-1 mr-md-0 p-md-0 pr-3 px-0 mt-2 mt-md-0">
                        <img src="<?php esc_url(wizshop_image_name_link("{{ImageFile}}","wiz_grid"))?>" alt="{{Name}}">
                        <!-- Discount label -->
                        <label class="v_iSale {{dispSale}} m-0  discount-label discount-label-list hide-xs"></label>
                    </aside>

                    <!-- Title -->
                    <aside class="col-10 col-md-3 mt-2 mt-md-0">
                        <h4 class="product-title"><a href="<?php echo esc_url(wizshop_get_products_url())?>{{Link}}">{{Name}}</a></h4>
						<!-- Discount label -->
                        <label class="v_iSale {{dispSale}} m-0 px-3 discount-label discount-label-list show-xs"></label>
						<!-- Matrix -->
						 <div data-wiz-matrix class="row mt-2 mt-md-0 no-gutters">
							<div class="col-6 col-md-6 px-md-0">
								<select data-wiz-dim-1 class="product-demselect mb-1 mnw-100 ">
									<option data-wiz-no-item>{{mtxTitle1}}</option>
									<option data-wiz-mtx-item wiz_selection>{{mtxName}}</option>
								</select>
							</div>
							<div class="col-6 col-md-6 px-md-0">
								<select data-wiz-dim-2 class="product-demselect mnw-100 mr-2">
									<option data-wiz-no-item>{{mtxTitle2}}</option>
									<option data-wiz-mtx-item wiz_selection>{{mtxName}}</option>
								</select>
							</div>
                        </div>
                    </aside>

                    <!-- Amount and Rif. ID -->
                    <aside class="col-12 col-md-2 row m-0 mt-2 mt-md-0">
                        <!-- Ref. ID -->
                        <p data-wiz-kit-item class="m-0 p-0 col-6 col-md-12"><?php _e('מק"ט', wizshop_pages)?>: {{Key}}</p>
                        <!-- Amount -->
                        <p data-wiz-item-balance class="m-0 p-0 col-6 col-md-12"><?php _e('כמות', wizshop_pages)?>: {{Balance}}</p>
                    </aside>

                    <!-- Price -->
                    <aside class="col-12 col-md-1 px-0 px-md-0 m-0 row mt-2 mt-md-0 {{dispPrice}}">
                        <!-- PreDiscount Price -->
						<div class="col-6 col-md-12 px-md-0"><del data-wiz-item-full-price>{{FullPrice}}</del></div>
                        <!-- Final price -->
						<div class="col-6 col-md-12 px-md-0">
							<strong data-wiz-item-price class="price-color">{{FormatedPrice}}</strong>
							<div class="hide{{PreVat}} grid-vat"><?php _e('המחיר אינו כולל מע"מ', wizshop_pages)?></div>
						</div>
						                        
                    </aside>

                   <!-- Units -->
                    <aside class="col-12 col-md-2 m-0 px-0 row mt-2 mt-md-0 text-center">
                        <!-- By parts -->
						<div class="col-6 col-md-12 {{dispUnits}} Packs{{dispPacks}} {{dispCart}}">
							<label class="m-0 p-0"><?php _e('יחידות', wizshop_pages)?>:</label>
							<input type="number" wiz_QuantId="{{QuantId}}" data-wiz-packs-only="{{OnlyPacks}}" value="1" min="0" class="dsp-inlineblock price-input">
						</div>
                        <!-- By packages -->
                        <div class="{{dispPacks}} col-6 col-md-12 {{dispCart}}">
                            <label class="m-0 p-0"><?php _e('אריזות של', wizshop_pages)?> {{QntInPack}}:</label>
                            <input type="number" size="2" wiz_PacksId="{{PacksId}}" data-wiz-quant-in-pack="{{QntInPack}}" value="0" min="0" class="price-input">
                        </div>
                    </aside>

                    <aside class="col-12 col-md-2 m-0 px-0 row mt-2 mt-md-0">
                        <!-- Order button -->
                        <div class="{{dispCart}}  matrix{{MatrixType}} w-100 mb-1 col-6 col-md-12">
                            <!-- Add to basket button -->
                            <a href="javascript:void(0);"
                               data-wiz-item-to-cart="{{urlItemKey}}"
                               data-wiz-packs-ctrl="{{PacksId}}"
                               data-wiz-quant-ctrl="{{QuantId}}"
                               data-wiz-check-quant="1"
                               data-wiz-item-row data-wiz-item-col
                               class="btn primary w-100 ">
                                <?php _e('הוספה לסל', wizshop_pages)?>
                            </a>
                            <a href="<?php echo esc_url(wizshop_get_cart_url())?>" data-wiz-view-list='{{urlItemKey}}' class="v_ihide btn text-center w-100"><?php _e('הצגת סל', wizshop_pages)?></a>
							
                        </div>
						<!-- view item in case it's hash-tree -->
						<div class="w-100 col-6 col-md-12 hesh-cont lines-{{Status}}">
							<a href="<?php echo esc_url(wizshop_get_products_url())?>{{Link}}" class="btn primary matrix w-100"><?php _e('בחירת אפשרויות', wizshop_pages)?></a>
						</div>

                    </aside>
					 <!-- Wishlist -->
					<aside class="col-12 col-md-1 heart-container product-wishlist">
						<a href="javascript:void(0);" class="w-100 svg-btn" data-wiz-list-action-item='{{urlItemKey}}' data-wiz-type='WL' data-wiz-item-row data-wiz-item-col data-wiz-action='2' data-wiz-status="|itemtocartstatus|2">	
							<img src="<?php echo wizshop_img_file_url('heart border.svg')?>" class="svg-icon" title="<?php esc_attr_e('רשימת משאלות', wizshop_pages)?>">
						</a>
                        <a href="<?php echo esc_url(wizshop_get_wish_list_url())?>" data-wiz-type='WL' data-wiz-view-list='{{urlItemKey}}'   class="v_ihide  svg-btn w-100">
							<img src="<?php echo wizshop_img_file_url('heart.svg')?>" class="svg-icon" >
						</a>
                    </aside>
                </script>
                </div>
                <div class="clr"></div>
                <hr class="my-2">
            </article>
    </section>
</div>
<?php elseif ($wiz_products_view == 'lines'): ?>
<div data-wizshop data-wiz-grid="<?php echo esc_attr($wiz_custom_id)?>" data-wiz-filter="<?php echo esc_attr($wiz_custom_filter)?>" class="container-fluid products-lines">
    <input data-wiz-items-in-page type="hidden" value="<?php echo $wiz_items_in_page; ?>">
    <div data-wiz-container class="row">
        <!-- Each item -->
        <article data-wiz-item class="col-12 mb-2">
            <div data-wiz-item-data class="each-product">
			<script type="text/html">
                <!-- Product image -->
                <aside class="col-2 p-0 float-right">
                    <img src="<?php esc_url(wizshop_image_name_link("{{ImageFile}}","wiz_grid"))?>" alt="{{Name}}">
                    <!-- Discount label -->
                    <label class="v_iSale {{dispSale}} m-0 discount-label discount-label-rows"></label>
                </aside>

                <div class="col-10 float-left">
                    <header class="row m-0 mb-2">
                        <!-- Product title -->
                        <h4 class="p-0 m-0 product-title col"><a href="<?php echo esc_url(wizshop_get_products_url())?>{{Link}}">{{Name}}</a></h4>
                        <span data-wiz-kit-item class="dsp-inlineblock pl-3"><?php _e('כמות בסל', wizshop_pages)?>: <span data-wiz-quant-in-cart> {{QntInCart}} </span> </span>
                        <span data-wiz-item-balance class="text-left m-0 dsp-inlineblock"><?php _e('במלאי', wizshop_pages)?>: {{Balance}}</span>
                    </header>

                    <!-- Content -->
                    <section>
                      <div class=""><?php _e('מק"ט', wizshop_pages)?>: {{Key}}</div>
                        <del data-wiz-item-full-price>{{FullPrice}}</del>
						  <strong data-wiz-item-price class="price-color">{{FormatedPrice}}</strong>
						  <span class="hide{{PreVat}} grid-vat"><?php _e('המחיר אינו כולל מע"מ', wizshop_pages)?></span>
                        <div class="product-description">
                            {{Description}}
                        </div>
                    </section>
                    <footer class="align-items-end dsp-flex justify-content-start mt-2 row">
                        <div data-wiz-matrix class=" col-lg-auto mb-2 ml-2">
                            <select data-wiz-dim-1 class="product-demselect">
                                <option data-wiz-no-item wiz_selection>{{mtxTitle1}}</option>
                                <option data-wiz-mtx-item >{{mtxName}}</option>
                            </select>
						
                            <select data-wiz-dim-2 class="product-demselect">
                                <option data-wiz-no-item wiz_selection>{{mtxTitle2}}</option>
                                <option data-wiz-mtx-item wiz_selection>{{mtxName}}</option>
                            </select>
                        </div>


                        <!-- Options -->
                        <div class="{{dispCart}}  matrix{{MatrixType}} text-center  col-lg-auto mb-2">
                            <div class="{{dispUnits}} row  m-0 ml-1">
                              <div>
							  <div class="dsp-block {{dispPacks}}"><?php _e('יחידות', wizshop_pages)?>:</div>
                                <input type="number" wiz_QuantId="{{QuantId}}" data-wiz-packs-only="{{OnlyPacks}}" value="1" min="0"  class=" price-input">
							</div>
								 <!-- By packages -->
							<div class="{{dispPacks}}">
								<p class="m-0 p-0"><?php _e('אריזות של', wizshop_pages)?> {{QntInPack}}:</p>
								<input type="number" size="2" wiz_PacksId="{{PacksId}}" data-wiz-quant-in-pack="{{QntInPack}}" min="0"  value="0" class="price-input">
							</div>
                            </div>
                            
                        </div>

                        <div class="{{dispCart}}  matrix{{MatrixType}} col-6 col-md-auto mb-2 ">
                            <!-- Add to basket button -->
                            <a href="javascript:void(0);"
                               data-wiz-item-to-cart="{{urlItemKey}}"
                               data-wiz-packs-ctrl="{{PacksId}}"
                               data-wiz-quant-ctrl="{{QuantId}}"
                               data-wiz-check-quant="1"
                               data-wiz-item-row data-wiz-item-col
                               class="btn primary">
                                <?php _e('הוספה לסל', wizshop_pages)?>
                            </a>
                            <a href="<?php echo esc_url(wizshop_get_cart_url())?>" data-wiz-view-list='{{urlItemKey}}' class="v_ihide"><?php _e('הצגת סל', wizshop_pages)?></a>
                        </div>
						<div class="col-6 col-md-auto mb-2 hesh-cont lines-{{Status}} " >
							<a href="<?php echo esc_url(wizshop_get_products_url())?>{{Link}}" class="btn primary"><?php _e('בחירת אפשרויות', wizshop_pages)?></a>
						</div>
                        <div class="col-6 col-md-auto mb-2 product-wishlist" >
                            <a href="javascript:void(0);" class="btn primary-outline " data-wiz-list-action-item='{{urlItemKey}}' data-wiz-type='WL' data-wiz-item-row data-wiz-item-col data-wiz-action='2'data-wiz-status="|itemtocartstatus|2"><?php _e('לרשימת המשאלות', wizshop_pages)?></a>
                            <a href="<?php echo esc_url(wizshop_get_wish_list_url())?>" data-wiz-type='WL' data-wiz-view-list='{{urlItemKey}}'   class="v_ihide"><?php _e('הצגת רשימה', wizshop_pages)?></a>
                        </div>

                    </footer>
                </div>
                <div class="clr"></div>
				
            </script>
            </div>
            <hr class="m-0 mt-2">
        </article>
    </div>
</div>
<?php endif; ?>
