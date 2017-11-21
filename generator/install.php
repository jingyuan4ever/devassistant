<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class da_generator_install extends da_generator_base
{
	private $_create_sql = array();

	function __construct()
	{
		parent::__construct();
		$this->_tpl_name = "install";
		foreach (da_util_conf::getConf('table') as $tableName){
			$realTableName = DB::table($tableName);
			$sql = C::m('#devassistant#dbmeta')->show_create_table($tableName);
			$sql = str_replace("CREATE TABLE `$realTableName`", 'CREATE TABLE IF NOT EXISTS `$table`', $sql);
			$this->_create_sql[$tableName] = $sql;
		}
		$this->_smarty->assign('create_sql', $this->_create_sql);
	}
}