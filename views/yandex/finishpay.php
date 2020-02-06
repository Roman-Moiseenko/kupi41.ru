<?php if (isset($error)):?>
    <h3>Заказ отменен.</h3>
<?php else: ?>
    <h3>Заказ № <?=$idorder;?> оплачен.</h3>
    <h6>В ближащее время он будет поставлен в очередь на формирование</h6>
        <div class="row">
            <div class="col-12">
                <p>Электронный чек №<?=$numberpaydoc . ' от ' . $datepaydoc?> сформирован.</p>
            </div>
        </div>
<?php endif;?>
<div class="row pt-5">
    <div class="col-12">
        <a href="/" class="btn btn-primary"> Вернуться на главную</a>
    </div>
</div>

