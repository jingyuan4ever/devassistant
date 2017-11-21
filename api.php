<?php
/**
 * api入口
 **/
chdir("../../../");
require_once './source/class/class_core.php';
require_once "autoloader.php";
$discuz = C::app();
$discuz->init();

$modules = array (
	'dbmeta',
	'table',
);

if(!isset($_GET['module']) || !in_array($_GET['module'], $modules)) {
	module_not_exists();
}

$module  = $_GET['module'];
$version = !empty($_GET['version']) ? intval($_GET['version']) : 1;
while ($version>=1) {
	$apifile = DEV_ASSISTANT_PLUGIN_PATH."/api/$version/$module.php";

	if(file_exists($apifile)) {
		require_once $apifile;
		exit(0);
	}
	--$version;
}
module_not_exists();

function module_not_exists()
{
	header("Content-type: application/json");
	echo json_encode(array('error' => 'module_not_exists'));
	exit;
}