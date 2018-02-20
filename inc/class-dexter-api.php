<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 14/02/18
 * Time: 08:42 PM
 */

class Dexter_api{
	protected $api_url = 'http://pokeapi.co/api/v2/pokemon';
	
	public function __construct() {
	}
	
	public function get_pokemon_data() {
		$pokemon_generation = get_option( 'wp_dexter_pokemon_generation' );
		//Set initial pokemon data
		if ( false == $pokemon_generation ) {
			$pokemon_generation = 251;
			update_option( 'wp_dexter_pokemon_generation', $pokemon_generation );
		}
		$pokemon_id         = rand( 1, $pokemon_generation );
		$json               = wp_remote_get( $this->api_url . '/' . $pokemon_id );
		$json_feed          = json_decode( $json['body'] );
		
		return $json_feed;
	}
}