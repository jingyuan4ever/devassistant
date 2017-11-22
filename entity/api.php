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
	public $fields;
	public $field_reverse_map = array();
	public $functions = array();
	public $need_encode = false;

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
		$this->fields = $this->info['fields'];
		foreach ($this->fields as $field_name => &$field) {
			if(empty($field['need_encode'])){
				$field['need_encode'] = false;
			}
			if($field['need_encode']){
				$this->need_encode = true;
			}
			if(empty($field['map'])){
				$field['map'] = $field_name;
			}
			$column_name = $field['map'];
			$this->field_reverse_map[$column_name] = $field_name;
			$column = $this->table->columns[$column_name];
			$field['column'] = $column;
		}
	}
}