<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

define("DEV_ASSISTANT_PLUGIN_PATH", dirname(__FILE__));

class da_autoloader
{
	public static function autoload($class)
	{
		$class = strtolower($class);
		if(strpos($class, 'da_') !== 0){
			return false;
		}
		$class = substr($class, strlen('da')+1);
		$path = DEV_ASSISTANT_PLUGIN_PATH ."/". str_replace('_', '/', $class) . ".php";
		if (!file_exists($path)) {
			return false;
		}
		require_once $path;
		if (class_exists($class)) {
			return true;
		}
		return false;
	}
}
spl_autoload_register(array('da_autoloader', 'autoload'), true, true);