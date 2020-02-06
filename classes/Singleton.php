<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 10.02.2019
 * Time: 23:45
 */

abstract class Singleton{
    // в $_aInstances будут хранится все
    // экзмепляры всех классов наследующих класс Singleton
    private static $_aInstances = array();
    public static function getInstance($className=false) {

        $sClassName = ($className===false)?get_called_class():$className; // название класса экземпляр которого мы запросили

        if(class_exists($sClassName) ){
            if(!isset( self::$_aInstances[$sClassName] ) )
                // если экземпляр класса еще не был создан, создаем его
                self::$_aInstances[$sClassName] = new $sClassName();
            // возвращаем один экземпляр
            return self::$_aInstances[$sClassName];
        } else {
            header('Location: /site/_404/');
            //throw new Except('Class '.get_called_class().'  no exist!');
            }
    }
    // более удобный вызов метода getInstance
    public static function gI($className=false) {
        return self::getInstance($className);
    }
    // так как нам нужен лишь один экземпляр любого класса,
    // то копировать объекты нам не потребуется
    final private function __clone(){}
    private function __construct(){}
}