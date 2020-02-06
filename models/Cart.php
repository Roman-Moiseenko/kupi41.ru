<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 20.02.2019
 * Time: 8:31
 */

class Cart extends ModelTable
{
    const TABLE_NAME = 'cart';
    const OPERATION_INC = 1;
    const OPERATION_DEC = 2;
    const OPERATION_REP = 3;
    //const PRIMARY_NAME = 'user';
    public $safe = array('id', 'user', 'datecart', 'products');
    public $pay = null;
    //json-products = {"productid" => "count"}

    public $_products = array();

    static public function _models($user)
    {
        $modelname = get_called_class();
        $item = App::gi()->db->query('SELECT * FROM '.$modelname::TABLE_NAME.' WHERE user ='. $user);
        $model = new $modelname();
        if (count($item) != 0) {
            $model->__attributes = $item[0];
            $model->_products = (array)json_decode($model->products);
        } else {
            $model->user = $user;
        }
        return $model;
    }
    static public function model($id)
    {
        $model = parent::model($id);
        if (isset($model->id)) {
            $model->_products = (array)json_decode($model->products);
        }
        return $model;
    }

    public function change($productid, $operation, $count = 0)
    {
        if (!isset($this->_products[$productid])) $this->_products[$productid] = 0;
        switch ($operation){
            case self::OPERATION_INC :
                $this->_products[$productid]++;
                break;
            case self::OPERATION_DEC :
                $this->_products[$productid]--;
                break;
            case self::OPERATION_REP :
                $this->_products[$productid] = $count;
                break;
        }
        //Проверка на не превышение остатков товара
        $prod = Product::model($productid);
        if ($this->_products[$productid] > $prod->remains) $this->_products[$productid] = $prod->remains;

        if ($this->_products[$productid] <= 0) unset($this->_products[$productid]);
        $this->products = json_encode($this->_products);

        $this->save();
    }

    public function save()
    {
        $this->datecart = time();//date('Y-m-d H:i:s');
        //print_r($this->datecart);
        //die($this->datecart);
        return parent::save();
    }

    public function count()
    {
        $count = 0;
        foreach ($this->_products as $_count) {
            $count += $_count;
        }
        return $count;
    }
    public function sum()
    {
        $sum = 0;
        foreach ($this->_products as $id => $count) {
            $prod = Product::model($id);
            $sum += $prod->price * $count;
        }
        return $sum;
    }

}