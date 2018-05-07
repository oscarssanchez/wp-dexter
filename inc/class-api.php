<?php
/**
 * The API class for wp-dexter
 *
 * Powered by http://pokeapi.co as the data source
 */

namespace WpDexter;

class Api {
	
	/**
	 * @var string $api_url The URL where we request the pokemon data from.
	 */
	static protected $api_url = 'http://pokeapi.co/api/v2/pokemon';
	
	/**
	 * Retrieves all the pokemon data.
	 *
	 * @return array|mixed|object
	 */
	public function get_pokemon_data() {
		//Fetches if there's custom settings to show from.
		$pokemon_generation = get_option( 'wp_dexter_pokemon_generation' );
		//Sets initial pokemon data if not.
		if ( ! $pokemon_generation ) {
			$pokemon_generation = 251;
			update_option( 'wp_dexter_pokemon_generation', $pokemon_generation );
		}
		$json = wp_remote_get( self::$api_url . '/' . rand( 1, $pokemon_generation ) );
		$json_feed = json_decode( $json['body'] );
		
		return $json_feed;
	}
	
	public function get_pokemon_json_data() {
		return json_encode( $this->get_pokemon_data() );
	}
	
	/**
	 * Render a list of pokemon generations and corresponding number of pokemon.
	 */
	public function pokemon_list() {
		$generation_list = array(
			array(
				'gen_name'   => '1st Gen',
				'gen_number' => 151,
			),
			array(
				'gen_name'   => '2nd Gen',
				'gen_number' => 251,
			),
			array(
				'gen_name'   => '3rd Gen',
				'gen_number' => 386,
			),
			array(
				'gen_name'   => '4th Gen',
				'gen_number' => 493,
			),
			array(
				'gen_name'   => '5th Gen',
				'gen_number' => 649,
			),
			array(
				'gen_name'   => '6th Gen',
				'gen_number' => 721,
			),
			array(
				'gen_name'   => '7th Gen',
				'gen_number' => 807,
			),
		);

		foreach( $generation_list as $pokemon_generation ) {
			echo '<option value="' . $pokemon_generation['gen_number'] . '">' . $pokemon_generation['gen_name'] . '</option>';
		}
	}
	
}
