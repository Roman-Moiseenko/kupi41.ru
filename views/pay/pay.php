<h3>Заказ № <?=$idorder;?> сформирован.</h3>
<h6>В ближащее время он будет поставлен в очередь на формирование</h6>
<?php if (isset($_SESSION['invoice'])):?>
    <div class="row">
        <div class="col-12">
            <h6>Срок действия счета 7 календарных дней, если не оговорено отдельно в договоре, в течении которых его необходимо оплатить.</h6>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <?php unset($_SESSION['invoice']);;?>
            <a href="/pay/paydoc/<?=$idorder?>" class=""> Загрузить счет на оплату</a>
        </div>
    </div>
<?php endif;?>

<div class="row pt-5">
    <div class="col-12">
        <a href="/" class="btn btn-primary"> Вернуться на главную</a>
    </div>
</div>