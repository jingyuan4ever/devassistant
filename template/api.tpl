<?php
{{include file='common/common_head.tpl'}}

{{$table = $api->table}}
class {{$api->name}} extends {{$conf.plugin_short_name}}_innerapi_{{$api->name}}
{

}

$api = new {{$api->name}}();
$api->execute();