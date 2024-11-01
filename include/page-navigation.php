<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
$view_op = wizshop_get_view_settings();
if($view_op['navigation'] & 1): 
$w_cur_url = esc_url(wizshop_current_page_url());
?>
<div data-wiz-page-navigation="<?php echo esc_attr(wizshop_get_id_var())?>" data-wizshop class=" mb-3 ">
	<input data-wiz-max-pages type="hidden" value="10">
    <div data-wiz-navigation-text> <?php _e('עמוד', wizshop_pages)?> {{PageNumber}} / {{TotalPages}} </div>
    <div data-wiz-page-numbering class="v_list">
        <!-- First page -->
		<a class="btn pagi-btn pagi-arrow-btn" data-wiz-first-page href='javascript:void(0);'>
           <img src="<?php echo wizshop_img_file_url('backward2.svg')?>" class="svg-icon">
        </a>
        <!-- Previous page -->
		<a class="btn pagi-btn pagi-arrow-btn" data-wiz-prev-page href='javascript:void(0);'>
              <img src="<?php echo wizshop_img_file_url('backward.svg')?>" class="svg-icon">
        </a>

        <!-- Page number -->
        <a class="btn pagi-btn" data-wiz-page-i wiz_selection  href='javascript:void(0);'>
            {{PageNumber}}
        </a>

        <!-- Next page -->
		<a class="btn pagi-btn pagi-arrow-btn" data-wiz-next-page href='javascript:void(0);'>
              <img src="<?php echo wizshop_img_file_url('forward.svg')?>" class="svg-icon">
        </a>
        <!-- Last page -->
		<a class="btn pagi-btn pagi-arrow-btn" data-wiz-last-page href='javascript:void(0);'>
            <img src="<?php echo wizshop_img_file_url('forward2.svg')?>" class="svg-icon">

        </a>
		<a class="btn pagi-btn" data-wiz-cur-page><span>{{PageNumber}}</span></a>
    </div>
</div>
<?php endif; ?>