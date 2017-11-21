<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class da_generator_portal extends da_generator_base
{
	function __construct()
	{
		parent::__construct();
		$this->_tpl_name = "portal";
		$this->_smarty->assign('site_url', da_util_env::get_site_url());
	}

	public function get_output_filename()
	{
		return da_util_conf::getConf("plugin_name").".inc.php";
	}
}