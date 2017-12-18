<?php
{{include file='common/common_head.tpl'}}

{{$table = $api->table}}
class {{$api->name}} extends {{$conf.plugin_short_name}}_innerapi_{{$api->name}}
{
	public function __construct()
	{
        $this->actionList = array(
{{foreach $api->allowed_interfaces as $interface_name => $priv}}
{{if $interface_name == 'remove' && !$table->has_status}}
{{continue}}
{{/if}}
            '{{$interface_name}}' => array({{join(',', $priv)}}),
{{/foreach}}
        );
    }
}

$api = new {{$api->name}}();
$api->execute();