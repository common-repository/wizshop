<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<!-- Filter selection restuls only -->
<div data-wiz-items-filter  data-wizshop class="column-6">
	<div data-wiz-note-filter class="top-filters dsp-inlineblock">
	     <div data-wiz-no-item wiz_index="-1" class="v_ihide v_iheader" >{{NoteName}}</div>
		<div data-wiz-value class="notevalue-top dsp-inlineblock ml-2 p-1 px-2">
		<span>x</span>	{{NoteValue}}		</div>
     </div>
<a href="javascript:void(0);" class="btn primary-outline v_ihide" data-wiz-clear-filter><?php _e('הסרת סינון', wizshop_pages)?></a>
</div>
