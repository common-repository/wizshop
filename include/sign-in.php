<?php
if ( ! defined( 'ABSPATH' ) ) { exit; } 
?>
<!-- status -->
<div data-wiz-status-report="signin" data-wizshop data-wiz-scroll-into class="alert w-100 mb-3 p-1">
	<span data-wiz-status-text></span>
		<a href="javascript:void(0);" data-wiz-close-status class="dsp-inlineblock float-left basket-dismiss-btn">
			<img src="<?php echo wizshop_img_file_url('close.svg')?>" class="svg-icon basket-dismiss-icon">
		</a>
	</span>
</div>

<!-- login Box -->
<div data-wiz-sign-in data-wizshop data-cust-form="2" class="" data-wiz-error-class="v_field_err">
	<div wiz_logout>
		<?php wizshop_get_template_part('customers-header', '', array('wiz_user_page' => 'sign-in'));?>
		<div class="row">
			<div class="col-12 col-md-5">
				<span class="dsp-block" ><?php _e('דואר אלקטרוני', wizshop_pages)?></span>
				<input type="text"  size="25" name="<?php _e('דואר אלקטרוני', wizshop_pages)?>" data-wiz-user-mail class="dsp-block w-100" />
			</div>
			<div class="col-12 col-md-5">
				<span class="dsp-block" ><?php _e('סיסמא', wizshop_pages)?></span>
				<input type="password"  size="25" name="<?php _e('סיסמא', wizshop_pages)?>" data-wiz-user-pass class="dsp-block w-100" />
			</div>
			<div class="col-12 col-md-2 mt-2 dsp-flex">
				<a href="javascript:void(0);"  data-wiz-status="signin|status_14|14" data-wiz-login data-wiz-b2b data-wiz-address="<?= esc_url(wizshop_get_reference_url())?>" class="btn primary mnw-100 mt-auto" ><?php _e('כניסה', wizshop_pages)?></a>
			</div>
			<div class="col-12 mt-4 ">
				<!-- Password reset -->
				<a href="javascript:void(0);"  data-wiz-status="signin|pass_3|15" data-wiz-send-pass data-wiz-b2b class="mt-1"><?php _e('שכחתי סיסמא, אנא שלחו לי מייל שיחזור סיסמא', wizshop_pages)?></a>
			</div>
		</div>
	</div>
</div>

<!-- user -->
<div data-wiz-customer data-wizshop>
    <h4  data-wiz-text wiz_login>שלום {{Name}}</h4>
	<p>
		<a href="<?php echo esc_url(wizshop_get_user_details_url())?>" class="v_sigin_log" wiz_login>איזור אישי</a>
		<a href="javascript:void(0);" data-wiz-logout wiz_login>התנתקות</a>
	</p>
</div>