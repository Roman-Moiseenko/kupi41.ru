<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 11.02.2019
 * Time: 23:45
 */

class Db
{
    private $connect_id = null;
    private $result_id = null;
    public function connect($config)
    {
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']}";
        $this->connect_id = new PDO($dsn, $config['user'], $config['password']);
        $this->connect_id->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if(!$this->connect_id) return false;

    }
    public function del($tablename, $id)
    {
        $sql = 'DELETE FROM '.$tablename.' WHERE id = :id';
        $result = $this->connect_id->prepare($sql);

        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->execute();
    }
    public function insert($tablename, $param)
    {
        $set = $this->arrayKeysToSet($param);
        $sql = 'INSERT INTO '.$tablename.' SET ' . $set;
        $result = $this->connect_id->prepare($sql);
        //echo ' SQL = '. $sql . '<br>';
        if (is_array($param) or is_object($param)) {
            foreach ($param as $key => &$val) {
                //echo $key . ' = ' . $val . '<br>';
                $result->bindParam(':'.$key, $val, PDO::PARAM_STR);
            }
        }


        if ($result->execute()) {
            $this->result_id = $this->connect_id->lastInsertId();
            return $this->result_id;//true;
        } else return false;
    }
    public function update($tablename, $param, $id)
    {
        $set = $this->arrayKeysToSet($param);
        if (is_numeric($id)) {$where = 'id = :id';} else {$where = $id;} //Если id число, то условие по id, иначе условие уже в id
        $sql = 'UPDATE ' . $tablename . ' SET ' . $set . ' WHERE ' . $where;
        $result = $this->connect_id->prepare($sql);
        //$result->bindParam(':tablename', $tablename, PDO::PARAM_STR);
        if (is_numeric($id)) {$result->bindParam(':id', $id, PDO::PARAM_INT);}
        if (is_array($param) or is_object($param)) {
            foreach ($param as $key => &$val) {
                $result->bindParam(':'.$key, $val, PDO::PARAM_STR);
            }
        }
        return $result->execute();
    }

    private function arrayKeysToSet($values)
    {
        $ret = '';
        if (is_array($values) or is_object($values)){
            foreach($values as $key => $value){
                if(!empty($ret)) $ret .= ', ';
                if (!is_numeric($key)) {
                    $ret .= $key . " = :". $key;
                } else {
                    $ret .= $value;
                }
            }
        } else {
            $ret = $values;
        }
        return $ret;
    }
    public function id()
    {
        return $this->result_id;
    }

    public function query($sql)
    {
        $result = $this->connect_id->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    public function queryPrepare($sql, $param)
    {
        //echo $sql . '<br>';

        $result = $this->connect_id->prepare($sql);
        if (is_array($param) or is_object($param)) {
            foreach ($param as $key => &$val) {
                $p = preg_replace('/\s/', '', ':'.$key);
               // echo 'key - ' . $p . '  val - ' . $val;
                $result->bindParam($p, $val, PDO::PARAM_STR);
            }
        }
        $result->execute();

        $rt = $result->fetchAll(PDO::FETCH_ASSOC);
        //print_r($rt);
        return $rt;//$result->fetchAll(PDO::FETCH_ASSOC);
    }
}