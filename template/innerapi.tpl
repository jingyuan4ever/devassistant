<?php
{{include file='common/common_head.tpl'}}

{{$table = $api->table}}
class {{$conf.plugin_short_name}}_innerapi_{{$api->name}} extends {{$conf.plugin_short_name}}_class_apibase
{
	public function __construct()
	{
		$this->actionList = array(
            'get_list' => array(),
            'get' => array(),
        );
    }

    public function get_list(){
        return C::t("#{{$conf.plugin_name}}#{{$api->info.table}}")->get_list();
    }

    public function get(){
        $id = $this->check_{{$table->pk}}();
        return C::t("#{{$conf.plugin_name}}#{{$api->info.table}}")->get_by_pk($id);
    }

{{foreach $table->columns as $column}}
    private function check_{{$column->name}}($optional = false){
        if($optional){
            return {{$conf.plugin_short_name}}_util_validate::getOPParameter('{{$column->name}}', '{{$column->name}}', '{{$column->da_type}}', {{$column->length}});
        }
        return {{$conf.plugin_short_name}}_util_validate::getNCParameter('{{$column->name}}', '{{$column->name}}', '{{$column->da_type}}', {{$column->length}});
    }
{{/foreach}}
}
