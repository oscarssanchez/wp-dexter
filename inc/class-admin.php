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
class Admin
{

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
     * The nonce name.
     *
     * @var string
     */
    const NONCE_NAME = 'pokemon_generation_nonce';

    /**
     * The nonce action
     *
     * @var string
     */
    const NONCE_ACTION = 'pokemon_generation_update';

    /**
     * Instantiate this class.
     *
     * @param object $plugin Instance of the plugin
     */
    public function __construct( $plugin )
    {
        $this->plugin = $plugin;
    }

    /**
     * Plugin admin page initializer.
     */
    public function init()
    {
        add_action('admin_menu', array( $this, 'admin_menus' ));
        add_action('admin_post_wp-dexter-save', array( $this, 'save' ));
        add_action('admin_head', array( $this, 'add_styles' ));
        add_action('init', array( $this, 'textdomain' ));
    }

    /**
     * Loads the plugin Text Domain. Enables plugin translation.
     */
    public function textdomain()
    {
        load_plugin_textdomain(self::SLUG);
    }

    /**
     * Creates the plugin's settings page in the settings menu.
     */
    public function admin_menus()
    {
        add_options_page(
            __('WP-Dexter', 'wp-dexter'),
            __('WP-Dexter', 'wp-dexter'),
            'manage_options',
            'wp-dexter',
            array( $this, 'render_options_page' )
        );
    }

    /**
     * Enqueues the CSS stylesheet.
     */
    public function add_styles()
    {
        if ($this->is_dexter_settings_page() ) {
            wp_enqueue_style('dexter_backend_css', plugins_url('../dist/css/frontend.css', __FILE__), array(), Plugin::VERSION);
        }
    }

    /**
     * Renders the main page.
     */
    public function render_options_page()
    {
        include dirname(__FILE__) . '/../templates/settings-page.php';
    }

    /**
     * Checks if this is Dexter settings page.
     *
     * @return bool
     */
    public function is_dexter_settings_page()
    {
        if ('settings_page_wp-dexter' === get_current_screen()->id ) {
            return true;
        }
        return false;
    }

    /**
     * Process and saves the form settings.
     */
    public function save()
    {
        $verify = (
        isset($_POST['pokemon_generation'], $_POST[ self::NONCE_NAME ])
        &&
        wp_verify_nonce(sanitize_key(wp_unslash($_POST[ self::NONCE_NAME ])), self::NONCE_ACTION)
        );

        if (true === $verify ) {
            update_option('wp_dexter_pokemon_generation', sanitize_text_field(wp_unslash($_POST['pokemon_generation'])));
            wp_redirect(admin_url('options-general.php?page=wp-dexter') . '&updated=true');
            exit;
        }
    }
}
