<?php
/**
 * The widget class
 */

namespace WpDexter;

/**
 * Class Widget
 *
 * @package WpDexter
 */
class Widget extends \WP_Widget {

	/**
	 * WP-Dexter ID Base.
	 *
	 * @var string
	 */
	const ID_BASE = 'dexter_widget';

	/**
	 * Widget constructor. Instantiates the class.
	 */
	function __construct() {
		parent::__construct(
			self::ID_BASE,
			__( 'Dexter', 'wp-dexter' ),
			array(
				'description'                 => __( 'Display Pokemon data on your site!', 'wp-dexter' ),
				'customize_selective_refresh' => true,
			)
		);
	}

	/**
	 * Output Widget Form.
	 *
	 * @param array $instance
	 * @return void
	 */
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
		<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php echo esc_html( 'Title: ' ); ?></label>
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

	/**
	 * Updates the widget instance.
	 *
	 * @param array $new_instance
	 * @param array $old_instance
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                         = $old_instance;
		$instance['title']                = isset( $new_instance['title'] ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
		$instance['show_number_checkbox'] = isset( $new_instance['show_number_checkbox'] ) ? 1 : false;
		$instance['show_type_checkbox']   = isset( $new_instance['show_type_checkbox'] ) ? 1 : false;
		$instance['show_weight_checkbox'] = isset( $new_instance['show_weight_checkbox'] ) ? 1 : false;
		$instance['show_height_checkbox'] = isset( $new_instance['show_height_checkbox'] ) ? 1 : false;
		return $instance;
	}

	/**
	 * Displays the widget.
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {
	    $plugin = Plugin::get_instance();
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
		if ( ! $plugin->components->metabox->pokemon_data ) {
		    $plugin->components->metabox->api_failed_message();
		} else {
			$plugin->components->metabox->display_meta_box();

			if ( $show_number_checkbox ) {
				$plugin->components->metabox->show_number();
			}

			if ( $show_type_checkbox ) {
				$plugin->components->metabox->show_type();
			}

			if ( $show_weight_checkbox ) {
				$plugin->components->metabox->show_weight();
			}

			if ( $show_height_checkbox ) {
				$plugin->components->metabox->show_height();
			}
		}

		echo $after_widget;
	}

}
