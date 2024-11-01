<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<div class="cart-widget" >
	<div class="shopping-cart-inner" data-wiz-shopping-cart data-wizshop>
		<table data-wiz-cart-container class="v_cart table-nodorder table-bb layout-auto">
			<tbody>
				<tr data-wiz-discount-item >
					<td colspan="2">{{Name}}</td>
					<td colspan="4" dir="ltr">{{LineTotal}} </td>
				</tr>
				<tr data-wiz-cart-item>
					<script type="text/html">
					<td class="px-1">
						<a href="<?php echo esc_url(wizshop_get_products_url())?>{{Link}}" class="item-link" >
							<img src="<?php wizshop_image_name_link("{{ImageFile}}","wiz_thumb")?>" width="60" height="60" alt="{{Name}}">
						</a>
					</td>
					<td class="px-1">
						<a href="<?= esc_url(wizshop_get_products_url())?>{{Link}}" class="item-link">{{Name}}</a>
					</td>
					<td class="px-1">{{Quantity}}</td>
					<td class="px-1 {{dispPrice}}"> x </td> 
					<td class="price px-1 {{dispPrice}}">{{Price-P}}</td>
					<td class="px-1">
						<a href="javascript:void(0);" data-wiz-remove-from-cart='{{ID}}' data-wiz-status=""  title="הסר פריט זה">
						<img src="<?php echo wizshop_img_file_url('delete.svg')?>" class="svg-icon">
						</a> 
					</td>
					</script>
				</tr>
			</tbody>
		</table>
		<div class="empty-basket"><?php _e('הסל ריק', wizshop_pages)?></div>
		<div data-wiz-cart-totals>
			<p class="total text-center {{dispPrice}}"><?php _e('סך הכל', wizshop_pages)?> <strong>{{Total-P}}</strong></p>
		</div>
		<div data-wiz-cart-actions class="buttons v_ihide row">
			<div class="col-sm-6">
				<a href="<?php echo esc_url(wizshop_get_cart_url())?>" class="btn primary-outline w-100"><?php _e('סל קניות', wizshop_pages)?></a>
			</div>
			<div class="col-sm-6">
				<a href="<?php echo wizshop_get_checkout_final_url()?>" class="btn primary w-100"><?php _e('רכישה', wizshop_pages)?></a>
			</div>
		</div>
	</div>
</div>
	