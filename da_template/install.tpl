<?php
{{foreach $create_sql as $table_name => $sql}}
$table = DB::table('{{$table_name}}');
$sql = <<<EOF
{{$sql}}
EOF;
runquery($sql);

{{/foreach}}