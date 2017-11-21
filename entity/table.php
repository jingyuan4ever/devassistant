<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class da_entity_table{
	public static $table_pool = array();

	public $pk = null;
	public $is_ai = false;
	public $name;
	public $columns = array();
	public $check_column_names = array();
	public $indexes = array();
	public $functions = array();

	public static function get_table($tableName){
		if(empty(self::$table_pool[$tableName])){
			self::$table_pool[$tableName] = new self($tableName);
		}
		return self::$table_pool[$tableName];
	}

	private function __construct($tableName)
	{
		$this->name = $tableName;
		$columns = C::m("#devassistant#dbmeta")->describe_table($tableName);
		foreach ($columns as $column) {
			$this->add_column($column);
		}
		$indexes = c::m("#devassistant#dbmeta")->get_index($tableName);
		foreach ($indexes as $index) {
			$this->add_index($index);
		}
		foreach ($this->indexes as $index) {
			$this->add_get_function($index);
		}
		// discuz有缓存，暂不考虑条件更新
//		foreach ($this->indexes as $index) {
//			$this->add_update_function($index);
//		}
		$this->add_insert_function();
	}

	private function add_column($column){
		if($column['Key'] == 'PRI'){
			$this->pk = $column['Field'];
		}
		if($column['Extra'] == 'auto_increment'){
			$this->is_ai = true;
		}
		$this->columns[$column['Field']] = new da_entity_column($column);
		$column = $this->columns[$column['Field']];
		if($column->not_null && $column->default == NULL && $column->extra != 'auto_increment'){
			$this->check_column_names[] = $column->name;
		}
	}

	private function add_index($index)
	{
		if (empty($this->indexes[$index['Key_name']])) {
			$this->indexes[$index['Key_name']] = new da_entity_index($this, $index);
		} else {
			$this->indexes[$index['Key_name']]->add_column($index);
		}
	}

	private function add_get_function($index){
		$signature = 'public function get_by';
		foreach ($index->columns as $column) {
			$signature.="_{$column->name}";
		}
		$signature.='(';
		$sp = '';
		foreach ($index->columns as $column) {
			$signature.=$sp.'$'.$column->name;
			$sp = ', ';
		}
		$signature.=', $extraConditions, $order, $offset = 0, $limit = 20)';
		$this->functions[] = array(
			'signature' => $signature,
			'columns' => $index->columns,
			'type' => 'get',
		);
	}

	private function add_update_function($index){
		$signature = 'public function update_by';
		foreach ($index->columns as $column) {
			$signature.="_{$column->name}";
		}
		$signature.='(';
		$sp = '';
		foreach ($index->columns as $column) {
			$signature.=$sp.'$'.$column->name;
			$sp = ', ';
		}
		$signature.=', $extraConditions)';
		$this->functions[] = array(
			'signature' => $signature,
			'columns' => $index->columns,
			'type' => 'update',
		);
	}

	private function add_insert_function(){
		$signature = 'public function insert_one($data)';
		$this->functions[] = array(
			'signature' => $signature,
			'check_columns' => $this->check_column_names,
			'type' => 'insert',
		);
	}


}