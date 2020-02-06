<?php
return array(
    'sitename' => 'Строительный магазин Елизово кабель лампа розетка светильник шуруповерт',
    'encode' => 'utf-8',
    'cookietime' => 3600, // время жизни куков администратора в секундах
    'version' => '1.0.0 ',
    'default_module' => 'index',
    'default_controller' => 'site',
    'default_action' => 'index',
    'dataout' => '/data/out/',
    'datain' => '/data/in/',
    'echeck' => '/data/e-check/',
    'cert' => '/data/cert/',
    'price' => '/data/price/',
    'imageproduct' => '/assets/images/products/',
    'description' => 'Магазин строительных материалов, электрики, бытовой химии и хозяйственных товаров в г.Елизово, с доставкой',

    'db' => include 'config.db.php',
    'router' => include 'router.php',
    'scripts'=>array(
        '/assets/js/libs/jquery-3.3.1.min.js',
        '/assets/js/libs/jquery.cookie.min.js',
        '/assets/js/libs/jquery.accordion.js',
        '/assets/js/libs/bootstrap/js/bootstrap.js',
        '/assets/js/libs/bootstrap/js/npm.js',
        '/assets/js/libs/bootstrap/js/bootstrap.bundle.min.js',
        '/assets/js/libs/popper.min.js',
        '/assets/js/fw.saint.js',
        ),
    'styles'=>array(
        '/assets/js/libs/bootstrap/css/bootstrap.min.css',
        '/assets/js/libs/bootstrap/css/bootstrap-theme.min.css',
        '/assets/css/fw.saint.css',),
    // ...
);