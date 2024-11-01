<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<div data-wiz-location="<?php echo esc_attr(wizshop_get_id_var())?>"  data-wizshop>
    <div data-wiz-search-loc class="v_cart">
        <div wiz_enabled = 'yes'><?php _e('נמצאו', wizshop_pages)?> {{Results}} <?php _e('מוצרים', wizshop_pages)?> </div>
    </div>  
	<div class="empty-basket">
		<?php _e('לא נמצאו מוצרים תואמים לחיפוש', wizshop_pages)?>
	</div>
</div>