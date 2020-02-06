<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 10.02.2019
 * Time: 23:54
 */

class Router extends Singleton{
    public $controller;
    public $action;
    public $id;
    public $page;
    private $path_elements = array('controller','action','id', 'page');
    function parse($path){
        $request = $_REQUEST;
        $request['controller'] = App::gI()->config->default_controller;
        $request['action'] = App::gI()->config->default_action;
        $request['id'] = 0;
        $request['page'] = 1;
        $parts = parse_url($path);

        if (isset($parts['query']) and !empty($parts['query'])) {
            $path = str_replace('?'.$parts['query'], '', $path);
            parse_str($parts['query'], $req);
            $request = array_merge($request, $req);
        }
        foreach(App::gI()->config->router as $rule => $keypath) {
            if (preg_match('#'.$rule.'#sui', $path, $list)) {
                for ($i=1; $i<count($list); $i=$i+1) {
                    $keypath = preg_replace('#\$([a-z0-9]++)#', $list[$i], $keypath, 1);
                }
                $keypath = explode('/', $keypath);
                foreach($keypath as $i=>$key) {
                    $request[$this->path_elements[$i]] = $key;
                }
                break;
            }
        }
        $request['controller'] = ucfirst($request['controller']);
        $request['action'] = ucfirst($request['action']);


        return $request;

    }
}


//