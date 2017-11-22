<?php
{{include file='common/common_head.tpl'}}

{{$table = $api->table}}
class {{$conf.plugin_short_name}}_util_conf
{
    const PRIVATE_KEY = '{{$private_key}}';
}
