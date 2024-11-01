<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>


<div class="basket-add-message p-3 mb-3 w-100 v_ihide single_item_message " id="dismiss-message" data-wizshop data-wiz-status-report="single-item-msg" >
	<!-- Here will come some message -->
	<span class="dsp-inlineblock" data-wiz-status-text></span>
	<!-- Here will come basket btn -->
	<a href="<?= esc_url(wizshop_get_cart_url())?>" class="see-cart"> | <strong><?php _e('הצגת סל', wizshop_pages)?></strong></a>

	<a href="javascript:void(0);" data-wiz-close-status  class="dsp-inlineblock float-left basket-dismiss-btn" > 
		<img src="<?php echo wizshop_img_file_url('close.svg')?>" class="svg-icon basket-dismiss-icon">
	</a>
	<div class="clr"></div>
</div> 
<div data-wizshop="" class="container-fluid" data-wiz-product="<?= esc_attr(wizshop_get_id_var()); ?>">

    <div data-wiz-item-data class="row justify-content-end">
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
			<!-- contact us (if v_istat4) -->
			<div class="{{Status}}"></div>
            <!--div class="my-1 my-md-3 btn-{{Status}} btn-contact"  data-wiz-details >
				<a href="<?php echo wizshop_get_cart_call_url()?>?item={{ItemKey}}" wiz_logout class="btn primary"><?php _e('נא פנו אלינו לביצוע הזמנה', wizshop_pages)?></a>	
				<a href="javascript:void(0);" data-wiz-post-cart wiz_login data-wiz-status="single-item-msg|send_cart_p|15" class="v_ihide"><?php _e('נא פנו אלינו לביצוע הזמנה', wizshop_pages)?></a>				
			</div-->
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
                <select data-wiz-dim-1 class="product-demselect w-25">
                    <option data-wiz-no-item wiz_selection>{{mtxTitle1}}</option>
                    <option data-wiz-mtx-item >{{mtxName}}</option>
                </select>
                <select data-wiz-dim-2 class="product-demselect w-25">
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
					<span class="ml-1 "><?php _e('יחידות', wizshop_pages)?></span>
					<input type="number" size="2" wiz_QuantId="{{QuantId}}" data-wiz-packs-only="{{OnlyPacks}}" value="1" min="0" class="dsp-inlineblock price-input">
				</span>

				<!-- Packages -->
				<span class="{{dispCart}} {{dispPacks}} py-2 mx-2 dsp-inlineblock">
					<span class="ml-1"><?php _e('אריזות של', wizshop_pages)?> {{QntInPack}}</span>
					<input type="number" size="2" wiz_PacksId="{{PacksId}}" data-wiz-quant-in-pack="{{QntInPack}}" value="0" min="0" class="dsp-inlineblock price-input">
				</span>
			</div>
			 <!-- Cart Remark -->
			 <div class="{{dispCart}} {{dispRemark}} my-1 my-md-3">	
				<div><?php _e('הערה לפריט זה', wizshop_pages)?>:</div> 
				<input type="text" class="w-75" wiz_RemarkId="{{RemarkId}}" value="">
	  
			</div>
			<!-- Add to basket buttons -->
			<div class="my-2 my-md-3 {{dispCart}} disp-{{Status}}  matrix{{MatrixType}}">
				<a href="javascript:void(0);" class="btn primary primary-outline wl{{Status}}" data-wiz-list-action-item='{{urlItemKey}}' data-wiz-type='FX' data-wiz-item-row data-wiz-item-col data-wiz-action='2' wiz_login data-wiz-status="single-item-msg|itemtofx|15"><?php _e('העברה לסל קבוע', wizshop_pages)?></a>
				<a href="javascript:void(0);" class="btn primary primary-outline wl{{Status}}"  data-wiz-list-action-item='{{urlItemKey}}' data-wiz-type='WL' data-wiz-item-row data-wiz-item-col data-wiz-action='2' data-wiz-status="single-item-msg|itemtowl|15"> <?php _e('העברה לרשימת המשאלות', wizshop_pages)?> </a>
				<div class="show-xs my-3"></div>
				<a href="javascript:void(0);" data-wiz-status="single-item-msg|add-to-cart|0" data-wiz-item-to-cart='{{urlItemKey}}' data-wiz-packs-ctrl="{{PacksId}}" data-wiz-quant-ctrl="{{QuantId}}" data-wiz-check-quant="1" data-wiz-remark-ctrl="{{RemarkId}}"  data-wiz-item-row data-wiz-item-col class="btn primary "><?php _e('הוספת הפריט לסל', wizshop_pages)?> </a>
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
			
			
			<!-- items in kit (פריט ערכה)-->
			<div data-wiz-kit class="v_kits my-1 my-md-3">
			<h2 class="tree-title"><?php _e('זהו פריט ערכה הכולל', wizshop_pages)?>: </h2>
				<table data-wiz-kit-item-container class="product-picklist">
					<tbody>
						<tr data-wiz-kit-item class="kit-item">
							<td class="img-col"><a href='<?= esc_url(wizshop_get_products_url())?>{{Link}}'><img src ="<?php esc_url(wizshop_image_name_link("{{ImageFile}}","wiz_thumb"))?>" alt="{{Name}}"></a></td>
							<td class="description"><a href='<?= esc_url(wizshop_get_products_url())?>{{Link}}'><span>{{Name}}</span> ({{Quantity}})</a></td>
							<td class="refid"><?php _e('מק"ט', wizshop_pages)?>: {{Key}}</td>
						</tr>
					</tbody>
				</table>
			</div>

			<!-- included in kits (הפריט משתתף בערכות) -->
			<div data-wiz-parent-kits class="v_kits my-1 my-md-3">
				<h2 class="tree-title"><?php _e('פריט משתתף בערכות הבאות', wizshop_pages)?>:</h2>
				<div data-wiz-kit-item-container class="product-picklist">	
					<div data-wiz-kit-item class="tree-border p-2">
						<div data-wiz-item-data class="row">
							<!-- Right - image -->
							<aside class="col-md-2 col-sm-4 col-4">
								<a href="<?= esc_url(wizshop_get_products_url())?>{{Link}}"><img src="<?php esc_url(wizshop_image_name_link("{{ImageFile}}","wiz_thumb"))?>" alt="{{Name}}"></a>
							</aside>

							<!-- Left- body -->
							<aside class="col-md-10 col-sm-8 col-8 row no-gutters align-content-center justify-content-between">
								<div class="col-auto">
									<!-- Product title -->
									<h3 class="tree-eachitem-title p-0 m-0">
										<a href="<?= esc_url(wizshop_get_products_url())?>{{Link}}">{{Name}}</a>
									</h3>
									<!-- Ref. ID -->
									<small><?php _e('מק"ט', wizshop_pages)?>: {{Key}}</small>
								</div>

								<div class="col-md-auto col-12 {{dispPrice}}">
									<!-- Price -->
									<del data-wiz-item-full-price class="dsp-block">{{FullPrice}}</del>
									<strong data-wiz-item-price class="price-color">{{FormatedPrice}}</strong>
								</div>
								<div class="{{dispCart}} {{dispRemark}} col-auto">	
											<div> <?php _e('הערה לפריט זה', wizshop_pages)?>:  </div> 
											<input type="text" class="w-75" wiz_RemarkId="{{RemarkId}}" value="">
								  
								</div>
								<div class="align-self-center col-auto">
									<!-- Each -->
									<span class="{{dispCart}} {{dispUnits}} py-2 dsp-inlineblock">
										<span class="ml-1 {{dispPacks}}"><?php _e('יחידות', wizshop_pages)?></span>
										<input type="number" size="2" min="0" wiz_QuantId="{{QuantId}}" data-wiz-packs-only="{{OnlyPacks}}" value="1" class="dsp-inlineblock price-input">
									</span>

									<!-- Packages -->
									<span class="{{dispCart}} {{dispPacks}} py-2 mx-2 dsp-inlineblock">
										<span class="ml-1"><?php _e('אריזות של', wizshop_pages)?> {{QntInPack}}</span>
										<input type="number" size="2" min="0" wiz_PacksId="{{PacksId}}" data-wiz-quant-in-pack="{{QntInPack}}" value="0" class="dsp-inlineblock price-input">
									</span>
								</div>

								<div class="align-self-center col-auto">
									<span class="{{dispCart}}"><a href="javascript:void(0);" data-wiz-item-to-cart='{{urlItemKey}}' data-wiz-packs-ctrl="{{PacksId}}" data-wiz-quant-ctrl="{{QuantId}}" data-wiz-check-quant="1" data-wiz-item-row data-wiz-item-col data-wiz-remark-ctrl="{{RemarkId}}" data-wiz-status="single-item-msg|add-to-cart|0" class="btn primary"><?php _e('הוספה לסל', wizshop_pages)?></a></span>
									<a href="<?= esc_url(wizshop_get_cart_url())?>" data-wiz-view-list='{{urlItemKey}}'  class="v_ihide btn primary-outline mt-2 mt-md-0"><?php _e('הצגת סל', wizshop_pages)?></a>
								</div>
							</aside>
						</div>
					</div>
				</div>
			</div>
		
		<!-- Hesh (עץ חשבונית) -->
			<div class="my-1 my-md-3">
				<!-- Title -->
				<h2 data-wiz-hesh-head class="tree-title"><?php _e('עץ חשבונית', wizshop_pages)?></h2>

					<!-- Content -->
					<div data-wiz-hesh-item-container>
						<!-- Each item -->
						<div data-wiz-hesh-item class="tree-border p-2">
							<div data-wiz-item-data class="row">
								<!-- Right - image -->
								<aside class="col-md-2 col-sm-4 col-4">
									<a href="<?= esc_url(wizshop_get_products_url())?>{{Link}}"><img src="<?php esc_url(wizshop_image_name_link("{{ImageFile}}","wiz_thumb"))?>" alt="{{Name}}"></a>
								</aside>

								<!-- Left- body -->
								<aside class="col-md-10 col-sm-8 col-8 row no-gutters align-content-center justify-content-between">
									<div class="col-auto">
										<!-- Product title -->
										<h3 class="tree-eachitem-title p-0 m-0">
											<a href="<?= esc_url(wizshop_get_products_url())?>{{Link}}">{{Name}}</a>
										</h3>
										<!-- Ref. ID -->
										<small><?php _e('מק"ט', wizshop_pages)?>: {{Key}}</small>
			
									</div>

									<div class="col-md-auto col-12 {{dispPrice}}">
										<!-- Price -->
										<del data-wiz-item-full-price class="dsp-block">{{FullPrice}}</del>
										<strong data-wiz-item-price class="price-color">{{FormatedPrice}}</strong>
									</div>
									<div class="{{dispCart}} {{dispRemark}} col-auto">	
												<div> <?php _e('הערה לפריט זה', wizshop_pages)?>:  </div> 
												<input type="text" class="w-75" wiz_RemarkId="{{RemarkId}}" value="">
									  
									</div>
									<div class="align-self-center col-auto">
										<!-- Each -->
										<span class="{{dispCart}} {{dispUnits}} py-2 dsp-inlineblock">
											<span class="ml-1 {{dispPacks}}"><?php _e('יחידות', wizshop_pages)?></span>
											<input type="number" min="0" size="2" wiz_QuantId="{{QuantId}}" data-wiz-packs-only="{{OnlyPacks}}" value="1" class="dsp-inlineblock price-input">
										</span>

										<!-- Packages -->
										<span class="{{dispCart}} {{dispPacks}} py-2 mx-2 dsp-inlineblock">
											<span class="ml-1"><?php _e('אריזות של', wizshop_pages)?> {{QntInPack}}</span>
											<input type="number" min="0" size="2" wiz_PacksId="{{PacksId}}" data-wiz-quant-in-pack="{{QntInPack}}" value="0" class="dsp-inlineblock price-input">
										</span>
									</div>

									<div class="align-self-center col-auto">
										<span class="{{dispCart}}"><a href="javascript:void(0);" data-wiz-item-to-cart='{{urlItemKey}}' data-wiz-packs-ctrl="{{PacksId}}" data-wiz-quant-ctrl="{{QuantId}}" data-wiz-check-quant="1" data-wiz-item-row data-wiz-item-col data-wiz-remark-ctrl="{{RemarkId}}"  class="btn primary"><?php _e('הוספה לסל', wizshop_pages)?></a></span>
										<a href="<?= esc_url(wizshop_get_cart_url())?>" data-wiz-view-list='{{urlItemKey}}'  class="v_ihide btn primary-outline mt-2 mt-md-0"><?php _e('הצגת סל', wizshop_pages)?></a>
									</div>
								</aside>
							</div>
						</div>
					</div>
				<div class="my-2">
					<a href="javascript:void(0);" data-wiz-hesh-items-to-cart data-wiz-status="single-item-msg|hesh-to-cart|15"  class="btn primary"  ><?php _e('הוספת כל הרשימה לסל', wizshop_pages)?> </a>
					<a href="<?php echo esc_url(wizshop_get_cart_url())?>" data-wiz-view-list data-wiz-type='hesh-LIST' class="v_ihide  btn primary-outline" title="הצג סל קניות"> <?php _e('הצגת הסל', wizshop_pages)?></a>
				</div>
			</div>
			<!-- Additional products (מוצרים משלימים) -->
			<div class="my-1 my-md-3">
			<!-- Title -->			
			<h2 data-wiz-comp-head class="tree-title"><?php _e('מוצרים משלימים', wizshop_pages)?></h2>
				<!-- Content -->
				<div data-wiz-comp-item-container>
					<!-- Each item -->
					<div data-wiz-comp-item class="tree-border p-2">
						<div data-wiz-item-data class="row">
							<!-- Right - image -->
							<aside class="col-md-2 col-sm-4 col-4">
								<a href="<?= esc_url(wizshop_get_products_url())?>{{Link}}"><img src="<?php esc_url(wizshop_image_name_link("{{ImageFile}}","wiz_thumb"))?>" alt="{{Name}}"></a>
							</aside>

							<!-- Left- body -->
							<aside class="col-md-10 col-sm-8 col-8 row no-gutters align-content-center justify-content-between">
								<div class="col-auto">
									<!-- Product title -->
									<h3 class="tree-eachitem-title p-0 m-0">
										<a href="<?= esc_url(wizshop_get_products_url())?>{{Link}}">{{Name}}</a>
									</h3>
									<!-- Ref. ID -->
									<small><?php _e('מק"ט', wizshop_pages)?>: {{Key}}</small>
								</div>

								<div class="col-md-auto col-12 {{dispPrice}} ">
									<!-- Price -->
									<del data-wiz-item-full-price class="dsp-block {{dispPrice}}">{{FullPrice}}</del>
									<strong data-wiz-item-price class="price-color {{dispPrice}}">{{FormatedPrice}}</strong>
								</div>
								<div class="{{dispCart}} {{dispRemark}} col-auto">	
											<div> <?php _e('הערה לפריט זה', wizshop_pages)?>:  </div> 
											<input type="text" class="w-75" wiz_RemarkId="{{RemarkId}}" value="">
								  
								</div>
								<div class="align-self-center col-auto">
									<!-- Each -->
									<span class="{{dispCart}} {{dispUnits}} py-2 dsp-inlineblock">
										<span class="ml-1 {{dispPacks}}"><?php _e('יחידות', wizshop_pages)?></span>
										<input type="number" size="2" min="0" wiz_QuantId="{{QuantId}}" data-wiz-packs-only="{{OnlyPacks}}" value="1" class="dsp-inlineblock price-input">
									</span>

									<!-- Packages -->
									<span class="{{dispCart}} {{dispPacks}} py-2 mx-2 dsp-inlineblock">
										<span class="ml-1"><?php _e('אריזות של', wizshop_pages)?> {{QntInPack}}</span>
										<input type="number" size="2" min="0" wiz_PacksId="{{PacksId}}" data-wiz-quant-in-pack="{{QntInPack}}" value="0" class="dsp-inlineblock price-input">
									</span>
								</div>
								<div class="align-self-center col-auto p-0 matrix{{MatrixType}} grid-{{Status}}">
									<span class="{{dispCart}}"><a href="javascript:void(0);" data-wiz-item-to-cart='{{urlItemKey}}' data-wiz-packs-ctrl="{{PacksId}}" data-wiz-quant-ctrl="{{QuantId}}" data-wiz-check-quant="1" data-wiz-item-row data-wiz-item-col data-wiz-remark-ctrl="{{RemarkId}}" class="btn primary"><?php _e('הוספה לסל', wizshop_pages)?></a></span>
									<a href="<?php echo esc_url(wizshop_get_products_url())?>{{Link}}" class="btn primary grid-matrix{{MatrixType}} hesh{{Status}} w-100 mb-1 p-0 py-2"><?php _e('בחירת אפשרויות', wizshop_pages)?></a>
									<a href="<?= esc_url(wizshop_get_cart_url())?>" data-wiz-view-list='{{urlItemKey}}'  class="v_ihide btn primary-outline"><?php _e('הצגת סל', wizshop_pages)?></a>
								</div>
							</aside>
						</div>
					</div>
				</div>	
			</div>
		</section>
    
    <div class="clr"></div>
	</script>
</div>
</div>

