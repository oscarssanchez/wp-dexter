<?php
/**
 * The API class for wp-dexter.
 *
 * Powered by http://pokeapi.co as the data source
 */

namespace WpDexter;

/**
 * Class Api
 *
 * Interacts with the API and retrieves Pokémon data.
 *
 * @package WpDexter
 */
class Api {
	
	/**
	 * The URL where we request the Pokémon data from.
	 *
	 * @var string API_URL
	 */
	const API_URL = 'http://pokeapi.co/api/v2/pokemon';

	/**
	 * Retrieves all the Pokémon data.
	 *
	 * @return array|mixed|object
	 */
	public function get_pokemon_data() {
		// Default gen is 251 because it is the best!
		$pokemon_generation = get_option( 'wp_dexter_pokemon_generation', 251 );

		//let's cache so we don't make a ton of requests
		$pokemon_data = wp_cache_get( 'pokemon-data', 'wp-dexter' );
		if ( ! $pokemon_data ) {
			$pokemon_data = wp_remote_get( self::API_URL . '/' . rand( 1, $pokemon_generation ) );
			if ( 200 !== wp_remote_retrieve_response_code( $pokemon_data ) ) {
				wp_cache_set( 'pokemon-data', $pokemon_data, 'wp-dexter', WEEK_IN_SECONDS );
			}
			wp_cache_set( 'pokemon-data', $pokemon_data, 'wp-dexter', 5 * MINUTE_IN_SECONDS );
		}

		return json_decode( $pokemon_data['body'] );
	}

	/**
	 * Render a list of Pokémon generations and corresponding number of Pokémon.
	 */
	public function pokemon_list() {
		$generation_list = array(
			array(
				'gen_name'   => __( '1st Gen', 'wp-dexter' ),
				'gen_number' => 151,
			),
			array(
				'gen_name'   => __( '2nd Gen', 'wp-dexter' ),
				'gen_number' => 251,
			),
			array(
				'gen_name'   => __( '3rd Gen', 'wp-dexter' ),
				'gen_number' => 386,
			),
			array(
				'gen_name'   => __( '4th Gen', 'wp-dexter' ),
				'gen_number' => 493,
			),
			array(
				'gen_name'   => __( '5th Gen', 'wp-dexter' ),
				'gen_number' => 649,
			),
			array(
				'gen_name'   => __( '6th Gen', 'wp-dexter' ),
				'gen_number' => 721,
			),
			array(
				'gen_name'   => __( '7th Gen', 'wp-dexter' ),
				'gen_number' => 807,
			),
		);

		foreach( $generation_list as $pokemon_generation ) {
			echo '<option value="' . esc_attr( $pokemon_generation['gen_number'] ) . '">' . esc_html( $pokemon_generation['gen_name'] ). '</option>';
		}
	}

	/**
	 * Display a message if pokeAPI is down.
	 */
	public function api_failed_message() {
		?>
		<div class="postbox pokepostbox">
			<p><?php esc_html_e( 'PokeAPI service is down. Sorry for the inconvenience!', 'wp-dexter' ); ?></p>
		</div>
		<?php
	}
}
