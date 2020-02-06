<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 08.03.2019
 * Time: 16:09
 */
use YandexCheckout\Client;

class YandexController extends Controller
{
    public $layout = 'tpl_pay';
    public function actionFinishpay()
    {
        $ajaxcall = isset($_POST['AjaxCall']) ? true : false;
        if (!isset($_SESSION['auth'])) {header('Location: /user/login'); return false;}

        $client = new Client();
        $client->setAuth('570422', 'live_QkybQa8B1pkRaqFfhHrMEGIJbv5nqRi6bU0AO5MCEQU');
        $payment = $client->getPaymentInfo($_SESSION['paymentid']);

        if ($payment->status === 'succeeded')
        {
            //Оплачен
            $order = Order::model($_SESSION['order_id']);
            $order->createOrderTo1C();
            $paydoc = new Paydoc(Paydoc::PAY_ECHECK);
            $paydoc->user = App::gI()->user->id;
            $paydoc->productorder = $_SESSION['order_id'];
            $paydoc->datepaydoc = time();// $payment->created_at;  //'дата от яндекс';
            $paydoc->numberpaydoc = $_SESSION['paymentid'];
            $paydoc->typepaydoc = Paydoc::PAY_ECHECK;
            $paydoc->save();
            App::gI()->cart->del(App::gI()->cart->id);
            $error = null;

        } else {
            App::gI()->db->del(Order::TABLE_NAME, $_SESSION['order_id']);
            $error = 'Заказ не оплачен';
        }
        unset($_SESSION['order_id']);
        unset($_SESSION['paymentid']);

        if (isset($error)) {$this->render('finishpay', array('error' => $error,
            'idorder' => '',
            'numberpaydoc' => '',
            'datepaydoc' => ''), $ajaxcall);}
        else {
        $this->render('finishpay', array('error' => $error,
            'idorder' => $paydoc->productorder,
            'numberpaydoc' => $paydoc->numberpaydoc,
            'datepaydoc' => $paydoc->datepaydoc), $ajaxcall); }


    }

}