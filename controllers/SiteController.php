<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 12.02.2019
 * Time: 15:44
 */

class SiteController extends Controller
{

    public $layout ='base';

    public function actionIndex()
    {
        $ajaxcall = isset($_POST['AjaxCall']) ? true : false;
        $products = Product::_models(Product::PARAM_RECOM);
        $this->render('index', array('products' => $products, 'typepage' => 'recom'), $ajaxcall);
    }
    public function actionCatalog($id, $page = 1)
    {
        $ajaxcall = isset($_POST['AjaxCall']) ? true : false;
        $ids = Catalog::getChildsId($id, $_SESSION['catalog_tree']);
        if ($ids == '') {header('Location: /site/_404'); return false;}

        $all_products = Product::_models(Product::PARAM_CATEGORY_PAGE, $ids);

        $total = count($all_products);

        $products = array_slice($all_products,($page - 1)*Product::SHOW_BY_DEFAULT, Product::SHOW_BY_DEFAULT);
        $pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT, 'p');
        $breadcrumb = Catalog::breadcrumb($id);
        $this->render('index', array('products' => $products, 'pagination' => $pagination, 'typepage' => 'catalog', 'breadcrumb' => $breadcrumb), $ajaxcall);

    }
    public function actionSearch($page = 1)
    {
        $ajaxcall = isset($_POST['AjaxCall']) ? true : false;
        if (isset($_POST['search'])) {
            $_SESSION['search'] = $_POST['search'];
        } else {
            if (!isset($_SESSION['search'])) {
                throw new Except('Строка поиска не была задана');
            }
        }
        $search = $_SESSION['search'];
        //echo $search;
        $all_products = Product::_models(Product::PARAM_SEARCH, $search);
        $total = count($all_products);
        $products = array_slice($all_products,($page - 1)*Product::SHOW_BY_DEFAULT, Product::SHOW_BY_DEFAULT);
        $pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT, 'p');
        $this->render('index', array('products' => $products, 'pagination' => $pagination, 'typepage' => 'search', 'total' => $total, 'search' => $search), $ajaxcall);
    }
    public function action_404()
    {
        $this->render('_404', array());
    }
}