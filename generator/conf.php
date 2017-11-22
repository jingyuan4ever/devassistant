<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class da_generator_conf extends da_generator_base
{
	public function __construct()
	{
		parent::__construct();
		$this->_tpl_name = "util/conf";
		$this->_smarty->assign('private_key', da_util_conf::get_private_key());
	}

	function get_output_filename()
	{
		return "conf.php";
	}

	function get_output_dir()
	{
		return parent::get_output_dir()."/util";
	}

}