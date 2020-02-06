<div class="container-fluid">
    <?php if (App::gI()->cart->count() != 0) :?>
        <div  class="row"><div class="col-12"><h2 class="pt-2">Моя корзина</h2></div></div>
        <div  class="row" style="color: #5a6268;"><div class="col-12 d-inline-flex"><i class="fas fa-map-marker-alt"></i>&#8194;<h6><?=App::gI()->user->address;?></h6></div></div>
        <div class="row pb-2"><div class="col-12"><i style="font-size: 14px; color: #6c757d">(адрес доставки можно поменять в профиле)</i></div></div>
    <?php else: ?>
        <div  class="row"><div class="col-12"><h2 class="pt-2">Корзина пуста</h2></div></div>
        <form action="/" method="post"><button class="btn btn-primary my-2 my-sm-0" type="submit">Перейти к покупкам</button></form>
    <?php endif;?>

    <div class="row">
        <div class="col-sm-12">
            <?=$content?>
        </div>
    </div>
    <?php if (App::gI()->cart->count() != 0) :?>
    <div class="row pt-4">
        <div class="col-md-9"></div>
        <div class="col-md-3 rounded" style="background: #ffffff;">
            <div class="row">
                <div class="col-12">
                    <h6>товаров <span class="cart_count"><?=isset($_SESSION['auth']) ? App::gI()->cart->count() : '0'; ?></span> на сумму:</h6>
                </div>
            </div>
            <div class="row pt-1">
                <div class="col-12" style="text-align: right">
                    <h4><span id="cart_sum"><?=number_format(App::gI()->cart->sum(), 2, ',', ' ');?></span> &#8381;</h4>
                </div>
            </div>
            <div class="row pb-4 pt-3">
                <div class="col-12" style="text-align: center">
                    <form action="/pay/index" method="post">
                        <button class="btn btn-success my-2 my-sm-0" type="submit" <?=(App::gI()->cart->count() == 0) ? 'disabled' : '';?>>Перейти к оформлению</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php endif;?>
</div>