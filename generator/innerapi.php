<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class da_generator_innerapi extends da_generator_base
{
	private $_api;

	public function __construct($api_name)
	{
		parent::__construct();
		$this->_tpl_name = "innerapi";
		$this->_api = da_entity_api::get_api($api_name);
		$this->_smarty->assign('api', $this->_api);
		$this->_smarty->assign('private_key', da_util_conf::get_private_key());
	}

	function get_output_filename()
	{
		return $this->_api->name.".php";
	}

	function get_output_dir()
	{
		return parent::get_output_dir()."/innerapi";
	}

}