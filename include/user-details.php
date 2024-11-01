<?php 
if ( ! defined( 'ABSPATH' ) ) { exit; }

?>

<!-- status -->
<div data-wiz-status-report="user-details" data-wizshop data-wiz-scroll-into class="alert w-100 my-3 p-1">
	<span data-wiz-status-text></span>
	<a href="javascript:void(0);" data-wiz-close-status class="dsp-inlineblock float-left basket-dismiss-btn">
		<img src="<?php echo wizshop_img_file_url('close.svg')?>" class="svg-icon basket-dismiss-icon">
	</a>
</div>
<!-- user details -->

<div class="row mx-0 px-2">
	<div  data-wiz-customer data-wizshop data-cust-form="0"  >
			
			<div data-wiz-details data-wiz-error-class="v_field_err" >
				<?php wizshop_get_template_part('customers-header', '', array('wiz_user_page' => 'user-details'));?>				
				<div class="row">
					<div class="col-12 col-md-4">
						<span class="dsp-block"><?php _e('שם ומשפחה', wizshop_pages)?></span>
						<input type="text" data-delivery data-req  name="<?php esc_attr_e('שם ומשפחה', wizshop_pages)?>" id="vs_Name" value="" maxlength="50" class="dsp-block w-100" >
					</div>
					<div class="col-12 col-md-4">
						<span class="dsp-block"><?php _e('דואר אלקטרוני', wizshop_pages)?></span>
						<input  type="text" data-delivery data-req  name="<?php esc_attr_e('דואר אלקטרוני', wizshop_pages)?>" id="vs_EMail" value="" maxlength="50" class="dsp-block w-100">
					</div>
					<div class="col-12 col-md-4">
						<span class="dsp-block"><?php _e('טלפון / נייד', wizshop_pages)?></span>
						<input type="text" data-delivery data-req  name="<?php esc_attr_e('טלפון / נייד', wizshop_pages)?>" id="vs_Phone" value="" maxlength="50" class="dsp-block w-100">
					</div>

					<div class="col-12 col-md-4 v_ihide">
						<span class="dsp-block"><?php _e('שיטת משלוח', wizshop_pages)?></span>
						<select id="vs_Shiping" data-req data-wiz-shipping-container class="mnw-100 p-2 dsp-block">
							<option data-wiz-shipping-type ="" wiz_selection>{{Name}} : {{Price}}</option>
						</select>
					</div>
					<div class="col-12 col-md-4">
						<span class="dsp-block"><?php _e('כתובת', wizshop_pages)?></span>
						<input type="text" data-delivery data-req  name="<?php esc_attr_e('כתובת', wizshop_pages)?>" id="vs_Address" value="" maxlength="50" class="dsp-block w-100" >
					</div>
					<div class="col-12 col-md-4">
						<span class="dsp-block"><?php _e('עיר', wizshop_pages)?></span>
						<input type="text" data-delivery data-req  name="<?php esc_attr_e('עיר', wizshop_pages)?>" id="vs_City" value="" maxlength="50" class="dsp-block w-100">
					</div>
					<div class="col-12 col-md-4">
						<span class="dsp-block"><?php _e('מיקוד', wizshop_pages)?></span>
						<input type="text" data-delivery name="<?php esc_attr_e('מיקוד', wizshop_pages)?>" id="vs_Zip" value="" maxlength="50" class="dsp-block w-100">
					</div>
					<div class="col-12 col-md-4 v_ihide" >
						<span class="dsp-block"><?php _e('איזור', wizshop_pages)?></span>
						<input type="text" data-delivery name="<?php esc_attr_e('איזור', wizshop_pages)?>" id="vs_Region" value="" maxlength="50" class="dsp-block w-100">
					</div>
					<div class="col-12 col-md-4">
						<span class="dsp-block"><?php _e('מדינה', wizshop_pages)?></span>
						<select data-req data-wiz-country-container class="mnw-100 p-2 dsp-block">
							<option data-wiz-country = "" wiz_selection>{{Name}}</option>
						</select>
					</div>
		<!--            <div class="col-4">-->
		<!--                <span class="dsp-block">שיטת תשלום</span>-->
		<!--                <select data-wiz-pay-option-container class="mnw-100">-->
		<!--                    <option data-wiz-pay_option  wiz_selection>{{Name}}</option>-->
		<!--                </select>-->
		<!--            </div>-->

					<div class="col-12 col-md-4 {{dispRemark}}">
						<span for="vs_Remark" class="dsp-block"><?php _e('הערה', wizshop_pages)?></span>
						<input type="text" id="vs_Remark"  name="<?php esc_attr_e('הערה', wizshop_pages)?>" maxlength="250" value="" class="dsp-block w-100"/>
					</div>
				</div>

				<div class="accordion">
				</div>

				<!-- Buttons to show external invitation block -->
				<div class="my-4">
					<input id="vs_VSSameAdd" style="display:none" type="checkbox"  value='1' />
					<input id="other_add" type="checkbox"  value='1' />
					<span class="p-2"><?php _e('האם לשלוח את החשבונית לכתובת אחרת?', wizshop_pages)?></span>
				</div>
				<!-- External address for invitation -->
				<div class="collappse-block">
					<h3><?php _e('כתובת לחשבונית (אם שונה מהכתובת לעיל)', wizshop_pages)?></h3>
					<div class="row">
						<div class="col-12 col-md-4">
							<span class="dsp-block"><?php _e('שם ומשפחה', wizshop_pages)?></span>
							<input type="text" data-billing class="input-text" name="<?php esc_attr_e('שם ומשפחה', wizshop_pages)?>" id="vs_BName" value="" maxlength="50" class="dsp-block w-100">
						</div>
						<div class="col-12 col-md-4">
							<span class="dsp-block"><?php _e('כתובת', wizshop_pages)?></span>
							<input type="text" data-billing class="input-text" name="<?php esc_attr_e('כתובת', wizshop_pages)?>" id="vs_BAddress" value="" maxlength="50" class="dsp-block w-100">
						</div>
						<div class="col-12 col-md-4">
							<span class="dsp-block"><?php _e('עיר', wizshop_pages)?></span>
							<input type="text" data-billing class="input-text" name="<?php esc_attr_e('עיר', wizshop_pages)?>" id="vs_BCity" value="" maxlength="50" class="dsp-block w-100">
						</div>
						<div class="col-12 col-md-4">
							<span class="dsp-block"><?php _e('מיקוד', wizshop_pages)?></span>
							<input type="text" data-billing class="input-text" name="<?php esc_attr_e('מיקוד', wizshop_pages)?>" id="vs_BZip" value="" maxlength="50" class="dsp-block w-100">
						</div>
						<div class="col-12 col-md-4 v_ihide">
							<span class="dsp-block"><?php _e('איזור', wizshop_pages)?></span>
							<input type="text" data-billing class="input-text" name="<?php esc_attr_e('איזור', wizshop_pages)?>" id="vs_BRegion" value="" maxlength="50" class="dsp-block w-100">
						</div>
						<div class="col-12 col-md-4">
							<span class="dsp-block"><?php _e('מדינה', wizshop_pages)?></span>
							<select class="country_to_state country_select mnw-100 p-2 dsp-block" data-wiz-bcountry-container>
								<option data-wiz-country = "" wiz_selectio>{{Name}}</option>
							</select>
						</div>
						<div class="col-12 col-md-4">
							<span class="dsp-block"><?php _e('טלפון / נייד', wizshop_pages)?></span>
							<input type="text" data-billing class="input-text" name="<?php esc_attr_e('טלפון / נייד', wizshop_pages)?>" id="vs_BPhone" value="" maxlength="50" class="dsp-block w-100">
						</div>
					</div>
					<div class="clr"></div>
				</div>

				<input id="vs_VSSendAdvByMail" type="checkbox" style="display:none" value='1' />
				<input id="vs_VSSendCpn" type="checkbox" style="display:none" value='1' />
				
				<p  for="cpn-adv">
					<input id="cpn-adv" type="checkbox"  value='1' /> <?php _e('אני מאשר/ת קבלת חומר פירסומי וקופונים', wizshop_pages)?>  
				</p>
				<p  for="vs_VSSendDigInv">
					<input id="vs_VSSendDigInv" type="checkbox"  value='1' /> <?php _e('אני מסכים/ה לקבל חשבונית מס דיגיטלית (במקום חשבונית מס מודפסת על נייר)', wizshop_pages)?> 
				</p>

				
				<h3 class="purchase-title"><span wiz_login><?php _e('שינוי', wizshop_pages)?> </span> <?php _e('סיסמא', wizshop_pages)?></h3>
				<div class="row">
					<div class="col-12 col-md-auto flex-grow-1 flex-basis-4">
						<span class="dsp-block"><?php _e('סיסמא', wizshop_pages)?></span>
						<input data-req id="vs_Pass" name="<?php esc_attr_e('סיסמא', wizshop_pages)?>" type="password" size="25" maxlength="20" value="" class="dsp-block w-100">
					</div>
					<div class="col-12 col-md-auto flex-grow-1 flex-basis-4" wiz_login>
						<span class="dsp-block"><?php _e('סיסמא חדשה', wizshop_pages)?></span>
						<input  data-req id="vs_NewPass" name="<?php esc_attr_e('סיסמא חדשה', wizshop_pages)?>" type="password" size="25" maxlength="20" value="" class="dsp-block w-100" />
					</div>
					<div class="col-12 col-md-auto flex-grow-1 flex-basis-4">
						<span class="dsp-block"><?php _e('אימות סיסמא', wizshop_pages)?></span>
						<input data-req id="vs_ConfirmPass"  name="<?php esc_attr_e('אימות סיסמא', wizshop_pages)?>" type="password" size="25" maxlength="20" value="" class="dsp-block w-100" />
					</div>
					<div class="col-12 my-3 text-left">
						<input type="button" class="btn primary" data-wiz-change-pass wiz_login data-wiz-status="user-details|status_14|15" value="<?php esc_attr_e('שינוי סיסמא', wizshop_pages)?>">
					</div>
				</div>
				<div class="mt-3 col-12 col-md-6">
					<input type="button"  data-wiz-address="<?= esc_url(wizshop_get_reference_url())?>" data-wiz-register wiz_login data-wiz-status="user-details|status_14|14"  value="<?php esc_attr_e('אישור פרטים אישיים', wizshop_pages)?>" class="btn primary mnw-100">
					<input type="button"  data-wiz-address="<?= esc_url(wizshop_get_reference_url())?>" data-wiz-register wiz_logout data-wiz-status="user-details|status_14|14" value="<?php esc_attr_e('הרשמה', wizshop_pages)?>" class="btn primary mnw-100">
				</div>
			</div>
		</div>


</div>

<script>
jQuery(document).ready(function($) { 

	$(window).on("message",function(e) {
		var data = null;
		try{
			if(e.originalEvent) data = JSON.parse(e.originalEvent.data);
		}catch (e){
			data = null;
		}                              
		if (data && data.wizshop) {          
			if(data.userLogin){
				if(data.cust_obj && data.cust_obj.hasOwnProperty("VSSameAdd")){
					("1" == data.cust_obj.VSSameAdd) ? $('#collyes').click() : $('#collno').click();
					$('#other_add').prop("checked", "1" != data.cust_obj.VSSameAdd);
					sameAddress("1" == data.cust_obj.VSSameAdd);
				}
				$('#cpn-adv').prop("checked", (data.cust_obj && "1" == data.cust_obj.VSSendAdvByMail && "1" == data.cust_obj.VSSendCpn) );
			}
		}
	});  

	$('#collyes').click(function(e) {
		sameAddress(true);
	});

	$('#collno').click(function(e){
		sameAddress(false);
	});

	$('#other_add').click(function(e) {
		sameAddress(!this.checked);
	});	

	function sameAddress(on){
		$('#vs_VSSameAdd').prop( "checked", on );
		if(on){
			$('.collappse-block').css("display","none") ;
		}else{
			$('.collappse-block').css("display","block") ;
		}
	}
	
	$('#cpn-adv').on('click', function(e)  {
		$('#vs_VSSendAdvByMail').prop( "checked", this.checked );
		$('#vs_VSSendCpn').prop( "checked",  this.checked );
	});		

});
</script>