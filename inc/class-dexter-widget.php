<?php
/**
 * The widget class
 */

class Dexter_widget extends WP_Widget{
	
	function __construct() {
		parent::__construct(
			'dexter_widget',
			esc_html( 'Dexter' ),
			array(
				'description'                 => 'Display Pokemon data on your site! ',
				'customize_selective_refresh' => true,
			)
		);
	}
	public static function register() {
		register_widget( get_class() );
	}
	
	public function form( $instance ) {

		// Set widget defaults
		$defaults = array(
			'title'                => '',
			'show_number_checkbox' => '',
			'show_type_checkbox'   => '',
			'show_weight_checkbox' => '',
			'show_height_checkbox' => '',
		);
		// Parse current settings with defaults
		extract( wp_parse_args( ( array ) $instance, $defaults ) ); ?>
	<?php // Widget Title ?>
	<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title: ', 'text_domain' ); ?></label>
		<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
	</p>
	<?php // show_number_checkbox ?>
	<p>
		<input id="<?php echo esc_attr( $this->get_field_id( 'show_number_checkbox' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_number_checkbox' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $show_number_checkbox ); ?> />
		<label for="<?php echo esc_attr( $this->get_field_id( 'show_number_checkbox' ) ); ?>"><?php echo esc_html( 'Show Pokemon number?' ); ?></label>
	</p>
	<?php // show_type_checkbox ?>
	<p>
		<input id="<?php echo esc_attr( $this->get_field_id( 'show_type_checkbox' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_type_checkbox' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $show_type_checkbox ); ?> />
		<label for="<?php echo esc_attr( $this->get_field_id( 'show_type_checkbox' ) ); ?>"><?php echo esc_html( 'Show type?' ); ?></label>
	</p>
	<?php //show_weight_checkbox ?>
	<p>
		<input id="<?php echo esc_attr( $this->get_field_id( 'show_weight_checkbox' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_weight_checkbox' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $show_weight_checkbox ); ?> />
		<label for="<?php echo esc_attr( $this->get_field_id( 'show_weight_checkbox' ) ); ?>"><?php echo esc_html( 'Show weight?' ); ?></label>
	</p>
	<?php //show_height_checkbox ?>
	<p>
		<input id="<?php echo esc_attr( $this->get_field_id( 'show_height_checkbox' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'show_height_checkbox' ) ); ?>" type="checkbox" value="1" <?php checked( '1', $show_height_checkbox ); ?> />
		<label for="<?php echo esc_attr( $this->get_field_id( 'show_height_checkbox' ) ); ?>"><?php echo esc_html( 'Show height?' ); ?></label>
	</p>
	<?php
	}
	
	public function update( $new_instance, $old_instance ) {
		$instance                         = $old_instance;
		$instance['title']                = isset( $new_instance['title'] ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		$instance['show_number_checkbox'] = isset( $new_instance['show_number_checkbox'] ) ? 1 : false;
		$instance['show_type_checkbox']   = isset( $new_instance['show_type_checkbox'] ) ? 1 : false;
		$instance['show_weight_checkbox'] = isset( $new_instance['show_weight_checkbox'] ) ? 1 : false;
		$instance['show_height_checkbox'] = isset( $new_instance['show_height_checkbox'] ) ? 1 : false;
		return $instance;
	}
	// Display the widget
	public function widget( $args, $instance ) {
		extract( $args );
		// Check the widget options
		$title                = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
		$show_number_checkbox = ! empty( $instance['show_number_checkbox'] ) ? $instance['show_number_checkbox'] : false;
		$show_type_checkbox   = ! empty( $instance['show_type_checkbox'] ) ? $instance['show_type_checkbox'] : false;
		$show_weight_checkbox = ! empty( $instance['show_weight_checkbox'] ) ? $instance['show_weight_checkbox'] : false;
		$show_height_checkbox = ! empty( $instance['show_height_checkbox'] ) ? $instance['show_height_checkbox'] : false;

		// WordPress core before_widget hook
		echo $before_widget;

		echo '<div class="widget-text wp_widget_plugin_box">';
		// Display widget title if defined
		if ( $title ) {
			echo $before_title . $title . $after_title;
		}
		echo '</div>';
		//Display meta_box
		Pokemon_Metabox::display_meta_box();
		// Display something if show_number_checkbox is true
		if ( $show_number_checkbox ) {
			Pokemon_Metabox::show_number();
		}
		// Display something if show_type_checkbox is true
		if ( $show_type_checkbox ) {
			Pokemon_Metabox::show_type();
		}
		// Display something if show_weight_checkbox is true
		if ( $show_weight_checkbox ) {
			Pokemon_Metabox::show_weight();
		}
		// Display something if show_height_checkbox is true
		if ( $show_height_checkbox ) {
			Pokemon_Metabox::show_height();
		}
		Pokemon_Metabox::metabox_footer();
		// WordPress core after_widget hook
		echo $after_widget;
	}
	
}
