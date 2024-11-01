<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$wiz_view_type_op = wizshop_cat_view_options(true /*default tax->lang view*/, null, wizshop_search_view_cookie_val());
?>
<h4><?php _e('תוצאות חיפוש', wizshop_pages)?></h4>
<div class="align-items-center mx-0 no-gutters row">
<div class="dsp-inlineblock col-6">
<?php wizshop_get_template_part('search-location');?>
</div>
<div class="col-6 text-left">
<!-- View type -->
<div data-but-container class="speedbar-block mr-1 mt-2 mt-sm-0">
	<!-- Title -->
	<span class="px-2 pt-1"><?php _e('צורת תצוגה', wizshop_pages)?></span>
	<?php if(1 == $wiz_view_type_op['grid']): ?>
	<button data-view-btn="grid" class="btn primary view-typebar-btn" title="<?php esc_attr_e('גלריה', wizshop_pages)?>">
		<img data-view-btn="grid" src="<?php echo wizshop_img_file_url('grid.svg')?>" class="svg-icon">
	</button>
	<?php endif; ?>
	<?php if(1 == $wiz_view_type_op['table']): ?>
	<button data-view-btn="table" class="btn primary view-typebar-btn" title="<?php esc_attr_e('טבלה', wizshop_pages)?>">
		<img data-view-btn="table" src="<?php echo wizshop_img_file_url('table.svg')?>" class="svg-icon">
	</button>
	<?php endif; ?>
	<?php if(1 == $wiz_view_type_op['lines']): ?>
	<button data-view-btn="lines" class="btn primary view-typebar-btn" title="<?php esc_attr_e('שורות', wizshop_pages)?>">
		<img data-view-btn="lines" src="<?php echo wizshop_img_file_url('lines.svg')?>" class="svg-icon">
	</button>
	<?php endif; ?>
</div>
<!-- Sort items -->

	<?php wizshop_get_template_part('page-sort');?>

</div>
</div>
 <div class="clr"></div>
 <hr class="my-2">
<!-- view's data stored here (using ajax or scripts (data-grid-scripts below) -->	
<div data-grid-view="products-view" data-grid-lang="<?php echo esc_attr(wizshop_cur_lang());?>" class="mt-3">
<?php
	if("grid" == $wiz_view_type_op['default']){
		wizshop_get_template_part('products-grid');
	}else if("table" == $wiz_view_type_op['default']){
		wizshop_get_template_part('products-table');
	}else if("lines" == $wiz_view_type_op['default']){
		wizshop_get_template_part('products-lines');
	}
?>	
</div>

<!-- keep views in page (no ajax calls) -->	
<div data-grid-scripts>
	<?php if(1 == $wiz_view_type_op['grid']) : ?>
		 <script type="text/html" id="wiz_script-grid"> 
		<?php echo rawurlencode(wizshop_template_part_string('products-grid'));?>
		</script>
	<?php endif; ?>				
	<?php if(1 == $wiz_view_type_op['table']) : ?>
		<script type="text/html" id="wiz_script-table" > 
		<?php echo rawurlencode(wizshop_template_part_string('products-table'));?>
		</script>
	<?php endif; ?>			
	<?php if(1 == $wiz_view_type_op['lines']) : ?>
		<script type="text/html" id="wiz_script-lines"> 
		<?php echo rawurlencode(wizshop_template_part_string('products-lines'));?>
		</script>
	<?php endif; ?>
</div>

<!--------------- navigation (optional)-------------->	
<!--  pagination -->	
<?php wizshop_get_template_part('page-navigation');?>
<!-- inifine scrolling or loading button -->	
<?php wizshop_get_template_part('lazy-navigation');?>


<!--------------- Quick View -------------->	
<?php wizshop_get_template_part('quick-view');?>