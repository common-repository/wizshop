<?php 
if ( ! defined( 'ABSPATH' ) ) { exit; }
$co = wizshop_get_customer_options();
?>
	
<div data-wiz-donations data-wizshop class="donations-description" >
	<h6 data-wiz-title>{{Description}}</h6>
</div>

		
<!-- status -->
<div data-wiz-status-report="donations" data-wizshop class="alert w-100 my-3 p-1 donations-alert" data-wiz-scroll-into>
	<span data-wiz-status-text></span>
	<a href="javascript:void(0);" data-wiz-close-status class="dsp-inlineblock float-left basket-dismiss-btn" >
		<img src="<?php echo wizshop_img_file_url('close.svg')?>" class="svg-icon basket-dismiss-icon">
	</a>
</div>

<div data-wiz-status-report="validation" data-wizshop class="alert w-100 my-3 p-1" data-wiz-scroll-into>
	<span data-wiz-status-text></span>
	<a href="javascript:void(0);" data-wiz-close-status class="dsp-inlineblock float-left basket-dismiss-btn" >
		<img src="<?php echo wizshop_img_file_url('close.svg')?>" class="svg-icon basket-dismiss-icon">
	</a>
</div>
	

<div data-wiz-donations data-wizshop data-wiz-error-class="v_field_err" id="donation-fields">
	<div class="my-3 bb">
		<h5 class="my-0"><?php _e('פרטי התרומה', wizshop_pages)?></h5>
	</div>
	<div class="col-12 col-md-7 row px-0 pt-4 donation-fields" data-wiz-don-details>
		<div class="col-12 col-md-6 pb-3 donfield-sum">
			<label class="dsp-block" for="DonationSum"><?php _e('תרומה חד פעמית בסכום', wizshop_pages)?> </label>
			<input type="number" data-wiz-sum value="" maxlength="25" id="DonationSum" class="dsp-block w-100 ifdisabled" name="<?php esc_attr_e('סכום התרומה', wizshop_pages)?>">
		</div> 
		<div class="col-12 col-md-3 pb-3 donfield-currency">
			<label for="curr_m"><?php _e('מטבע', wizshop_pages)?></label>
			<select id="curr_m" class="ifdisabled" data-wiz-currency-type>
			   <option  class="v_iselect" data-wiz-item="NIS"  value="NIS">&#8362;</option>
			   <option  data-wiz-item="$" value="$">&#36;</option>
			</select>
		</div>
		<div class="col-12 col-md-3 pb-3 donfield-payments">
			<label class="dsp-block" for="DonationPay"><?php _e('תשלומים', wizshop_pages)?></label>
			<select id="DonationPay" data-wiz-payment-container class=" mnw-100 p-2 dsp-block ifdisabled">
				<option data-wiz-payment  wiz_selection>{{Name}}</option>
			</select>
		</div>
		<div class="col-12 col-md-12 donfield-remark">
			<span class="dsp-block" for="DonationRemark"><?php _e('הערה', wizshop_pages)?></span>	
			<textarea maxlength="250" data-wiz-remark id="DonationRemark" class="ifdisabled  mb-5 w-100 "></textarea>
		</div>
	</div>
	
	<div class="xrow" >
		
		<div data-wiz-sign-in data-wizshop class="cust-type-new link pr-2 w-100 b2c-button mb-3">
			<a data-cust-type="2"  wiz_logout>
				<h5 class="bb m-0 pb-2"> <?php echo $co["b2c_donor_text"]; ?> <u> <?php _e('אנא התחברו', wizshop_pages)?> </u></h5>
			</a>
		</div>
		
		<div data-cust-form="2">
			<div data-wiz-status-report="sign-in" data-wizshop data-wiz-scroll-into  class="alert w-100 my-3 p-1">
				<span data-wiz-status-text></span>
				<a href="javascript:void(0);" data-wiz-close-status class="dsp-inlineblock float-left basket-dismiss-btn">
					<img src="<?php echo wizshop_img_file_url('close.svg')?>" class="svg-icon basket-dismiss-icon">
				</a>
			</div>
			<div  data-wiz-sign-in data-wizshop class="mt-3 px-4 py-3 login-box v_user_log" data-wiz-error-class="v_field_err">
				<div class="row" wiz_logout>
					<div class="col-12 col-md-5">
						<span ><?php _e('דואר אלקטרוני', wizshop_pages)?></span>
						<input type="text"  size="25" name="<?php esc_attr_e('דואר אלקטרוני', wizshop_pages)?>" data-wiz-user-mail class="dsp-block w-100" />
					</div>
					<div class="col-12 col-md-5">
						<span ><?php _e('סיסמא', wizshop_pages)?></span>
						<input type="password"  size="25" name="<?php esc_attr_e('סיסמא', wizshop_pages)?>" data-wiz-user-pass class="dsp-block w-100" />
					</div>
					<div class="col-12 col-md-2 mt-2  pr-1 dsp-flex">
						<a href="javascript:void(0);"  data-wiz-status="sign-in|status_14|14" data-wiz-login data-wiz-b2b data-wiz-address="<?= esc_url(wizshop_get_reference_url())?>" class="btn primary mnw-100 mt-auto" ><?php _e('כניסה', wizshop_pages)?></a>
					</div>
					<div class="col-12 mt-4 ">
						<!-- Password reset -->
						<a href="javascript:void(0);"  data-wiz-status="sign-in|pass_3|15" data-wiz-send-pass data-wiz-b2b class="mt-1 link"><?php _e('שכחתי סיסמא, אנא שלחו לי מייל שיחזור סיסמא', wizshop_pages)?></a>
					</div>
				</div>
			</div>
		</div>
		
		<div data-wiz-sign-in data-wizshop  class="cust-type-new link pr-2 w-100 b2b-button mb-3">
			<a data-cust-type="1" wiz_logout>
				<h5 class="bb m-0 pb-2"> <?php echo $co["b2b_donor_text"]; ?><u> <?php _e('אנא התחברו', wizshop_pages)?>  </u></h5>
			</a>
		</div>
		
		<div data-cust-form="1">
			<div data-wiz-status-report="sign-in-b2b" data-wizshop data-wiz-scroll-into  class="alert w-100 my-3 p-1">
			<span data-wiz-status-text></span>
			<a href="javascript:void(0);" data-wiz-close-status class="dsp-inlineblock float-left basket-dismiss-btn">
				<img src="<?php echo wizshop_img_file_url('close.svg')?>" class="svg-icon basket-dismiss-icon">
			</a>
			</div>
			<div data-wiz-sign-in data-wizshop class="mt-3 px-4 py-3 login-box v_user_log" data-wiz-error-class="v_field_err">
				<div wiz_logout class="row">
					 <div class="col-12  col-md-5">
						<span wiz_logout><?php _e('קוד משתמש', wizshop_pages)?></span>
						<input type="text" size="25" name="<?php esc_attr_e('קוד משתמש', wizshop_pages)?>" data-wiz-user-key class="dsp-block w-100">
					</div>
					<div class="col-12  col-md-5">
						<span wiz_logout><?php _e('סיסמא', wizshop_pages)?></span>
						<input type="password" size="25" name="<?php esc_attr_e('סיסמא', wizshop_pages)?>" data-wiz-user-pass class="dsp-block w-100">
					</div>
					<div class="col-12 col-md-2 mt-2 pr-1 dsp-flex">
						<a href="javascript:void(0);" data-wiz-status="sign-in-b2b|status_14|14" data-wiz-login data-wiz-b2b="1" data-wiz-address="<?php echo esc_url(wizshop_get_reference_url())?>"  class="btn primary mnw-100 mt-auto" ><?php _e('כניסה', wizshop_pages)?></a>
					</div>
					<div class="col-12 mt-3 ">
						<span><?php _e('שכחתי סיסמא / אני רוכש בפעם הראשונה', wizshop_pages)?>  </span>
						
					</div>
					<div class="col-12  col-md-5" wiz_logout>
						<span><?php _e('דואר אלקטרוני', wizshop_pages)?></span>
						<input type="text" size="25" name="<?php esc_attr_e('דואר אלקטרוני', wizshop_pages)?>" data-wiz-user-mail class="dsp-block w-100" />
					</div>
					<div class="col-12 col-md-4 mt-2 dsp-flex">
						<!-- Password reset -->
						<a href="javascript:void(0);" data-wiz-status="sign-in-b2b|pass_3|15" data-wiz-send-pass data-wiz-b2b="1" class="btn primary  mt-auto"><?php _e('שחזור סיסמא', wizshop_pages)?></a>
					</div>
				</div>
			</div>
		</div>
	</div>

	
	<div class="my-3 bb">
			<h5 class="my-0"><?php _e('פרטים אישיים', wizshop_pages)?></h5>
	</div>
	<div data-wiz-details data-wiz-error-class="v_field_err" class="donation-user-fields px-0 row">
		<div class="col-12 donfield-email">
			<label class="dsp-block"><?php _e('מייל', wizshop_pages)?></label>
			<input type="text" data-req data-billing  name="<?php esc_attr_e('מייל', wizshop_pages)?>" id="don_EMail" value="" maxlength="50" class="dsp-block w-100">
		</div>
		<div class="col-12 col-md-6 donfield-name">
			<label class="dsp-block"><?php _e('שם מלא', wizshop_pages)?></label>
			<input type="text" data-req  data-billing name="<?php esc_attr_e('שם מלא', wizshop_pages)?>" id="don_BName" value="" maxlength="50" class="dsp-block w-100">
		</div>
		
		<div class="col-12 col-md-6 donfield-phone">
			<label class="dsp-block"><?php _e('טלפון / נייד', wizshop_pages)?></label>
			<input type="text" data-req  data-billing name="<?php esc_attr_e('טלפון / נייד', wizshop_pages)?>" id="don_BPhone" value="" maxlength="50" class="dsp-block w-100">
		</div>
		<div class="col-12 col-md-8 donfield-address">
			<label class="dsp-block"><?php _e('כתובת', wizshop_pages)?></label>
			<input type="text" data-req  data-billing name="<?php esc_attr_e('כתובת', wizshop_pages)?>" id="don_BAddress" value="" maxlength="50" class="dsp-block w-100">
		</div>
		<div class="col-12 col-md-4 donfield-zip">
			<label class="dsp-block"><?php _e('מיקוד', wizshop_pages)?></label>
			<input type="text"  name="<?php esc_attr_e('מיקוד', wizshop_pages)?>" data-billing id="don_BZip" value="" maxlength="50" class="dsp-block w-100">
		</div>
		<div class="col-12 col-md-auto flex-grow-1 flex-basis-4 donfield-city">
			<label class="dsp-block"><?php _e('עיר', wizshop_pages)?></label>
			<input type="text" data-req  data-billing name="<?php esc_attr_e('עיר', wizshop_pages)?>" id="don_BCity" value="" maxlength="50" class="dsp-block w-100">
		</div>
		<div class="col-12 col-md-auto flex-grow-1 flex-basis-4 donfield-area">
			<label class="dsp-block"><?php _e('איזור', wizshop_pages)?> </label>
			<input type="text"  name="<?php esc_attr_e('איזור', wizshop_pages)?>" data-billing id="don_BRegion" value="" maxlength="50" class="dsp-block w-100">
		</div>
		
		<div class="col-12 col-md-auto flex-grow-1 flex-basis-4 donfield-country">
			<label class="dsp-block"><?php _e('מדינה', wizshop_pages)?></label>
			<a data-win="#don_BCountry" class="click-me ml-3 extra-label link"><?php _e('הקלדת מדינה', wizshop_pages)?> </a>
			
			<select data-wiz-bcountry-container class=" mnw-100 p-2 dsp-block">
				<option data-wiz-no-item ><?php _e('בחירה מרשימה', wizshop_pages)?></option>
				<option data-wiz-country = "">{{Name}}</option>
			</select>
			<input data-billing data-req data-wiz-country_input id="don_BCountry" type="text" maxlength="50" value="" name="<?php esc_attr_e('מדינה', wizshop_pages)?>" class="dsp-block w-100 mt-2 click-me-target" style="display:none" />
		</div>
	</div>	
	<div class="my-3">
		<a href="javascript:void(0);" class="btn primary ifdisabled" data-wiz-checkout data-wiz-status="donations|donations-msg|0@@validation|donations-msg|4" ><?php _e('מעבר לתרומה', wizshop_pages)?> </a>
	</div>
	<iframe id="VSCreditIframe" width="100%" height="600px"></iframe>

</div>
<div class="clr"></div>
<div id="checkout_report" data-wiz-purchase-report data-wizshop>
	<div data-wiz-fields>
		<h5 class="mb-2 mt-2" ><?php _e('תודה על תרומתך!', wizshop_pages)?></h5>
		<p class="mb-3 {{dispPrice}}"><?php _e('סכום התרומה', wizshop_pages)?>: {{Total-P}} </p>
		<p class="mb-0 hiderev{{cr_method}} {{dispPrice}}"><?php _e('מספר תשלומים', wizshop_pages)?>: {{PaymentsNo}}</p>
	</div>
</div>	
	
<script>
(function(){        
	var __login = null;
	jQuery(window).on("message", function(e) {
		var data = null;
		try{
			data = JSON.parse(e.originalEvent.data);
		}catch (e){
			return;
		}
		if (data  && data.wizshop){
			if(data.cpPainted && data.id){
				 if('checkout_report' == data.id){
					document.getElementById("donation-fields").style.display = 'none';
				 }else if('donation-fields' == data.id){
					if(0 == jQuery('[data-wiz-bcountry-container]').prop('selectedIndex')&&	"" != jQuery("#don_BCountry").val()){
						jQuery("[data-win='#don_BCountry']").click();		
					}
				 }
			}else if(data.userLogin){
				__login = data.login;
				jQuery('[data-cust-type]').each(function( index, el ){
					if(!jQuery(el).hasClass('v_iselect')){
						var type = jQuery(el).attr('data-cust-type');
						jQuery('[data-cust-form="'+type+'"]').addClass('v_ihide');
					}
				});
			}
		}           
	});
	
	jQuery('[data-cust-type]').click(function(e){
		var type = jQuery(this).attr('data-cust-type');
		var has_select = jQuery(this).hasClass('v_iselect');
		if(has_select){
			jQuery('[data-cust-type]').removeClass("v_iselect");
			jQuery('[data-cust-form="'+type+'"]').addClass("v_ihide");
		}else{
			jQuery('[data-cust-type]').removeClass("v_iselect");
			jQuery(this).addClass('v_iselect');

			jQuery('[data-cust-form]').addClass("v_ihide");
			jQuery('[data-cust-form="'+type+'"]').removeClass('v_ihide');
		}
		clear_status();
	});
	
	jQuery('[data-wiz-checkout]').click(function(e){
		clear_status();
	});
	
	function clear_status(){
		postMessage(JSON.stringify({ status_report_off: true, wizshop: true, 
			object_id: ["sign-in", "sign-in-b2b", "donations", "validation"]}),"*");
	}
})();

</script>
