

<div class="rounded m-2 p-2 pt-5 mt-5" style="background-color: #ffffff">
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-12">
            <img src="<?=$product->imagefile?>" class="card-img-top border border-info rounded" title="ВНИМАНИЕ!<?="\n"?>Внешний вид товара, <?="\n"?>может отличаться от данной иллюстрации">
        </div>
        <div class="col-lg-8 col-md-6 col-sm-12">
            <div class="d-flex flex-column">
                <div class="border-bottom border-info">
                    <h4><?=$product->name; ?></h4>
                </div>
                <div class="pt-4" style="text-align: right; font-size: 42px">
                    <?=number_format($product->price, 2, ',', ' '); ?> <span style="color: #3c3c3c">&#8381;</span>
                </div>
                <div class="border-bottom border-info pb-3" style="text-align: right; font-size: 16px; color: #3c3c3c">Остаток на складе: <?=$product->remains; ?> <?=$product->unit; ?></div>
                <div class="ml-auto pt-1">
                    <?php if ($product->remains == 0): ?>
                        <p>Нет на складе</p>
                    <?php else: ?>
                        <?php if(!isset($_SESSION['auth'])):?>
                            <a href="/user/login" class="btn btn-primary" data_id="<?=$product->id; ?>" data_type="1">В корзину</a>
                        <?php else: ?>
                            <a href="#" class="btn btn-primary change_cart" data_id="<?=$product->id; ?>" data_type="1">В корзину</a>
                        <?php endif;?>
                    <?php endif;?>
                </div>

            </div>
        </div>
    </div>
    <div class="row m-0 pt-2">
        <div class="col-12">
            <?php if (strlen($product->techinfo) != 0):?>
                <div class="row" style="font-weight: bold">
                    <div class="col-12">Технические характеристики</div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-8 col-sm-12">
                        <table class="table table-striped">
                            <tbody>
                            <?php $arr = json_decode($product->techinfo, true);
                            foreach ($arr as $key => $_item): ?>
                                <tr>
                                    <td class="p-1"><?=$key;?></td>
                                    <td class="p-1"><?=$_item;?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif;?>
        </div>
    </div>

    <div class="row m-0">
        <div class="col-12">
            <div class="row" style="font-weight: bold">
                <div class="col-12">Описание товара</div>
            </div>
            <div class="row">
                <div class="col-12">
                    <?=$product->descr; ?>
                </div>
            </div>
        </div>
    </div>
</div>
