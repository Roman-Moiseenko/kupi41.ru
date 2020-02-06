<?php
const TIME_LIMIT = 1000;

define('ROOT','kupi41.ru/public_html/');
define('ROOT_LOAD', ROOT . 'data/in/');

spl_autoload_register(function ($class_name) {
    $array_path = array('models/', 'controllers/', 'classes/');
    foreach ($array_path as $path)    {
        $path = ROOT . $path . $class_name . '.php';

        if (is_file($path)) {
            include_once ($path);
        }
    }
});

//Ищем файлы с по маске
$loadcatalog = glob(ROOT_LOAD . '*.groups'); //Группы товаров
$loadproduct = glob(ROOT_LOAD . '*.goods'); //Товары
$loadproperty = glob(ROOT_LOAD . '*.property'); //Свойства
$loadorder = glob(ROOT_LOAD . '*.order'); //Свойства

//Загрузка групп
foreach (['loadcatalog','loadproduct','loadproperty','loadorder'] as $__ITEMS__) {
    foreach ($$__ITEMS__ as $file) {
        $dataarray = array();
        $fp = fopen($file, 'rt');         // Считываем данные
        if ($fp) {
            while (!feof($fp)) {
                $dataarray[] = rtrim(fgets($fp));
            }
        }
        fclose($fp);
        //Лог загрузки
        $file_log = fopen(ROOT . 'logdata.txt', 'a');
        fwrite($file_log, $__ITEMS__ . "\n\r");
        fwrite($file_log, $file . "\n\r");
        fwrite($file_log, 'кол-во строк '. count($dataarray) . "\n\r");
        fclose($file_log);

        try {
            if (count($dataarray) != 0) Admin::$__ITEMS__($dataarray); // Запускаем соответствующую процедуру класса Админ
            unlink($file); // Удаляем файл
        } catch (Exception $e) {
            $file_error = fopen(ROOT . 'myerrors_load.txt', 'a');
            fwrite($file_error, $__ITEMS__ . "\n\r");
            fwrite($file_error, $file . "\n\r");
            fwrite($file_error, 'Файл '. $e->getFile() . ' строка ' . $e->getLine() . ' текст - '
                . $e->getMessage() . "\n\r" . $e->getCode() . "\n\r");
            foreach ($dataarray as $item) {
             fwrite($file_error, $item . "\n\r");
            }
            fclose($file_error);
        }

    }
}
