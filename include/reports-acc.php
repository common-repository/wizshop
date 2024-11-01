<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<div data-wiz-hash-report="acc" data-wizshop>
	<div class="row mb-3 mx-3">
		<h3 data-wiz-cur-balance class="m-0 dsp-inlineblock"> <span class="cur-balance  p-2 dsp-inlineblock"> <?php _e('יתרה נוכחית', wizshop_pages)?>: <span dir="ltr">{{CurrBalance}} </span></span> </h3>
	</div>
	
	<p class="mt-3 mb-1 mx-3"><?php _e('סינון תוצאות לפי', wizshop_pages)?>:</p>
	
	<div data-wiz-input class="row acc-boxes mx-3">
		<div  class="col-6 acc p-2">
			<div class="acc-title bb" id="DateTitle" onclick="openBox('Date')" ><?php _e('תאריך', wizshop_pages)?> </div>
			<div class="acc-box py-2 " id="DateBox">
				<div >
					<span><?php _e('החל מ', wizshop_pages)?> - </span>
					<input id="acc_DateF" type="date" data-wiz-date data-wiz-date-format="yyyy-mm-dd"/>
				</div>
				<div >
					<span><?php _e('עד', wizshop_pages)?>  - </span>
					<input id="acc_DateTo" type="date" data-wiz-date data-wiz-date-format="yyyy-mm-dd"/>
				</div>
			</div>
		</div>
		
		<div  class="col-6 acc p-2">
			<div class="acc-title bb" id="DueDateTitle" onclick="openBox('DueDate')"><?php _e('תאריך ערך', wizshop_pages)?> </div>
			<div class="acc-box py-2" id="DueDateBox">
				<div >
					<span><?php _e('החל מ', wizshop_pages)?> -</span>
					<input id="acc_DueDateF" type="date"  data-wiz-date data-wiz-date-format="yyyy-mm-dd"/>
				</div>
				<div >
					<span><?php _e('עד', wizshop_pages)?>  - </span>
					<input id="acc_DueDateTo" type="date" data-wiz-date  data-wiz-date-format="yyyy-mm-dd"/>
				</div>
			</div>
		</div>
		
		<div  class="col-6 acc p-2">
			<div class="acc-title bb" id="ReferenceTitle" onclick="openBox('Reference')"><?php _e('אסמכתא', wizshop_pages)?> </div>
			<div class="acc-box py-2" id="ReferenceBox">
				<div >
					<span><?php _e('החל מ', wizshop_pages)?> -</span>
					<input id="acc_ReferenceF" type="number" min="0"  value="0"/>
				</div>
				<div >
					<span> <?php _e('עד', wizshop_pages)?> - </span>
					<input id="acc_ReferenceTo" type="number" min="0" value="99999999"/>
				</div>
			</div>
		</div>
		<div  class="col-6 acc p-2">
			<div class="acc-title bb" id="Ref2Title" onclick="openBox('Ref2')"><?php _e('אסמכתא-2', wizshop_pages)?> </div>
			<div class="acc-box py-2" id="Ref2Box">
				<div >
					<span><?php _e('החל מ', wizshop_pages)?> -</span>
					<input id="acc_Ref2F" type="number" min="0"  value="0"/>
				</div>
				<div >
					<span> <?php _e('עד', wizshop_pages)?> - </span>
					<input id="acc_Ref2To" type="number" min="0" value="99999999"/>
				</div>
			</div>
		</div>
		
		<div  class="col-6 acc p-2">
			<div class="acc-title bb" id="AmountTitle" onclick="openBox('Amount')"><?php _e('סכום בש"ח', wizshop_pages)?> </div>
			<div class="acc-box py-2" id="AmountBox">
				<div >
					<span><?php _e('החל מ', wizshop_pages)?> -</span>
					<input id="acc_AmountF" type="number"  value="-99999999.99"/>
				</div>
				<div >
					<span> <?php _e('עד', wizshop_pages)?> - </span>
					<input id="acc_AmountTo" type="number" min="0" value="99999999"/>
				</div>
			</div>
		</div>

	</div>

	
	<div class="col-md-12 row justify-content-between m-0">
		<div class="onlyopen p-2"> 
			<input id="onlyopen" value="1" data-wiz-open-trans type="checkbox"/> <label for="onlyopen"><?php _e('הצג רק תנועות פתוחות', wizshop_pages)?></label>
		</div>
		<div class="col-md-4 p-2 sortby row no-gutters">
			<div class="col-md-4 align-self-center"><?php _e('מיון לפי', wizshop_pages)?>:</div>
			<select data-wiz-sort-method class="col-md-8 p-2"> 
				<option data-wiz-no-item><?php _e('ברירת מחדל', wizshop_pages)?></option>
				<option data-wiz-sort-by>{{Name}}</option>
			</select>
		</div>
		<div class="buttons p-2">
			<a href="javascript:void(0);" data-wiz-issue-rep class="btn primary"><?php _e('הפקה', wizshop_pages)?></a>
			<a href="javascript:void(0);" class="btn "><?php _e('הדפסה', wizshop_pages)?></a>
		</div>
	</div>

	
	<div data-wiz-output data-wiz-status data-wiz-date-format="dd-mm-yyyy" >
		<div data-wiz-rep-info class="mt-3 mb-1">
			 {{Total}} <?php _e('תנועות נמצאו', wizshop_pages)?>   
		</div>
		<div class="rep-table-container">
		<table class="rep-table">
			<thead data-wiz-rep-head>
				<tr>
					<th>{{h0}}</th>
					<th>{{h1}}</th>
					<th>{{h2}}</th>
					<th>{{h3}}</th>
					<th>{{h4}}</th>
					<th>{{h5}}</th>
					<th>{{h6}}</th>
				</tr>
			</thead>	
			<tbody data-wiz-rep-data class="ltr">
				<tr>
					<td>{{Date}}</td>
					<td>{{DueDate}}</td>
					<td>{{Reference}}</td>
					<td>{{Ref2}}</td>
					<td>{{Details}}</td>
					<td class="{{Type}}">{{Amount}}</td>
					<td>{{AccBalance}}</td>
				</tr>
			</tbody>
		</table>
		</div>
		
	</div>

</div>
<script type="text/javascript">
	function openBox(section) 
	{
		var sect = section;
		var box = document.getElementById(sect+"Box");
		if (box.style.display == 'flex'){
			document.getElementById(sect+"Box").style.display = 'none';
		}else{
			box.style.display = 'flex';
		}
	}
</script>