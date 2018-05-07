<?php
/**
 * The main plugin class
 *
 * @package WpDexter
 */

namespace WpDexter;

/**
 * Class Plugin
 *
 * Initializes and instantiates de plugin.
 *
 * @package WpDexter
 */
class Plugin {

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
	 * Initializes the plugin by loading files and classes.
	 */
	public function init() {
		$this->load_files();
		$this->load_classes();
		$this->add_actions();
	}

	/**
	 * Loads all plugin files.
	 */
	public function load_files() {
		require_once( dirname( __FILE__ ) . '/class-widget.php' );
		require_once( dirname( __FILE__ ) . '/class-admin-page.php' );
		require_once( dirname( __FILE__ ) . '/class-api.php');
		require_once( dirname( __FILE__ ) . '/class-pokemon-metabox.php');
	}

	/**
	 * Instantiates the plugin classes in $components
	 */
	public function load_classes() {
		$this->components = new \stdClass();
		$this->components->api = new Api();
		$this->components->admin_page = new Admin( $this );
		$this->components->admin_page->init();
		$this->components->metabox = new Pokemon_Metabox( $this );
	}

	public function add_actions() {
        add_action( 'widgets_init', array( $this, 'register_widget' ) );
    }

	public static function get_instance() {
		if ( ! self::$instance instanceof Plugin ) {
			self::$instance = new Plugin();
		}

		return self::$instance;
	}

    public function register_widget() {
        register_widget( __NAMESPACE__ . '\Widget' );
    }

}
