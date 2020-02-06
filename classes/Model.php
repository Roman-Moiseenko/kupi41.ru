<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 11.02.2019
 * Time: 23:11
 */

class Model
{
    private $data = null;
    public $safe = array();
    function __construct()
    {
        $this->data = new stdClass();
    }
    function __set($name, $value)
    {
        if ($name === '__attributes') {
            foreach ($value as $key => $val){
                $this->__set($key, $val);
            }
        }
        if (method_exists($this, 'set' . $name)) {
            return call_user_func(array($this, 'set' . $name), $value);
        }
        if (in_array($name, $this->safe)) {
            $this->data->$name = $value;
        }
    }
    function __get($name)
    {
        if ($name==='__attributes') {
            return $this->data;
            }
        if (method_exists($this, 'get' . $name)) {
            return call_user_func(array($this, 'get' . $name));
        }
        return property_exists($this->data, $name) ? $this->data->$name : null;
    }

}