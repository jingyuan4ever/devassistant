<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class da_entity_index{
	public $is_unique;
	public $columns;
	public $table;

	public function __construct($table, $index){
		$this->table = $table;
		$this->is_unique = $index['Non_unique'] == 1 ? false : true;
		$this->columns[$index['Seq_in_index']] = $this->table->columns[$index['Column_name']];
	}

	public function add_column($index){
		$this->columns[$index['Seq_in_index']] = $this->table->columns[$index['Column_name']];
	}
}