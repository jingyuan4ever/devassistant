<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class da_entity_column{
	public $name;
	public $type;
	public $da_type;
	public $length;
	public $default;
	public $not_null;
	public $extra;
	public $need_input;
	public $is_ai;

	public function __construct($column)
	{
		$this->name = $column['Field'];
		if(preg_match("/(\w+)\((\d+)\)/", $column['Type'], $matches)){
			$this->type = $matches[1];
			$this->length = $matches[2];
		}else{
			$this->type = $column['Type'];
			$this->length = $this->get_length();
		}
		$this->default = $column['Default'];
		$this->not_null = $column['Null'] == 'NO' ? true : false;
		$this->extra = $column['Extra'];
		$this->is_ai = $column['Extra'] == 'auto_increment' ? true : false;
		$this->da_type = $this->get_da_type();
		$this->need_input = $this->get_need_input();
	}

	private function get_da_type(){
		if($this->name == 'email'){
			return 'email';
		}
		if($this->name == 'url'){
			return 'url';
		}
		switch($this->type){
			case 'tinyint':
			case 'smallint':
			case 'mediumint':
			case 'int':
			case 'bigint':
				return 'integer';
			case 'double':
			case 'float':
				return 'number';
			case 'char':
			case 'varchar':
			case 'tinytext':
			case 'text':
			case 'mediumtext':
			case 'longtext':
			default:
				return 'string';
		}
	}

	private function get_length(){
		switch($this->type){
			case 'tinytext':
				return 2 ^ 8 - 1;
			case 'text':
				return 2 ^ 16 - 1;
			case 'mediumtext':
				return 2 ^ 24 - 1;
			case 'longtext':
				return 2 ^ 32 - 1;
			default:
				return 0;
		}
	}

	private function get_need_input(){
		if(empty($this->default) && $this->not_null && !$this->is_ai){
			return true;
		}
		return false;
	}
}