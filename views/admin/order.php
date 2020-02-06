<h2>Заказы покупателей (ручной режим)</h2>
<table class="table">
    <thead>
    <tr>
        <th scope="col">Заказ</th>
        <th scope="col">Клиент (Ф.И.О.)</th>
        <th scope="col">Телефон</th>
        <th scope="col">Сумма</th>
        <th scope="col">Статус</th>
        <th scope="col">Отменить</th>
        <th scope="col">Выгрузить</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($orders_arr as $idorder => $order):?>
    <tr>
        <td><?='№ ' . $idorder . ' от ' . $order['dateorder'];?></td>
        <td><?=$order['user'];?></td>
        <td><?=$order['phone'];?></td>
        <td><?=$order['total'];?></td>
        <td><?=$order['orderstatus'];?></td>
        <td><form action="/order/del/<?=$idorder?>" method="post"><button class="btn btn-outline-danger"><i class="fas fa-trash-alt"></i></button></form></td>
        <td><form action="/order/unload/<?=$idorder?>" method="post"><button class="btn btn-outline-success "><i class="fas fa-file-import"></i></button></form></td>

    </tr>
    <?php endforeach;?>
</tbody>
</table>