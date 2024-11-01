<?php 
if ( ! defined( 'ABSPATH' ) ) { exit; }
$dispB2B = wizshop_b2b_customer_details(); 
?>
<h3 data-wiz-title="3" class="purchase-title mb-2 title-off row">בחירת משלוח ותשלום</h3>
<div data-wiz-status-report="payment" data-wizshop data-wiz-scroll-into  class="alert w-100 my-3 p-1">
	<span data-wiz-status-text></span>
		<a href="javascript:void(0);" data-wiz-close-status class="dsp-inlineblock float-left basket-dismiss-btn">
			<img src="<?php echo wizshop_img_file_url('close.svg')?>" class="svg-icon basket-dismiss-icon">
		</a>
	</span>
</div>
<div class="row"  data-wiz-purchase  data-wizshop>
	
	<?php if(0 < $dispB2B): ?>
		<div class="w-100 my-2"><a href="javascript:void(0);" data-wiz-step="2" wiz_login>עדכון פרטי חשבון ומשלוח</a></div>
	<?php endif; ?>
	
	<div class="my-2">
		<label for="vs_Shiping" class="dsp-block">שיטת משלוח</label>
		<select id="vs_Shiping" data-req data-wiz-shipping-container class="mnw-100 p-2">
			<option data-wiz-shipping-type="" wiz_selection>{{Name}} : {{Price}}</option>
		</select>
		
	</div>
	<div id="payment_select"  class="w-100 my-2 " >
		<div data-wiz-credit-method class="mb-2"  >
			   <input type="radio" name="pay" id="use_credit" data-wiz-credit-type="0"/>
			   <label for="use_credit"  >כרטיס אשראי</label>
			   <input type="radio" name="pay" id="no_credit" data-wiz-credit-type="1"/>
			   <label for="no_credit"  >ללא כרטיס אשראי</label>
		  </div>	  
	</div>
	<div id="pay_mehtod_0" class=" w-100">
	
	<div class="my-2" >
		<label for="pay_num" class="dsp-block">מספר תשלומים</label>
		<select id="pay_num" data-wiz-payments-container>
			<option data-wiz-payment>{{Name}}</option>
		</select>
	</div>
	</div>
	<div class="my-2" >
		<span class="dsp-block">הערה לרכישה</span>
		<input type="text" name="הערה לרכישה" data-wiz-order-remark data-req data-wiz-status="payment|addcomment|4" class="input-text" >
	</div>

	<div class="w-100 my-2"  >
	 <input id="read_policy_id" data-wiz-read-policy data-wiz-status="payment|read_policy_p|14"  type="checkbox"/>
	<span for="read_policy_id">אני מאשר/ת שקראתי את <a href="/תקנון/">תקנון האתר</a> ומסכים/ה.</span>
	</div>
	
	<div id="pay_mehtod_01" class=" w-100">
	<div class="my-2"><button data-wiz-checkout data-wiz-status="payment|upd_p|14" class="btn primary ">המשך</button></div>
		
	</div>
	
	<iframe id="VSCreditIframe" style="display:none" width="100%" height="600px"></iframe>
	<div id="pay_mehtod_1"  class="v_ihide w-100 my-2">
		<div><button data-wiz-checkout data-wiz-status="payment|upd_p|14" class="btn primary ">סיום</button></div>
		
	</div>
</div>

<div id="checkout_report" data-wiz-purchase-report data-wizshop>
	<div data-wiz-fields>
		<h5 class="mb-2 mt-2" >הרכישה הושלמה בהצלחה</h5>
		
		<p class="mb-0">מספר הזמנה: {{OrderNo}}</p>
		<p class="mb-3">סה"כ: {{Total-P}} </p>
			
		<p class="mb-0 hide{{DeliveryMethod}}0">מחיר לפני משלוח: {{TotalCostItems}}</p>
		<p class="mb-0 hide{{DeliveryMethod}}0">שיטת משלוח: {{DeliveryMethod}}</p>
		<p class="mb-3 hide{{DeliveryMethod}}0">עלות משלוח: {{DeliveryCost}}</p>
		
		<p class="mb-0 hiderev{{cr_method}}">מספר תשלומים: {{PaymentsNo}}</p>
		<p class="mb-3 hiderev{{cr_method}} hide{{PaymentsCredit}}">תשלומי קרדיט: {{PaymentsCredit}}</p>
		
		<p class="mb-0 hiderev{{cr_method}}">חברת אשראי: {{CrFirmName}}</p>
		<p class="mb-0 hiderev{{cr_method}}">כרטיס אשראי: {{CrLastDigits}}</p>
		
	</div>
</div>