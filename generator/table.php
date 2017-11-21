<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class da_generator_table extends da_generator_base
{
	private $_table;

	public function __construct($tableName)
	{
		parent::__construct();
		$this->_table = da_entity_table::get_table($tableName);
		$this->_tpl_name = "table";
		$this->_smarty->assign('table', $this->_table);
		$this->_force_update = false;
	}

	function get_output_filename(){
		return "table_{$this->_table->name}.php";
	}

	function get_output_dir()
	{
		return parent::get_output_dir()."/table";
	}
}