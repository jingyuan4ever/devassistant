<?php
{{include file='common/common_head.tpl'}}

define("{{$conf.plugin_name_upper_case}}_PLUGIN_PATH", dirname(__FILE__));

class {{$conf.plugin_short_name}}_autoloader
{
	public static function autoload($class)
	{
		$class = strtolower($class);
		if(strpos($class, '{{$conf.plugin_short_name}}_') !== 0){
			return false;
		}
		$class = substr($class, strlen('{{$conf.plugin_short_name}}') + 1);
		while(($pos = strpos($class, '_')) != false) {
			$class[$pos] = '/';
			$path = {{$conf.plugin_name_upper_case}}_PLUGIN_PATH . "/$class.php";
			if (!file_exists($path)) {
				continue;
			}
			require_once $path;
			if (class_exists($class)) {
				return true;
			}
		}
		return false;
	}
}
spl_autoload_register(array('{{$conf.plugin_short_name}}_autoloader', 'autoload'), true, true);