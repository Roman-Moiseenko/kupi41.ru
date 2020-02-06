<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 24.02.2019
 * Time: 21:32
 */

class Extproduct extends Product
{
    const TABLE_NAME = 'product';
    public $safe = array('id', 'parentid', 'name', 'descr', 'techinfo', 'price', 'remains', 'unit', 'recom', 'imagefile', 'count', 'priceorder');
    public function save()
    {
        throw new Except('Нельза сохранить объект');
    }

    public static function _models($type = self::PARAM_ALL, $param = 0)
    {
        $tmp_products = (array)json_decode($param, true);
        $param = implode(',', array_keys($tmp_products));
        $products = parent::_models(Product::PARAM_IDS, $param);
        foreach ($products as $items) {
            $result[$items->id] = new Extproduct();
            $result[$items->id]->__attributes = $items->__attributes;
            $result[$items->id]->imagefile = $items->imagefile;
            $result[$items->id]->count = $tmp_products[$items->id]['count'];
            $result[$items->id]->priceorder = $tmp_products[$items->id]['price'];
        }
        return $result;

    }

}