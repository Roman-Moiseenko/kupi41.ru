<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 20.02.2019
 * Time: 12:52
 */
use YandexCheckout\Client;

class PayNow extends Pay
{

public function PayOrder(Order &$order)
{

    parent::PayOrder($order);
    $order->orderstatus = Order::ORDER_PAY;
    $order->save(false);
    $items = array();
    $products = json_decode($order->products, true);
    foreach ($products as $id => $product) {
        $_product = Product::model($id);
        $items[] = array('description' => addslashes($_product->name),
                         'quantity' => $product['count'],
                         'amount' => array('value' => $product['price'], 'currency' => 'RUB'),
                         'vat_code' => 1);
    }
    $_SESSION['order_id'] = $order->id;
    //TODO Модуль оплаты от Яндекс
    $client = new Client();
    $client->setAuth('570422', 'live_QkybQa8B1pkRaqFfhHrMEGIJbv5nqRi6bU0AO5MCEQU');
    $payment = $client->createPayment(
        array(
            'amount' => array(
                'value' => $order->total,
                'currency' => 'RUB',
            ),
            'payment_method_data' => array(
                'type' => 'bank_card',
            ),
            'receipt' => array(
                'email' => App::gI()->user->email,
                'items' => $items,
            ),
            'confirmation' => array(
                'type' => 'redirect',
                'return_url' => 'https://kupi41.ru/yandex/finishpay',
            ),
            'capture' => true,
            'description' => 'Заказ № ' . $order->id,
        ),
        uniqid('', true)
    );

    $_SESSION['paymentid'] = $payment->id;
    header ("Location: ". $payment->confirmation->confirmationUrl);
    die();
}

    public function loadPaydoc($params = array()) {
        if (is_object($params)) $params = json_decode((json_encode($params)), true);
        extract($params);
        $filename = App::gI()->config->echeck . $id . '.pdf';
        if (file_exists($filename)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($filename));
            header('Content-Length: ' . filesize($filename));
            readfile($filename);
            exit;
        }

        //TODO
    }

}