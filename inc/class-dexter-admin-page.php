<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 14/02/18
 * Time: 08:42 PM
 */

class Dexter_admin{
	
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menus' ) );
	}
	
	public function admin_menus() {
		add_menu_page(
			'Dexter Admin page',
			'Dexter',
			'manage_options',
			'wp-dexter',
			array( $this, 'admin_main_page' )
		);
	}
	
	public function admin_main_page() {
		
		self::admin_header();
		self::pokemon_meta_box();
		self::dexter_admin_settings();
		self::admin_footer();
	}
	
	public static function admin_header() {
	?>
		<div class="welcome-panel">
			<h1>Dexter</h1>
			<p class="about description">Welcome PokeUser, you shall change Dexter's settings in this page</p>
	<?php
	}
	
	public static function pokemon_meta_box() {
		global $dexter_api;
		
		$pokemon_data = $dexter_api->get_pokemon_data();
	?>
		<div class="wrapper">
			<h2>Pokemon:</h2>
			<img src="<?php echo $pokemon_data->{'sprites'}->{'back_default'}; ?>">
			<img src="<?php echo $pokemon_data->{'sprites'}->{'front_default'}; ?>">
			<p>Name: <?php echo $pokemon_data->{'name'}; ?></p>
			<p>Number: <?php echo $pokemon_data->{'id'}; ?></p>
			<p>Type: <?php echo $pokemon_data->{'types'}[0]->{'type'}->{'name'}; ?></p>
			<p>Weight: <?php echo $pokemon_data->{'weight'}; ?></p>
		</div>
	<?php
	}
	
	public static function dexter_admin_settings() {
		$pokemon_generation = get_option( 'wp_dexter_pokemon_generation' );
		if ( empty( $pokemon_generation ) ) {
			$pokemon_generation = 251;
		}
		if ( isset( $_POST['pokemon_generation'] ) ) {
			$pokemon_generation = $_POST['pokemon_generation'];
		}
		?>
		<h2>Settings</h2>
		<form name="dexter_options" method="post" action="">
			<div class="form-field">
				<label for="pokemon_generation">Show until which generation?</label>
				<select name="pokemon_generation">
					<option value="151">1st Gen</option>
					<option value="251">2nd Gen</option>
					<option value="386">3rd Gen</option>
					<option value="493">4th Gen</option>
					<option value="649">5th Gen</option>
					<option value="721">6th Gen</option>
					<option value="807">7th Gen</option>
				</select>
			</div>
			<div class="form-field">
				<?php submit_button(); ?>
			</div>
		</form>
		<?php
		update_option( 'wp_dexter_pokemon_generation', $pokemon_generation );
	}
	public static function admin_footer() {
	?>
		</div>
	<?php
	}
}