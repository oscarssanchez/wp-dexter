<?php
/**
 * Dexter's settings page
 *
 * @package WpDexter
 */

namespace WpDexter;

// Check referrer.
if ( ! ( $this instanceof Admin ) ) {
	return;
}

$wp_dexter_pokemon_generation = get_option( 'wp_dexter_pokemon_generation' );
?>
<div class="wrap">
	<h2><?php echo esc_html( $GLOBALS['title'] ); ?></h2>
	<div class="pokepostbox postbox">
		<h3><?php echo esc_html_e( 'Settings', 'wp-dexter' ); ?></h3>
		<p><?php echo esc_html_e( 'Currently picking up from:', 'wp-dexter' ); ?> <span class="pokebold"><?php echo esc_html( sprintf( __( '%s Pokemon', 'wp-dexter' ), $wp_dexter_pokemon_generation ) ); ?></span></p>
		<form name="dexter_options" method="post" action="<?php admin_url( 'admin-post.php' ); ?>">
			<?php wp_nonce_field( self::FORM_ACTION, 'pokemon_generation_nonce' ); ?>
			<label for="pokemon_generation"><?php echo esc_html_e( ' Show until which generation?', 'wp-dexter' ); ?></label>
			<select name="pokemon_generation">
				<?php $this->plugin->components->api->pokemon_list(); ?>
			</select>
			<?php submit_button( esc_html( 'Save changes', 'wp-dexter' ) ); ?>
		</form>
	</div>
</div>
<?php
$this->process_form_settings();
