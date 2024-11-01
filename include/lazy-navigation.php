<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$view_op = wizshop_get_view_settings();
?>
<?php if($view_op['navigation'] & 2 || $view_op['navigation'] & 4) : ?>
<div data-wiz-page-navigation="<?php echo esc_attr(wizshop_get_id_var())?>" data-wizshop>
	<input data-wiz-max-pages type="hidden"  value='6'>
	<?php if($view_op['navigation'] & 4): ?>
		<span data-wiz-load-page data-wiz-lazy-load class="v_ihide"></span>
	<?php elseif($view_op['navigation'] & 2): ?>
		<div class="col-12 text-center">
			<a data-wiz-load-page href="javascript:void(0)" class="v_ihide btn primary"><?php _e('הציגו עוד', wizshop_pages)?></a>
		</div>
	<?php endif; ?>
	<div data-wiz-load-status  class="v_ihide "><?php _e('מוצרים בטעינה', wizshop_pages)?></div>
</div>
<?php endif; ?>
