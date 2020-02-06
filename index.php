<?php
ini_set('display_errors',1);
error_reporting(E_ALL);

define('ROOT',dirname(__FILE__) . '/');
require __DIR__ . '/classes/lib/autoload.php';
if(session_id() == '') {session_start();}

spl_autoload_register(function ($class_name) {
    $array_path = array('models/', 'controllers/', 'classes/');
    foreach ($array_path as $path)    {
        $path = ROOT . $path . $class_name . '.php';
        
        if (is_file($path)) {
            include_once ($path);
        }
    }
});
setlocale(LC_ALL, 'ru_RU', 'ru_RU.UTF-8', 'ru', 'russian');
App::gI()->start();