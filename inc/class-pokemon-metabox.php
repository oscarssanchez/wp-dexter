<?php
/**
 * The Metabox Class
 */

namespace WpDexter;

class Pokemon_Metabox {
    /**
     * Instance of the plugin.
     *
     * @var object
     */
    public $plugin;

    /**
     * Instantiate this class.
     *
     * @param object $plugin Instance of the plugin.
     */

    /**
     * Stores the pokemon data.
     *
     * @var object
     */
    public $pokemon_data;

    public function __construct( $plugin ) {
        $this->plugin = $plugin;
        $this->pokemon_data = $this->plugin->components->api->get_pokemon_data();
    }

	/**
	 * Displays the basic pokemon data
	 */
	public function display_meta_box() {
		?>
		<div class="postbox pokepostbox">
			<h3>Pokemon:</h3>
			<img src="<?php echo $this->pokemon_data->{'sprites'}->{'back_default'}; ?>">
			<img src="<?php echo $this->pokemon_data->{'sprites'}->{'front_default'}; ?>">
			<p>Name: <?php echo $this->pokemon_data->{'name'}; ?></p>
		<?php
	}
	/**
	 * Displays all pokemon data
	 */
	public function display_full_metabox() {
		$this->display_meta_box();
        $this->show_number();
        $this->show_type();
        $this->show_height();
        $this->show_weight();
        $this->stats_container();
        ?>
        </div>
        <?php
	}
	
	public function stats_container() {
		?>
		<div>
			<p class="pokestats_title">Stats</p>
			<svg class="pokestats"></svg>
		</div>
		<?php
	}
	/**
	 * Displays the pokemon number
	 */
	public function show_number() {
		?>
		<p>Number: <?php echo $this->pokemon_data->{'id'}; ?></p>
		<?php
	}
	/**
	 * Displays the pokemon height
	 */
	public function show_height() {
		?>
		<p>Height: <?php echo $this->pokemon_data->{'height'}; ?></p>
		<?php
	}
	/**
	 * Displays the pokemon weight
	 */
	public function show_weight() {
		?>
		<p>Weight: <?php echo $this->pokemon_data->{'weight'}; ?></p>
		<?php
	}
	/**
	 * Displays the pokemon type
	 */
	public function show_type() {
		?>
		<p>Type: <?php echo $this->pokemon_data->{'types'}[0]->{'type'}->{'name'}; ?></p>
		<?php
	}
}
