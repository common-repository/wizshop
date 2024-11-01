<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$w_cur_url = esc_url(wizshop_current_page_url());
?>
<div data-wiz-page-items="<?php echo esc_attr(wizshop_get_id_var())?>" data-wizshop class="m-0">
    <span><?php _e('הצג', wizshop_pages)?>:</span>
	<span data-wiz-container>
		<a data-wiz-show-items='0' class="btn px-1" wiz_selection  href='javascript:void(0);'><?php _e('הכל', wizshop_pages)?></a>
		<a data-wiz-show-items='2' class="btn px-1" wiz_selection  href='javascript:void(0);'>2</a>
		<a data-wiz-show-items='5' class="btn px-1" wiz_selection  href='javascript:void(0);'>5</a>
		<a data-wiz-show-items='10' class="btn px-1" wiz_selection  href='javascript:void(0);'>10</a>
		<a data-wiz-show-items='50' class="btn px-1" wiz_selection  href='javascript:void(0);'>50</a>
		<span data-wiz-cur-page class="btn py-0 px-1 show-cur-page">{{PageNumber}}</span>
	</span>
    <span><?php _e('מוצרים בעמוד', wizshop_pages)?></span>
    <span data-wiz-page-text class="dsp-inlineblock">
        (<?php _e('מתוך', wizshop_pages)?>: {{Total}})
	</span>
</div>