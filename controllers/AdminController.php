<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 27.02.2019
 * Time: 8:38
 */

class AdminController extends Controller
{
    public $layout = 'tpl_admin';

    public function actionIndex()
    {
        $ajaxcall = isset($_POST['AjaxCall']) ? true : false;
        if (!isset($_SESSION['auth'])) {header('Location: /user/login'); return false;}
        if (App::gI()->user->role != 'admin') {header('Location: /user/login'); return false;}

        $this->render('index', array(), $ajaxcall);
    }
    public function actionProducts()
    {
        $ajaxcall = isset($_POST['AjaxCall']) ? true : false;
        if (!isset($_SESSION['auth'])) {header('Location: /user/login'); return false;}
        if (App::gI()->user->role != 'admin') {header('Location: /user/login'); return false;}

        //Загрузка изображения
        if (isset($_POST['submit_image'])) {
            $id = $_POST['idproduct'];
            if (is_uploaded_file($_FILES["filename"]["tmp_name"])) {
                move_uploaded_file($_FILES["filename"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'] . App::gI()->config->imageproduct . $id.".jpg");}
        }
        //Установка рекомендованного товара
        if (isset($_POST['submit_recom'])) {
            $tmp_product = Product::model($_POST['idproduct']);
            $tmp_product->recom = ($tmp_product->recom == 0) ? 1 : 0;
            $tmp_product->save();
        }

        $products = array();
        //Запоминаем режим поиска
        if (isset($_POST['search_admin'])) {
            $_SESSION['search_admin'] = true;
            $_SESSION['search_input_admin'] = $_POST['search_input_admin'];
            $_SESSION['no_image'] = isset($_POST['no_image']) ? true : null;
            if ($_SESSION['search_input_admin'] == '') $_SESSION['no_image'] = true;
        }

        //Получаем список товаров по поиску для отображения
        if (isset($_SESSION['search_admin']))
        {
            $products = Product::_models(Product::PARAM_SEARCH, $_SESSION['search_input_admin']);
            if (isset($_SESSION['no_image'])) {
//Проверить корректную работу удаления элементов -- РАБОТАЕТ
                foreach ($products as $id => $product)
                {
                    if(preg_match('/no-image/', $product->imagefile) == false) {unset($products[$id]);}
                }
            }
        }


        $this->render('products', array('products' => $products), $ajaxcall);
    }
    public function actionInfo()
    {
        $ajaxcall = isset($_POST['AjaxCall']) ? true : false;
        if (!isset($_SESSION['auth'])) {header('Location: /user/login'); return false;}
        if (App::gI()->user->role != 'admin') {header('Location: /user/login'); return false;}
        if (isset($_POST['name'])){
            App::gI()->info->__attributes =  $_POST;
            App::gI()->info->save();
        }

        $this->render('info', array('model' => App::gI()->info->__attributes,
                                             'errors' => App::gI()->info->errors),
                               $ajaxcall);
    }
    public function actionChange()
    {
        $ajaxcall = isset($_POST['AjaxCall']) ? true : false;
        if (!isset($_SESSION['auth'])) {header('Location: /user/login'); return false;}
        if (App::gI()->user->role != 'admin') {header('Location: /site/_404'); return false;}

        /** Загрузка групп товаров */
        $file = $_SERVER['DOCUMENT_ROOT'] . "/data/temp/data.load";
        foreach (['loadcatalog', 'loadproduct' , 'loadproperty'] as $item) {
            if (isset($_POST[$item])) {
                if (is_uploaded_file($_FILES["filename"]["tmp_name"])) {
                    move_uploaded_file($_FILES["filename"]["tmp_name"], $file);
                    $dataarray = array();
                    /** Считываем данные */
                    $fp = fopen($file, 'rt');
                    if ($fp) {
                        while (!feof($fp)) {
                            $dataarray[] = rtrim(fgets($fp));
                        }
                        fclose($fp);
                    }
                    /** Запускаем соответствующую процедуру класса Админ */
                    Admin::$item($dataarray);
                    /** Удаляем файл */
                    unlink($file);
                }
            }
        }
        $this->render('change', array(), $ajaxcall);
    }
    public function actionOrder()
    {
        $ajaxcall = isset($_POST['AjaxCall']) ? true : false;
        if (!isset($_SESSION['auth'])) {header('Location: /user/login'); return false;}
        if (App::gI()->user->role != 'admin') {header('Location: /user/login'); return false;}
        $orders = Order::_models(0, array(Order::ORDER_NO_PAY, Order::ORDER_INVOICE, Order::ORDER_PAY, Order::ORDER_READY));
        $orders_arr = array();
        foreach ($orders as $order) {
            $_user = User::model($order->user);
            $id = $order->id;
            $orders_arr[$id]['user'] = $_user->firstname . ' ' . $_user->secondname . ' ' . $_user->lastname;
            $orders_arr[$id]['phone'] = $_user->phone;
            $orders_arr[$id]['dateorder'] = date('d-m-y', $order->dateorder);
            $orders_arr[$id]['orderstatus'] = Order::$order_type[$order->orderstatus];
            $orders_arr[$id]['total'] = $order->total;
        }

        $this->render('order', array('orders_arr' => $orders_arr), $ajaxcall);
    }

    public function actionCertificate()
    {
        $ajaxcall = isset($_POST['AjaxCall']) ? true : false;
        if (!isset($_SESSION['auth'])) {header('Location: /user/login'); return false;}
        if (App::gI()->user->role != 'admin') {header('Location: /user/login'); return false;}

        if (isset($_POST['new'])) {
            $cert = new Certificate();
            $cert->name = '';
            $cert->save();
        }
        if (isset($_POST['delete'])) {
            $cert = Certificate::model($_POST['id']);
            $file = $_SERVER['DOCUMENT_ROOT'] . App::gI()->config->cert . $cert->file;
            if (is_file($file)) unlink($file);
            App::gI()->db->del(Certificate::TABLE_NAME, $cert->id);
        }
        if (isset($_POST['save'])) {
            if (is_uploaded_file($_FILES["filename"]["tmp_name"])) {
                //Загрузка файла
                $_POST['filename'] = $_FILES['filename']['name'];
                $file = $_SERVER['DOCUMENT_ROOT'] . App::gI()->config->cert . $_FILES['filename']['name'];
                move_uploaded_file($_FILES["filename"]["tmp_name"], $file);
            }
            $cert = new Certificate();
            $cert->__attributes = $_POST;
            $cert->save();
        }
        $certificates  = Certificate::models();
        $this->render('certificate', array('certificates' => $certificates), $ajaxcall);
    }
}

