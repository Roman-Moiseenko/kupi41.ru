<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 13.02.2019
 * Time: 10:43
 */

class Order extends ModelTable
{

    const ORDER_NO_PAY = 0; //оплатит на месте
    const ORDER_INVOICE = 1; //выписан счет (для фирм)
    const ORDER_PAY = 2; //Оплачен картой
    const ORDER_READY = 3; //готов к выдаче
    const ORDER_FINISH = 4; //выдан
    const ORDER_CANCEL = 5;//ануллирован
    const ORDER_ALL = 999;

    public $paydoc = null;
    static public $order_type = array('не оплачен', 'выставлен счет', 'оплачен электронно', 'готов к выдаче', 'завершен', 'аннулирован');
    public $safe = array('id', 'user', 'dateorder', 'products', 'orderstatus', 'delivery', 'comment', 'total', 'datefinish', 'paydocid');
    //json-products = {"productid" => ("count"=>xxx, "price"=>yyy)}
    const TABLE_NAME = 'productorder';
    public function __construct($typepaydoc = null)
    {

        parent::__construct();
        if ($typepaydoc != null)
            $this->paydoc = new Paydoc($typepaydoc);
        //TODO !!!!
    }

    public function save($to1C = true)
    {
        if ($this->dateorder == null) $this->dateorder = time(); //date('Y-m-d H:i:s');
        parent::save();
        if ($to1C) $this->createOrderTo1C();
    }
    static public function model($id)
    {
        $model = parent::model($id);
        $model->paydoc = Paydoc::model($model->id);
        return $model;
    }

    static public function _models($user = 0, $params = array())
    {
        $where = array();
        if ($user != 0) $where[] = 'user = ' . $user;
        if (count($params) != 0 || $params[0] != self::ORDER_ALL) $where[] = 'orderstatus IN (' . implode(', ', $params) . ') ORDER BY dateorder DESC';
        $sql = 'SELECT * FROM ' . self::TABLE_NAME;
        if (count($where) > 0) $sql .= ' WHERE ' . implode(' AND ', $where);
        //echo $sql;

        $items = App::gI()->db->query($sql);
        $results = array();
        foreach ($items as $item) {
            $model = new Order();
            $model->__attributes = $item;
            $model->paydoc = Paydoc::model($model->id);
            $results[] = $model;
        }
        return $results;
    }

    public function createOrderTo1C()
    {
        $user = User::model($this->user);
        $products = json_decode($this->products, true);

        $file = ROOT . App::gI()->config->dataout . $this->id . '.order';
        $handle = fopen($file, 'wt');
        if ($user->firm <> '') {
            $firm = json_decode($user->firm, true);
            $str = implode(';', $firm);
        } else {
            $str = $user->id . ';'
                 . $user->firstname . ' ' . $user->secondname . ' ' . $user->lastname .';'
                 . $user->phone . ';'
                 . $user->address . ';'
                 . $user->email;
        }
        fwrite($handle, $str."\r\n");
        fwrite($handle, $this->id.';' . $this->orderstatus.';'.$this->delivery.';'.$this->comment.';'.date('YmdHis', $this->dateorder)."\r\n");
        foreach ($products as $idd => $items)
        {
            fwrite($handle, Decode::getCode($idd) . ';' . $items['count'] . ';' . $items['price']."\r\n");
        }
        fclose($handle);
        return true;
    }

}