<?php

require_once('configuration.php');

date_default_timezone_set($C->DEF_TIMEZONE);

if($C->DEBUG_MODE){
	ini_set('display_errors', true);
	ini_set('display_startup_errors', true);
	error_reporting(E_ALL);
}else{
	ini_set('display_errors', false);
	ini_set('display_startup_errors', false);
}

ini_set('memory_limit', '-1');

$SCRIPT_START_TIME = time();

/* add helpers functions */
$helpers_list = scandir($C->path_helpers);
foreach($helpers_list as $helper_file){
	if(substr($helper_file,0,7)=='helper_')
		require_once($C->path_helpers.$helper_file);
}
/* add classes */
$classes_list = scandir($C->path_classes);
foreach($classes_list as $class_file){
    if(substr($class_file,0,6)=='class_' && substr($class_file,-4,4)=='.php')
        require_once($C->path_classes.$class_file);
}

//start classes
$cache = new cache;
$db = new mysql($C->database_host, $C->database_username, $C->database_password, $C->database_name, $C->database_extension);


session_start();

$network	= new network();
$network->LOAD();

$system_date	= new jDateTime();
$core		= new core();
$user		= new user();
ob_start('ob_gzhandler', 8);//gzip
$page		= new page();
$phone		= new phone();
$api		= new api();
$page->LOAD();