<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="<?=app::gi()->config->encode?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="<?=app::gi()->config->description?>">
    <meta name="author" content="Моисеенко Роман Александрович">
    <meta name="yandex-verification" content="054696ff5888c5f9" />
    <title><?=app::gi()->config->sitename?></title>
    <link rel="icon" href="/assets/images/favicon.ico">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

</head>
<body>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #e3f2fd;">
                <h5 class="modal-title" id="exampleModalLongTitle">Добавление товара в корзину</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <span style="font-size: 20px; color: #2e6da4"><i class="fas fa-shopping-cart"></i> Товар успешно добавлен!</span>
            </div>

        </div>
    </div>
</div>

    <div class="container d-none d-sm-block">
        <nav class="navbar navbar-expand-sm navbar-light justify-content-end small py-0" style="background-color: #ffffff;">
            <a class="nav-link text-secondary" href="/data/contacts">Контакты</a>
            <a class="nav-link text-secondary" href="/data/delivery">Доставка</a>
            <a class="nav-link text-secondary" href="/data/certificate">Сертификаты</a>
            <a class="nav-link text-secondary" href="/data/warranty">Гарантия</a>
            <a class="nav-link text-secondary" href="<?=App::gI()->config->price .'price.xlsx'?>" download>Прайс-лист</a>
        </nav>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
        <div class="container">
            <a class="navbar-brand" href="/"><img src="/assets/images/info.png" width="180" height="78" alt="Главная"  style="margin-top: -20px; margin-bottom: -20px;"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto col-sm-12">
                    <form class="form-inline my-2 my-lg-0" style="width: 100%" method="post" action="/site/search" id="search_form">
                        <div class="col-sm-11">
                            <div class="input-group">
                                <input class="form-control" type="search" placeholder="Поиск, введите ключевые слова, разделенные пробелом" aria-label="Search" name="search" id="search_input">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-success mt-0" type="submit" id="search_submit"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="nav-item text-center">
                        <?php if(!isset($_SESSION['auth'])):?>
                            <a class="nav-link pt-0 pb-0" href="/user/login">
                                <button class="btn btn-outline-primary my-2 my-sm-0" type="submit" style="border: 0; "><i class="far fa-user"></i></button>
                                <!-- USER -->
                            </a>
                        <? else:?>
                            <div class="dropdown">
                                <a class="dropdown-toggle text-center" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="height: 30px;">
                                    <button class="btn btn-outline-primary my-2 my-sm-0 p-0" type="submit" style="border: 0;"><i class="far fa-user">
                                            <span style="font-size: 12px"><?=App::gI()->user->firstname;?></span></i></button><!-- USER -->
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <?php if(App::gI()->user->role == 'admin'): ?>
                                        <a class="dropdown-item" href="/admin/index">Администратор</a>
                                        <div class="dropdown-divider"></div>
                                    <?php endif; ?>

                                    <a class="dropdown-item" href="/user/index">Профиль пользователя</a>
                                    <a class="dropdown-item" href="/user/password">Сменить пароль</a>
                                    <a class="dropdown-item" href="/order/index">История заказов</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="/user/logout">Выход</a>
                                </div>
                            </div>
                        <?php endif;?>
                    </div>
                    <div class="nav-item text-center">
                        <a class="nav-link pt-0 pb-0" href="<?=!isset($_SESSION['auth']) ? '/user/login' : '/cart/index'; ?>" style="height: 30px;">
                            <button class="btn btn-outline-primary my-2 my-sm-0 p-0" type="submit" style="border: 0; width: 44px; height: 36px"><i class="fas fa-shopping-cart">
                                    <span style="font-size: 12px" class="cart_count"><?=isset($_SESSION['auth']) ? App::gI()->cart->count() : '0'; ?></span></i></button>
                        </a>
                    </div>
                    <div class="nav-item d-block d-sm-none">
                        <div class="dropdown-divider"></div>
                        <a class="nav-link text-secondary" href="/data/contacts">Контакты</a>
                        <a class="nav-link text-secondary" href="/data/delivery">Доставка</a>
                        <a class="nav-link text-secondary" href="/data/certificate">Сертификаты</a>
                        <a class="nav-link text-secondary" href="/data/warranty">Гарантия</a>
                        <a class="nav-link text-secondary" href="<?=App::gI()->config->price .'price.xlsx'?>" download>Прайс-лист</a>
                    </div>
                </ul>
            </div>

        </div>
    </nav>
        <div class="container pb-5" style="background: #f0f0f0;">
            <? include dirname(__FILE__).'/layouts/'.$this->layout.'.php';?>
        </div><!-- /.container -->
    <footer>
        <div class="container mt-auto p-2 text-center" style="background-color: #f0f0f0">
            <span>Copyright © 2019 Моисеенко Роман Александрович | <a href="http://mycraft.site" target="_blank">Designed by PHP.</a></span>
        </div>
    </footer>
</body>

</html>