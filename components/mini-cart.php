<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<li  data-wiz-shopping-cart data-wizshop class="menu-item menu-item-has-children">
	<a class="elementor-item has-submenu"> <?php _e('סל קניות', wizshop_pages)?> <span data-wiz-cart-totals  dir="ltr" ><span>({{Items}})</span></span></a>
	<ul class="sub-menu elementor-nav-menu--dropdown mini-cart-container">
		<table data-wiz-cart-container class="v_cart table-nodorder  layout-auto">

			<tr data-wiz-discount-item >
				<td colspan="2" ><a>{{Name}}</a></td>
				<td colspan="4" dir="ltr" ><a>{{LineTotal}} </a></td>
			</tr>
			<tr data-wiz-cart-item>
				<script type="text/html">
				<td class="thumb px-1">
					<a href="<?php echo esc_url(wizshop_get_products_url())?>{{Link}}" class="px-0 item-link" >
						<img src="<?php wizshop_image_name_link("{{ImageFile}}","wiz_thumb")?>" width="60" height="60" alt="{{Name}}">
					</a>
				</td>
				<td class="px-1">
					<a href="<?= esc_url(wizshop_get_products_url())?>{{Link}}" class="item-link" >{{Name}}</a>
				</td>
				<td class="px-1">{{Quantity}}</td>
				<td class="px-1 {{dispPrice}}"> x </td> 
				<td class="price px-1 {{dispPrice}}">{{Price-P}}</td>
				<td class="px-1">
					<a href="javascript:void(0);" data-wiz-remove-from-cart='{{ID}}' data-wiz-status=""  title="<?php esc_attr_e('הסר פריט זה', wizshop_pages)?>">
						<img src="<?php echo wizshop_img_file_url('delete.svg')?>" class="svg-icon">
					</a> 
				</td>
				</script>
			</tr>
		
		</table>	
		<li class="menu-item empty-basket"><a class="elementor-sub-item"><?php _e('הסל ריק', wizshop_pages)?></a></li>	
		<li data-wiz-cart-totals>
			<a class="total text-center elementor-sub-item {{dispPrice}}"><?php _e('סך הכל', wizshop_pages)?> <strong>{{Total-P}}</strong></a>
		</li>
		
		<li data-wiz-cart-actions class="menu-item buttons v_ihide row">
			<div class="col-6 float-right mb-2">
				<a href="<?php echo esc_url(wizshop_get_cart_url())?>" class="btn primary-outline w-100 dsp-block"><?php _e('סל קניות', wizshop_pages)?></a>
			</div>
			<div class="col-6 float-left mb-2">
				<a href="<?php echo wizshop_get_checkout_final_url()?>" class="btn primary w-100 dsp-block"><?php _e('רכישה', wizshop_pages)?></a>
			</div>
		</li>
	</ul>
	
</li>


