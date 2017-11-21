<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
/**
 * 加密解密模块
 **/
class model_dbmeta
{
	public function get_tables(){
		return DB::fetch_all("SHOW TABLE STATUS");
	}

	public function describe_table($tableName){
		$tableName = DB::table($tableName);
		return DB::fetch_all("DESC $tableName");
	}
	
	public function show_create_table($tableName){
		$tableName = DB::table($tableName);
		return DB::fetch_first("SHOW CREATE TABLE $tableName")['Create Table'];
	}

	public function get_index($tableName){
		$tableName = DB::table($tableName);
		return DB::fetch_all("SHOW INDEX FROM $tableName");
	}
}