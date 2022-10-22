<?php
/**
 * The Metabox Class.
 */

namespace WpDexter;

/**
 * Class Pokemon_Metabox
 *
 * @package WpDexter
 */
class Pokemon_Metabox {

	/**
	 * Instance of the plugin.
	 *
	 * @var object
	 */
	public $plugin;

	/**
	 * Stores the Pokémon data.
	 *
	 * @var object
	 */
	 public $pokemon_data;

	/**
	 * Pokemon_Metabox constructor.
	 *
	 * Instantiates this class and loads the Pokémon data retrieved from the API.
	 *
	 * @param $plugin
	 */
	public function __construct( $plugin ) {
		$this->plugin       = $plugin;
		$this->pokemon_data = $this->plugin->components->api->get_pokemon_data();
	}

	public function init() {
		add_action( 'init', [ $this, 'register_block'] );
	}

	/**
	* Registers out Pokémon block
	*/
	public function register_block() {
		register_block_type(
			WP_DEXTER_PATH . '/js/blocks',
			[
				'render_callback' => [ $this, 'render_block_callback' ],
			]

		);
	}

	/**
	 * Render callback method for the block
	 *
	 * @param array  $attributes The blocks attributes
	 *
	 * @return string The rendered block markup.
	 */
	public function render_block_callback( $attributes ) {
		$html = '';
		if ( ! empty ( $attributes['pokemonNumber'] ) && is_numeric( $attributes['pokemonNumber'] ) ) :
			ob_start(); ?>
			<div class="postbox pokepostbox">
				<img src="<?php echo esc_url( $attributes['frontImage'] ); ?>">
				<img src="<?php echo esc_url( $attributes['backImage'] ); ?>">
				<?php if ( $attributes['showName'] && ! empty( $attributes['pokemonName'] ) ) : ?>
					<p><?php printf( __( 'Name: %s', 'wp_dexter' ), esc_html( $attributes['pokemonName'] ) ); ?></p>
				<?php endif; ?>
				<?php if ( $attributes['showNumber'] ) : ?>
					<p><?php printf( __( 'Number: %s', 'wp_dexter' ), esc_html( $attributes['pokemonNumber'] ) ); ?></p>
				<?php endif; ?>
				<?php if ( $attributes['showType'] && ! empty( $attributes['pokemonType'] ) ) : ?>
					<p><?php printf( __( 'Type: %s', 'wp_dexter' ), esc_html( $attributes['pokemonType'] ) ); ?></p>
				<?php endif; ?>
				<?php if ( $attributes['showWeight'] && ! empty( $attributes['pokemonWeight'] ) ) : ?>
					<p><?php printf( __( 'Weight: %s', 'wp_dexter' ), esc_html( $attributes['pokemonWeight'] ) ); ?></p>
				<?php endif; ?>
				<?php if ( $attributes['showHeight'] && ! empty( $attributes['pokemonHeight'] ) ) : ?>
					<p><?php printf( __( 'Height: %s', 'wp_dexter' ), esc_html( $attributes['pokemonHeight'] ) ); ?></p>
				<?php endif; ?>
			</div>
			<?php
			$html = ob_get_clean();
		endif;
		return $html;
	}

	/**
	 * Displays the basic Pokémon data.
	 */
	public function display_meta_box() {
		?>
		<div class="postbox pokepostbox">
			<img src="<?php echo esc_url( $this->pokemon_data->sprites->back_default ); ?>">
			<img src="<?php echo esc_url( $this->pokemon_data->sprites->front_default ); ?>">
			<p><?php echo esc_html( sprintf( __( 'Name: %s', 'wp-dexter' ), $this->pokemon_data->name ) ); ?></p>
		<?php
	}

	/**
	 * Displays the stats chart.
	 */
	public function stats_container() {
		?>
		<div>
			<p class="pokestats_title"><?php esc_html_e( 'Stats' ); ?></p>
			<svg class="pokestats"></svg>
		</div>
		<?php
	}

	/**
	 * Displays the Pokémon number.
	 */
	public function show_number() {
		?>
		<p><?php echo esc_html( sprintf( __( 'Number: %s', 'wp-dexter' ), $this->pokemon_data->id )  ); ?></p>
		<?php
	}

	/**
	 * Displays the Pokémon height.
	 */
	public function show_height() {
		?>
		<p><?php echo esc_html( sprintf( __( 'Height: %s', 'wp-dexter' ), $this->pokemon_data->height )  ); ?></p>
		<?php
	}

	/**
	 * Displays the Pokémon weight.
	 */
	public function show_weight() {
		?>
		<p><?php echo esc_html( sprintf( __( 'Weight: %s', 'wp-dexter' ), $this->pokemon_data->weight )  ); ?></p>
		<?php
	}

	/**
	 * Displays the Pokémon type.
	 */
	public function show_type() {
		?>
		<p><?php echo esc_html( sprintf( __( 'Type: %s', 'wp-dexter' ), $this->pokemon_data->types[0]->type->name )  ); ?></p>
		<?php
	}

}
