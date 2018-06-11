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
		add_action( 'admin_enqueue_scripts', array( $this, 'add_scripts' ) );
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
	 * Enqueues JavaScript files.
	 */
	public function add_scripts() {
		wp_enqueue_script( 'd3-scripts', plugins_url( '../vendor/d3/d3.min.js', __FILE__ ) );
		wp_enqueue_script( 'dexter-scripts', plugins_url( '../js/dexter-scripts.js', __FILE__ ), array( 'jquery'), Plugin::VERSION, true );
		wp_localize_script( 'dexter-scripts', 'pokemon_stats', $this->plugin->components->api->get_pokemon_json_data() );
	}
	/**
	 * Enqueues the CSS stylesheet.
	 */
	public function add_styles() {
		wp_enqueue_style( 'dexter_backend_css', plugins_url( '../css/wp-dexter-styles.css', __FILE__ ), array(), Plugin::VERSION );
	}

	/**
	 * Renders the main page.
	 */
	public function render_options_page() {
		$this->admin_form_settings();
	}

	/**
	 * Renders the admin settings.
	 */
	public function admin_form_settings() {
		include( dirname( __FILE__ ) . '/../templates/settings-page.php' );
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
