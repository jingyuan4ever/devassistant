<?php
{{include file='common/common_head.tpl'}}

class {{$conf.plugin_short_name}}_innertable_{{$table->name}} extends {{$conf.plugin_short_name}}_class_table{
    public function __construct(){
		$this->_table = '{{$table->name}}';
        $this->_pk = '{{$table->pk}}';
        $this->_pre_cache_key = '{{$table->name}}_';
        $this->_field_list = array(
{{foreach $table->columns as $column}}
            '{{$column->name}}',
{{/foreach}}
        );
        parent::__construct();
    }

{{foreach $table->functions as $function}}
{{if $function.type == "get"}}
    {{$function.signature}}
    {
        $conditions = array();
{{foreach $function.columns as $column}}
        if(!empty(${{$column->name}})){
            $conditions['{{$column->name}}'] = ${{$column->name}};
        }
{{/foreach}}
        if(!empty($extraConditions)){
            $conditions = array_merge($conditions, $extraConditions);
        }
        return $this->get_list(null, $conditions, $order, $offset, $limit);
    }
{{/if}}

{{if $function.type == "update"}}
    {{$function.signature}}
    {
        $conditions = array();
{{foreach $function.columns as $column}}
        if(!isset(${{$column->name}})){
            throw new Exception(__function__." needs condition {{$column->name}}!");
        }
{{/foreach}}
        if(!empty($extraConditions)){
            $conditions = array_merge($conditions, $extraConditions);
        }
        return $this;
    }
{{/if}}
{{/foreach}}

    public function create($data)
    {
{{foreach $table->check_column_names as $column}}
        if(empty($data['{{$column}}'])){
            throw new Exception(__function__." needs param {{$column}}!");
        }
{{/foreach}}
        return parent::insert($data, true);
    }

{{if $table->has_status}}
    public function remove($id)
    {
        $data['status'] = 0;
        return parent::update($id, $data);
    }
{{/if}}
}