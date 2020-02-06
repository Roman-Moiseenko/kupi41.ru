<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 25.02.2019
 * Time: 15:28
 */

class OrderController extends Controller
{
    public $layout ='tpl_order';

    public function actionCancel($id)
    {
        if (!isset($_SESSION['auth'])) {header('Location: /user/login'); return false;}
        $order = Order::model($id);
        $order->orderstatus = Order::ORDER_CANCEL;
        $order->datefinish = time();
        $order->save();
        $paydoc = Paydoc::model($id);
        if ($paydoc->id != null) {App::gI()->db->del(Paydoc::TABLE_NAME, $paydoc->id);}

        header('Location: \order\index');

    }
    public function actionIndex()
    {
        if (!isset($_SESSION['auth'])) {header('Location: /user/login'); return false;}
        $ajaxcall = isset($_POST['AjaxCall']) ? true : false;
        if (!isset($_SESSION['auth'])) {header('Location: /user/login'); return false;}

        $order_process = Order::_models(App::gI()->user->id, array(Order::ORDER_NO_PAY, Order::ORDER_INVOICE));

        $order_current = Order::_models(App::gI()->user->id, array(Order::ORDER_PAY, Order::ORDER_READY));;
        $order_finish = Order::_models(App::gI()->user->id, array(Order::ORDER_CANCEL, Order::ORDER_FINISH));
        $this->render('index', array('model' => App::gI()->user,
            'order_process' => $order_process,
            'order_current' => $order_current,
            'order_finish' => $order_finish), $ajaxcall);
    }
    public function actionDel($id)
    {
        if (!isset($_SESSION['auth'])) {header('Location: /user/login'); return false;}

       // echo $id;
        App::gI()->db->del(Order::TABLE_NAME, $id);
        $paydoc = Paydoc::model($id);
       // echo $paydoc->id;
        if (isset($paydoc->id)) App::gI()->db->del(Paydoc::TABLE_NAME, $paydoc->id);
        //die($_SERVER['HTTP_REFERER']);
        header('Location: '.$_SERVER['HTTP_REFERER']);

    }
    public function actionUnload($id)
    {
        $order = Order::model($id);
        $order->createOrderTo1C();
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }


}