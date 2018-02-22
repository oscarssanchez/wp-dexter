<?php
/**
 * The API class for wp-dexter
 *
 * Powered by http://pokeapi.co as the data source
 */

class Dexter_api{
	/**
	 * @var string $api_url The URL where we request the pokemon data from.
	 */
	protected $api_url = 'http://pokeapi.co/api/v2/pokemon';
	
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
		$pokemon_id         = rand( 1, $pokemon_generation );
		$json               = wp_remote_get( $this->api_url . '/' . $pokemon_id );
		$json_feed          = json_decode( $json['body'] );
		
		return $json_feed;
	}
}