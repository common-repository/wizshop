<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$co = wizshop_get_customer_options();  
?>
<header class="mb-2 customers-header" wiz_logout >
	<div class="col text-right px-0">
		<a href="<?=esc_url(wizshop_get_signin_url())?>" class="btn primary b2c-button <?php echo (('sign-in' == $wiz_user_page) ? 'primary-outline' : '');?>"><?php echo $co["b2c_link_text"]; ?></a>
		<a href="<?=esc_url(wizshop_get_signin_b2b_url())?>" class="btn primary  b2b-button <?php echo (('sign-in-b2b' == $wiz_user_page) ? 'primary-outline' : '');?>"><?php echo $co["b2b_link_text"]; ?></a>
		<a href="<?=esc_url(wizshop_get_user_details_url())?>" class="btn primary signup-button <?php echo (('user-details' == $wiz_user_page) ? 'primary-outline' : '');?>"><?php _e('הרשמה', wizshop_pages)?></a>
	</div>
</header>

