<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 14/02/18
 * Time: 08:42 PM
 */

class Dexter_admin{
	
	public function __construct(){
		add_action( 'admin_menu', array( $this, 'admin_menus' ) );
	}
	
	public function admin_menus(){
		add_menu_page(
		'Dexter Admin page',
		'Dexter',
		'edit_plugins',
		'wp-dexter',
		array( $this, 'admin_main_page' )
		);
	}
	
	public function admin_main_page(){
		
		$this->admin_header();
		self::pokemon_meta_box();
		$this->admin_footer();
	}
	
	public function admin_header(){
	?>
		<div class="welcome-panel">
			<h1>Dexter</h1>
			<p class="about description">Welcome PokeUser, you shall change Dexter's settings in this page</p>
	<?php
	}
	
	public static function pokemon_meta_box(){
		global $dexter_api;
		
		$pokemon_data  = $dexter_api->get_pokemon_data();
	?>
		<div class="wrapper">
			<h2>Pokemon:</h2>
            <img src="<?php echo $pokemon_data->{'sprites'}->{'back_default'}; ?>">
            <img src="<?php echo $pokemon_data->{'sprites'}->{'front_default'}; ?>">
			<p>Name: <?php echo $pokemon_data->{'name'}; ?></p>
            <p>Number: <?php echo $pokemon_data->{'id'};?></p>
            <p>Type: <?php echo $pokemon_data->{'types'}[0]->{'type'}->{'name'}; ?></p>
            <p>Weight: <?php echo $pokemon_data->{'weight'}; ?></p>
		</div>
	<?php
	}
	
	public function admin_footer(){
	?>
		</div>
	<?php
	}
}