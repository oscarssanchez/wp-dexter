<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 14/02/18
 * Time: 08:41 PM
 */
/*
Plugin Name: Dexter
Plugin URI: http://wordpress.org/plugins/hello-dolly/
Description: Dexter is a PokePlugin for Pokemon fans
Author: Oscar Sanchez
Version: 1.6
Author URI: http://ma.tt/
*/

require_once ('inc/class-dexter-api.php');
require_once ('inc/class-dexter.php');
require_once ('inc/class-dexter-widget.php');
require_once ('inc/class-dexter-admin-page.php');

add_action( 'plugins_loaded', array( 'Dexter_plugin', 'load' ) );
add_action( 'widgets_init', array( 'Dexter_widget', 'register' ) );