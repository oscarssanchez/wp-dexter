<?php
/**
 * The main plugin class
 */

class Dexter_plugin{
	static function load(){
		global $dexter;
		global $dexter_api;
		global $dexter_admin;
		global $dexter_widget;
		$dexter       = new self();
		$dexter_api   = new Dexter_api();
		$dexter_admin = new Dexter_admin();
		$dexter_widget = new Dexter_widget();
	}
}