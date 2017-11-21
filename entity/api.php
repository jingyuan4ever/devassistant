<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class da_entity_api
{
	public static $api_pool = array();

	public $name;
	public $info;
	public $table;
	public $allowed_interfaces;
	public $field_names;
	public $field_reverse_map = array();
	public $functions = array();

	public static function get_api($api_name){
		if(empty(self::$api_pool[$api_name])){
			self::$api_pool[$api_name] = new self($api_name);
		}
		return self::$api_pool[$api_name];
	}

	private function __construct($name)
	{
		$this->name = $name;
		$conf = da_util_conf::getConf('api');
		$this->info = $conf[$name];
		$this->table = da_entity_table::get_table($this->info['table']);
		$this->allowed_interfaces = $this->info['allowed_interfaces'];
		$this->field_names = $this->info['fields'];
		foreach ($this->field_names as $field_name => $field) {
			$this->field_reverse_map[$field['map']] = $field_name;
		}
	}
}