<?php
/**
 * Plugin Name: wp-dexter
 * Description: The useful pokemon encyclopedia now on your WordPress website. Uses pokéAPI.
 * Plugin URI: https://github.com/oscarssanchez/wp-dexter
 * Author: Oscar Sánchez
 * Author URI: https://oscarssanchez.com
 * Version: 1.0
 * License: GPLv2 or later
 */

/** Prevent direct access to the file **/
defined( 'ABSPATH' ) or die( 'Access denied' );

require_once( 'inc/class-dexter-api.php' );
require_once( 'inc/class-dextermbox.php' );
require_once( 'inc/class-dexter.php' );
require_once( 'inc/class-dexter-widget.php' );
require_once( 'inc/class-dexter-admin-page.php' );

add_action( 'plugins_loaded', array( 'Dexter_plugin', 'load' ) );
add_action( 'widgets_init', array( 'Dexter_widget', 'register' ) );