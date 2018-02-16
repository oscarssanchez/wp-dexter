<?php
/**
 * Created by PhpStorm.
 * User: oscar
 * Date: 14/02/18
 * Time: 08:42 PM
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