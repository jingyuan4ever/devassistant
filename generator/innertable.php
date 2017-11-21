<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class da_generator_innertable extends da_generator_base
{
	private $_table;

	public function __construct($tableName)
	{
		parent::__construct();
		$this->_table = da_entity_table::get_table($tableName);
		$this->_tpl_name = "innertable";
		$this->_smarty->assign('table', $this->_table);
	}

	function get_output_filename(){
		$s = str_replace('_', '', $this->_table->name);
		return "$s.php";
	}

	function get_output_dir()
	{
		return parent::get_output_dir()."/innertable";
	}
}