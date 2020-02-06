<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 11.02.2019
 * Time: 0:09
 */

class Registry
{
    private $data = array();
    function __construct($data = array())
    {
        $this->data = $data;
    }

    function __get($name){
        return isset($this->data[$name])?$this->data[$name]:null;
    }
    function __set($name,$value){
        $this->data[$name] = $value;
    }
}