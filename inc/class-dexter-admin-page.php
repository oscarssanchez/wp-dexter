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
		add_action( 'admin_head', array( $this, 'add_styles' ) );
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
	
	public function add_styles() {
		wp_enqueue_style( 'dexter_backend_css', plugins_url( 'wp-dexter/css/wp-dexter-styles.css' ) );
	}
	public function admin_main_page() {
		
		self::admin_header();
		self::pokemon_meta_box();
		$this->dexter_admin_settings();
	}
	
	public static function admin_header() {
	?>
		<div class="wrapper">
			<h1>Dexter</h1>
			<p class="about description">Welcome PokeUser, you shall change Dexter's settings in this page</p>
		</div>
	<?php
	}
	
	public static function pokemon_meta_box() {
		global $dexter_api;
		
		$pokemon_data = $dexter_api->get_pokemon_data();
	?>
		<div class="postbox pokepostbox">
			<h3>Pokemon:</h3>
			<img src="<?php echo $pokemon_data->{'sprites'}->{'back_default'}; ?>">
			<img src="<?php echo $pokemon_data->{'sprites'}->{'front_default'}; ?>">
			<p>Name: <?php echo $pokemon_data->{'name'}; ?></p>
			<p>Number: <?php echo $pokemon_data->{'id'}; ?></p>
			<p>Type: <?php echo $pokemon_data->{'types'}[0]->{'type'}->{'name'}; ?></p>
			<p>Weight: <?php echo $pokemon_data->{'weight'}; ?></p>
			<p>Height: <?php echo $pokemon_data->{'height'}; ?></p>
		</div>
	<?php
	}
	
	public function dexter_admin_settings() {
		if ( isset( $_POST['pokemon_generation'] ) ) {
			$pokemon_generation = $_POST['pokemon_generation'];
			update_option( 'wp_dexter_pokemon_generation', $pokemon_generation );
		}
		?>
		<div class="postbox pokepostbox">
			<div class="settings">
				<h3>Settings</h3>
				<p class="about description">Changes might take a while</p>
			</div>
			<form name="dexter_options" method="post" action="">
				<div class="form-field">
					<p>Currently picking up from: <span class="pokebold"><?php echo esc_html( get_option( 'wp_dexter_pokemon_generation' ) . 'pokemon' ); ?></span></p>
					<label for="pokemon_generation"> Show until which generation? </label>
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
	}
}
