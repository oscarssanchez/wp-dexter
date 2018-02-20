<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 15/02/18
 * Time: 04:24 PM
 */

class Dexter_widget extends WP_Widget{
	
	function __construct() {
		parent::__construct(
			'dexter_widget',
			esc_html( 'Dexter' ),
			array( 'description' => 'Display Pokemon data on your site! ' )
		);
	}
	public static function register() {
		register_widget( get_class() );
	}
	public function widget( $args, $instance ) {
		echo $args[ 'before_widget' ];
		if( !empty( $instance[ 'title' ] ) ){
			echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
		}
		Dexter_admin::pokemon_meta_box();
		echo $args['after_widget'];
	}
	
	public function form( $instance ){
		$title = ! empty( $instance[ 'title' ] ) ? $instance[ 'title' ] : esc_html( 'Dexter' );
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_attr_e( 'Title    :', 'text_domain' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<?php
	}
	
	public function update( $new_instance, $old_instance ){
		$instance = array();
		$instance[ 'title' ] = ( ! empty( $new_instance[ 'title' ] ) ) ? strip_tags( $new_instance[ 'title' ] ) : '';
		
		return $instance;
	}
	
}
