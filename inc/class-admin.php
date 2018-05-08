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
	 * Creates the admin menus for the plugin.
	 */
	public function admin_menus() {
		add_menu_page(
			__( 'Dexter Admin page', 'wp-dexter' ),
			__( 'Dexter', 'wp-dexter' ),
			'manage_options',
			'wp-dexter',
			array( $this, 'admin_main_page' ),
			'dashicons-smartphone'
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
	public function admin_main_page() {
		$this->admin_header();
		//Renders the Pokemon Metabox with all display options enabled.
		$this->admin_form_settings();
		$this->plugin->components->metabox->display_full_metabox();
	}

	/**
	 * Renders the header of the admin area.
	 */
	public function admin_header() {
	?>
		<div class="wrapper">
			<h1><?php esc_html_e( 'Dexter', 'wp-dexter' ); ?></h1>
			<p class="about description"><?php echo esc_html_e( 'Welcome PokeUser, you shall change Dexter settings in this page', 'wp-dexter' ); ?></p>
		</div>
	<?php
	}

	/**
	 * Renders the admin settings.
	 */
	public function admin_form_settings() {
		$wp_dexter_pokemon_generation = get_option( 'wp_dexter_pokemon_generation' );
		?>
		<div class="postbox pokepostbox">
			<div class="settings">
				<h3><?php echo esc_html_e( 'Settings', 'wp-dexter' ); ?></h3>
				<p class="about description"><?php echo esc_html_e( 'Changes might take a while', 'wp-dexter' ); ?></p>
			</div>
			<form name="dexter_options" method="post" action="">
				<?php wp_nonce_field( self::FORM_ACTION, 'pokemon_generation_nonce' ); ?>
				<div class="form-field">
					<label for="pokemon_generation"><?php echo esc_html_e (' Show until which generation?', 'wp-dexter' ); ?> </label>
					<select name="pokemon_generation">
						<?php $this->plugin->components->api->pokemon_list(); ?>
					</select>
				</div>
				<div class="form-field">
					<?php submit_button( esc_html( 'Save changes', 'wp-dexter' ) ); ?>
				</div>
				<p><?php echo esc_html_e( 'Currently picking up from:', 'wp-dexter' ); ?> <span class="pokebold"><?php echo esc_html( sprintf( __( '%s Pokemon', 'wp-dexter' ), $wp_dexter_pokemon_generation ) ); ?></span></p>
			</form>
			<?php
		$this->process_form_settings();
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
