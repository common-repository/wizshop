<?php 
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<div data-wiz-status-report="post_cart_id" data-wiz-scroll-into  data-wizshop  class="stat_div basket-add-message p-3 mb-3 w-100 v_ihide">
	<span data-wiz-status-text></span>
	<a href='<?php echo esc_url(wizshop_get_personal_area_url(true))?>' class="update-info"><?php _e('לעדכון פרטים', wizshop_pages)?> </a>
	<span data-wiz-close-status class="dsp-inlineblock float-left basket-dismiss-btn">
		<img src="<?php echo wizshop_img_file_url('close.svg')?>" class="svg-icon basket-dismiss-icon">
	</span>
	<div class="clr"></div>
</div>
<div id="wiz-cart" class="v_cart v_ihide" data-wiz-shopping-cart data-wizshop data-auto-hide>
	<div data-wiz-cart-container class="basket-table responsive-table basket-flex">
        <div class="basket-thead row justify-content-between  align-items-center mx-0 no-gutters px-md-2 hide-xs" data-wiz-cart-head>
			<div class="product-thumbnail col-md-1"><?php _e('תמונה', wizshop_pages)?></div>
			<aside class="product-info mxw-100 flex-grow-1 col-md-11 col-8 row align-items-center justify-content-between pr-3">
				<div class="product-name pr-3 col-md-3 flex-grow-1 mxw-25"><?php _e('שם המוצר', wizshop_pages)?></div>
				<div class="product-key col-md-1"><?php _e('מק"ט', wizshop_pages)?></div>
				<div class="product-balance col-md-1 {{dispBalance}}"><?php _e('כמות במלאי', wizshop_pages)?></div>
				<div class="product-price col-md-1 {{dispPrice}}"><?php _e('מחיר', wizshop_pages)?></div>
				<div class="product-quant col-md-1 px-md-3"><?php _e('כמות', wizshop_pages)?></div>
				<div class="product-total  col-md-1 {{dispPrice}}"><?php _e('סה"כ', wizshop_pages)?></div>
				<div class="product-remark {{dispRemark}} col-md-2  mxw-25 flex-grow-1"><?php _e('הערה לפריט', wizshop_pages)?></div>
				<div class="product-wishlist col-md-1"></div>
				<div class="product-delete col-md-1"></div>
			</aside>
        </div>
		<div data-wiz-discount-item class="actions row" >
			<div class="col-12 text-left">
				<strong>{{Name}} </strong>
				<span dir="ltr">- {{LineTotal-P}}</span>
			</div>
		</div>
		<div data-wiz-cart-item class="align-items-center justify-content-between mx-0 no-gutters row basket-row py-2 px-md-2">
			<script type="text/html">
				<aside class="product-thumbnail col-md-1 col-3 align-self-start ">
					<a href='<?= esc_url(wizshop_get_products_url())?>{{Link}}' class="item-link">
						<img src="<?php esc_url(wizshop_image_name_link("{{ImageFile}}","wiz_thumb"))?>" alt="{{Name}}">
					</a>
				</aside>
				<aside class="align-items-center col-9 col-md-11 flex-grow-1 justify-content-between mxw-100 pr-3 product-info row">
					<div class="product-name flex-grow-1 mxw-25 mxw-auto-xs col-md-3 col-12 pb-2 pb-md-0" >
						<a href='<?php echo esc_url(wizshop_get_products_url())?>{{Link}}' class="item-link">
							<span>{{Name}}</span>
						</a>
					</div>
					<div class="product-key col-md-1 col-12 pb-2 pb-md-0" >
						<strong>{{Key}}</strong>
					</div>
					<div class="product-balance text-center text-right-xs pb-2 pb-md-0 {{dispBalance}} col-md-1 col-12" >
						<strong class="show-xs"><?php _e('מלאי', wizshop_pages)?></strong>
						<span class="basket-amouth">{{Balance}}</span>
					</div>
					<div class="product-price {{dispPrice}} col-md-1 col-12 pb-2 pb-md-0" > 
						<strong class="show-xs"><?php _e('מחיר', wizshop_pages)?></strong> 
						{{Price-P}}
					</div>
					<div class="product-quantity col-md-1 col-12 px-md-3 row no-gutters pb-2 pb-md-0" >
						<span class="{{dispUnits}} Packs{{dispPacks}} col-md-12 col-3">
							<input type="number" class="mxw-100 py-2" size="2" wiz_QuantId="{{QuantId}}" data-wiz-packs-only="{{OnlyPacks}}" min="0"  value="{{ItemsQuant}}">
							<label class="{{dispPacks}}"><?php _e('יחידות', wizshop_pages)?></label>
						</span>
						<span class="{{dispPacks}} col-md-12 col-4 pr-2 pr-md-0">
							<input type="number" class="mxw-100 mxw-75-xs py-2"  size="2" wiz_PacksId="{{PacksId}}" data-wiz-quant-in-pack="{{QntInPack}}" value="{{PacksNoInCart}}">
							<label><?php _e('אריזות של', wizshop_pages)?> {{QntInPack}}</label>
						</span>
					</div>
					<div class="product-total {{dispPrice}} col-md-1 col-12 pb-2 pb-md-0" >
						<strong class="show-xs"><?php _e('סך הכל', wizshop_pages)?></strong> 
						{{FormatedLineTotal-P}}
					</div>
					<div class="product-remark {{dispRemark}} col-md-2 col-12 pb-2 pb-md-0 mxw-25 mxw-auto-xs flex-grow-1" >
						<input type="text"  maxlength="100" data-wiz-item-remark='{{Key}}' class="w-100 py-2" placeholder="<?php esc_attr_e('הערה', wizshop_pages)?>"  value="{{ItemRemark}}"/>
					</div>
					<div class="product-wishlist col-md-1 col-auto text-left text-right-xs pb-2 pb-md-0" >
					
						<a href="javascript:void(0);" data-wiz-list-action-item='{{Key}}' data-wiz-type='WL' data-wiz-action='1' data-wiz-status="post_cart_id|wishlist|15" class="basket-fav" title="<?php esc_attr_e('רשימת משאלות', wizshop_pages)?>">
							<img src="<?php echo wizshop_img_file_url('heart.svg')?>" class="svg-icon">
							<span class="show-xs link"><?php _e('העברה למועדפים', wizshop_pages)?></span>
						</a>
					</div>
					<div class="product-delete col-md-1 col-auto text-left text-right-xs pb-2 pb-md-0" >
						<a href="javascript:void(0);" data-wiz-remove-from-cart="{{Key}}" data-wiz-status="post_cart_id|delete|15" class="basket-del" title="<?php esc_attr_e('מחיקה', wizshop_pages)?>">
							<img src="<?php echo wizshop_img_file_url('delete.svg')?>" class="svg-icon">
							<span class="show-xs"><?php _e('הסרה', wizshop_pages)?></span>
						</a>
					</div>
				</aside>
			</script>
	  </div>

	</div>
	<div class=" w-100 mb-3 text-center" data-wiz-cart-totals>
		<div data-wiz-status-report data-wizshop data-wiz-scroll-into class="hide{{VSCartStatus}} total-box">
			<span><?php _e('המינימום להזמנה הוא', wizshop_pages)?> {{VSMinCost-P}}.</span>						
		</div>		
	</div>		

    <footer class="container-fluid">
        <div class="row justify-content-between ">
			<div class="float-right" >
				<div data-wiz-details class="b-1 p-2 td-none cart-call">
					<a href="<?php echo wizshop_get_cart_call_url()?>"  wiz_logout><?php _e('אנא צרו איתי קשר בנושא סל הקניות שלי', wizshop_pages)?></a>					
					<a href="javascript:void(0);" data-wiz-post-cart wiz_login data-wiz-status="post_cart_id|send_cart_p|15" class="v_ihide"><?php _e('אנא צרו איתי קשר בנושא סל הקניות שלי', wizshop_pages)?></a>
				</div>
			</div>
			<div class="col-md-5 px-0 float-left">
				<div data-wiz-cart-coupons class="v_ihide row no-gutters mb-4 coupon-box">
					<span class="col-12"><?php _e('ברשותך קוד קופון?', wizshop_pages)?></span>
					<div  class="col-8 pl-2"><input type="text" maxlength="30" class="w-100" data-coupon-code value="{{VSCpUsed_1}}"/>      </div>
					<div class="col-4"><a data-send-coupon href="javascript:void(0);" data-wiz-status="sign-up|status_14|15" class="btn primary w-100"><?php _e('הפעלת קופון', wizshop_pages)?></a></div>
					<div class="coupon-msg coupon_status_{{VSCpUsed_0}} my-2"> 
						<div class="og-status">{{VSCpUsed_5}}</div>
					</div>
				</div>
				<div data-wiz-cart-totals class=" total-box px-3 py-2">
					<div><h5 class="m-0 p-0"><?php _e('סיכום הזמנה', wizshop_pages)?></h5></div>
					<!--מחיר לפני מע"מ : {{PreVat}}-->
					<div class="{{dispPrice}} wiz-TotalCostItems"><strong><?php _e('סיכום ביניים', wizshop_pages)?>: </strong> {{TotalCostItems-P}} <span class="hide{{PreVat}}">(לפני מע"מ)</span></div>
					<div class="hide{{TotalDiscount}} {{dispPrice}} wiz-TotalDiscount"><strong><?php _e('שוברים והנחות', wizshop_pages)?>: </strong> {{TotalDiscount-P}} - </div>
					<div class="py-2 hide{{DeliveryMethod}}0 wiz-DeliveryMethod"><strong><?php _e('משלוח', wizshop_pages)?>: </strong> {{DeliveryMethod}} <span class="{{dispPrice}}">({{DeliveryCost-P}}) </span> </div>
					<div class="{{dispPrice}} wiz-Total"><strong><?php _e('סה"כ לתשלום', wizshop_pages)?>:</strong> {{Total-P}} <span class="hide{{PreVat}}"><?php _e('(לפני מע"מ)', wizshop_pages)?></span></div>
					<div class="py-1 {{dispPrice}} hide{{VSCpAmount}} wiz-VSCpAmount"><strong><?php _e('סכום הקופון', wizshop_pages)?>:</strong> {{VSCpAmount-P}} <span class="hide{{PreVat}}"><?php _e('(לפני מע"מ)', wizshop_pages)?></span> </div>
					<div class="py-1 {{dispPrice}} hide{{VSCpAmount}} wiz-PayAmount"><strong><?php _e('סכום לתשלום באשראי', wizshop_pages)?>: {{PayAmount-P}} <span class="hide{{PreVat}}"><?php _e('(לפני מע"מ)', wizshop_pages)?></span></strong> </div>
				</div>
           
				<?php if(wizshop_is_shipping()): ?>
				<div class="mt-2 shipping-alert">
					<div class="total-box py-2 text-center" wiz_logout><?php _e('בחירת משלוח מתבצעת בשלב הבא', wizshop_pages)?> </div>
					<div class="total-box py-2 text-center" wiz_login><?php _e('שינוי משלוח מתבצע בשלב הבא', wizshop_pages)?> </div>
				</div>			 
				<?php endif; ?>
				<div class="mt-2">
					<div data-wiz-cart-actions class="v_ihide mt-2 text-left">
						<div data-wiz-empty-cart class="dsp-inlineblock btn-empty-cart"><a href="javascript:void(0);" class="btn primary-outline"><?php _e('ריקון סל קניות', wizshop_pages)?></a></div>
						<a href="<?php echo wizshop_get_checkout_final_url()?>" class="btn primary btn-purchase"><?php _e('רכישה', wizshop_pages)?></a>
					</div>
				</div>
			</div>
		</div>
        <div class="clr"></div>
    </footer>
 </div>
 <div class="empty-basket">
	<p class="cart-empty"><?php _e('העגלה שלך ריקה כרגע', wizshop_pages)?>.</p>
	<a class="btn primary-outline" href="<?php echo wizshop_get_shop_url()?>"><?php _e('חזרה לחנות', wizshop_pages)?></a>
</div>

	