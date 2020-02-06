<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 10.02.2019
 * Time: 23:42
 */

class App extends Singleton {
    public $config = null;
    public $db;
    public $uri = null;
    public $user = null;
    public $info = null;
    public $cart = null;
    //public $
    function __construct()
    {
        $this->initSystemHandlers();
        $this->config = new Registry(include ROOT . '/config/config.php');
        $this->db = new Db();
        $this->db->connect($this->config->db);
        $this->info = new Info();
        $this->user = new User();
    }
    function start()
   {
       $this->info->load();
       if (isset($_SESSION['auth']))
       {
           App::gI()->user = User::model($_SESSION['auth']);
           //Загружаем корзину пользователя
           App::gI()->cart = Cart::_models($_SESSION['auth']);
       }
       if(!isset($_SESSION['catalog']))
       {
           // класс списка для Ajax
           $tree = Catalog::loadFromDB();
           $_SESSION['catalog_tree'] = $tree;
        //   $_SESSION['catalog'] = Catalog::loadTree($tree,'AjaxCatalog');
           $_SESSION['catalog'] = Catalog::loadTreeDIV($tree,'AjaxCatalog', 'mainDIV'); //loadTree($tree,'AjaxCatalog');
       }
       $this->uri = new Registry(Router::gI()->parse($_SERVER['REQUEST_URI']));
       $controller = App::gI($this->uri->controller.'Controller');
       $controller->__call('action'.$this->uri->action, array($this->uri->id, $this->uri->page));
   }

    public function handleError($code,$message,$file,$line){
        if($code & error_reporting()) {
            restore_error_handler();
            restore_exception_handler();
            try{
                $this->displayError($code,$message,$file,$line);
            } catch(Exception $e) {
                $this->displayException($e);
            }
        }
}
    public function handleException($exception)
    {
        restore_error_handler();
        restore_exception_handler();
        $this->displayException($exception);
    }
    public function displayError($code,$message,$file,$line)
    {
        echo "<h1>PHP Error [$code]</h1>\n";
        echo "<p>$message ($file:$line)</p>\n";
        echo '<pre>';

        $trace=debug_backtrace();

        if(count($trace)>3) {
            $trace=array_slice($trace,3);
        }

        foreach($trace as $i=>$t){
            if(!isset($t['file']))
                $t['file']='unknown';
            if(!isset($t['line']))
                $t['line']=0;
            if(!isset($t['function']))
                $t['function']='unknown';
            echo "#$i {$t['file']}({$t['line']}): ";
            if(isset($t['object']) && is_object($t['object']))
                echo get_class($t['object']).'->';
            echo "{$t['function']}()\n";
        }
        echo '</pre>';
        exit();
    }
    public function displayException($exception)
    {
        echo '<h1>'.get_class($exception)."</h1>\n";
        echo '<p>'.$exception->getMessage().' ('.$exception->getFile().':'.$exception->getLine().')</p>';
        echo '<pre>'.$exception->getTraceAsString().'</pre>';
    }
    protected function initSystemHandlers()
    {
        set_exception_handler(array($this,'handleException'));
        set_error_handler(array($this,'handleError'),error_reporting());
    }
}