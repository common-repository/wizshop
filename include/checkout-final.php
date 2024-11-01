<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$dispB2B = wizshop_b2b_customer_details(); 
$co = wizshop_get_customer_options();
$is_reg = wizshop_is_reg_customer();
$pass_hide = "v_ihide";
?> 

<!-- Global status report (example) -->

<div class="row mx-0">
<input type="hidden" id="wiz_page_ver" value="2.0"/>

<div class="col-md-5 col-sm-12 pl-md-5 " id="wizshop-main-content">
	
	
	<div id="step_1" class="xrow" >
		
		<div data-wiz-sign-in data-wizshop class="cust-type-new link pr-2 w-100 b2c-button mb-3">
			<a data-cust-type="2"  wiz_logout>
				<h5 class="bb m-0 pb-2"> <?php echo $co["b2c_checkout_text"]; ?> <u> <?php _e('אנא התחברו', wizshop_pages)?> </u></h5>
			</a>
		</div>
		
		<div data-cust-form="2">
			<div data-wiz-status-report="sign-in" data-wizshop data-wiz-scroll-into  class="alert w-100 my-3 p-1">
				<span data-wiz-status-text></span>
				<a href="javascript:void(0);" data-wiz-close-status class="dsp-inlineblock float-left basket-dismiss-btn">
					<img src="<?php echo wizshop_img_file_url('close.svg')?>" class="svg-icon basket-dismiss-icon">
				</a>
			</div>
			<div  data-wiz-sign-in data-wizshop class="" data-wiz-error-class="v_field_err">
				<div class="row" wiz_logout>
					<div class="col-12 col-md-5">
						<span ><?php _e('דואר אלקטרוני', wizshop_pages)?></span>
						<input type="text"  size="25" name="<?php esc_attr_e('דואר אלקטרוני', wizshop_pages)?>" data-wiz-user-mail class="dsp-block w-100" />
					</div>
					<div class="col-12 col-md-5">
						<span ><?php _e('סיסמא', wizshop_pages)?></span>
						<input type="password"  size="25" name="<?php esc_attr_e('סיסמא', wizshop_pages)?>" data-wiz-user-pass class="dsp-block w-100" />
					</div>
					<div class="col-12 col-md-2 mt-2  px-1 dsp-flex">
						<a href="javascript:void(0);"  data-wiz-status="sign-in|status_14|14" data-wiz-login data-wiz-b2b data-wiz-address="#step_1" class="btn primary mnw-100 mt-auto" ><?php _e('כניסה', wizshop_pages)?></a>
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
				<h5 class="bb m-0 pb-2"> <?php echo $co["b2b_checkout_text"]; ?><u> <?php _e('אנא התחברו', wizshop_pages)?>  </u></h5>
			</a>
		</div>
		
		<div data-cust-form="1">
			<div data-wiz-status-report="sign-in-b2b" data-wizshop data-wiz-scroll-into  class="alert w-100 my-3 p-1">
			<span data-wiz-status-text></span>
			<a href="javascript:void(0);" data-wiz-close-status class="dsp-inlineblock float-left basket-dismiss-btn">
				<img src="<?php echo wizshop_img_file_url('close.svg')?>" class="svg-icon basket-dismiss-icon">
			</a>
			</div>
			<div data-wiz-sign-in data-wizshop class="mt-3 v_user_log " data-wiz-error-class="v_field_err">
				<div wiz_logout class="row">
					 <div class="col-12  col-md-5">
						<span wiz_logout><?php _e('קוד משתמש', wizshop_pages)?></span>
						<input type="text" size="25" name="<?php esc_attr_e('קוד משתמש', wizshop_pages)?>" data-wiz-user-key class="dsp-block w-100">
					</div>
					<div class="col-12  col-md-5">
						<span wiz_logout><?php _e('סיסמא', wizshop_pages)?></span>
						<input type="password" size="25" name="<?php esc_attr_e('סיסמא', wizshop_pages)?>" data-wiz-user-pass class="dsp-block w-100">
					</div>
					<div class="col-12 col-md-2 mt-2 px-1 dsp-flex">
						<a href="javascript:void(0);" data-wiz-status="sign-in-b2b|status_14|14" data-wiz-login data-wiz-b2b="1" data-wiz-address="#step_1"  class="btn primary mnw-100 mt-auto" ><?php _e('כניסה', wizshop_pages)?></a>
					</div>
					<div class="col-12 mt-3 ">
						<b><?php _e('שכחתי סיסמא / אני רוכש בפעם הראשונה', wizshop_pages)?>  </b>
						
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
	</div><!--step_1-->
		
		
	<div data-wiz-customer data-wizshop>
		<div class="mt-2 bb row mb-2 no-gutters">
			<div class="col-md-7">
				<div> <?php _e('שלב 1', wizshop_pages)?>  </div>
				<h5 data-wiz-title="2" class="m-0 pb-2"><span wiz_login><?php _e('אישור', wizshop_pages)?></span> <?php _e('פרטים אישיים', wizshop_pages)?></h5>	
			</div>
			<div class="col-md-5 text-left align-self-center">	
				<a href="javascript:void(0);" class="cust-type link pr-2 " data-wiz-logout wiz_login data-wiz-address="#step_1"><?php _e('התנתקות', wizshop_pages)?></a>
			</div>
		</div>
		<div wiz_login>
			<h6  data-wiz-text><?php _e('שלום', wizshop_pages)?> {{Name}}</h6>
		</div>
	</div>

	
<?php if(0 < $dispB2B): ?>
	<div id="step_2"  >
		
		<div data-wiz-status-report="sign-up" data-wizshop data-wiz-scroll-into  class="alert w-100 my-3 p-1">
			<span data-wiz-status-text></span>
			<a href="javascript:void(0);" data-wiz-close-status class="dsp-inlineblock float-left basket-dismiss-btn">
				<img src="<?php echo wizshop_img_file_url('close.svg')?>" class="svg-icon basket-dismiss-icon">
			</a>
		</div>
		
		<div  id="cust_info" data-wiz-customer data-wizshop data-cust-form="0">
		
			<div data-wiz-details data-wiz-error-class="v_field_err" class="data-wiz-details">
				
				<div class="row">
				<div class="col-12 col-md-12 mb-3 wizfield-email">
						<span class="dsp-block"><?php _e('מייל', wizshop_pages)?></span>
						<input  type="text" data-delivery data-req  name="<?php esc_attr_e('מייל', wizshop_pages)?>" id="vs_EMail" value="" maxlength="50" class="dsp-block w-100">
					</div>
					<div class="col-12 col-md-6 mb-3 wizfield-name ">
						<span class="dsp-block"><?php _e('שם מלא', wizshop_pages)?></span>
						<input type="text" data-delivery data-req  name="<?php esc_attr_e('שם מלא', wizshop_pages)?>" id="vs_Name" value="" maxlength="50" class="dsp-block w-100">
					</div>
					
					<div class="col-12 col-md-6 mb-3 wizfield-phone">
						<span class="dsp-block"><?php _e('טלפון / נייד', wizshop_pages)?></span>
						<input type="text" data-delivery data-req  name="<?php esc_attr_e('טלפון / נייד', wizshop_pages)?>" id="vs_Phone" value="" maxlength="50" class="dsp-block w-100">
					</div>

					<div class="col-12 col-md-4 v_ihide wizfield-shipping">
						<span class="dsp-block"><?php _e('שיטת משלוח', wizshop_pages)?></span>
						<select id="vs_Shiping" data-req data-wiz-shipping-container class="mnw-100 p-2">
							<option data-wiz-shipping-type ="" wiz_selection>{{Name}} : {{Price}}</option>
						</select>
					</div>
					<div class="col-12 col-md-8 mb-3 wizfield-address">
						<span class="dsp-block"><?php _e('כתובת', wizshop_pages)?></span>
						<input type="text" data-delivery data-req  name="<?php esc_attr_e('כתובת', wizshop_pages)?>" id="vs_Address" value="" maxlength="50" class="dsp-block w-100">
					</div>
					<div class="col-12 col-md-4 mb-3 wizfield-city">
						<span class="dsp-block"><?php _e('עיר', wizshop_pages)?></span>
						<input type="text" data-delivery data-req  name="<?php esc_attr_e('עיר', wizshop_pages)?>" id="vs_City" value="" maxlength="50" class="dsp-block w-100">
					</div>
					
					<div class="col-12 col-md-auto flex-grow-1 mb-3 flex-basis-4  wizfield-zip">
						<span class="dsp-block"><?php _e('מיקוד', wizshop_pages)?></span>
						<input type="text" data-delivery name="<?php esc_attr_e('מיקוד', wizshop_pages)?>" id="vs_Zip" value="" maxlength="50" class="dsp-block w-100">
						<a href="https://mypost.israelpost.co.il/%D7%A9%D7%99%D7%A8%D7%95%D7%AA%D7%99%D7%9D/%D7%90%D7%99%D7%AA%D7%95%D7%A8-%D7%9E%D7%99%D7%A7%D7%95%D7%93/" class="zip-link link" target="_blank"> <?php _e('איתור מיקוד', wizshop_pages)?>  </a>
					</div>
					<div class="col-12 col-md-auto flex-grow-1 mb-3 flex-basis-4 wizfield-area " >
						<span class="dsp-block"><?php _e('איזור', wizshop_pages)?></span>
						<input type="text" data-delivery name="<?php esc_attr_e('איזור', wizshop_pages)?>" id="vs_Region" value="" maxlength="50" class="dsp-block w-100">
					</div>
					<div class="col-12 col-md-auto flex-grow-1 mb-3 flex-basis-4 wizfield-country">
						<span class="dsp-block"><?php _e('מדינה', wizshop_pages)?></span>
						<select data-req data-wiz-country-container class="mnw-100 p-2 dsp-block">
							<option data-wiz-country = "" wiz_selection>{{Name}}</option>
						</select>
					</div>
					<div class="col-12 col-md-12 mb-3 wizfield-payoption">
						<span class="dsp-block"><?php _e('אמצעי תשלום', wizshop_pages)?></span>
						<select  data-wiz-pay-option-container >
							<option data-wiz-pay_option wiz_selection>{{Name}}</option>
						</select>
					</div>
					<div class="col-12 col-md-12 mb-3  wizfield-exdata" data-wiz-order-exdata>
						<span for="vs_OrdExDataTab" class="dsp-block">{{Name}}</span>
						<input type="text" id="vs_OrdExDataTab"  data-wiz-value class="input-text form-control dsp-block w-100" value="{{Data}}" name="{{Name}}" maxlength="{{Max}}" >
					</div>
	
					
				</div>
				
				
				<div class="bb mt-3"></div>
				<!-- Buttons to show invoice address -->
				<div class="my-2">
					<input id="vs_VSSameAdd" style="display:none" type="checkbox"  value='1' />
					<input id="other_add" type="checkbox"  value='1' />
					<span class="p-2"><?php _e('האם לשלוח את החשבונית לכתובת אחרת?', wizshop_pages)?></span>
				</div>
				<!-- Invoice address -->
				<div class="collappse-block">
					<h3><?php _e('כתובת לחשבונית (אם שונה מהכתובת לעיל)', wizshop_pages)?></h3>
					<div class="row">
						<div class="col-12 col-md-6 wizfield-name">
							<span class="dsp-block"><?php _e('שם מלא', wizshop_pages)?></span>
							<input type="text" data-billing class="dsp-block w-100" name="<?php esc_attr_e('שם ומשפחה', wizshop_pages)?>" id="vs_BName" value="" maxlength="50" >
						</div>
						<div class="col-12 col-md-6 wizfield-phone">
							<span class="dsp-block"><?php _e('טלפון / נייד', wizshop_pages)?></span>
							<input type="text" data-billing class="dsp-block w-100" name="<?php esc_attr_e('טלפון / נייד', wizshop_pages)?>" id="vs_BPhone" value="" maxlength="50">
						</div>
						<div class="col-12 col-md-8 wizfield-address">
							<span class="dsp-block"><?php _e('כתובת', wizshop_pages)?></span>
							<input type="text" data-billing class="dsp-block w-100" name="<?php esc_attr_e('כתובת', wizshop_pages)?>" id="vs_BAddress" value="" maxlength="50">
						</div>
						<div class="col-12 col-md-4 wizfield-city">
							<span class="dsp-block"><?php _e('עיר', wizshop_pages)?></span>
							<input type="text" data-billing class="dsp-block w-100" name="<?php esc_attr_e('עיר', wizshop_pages)?>" id="vs_BCity" value="" maxlength="50">
						</div>
						<div class="col-12 col-md-auto flex-grow-1 mb-3 flex-basis-4  wizfield-zip">
							<span class="dsp-block"><?php _e('מיקוד', wizshop_pages)?></span>
							<input type="text" data-billing class="dsp-block w-100" name="<?php esc_attr_e('מיקוד', wizshop_pages)?>" id="vs_BZip" value="" maxlength="50">
						</div>
						<div class="col-12 col-md-auto flex-grow-1 mb-3 flex-basis-4  wizfield-area">
							<span class="dsp-block"><?php _e('איזור', wizshop_pages)?></span>
							<input type="text" data-billing class="dsp-block w-100" name="<?php esc_attr_e('איזור', wizshop_pages)?>" id="vs_BRegion" value="" maxlength="50">
						</div>
						<div class="col-12 col-md-auto flex-grow-1 mb-3 flex-basis-4  wizfield-country">
							<span class="dsp-block"><?php _e('מדינה', wizshop_pages)?></span>
							<select class="country_to_state country_select mnw-100 p-2 dsp-block" data-wiz-bcountry-container>
								<option data-wiz-country = "" wiz_selectio>{{Name}}</option>
							</select>
						</div>
					
					</div>
					<div class="clr"></div>
				</div>
				<div class="bb"></div>
				<input id="vs_VSSendAdvByMail" type="checkbox" style="display:none" value='1' />
				<input id="vs_VSSendCpn" type="checkbox" style="display:none" value='1' />
				<div class="my-1">
					<input id="cpn-adv" type="checkbox"  value='1' />
					<label for="cpn-adv"> <?php _e('אני מאשר/ת קבלת חומר פירסומי וקופונים', wizshop_pages)?> </label>
				</div>
				<div class="my-1">
					<input id="vs_VSSendDigInv" type="checkbox"  value='1' />
					<label for="vs_VSSendDigInv"><?php _e('אפשר לשלוח לי חשבונית מס דיגיטלית במקום חשבונית מודפסת', wizshop_pages)?></label>
				</div>
				
				<?php if(wizshop_is_shipping()): ?>
					<div class="total-box my-3 p-2">
					<?php _e('ניתן לבחור עלות ושיטת משלוח בשלב הבא', wizshop_pages)?>
					</div>
				<?php endif; ?>
				
				<div class="password-container px-3 py-2">
					<?php if($is_reg): ?>
						<h4  class="my-3 showpass"><button class="sub-icon ml-3 p-0" >+</button><?php _e('שינוי סיסמא?', wizshop_pages) ?>  </h4>
					<?php elseif (wizshop_is_guest_allowed()): ?>
						<h4  class="my-3 showpass"><button class="sub-icon ml-3 p-0" >+</button><?php _e('רוצים להירשם לאתר?', wizshop_pages)?>  </h4>
					<?php else: 
						$pass_hide="";
					endif; ?>
					
					<div class="row password-block mb-3 <?php echo $pass_hide ?>" >
						<div class="col-12 password-info py-2"><?php _e('יש להגדיר סיסמא המכילה לפחות 6 תווים | הסיסמא חייבת להכיל שילוב של ספרות ואותיות באנגלית', wizshop_pages)?></div>
						<div class="col-12 col-md-auto flex-grow-1 mb-3 flex-basis-4">
							<span class="dsp-block"><?php _e('סיסמא', wizshop_pages)?></span>
							<input data-req id="vs_Pass" name="<?php esc_attr_e('סיסמא', wizshop_pages)?>" type="password" size="25" maxlength="20" value=""  class="dsp-block w-100">
						</div>
						<div class="col-12 col-md-auto flex-grow-1 mb-3 flex-basis-4" wiz_login>
							<span class="dsp-block" ><?php _e('סיסמא חדשה', wizshop_pages)?></span>
							<input  data-req id="vs_NewPass" name="<?php esc_attr_e('סיסמא חדשה', wizshop_pages)?>" type="password" size="25" maxlength="20" value=""  class="dsp-block w-100" />
						</div>
						<div class="col-12 col-md-auto flex-grow-1 mb-3 flex-basis-4">
							<span class="dsp-block"><?php _e('אימות סיסמא', wizshop_pages)?></span>
							<input data-req id="vs_ConfirmPass"  name="<?php esc_attr_e('אימות סיסמא', wizshop_pages)?>" type="password" size="25" maxlength="20" value=""  class="dsp-block w-100" />
						</div>
						<div class="col-12 col-md-12 my-3 text-left">
							<input type="button" class="btn primary primary-outline" data-wiz-change-pass wiz_login data-wiz-status="sign-up|status_14|15" value="<?php esc_attr_e('שינוי סיסמא', wizshop_pages)?>">
							<input type="button" class="btn primary primary-outline" data-wiz-register wiz_logout data-wiz-status="sign-up|status_14|14" data-wiz-address="#step_3" value="<?php esc_attr_e('הרשמה', wizshop_pages)?>" >
						</div>
					</div>
				</div>
				<div class="mt-3 col-12 col-md-6 pr-0 mb-4">
					<input type="button"  data-wiz-register wiz_login data-wiz-status="sign-up|status_14|14" data-wiz-address="#step_3" value="<?php esc_attr_e('אישור פרטים אישיים', wizshop_pages)?>" class="btn primary mnw-100">
					<?php if(wizshop_is_guest_allowed()): ?>
						<input type="button"  wiz_logout data-wiz-step="3" value="<?php esc_attr_e('המשך', wizshop_pages)?>" class="btn primary mnw-100">
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div> <!--step_2-->
<?php endif; ?>
		
	<div class="clr"></div>
	<div class="bb mt-5 row clr">
		<div class="col-12"><?php _e('שלב 2', wizshop_pages)?> </div>
		<h5 data-wiz-title="3" class="col-12 m-0 pb-2">
			<?php if(wizshop_is_shipping()): ?>
				<?php _e('בחירת משלוח ו', wizshop_pages)?><?php endif; ?><?php _e('תשלום', wizshop_pages)?>
		</h5>
	</div>
	<div data-wiz-status-report="payment" data-wizshop data-wiz-scroll-into  class="alert w-100 my-3 p-1">
			<span data-wiz-status-text></span>
				<a href="javascript:void(0);" data-wiz-close-status class="dsp-inlineblock float-left basket-dismiss-btn">
					<img src="<?php echo wizshop_img_file_url('close.svg')?>" class="svg-icon basket-dismiss-icon">
				</a>
			</span>
	</div>

	<div id="step_3" data-wiz-purchase  data-wiz-customer-info="cust_info" data-wizshop>
			
		<?php if(0 < $dispB2B): ?>
			<div class="w-100 my-2 link updateinfo"><a href="javascript:void(0);" data-wiz-step="2" ><?php _e('עדכון פרטים אישיים', wizshop_pages)?></a></div>
		<?php endif; ?>
		<div id="payment_select"  class="w-100  paymethod" >
			<div data-wiz-credit-method class="my-3"  >
				   <input type="radio" name="pay" id="use_credit" data-wiz-credit-type="0"/>
				   <label for="use_credit" class="ml-3" ><?php _e('תשלום באשראי', wizshop_pages)?></label>
				   <input type="radio" name="pay" id="no_credit" data-wiz-credit-type="1"/>
				   <label for="no_credit"  ><?php _e('הזמנה ללא אשראי', wizshop_pages)?></label>
			</div>	  
		</div>
		<div class="row shippingmethod">
			<label for="vs_Shiping" class="col-md-4 my-3"><?php _e('שיטת משלוח', wizshop_pages)?></label>
			<select id="vs_Shiping" data-req data-wiz-shipping-container class="col-md-8 my-3">
				<option data-wiz-shipping-type="" wiz_selection>{{Name}} : {{Price}}</option>
			</select>
		</div>
		<div class="row supplydate">
			<label class="col-md-4 my-3" for="supp_id"><?php _e('תאריך אספקה', wizshop_pages)?></label>
			<input data-wiz-supply-date data-wiz-date  data-wiz-date-format="yyyy-mm-dd" id="supp_id"  type="date" class="col-md-8 my-3" />
		</div>
		<div id="pay_mehtod_0" class="row my-3 paynumber">
			<label for="pay_num" class="col-md-4"><?php _e('מספר תשלומים', wizshop_pages)?></label>
			<select id="pay_num" data-wiz-payments-container class="col-md-8">
				<option data-wiz-payment>{{Name}}</option>
			</select>
		</div>
		<div class="my-3 row paycomment" >
			<span class="col-md-4"><?php _e('הערה', wizshop_pages)?></span>
			<textarea type="text" name="<?php esc_attr_e('הערה', wizshop_pages)?>" data-wiz-order-remark data-req data-wiz-status="payment|addcomment|4" class="col-md-8" > </textarea>
		</div>
		<div class="my-3 row extraaddress ">
			<select data-wiz-confirm-method class="w-100 v_ihide">
				<option data-wiz-confirm-type ="0" value="0">לא אישור</option>
				<option data-wiz-confirm-type="1" value="1"  >כתובת לקוח</option>
				<option data-wiz-confirm-type="2" value="2">משרד אחורי </option>
				<option data-wiz-confirm-type="3" value="3" selected>כתובת זו ומשרד אחורי: </option>
			</select>
			<label  class="col-md-6"><?php _e('שליחת אישור הזמנה לכתובת מייל נוספת', wizshop_pages)?></label>					
			<input type="text" data-wiz-confirm3-address class="col-md-6"/>
		</div>
		<div class="w-100 policy"  >
			<input id="read_policy_id" data-wiz-read-policy data-wiz-status="payment|read_policy_p|14" type="checkbox" class="m-0 my-3"/>
			<span for="read_policy_id" class="my-3"><?php _e('אני מאשר/ת שקראתי את <a href="/תקנון/"  target="_blank">תקנון האתר</a> ומסכים/ה.', wizshop_pages)?></span>
		</div>
		<div id="pay_mehtod_01" class=" w-100 my-5">
			<button data-wiz-checkout data-wiz-status="payment|upd_p|14" class="btn primary "><?php _e('מעבר לתשלום מאובטח', wizshop_pages)?></button>
			
		</div>
		<iframe id="VSCreditIframe" style="display:none" width="100%" height="600px"></iframe>
		<div id="pay_mehtod_1"  class="v_ihide w-100 my-5">
			<button data-wiz-checkout data-wiz-status="payment|upd_p|14" class="btn primary "><?php _e('שליחת הזמנה', wizshop_pages)?></button>
			
		</div>

	</div><!--step_3-->
		
	<div id="checkout_report" data-wiz-purchase-report data-wizshop>
		<div data-wiz-fields>
			<h5 class="mb-2 mt-2" ><?php _e('הרכישה הושלמה בהצלחה', wizshop_pages)?></h5>
			
			<p class="mb-0"><?php _e('מספר הזמנה', wizshop_pages)?>: {{OrderNo}}</p>
			<p class="mb-3 {{dispPrice}}"><?php _e('סה"כ', wizshop_pages)?>: {{Total-P}} </p>
			
			
			<p class="mb-0 hide{{DeliveryMethod}}0 {{dispPrice}}"><?php _e('מחיר לפני משלוח', wizshop_pages)?>: {{TotalCostItems}}</p>
			<p class="mb-0 hide{{DeliveryMethod}}0"><?php _e('שיטת משלוח', wizshop_pages)?>: {{DeliveryMethod}}</p>
			<p class="mb-3 hide{{DeliveryMethod}}0 {{dispPrice}}"><?php _e('עלות משלוח', wizshop_pages)?>: {{DeliveryCost}}</p>
			
			<p class="mb-0 hiderev{{cr_method}} {{dispPrice}}"><?php _e('מספר תשלומים', wizshop_pages)?>: {{PaymentsNo}}</p>
			<p class="mb-3 hiderev{{cr_method}} hide{{PaymentsCredit}} {{dispPrice}}"><?php _e('תשלומי קרדיט', wizshop_pages)?>: {{PaymentsCredit}}</p>
			
			<p class="mb-0 hiderev{{cr_method}}"><?php _e('חברת אשראי', wizshop_pages)?>: {{CrFirmName}}</p>
			<p class="mb-0 hiderev{{cr_method}}"><?php _e('כרטיס אשראי', wizshop_pages)?>: {{CrLastDigits}}</p>
			
		</div>
	</div>
			
</div><!-- wizshop-main-content -->

<div class="col-md-1"></div>

<!--Order summary box-->
<div class="col-md-6 mt-5 mt-md-0 pr-md-5 " id="order-summary">
	<div id="wiz-cart" class="v_cart v_ihide short-basket  p-md-5 p-1" data-wiz-shopping-cart data-wizshop data-auto-hide>
		<h3 class="mb-1 mr-1 order-title"><?php _e('סיכום הזמנה', wizshop_pages)?></h3>
		<table data-wiz-cart-container class="table-nodorder layout-auto w-100">
		<tbody>
			<tr data-wiz-discount-item >
				<td colspan="2">{{Name}}</td>
				<td colspan="3" >{{LineTotal-P}} </td>
			</tr>
			<tr data-wiz-cart-item>
			 <script type="text/html">
				<td class="px-2 product-name">
					<a href="<?= esc_url(wizshop_get_products_url())?>{{Link}}" class="item-link">{{Name}}</a>
				</td>
				<td class="px-2 product-quantity">
					 <span class="{{dispUnits}} Packs{{dispPacks}}">
						<label class="{{dispPacks}}"><?php _e('יחידות', wizshop_pages)?></label>
						<input type="number" min="0" size="2" wiz_QuantId="{{QuantId}}" data-wiz-packs-only="{{OnlyPacks}}" value="{{ItemsQuant}}" class="price-input">
					</span>
					<span class="{{dispPacks}}">
						<label><?php _e('אריזות של', wizshop_pages)?> {{QntInPack}}:</label>
						<input type="number" min="0" size="2" wiz_PacksId="{{PacksId}}" data-wiz-quant-in-pack="{{QntInPack}}" value="{{PacksNoInCart}}" class="price-input">
					</span>
				</td>
				<td class="px-2 product-price {{dispPrice}}"> x </td> 
				<td class="px-2 product-price {{dispPrice}} "><strong>{{Price-P}}</strong></td>
				<td class="px-2 product-delete ">
					<a href="javascript:void(0);" data-wiz-remove-from-cart='{{ID}}' data-wiz-status="" class="remove" title="<?php esc_attr_e('הסר פריט זה', wizshop_pages)?>"><img src="<?php echo wizshop_img_file_url('delete.svg')?>" class="svg-icon"></a> 
				</td>
			</script>
			</tr>
		</tbody>
		</table>

		<div data-wiz-cart-coupons class="v_ihide row no-gutters mb-4">
			<span class="col-12"><?php _e('ברשותך קוד קופון?', wizshop_pages)?></span>
			<div  class="col-8 pl-2"><input type="text" maxlength="30" class="w-100" data-coupon-code value="{{VSCpUsed_1}}"/>      </div>
			<div class="col-4"><a data-send-coupon href="javascript:void(0);" data-wiz-status="sign-up|status_14|15" class="btn primary w-100"><?php _e('הפעלת קופון', wizshop_pages)?></a></div>
			<div class="coupon-msg coupon_status_{{VSCpUsed_0}} my-2"> 
				<div class="og-status">{{VSCpUsed_5}}</div>
			</div>
		</div>
		<footer data-wiz-cart-totals class="col-12  mt-3 p-3 px-2 totals">
		   
			<div class=" py-1 {{dispPrice}}"><strong><?php _e('סיכום ביניים', wizshop_pages)?>:</strong> {{TotalCostItems-P}} <span class="hide{{PreVat}}"><?php _e('(לפני מע"מ)', wizshop_pages)?></span></div>
			<div class="py-1 hide{{TotalDiscount}} {{dispPrice}}" ><strong><?php _e('שוברים והנחות', wizshop_pages)?>:</strong> {{TotalDiscount-P}} -</div>
			<div class="py-1 hide{{DeliveryMethod}}0"><strong><?php _e('משלוח', wizshop_pages)?>: </strong> {{DeliveryMethod}} <span class="{{dispPrice}}">({{DeliveryCost-P}})</span> </div>
			<div class="py-1 {{dispPrice}}"><strong><?php _e('סה"כ לתשלום', wizshop_pages)?>: {{Total-P}} <span class="hide{{PreVat}}"><?php _e('(לפני מע"מ)', wizshop_pages)?></span></strong> </div>
			<div class="py-1 {{dispPrice}} hide{{VSCpAmount}}"><strong><?php _e('סכום הקופון', wizshop_pages)?>:</strong> {{VSCpAmount-P}} <span class="hide{{PreVat}}"><?php _e('(לפני מע"מ)', wizshop_pages)?></span> </div>
			<div class="py-1 {{dispPrice}} hide{{VSCpAmount}}"><strong><?php _e('סכום לתשלום באשראי', wizshop_pages)?>: {{PayAmount-P}} <span class="hide{{PreVat}}"><?php _e('(לפני מע"מ)', wizshop_pages)?></span></strong> </div>
		
		</footer>
		<div class="clr"></div>
	</div><!-- wiz-cart -->
	
	<div class="empty-basket short-basket p-2">
		<p class="cart-empty"><?php _e('העגלה שלך ריקה כרגע', wizshop_pages)?>.</p>
		<a class="btn primary-outline" href="/"><?php _e('חזרה לחנות', wizshop_pages)?></a>
	</div>
	
</div><!--Order summary box-->

</div>