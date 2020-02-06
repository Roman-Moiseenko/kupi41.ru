<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 15.02.2019
 * Time: 0:48
 */

class CartController extends Controller
{

    public $layout ='tpl_cart';

    public function actionIndex()
    {
        $ajaxcall = isset($_POST['AjaxCall']) ? true : false;
        if (!isset($_SESSION['auth'])) {header('Location: /user/login'); return false;}
        $_array = array();
        foreach (App::gI()->cart->_products as $productid => $count)
        {
            $_array[] = array('product'=> Product::model($productid), 'count' => $count);
        }
        $this->render('index', array('products' => $_array), $ajaxcall);
    }
    public function actionChange($id)
    {
        if (!isset($_SESSION['auth'])) {header('Location: /user/login'); return false;}
        $oper = $_POST['oper'];
        $count = isset($_POST['count']) ? $_POST['count'] : 0;
        App::gI()->cart->change($id, $oper, $count);
        echo App::gI()->cart->count();
        return true;
    }
    public function actionTotalprice()
    {
        if (!isset($_SESSION['auth'])) {header('Location: /user/login'); return false;}
        echo number_format(App::gI()->cart->sum(), 2, ',', ' ');
        return true;
    }
    public function actionDel($id)
    {
        if (!isset($_SESSION['auth'])) {header('Location: /user/login'); return false;}
        App::gI()->cart->change($id, 3, 0);
        header('Location: \cart\index');
    }
    public function actionOrder($idorder)
    {
        if (!isset($_SESSION['auth'])) {header('Location: /user/login'); return false;}
        $order = Order::model($idorder);
        $products = json_decode($order->products, true);
        foreach ($products as $idproduct => $item) {
            App::gI()->cart->change($idproduct, 3, $item['count']);
        }
        header('Location: \cart\index');
    }
}