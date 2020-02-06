<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 13.02.2019
 * Time: 10:42
 */

class Product extends ModelTable
{

    const PARAM_ALL = 0;
    const PARAM_CATEGORY_ALL = 1;
    const PARAM_CATEGORY_PAGE = 2;
    const PARAM_RECOM = 3;
    const PARAM_SEARCH = 4;
    const PARAM_IDS = 5;
    const SHOW_BY_DEFAULT = 16;
    const TABLE_NAME = 'product';
    public $imagefile = '';
    public $safe = array('id', 'parentid', 'name', 'descr', 'techinfo', 'price', 'remains', 'unit', 'recom');

    /** $param - id категории, строка поиска или список id товара, в зависимости от $type */
    static public function _models($type = self::PARAM_ALL, $param = 0)
    {
        $sql ='SELECT * FROM '. self::TABLE_NAME . ' ';
        $params = array();
        switch ($type) {
            case self::PARAM_CATEGORY_ALL:
                $sql .= ' WHERE parentid = ' . $param . ' AND remains > 0';
                break;
            case self::PARAM_CATEGORY_PAGE:
                $sql .= ' WHERE parentid IN (' . $param . ') AND remains > 0'
                        ." ORDER BY id ASC ";
                break;
            case self::PARAM_RECOM:
                $sql .= ' WHERE recom = 1 AND remains > 0';
                break;
            case self::PARAM_SEARCH:
                //TODO Удаление спец.символов со строки поиска
                $param = preg_replace('/[^a-zA-ZА-Яа-я0-9-()\s$]/u', '', $param);
                $search = explode(' ', $param);
                foreach ($search as $item)
                {
                    $_s[] = "name LIKE '%$item%' ";
                    $_s1[] = "descr LIKE '%$item%' ";
                    $_s2[] = "techinfo LIKE '%$item%' ";
                }
                $str = implode(" AND ", $_s);
                $str1 = implode(" AND ", $_s1);
                $str2 = implode(" AND ", $_s2);
                $sql .= ' WHERE ((' . $str .') OR (' . $str1 . ') OR (' . $str2 . ')) AND (remains > 0)'
                    ." ORDER BY id ASC ";
                break;
            case self::PARAM_IDS:
                $sql .= ' WHERE id IN(' . $param . ') AND remains > 0';
                break;

        }
        //$items = App::gI()->db->queryPrepare($sql, $params);
        $items = App::gI()->db->query($sql);
        $results = array();
        foreach ($items as $item) {
            $model = new Product();
            $model->__attributes = $item;
            /** Загружаем в объект ссылку на image*/
            $filepath =  App::gI()->config->imageproduct;
            if(file_exists($_SERVER['DOCUMENT_ROOT']. $filepath . $model->id . '.jpg')) {
                $model->imagefile = $filepath . $model->id . '.jpg';
            } else {
                $model->imagefile = $filepath . 'no-image.jpg';
            }

            /**  */
            $results[] = $model;
        }
        return $results;
    }
    public static function model($id)
    {
        $model = parent::model($id);
        /** Загружаем в объект ссылку на image*/
        $filepath = '/assets/images/products/';
        if(file_exists($_SERVER['DOCUMENT_ROOT'].$filepath . $model->id . '.jpg')) {
            $model->imagefile = $filepath . $model->id . '.jpg';
        } else {
            $model->imagefile = $filepath . 'no-image.jpg';
        }
        return $model;

    }
}

