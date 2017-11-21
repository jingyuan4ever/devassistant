<?php

class da_util_conf
{
	const DEV_ASSISTANT_TEMPLATE_DIR = DEV_ASSISTANT_PLUGIN_PATH."/template";
	const DEV_ASSISTANT_OUTPUT_DIR = DEV_ASSISTANT_PLUGIN_PATH."/output";

	private static $conf = array(
		'plugin_name' => 'test',
		'plugin_name_upper_case' => 'TEST',
		'plugin_short_name' => 'tt',
		'api_version' => 1,
		'table' => array(
			'qudati_quiz',
			'qudati_question',
		),
		'api' => array(
			'quiz' => array(
				'table' => 'qudati_quiz',
				'fields' => array(
					'id' => array(
						'map' => 'id',
						'need_encode' => true,
					),
					'n' => array(
						'map' => 'name',
					),
				),
				'allowed_interfaces' => array(
					'*',
				),
			),
		),
	);

	public static function getConf($name){
		return self::$conf[$name];
	}

	public static function getAll(){
		return self::$conf;
	}

	public static function get_plugin_name(){
		return self::getConf("plugin_name");
	}

	public static function get_plugin_output_dir(){
		return DEV_ASSISTANT_PLUGIN_PATH.'/output/'.self::get_plugin_name();
	}

	public static function get_template_dir(){
		return DEV_ASSISTANT_PLUGIN_PATH.'/template';
	}

	public static function get_template_c_dir(){
		return DEV_ASSISTANT_PLUGIN_PATH.'/template_c';
	}
}