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
class Api
{
    /**
     * The URL where we request the Pokémon data from.
     *
     * @var string API_URL
     */
    const API_URL = 'http://pokeapi.co/api/v2';

    /**
     * Retrieves all the Pokémon data.
     *
     * @return array|mixed|object
     */
    public function get_pokemon_data()
    {
        // Default gen is 251 because it is the best!
        $pokemon_generation = get_option('wp_dexter_pokemon_generation', 251);

        $pokemon_data = wp_cache_get('pokemon-data', 'wp-dexter');
        if (! $pokemon_data ) {
            $pokemon_data = wp_remote_get(self::API_URL . '/pokemon/' . rand(1, $pokemon_generation));
            if (200 !== wp_remote_retrieve_response_code($pokemon_data) ) {
                $pokemon_data = false;
            }
            wp_cache_set('pokemon-data', $pokemon_data, 'wp-dexter', 5 * MINUTE_IN_SECONDS);
        }

        return json_decode(wp_remote_retrieve_body($pokemon_data));
    }

    /**
     * Return formatted generations.
     * These don't need to be retrieved often, so cache is set for a month.
     *
     * @return array|false|mixed The pokemon generations formatted or false if pokeAPI is down.
     */
    public function get_generations()
    {
        $generations = wp_cache_get('pokemon-generations', 'wp-dexter');
        if (! $generations ) {
            $generations_data = wp_remote_get(self::API_URL . '/generation/');
            if (200 === wp_remote_retrieve_response_code($generations_data) ) {
                $generations_data = json_decode(wp_remote_retrieve_body($generations_data));
                $generations      = [];
                $pokemon_counter  = 0;
                foreach ( $generations_data->results as $generation ) {
                    $generation = wp_remote_get($generation->url);
                    if (200 === wp_remote_retrieve_response_code($generation) ) {
                        $generation       = json_decode(wp_remote_retrieve_body($generation));
                        $pokemon_counter += count($generation->pokemon_species);
                        $generations[]    = [
                         'gen_name'   => ucfirst($generation->name),
                         'gen_number' => $pokemon_counter
                        ];
                    } else {
                        return false;
                    }
                }
                wp_cache_set('pokemon-generations', $generations, 'wp-dexter', MONTH_IN_SECONDS);
            } else {
                return false;
            }
        }

        return $generations;
    }

    /**
     * Display a message if pokeAPI is down.
     */
    public function api_failed_message()
    {
        ?>
        <div class="postbox pokepostbox">
            <p><?php esc_html_e('PokeAPI service is down. Sorry for the inconvenience!', 'wp-dexter'); ?></p>
        </div>
        <?php
    }
}
