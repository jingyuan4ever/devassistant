<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once "autoloader.php";

$autoloader = new da_generator_autoloader();
$autoloader->render();

$index = new da_generator_index();
$index->render();

$portal = new da_generator_portal();
$portal->render();

$classes = array(
	'apibase',
	'table',
);
foreach ($classes as $className) {
	$class = new da_generator_class($className);
	$class->render();
}

$utils = array(
	'env',
	'validate',
);
foreach ($utils as $utilName) {
	$util = new da_generator_util($utilName);
	$util->render();
}

foreach (da_util_conf::getConf('api') as $apiName => $info) {
	$api = new da_generator_api($apiName);
	$api->render();
	$inner_api = new da_generator_innerapi($apiName);
	$inner_api->render();
}

foreach (da_util_conf::getConf('table') as $tableName){
	$table = new da_generator_table($tableName);
	$table->render();
	$table = new da_generator_innertable($tableName);
	$table->render();
}

$install = new da_generator_install();
$install->render();

da_util_file::mv_output();

//echo <<<EOF
//<html>
//	<head>
//		<title>DevAssistant</title>
//	</head>
//	<link>
//		<a href="http://www.baidu.com" target="_blank">baidu</a><br/>
//	</body>
//</html>
//EOF;
