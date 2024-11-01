<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
do_action('wiz_categories_init');
?>
<h3><?php _e('סינון קטגוריות', wizshop_pages)?></h3>
<div data-wiz-categories-filter="NON"  
	data-wiz-address='<?php echo esc_url(wizshop_get_category_url())?>{{Link}}'
	 data-wizshop >
<select data-wiz-cat-container>
	<option data-wiz-no-item><?php _e('בחירה', wizshop_pages)?></option>
	<option data-wiz-cat-item>
		<script type="text/html">
			<span>{{Category}}</span>
		</script>
	</option>
 </select>
<select data-wiz-note-filter>
	<option data-wiz-no-item>{{NoteName}}</option>
	<option data-wiz-value >
		<span>{{NoteValue}}</span>
	</option>
 </select>
<a href="javascript:void(0);" data-wiz-go><?php _e('סינון', wizshop_pages)?></a> 
<a href="javascript:void(0);" data-wiz-clear-filter><?php _e('הסרת סינון', wizshop_pages)?></a> 
</div>