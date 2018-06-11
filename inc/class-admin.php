<?php
/**
 * WP-Dexter admin area.
 */

namespace WpDexter;

/**
 * Class Admin
 *
 * @package WpDexter
 */
class Admin {

	/**
	 * Instance of the plugin.
	 * 
	 * @var object
	 */
	public $plugin;

	/**
	 * Plugin slug.
	 *
	 * @var string
	 */
	const SLUG = 'wp-dexter';

	/**
	 * Action to submit a Pokémon generation.
	 *
	 * @var string
	 */
	const FORM_ACTION = 'submit_pokemon_generation';

	/**
	 * Instantiate this class.
	 *
	 * @param object $plugin Instance of the plugin
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
	}

	/**
	 * Plugin admin page initializer.
	 */
	public function init() {
		add_action( 'admin_menu', array( $this, 'admin_menus' ) );
		add_action( 'admin_head', array( $this, 'add_styles' ) );
		add_action( 'init', array( $this, 'textdomain' ) );
	}

	/**
	 * Loads the plugin Text Domain. Enables plugin translation.
	 */
	public function textdomain() {
		load_plugin_textdomain( self::SLUG );
	}

	/**
	 * Creates the plugin's settings page in the settings menu.
	 */
	public function admin_menus() {
		add_options_page(
			__( 'WP-Dexter', 'wp-dexter' ),
			__( 'WP-Dexter', 'wp-dexter' ),
			'manage_options',
			'wp-dexter',
			array( $this, 'render_options_page' )
		);
	}

	/**
	 * Enqueues the CSS stylesheet.
	 */
	public function add_styles() {
		if ( $this->is_dexter_settings_page() ) {
			wp_enqueue_style( 'dexter_backend_css', plugins_url( '../css/wp-dexter-styles.css', __FILE__ ), array(), Plugin::VERSION );
		}
	}

	/**
	 * Renders the main page.
	 */
	public function render_options_page() {
		include( dirname( __FILE__ ) . '/../templates/settings-page.php' );
	}

	/**
	 * Checks if this is Dexter settings page.
	 *
	 * @return bool
	 */
	public function is_dexter_settings_page() {
		if ( get_current_screen()->id === 'settings_page_wp-dexter' ) {
			return true;
		}
	}

	/**
	 * Process the form settings.
	 */
	public function process_form_settings() {
		if ( isset( $_POST['pokemon_generation_nonce'] ) && wp_verify_nonce( $_POST['pokemon_generation_nonce'], self::FORM_ACTION ) && isset( $_POST['pokemon_generation'] ) ) {
			update_option( 'wp_dexter_pokemon_generation', sanitize_text_field( wp_unslash( $_POST['pokemon_generation'] ) ) );
		}
	}

}
