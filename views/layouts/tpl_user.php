<div class="container-fluid">
    <div class="row pt-4">
        <div class="col-md-3 col-sm-12 rounded border-light pb-4" <?=isset($_SESSION['auth']) ? 'style="background-color: #ffffff;"': '';?> >
            <?php if (isset($_SESSION['auth'])):?>
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <?php if(App::gI()->user->role == 'admin'): ?>
                        <a class="nav-link" id="useredit" href="/admin/index">Администратор</a>
                    <?php endif; ?>
                    <p class="nav-link pb-0 mb-0 text-dark" id="vtab" href="#" aria-selected="false" disabled>Личная информация</p>
                    <a class="nav-link <?=isset($_SESSION['user_activ']) ? $_SESSION['user_activ'][UserController::USER_CABINET_EDITDATA] : 'active' ?>" id="useredit" href="/user/index">
                        Регистрационные данные
                    </a>
                    <a class="nav-link <?=isset($_SESSION['user_activ']) ? $_SESSION['user_activ'][UserController::USER_CABINET_EDITPASSWORD] : '' ?>" id="useredit" href="/user/password">
                        Изменить пароль</a>
                    <p class="nav-link pb-0 mb-0 pt-2 text-dark" id="vtab" href="#" aria-selected="false" disabled>Заказы</p>
                    <a class="nav-link" href="/cart/index">Моя корзина</a>
                    <a class="nav-link <?=isset($_SESSION['user_activ']) ? $_SESSION['user_activ'][UserController::USER_CABINET_ARCH] : '' ?>" id="useredit" href="/order/index">
                        История покупок</a>
                    <a class="nav-link <?=isset($_SESSION['user_activ']) ? $_SESSION['user_activ'][UserController::USER_CABINET_ECHECK] : '' ?>" id="useredit" href="/user/paydoc">
                        Электронные чеки(счета)</a>
                </div>
            <?php endif;?>
        </div>
        <div class="col-md-9 col-sm-12">
            <?=$content?>
        </div>

    </div>
</div>


