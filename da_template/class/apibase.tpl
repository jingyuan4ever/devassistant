<?php
{{include file='../common/common_head.tpl'}}

class {{$conf.plugin_short_name}}_class_apibase
{
	protected $actionList;

	public function execute(){
		global $_G;
		$groupId = $_G["groupid"];
		$action = isset($_GET['action']) ? $_GET['action'] : "get";

		try {
			if (!isset($this->actionList[$action])) {
                throw new Exception('Unknown action!');
            }
            $groups = $this->actionList[$action];
            if (!empty($groups) && !in_array($groupId, $groups)) {
                throw new Exception('Illegal request!');
            }
            $res = $this->$action();
            {{$conf.plugin_short_name}}_util_env::result(array("data"=>$res));
        } catch (Exception $e) {
            {{$conf.plugin_short_name}}_util_env::result(array('retcode'=>100010,'retmsg'=>$e->getMessage()));
        }
    }
}
