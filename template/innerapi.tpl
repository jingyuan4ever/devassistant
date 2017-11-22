<?php
{{include file='common/common_head.tpl'}}

{{$table = $api->table}}
{{$allowed_interfaces = $api->allowed_interfaces}}
abstract class {{$conf.plugin_short_name}}_innerapi_{{$api->name}} extends {{$conf.plugin_short_name}}_class_apibase
{

{{if isset($allowed_interfaces['get_list'])}}
    public function get_list(){
        $data = C::t("#{{$conf.plugin_name}}#{{$api->info.table}}")->get_list();
{{if $field.need_encode}}
        $this->encode_data($data, 2);
{{/if}}
        return $data;
    }
{{/if}}

{{if isset($allowed_interfaces['get'])}}
    public function get(){
        $id = $this->check_{{$api->field_reverse_map[$table->pk]}}();
        $data = C::t("#{{$conf.plugin_name}}#{{$api->info.table}}")->get_by_pk($id);
{{if $field.need_encode}}
        $this->encode_data($data);
{{/if}}
        return $data;
    }
{{/if}}

{{if isset($allowed_interfaces['create'])}}
    public function create(){
        $data = array();
{{foreach $table->columns as $column}}
{{if $column->need_input}}
{{if isset($api->field_reverse_map[$column->name])}}
        ${{$column->name}} = $this->check_{{$api->field_reverse_map[$column->name]}}();
        $data['{{$column->name}}'] = ${{$column->name}};
{{else}}
        //$data['{{$column->name}}'] = ${{$column->name}};
{{/if}}
{{/if}}
{{/foreach}}
        C::t('#{{$conf.plugin_name}}#{{$table->name}}')->create($data);
    }
{{/if}}

{{if isset($allowed_interfaces['remove']) && $table->has_status}}
    public function remove(){
        $id = $this->check_{{$api->field_reverse_map[$table->pk]}}();
        C::t('#{{$conf.plugin_name}}#{{$table->name}}')->remove($id);
    }
{{/if}}

{{foreach $api->fields as $field_name => $field}}
{{if $field.need_encode}}
{{$type = "string"}}
{{$length = 40}}
{{else}}
{{$type = $field.column->da_type}}
{{$length = $field.column->length}}
{{/if}}
    // map to {{$field.map}}
    protected function check_{{$field_name}}($optional = false){
        if($optional){
            $ret = {{$conf.plugin_short_name}}_util_validate::getOPParameter('{{$field_name}}', '{{$field_name}}', '{{$type}}', {{$length}});
        }else{
            $ret = {{$conf.plugin_short_name}}_util_validate::getNCParameter('{{$field_name}}', '{{$field_name}}', '{{$type}}', {{$length}});
        }
{{if $field.need_encode}}
        $ret = authcode($ret, 'DECODE', {{$conf.plugin_short_name}}_util_conf::PRIVATE_KEY);
        if($ret == ''){
            throw new Exception("Unknown param {{$field_name}}!");
        }
{{/if}}
        return $ret;
    }
{{/foreach}}

{{if $api->need_encode}}
    private function encode_data(&$data, $dim = 1){
        if($dim != 1 || $dim != 2)
        if($dim == 1){
{{foreach $api->fields as $field_name => $field}}
{{if $field.need_encode}}
            if(isset($data['{{$field.map}}'])){
                $data['{{$field.map}}_code'] = authcode($data['{{$field.map}}'], 'ENCODE', {{$conf.plugin_short_name}}_util_conf::PRIVATE_KEY);
            }
{{/if}}
{{/foreach}}
            return;
        }
        foreach($data as &$line){
            $this->encode_data($line);
        }
    }
{{/if}}

}
