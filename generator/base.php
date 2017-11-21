<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once DEV_ASSISTANT_PLUGIN_PATH . "/libs/smarty/Smarty.class.php";

abstract class da_generator_base
{
	protected $_tpl_name;
	protected $_smarty;
	protected $_force_update = true;

	function __construct()
	{
		$this->_smarty = new \Smarty();
		$this->_smarty->left_delimiter = '{{';
		$this->_smarty->right_delimiter = '}}';
		$this->_smarty->setTemplateDir(da_util_conf::get_template_dir());
		$this->_smarty->setCompileDir(da_util_conf::get_template_c_dir());
		$this->_smarty->setCacheDir(da_util_conf::get_template_dir());
		$this->_smarty->setConfigDir(da_util_conf::get_template_dir());
		$this->_smarty->assign('conf', da_util_conf::getAll());
	}

	protected function get_output_filename(){
		return $this->_tpl_name.".php";
	}

	protected function get_output_dir(){
		return da_util_conf::get_plugin_output_dir();
	}

	public function render(){
		$data = $this->_smarty->fetch($this->_tpl_name.".tpl");
		da_util_file::put_file_data($this->get_output_filename(), $data, $this->get_output_dir(), $this->_force_update);
	}
}