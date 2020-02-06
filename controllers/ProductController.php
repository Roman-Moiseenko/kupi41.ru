<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 15.02.2019
 * Time: 0:47
 */

class ProductController extends Controller
{
    public function actionIndex($id)
    {
        $ajaxcall = isset($_POST['AjaxCall']) ? true : false;
        $product = Product::model($id);

        $this->render('index', array('product' => $product), $ajaxcall);

    }

}