<?php
/**
 * The Metabox Class
 */

class Pokemon_Metabox {
	/**
	 * Displays the basic pokemon data
	 */
	public static function display_meta_box() {
		$pokemon_data = Dexter_api::get_pokemon_data();
		?>
		<div class="postbox pokepostbox">
			<h3>Pokemon:</h3>
			<img src="<?php echo $pokemon_data->{'sprites'}->{'back_default'}; ?>">
			<img src="<?php echo $pokemon_data->{'sprites'}->{'front_default'}; ?>">
			<p>Name: <?php echo $pokemon_data->{'name'}; ?></p>
		<?php
	}
	/**
	 * Displays all pokemon data
	 */
	public static function display_full_metabox() {
		self::display_meta_box();
		self::show_number();
		self::show_type();
		self::show_height();
		self::show_weight();
		self::stats_container();
		self::metabox_footer();
	}
	
	public static function stats_container() {
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
	public  static function show_number() {
		$pokemon_data = Dexter_api::get_pokemon_data();
		?>
		<p>Number: <?php echo $pokemon_data->{'id'}; ?></p>
		<?php
	}
	/**
	 * Displays the pokemon height
	 */
	public static function show_height() {
		$pokemon_data = Dexter_api::get_pokemon_data();
		?>
		<p>Height: <?php echo $pokemon_data->{'height'}; ?></p>
		<?php
	}
	/**
	 * Displays the pokemon weight
	 */
	public static  function show_weight() {
		$pokemon_data = Dexter_api::get_pokemon_data();
		?>
		<p>Weight: <?php echo $pokemon_data->{'weight'}; ?></p>
		<?php
	}
	/**
	 * Displays the pokemon type
	 */
	public static function show_type() {
		$pokemon_data = Dexter_api::get_pokemon_data();
		?>
		<p>Type: <?php echo $pokemon_data->{'types'}[0]->{'type'}->{'name'}; ?></p>
		<?php
	}
	public static function metabox_footer() {
		?>
		</div>
		<?php
	}
}
