<div class="row">
    <div class="col-12">
        <form action="#" method="post" class="">
            <div class="row">
                <div class="col-6">
                    <label>Фильтр товаров</label>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <input class="form-control" type="search" placeholder="введите ключевые слова, разделенные пробелом"
                           name="search_input_admin" id="search_input_admin" value="<?=isset($_SESSION['search_input_admin']) ? $_SESSION['search_input_admin'] : '';?>">
                </div>
                <div class="col-3">
                    <label>
                        <input type="checkbox" name="no_image" <?=isset($_SESSION['no_image']) ? 'checked' : ''?> > без изображений
                    </label>
                </div>
                <div class="col-3">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="search_admin" id="search_submit_admin">Показать</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Изображение</th>
                <th scope="col">Товар</th>
                <th scope="col">Реком</th>
                <th scope="col">Загрузить изображение</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($products as $product):?>
                <tr>
                    <td><img src="<?=$product->imagefile;?>" style="width: 40px; height: 40px"></td>
                    <td><?=$product->name;?></td>
                    <td><form action="#" method="post">
                            <input type="hidden" name="idproduct" value="<?=$product->id;?>">
                            <button class="btn btn-outline-<?=($product->recom == 1) ? 'warning' : 'info';?>" type="submit" name="submit_recom">
                                <i class="far fa-thumbs-<?=($product->recom == 1) ? 'up' : 'down';?>"></i>
                            </button></form></td>
                    <form action="#" method="post" enctype="multipart/form-data">
                        <td><input type="hidden" name="idproduct" value="<?=$product->id;?>">
                            <div class="custom-file">
                                <input class="custom-file-input choose_file" type="file" id="filename" name="filename">
                                <label class="custom-file-label" for="filename"><?=basename($product->imagefile);?></label>
                            </div>

                        </td>
                        <td><button class="btn btn-outline-success " type="submit" name="submit_image"><i class="fas fa-file-upload"></i></button></td>
                    </form>

                </tr>
            <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>