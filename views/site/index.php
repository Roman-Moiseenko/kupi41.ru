<?php if ($typepage == 'recom'): ?>
    <div class="row pt-3"><h1>Рекомендуем</h1></div>
<?php endif;?>
<?php if ($typepage == 'catalog'): ?>
    <div class="row pt-1">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <?php foreach ($breadcrumb as $item): ?>
                <li class="breadcrumb-item" <?=($item['id'] == -1) ? 'aria-current="page"' : ''?>>
                    <?php if ($item['id'] != -1): ?>
                        <a href="/site/catalog/<?=$item['id']?>"><?=$item['name']?></a>
                    <?php else:?>
                        <?=$item['name']?>
                    <?php endif;?>
                </li>


                <?php endforeach;?>
            </ol>
        </nav>
    </div>
<?php endif;?>
<?php if ($typepage == 'search'): ?>
    <div class="row pt-3"><h3>По вашему запросу "<?=$search?>" найдено <?=$total?> товара(ов):</h3></div>
<?php endif;?>
<div class="row">
    <?php foreach ($products as $item): ?>
        <div class="col-lg-3 col-md-6 col-sm-12 p-1">


            <div class="card" style=" background-color: #ffffff">

                <img src="<?=$item->imagefile?>" class="card-img-top" title="ВНИМАНИЕ!<?="\n"?>Внешний вид товара, <?="\n"?>может отличаться от данной иллюстрации">
                <div class="card-body p-3">
                    <h6 class="card-title" style="height: 60px"><a href="/product/index/<?=$item->id; ?>" style="color: black" title="<?=$item->name; ?>"><?=_f::shortname($item->name); ?></a></h6>
                    <p class="card-text align-content-end pb-1" style="text-align: right; font-size: 30px;">
                        <?=number_format($item->price, 2, ',', ' ');?>
                        <span style="color: #6c757d">&#8381;</span>
                    </p>
                    <small class="text-muted align-content-end" ><br>На складе: <?=$item->remains . ' ' . $item->unit; ?> </small>
                </div>
                <div class="card-footer pl-0 pb-2 pr-0 text-center" style="background: #ffffff;">
                    <?php if ($item->remains == 0): ?>
                        <p>Нет на складе</p>
                    <?php else: ?>
                        <?php if(!isset($_SESSION['auth'])):?>
                            <a href="/user/login" class="btn btn-primary" data_id="<?=$item->id; ?>" data_type="1">В корзину</a>
                        <?php else: ?>
                            <a href="#" class="btn btn-primary change_cart" data_id="<?=$item->id; ?>" data_type="1">В корзину</a>
                        <?php endif;?>
                    <?php endif;?>
                </div>
            </div>



        </div>
    <?php endforeach; ?>

</div>
<?php if ($typepage <> 'recom'): ?>
    <nav aria-label="Page navigation example"><?php echo $pagination->get(); ?></nav>
<?php endif;?>
