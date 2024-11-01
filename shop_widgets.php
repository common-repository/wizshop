<?php   
//---------------------------------------------------------------------------
class WizShop_Cart_Widget extends WizShop_Widget {
	public function __construct() {
		$this->wiz_data = array(
				'id' => 'wizshop-cart',
				'name' =>  __('WizShop - Shopping cart',WizShop),
				'template' => 'cart-widget',
				'hide_on_page' => array('my-cart'),
				'widget_options' => array('cssclass' => '', 'description' =>  
						__('Shopping Cart component',WizShop)),
				'settings' => array(
						'title'  => array(
							'type'  => 'text',
							'val'   => __('Shopping cart',WizShop),
							'label' => __('Title',WizShop),
						),
						'hide_if_mobile'  => array(
							'type'  => 'checkbox',
							'val'   => 0,
							'label' => __('Hide on mobile devices',WizShop),
						),
				),
			); 
		parent::__construct();
	}
}
//---------------------------------------------------------------------------
class WizShop_CatTree_Widget extends WizShop_Widget {
	public function __construct() {
		$this->wiz_data = array(
			'id' => 'wizshop-cat-tree',
			'name' =>  __('WizShop - Categories Tree',WizShop),
			'template' => 'cat-tree-widget',
			'hide_on_page' => array(),
			'widget_options' => array('cssclass' => '', 'description' =>  
					__('Categories Tree component',WizShop)),
			'settings' => array(
					'title'  => array(
						'type'  => 'text',
						'val'   => __('Categories tree',WizShop),
						'label' => __('Title',WizShop),
					),
					'show_image'  => array(
						'type'  => 'checkbox',
						'val'   => 0,
						'label' => __('Show category image',WizShop),
					),
					'hide_if_mobile'  => array(
						'type'  => 'checkbox',
						'val'   => 0,
						'label' => __('Hide on mobile devices',WizShop),
					),
			),
		);
		parent::__construct();
	}
}
//---------------------------------------------------------------------------
class WizShop_ProductSearch_Widget extends WizShop_Widget {
	public function __construct() {
		$this->wiz_data = array(
			'id' => 'wizshop-product-search',
			'name' =>  __('WizShop - Product Search',WizShop),
			'template' => 'product-search-widget',
			'hide_on_page' => array(),
			'widget_options' => array('cssclass' => '', 'description' =>  
					__('Product Search component',WizShop)),
			'settings' => array(
					'title'  => array(
						'type'  => 'text',
						'val'   => __('Search',WizShop),
						'label' => __('Title',WizShop),
					),
					'placeholder'  => array(
						'type'  => 'text',
						'val'   => "",
						'label' => "Placeholder",
					),
					'show_suggestions'  => !wizshop_is_wizsearch() ? array(
						'type'  => 'checkbox',
						'val'   => 0,
						'label' => __('Show suggestions list',WizShop) 
					) : array(),
					'show_image'  => array(
						'type'  => 'checkbox',
						'val'   => 0,
						'label' => __('Show product image',WizShop),
					),
					'hide_if_mobile'  => array(
						'type'  => 'checkbox',
						'val'   => 0,
						'label' => __('Hide on mobile devices',WizShop),
					),
			),
		);
		parent::__construct();
	}
}
//---------------------------------------------------------------------------
class WizShop_SignIn_Widget extends WizShop_Widget {
	public function __construct() {
		$this->wiz_data = array(
			'id' => 'wizshop-sign-in',
			'name' =>  __('WizShop - Sign In Private Customer',WizShop),
			'template' => 'sign-in-widget',
			'hide_on_page' => array('sign-in'),
			'widget_options' => array('cssclass' => '', 'description' =>  
					__('Sign In Private Customer omponent',WizShop)),
			'settings' => array(
					'title'  => array(
						'type'  => 'text',
						'val'   => __('Sign In Private Customer',WizShop),
						'label' => __('Title',WizShop),
					),
					'hide_if_sign_in'  => array(
						'type'  => 'checkbox',
						'val'   => 0,
						'label' => __('Hide when customer has already logged in',WizShop),
					),
					'hide_if_mobile'  => array(
						'type'  => 'checkbox',
						'val'   => 0,
						'label' => __('Hide on mobile devices',WizShop),
					),
			),
		);
		parent::__construct();
	}
	
	protected function get_title($title){
		return wizshop_is_b2b_customer() ? "" : $title ;
	}

}
//---------------------------------------------------------------------------
class WizShop_SignInB2b_Widget extends WizShop_Widget {
	public function __construct() {
		$this->wiz_data = array(
			'id' => 'wizshop-sign-in-b2b',
			'name' =>  __('WizShop - Sign In Business Customer',WizShop),
			'template' => 'sign-in-b2b-widget',
			'hide_on_page' => array('sign-in-b2b'),
			'widget_options' => array('cssclass' => '', 'description' =>  
					__('Sign In Business Customer component',WizShop)),
			'settings' => array(
					'title'  => array(
						'type'  => 'text',
						'val'   => __('Sign In Business Customer',WizShop),
						'label' => __('Title',WizShop),
					),
					'hide_if_sign_in'  => array(
						'type'  => 'checkbox',
						'val'   => 0,
						'label' => __('Hide when customer has already logged in',WizShop),
					),
					'hide_if_mobile'  => array(
						'type'  => 'checkbox',
						'val'   => 0,
						'label' => __('Hide on mobile devices',WizShop),
					),
			),
		);
		parent::__construct();
	}
	
	protected function get_title($title){
		return wizshop_is_b2c_customer() ? "" : $title ;
	}
}
//---------------------------------------------------------------------------
class WizShop_ItemsFilter_Widget extends WizShop_Widget {
	public function __construct() {
		$this->wiz_data = array(
			'id' => 'wizshop-items-filter',
			'name' =>  __('WizShop - Products Filter',WizShop),
			'template' => 'items-filter-widget',
			'hide_on_page' => array(),
			'widget_options' => array('cssclass' => '', 'description' =>  
					__('Products Filter component',WizShop)),
			'settings' => array(
					'title'  => array(
						'type'  => 'text',
						'val'   => __('Products Filter',WizShop),
						'label' => __('Title',WizShop),
					),
					'grid_id'  => array(
						'type'  => 'text',
						'val'   => '',
						'label' => __('Filter products for Grid with ID',WizShop),
					),
					'max_notes'  => array(
						'type'  => 'number',
						'val'   => 0,
						'min'	=> 0,
						'max'	=> 10,
						'step'  => 1,
						'size' 	=> 3,
						'label' => __('Max number of properties (0 = unlimited)',WizShop),
					),
					'post_filter'  => array(
						'type'  => 'checkbox',
						'val'   => 0,
						'label' => __('Show properties with no values',WizShop),
					),
					'hide_if_mobile'  => array(
						'type'  => 'checkbox',
						'val'   => 0,
						'label' => __('Hide on mobile devices',WizShop),
					),
			),
		);
		parent::__construct();
	}
	
	protected function get_title($title){
		return "<div data-wizshop data-wiz-items-filter><div data-wiz-title>".$title."</div></div>";
	}
}
//---------------------------------------------------------------------------
class WizShop_ProductsList_Widget extends WizShop_Widget {
	public function __construct() {
		$views = array();
		global $wizshop_cat_view;
		foreach ($wizshop_cat_view as $key => $prop){
			$views[$key] = $prop['label'];
		}		
		
		$this->wiz_data = array(
			'id' => 'wizshop-products-list',
			'name' =>  __('WizShop - Products List',WizShop),
			'template' => 'products-list-widget',
			'hide_on_page' => array(),
			'widget_options' => array('cssclass' => '', 'description' =>  
					__('Products List for Category/Query component',WizShop)),
			'settings' => array(
					'title'  => array(
						'type'  => 'text',
						'val'   =>'',
						'label' => __('Title',WizShop),
					),
					'filter_type'  => array(
						'type'  => 'select',
						'val'   => 0,
						'label' => __('List product by:',WizShop),
						'options' => array( '#c' => __('Category key',WizShop), 
											'#q' => __('Search query',WizShop)),
					),
					'text'  => array(
						'type'  => 'text',
						'val'   => '',
						'label' => __('Category key / Search query',WizShop),
					),
					'view_type'  => array(
						'type'  => 'select',
						'val'   => 0,
						'label' => __('Products display',WizShop),
						'options' => $views,
					),
					'count'  => array(
						'type'  => 'number',
						'val'   => 0,
						'label' => __('Max number of products (0 = use default)',WizShop),
					),					
					'hide_if_mobile'  => array(
						'type'  => 'checkbox',
						'val'   => 0,
						'label' => __('Hide on mobile devices',WizShop),
					),
			),
		);
		parent::__construct();
	}
}
//---------------------------------------------------------------------------
class WizShop_Newsletters_Widget extends WizShop_Widget {
	public function __construct() {
		$this->wiz_data = array(
			'id' => 'wizshop-newsletters',
			'name' =>  __('WizShop - Newsletters',WizShop),
			'template' => 'newsletters-widget',
			'hide_on_page' => array(),
			'widget_options' => array('cssclass' => '', 'description' =>  
					__('Newsletters registration component',WizShop)),
			'settings' => array(
					'title'  => array(
						'type'  => 'text',
						'val'   =>'',
						'label' => __('Title',WizShop),
					),
					'hide_if_mobile'  => array(
						'type'  => 'checkbox',
						'val'   => 0,
						'label' => __('Hide on mobile devices',WizShop),
					),
			),
		);
		parent::__construct();
	}
}
//---------------------------------------------------------------------------
function register_wiz_widgets() {

	register_widget('WizShop_Cart_Widget');
	register_widget('WizShop_CatTree_Widget');
	register_widget('WizShop_ProductSearch_Widget');
	register_widget('WizShop_SignIn_Widget');
	register_widget('WizShop_SignInB2b_Widget');
	register_widget('WizShop_ItemsFilter_Widget');
	register_widget('WizShop_ProductsList_Widget');
	register_widget('WizShop_Newsletters_Widget');

}
//---------------------------------------------------------------------------
add_action( 'widgets_init', 'register_wiz_widgets' );

//---------------------------------------------------------------------------
add_filter('wizshop_widget_disp',  function( $id) {
	$ret = 1;
	if( ('wizshop-sign-in-b2b' == $id && wizshop_is_b2c_customer()) ||
			('wizshop-sign-in' == $id && wizshop_is_b2b_customer()) ){
		$ret = 0;
	}
	return $ret;
});

//---------------------------------------------------------------------------
?>