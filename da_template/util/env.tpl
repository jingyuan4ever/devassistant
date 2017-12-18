<?php
{{include file='../common/common_head.tpl'}}

class {{$conf.plugin_short_name}}_util_env{

	// get discuz site's url(discuz root)
	public static function get_site_url(){
		global $_G;
		$_G['siteurl'] = preg_replace("/source\/plugin\/{{$conf.plugin_name}}/i","", $_G['siteurl']);
		return rtrim($_G['siteurl'], '/');
	}

	public static function result(array $result,$json_header=true)
	{
		header("Content-type: application/json");
		if (!isset($result['retcode'])) {
			$result['retcode'] = 0;
		}
		if (!isset($result['retmsg'])) {
			$result['retmsg'] = 'succ';
		}
		if ($json_header) {
			header("Content-type: application/json");
		}
		echo json_encode($result);
		exit;
	}
}