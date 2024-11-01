<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
do_action('wiz_categories_init');
?>
<div>
	<h2 id="v_status100" class="v_ihide">חנות בשידור</h2>
	<div id="v_link100" class="v_ihide"><a href='{{Link}}'>חזרה</a></div>
</div>
<div data-wiz-categories-filter="NON" data-wiz-cat-depth="1" data-wizshop>
	<div data-wiz-cat-container class="row">
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