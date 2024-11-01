<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
do_action('wiz_categories_init');
?>
<div data-wiz-categories  data-wiz-cat-depth="-1"  data-wizshop class="sidebar-cats with-sub" >
    <ul data-wiz-cat-container class="widget-catitems m-0">
        <li data-wiz-cat-item wiz_selection  class="v_ilast cat-item">
            <script type="text/html">
			<a href="<?= wizshop_get_category_url()?>{{Link}}" wiz_selection key="{{Key}}" class="p-2 dsp-block">
				<?php if(wizshop_widget_param('show_image')){ ?>
					<img src="<?php esc_url(wizshop_image_link("wiz_thumb"))?>" wiz_selection>
				<?php } ?>
                <strong>{{Category}}</strong>
				<span class="sub-icon float-left">+</a>
            </a>
			</script>
        </li>
    </ul>
    <input data-wiz-full-path-select type="hidden" value="1">
</div>