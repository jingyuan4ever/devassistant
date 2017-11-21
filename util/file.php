<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class da_util_file
{
	public static function get_file_data($fileName, $dir = da_util_env::DEV_ASSISTANT_TEMPLATE_DIR){
		$path = $dir.'/'.$fileName;
		return file_get_contents($path);
	}

	public static function put_file_data($fileName, $data, $dir = da_util_env::DEV_ASSISTANT_OUTPUT_DIR, $forceUpdate = true){
		if(!file_exists($dir)){
			mkdir($dir, 0755, true);
		}
		$path = $dir.'/'.$fileName;
		if(!$forceUpdate){
			$path .= ".protected";
		}
		if(file_exists($path) && !$forceUpdate){
			return true;
		}
		return file_put_contents($path, $data);
	}

	public static function mv_output(){
		$dir = da_util_conf::get_plugin_output_dir();
		self::traverse($dir, 'da_util_file::mv_file');
		$cmd = "rm -rf $dir";
		system($cmd);
	}

	private static function mv_file($filename, $pluginPath = DEV_ASSISTANT_PLUGIN_PATH."/.."){
		if(!file_exists($filename)){
			return;
		}
		$newFilename = $filename;
		$protected = false;
		$extension = self::get_extension($filename);
		if($extension == 'protected'){
			$protected = true;
			$newFilename = self::strip_extension($filename);
		}
		$pluginFile = str_replace(DEV_ASSISTANT_PLUGIN_PATH."/output", $pluginPath, $newFilename);
		if($protected && file_exists($pluginFile)){
			return;
		}
		$pluginDir = dirname($pluginFile);
		$cmd = "mkdir -p $pluginDir\n";
		system($cmd);
		$cmd = "cp -f $filename $pluginFile\n";
		system($cmd);
	}

	private static function traverse($dirPath, $fileFunc = NULL, $dirFunc = NULL){
		if(is_file($dirPath)){
			if(empty($fileFunc)){
				return;
			}
			call_user_func_array($fileFunc, array($dirPath));
			return;
		}
		if(!empty($dirFunc)){
			call_user_func_array($dirFunc, array($dirPath));
		}
		$dir = dir($dirPath);
		while($file = $dir->read()){
			if($file == '.' || $file == '..'){
				continue;
			}
			$file = "$dirPath/$file";
			self::traverse($file, $fileFunc);
		}
	}

	private static function get_extension($filename){
		return substr($filename, strrpos($filename, '.')+1);
	}

	private static function strip_extension($filename){
		return substr($filename, 0, strrpos($filename, '.'));
	}
}