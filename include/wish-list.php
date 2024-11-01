<?php 
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<div data-wiz-status-report="wish-list" data-wizshop class="stat_div basket-add-message p-3 mb-3 w-100 v_ihide">
	<span data-wiz-status-text></span>
	<span data-wiz-close-status class="dsp-inlineblock float-left basket-dismiss-btn">
		<img src="<?php echo wizshop_img_file_url('close.svg')?>" class="svg-icon basket-dismiss-icon">
	</span>
	<div class="clr"></div>
</div>
<div id="wiz-wish-list" class="v_cart v_ihide" data-wiz-shopping-list='WL' data-wizshop data-auto-hide>
<div data-wiz-list-container class="basket-table responsive-table basket-flex w-100">
	<div class="basket-thead row justify-content-between  align-items-center mx-0 no-gutters px-md-2 hide-xs" data-wiz-list-head>
		<div class="product-thumbnail col-3 col-md-1"><?php _e('תמונה', wizshop_pages)?></div>
		<aside class="product-info mxw-100 flex-grow-1 col-md-11 col-8 row align-items-center justify-content-between pr-3">
			<div class="product-name col-md-3  flex-grow-1 mxw-25"><?php _e('מוצר', wizshop_pages)?></div>		
			<div class="product-key col-md-1"><?php _e('מפתח', wizshop_pages)?></div>
			<div class="product-balance {{dispBalance}} col-md-1"><?php _e('מלאי', wizshop_pages)?></div>
			<div class="product-price col-md-2"><?php _e('מחיר', wizshop_pages)?></div>
			<div class="product-quantity col-md-2"><?php _e('כמות', wizshop_pages)?></div>
			<div class="product-addtocart col-md-2 text-left" ></div>
			<div class="product-delete col-md-1"></div>
		</aside>
  	</div>
	<div data-wiz-list-item class="align-items-center justify-content-between mx-0 no-gutters row basket-row py-2 px-md-2">
		<script type="text/html">
		<aside class="product-thumbnail col-3 col-md-1 align-self-start" >
			<a href='<?php echo esc_url(wizshop_get_products_url())?>{{Link}}'>
				<img src="<?php esc_url(wizshop_image_name_link("{{ImageFile}}","wiz_thumb"))?>" alt="{{Name}}">
			</a>
		</aside>	
		<aside class="align-items-center col-9 col-md-11 flex-grow-1 justify-content-between mxw-100 pr-3 product-info row">
			<div class="product-name col-12 flex-grow-1 mxw-25 mxw-auto-xs col-md-3 pb-2 pb-md-0">
				<a href='<?php echo esc_url(wizshop_get_products_url())?>{{Link}}'>
					{{Name}}
				</a>
			</div>
			<div class="product-key col-12 col-md-1 pb-2 pb-md-0 ">
				<strong>{{Key}}</strong>
			</div>
			<div class="product-balance {{dispBalance}} col-12  col-md-1 pb-2 pb-md-0">
				<strong class="show-xs"><?php _e('מלאי', wizshop_pages)?></strong>
				{{Balance}}
			</div>		
			<div class="product-price {{dispPrice}} col-12 col-md-2 pb-2 pb-md-0">
				<strong class="show-xs"><?php _e('מחיר', wizshop_pages)?></strong>
				{{Price-P}}
			</div>
			<div class="product-quantity col-12 col-md-2 row pb-2 pb-md-0 no-gutters ">
				<span class="{{dispUnits}} {{dispCart}} col-md-12 col-3">
					<input type="number" min="0" size="2" wiz_QuantId="{{QuantId}}" data-wiz-packs-only="{{OnlyPacks}}" value="1" class="mxw-100 py-2">	
					<label class="{{dispPacks}}"> <?php _e('יחידות', wizshop_pages)?> </label>
				</span>
				<span class="{{dispPacks}} {{dispCart}} col-md-12 col-3" >
					<input type="number" size="2" min="0" wiz_PacksId="{{PacksId}}" data-wiz-quant-in-pack="{{QntInPack}}" value="0" class="mxw-100 py-2">
					<label><?php _e('אריזות של', wizshop_pages)?> {{QntInPack}} </label>
				</span>
			</div>
			<div class="product-addtocart col-md-2 col-auto text-left text-right-xs pb-2 pb-md-0" >
				<div class="{{Status}}"></div>
				<a href="javascript:void(0);" data-wiz-item-to-cart='{{Key}}' data-wiz-packs-ctrl="{{PacksId}}" data-wiz-quant-ctrl="{{QuantId}}" data-wiz-check-quant="1" data-wiz-item-row data-wiz-item-col data-wiz-status="wish-list||15" class="{{dispCart}} link">
					<img src="<?php echo wizshop_img_file_url('cart light.svg')?>" class="svg-icon">
					<?php _e('העברה לסל', wizshop_pages)?>
				</a>
				<br class="hide-xs"/>
				<a href="<?php echo esc_url(wizshop_get_cart_url())?>" data-wiz-view-list='{{urlItemKey}}' class="v_ihide link pr-2">
				<img src="<?php echo wizshop_img_file_url('check.svg')?>" class="svg-icon">
				<?php _e('הצגת סל', wizshop_pages)?></a>
			</div>
			<div class="product-delete col-auto col-md-1 pb-2 pb-md-0" >
				<a href="javascript:void(0);" data-wiz-list-action-item='{{Key}}' 
				data-wiz-matrix-key='{{matrixKey}}'  data-wiz-type='WL' data-wiz-action='3' data-wiz-status="wish-list||15">
					<img src="<?php echo wizshop_img_file_url('delete.svg')?>" class="svg-icon">
					<span class="show-xs"><?php _e('הסרה', wizshop_pages)?></span>
				</a>
			</div>
		</aside>
		</script>
	</div>
 </div>
</div>
<div class="empty-basket">
	<p class="cart-empty"><?php _e('רשימת המשאלות עדיין ריקה.', wizshop_pages)?> </p>
	<a class="btn primary-outline" href="/"><?php _e('לעמוד הראשי', wizshop_pages)?></a>
</div>