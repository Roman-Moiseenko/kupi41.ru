<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 11.02.2019
 * Time: 0:05
 */

class Controller extends Singleton{
    private $assets = array();
    public $layout = 'base';
    public $tplPath = '';
    public $tplControllerPath = '';

    function __construct()
    {
        $this->tplPath = ROOT.'views/';
        $this->tplControllerPath = ROOT.'views/'.strtolower(str_replace('Controller','',get_called_class())).'/';
    }

    function __call( $methodName,$args=array() ){
            if (is_callable(array($this, $methodName))) {
                $tmp_methods = get_class_methods($this);
                if (in_array($methodName, $tmp_methods)) {
                    call_user_func_array(array($this, $methodName), $args);
                } else {
                    header('Location: /site/_404');
                    //throw new Except('In controller ' . get_called_class() . ' method ' . $methodName . ' not found!');
                }
                return true;
            }
            else
                header('Location: /site/_404');
                //throw new Except('In controller ' . get_called_class() . ' method ' . $methodName . ' not found!');

    }
    private function addAsset($link, $where = 'head', $asset = 'script', $type = 'url')
    {
        $hash = md5('addScript'.$link.$where.$asset.$type);
        $where = $where=='head' ? 'head' : 'body';
        $asset = $asset=='script' ? 'script' : 'style';
        if (!isset($this->assets[$hash])) {
            $this->assets[$hash] = array('where'=>$where,'asset'=>$asset,'type'=>$type,'data'=>$link);
        }
    }
    public function addScript($link, $where = 'head'){
        $this->addAsset($link, $where);
    }
    public function addStyleSheet($link, $where = 'head'){
        $this->addAsset($link, $where, 'style');
    }
    public function addScriptDeclaration($data, $where = 'head'){
        $this->addAsset($data, $where, 'script', 'inline');
    }
    public function addStyleSheetDeclaration($data, $where = 'head'){
        $this->addAsset($data, $where, 'style', 'inline');
    }
    public function render($filename, $variables = array(), $ajaxcall = false, $output = true){
        $filename = $this->tplControllerPath.str_replace('..','',$filename).'.php';
        //Добавляем параметр ajax вызов или нет
        if ($ajaxcall) {
            $this->renderPartial($filename, $variables, $output);
        } else {
            ob_start();
            $this->renderPartial($filename, $variables, $output);
            $content = ob_get_clean();
            if (App::gI()->config->scripts and is_array(App::gI()->config->scripts)) {
                foreach (App::gI()->config->scripts as $script) {
                    $this->addScript($script);
                }
            }
            if (App::gI()->config->styles and is_array(App::gI()->config->styles)) {
                foreach (App::gI()->config->styles as $style) {
                    $this->addStyleSheet($style);
                }
            }
            $this->renderPage($content);


        }


    }
    private function renderPartial($fullpath, $variables=array(),$output=true){
        extract($variables);

        if( file_exists($fullpath) ){
            if(!$output) ob_start();
            include $fullpath;
            return !$output ? ob_get_clean() : true;
        }else
            throw new Except('File '.$fullpath.' not found');

    }
    /*public function renderPartial($filename,$variables=array(),$output=true){
        $file = $this->tplControllerPath.str_replace('..','',$filename).'.php';
        return $this->_renderPartial($file,$variables,$output);
    }*/
    public function renderPage($content){
        $html = $this->renderPartial($this->tplPath.'index.php',array('content'=>$content), false);
        $output = array('head'=>'','body'=>'');
        foreach ($this->assets as $item) {
            if ($item['asset'] == 'script') {
                if ($item['type']=='inline') {
                    $output[$item['where']].='<script type="text/javascript">'.$item['data'].'</script>'."\n";
                } else {
                    $output[$item['where']].='<script type="text/javascript" src="'.$item['data'].'"></script>'."\n";
                }
            }else{
                if ($item['type']=='inline') {
                    $output[$item['where']].='<style>'.$item['data'].'</style>'."\n";
                } else {
                    $output[$item['where']].='<link rel="stylesheet" href="'.$item['data'].'" type="text/css" />'."\n";
                }
            }
        }
        if ($output['head']) {
            $html = preg_replace('#(<\/head>)#iu', $output['head'].'$1', $html);
        }
        if ($output['body']) {
            $html = preg_replace('#(<\/body>)#iu', $output['body'].'$1', $html);
        }
        echo $html;
    }
    public function renderAjax($AjaxCall = false)
    {
        if (isset($_POST['AjaxCall'])) {

            $this->render('login', array('model' => $model));
        } else {
            ob_start();
            $this->render('login', array('model' => $model));
            $content = ob_get_clean();
            if (App::gI()->config->scripts and is_array(App::gI()->config->scripts)) {
                foreach (App::gI()->config->scripts as $script) {
                    $this->addScript($script);
                }
            }
            if (App::gI()->config->styles and is_array(App::gI()->config->styles)) {
                foreach (App::gI()->config->styles as $style) {
                    $this->addStyleSheet($style);
                }
            }
            $this->renderPage($content);

        }
    }

}