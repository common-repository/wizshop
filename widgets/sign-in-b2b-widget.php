<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<!-- status -->
<div data-wiz-status-report="sign-in-b2b-widget" data-wizshop  class="alert mini-alert w-100 mb-3 p-1">
	<span data-wiz-status-text></span>
		<a href="javascript:void(0);" data-wiz-close-status class="dsp-inlineblock float-left basket-dismiss-btn">
			<img src="<?php echo wizshop_img_file_url('close.svg')?>" class="svg-icon basket-dismiss-icon">
		</a>
	</span>
</div>
<!-- login Box -->
<div data-wiz-sign-in data-wizshop data-wiz-error-class="v_field_err">
	<div wiz_logout>
		
		<div class="col-12 mb-2">
			<input type="text" size="25" name="<?php esc_attr_e('קוד משתמש', wizshop_pages)?>" data-wiz-user-key placeholder="<?php esc_attr_e('קוד משתמש', wizshop_pages)?>"  class="dsp-block w-100" />
		</div>
		<div class="col-12 mb-2">
			<input type="password" size="25" name="<?php esc_attr_e('סיסמא', wizshop_pages)?>" data-wiz-user-pass placeholder="<?php esc_attr_e('סיסמא', wizshop_pages)?>"  class="dsp-block w-100" />
		</div>
		<div class="col-12 text-left">
			<a href="javascript:void(0);" data-wiz-status="sign-in-b2b-widget|status_14|14" data-wiz-login data-wiz-b2b="1" data-wiz-address="<?php echo esc_url(wizshop_current_page_url())?>" class="btn primary"><?php _e('כניסה', wizshop_pages)?></a>
		</div>
		<div class="col-12 mb-2">
			<a data-win="#send-password" class="click-me link"><?php _e('שכחתי סיסמא/כניסה ראשונה', wizshop_pages)?></a>
		</div>
		<div class="col-12 mb-2 click-me-target"  id="send-password">
			<div class=" mb-2">
				<input type="text" size="25" name="<?php esc_attr_e('דואר אלקטרוני', wizshop_pages)?>" data-wiz-user-mail placeholder="<?php esc_attr_e('מייל', wizshop_pages)?>"  class="dsp-block w-100"/>
			</div>
			<div class=" mb-2">
				<a href="javascript:void(0);"  data-wiz-status="sign-in-b2b-widget|status_14|15" data-wiz-send-pass data-wiz-b2b="1" class="btn primary  mnw-100 mt-auto"><?php _e('שחזור סיסמא', wizshop_pages)?></a>
			</div>
		</div>
		
	</div>
</div>

<div data-wiz-customer data-wizshop >
	<div wiz_login data-wiz-text>
		<h6	class="hello-client mb-2 "><?php _e('שלום', wizshop_pages)?>   {{Name}} </h6>
		<h6 class="hide{{AgentName}}0">	(סוכן: {{AgentName}}) </h6>		
	</div>
	<div  wiz_login class="row" >
		<div class="col-6 ">
			<a href="<?php echo esc_url(wizshop_get_personal_area_url())?>" class="btn primary w-100" > <?php _e('איזור האישי', wizshop_pages)?></a>
		</div>
		<div class="col-6 ">
			<a  href="javascript:void(0);" data-wiz-logout class="btn primary-outline w-100"><?php _e('התנתקות', wizshop_pages)?></a>
		</div>
	</div>
</div>