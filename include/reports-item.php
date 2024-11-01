<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<!-- status -->
<div data-wiz-status-report="reports-item" data-wiz-scroll-into data-wizshop class="alert w-100 my-3 p-1">
	<span data-wiz-status-text></span>
	<a href="javascript:void(0);" data-wiz-close-status class="dsp-inlineblock float-left basket-dismiss-btn">
		<img src="<?php echo wizshop_img_file_url('close.svg')?>" class="svg-icon basket-dismiss-icon">
	</a>
</div>
<div data-wiz-hash-report="itm" data-wizshop>
	<div data-wiz-input >
			<div class="acc-boxes my-3 p-2">

			<div class="align-items-center justify-content-start m-0 row">
				<div class="acc-title m-md-2 col-md-3 col-sm-12"><?php _e('סינון תוצאות לפי תאריך', wizshop_pages)?>: </div>
				<div class="col-md-4 col-sm-12">
				<span><?php _e('החל מ', wizshop_pages)?> -</span>
				<input id="itm_DateF" class="col-sm-12" type="date" data-wiz-date data-wiz-date-format="yyyy-mm-dd"/>
				</div>
				<div class="col-md-4 col-sm-12">
				<span><?php _e('עד', wizshop_pages)?>  - </span>
				<input id="itm_DateTo" class="col-sm-12" type="date" data-wiz-date data-wiz-date-format="yyyy-mm-dd"/>
				</div>
			</div>
			
			<div class="v_ihide">
				<span><?php _e('תאריך ערך', wizshop_pages)?>:</span>
				<input id="itm_DueDateF" type="date"  data-wiz-date data-wiz-date-format="yyyy-mm-dd"/>
				<span><?php _e('עד', wizshop_pages)?>  - </span>
				<input id="itm_DueDateTo" type="date" data-wiz-date  data-wiz-date-format="yyyy-mm-dd"/>
			</div>
			
			<div class="v_ihide">
				<span><?php _e('אסמכתא', wizshop_pages)?>:</span>
				<input id="itm_ReferenceF" type="number" min="0"  value="0"/>
				<span><?php _e('עד', wizshop_pages)?>  - </span>
				<input id="itm_ReferenceTo" type="number" min="0" value="99999999"/>
			</div>

			<div class="v_ihide">
				<span><?php _e('אסמכתא-2', wizshop_pages)?>:</span>
				<input id="itm_Ref2F" type="number" min="0"  value="0"/>
				<span><?php _e('עד', wizshop_pages)?>  - </span>
				<input id="itm_Ref2To" type="number" min="0" value="99999999"/>
			</div>
			
			<div class="v_ihide">
				<span><?php _e('סכום', wizshop_pages)?>:</span>
				<input id="itm_AmountF" type="number"  value="-99999999.99"/>
				<span><?php _e('עד', wizshop_pages)?>  - </span>
				<input id="itm_AmountTo" type="number" min="0" value="99999999"/>
			</div>
			
			<div class="v_ihide">
				<span><?php _e('מחיר', wizshop_pages)?>:</span>
				<input id="itm_PriceF" type="number"  value="-99999999.99"/>
				<span><?php _e('עד', wizshop_pages)?>  - </span>
				<input id="itm_PriceTo" type="number" min="0" value="99999999"/>
			</div>
			

			<div class="v_ihide">
				<span><?php _e('כמות', wizshop_pages)?>:</span>
				<input id="itm_QuantityF" type="number"  value="-99999999.99"/>
				<span><?php _e('עד', wizshop_pages)?>  - </span>
				<input id="itm_QuantityTo" type="number" min="0" value="99999999"/>
			</div>

			<div class="v_ihide">
				<span><?php _e('הנחת פריט', wizshop_pages)?>:</span>
				<input id="itm_ItemDiscountF" type="number"  value="-99999999.99"/>
				<span> <?php _e('עד', wizshop_pages)?> - </span>
				<input id="itm_ItemDiscountTo" type="number" min="0" value="99999999"/>
			</div>
			
			<div class="v_ihide">
				<span><?php _e('הנחה כללית', wizshop_pages)?>:</span>
				<input id="itm_GenDiscountF" type="number"  value="-99999999.99"/>
				<span> <?php _e('עד', wizshop_pages)?> - </span>
				<input id="itm_GenDiscountTo" type="number" min="0" value="99999999"/>
			</div>
			
			<div class="v_ihide">
				<span><?php _e('מחיר נטו ללא מעמ', wizshop_pages)?>:</span>
				<input id="itm_NetPriceF" type="number"  value="-99999999.99"/>
				<span><?php _e('עד', wizshop_pages)?>  - </span>
				<input id="itm_NetPriceTo" type="number" min="0" value="99999999"/>
			</div>
		

		</div>

		<div class="row mx-0">
			<div class="col-md-6 col-12 mb-2 mb-md-0">
				<span class="w-25"><?php _e('מפתח פריט', wizshop_pages)?>:</span>
				<input id="itm_ItemKey" type="text" class=" w-75 float-left" value="<?php echo esc_attr(wizshop_get_id_var())?>"/>
			</div>


			<div class="sortby col-md-4 col-9" >
				<span class="w-25"><?php _e('מיון לפי', wizshop_pages)?>:</span>
				<select data-wiz-sort-method class="p-2 w-75 float-left"> 
					<option data-wiz-no-item><?php _e('ברירת מחדל', wizshop_pages)?></option>
					<option data-wiz-sort-by>{{Name}}</option>
				</select>
			</div>
			<div class="buttons col-md-2 col-3">
				<a href="javascript:void(0);" data-wiz-issue-rep class="btn primary w-100" data-wiz-status="reports-item|status_14|14"><?php _e('הפקה', wizshop_pages)?></a>
			</div>
		</div>
	</div>

	<div data-wiz-output data-wiz-status="reports-item|status_14|14" data-wiz-date-format="dd-mm-yyyy" >
		<div data-wiz-rep-info class="mt-3 mb-1">
			{{Total}} <?php _e('תנועות נמצאו', wizshop_pages)?>   
			<div>{{ItemName}}</div>
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
						<th>{{h7}}</th>
						<th>{{h8}}</th>
						<th>{{h9}}</th>
						<th>{{h10}}</th>
					</tr>
				</thead>	
				<tbody data-wiz-rep-data class="ltr">
					<tr>
						<td>{{DocType}}</td>
						<td>{{Date}}</td>
						<td>{{DueDate}}</td>
						<td>{{Referance}}</td>
						<td>{{Ref2}}</td>
						<td>{{Quantity}}</td>
						<td>{{Price}}</td>
						<td>{{Amount}}</td>
						<td>{{ItemDiscount}}</td>
						<td>{{GenDiscount}}</td>
						<td>{{NetPrice}}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
</div>