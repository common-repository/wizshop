<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$dispB2B = wizshop_b2b_customer_details(); 
$co = wizshop_get_customer_options();  
?>
<li class="menu-item menu-item-has-children" data-wiz-customer data-wizshop>
<a  class="elementor-item has-submenu">
<span wiz_logout> <?php _e('כניסת לקוחות', wizshop_pages)?> </span>
<span wiz_login> <?php _e('איזור אישי', wizshop_pages)?> </span> 
</a>

<ul class="shopping-cart sub-menu elementor-nav-menu--dropdown"  >
	<li class="menu-item b2c-button" wiz_logout>
		<a href="<?php echo esc_url(wizshop_get_signin_url())?>" class="elementor-sub-item "><?php echo $co["b2c_link_text"]; ?></a>
	</li>
	<li class="menu-item b2b-button" wiz_logout>
		<a href="<?php echo esc_url(wizshop_get_signin_b2b_url())?>" class="elementor-sub-item "><?php echo $co["b2b_link_text"]; ?></a>
	</li>
	<li class="menu-item agents-button" wiz_logout>
		<a href="<?php echo esc_url(wizshop_get_agents_url())?>" class="elementor-sub-item "><?php echo $co["agents_link_text"]; ?></a>
	</li>
	<li class="menu-item b2c-button signup-button" wiz_logout>
		<a href="<?php echo esc_url(wizshop_get_user_details_url())?>" class="elementor-sub-item "> <?php _e('הרשמה', wizshop_pages)?></a>
	</li>
	<li class="menu-item" wiz_login >
		<a  data-wiz-text class="elementor-sub-item"> <?php _e('שלום', wizshop_pages)?> {{Name}}</a>
	</li>
	<li class="menu-item"  wiz_login>
	<a href="<?php echo esc_url(wizshop_get_personal_area_url())?>" class="elementor-sub-item"> <?php _e('איזור אישי', wizshop_pages)?> </a>
	</li>
	<li class="menu-item" wiz_login>
		<a href="javascript:void(0);"    data-wiz-logout class="elementor-sub-item"><?php _e('התנתקות', wizshop_pages)?></a>
	</li>
</ul>

</li>


	