<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
if (defined('__wizshop_quick_view')) return;
define('__wizshop_quick_view', '');

$view_op = wizshop_get_view_settings();
if(1 == $view_op['quick_view']): 
?>
<div class="quickview-lightbox" data-wizshop data-wiz-product id="wiz-item-q-view" >
	<div class="quickview-content">
		<div class="quickview-close-button">
			<a href="javascript:void(0);" class="p-2" data-wiz-item-close-view>
			<img src="<?php echo wizshop_img_file_url('close.svg')?>" class="svg-icon">
			</a>
		</div>
	
		<div class="quickview-item-wrapper">
	
		<div class="quickview-item  p-4">
			<div class="basket-add-message p-3 mb-3 w-100 v_ihide single_item_message " id="dismiss-message" data-wizshop data-wiz-status-report="quick-view-item-msg" data-wiz-scroll-into>
			<!-- Here will come some message -->
			<span class="dsp-inlineblock" data-wiz-status-text></span>
			<!-- Here will come basket btn -->
			<a href="<?= esc_url(wizshop_get_cart_url())?>" class="see-cart"> | <strong><?php _e('הצגת סל', wizshop_pages)?></strong></a>

			<a href="javascript:void(0);" data-wiz-close-status  class="dsp-inlineblock float-left basket-dismiss-btn" > 
				<img src="<?php echo wizshop_img_file_url('close.svg')?>" class="svg-icon basket-dismiss-icon">
			</a>
			<div class="clr"></div>
		</div> 
			<div data-wiz-item-data class="justify-content-end row">
				<script type="text/html">

				<!-- Title (mobile) -->
         <h1 class="col-12 show-xs">{{Name}}</h1>
        <!-- Product pictures -->
        <aside class="col-md-4 col-sm-12 col-12" style="position: relative">
            <div class="each-product mb-2 row">
                <!-- Discount label -->
                <label class="v_iSale {{dispSale}} m-0 px-3 discount-label"></label>
                <!-- Main picture -->
				<a href="<?php esc_url(wizshop_image_name_link("{{ImageFile}}",""))?>">
					<img src="<?php esc_url(wizshop_image_name_link("{{ImageFile}}","wiz_product"))?>" alt="{{Name}}" class="w-100 p-2">
				</a>
            </div>
            <!-- Additional picture -->
            <div data-wiz-item-img-container  data-wiz-ignore-cur class="row">
                <div data-wiz-item-img class="col-sm-6 col-md-4 p-2">
				<a href="<?php esc_url(wizshop_image_name_link("{{BigImageFile}}",""))?>">
                    <img src="<?php esc_url(wizshop_image_name_link("{{BigImageFile}}","wiz_thumb"))?>" alt="{{Name}}">
                </a>
				</div>
            </div>
        </aside>

        <!-- Product details -->
        <section class="col-md-8 col-sm-12 col-12 mt-2 mt-sm-0">
            <header class="row">
                <!-- Title (desktop) -->
                <h1 class="col-12 hide-xs">{{Name}}</h1>
				<!-- Item Key -->
				<div class="col-12 my-1 my-md-3"><?php _e('מק"ט', wizshop_pages)?> : {{ItemKey}} </div>
            </header>
			<div class="my-1 my-md-3 {{dispRange}}">
				<strong class="price-color">{{priceRange}}</strong>
			</div>
            <div class="my-1 my-md-3 {{dispPrice}}">
				<!-- Price (full, final)  -->			
				<del data-wiz-item-full-price class="dsp-inlineblock price-color">{{FullPrice}}</del>
				<strong data-wiz-item-price class="dsp-inlineblock price-color" >{{FormatedPrice}}</strong>
				<span class="hide{{PreVat}}"><?php _e('(לפני מע"מ)', wizshop_pages)?></span>
            </div>
			<!-- Blanace -->
            <div data-wiz-item-balance class="my-1 my-md-3"><?php _e('מלאי', wizshop_pages)?>: {{Balance}} </div>
            
            <!-- Matrix -->
            <div class="my-1 my-md-3" data-wiz-matrix>
                <select data-wiz-dim-1 class="product-demselect">
                    <option data-wiz-no-item wiz_selection>{{mtxTitle1}}</option>
                    <option data-wiz-mtx-item >{{mtxName}}</option>
                </select>
                <select data-wiz-dim-2 class="product-demselect">
                    <option data-wiz-no-item wiz_selection>{{mtxTitle2}}</option>
                    <option data-wiz-mtx-item >{{mtxName}}</option>
                </select>
            </div>
		
			<!-- Quantity -->
		
			<div class="my-1 my-md-3">
				<!-- Packages Title -->
				<h5 class="w-100 mt-2 {{dispPacks}}">
					<img src="<?php echo wizshop_img_file_url('info.svg')?>" class="svg-icon info">
					<?php _e('פריט זה מגיע', wizshop_pages)?>
					<span class="{{dispUnits}}"><?php _e('ביחידות ו', wizshop_pages)?></span><?php _e('אריזות', wizshop_pages)?>
				</h5>

				<!-- Single -->
				<span class="{{dispCart}} {{dispUnits}} py-2 dsp-inlineblock">
					<span class="ml-1"><?php _e('יחידות', wizshop_pages)?></span>
					<input type="number" size="2" wiz_QuantId="{{QuantId}}" data-wiz-packs-only="{{OnlyPacks}}" value="1" class="dsp-inlineblock price-input">
				</span>

				<!-- Packages -->
				<span class="{{dispCart}} {{dispPacks}} py-2 mx-2 dsp-inlineblock">
					<span class="ml-1"><?php _e('אריזות של', wizshop_pages)?> {{QntInPack}}</span>
					<input type="number" size="2" wiz_PacksId="{{PacksId}}" data-wiz-quant-in-pack="{{QntInPack}}" value="0" class="dsp-inlineblock price-input">
				</span>
			</div>
			 <!-- Cart Remark -->
			 <div class="{{dispCart}} {{dispRemark}} my-1 my-md-3">	
				<div><?php _e('הערה לפריט זה', wizshop_pages)?>:</div> 
				<input type="text" class="w-75" wiz_RemarkId="{{RemarkId}}" value="">
	  
			</div>
			<!-- Add to basket buttons -->
			<div class="my-2 my-md-3 {{dispCart}}  matrix{{MatrixType}}">
				<a href="javascript:void(0);" class="btn primary primary-outline" data-wiz-list-action-item='{{urlItemKey}}' data-wiz-type='FX' data-wiz-item-row data-wiz-item-col data-wiz-action='2' wiz_login data-wiz-status="quick-view-item-msg|itemtofx|15"><?php _e('העברה לסל קבוע', wizshop_pages)?></a>
				<a href="javascript:void(0);" class="btn primary primary-outline"  data-wiz-list-action-item='{{urlItemKey}}' data-wiz-type='WL' data-wiz-item-row data-wiz-item-col data-wiz-action='2' data-wiz-status="quick-view-item-msg|itemtowl|15"> <?php _e('העברה לרשימת המשאלות', wizshop_pages)?> </a>
				<div class="show-xs my-3"></div>
				<a href="javascript:void(0);" data-wiz-status="quick-view-item-msg|add-to-cart|0" data-wiz-item-to-cart='{{urlItemKey}}' data-wiz-packs-ctrl="{{PacksId}}" data-wiz-quant-ctrl="{{QuantId}}" data-wiz-check-quant="1" data-wiz-remark-ctrl="{{RemarkId}}"  data-wiz-item-row data-wiz-item-col class="btn primary "><?php _e('הוספת הפריט לסל', wizshop_pages)?> </a>
				<a href="<?= esc_url(wizshop_get_cart_url())?>" data-wiz-view-list='{{urlItemKey}}'  class="v_ihide btn primary-outline"><?php _e('הצגת סל', wizshop_pages)?></a>
			</div>
	
			<!-- Description -->
			<div class="my-1 my-md-3">{{Description}}</div>
			<!-- Properties (נתון נוסף מסוג מאפיין) -->
			<table class="col-12 p-0 my-1 my-md-3 properties-table">
				<thead data-wiz-tab-prop-head>
					<tr>
						<th colspan="2"><?php _e('נתונים כלליים', wizshop_pages)?></th>
					</tr>
				</thead>
				<tbody  data-wiz-item-tab-prop-container>
					<tr data-wiz-item-prop class="col-12">
						<td class="param">{{PropName}}</td>
						<td class="value">{{PropVal}}</td>
					</tr>
				</tbody>
			</table>
			<!-- Properties (נתון נוסף מסוג כותרת) -->
			<table class="col-12 p-0 my-1 my-md-3 properties-table">
				<thead data-wiz-top-prop-head>
					<tr>
						<th colspan="2"><?php _e('נתונים כלליים', wizshop_pages)?></th>
					</tr>
				</thead>
				<tbody  data-wiz-item-top-prop-container>
					<tr data-wiz-item-prop class="col-12">
						<td class="param">{{PropName}}</td>
						<td class="value">{{PropVal}}</td>
					</tr>
				</tbody>		
			</table>
			
					
				</section>
					
				</script>
			</div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
