<?php
{{include file='common/common_head.tpl'}}

{{$table = $api->table}}
abstract class {{$conf.plugin_short_name}}_innerapi_{{$api->name}} extends {{$conf.plugin_short_name}}_class_apibase
{

    public function get_list(){
        return C::t("#{{$conf.plugin_name}}#{{$api->info.table}}")->get_list();
    }

    public function get(){
        $id = $this->check_{{$api->field_reverse_map[$table->pk]}}();
        return C::t("#{{$conf.plugin_name}}#{{$api->info.table}}")->get_by_pk($id);
    }

    public function create(){
        $data = array();
{{foreach $table->columns as $column}}
{{if $column->need_input}}
        ${{$column->name}} = $this->check_{{$api->field_reverse_map[$column->name]}}();
        $data['{{$column->name}}'] = ${{$column->name}};
{{/if}}
{{/foreach}}
        C::t('#{{$conf.plugin_name}}#{{$table->name}}')->create($data);
    }

{{if $table->has_status}}
    public function remove(){
        $id = $this->check_{{$api->field_reverse_map[$table->pk]}}();
        C::t('#{{$conf.plugin_name}}#{{$table->name}}')->remove($id);
    }
{{/if}}

{{foreach $api->fields as $field_name => $field}}
{{$type = $field.column->da_type}}
{{$length = $field.column->length}}
    // map to {{$field.map}}
    protected function check_{{$field_name}}($optional = false){
        if($optional){
            return {{$conf.plugin_short_name}}_util_validate::getOPParameter('{{$field_name}}', '{{$field_name}}', '{{$type}}', {{$length}});
        }
        return {{$conf.plugin_short_name}}_util_validate::getNCParameter('{{$field_name}}', '{{$field_name}}', '{{$type}}', {{$length}});
    }
{{/foreach}}
}
