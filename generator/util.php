<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class da_generator_util extends da_generator_base
{
	private $_utilName;
	public function __construct($utilName)
	{
		parent::__construct();
		$this->_tpl_name = "util/".$utilName;
		$this->_utilName = $utilName;
	}

	function get_output_dir()
	{
		return parent::get_output_dir()."/util";
	}

	function get_output_filename()
	{
		return $this->_utilName.".php";
	}
}