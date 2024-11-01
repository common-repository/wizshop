<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$wiz_view_type_op = wizshop_cat_view_options(false /*cats only*/, null, wizshop_grid_view());
?>
<div class="col-12">
    <!-- Category title -->
    <h1 data-wiz-title data-wizshop>{{Title}}</h1>
</div>
<?php
	if(1 == wizshop_get_view_settings()['top_filter']){
		wizshop_get_template_part('items-filter-top');
	}else{
		wizshop_get_template_part('items-filter');	
	}
?>
<div class="col-12 cat-desc-sc">
	<?php echo do_shortcode(wizshop_cat_description());?>
</div>
<!-- Type of view -->
<nav  class="view-typebar p-2 my-2 w-100">
    <div class="justify-content-between px-3 row speedbar-btns">
        <div id="breadcrumbs" class="pt-2">
            <?php wizshop_get_template_part('product-location');?>
        </div>

        <!-- View type -->
        <div >
			<div class="speedbar-block mr-1 mt-2 mt-sm-0" data-but-container>
				<!-- Title -->
				<span class="px-2 pt-1"><?php _e('צורת תצוגה', wizshop_pages)?></span>
				<?php if(1 == $wiz_view_type_op['grid']): ?>
				<button data-view-btn="grid" class="btn   view-typebar-btn" title="<?php esc_attr_e('גלריה', wizshop_pages)?>">
					<img data-view-btn="grid" src="<?php echo wizshop_img_file_url('grid.svg')?>" class="svg-icon">
				</button>
				<?php endif; ?>
				<?php if(1 == $wiz_view_type_op['table']): ?>
				<button data-view-btn="table" class="btn  view-typebar-btn" title="<?php esc_attr_e('טבלה', wizshop_pages)?>">
					<img data-view-btn="table" src="<?php echo wizshop_img_file_url('table.svg')?>" class="svg-icon">
				</button>
				<?php endif; ?>
				<?php if(1 == $wiz_view_type_op['lines']): ?>
				<button data-view-btn="lines" class="btn view-typebar-btn" title="<?php esc_attr_e('שורות', wizshop_pages)?>">
					<img data-view-btn="lines" src="<?php echo wizshop_img_file_url('lines.svg')?>" class="svg-icon">
				</button>
				<?php endif; ?>
			</div>
			 <!-- Sort items -->
			<div class="dsp-inlineblock">
				<?php wizshop_get_template_part('page-sort');?>
			</div>
			</div>
    </div>
	
    <div class="clr"></div>
    <hr class="my-2">
    <!-- Pagination -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-12 mb-sm-2 text-right pagenav-top">
		        <?php wizshop_get_template_part('page-navigation');?>
            </div>
            <div class="col-md-6 col-12 text-left">
	            <?php wizshop_get_template_part('page-items');?>
            </div>
        </div>
    </div>
</nav>
<?php wizshop_get_template_part('cat-dir-child');?>
<!-- view's data stored here (using ajax or scripts (data-grid-scripts below) -->	
<div data-grid-view="products-view" data-grid-lang="<?php echo esc_attr(wizshop_cur_lang());?>">
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
<div class="text-center pagenav-bottom">
<?php wizshop_get_template_part('page-navigation');?>
</div>
<!-- inifine scrolling or loading button -->
<?php wizshop_get_template_part('lazy-navigation');?>


<!--------------- Quick View -------------->	
<?php wizshop_get_template_part('quick-view');?>