<?php
{{include file='common/common_head.tpl'}}

require_once "autoloader.php";

echo <<<EOF
<html>
<head>
    <title>{{$conf.plugin_name_upper_case}}</title>
</head>
<link>
{{foreach $conf.api as $api => $info}}
<a href="{{$site_url}}/source/plugin/{{$conf.plugin_name}}/index.php?module={{$api}}&action=get_list" target="_blank">{{$api}}-list</a><br/>
{{/foreach}}
</body>
</html>
EOF;
