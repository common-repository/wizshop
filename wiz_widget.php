<?php   
abstract class WizShop_Widget extends WP_Widget {

    function __construct() {
		if(!isset($this->wiz_data))
			return;
		$this->wiz_data = (object)($this->wiz_data);
		parent::__construct(
			$this->wiz_data->id, 
			$this->wiz_data->name ,
			$this->wiz_data->widget_options 
		);
	}
	
	public function widget( $args, $instance ) {
		if(!isset($this->wiz_data))
			return;
		
		$hide_if_mobile = false;
		$hide_on_page = false;
		$hide_if_sign_in = false;
		
		$disp = apply_filters('wizshop_widget_disp', $this->wiz_data->id);
		if(0 == $disp){
			return;
		}
		
		if(is_page() && isset($this->wiz_data->hide_on_page) && is_array($this->wiz_data->hide_on_page)){
			$post = get_post();
			foreach ($this->wiz_data->hide_on_page as $page) {
				if($post->ID == WizShop_Pages::get_page_id($page)){
					$hide_on_page = true;
					break;
				}
			}
		}
	
		if(array_key_exists('hide_if_mobile',$instance)){
			$hide_if_mobile = !empty( $instance['hide_if_mobile']) 
										&& wp_is_mobile();
		}
		if(array_key_exists('hide_if_sign_in',$instance)){
			$hide_if_sign_in = !empty( $instance['hide_if_sign_in']) 
										&& wizshop_is_reg_customer();
		}
		
		if($hide_if_mobile || $hide_on_page || $hide_if_sign_in) return;
		
		extract($args);
		
		echo $before_widget;
		
		$title = apply_filters('widget_title', empty( $instance['title'] ) ? '' : 
			$instance['title'], $instance, $this->id_base );
		if ( $title )
			echo $before_title . $this->get_title($title) . $after_title;
		$_POST['wiz_instance'] = $instance;
		wizshop_get_widget_part($this->wiz_data->template);

		echo $after_widget;
	}

	public function form( $instance ) {
		if(!isset($this->wiz_data))
			return;
		foreach($this->wiz_data->settings as $key => $setting ) {
			if(!isset($setting['type'])) continue;
			$value = isset($instance[$key]) ? $instance[$key] : $setting['val'];
			switch($setting['type']){
				case "text" :
					?>
					<p>
						<label for="<?php echo esc_attr($this->get_field_id($key)); ?>"><?php echo esc_html($setting['label']); ?></label>
						<input class="widefat" 
							id="<?php echo esc_attr( $this->get_field_id($key)); ?>" 
							name="<?php echo esc_attr($this->get_field_name($key)); ?>" 
							type="text" value="<?php echo esc_attr($value); ?>" 
							<?php echo isset($setting['attr']) ? esc_attr($setting['attr']) : "";?>
						/>
					</p>
					<?php
				break;
				case "number" :
					?>
					<p>
						<label for="<?php echo esc_attr($this->get_field_id($key)); ?>"><?php echo esc_html($setting['label']); ?></label>
						<input class="widefat" 
							id="<?php echo esc_attr($this->get_field_id($key)); ?>" 
							name="<?php echo esc_attr($this->get_field_name($key)); ?>" 
							type="number" step="<?php echo isset($setting['step'])? esc_attr($setting['step']) : 1; ?>" 
							min="<?php echo isset($setting['min'])? esc_attr( $setting['min']): 0 ; ?>" 
							max="<?php echo isset($setting['max'])? esc_attr($setting['max']):999; ?>" 
							size="<?php echo isset($setting['size'])? esc_attr($setting['size']):3; ?>" 
							value="<?php echo esc_attr($value); ?>" 
							<?php echo isset($setting['attr']) ? esc_attr($setting['attr']) : "";?>
						/>
					</p>
					<?php
				break;
				case "select" :
					?>
					<p>
						<label for="<?php echo esc_attr($this->get_field_id($key)); ?>"><?php echo esc_html($setting['label']); ?></label>
						<select class="widefat" 
							id="<?php echo esc_attr( $this->get_field_id($key)); ?>" 
							name="<?php echo esc_attr($this->get_field_name($key)); ?>"
							<?php echo isset($setting['attr']) ? esc_attr($setting['attr']) : "";?> 
								>
							<?php foreach ( $setting['options'] as $option_key => $option_value) : ?>
								<option value="<?php echo esc_attr( $option_key ); ?>" <?php selected( $option_key, $value ); ?>><?php echo esc_html($option_value); ?></option>
							<?php endforeach; ?>
						</select>
					</p>
					<?php
				break;
				case "checkbox" :
					?>
					<p>
						<input class="widefat" 
							id="<?php echo esc_attr($this->get_field_id($key)); ?>" 
							name="<?php echo esc_attr( $this->get_field_name( $key ) ); ?>" 
							type="checkbox" value="1" <?php checked( $value, 1 );  
							echo isset($setting['attr']) ? esc_attr($setting['attr']) : "";?> 
						/>
						<label for="<?php echo esc_attr($this->get_field_id($key)); ?>"><?php echo esc_html($setting['label']); ?></label>
					</p>
					<?php
				break;
			}
		}
	}

	public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
		if(!isset($this->wiz_data))
			return $instance;
		foreach($this->wiz_data->settings as $key => $setting ) {
			if(isset($new_instance[$key])) {
				$instance[$key] = sanitize_text_field($new_instance[$key]);
			} elseif('checkbox' === $setting['type']){
				$instance[$key] = 0;
			}
		}
		return $instance;
    }

	protected function get_title($title){
		return $title;
	}
	
} 
?>