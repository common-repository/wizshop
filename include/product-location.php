<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<span data-wiz-location data-wizshop itemscope itemtype="http://schema.org/BreadcrumbList" >
	<span data-wiz-home-loc wiz_selection class="v_ilast" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
		<a href="<?php echo esc_url(get_site_url())?>" class="v_ilast"  itemprop="item">
			<span itemprop="name"> <?php _e('ראשי', wizshop_pages)?></span>
			<meta itemprop="position" content="1" />
		</a>
	</span>
	<span data-wiz-cat-loc data-wiz-type="flat" data-wiz-level="1">
		<span data-wiz-cat-container>
			<span data-wiz-cat-item wiz_selection class="v_ilast" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
				<span class="seperator"> > </span>
				<a href="<?php echo wizshop_get_category_url()?>{{Link}}" itemprop="item">
				<span itemprop="name"> {{Category}} </span>
				<meta itemprop="position" content="{{Depth}}" />
				</a>
			</span>
		</span>
	</span>
</span>

			