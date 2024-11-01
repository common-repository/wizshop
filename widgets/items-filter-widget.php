<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<div data-wiz-items-filter='<?php echo wizshop_widget_param("grid_id") ?>'
	data-wiz-max-notes='<?php echo wizshop_widget_param("max_notes") ?>'
	data-wiz-post-filter='<?php echo (("1" == wizshop_widget_param("post_filter")) ? "2" :"0")  ?>'
	data-wizshop
    class="widget-filter-block"
>
    <div data-wiz-note-filter class="widget-filter">
        <div data-wiz-no-item wiz_index="-1" class="v_iheader p-2 notname">
			<strong>{{NoteName}}</strong>
			<span class="sub-icon float-left">+</a>
		</div>
        <div data-wiz-value class="p-2 notevalue"> {{NoteValue}}</div>
    </div>
   <div class="border-none mt-3"><a href="javascript:void(0);" class="btn primary-outline v_ihide" data-wiz-clear-filter><?php _e('הסרת סינון', wizshop_pages)?></a></div>
</div>