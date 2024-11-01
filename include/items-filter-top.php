<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<!-- full filter - above items -->
<div data-wiz-items-filter='<?php echo wizshop_widget_param("grid_id") ?>'
	data-wiz-max-notes='<?php echo wizshop_widget_param("max_notes") ?>'
	data-wiz-post-filter='<?php echo (("1" == wizshop_widget_param("post_filter")) ? "2" :"0")  ?>'
	data-wizshop
    class="topfilter"
><h5 class="widget-title v_ihide" data-wiz-title><?php _e('סינון', wizshop_pages)?> </h5>
	<div class="row topfilter-container">
    <div data-wiz-note-filter class="col-md-3 col-xs-6">
        <div data-wiz-no-item wiz_index="-1" class="v_iheader p-2 topfilter-notname notname bb">
			{{NoteName}}
			<span class="sub-icon float-left">+</span>
		</div>
        <div data-wiz-value class="p-2 topfilter-value notevalue v_iclose"> {{NoteValue}}</div>
    </div>
    </div>
  
</div>