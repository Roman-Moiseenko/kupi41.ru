<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 15.02.2019
 * Time: 0:13
 */

class Admin extends ModelTable
{
    const TIME_LIMIT = 0;
    public function save()
    {
        throw new Except('Нельза сохранить объект');
    }

    //TODO вынести в класс админские функции

    static public function loadcatalog($array_data)
    {
        //print_r($array_data);
        set_time_limit(self::TIME_LIMIT);
        foreach ($array_data as $item) {
            $category = explode(';', $item);
            $parentid = Decode::getId($category[2]);
            if($parentid != false)
            {
                $id = Decode::getId($category[0]);
                if($id == false){
                    $id = Decode::addCode($category[0]);
                    App::gI()->db->insert('catalog', array('id' => $id, 'name' => $category[1], 'parentid' => $parentid));
                } else {
                    App::gI()->db->update('catalog', array('name' => $category[1], 'parentid' => $parentid), $id);
                }
            } else {
                $errors[] = $item;
            }
        }
        if (isset($errors) && is_array($errors)) {
            self::loadcatalog($errors);
        }
    }
    static public function loadproduct($array_data)
    {
        set_time_limit(self::TIME_LIMIT);
        foreach ($array_data as $item) {
            $products = explode(';', $item);
            $parentid = Decode::getId($products[1]);
            if($parentid != false)
            {
                $id = Decode::getId($products[0]);
                $products[3] = str_replace(',', '.', $products[3]);

                $products[4] = str_replace(',', '.', $products[4]);
                if ($products[4] == '') $products[4] = '0';
                if($id == false){
                    $id = Decode::addCode($products[0]);
                    App::gI()->db->insert(Product::TABLE_NAME, array('id' => $id, 'parentid' => $parentid,
                                                  'name' => $products[2], 'price' => $products[3], 'remains' => $products[4], 'unit' => $products[5], 'descr' => $products[6]));

                } else {
                    App::gI()->db->update(Product::TABLE_NAME, array('parentid' => $parentid,
                        'name' => $products[2], 'price' => $products[3], 'remains' => $products[4], 'unit' => $products[5], 'descr' => $products[6]), $id);

                }
            } else {
                $errors[] = $item;
            }
        }

    }
    static public function loadproperty($array_data)
    {
        set_time_limit(self::TIME_LIMIT);
        foreach ($array_data as $item) {
            $property = explode(';', $item);
            $id = Decode::getId(array_shift($property));
            if($id != false)
            {
                $arr = array();
                $count = (int)(count($property) / 2);
                for ($i = 0; $i < $count; $i++) {
                    $arr[array_shift($property)] = array_shift($property);
                }
                App::gI()->db->update(Product::TABLE_NAME, array('techinfo' => json_encode($arr)), $id);
            } else {$errors[] = $item;}
        }
    }
    static public function loadorder($array_data)
    {
        set_time_limit(self::TIME_LIMIT);
        foreach ($array_data as $item) {
            $order = explode(';', $item);
            $id = Decode::getId($order[0]);
            if($id != false)
            {
                App::gI()->db->update(Order::TABLE_NAME, array('orderstatus' => $order[1]), $id);
            } else {$errors[] = $item;}
        }

    }

}