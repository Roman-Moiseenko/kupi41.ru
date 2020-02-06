<h2>История покупок</h2>
<?php

//Убрать row тех типов заказов которых нет в данный момент
//Кнопка svg разворачивания каждого заказа
//Кнопка svg разворачивания раздела Завершенные заказы - всегда свернут,
// остальные типы, при наличии заказов, несворачиваемые
//№ заказа, дата , сумма , статус  - кнопки (Аннулировать, Оплатить для ORDER_NO_PAY, Повторить )
// $order_current - #b9def0
// $order_finish - #c3e6cb
?>

<?php if (count($order_process) != 0):?>
<div class="row p-2 m-3 rounded" style="background-color: #ffeeba">
    <div class="col-12">
        <h5>Текущие заказы</h5>
        <div class="rounded row p-2" style="background-color: #ffffff">
            <div class="col-12">
            <?php foreach($order_process as $order):;?>
                <div class="accordion border border-process rounded" id="accordion<?=$order->id?>">
                    <div class="row pl-4 pr-4">
                        <div class="col-12 p-0">
                            <div class="d-flex flex-row ">
                                <div> Заказ № <?=$order->id;?> от <?=_f::dateToHTML($order->dateorder);?> </div>
                                <div class="text-warning">&#8195;<?=Order::$order_type[$order->orderstatus]?></div>
                                <div class="ml-auto">
                                    <button class="btn btn-outline-secondary p-0 " style="border: 0" type="button" data-toggle="collapse" data-target="#collapse<?=$order->id?>" aria-expanded="true" aria-controls="collapse<?=$order->id?>">
                                            <span style="font-size: 24px"><i class="fas fa-chevron-circle-down"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="collapse<?=$order->id?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion<?=$order->id?>">
                        <div class="card-body">
                            <?php $ext = Extproduct::_models(0, $order->products);
                            foreach ($ext as $product):?>
                                <div class="row border border-light rounded" style="border-width: 2px">
                                    <div class="col-8">
                                        <img src="<?=$product->imagefile?>" class="pt-1" alt="..." style="height: 40px; width: 40px;">
                                        <?=$product->name;?>
                                    </div>
                                    <div class="col-4 align-content-center" style="text-align: right">
                                        <span style="font-size: 0.8em; color: #3c3c3c">(<?=$product->count?> <?=$product->unit?>)</span>&#8195;
                                        <?=number_format((float)($product->priceorder) * (int)($product->count), 2, ',', ' ' )?> &#8381;</div>
                                </div>
                            <?php endforeach;?>
                        </div>
                        <div class="row" style="background-color: #ffeeba; margin: 0;">
                            <div class="col-lg-9 col-md-8 col-sm-6">
                                <a href="/pay/paydoc/<?=$order->id?>">

                                    <?php if ($order->paydoc->typepaydoc != null)
                                        echo Paydoc::$caption[$order->paydoc->typepaydoc]
                                            . ' № ' . $order->paydoc->numberpaydoc
                                            . ' от ' . _f::dateToHTML($order->paydoc->datepaydoc);  ?>
                                </a>
                                <div class="row ml-1 mt-2"">
                                <?php if ($order->orderstatus == Order::ORDER_INVOICE || $order->paydoc->id == null):?>
                                    <form action="/order/cancel/<?=$order->id;?>" method="post"><button class="btn btn-secondary m-0" style="padding: 2px; font-size: 0.8em;  height: 30px">Аннулировать</button></form>
                                <?php endif;?>
                                <form action="/cart/order/<?=$order->id;?>"" method="post"><button class="btn btn-info m-0" style="padding: 2px; font-size: 0.8em;  height: 30px">Повторить</button></form>
                                <?php if ($order->orderstatus == Order::ORDER_NO_PAY):?>
                                    <form action="/pay/order/<?=$order->id;?>" method="post"><button class="btn btn-success m-0" style="padding: 2px; font-size: 0.8em;  height: 30px" disabled>Оплатить</button></form>
                                <?php endif;?>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="d-flex flex-column">
                                <div class="d-flex flex-row"><div>Товаров на</div><div class="ml-auto"><?=number_format($order->total, 2, ',', ' ');?>&#8381;</div></div>
                                <div class="d-flex flex-row" style="font-size: 0.8em"><div>Доставка:</div><div class="ml-auto"><?=number_format($order->delivery, 2, ',', ' ');?>&#8381;</div></div>
                                <div class="d-flex flex-row" style="font-size: 1.2em"><div>ИТОГО:</div><div class="ml-auto"><?=number_format((int)($order->delivery) + (float)($order->total), 2, ',', ' ');?>&#8381;</div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
            </div>
        </div>
    </div>
</div>
<?php endif;?>



<?php if (count($order_current) != 0):?>
    <div class="row p-2 m-3 rounded" style="background-color: #b9def0">
        <div class="col-12">
            <h5>Заказы в обработке</h5>
            <div class="rounded row p-2" style="background-color: #ffffff">
                <div class="col-12">
                    <?php foreach($order_current as $order):;?>
                    <div class="accordion border border-current rounded" id="accordion<?=$order->id?>">
                        <div class="row pl-4 pr-4">
                            <div class="col-12 p-0">
                                <div class="d-flex flex-row ">
                                    <div> Заказ № <?=$order->id;?> от <?=_f::dateToHTML($order->dateorder);?> </div>
                                    <div class="text-info">&#8195;<?=Order::$order_type[$order->orderstatus]?></div>
                                    <div class="ml-auto">
                                        <button class="btn btn-outline-secondary p-0 " style="border: 0" type="button" data-toggle="collapse" data-target="#collapse<?=$order->id?>" aria-expanded="true" aria-controls="collapse<?=$order->id?>">
                                            <span style="font-size: 24px"><i class="fas fa-chevron-circle-down"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="collapse<?=$order->id?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion<?=$order->id?>">
                            <div class="card-body">
                                <?php $ext = Extproduct::_models(0, $order->products);
                                foreach ($ext as $product):?>
                                    <div class="row border border-light rounded" style="border-width: 2px">
                                        <div class="col-8">
                                            <img src="<?=$product->imagefile?>" class="pt-1" alt="..." style="height: 40px; width: 40px;">
                                            <?=$product->name;?>
                                        </div>
                                        <div class="col-4 align-content-center" style="text-align: right">
                                            <span style="font-size: 0.8em; color: #3c3c3c">(<?=$product->count?> <?=$product->unit?>)</span>&#8195;
                                            <?=number_format((float)($product->priceorder) * (int)($product->count), 2, ',', ' ' )?> &#8381;</div>
                                    </div>
                                <?php endforeach;?>
                            </div>
                            <div class="row" style="background-color: #b9def0; margin: 0;">
                                <div class="col-lg-9 col-md-8 col-sm-6">
                                    <a href="/pay/paydoc/<?=$order->id?>">
                                        <?php if ($order->paydoc->id != null)
                                            echo Paydoc::$caption[$order->paydoc->typepaydoc]
                                                . ' № ' . $order->paydoc->numberpaydoc
                                                . ' от ' . _f::dateToHTML($order->paydoc->datepaydoc);  ?>
                                    </a>
                                    <div class="row ml-1 mt-2"">
                                    <?php if ($order->orderstatus == Order::ORDER_INVOICE || $order->paydoc->id == null):?>
                                        <form action="/order/cancel/<?=$order->id;?>" method="post"><button class="btn btn-secondary m-0" style="padding: 2px; font-size: 0.8em;  height: 30px">Аннулировать</button></form>
                                    <?php endif;?>
                                    <form action="/cart/order/<?=$order->id;?>"" method="post"><button class="btn btn-info m-0" style="padding: 2px; font-size: 0.8em;  height: 30px">Повторить</button></form>
                                    <?php if ($order->orderstatus == Order::ORDER_NO_PAY):?>
                                        <form action="/pay/order/<?=$order->id;?>" method="post"><button class="btn btn-success m-0" style="padding: 2px; font-size: 0.8em;  height: 30px">Оплатить</button></form>
                                    <?php endif;?>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="d-flex flex-column">
                                    <div class="d-flex flex-row"><div>Товаров на</div><div class="ml-auto"><?=number_format($order->total, 2, ',', ' ');?>&#8381;</div></div>
                                    <div class="d-flex flex-row" style="font-size: 0.8em"><div>Доставка:</div><div class="ml-auto"><?=number_format($order->delivery, 2, ',', ' ');?>&#8381;</div></div>
                                    <div class="d-flex flex-row" style="font-size: 1.2em"><div>ИТОГО:</div><div class="ml-auto"><?=number_format((int)($order->delivery) + (float)($order->total), 2, ',', ' ');?>&#8381;</div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
    </div>
<?php endif;?>


<?php if (count($order_finish) != 0):?>
    <div class="row p-2 m-3 rounded" style="background-color: #c3e6cb">
        <div class="col-12">
            <h5>Завершенные заказы</h5>
            <div class="rounded row p-2" style="background-color: #ffffff">
                <div class="col-12">
                    <?php foreach($order_finish as $order):;?>
                    <div class="accordion border border-finish rounded" id="accordion<?=$order->id?>">
                        <div class="row pl-4 pr-4">
                            <div class="col-12 p-0">
                                <div class="d-flex flex-row ">
                                    <div> Заказ № <?=$order->id;?> от <?=_f::dateToHTML($order->dateorder);?> </div>
                                    <div class="<?=($order->orderstatus == Order::ORDER_FINISH) ? 'text-success' : 'text-secondary' ?>">
                                        &#8195;<?=Order::$order_type[$order->orderstatus]?> <?=_f::dateToHTML($order->datefinish);?>
                                    </div>
                                    <div class="ml-auto">
                                        <button class="btn btn-outline-secondary p-0 " style="border: 0" type="button" data-toggle="collapse" data-target="#collapse<?=$order->id?>" aria-expanded="true" aria-controls="collapse<?=$order->id?>">
                                            <span style="font-size: 24px"><i class="fas fa-chevron-circle-down"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="collapse<?=$order->id?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordion<?=$order->id?>">
                            <div class="card-body">
                                <?php $ext = Extproduct::_models(0, $order->products);
                                foreach ($ext as $product):?>
                                    <div class="row border border-light rounded" style="border-width: 2px">
                                        <div class="col-8">
                                            <img src="<?=$product->imagefile?>" class="pt-1" alt="..." style="height: 40px; width: 40px;">
                                            <?=$product->name;?>
                                        </div>
                                        <div class="col-4 align-content-center" style="text-align: right">
                                            <span style="font-size: 0.8em; color: #3c3c3c">(<?=$product->count?> <?=$product->unit?>)</span>&#8195;
                                            <?=number_format((float)($product->priceorder) * (int)($product->count), 2, ',', ' ' )?> &#8381;</div>
                                    </div>
                                <?php endforeach;?>
                            </div>
                            <div class="row" style="background-color: #c3e6cb; margin: 0;">
                                <div class="col-lg-9 col-md-8 col-sm-6">
                                    <?php if($order->orderstatus != Order::ORDER_CANCEL):?>
                                        <a href="/pay/paydoc/<?=$order->id?>">
                                            <?php if ($order->paydoc->id != null)
                                                echo Paydoc::$caption[$order->paydoc->typepaydoc]
                                                    . ' № ' . $order->paydoc->numberpaydoc
                                                    . ' от ' . _f::dateToHTML($order->paydoc->datepaydoc);  ?>
                                        </a>
                                    <?php endif;?>
                                    <div class="row ml-1 mt-2"">
                                    <form action="/cart/order/<?=$order->id;?>"" method="post"><button class="btn btn-info m-0" style="padding: 2px; font-size: 0.8em;  height: 30px">Повторить</button></form>
                                    <?php if ($order->orderstatus == Order::ORDER_NO_PAY):?>
                                        <form action="/pay/order/<?=$order->id;?>" method="post"><button class="btn btn-success m-0" style="padding: 2px; font-size: 0.8em;  height: 30px">Оплатить</button></form>
                                    <?php endif;?>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-4 col-sm-6">
                                <div class="d-flex flex-column">
                                    <div class="d-flex flex-row"><div>Товаров на</div><div class="ml-auto"><?=number_format($order->total, 2, ',', ' ');?>&#8381;</div></div>
                                    <div class="d-flex flex-row" style="font-size: 0.8em"><div>Доставка:</div><div class="ml-auto"><?=number_format($order->delivery, 2, ',', ' ');?>&#8381;</div></div>
                                    <div class="d-flex flex-row" style="font-size: 1.2em"><div>ИТОГО:</div><div class="ml-auto"><?=number_format((int)($order->delivery) + (float)($order->total), 2, ',', ' ');?>&#8381;</div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
    </div>
<?php endif;?>