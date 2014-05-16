<?php

use system\routing\routing;
use system\language\language;

ini_set('display_errors', 1);

error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

header("Content-Type: text/html; charset=utf-8");

// * ********************* Автозагрузчик классов ***************************** 
require_once "system/core/autoloader/autoloader.php";

spl_autoload_register('system\core\autoloader\autoloader::autoload');

// ***************************************************************
require_once 'system/core/core.php';
core::request_url();

// ************************ определение языка
language::$lang_def = "ru";
language::$languages = array('ru' => "Русский", 'en' => "English");

language::languageDetect();

// * ********************** авторизация и сессия ***************************** 
//ini_set ("session.use_cookies", 0);
ini_set("session.use_trans_sid", 1);
ini_set("session.use_only_cookies", 0);

routing::$routes = array(
    'vkgdt' => array(
        'name' => "vkgdt",
        'rule' => "vkgdt",
        'defaults' => array('controller' => "api", 'action' => "social")
    ),
    'default' => array(
        'name' => "default",
        'rule' => "{controller}/{action}/{id}",
        'defaults' => array('controller' => "home", 'action' => "main")
    )
);

routing::$url =  core::$url;

routing::getRoute();

echo core::$url;
echo "<br>";
echo routing::$controller;
echo "<br>";
echo routing::$action;
echo "<br>";
print_r(routing::$values);
echo "<br>";


$module_path = $_SERVER['DOCUMENT_ROOT'] . '/module/' . routing::$controller . '/controller.php';

if (file_exists($module_path))
{
    require_once $module_path;
    
    $controller = new controller();
    
    echo $controller->run();
}
else
{
    echo "N";
}

//echo $module_path;
//echo routing::getLink("api","hoppi","vkgdt",array("shortname" => "gora"));