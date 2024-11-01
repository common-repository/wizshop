<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<div class="speedbar-block mt-2 mt-sm-0" data-wiz-page-sort data-wizshop>
    <div class="dsp-inlineblock">
        <select data-wiz-sort-ex-method class=" p-1 border-none">
            <option  data-wiz-sort-by="-1"><?php _e('שם', wizshop_pages)?></option>
            <option  data-wiz-sort-by="-2"><?php _e('מחיר', wizshop_pages)?></option>
			<option data-wiz-sort-by>{{Name}}</option>
        </select>
	</div>
 	<div data-wiz-sort-dir class="dsp-inlineblock">
		<button data-wiz-sort-order='asc' class="v_iselect btn  primary-icon view-typebar-btn" wiz_selection href='javascript:void(0);'>
            <img src="<?php echo wizshop_img_file_url('sort-up.svg')?>" class="svg-icon">
        </button>
		<button data-wiz-sort-order='desc' wiz_selection href='javascript:void(0);' class="btn  primary-icon view-typebar-btn">
           <img src="<?php echo wizshop_img_file_url('sort-down.svg')?>" class="svg-icon">
        </button>
	</div>
</div>