<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class da_generator_autoloader extends da_generator_base
{
	public function __construct()
	{
		parent::__construct();
		$this->_tpl_name = "autoloader";
	}
}