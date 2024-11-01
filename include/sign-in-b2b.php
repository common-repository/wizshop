<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$co = wizshop_get_customer_options();  

?>


<!-- status -->
<div data-wiz-status-report="signin-b2b" data-wizshop data-wiz-scroll-into class="alert w-100 mt-2 p-1">
	<span data-wiz-status-text></span>
		<a href="javascript:void(0);" data-wiz-close-status class="dsp-inlineblock float-left basket-dismiss-btn">
			<img src="<?php echo wizshop_img_file_url('close.svg')?>" class="svg-icon basket-dismiss-icon">
		</a>
	</span>
</div>

<!-- login Box -->
<div data-wiz-sign-in data-wizshop data-cust-form="1" class="mt-3 v_user_log " data-wiz-error-class="v_field_err">
	<div wiz_logout>
		<?php wizshop_get_template_part('customers-header', '', array('wiz_user_page' => 'sign-in-b2b'));?>
		<div wiz_logout class="row">
		 <div class="col-12  col-md-5">
			<span class="dsp-block" wiz_logout><?php _e('קוד משתמש', wizshop_pages)?></span>
			<input type="text" size="25" name="<?php _e('קוד משתמש', wizshop_pages)?>" data-wiz-user-key class="dsp-block w-100">
		</div>
		<div class="col-12  col-md-5">
			<span class="dsp-block" wiz_logout><?php _e('סיסמא', wizshop_pages)?></span>
			<input type="password" size="25" name="<?php _e('סיסמא', wizshop_pages)?>" data-wiz-user-pass class="dsp-block w-100">
		</div>
		<div class="col-12 col-md-2 mt-2 dsp-flex">
			<a href="javascript:void(0);" data-wiz-status="signin-b2b|status_14|14" data-wiz-login data-wiz-b2b="1" data-wiz-address="<?php echo esc_url(wizshop_get_reference_url())?>"  class="btn primary mnw-100 mt-auto" ><?php _e('כניסה', wizshop_pages)?></a>
		</div>
		<div class="col-12 mt-3 ">
			<span><?php _e('שכחתי סיסמא / אני רוכש בפעם הראשונה', wizshop_pages)?>  </span>
			
		</div>
		<div class="col-12  col-md-5" wiz_logout>
			<span class="dsp-block"><?php _e('דואר אלקטרוני', wizshop_pages)?></span>
			<input type="text" size="25" name="דואר אלקטרוני" data-wiz-user-mail class="dsp-block w-100" />
		</div>
		<div class="col-12 col-md-3 mt-2 dsp-flex">
			<!-- Password reset -->
			<a href="javascript:void(0);" data-wiz-status="signin-b2b|pass_3|15" data-wiz-send-pass data-wiz-b2b="1" class="btn primary  mnw-100 mt-auto"><?php _e('שחזור סיסמא', wizshop_pages)?></a>
		</div>
		</div>
	</div>
</div>

<!-- user -->
<div data-wiz-customer data-wizshop>
    <h4  data-wiz-text wiz_login class="v_sigin_log"><?php _e('שלום', wizshop_pages)?> {{Name}}</h4>
	<p>
		<a href="<?php echo esc_url(wizshop_get_user_details_url())?>" class="v_sigin_log" wiz_login><?php _e('איזור אישי', wizshop_pages)?></a>
		<a href="javascript:void(0);" data-wiz-logout class="v_sigin_log" wiz_login><?php _e('התנתקות', wizshop_pages)?></a>
	</p>
</div>