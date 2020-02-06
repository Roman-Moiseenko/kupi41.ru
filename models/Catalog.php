<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 13.02.2019
 * Time: 19:51
 */

class Catalog
{
    const TABLE_NAME = 'catalog';
    private $tree = array();
    //public $safe = array('id', 'name', 'parentid'); //?

    static public function loadFromDB()
    {
        $tree = array();
        $dataset = array();

        $items = App::gI()->db->query('SELECT * FROM ' . self::TABLE_NAME . ' ORDER BY name');
        foreach ($items as $item) {
            $dataset[$item['id']] = $item;
        }
        foreach ($dataset as $id => &$node) {
            if (!$node['parentid']){
                $tree[$id] = &$node;
            }else{
                $dataset[$node['parentid']]['childs'][$id] = &$node;
            }
        }
        foreach ($tree as $id => $node)
        {
            if (substr($node['name'], 0, 1) != '+') {
                unset($tree[$id]);
            } else {
                $tree[$id]['name'] = str_replace('+', '', $node['name']);
            }

        }
        return $tree;
    }

    static public function loadTree($tree, $classname = '')
    {
        $html = '';
        //$tree = self::loadFromDB();
        /** Загружаем шаблон HTML  и подставляем значения из массива*/
        foreach($tree as $item){
            $html .= self::loadTemplate($item, $classname);
        }
        return $html;
    }
    static public function loadTreeDIV($tree, $classname = '', $parentdiv)
    {
        $html = '';
        //$tree = self::loadFromDB();
        /** Загружаем шаблон HTML  и подставляем значения из массива*/
        foreach($tree as $item){
            $html .= self::loadTemplateDIV($item, $classname, $parentdiv);
        }
        return $html;
    }

    //static public function TreeToHTML();
    private static function loadTemplate($category, $classname)
    {
        $s = '<li class="li_card">'."\n";
        $s_a = '<a href="/site/catalog/'.$category['id'].'" class="'.$classname.'" page="1" category="'.$category['id'].'">' . $category['name'] . '</a>';
        if(isset($category['childs'])) {
            $s .= '<a class=" page-link p-0 m-1"><a href="#">++</a>' . $s_a . '</a>';
            foreach ($category['childs'] as $catchild) {
                $s .= '<ul class="li_card"> '.self::loadTemplate($catchild, $classname) . '</ul> '. "\n"; }
        } else {
            $s .= '<a class="page-link p-0 m-0"><a href="#">&#160;&#160;</a>' . $s_a. '</a>';
        }
        $s .= '</li>' . "\n";
        return $s;
    }

    private static function loadTemplateDIV($category, $classname, $parentdiv)
    {
        $s = '<div class="card p-0 pl-1 ml-1" >'."\n"
            .'<table><tr><td width="20px">'
            .'<button class="btn btn-link p-0 m-0 show_accord" type_btn="plus" style="float: left;" '
            .'type="button" data-toggle="collapse" data-target="#_'.$category['id'].'" aria-expanded="true" aria-controls="_'.$category['id'].'">';
        $s_end = '</button></td>'."\n";
        //$s_a = '<a href="/site/catalog/'.$category['id'].'" class="'.$classname.' float-left" page="1" category="'.$category['id'].'">' . $category['name'] . '</a>'."\n";

        $s_a = //'<button class="btn btn-link p-0 m-0" type="button">'
             '<td><a href="/site/catalog/'.$category['id'].'" class="'.$classname.' float-left" page="1" category="'.$category['id'].'" style="color: #0c0c0c">' . $category['name']
            . '</a>'."\n" /*.'</button>'*/
            . '</td></tr></table>';
        if(isset($category['childs'])) {
            $s .= '<i class="far fa-plus-square"></i>' . $s_end . $s_a;
            $s .= '<div id="_'.$category['id'].'" class="collapse m-0 p-0" aria-labelledby="headingOne" data-parent="#'.$parentdiv.'">';
            foreach ($category['childs'] as $catchild) {
                $s .= self::loadTemplateDIV($catchild, $classname, '_' . $category['id']) . "\n"; }
            $s .= '</div>';
        } else {$s .= $s_a . $s_end;};
        $s .= '</div>' . "\n";
        return $s;
    }

    public static function getChildsId($id, $arr, $flag = false)
    {
        $s ='';
        //if($arr == false) {$arr = $this->tree; }

        foreach ($arr as $treeitem) {
            /**Найдено совпадение по id, после обработки выходим из процедуры */
            if ($treeitem['id'] == $id) {
                $s = $treeitem['id']; //Запомнили текущий id
                /**Запускаем рекурсию по вложенным спискам*/
                if (isset($treeitem['childs'])) {
                    $s .= self::getChildsId($id, $treeitem['childs'], true);
                }
                return $s;
            }
            /** Попали во вложенный цикл с флагом TRUE*/

            if ($flag and $treeitem['id'] != $id) {
                $s .= ','.$treeitem['id'];
            }
            /** Проходим корневой список, еще не найдя совпадения по id*/
            if (isset($treeitem['childs'])) {
                $s .= self::getChildsId($id, $treeitem['childs'], $flag);
            }
        }
        return $s;
    }
    public static function getPrice($tree, $flag = 0)
    {
        $price = array();
        $flag++;
        foreach ($tree as $id => $sub_tree){
            //Получаем product из $tree
            $price[] = array('name' =>$sub_tree['name'], 'price' => '', 'unit' => '', 'flag' => $flag);
            $products = Product::_models(Product::PARAM_CATEGORY_ALL, $id);
            foreach ($products as $product) {
                $price[] = array('name' =>$product->name, 'price' => $product->price, 'unit' => $product->unit);
            }
            if (isset($sub_tree['childs'])) {
                $price = array_merge($price, self::getPrice($sub_tree['childs'], $flag));
            }

        }
        return $price;
    }

    public static function breadcrumb($id)
    {
        $result = array();
        self::bread($_SESSION['catalog_tree'], $id, $result, 0);
        return array_reverse($result);
    }
    private static function bread($tree, $id_finish, &$result, $flag = 0)
    {
        $flag++;
        foreach ($tree as $id => $node) {


            if ($id_finish == $id) {
                $result[$flag] = array('id' => -1, 'name' => $node['name']);
                return true;
            }
            if (isset($node['childs'])) {
                //echo '=>';
                if (self::bread($node['childs'], $id_finish, $result, $flag))
                {
                    $result[$flag] = array('id' => $id, 'name' => $node['name']);
                    return true;
                }
            }
        }
    }
}