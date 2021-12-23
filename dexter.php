<?php
/**
 * Plugin Name: WP-Dexter
 * Description: The useful pokemon encyclopedia now on your WordPress website. Uses pokéAPI.
 * Text Domain: wp-dexter
 * Plugin URI: https://github.com/oscarssanchez/wp-dexter
 * Author: Oscar Sánchez
 * Author URI: https://oscarssanchez.com
 * Version: 1.1.1
 * License: GPLv2 or later
 */

namespace WpDexter;

/** Prevent direct access to the file **/
defined( 'ABSPATH' ) or die( 'Access denied' );

require_once( dirname( __FILE__ ) . '/inc/class-plugin.php' );

$plugin = Plugin::get_instance();
$plugin->init();
