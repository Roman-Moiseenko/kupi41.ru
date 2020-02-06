<?php foreach ($products as $item):?>
    <div class="row mb-1 rounded" style="background-color: #ffffff; border-bottom: #3c3c3c 1px;">
        <div class="col-md-8 col-sm-12">
            <img src="<?=$item['product']->imagefile?>" class="pt-1" alt="..." style="height: 40px; width: 40px;">
                <?=$item['product']->name;?>
        </div>

        <div class="col-md-2  col-sm-4 col-6 pt-2">
            <div class="row">
                <div class="col-md-2 m-0 p-0">
                    <div class="col-md-12">
                    <form action="/cart/del/<?=$item['product']->id;?>" method="post"><button class="btn btn-outline-info my-2 my-sm-0 p-0" type="submit" style="border: 0; font-size: 24px; width: 36px">
                        <i class="fas fa-trash-alt" style="display: inline-flex"></i></button>
                    </form>
                    </div>
                </div>
                <div class="col-md-1"></div>
                <div>
                    <div class="row">
                        <div class="col-md-12">
                        <form class="form-inline">
                            <button class="btn btn-outline-info my-2 my-sm-0 p-0 m-0 change_cart"
                                    type="submit" style="border: 0; font-size: 12px; width: 24px; height: 24px"
                                    data_id="<?=$item['product']->id;?>" data_type="2">
                                <i class="fas fa-minus"></i></button>
                            <input class="form-control p-0 m-0" type="text" style="width: 50px; height: 24px; text-align: center"
                                   value="<?=$item['count']?>" name="count" data_id="<?=$item['product']->id;?>"
                                   id="change_cart<?=$item['product']->id;?>" data_type="3" remains="<?=$item['product']->remains;?>" price="<?=$item['product']->price;?>">
                            <button class="btn btn-outline-info my-2 my-sm-0 p-0 m-0 change_cart"
                                    type="submit" style="border: 0; font-size: 12px; width: 24px; height: 24px"
                                    data_id="<?=$item['product']->id;?>" data_type="1">
                                <i class="fas fa-plus"></i></button>
                        </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 pt-2" style="font-size: 12px; color: #5a6268; text-align: center">
                            <?=number_format($item['product']->price, 2, ',', ' ');?> &#8381;/<?=$item['product']->unit;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-2 col-6 p-2 " style="text-align: right"><span id="cart_price<?=$item['product']->id;?>">
                <?php echo number_format((int)$item['count'] * (float)$item['product']->price, 2, ',', ' ');?></span> &#8381;</div>

    </div>
<?php endforeach;?>