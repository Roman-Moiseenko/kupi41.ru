<?php
/**
 * User: Роман
 * Date: 21.02.2019
 * Time: 8:41
 */

class PayController extends Controller
{
    public $layout = 'tpl_pay';
    public function actionIndex()
    {
        $ajaxcall = isset($_POST['AjaxCall']) ? true : false;
        if (!isset($_SESSION['auth'])) {header('Location: /user/login'); return false;}
        if (App::gI()->cart->count() == 0) return false;

        $out['total'] = App::gI()->cart->sum();
        $out['count'] = App::gI()->cart->count();
        $this->render('index', $out, $ajaxcall);
    }
    public function actionOrder($id)
    {
        $ajaxcall = isset($_POST['AjaxCall']) ? true : false;
        if (!isset($_SESSION['auth'])) {header('Location: /user/login'); return false;}
        //TODO Переделать оплату ранее созданного заказа, или совсем запретить
        $order = Order::model($id);
        $pay = new PayNow();
        $pay->PayOrder($order);

        //TODO Возврат на страницу?????
    }
    public function actionPay()
    {
        $ajaxcall = isset($_POST['AjaxCall']) ? true : false;
        if (!isset($_SESSION['auth'])) {header('Location: /user/login'); return false;}
        if (App::gI()->cart->count() == 0) return false;

        if (!isset($_POST['typepay'])) return false;
        $typepay = $_POST['typepay'];
        //echo $typepay;
        $order = new Order($typepay);
        $total = 0;
        $products_for_order = array();
        foreach (App::gI()->cart->_products as $id => $count)
        {
            $prod = Product::model($id);
            $products_for_order[$id] = array('count' => $count, 'price' => $prod->price);
            $total += $prod->price * $count;
        }
        $order->user = App::gI()->user->id;

        $order->products = json_encode($products_for_order);
        $order->delivery = isset($_POST['delivery']) ? App::gI()->info->delivery: 0; // $_POST['delivery'];
        $order->comment = $_POST['comment'];
        $order->total = $total;

        try {
            $order->paydoc->SaveAndPayOrder($order);


            App::gI()->cart->del(App::gI()->cart->id);
            $this->render('pay', array('idorder' => $order->id), $ajaxcall);
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    public function actionPaydoc($idorder)
    {
        if (!isset($_SESSION['auth'])) {header('Location: /user/login'); return false;}
        $paydoc = Paydoc::model($idorder);
        $paydoc->loadPaydoc();
    }
    public function actionTemp($idorder)
    {

    }
}