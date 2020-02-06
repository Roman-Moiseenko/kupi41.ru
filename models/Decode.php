<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 15.02.2019
 * Time: 0:33
 */

class Decode extends ModelTable
{
    const TABLE_NAME = 'idcode';
    const PRIMARY_NAME = 'mysql_id';
    public $safe = array(self::PRIMARY_NAME, '1c_code');
    static public function getCode($id)
    {
        $items = App::gI()->db->query('SELECT 1c_code FROM ' . self::TABLE_NAME . ' WHERE ' . self::PRIMARY_NAME . ' = ' . $id);
        return $items[0]['1c_code'];

    }
    static public function getId($code)
    {
        if ($code == '' or $code == '0') return '00';
        //print_r($code);
        //print_r('SELECT ' . self::PRIMARY_NAME . ' FROM ' . self::TABLE_NAME . ' WHERE 1c_code = ' . $code);
        $items = App::gI()->db->query('SELECT ' . self::PRIMARY_NAME . ' FROM ' . self::TABLE_NAME . ' WHERE 1c_code = "' . $code . '"');
        if (count($items) == 0) return false;
        return $items[0][self::PRIMARY_NAME];
    }
    static public function addCode($code)
    {
        $id = App::gI()->db->insert(self::TABLE_NAME, array('1c_code' => $code));
        return $id;
    }


}