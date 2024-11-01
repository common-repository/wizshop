<?php 
if ( ! defined( 'ABSPATH' ) ) { exit; } 
?> 
<div data-wiz-status-report="agents" data-wiz-scroll-into data-wizshop  class="alert w-100 mb-3 p-1">
	<span data-wiz-status-text></span>
		<a href="javascript:void(0);" data-wiz-close-status class="dsp-inlineblock float-left basket-dismiss-btn">
			<img src="<?php echo wizshop_img_file_url('close.svg')?>" class="svg-icon basket-dismiss-icon">
		</a>
	</span>
</div>
<h2 class="purchase-title"><?php _e('פרטי התחברות הסוכן', wizshop_pages)?></h2>
<div data-wiz-agent-sign-in data-wizshop data-wiz-error-class="v_field_err">

	<div class="row align-items-end mb-5">
		<div class="col-12 col-md-3 mb-2 mb-md-0">
			<div ><?php _e('דואר אלקטרוני', wizshop_pages)?>:</div>
			<input type="email"  name="<?php esc_attr_e('דואר אלקטרוני', wizshop_pages)?>" data-wiz-user-mail class="dsp-block w-100" />
		</div>
		<div class="col-12 col-md-3 mb-3 mb-md-0">
			<div><?php _e('סיסמא', wizshop_pages)?>:</div>
			<input type="password" name="<?php esc_attr_e('סיסמא', wizshop_pages)?>" data-wiz-user-pass class="dsp-block w-100" />
		</div>
		<div class="col-12 col-md-2 mb-2 mb-md-0">	
			<a href="javascript:void(0);"  data-wiz-login data-wiz-b2b data-wiz-status="agents|upd_p|14" class="btn primary mnw-100 mt-auto"><?php _e('כניסת סוכן', wizshop_pages)?></a>
		</div>
		<div class="col-12 col-md-4">
			<a href="javascript:void(0);"  data-wiz-send-pass data-wiz-b2b  data-wiz-status="agents|pass_rest|15" class="link"><?php _e('שכחתי סיסמא, אנא שלחו לי מייל שיחזור סיסמא', wizshop_pages)?></a>
		</div>
	</div>
</div>
<div data-wiz-agent data-wizshop>            
	<div data-wiz-agent-info class="mb-3">
		<div class="dsp-inlineblock pl-4"><?php _e('שלום', wizshop_pages)?> {{AgentName}}</div>
		<div class="dsp-inlineblock">
			<a href="javascript:void(0);" data-agent-exit data-wiz-address><span><?php _e('יציאה', wizshop_pages)?></span></a>
		</div>
	</div>
	<h2 class="purchase-title"><?php _e('איתור לקוחות', wizshop_pages)?></h2>          
	<div data-wiz-input>
		<div class="row">
			<div class="col-12 col-md-8 row ">
				<div class="col-12 col-md-auto ">
					<span for="src_Name"><?php _e('שם לקוח (לפחות 3 אותיות)', wizshop_pages)?></span>
				</div>
				<div class="col-12 col-md-auto ">
					<input data-req id="src_Name" name="<?php esc_attr_e('שם לקוח', wizshop_pages)?>" type="text" size="25" maxlength="50" value='' />
				</div>
				<div class="col-12 col-md-auto my-2 my-md-0 ">
					<a href="javascript:void(0);" data-wiz-search data-wiz-status="login_id|upd_p|15"  class="btn primary"><?php _e('חיפוש', wizshop_pages)?></a>
				</div>
			</div>
			<div class="align-items-center col-12 col-md-4 dsp-flex justify-content-md-end justify-content-sm-start my-2 my-md-0 pl-0 text-left agent-icons">
				<a data-win="#open-page" class="click-me ml-3"><img src="<?php echo wizshop_img_file_url('settings.svg')?>" class="svg-icon"> <?php _e('הגדרות', wizshop_pages)?> </a>
				<a data-win="#more-filters" class="click-me ml-3"><img src="<?php echo wizshop_img_file_url('filter.svg')?>" class="svg-icon"> <?php _e('סינונים נוספים', wizshop_pages)?> </a>
			</div>
		</div>
			<div class="acc-boxes my-3 p-2 click-me-target " id="more-filters" style="display:none">
				<span for="src_City"><?php _e('עיר', wizshop_pages)?></span>
				<input  id="src_City" name="<?php esc_attr_e('עיר', wizshop_pages)?>" type="text" size="25" maxlength="50" value='' />

				<span for="src_Email"><?php _e('דואר אלקטרוני', wizshop_pages)?></span>
				<input  id="src_Email" name="<?php esc_attr_e('דואר אלקטרוני', wizshop_pages)?>" type="email" size="25" maxlength="50" value='' autocomplete="off"/>
		   </div>
		   
			<div class="acc-boxes my-3 pl-5 px-4 py-4 click-me-target" id="open-page" style="display:none">
				<label for="adds"><?php _e('דף פתיחה', wizshop_pages)?></label>
				<select id="adds" data-wiz-addresses>
					<option   data-wiz-address="/"><?php _e('ראשי', wizshop_pages)?></option>
					<option  data-wiz-address="<?= esc_url(wizshop_get_cart_url())?>" ><?php _e('סל קניות', wizshop_pages)?></option>
					<option  data-wiz-no-item><?php _e('השאר בדף זה', wizshop_pages)?></option>
				</select>
			</div>
	</div>
	
	<div data-wiz-customers  data-wiz-status >
	
		<table class="basket-table responsive-table no-titles agents mt-3">
			<thead data-wiz-cus-head class="basket-thead">
				<tr>
					<th class="py-3"><?php _e('שם', wizshop_pages)?></th>
					<th class="py-3"><?php _e('מפתח', wizshop_pages)?></th>
					<th class="py-3"><?php _e('מס טלפון', wizshop_pages)?></th>
					<th class="py-3"><?php _e('דואר אלקטרוני', wizshop_pages)?></th>
					<th class="py-3"><?php _e('כתובת', wizshop_pages)?></th>
					<th class="py-3"><?php _e('עיר', wizshop_pages)?></th>
					<th class="{{dispBalance}} py-3"><?php _e('יתרה', wizshop_pages)?></th>
					<th class="py-3"></th>
				</tr>
			</thead> 
			<tbody data-wiz-cus-data>
				<tr>
					<td class="pr-xs-4"><a data-wiz-customer="{{Key}}" href="{{Link}}" class="link" target="_blank">{{Name}}</a></td>
					<td class="pr-xs-4"> {{WizKey}}</td>
					<td class="pr-xs-4">{{Phone}}</td>
					<td class="pr-xs-4">{{Email}}</td>
					<td class="pr-xs-4">{{Address}}</td>
					<td class="pr-xs-4">{{City}}</td>
					<td class="{{dispBalance}} pr-xs-4">{{CurrBalance}}</td>
					<td class="pr-xs-4"><a class="btn primary" data-wiz-customer="{{Key}}" href="{{Link}}" target="_blank"><?php _e('התחברות', wizshop_pages)?></a></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="empty-basket">	<?php _e('לא נמצאו לקוחות תואמים לחיפוש', wizshop_pages)?>. 	</div>
</div>