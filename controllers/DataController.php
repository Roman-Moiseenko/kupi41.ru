<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 15.02.2019
 * Time: 0:57
 */

class DataController extends Controller
{

    public $layout ='tpl_data';

    public function actionContacts()
    {
        //Загрузка страницы ***Контакты***
        $ajaxcall = isset($_POST['AjaxCall']) ? true : false;


        $this->render('contacts', array(), $ajaxcall);
    }
    public function actionDelivery()
    {
        //Загрузка страницы ***Доставка***
        $ajaxcall = isset($_POST['AjaxCall']) ? true : false;


        $this->render('delivery', array(), $ajaxcall);
    }
    public function actionCertificate()
    {
        //Загрузка страницы ***Сертификаты***
        $ajaxcall = isset($_POST['AjaxCall']) ? true : false;

        $certificates = Certificate::models();

        $this->render('certificate', array('certificates' => $certificates), $ajaxcall);
    }
    public function actionWarranty()
    {
        //Загрузка страницы ***Гарантия***
        $ajaxcall = isset($_POST['AjaxCall']) ? true : false;


        $this->render('warranty', array(), $ajaxcall);
    }
    public function actionReturn()
    {
        //Загрузка страницы ***Возврат***
        $ajaxcall = isset($_POST['AjaxCall']) ? true : false;


        $this->render('return', array(), $ajaxcall);
    }


}