<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class da_class_table extends discuz_table
{
	protected $_field_list;

	public function get_list($fields, $conditions, $orders, $offset = 0, $limit = 20){
		if(empty($fields)){
			$fields = $this->_field_list;
		}
		if(empty($fields)){
			return array();
		}
		$sql = "SELECT ";
		foreach ($fields as $index => $field) {
			$fields[$index] = DB::quote_field($field);
		}
		$sql.=join(',', $fields)." FROM {$this->_table}";
		$sql.= " WHERE ";
		if (empty($conditions)) {
			$sql.= '1';
		} elseif (is_array($conditions)) {
			$sql.= DB::implode($conditions, ' AND ');
		} else {
			$sql.= $conditions;
		}
		if (!empty($orders)) {
			$sql.=" ORDER BY";
		}
		foreach ($orders as $field => $dir){
			$sql.=DB::order($field, $dir);
		}
		$sql.=DB::limit($offset, $limit);
		return DB::fetch_all($sql);
	}

	public function get_by_pk($id){
		return $this->fetch($id);
	}

}