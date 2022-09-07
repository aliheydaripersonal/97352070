<?php
$C = new stdclass;

$C->database_type = 'mysqli';
$C->database_name = 'classified';// change this with your own db name
$C->database_username = 'root';// change this with your own db user name
$C->database_password = '';// change this with your own db password
$C->database_host = 'localhost';// change this with your own db host
$C->database_extension = 'mysqli';

//$C->SITE_URL = 'http://192.168.8.100/delivery/';
$C->SITE_URL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST']."/";
$C->SITE_SEARCH_URL = $C->SITE_URL.'blog?q=';
$C->FULL_URI = $_SERVER['REQUEST_URI'];
$C->FULL_URL = trim((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],'/').(strpos($_SERVER['REQUEST_URI'],"?")!==false||strpos($_SERVER['REQUEST_URI'],".")!==false?"":'/');
$C->FULL_URL_WITHOUT_GET = strpos($_SERVER['REQUEST_URI'],"?")==false?$C->FULL_URL:(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST']. substr($_SERVER['REQUEST_URI'],0, strpos($_SERVER['REQUEST_URI'],"?"));
$C->FULL_URL_FOR_PAGING = preg_replace('/\/page:[0-9]+/', '', $C->FULL_URL);

$C->FULL_URL_FOR_PAGING = count($_GET)>0?str_replace("?","{page_counter}/?",$C->FULL_URL_FOR_PAGING):$C->FULL_URL_FOR_PAGING."{page_counter}";

$C->DOMAIN = str_replace(["http://","https://","/"],"",$C->SITE_URL);
$C->VERSION = '1';
$C->DATE_TYPE = 'jalali';

$C->template = "main";

$C->DEF_TIMEZONE = "Asia/Tehran";

$C->SITE_TITLE = "نیازمندی آنلاین";
$C->LANGUAGE = "fa";



$C->path_public = 'public/';
$C->path_public_tmp = $C->path_public."tmp/";
$C->path_media = $C->path_public.'media/'.date("Y").'/'.date("m").'/';
$C->path_thumbnail = $C->path_public.'thumbnail/'.date("Y").'/'.date("m").'/';


$C->path_logs = 'logs/';
$C->path_classes = 'system/classes/';
$C->path_controllers = 'system/controllers/';
$C->path_helpers = 'system/helpers/';
$C->path_templates = 'templates/';
$C->path_languages = 'system/languages/';
$C->path_tmp = 'tmp/';
$C->path_cache = 'cache/';

$C->CACHE_KEYS_PREFIX = 'ComNewCache';
$C->CACHE_MECHANISM = '';
$C->CACHE_EXPIRE_DATE = 6400;

$C->DEBUG_MODE = true;
$C->name_template = 'main';

$C->TYPES = (object)[

];
$C->STATUSES = (object)[
	"post"	=>	[
        "0"=>(object)["label"=>"pending"],
        "1"=>(object)["label"=>"active"],
        "2"=>(object)["label"=>"rejected"],
        "3"=>(object)["label"=>"removed"],
        "4"=>(object)["label"=>"expired"],
    ]
];