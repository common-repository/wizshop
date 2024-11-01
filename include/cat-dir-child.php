<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<div data-wiz-categories-filter="<?php echo esc_attr(wizshop_cur_cat_key())?>" data-wiz-cat-depth="1" data-wizshop class="col-12">
	<div data-wiz-cat-container class="row sub-cats-grid">
		<p class="col-12"><?php _e('קטגוריות בקטגוריה זו', wizshop_pages)?>:</p>
		<div data-wiz-cat-item class="col-md-3 col-6 text-center">
            <script type="text/html">
			<a href='<?= esc_url(wizshop_get_category_url())?>{{Link}}' wiz_selection class="w-100">
                <img src="<?php esc_url(wizshop_image_link("wiz_cat"))?>" wiz_selection alt="{{Category}}" >
                <p class="text-center mt-2 cat-name">{{Category}}</p>
            </a>
			</script>
        </div>
    </div>
</div>