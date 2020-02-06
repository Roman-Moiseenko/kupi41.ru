<form action="/pay/pay" method="post" class="">
    <div class="row">
    <div class="col-md-8 rounded pr-1" style="background: #ffffff">
        <div class="row pt-3">
            <div class="col-12">
                <!-- DELIVERY -->
                <h6>Доставка:</h6>
                <label><input type="checkbox" name="delivery" id="delivery" delivery="<?=App::gI()->info->delivery;?>" <?=(App::gI()->user->firm == '') ? '' : 'disabled' ;?>>
                    Доставка товаров по адресу (+ <?=App::gI()->info->delivery;?> &#8381;)
                </label>
                <div  class="row" style="color: grey;" id="delivery_address">
                    <div class="col-12 d-inline-flex">
                        <i class="fas fa-map-marker-alt"></i>&#8194;<h6 class="mb-0"><?=App::gI()->user->address;?></h6>
                    </div>
                </div>
                <div class="row pb-2 pt-0"><div class="col-12"><i style="font-size: 14px; color: #6c757d">(адрес доставки можно поменять в профиле)</i></div></div>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col-md-12">
                <!-- COMMENT -->
                <h6>Пояснения к заказу:</h6>
                <textarea class="textarea_pay" name="comment" cols="70" rows="6"></textarea>
            </div>
        </div>
        <div class="row pt-3 pb-4">
            <div class="col-12">
                <!-- PAY TYPE -->
                <h6>Способ оплаты:</h6>
                <div class="form-check" id="div_type_pay_1">
                    <input class="form-check-input" type="radio" name="typepay" id="radio_type_pay_1" value="<?=Paydoc::PAY_NOPAY;?>">
                    <label class="form-check-label" for="radio_type_pay_1">
                        Наличными при получении заказа
                    </label>
                </div>
                <div class="form-check" id="div_type_pay_2">
                    <input class="form-check-input" type="radio" name="typepay" id="radio_type_pay_2" value="<?=Paydoc::PAY_ECHECK;?>" <?=(App::gI()->user->firm == '') ? 'checked' : '';?>>
                    <label class="form-check-label" for="radio_type_pay_2">
                        Оплата банковской картой в режиме online (тестовый режим!!!)
                    </label>
                </div>
                <div class="form-check <?=(App::gI()->user->firm == '') ? 'disabled' : '';?>" id="div_type_pay_3">
                    <input class="form-check-input" type="radio" name="typepay" id="radio_type_pay_3"
                           value="<?=Paydoc::PAY_INVOICE;?>" <?=(App::gI()->user->firm == '') ? 'disabled' : '';?>
                           <?=(App::gI()->user->firm != '') ? 'checked' : '';?>>
                    <label class="form-check-label" for="radio_type_pay_3">
                        Выписать счет (для организаций)
                    </label>
                </div>

            </div>
        </div>
    </div>
    <div class="card col-md-3 rounded ml-2" style="background: #ffffff; height: 200px">
        <div class="row pt-3">
            <div class="col-12">
                <!-- TO PAY -->
                <div class="row">
                    <div class="col-6">Товаров на</div>
                    <div class="col-6" style="text-align: right"><?=number_format($total, 2, ',', ' ');?> &#8381;</div>
                </div>
                <div class="row pt-1 pb-1" style="font-size: 14px; color: #1c7430; font-style: italic;">
                    <div class="col-md-6">доставка</div>
                    <div class="col-md-6" style="text-align: right"><span id="delivery_sum">+ 0</span> &#8381;</div>
                </div>
                <div class="row pt-2 ml-1 mr-1 border-top" style="font-size: 20px">
                    <div class="col-12"></div>
                </div>

                <div class="row pt-2" style="font-size: 20px">
                    <div class="col-md-5 mr-0">ИТОГО</div>
                    <div class="col-md-7 ml-0" style="text-align: right"><span id="total" total="<?=$total;?>"><?=number_format($total, 2, ',', ' ');?></span> &#8381;</div>
                </div>

                <div class="row pt-4">
                    <div class="col-12" style="text-align: center">
                        <button class="btn btn-success my-2 my-sm-0" type="submit">Оплатить</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>