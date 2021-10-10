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
