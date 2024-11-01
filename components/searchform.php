<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
?>
<li data-wiz-search data-wizshop class="menu-item searchform">
	<a class="elementor-item">
		<span class="search-cont">
			<input type="text" size="20" data-wiz-text
				data-wzsrch
				data-wz-rec-template="recTemplateItm" 
				data-rec-suggest="yes" 
				data-wz-rec-target="recResults"
				data-wz-pre-process ="vshop_pre_render_search_item" 
				/>
			<img src="<?php echo wizshop_img_file_url('search.svg')?>" data-wiz-go data-wiz-address='<?php echo esc_url(wizshop_get_products_url())?>?s=' class="svg-icon search-icon">
		</span>
	</a>
	
	<div data-wiz-auto-complete class="auto-c">
		<input data-wiz-auto-hide type="hidden" value="0">
		<div data-wiz-suggestion>
			<script type="text/html">
				<a href='<?php echo esc_url(wizshop_get_products_url())?>{{Link}}' wiz_selection wiz_index='{{index}}' class="px-3 py-2 row bb mx-0">
			
					<div class="col-md-4 px-1">
						<img src ="<?php esc_url(wizshop_image_name_link("{{ImageFile}}","wiz_thumb"))?>" wiz_selection wiz_index='{{index}}' alt="{{Name}}" >
					</div>
					<span wiz_selection wiz_index='{{index}}' class="col-md-8 px-1">{{NameDisp}}</span>
				</a>
			</script>
		</div>
	</div>
	
	<div data-wiz-search-info>
		<div id="recResults" class="v_ihide"></div>
			<script id="recTemplateItm" type="x-tmpl-mustache">  		  
			   <a href='<?php echo esc_url(wizshop_get_products_url())?>{{record.Link}}' class="px-3 py-2 row bb mx-0">
					 <div class="col-md-4 px-1">
						<img src ="<?php esc_url(wizshop_image_name_link("{{record.ImageFile}}","wiz_thumb"))?>" >
					 </div>
					<span class="col-md-8 px-1">{{record.Name}}</span>
				
			  </a>
			</script>
	</div>	
</li>