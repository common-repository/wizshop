<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>

<!-- user -->
<div data-wiz-customer data-wizshop>
    <div  data-wiz-text wiz_login>
		<h4><?php _e('שלום', wizshop_pages)?> {{Name}} </h4>
		<p> {{DiscountMsg}}  </p>
	</div>
	<p>
		<a href="javascript:void(0);" data-wiz-logout wiz_login><?php _e('התנתקות', wizshop_pages)?></a>
	</p>
</div>

<div class="tabs">
	<!--?php if(!wp_is_mobile()): ?--> 
		<ul class="tab-links dsp-inlineblock bb w-100 hide-xs">
			<li class="tab-item mr-2 float-right tab-userdetails"><a href="#userdetails" class="tab-link p-3">
				<?php if(wizshop_is_reg_customer()): ?>  <?php _e('עדכון פרופיל', wizshop_pages)?>
				<?php else: ?> <?php _e('הרשמה', wizshop_pages)?> <?php endif; ?>
			</a></li>
			<li class="tab-item mr-2 float-right tab-wishlist"><a href="#wishlist" class="tab-link p-3"><?php _e('רשימת משאלות', wizshop_pages)?></a></li>
		<?php if(wizshop_is_reg_customer()): ?> 
			<li class="tab-item mr-2 float-right tab-prevcart"><a href="#prevcart" class="tab-link p-3"><?php _e('קניות קודמות', wizshop_pages)?></a></li> 
			<li class="tab-item mr-2 float-right tab-permcart"><a href="#permcart" class="tab-link p-3"><?php _e('סל קבוע', wizshop_pages)?></a></li> 
		<?php endif; if(wizshop_is_b2b_customer()): ?> 
			<li class="tab-item mr-2 float-right tab-reportsacc"><a href="#reportsacc" class="tab-link p-3"><?php _e('כרטסת הנהלת חשבונות', wizshop_pages)?></a></li>
			<li class="tab-item mr-2 float-right tab-reportsitem"><a href="#reportsitem" class="tab-link p-3"><?php _e('דו"ח פריטים', wizshop_pages)?></a></li>
		<?php endif; ?>	  
		</ul>
	<!--?php else: ?-->	  
		<select class="tabs-m-links show-xs w-100 mb-3 p-2 ">
			<option class="tab-userdetails" value="#userdetails"><?php _e('עדכון פרופיל', wizshop_pages)?></option>
			<option class="tab-wishlist" value="#wishlist"><?php _e('רשימת משאלות', wizshop_pages)?></option>
		<?php if(wizshop_is_reg_customer()): ?> 
			<option class="tab-prevcart" value="#prevcart"><?php _e('קניות קודמות', wizshop_pages)?></option>
			<option class="tab-permcart" value="#permcart"><?php _e('סל קבוע', wizshop_pages)?></option>
		<?php endif; if(wizshop_is_b2b_customer()): ?> 
			<option class="tab-reportsacc" value="#reportsacc"><?php _e('כרטסת הנהלת חשבונות', wizshop_pages)?></option>
			<option class="tab-reportsitem" value="#reportsitem"><?php _e('דו"ח פריטים', wizshop_pages)?></option>
		<?php endif; ?>	  
		</select>
	<!--?php endif; ?-->	  

	<div  class="tab-content">
		<div id="userdetails" class="tab active">
			<?php wizshop_get_template_part('user-details');?>
		</div>
		<div id="wishlist" class="tab">
			<?php wizshop_get_template_part('wish-list');?>
		</div>
	<?php if(wizshop_is_reg_customer()): ?> 
		<div id="prevcart" class="tab">
			<?php wizshop_get_template_part('past-purchases');?>
		</div>
		<div id="permcart" class="tab">
			<?php wizshop_get_template_part('permanent-cart');?>
		</div>
	<?php endif; if(wizshop_is_b2b_customer()): ?>
		<div id="reportsacc" class="tab">
			<?php wizshop_get_template_part('reports-acc');?>
		</div>
		<div  id="reportsitem" class="tab">
			<?php wizshop_get_template_part('reports-item');?>
		</div>
	<?php endif; ?>
	</div>
</div>

<script>
jQuery(document).ready(function($) {  
	$( window ).on( 'hashchange', function( e ) {
		set_tab(location.hash);}
	);	
	$('.tabs .tab-links a').on('click', function(e)  {
        var tab = $(this).attr('href');
		if(tab == location.hash){
			e.preventDefault();
		}else{
			location.hash = tab;
		}
	});
	$('.tabs .tabs-m-links').on('change', function(e)  {
		location.hash = $(this).find('option:selected').val();
	});
	function set_tab(tab){
		$('.tabs ' + tab).show().siblings().hide();
		$('.tabs .tab-links a[href="'+tab+'"]').parent('li').addClass('active').siblings().removeClass('active');
		$('.tabs-m-links').val(tab);
	}
	if(!location.hash){
		location.hash = "#userdetails";
	}else{
		set_tab(location.hash);
	}
});
</script>