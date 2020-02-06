<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 12.02.2019
 * Time: 0:03
 */

class ModelTable extends Model
{
    const TABLE_NAME = '{table}';
    const PRIMARY_NAME = 'id';
    public $errors = null;

    function beforeSave () {
        if (!isset($this->errors)) {
            return true;
        } else {
            return false;
        }
        //return !count($this->errors);
    }
    function save () {
        $modelname = get_called_class();
        //echo '!0';
        if ($this->beforeSave()) {
          //  echo ' ' . $modelname::TABLE_NAME . ' ';
            if (!$this->__get(self::PRIMARY_NAME)) {
            //    echo '!';
                $res = App::gI()->db->insert($modelname::TABLE_NAME, $this->__attributes);
                $this->__set($modelname::PRIMARY_NAME, App::gI()->db->id());
                return $res;
            } else {
                return App::gI()->db->update($modelname::TABLE_NAME, $this->__attributes, $this->__get(self::PRIMARY_NAME));
            }
        }
        return false;
    }
    static function models() {

        $results = array();
        $modelname = get_called_class();
        $items = App::gI()->db->query('SELECT * FROM '.$modelname::TABLE_NAME);
        foreach ($items as $item) {
            $model = new $modelname();
            $model->__attributes = $item;
            $results[] = $model;
        }
        return $results;
    }
    static function model($id) {
        $modelname = get_called_class();
        $item = App::gi()->db->query('SELECT * FROM '.$modelname::TABLE_NAME.' WHERE '.$modelname::PRIMARY_NAME.'='. $id);
        $model = new $modelname();
        //print_r($item[0]);
        if (count($item) != 0) $model->__attributes = $item[0];
        return $model;
    }
    static function _models($params)
    {
        /** Переписать функцию в дочерних классах */
        $modelname = get_called_class();
        return $modelname::models();
    }
    static function del($id)
    {
        $modelname = get_called_class();
        App::gi()->db->del($modelname::TABLE_NAME, $id);
        return true;
    }

}