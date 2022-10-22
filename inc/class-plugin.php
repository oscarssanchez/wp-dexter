<?php
/**
 * The main plugin class.
 *
 * @package WpDexter
 */

namespace WpDexter;

/**
 * Class Plugin
 *
 * Initializes and instantiates the plugin.
 *
 * @package WpDexter
 */
class Plugin {

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	const VERSION = '1.0';

	/**
	 * The Plugin instance.
	 *
	 * @var object
	 */
	public static $instance;

	/**
	 * The plugin instantiated classes.
	 *
	 * @var object
	 */
	public $components;

	/**
	 * Instantiates the main plugin class.
	 *
	 * @return object|Plugin
	 */
	public static function get_instance() {
		if ( ! self::$instance instanceof Plugin ) {
			self::$instance = new Plugin();
		}

		return self::$instance;
	}

	/**
	 * Initializes the plugin by loading files and classes.
	 */
	public function init() {
		$this->load_files();
		$this->load_classes();
		$this->add_actions();
	}

	/**
	 * Loads plugin files.
	 */
	public function load_files() {
		require_once( dirname( __FILE__ ) . '/class-admin.php');
		require_once( dirname( __FILE__ ) . '/class-api.php');
		require_once( dirname( __FILE__ ) . '/class-pokemon-metabox.php');
		require_once( dirname( __FILE__ ) . '/class-widget.php' );
	}

	/**
	 * Instantiates the plugin classes in $components .
	 */
	public function load_classes() {
		$this->components             = new \stdClass();
		$this->components->api        = new Api();
		$this->components->admin_page = new Admin( $this );
		$this->components->admin_page->init();
		$this->components->metabox = new Pokemon_Metabox( $this );
        $this->components->metabox->init();
	}

	/**
	 * Adds plugin actions.
	 */
	public function add_actions() {
		add_action( 'widgets_init', array( $this, 'register_widget' ) );
	}

	/**
	 * Registers the plugin widget.
	 */
	public function register_widget() {
		register_widget( __NAMESPACE__ . '\Widget' );
	}

}
