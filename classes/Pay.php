<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 20.02.2019
 * Time: 12:25
 */

abstract class Pay
{
    /*const PAY_NOT = 0;
    const PAY_INV = 1;
    const PAY_NOW = 2;*/
    public function PayOrder(Order &$order) {}
    public function loadPaydoc($params = array()) {

    }
}