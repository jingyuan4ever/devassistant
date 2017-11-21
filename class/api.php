<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class da_class_api
{
	protected $actionList;

	public function execute(){
		global $_G;
		$groupId = $_G["groupid"];
		$action = isset($_GET['action']) ? $_GET['action'] : "get";

		try {
			if (!isset($this->actionList[$action])) {
				throw new Exception('unknown action');
			}
			$groups = $this->actionList[$action];
			if (!empty($groups) && !in_array($groupId, $groups)) {
				throw new Exception('illegal request');
			}
			$res = $this->$action();
			da_util_env::result(array("data"=>$res));
		} catch (Exception $e) {
			da_util_env::result(array('retcode'=>100010,'retmsg'=>$e->getMessage()));
		}
	}
}
