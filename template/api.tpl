<?php
{{include file='common/common_head.tpl'}}

{{$table = $api->table}}
class {{$api->name}} extends {{$conf.plugin_short_name}}_innerapi_{{$api->name}}
{
	public function __construct()
	{
        $this->actionList = array(
            'get_list' => array(),
            'get' => array(),
            'create' => array(),
        );
    }
}

$api = new {{$api->name}}();
$api->execute();