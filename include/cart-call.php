<?php 
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<!-- status -->
<div data-wiz-status-report="post_cart_id" data-wizshop  data-wiz-scroll-into  class="alert w-100 mb-3 p-1">
	<span data-wiz-status-text></span>
	<a href="javascript:void(0);" data-wiz-close-status class="dsp-inlineblock float-left basket-dismiss-btn">
		<img src="<?php echo wizshop_img_file_url('close.svg')?>" class="svg-icon basket-dismiss-icon">
	</a>
</div>	
 <div  data-wiz-shopping-cart data-wizshop>
 <h4><?php _e('אנא מלא/י את פרטי ההתקשרות שלך ונחזור אליך בהקדם', wizshop_pages)?></h4>
	<div data-wiz-details data-wiz-error-class="v_field_err" class="row">
	
	<div class="col-12 col-md-6">
		<span class="dsp-block"><?php _e('שם ומשפחה', wizshop_pages)?></span>
		<input type="text"  class="dsp-block w-100" data-req  name="<?php esc_attr_e('שם ומשפחה', wizshop_pages)?>" id="cart_Name" value="" maxlength="50">
	</div>
	<div class="col-12 col-md-6">
		<span class="dsp-block"><?php _e('טלפון / נייד', wizshop_pages)?></span>
		<input type="text"  class="dsp-block w-100"data-req  name="<?php esc_attr_e('טלפון / נייד', wizshop_pages)?>" id="cart_Phone" value="" maxlength="50">
	</div>
	<div class="col-12 col-md-6">
		<span class="dsp-block"><?php _e('דואר אלקטרוני', wizshop_pages)?> </span>
		<input type="text"  class="dsp-block w-100"data-req  name="<?php esc_attr_e('דואר אלקטרוני', wizshop_pages)?>" id="cart_EMail" value="" maxlength="50">
	</div>
	<div class="col-12 col-md-6">
		<span class="dsp-block"><?php _e('כתובת', wizshop_pages)?> </span>
		<input type="text"  class="dsp-block w-100" name="<?php esc_attr_e('כתובת', wizshop_pages)?>" id="cart_Address" value="" maxlength="50">
	</div>
	<div class="col-12 col-md-12">
		<span class="dsp-block"><?php _e('הערה', wizshop_pages)?></span>
		<textarea  name="<?php esc_attr_e('הערה', wizshop_pages)?>" class="dsp-block w-100" id="cart_Remark" value="" maxlength="100"></textarea>
	</div>
	</div>
	<a data-wiz-post-cart data-wiz-status="post_cart_id|send_cart_p|15" href="javascript:void(0);" class="btn primary mt-3"><?php _e('שליחה', wizshop_pages)?></a>
</div>