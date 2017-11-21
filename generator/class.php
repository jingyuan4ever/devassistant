<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class da_generator_class extends da_generator_base
{
	private $_className;
	public function __construct($className)
	{
		parent::__construct();
		$this->_tpl_name = "class/".$className;
		$this->_className = $className;
	}

	function get_output_dir()
	{
		return parent::get_output_dir()."/class";
	}

	function get_output_filename()
	{
		return $this->_className.".php";
	}
}