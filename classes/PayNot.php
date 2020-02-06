<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 20.02.2019
 * Time: 12:54
 */

class PayNot extends Pay
{
    public function PayOrder(Order &$order)
    {
        parent::PayOrder($order);
        $order->orderstatus = Order::ORDER_NO_PAY;
        $order->save();

        //return $order->id;
    }

    public function loadPaydoc($params = array()) {
        if (is_object($params)) $params = json_decode((json_encode($params)), true);
        extract($params);
        //TODO
    }

}