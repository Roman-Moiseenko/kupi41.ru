Загрузка сертификатов

<?php foreach ($certificates as $certificate): ?>
<form action="#" method="post"  enctype="multipart/form-data" class="col-12 p-0 m-0">
    <div class="container-fluid p-0 m-0">
    <div class="row rounded mt-1 mb-1">
        <input type="hidden" id="id" name="id" date-id="<?=$certificate->id?>" value="<?=$certificate->id?>" >
        <div class="col-sm-4 col-md-2 p-0 m-0"><input class="form-control" name="name" type="text" value="<?=$certificate->name?>" placeholder="Группа товаров"> </div>
        <div class="col-sm-6 col-md-4 p-0 m-0"> <input class="form-control" name="descr" type="text" value="<?=$certificate->descr?>" placeholder="Ключевые слова"> </div>
        <div class="col-sm-4 col-md-2 p-0 m-0"> <input class="form-control" name="link" type="text" value="<?=$certificate->link?>" placeholder="Ссылка на производителя"> </div>
        <div class="col-sm-4 col-md-2 col-lg-3 p-0 m-0">
            <div class="custom-file">
                <input type="file" class="custom-file-input choose_file" id="filename" name="filename">
                <label class="custom-file-label" for="filename"><?=($certificate->filename != '') ? $certificate->filename : 'Файл ...'?></label>
            </div>
        </div>
        <div class="col-sm-3 col-md-2 col-lg-1 p-0 m-0 align-content-end">
            <button type="submit" name="delete" class="btn btn-outline-danger"><i class="fas fa-trash-alt"></i></button>
            <button type="submit" name="save" class="btn btn-outline-success"><i class="far fa-save"></i></button>
        </div>
    </div>
    </div>
</form>


<?php endforeach;?>

<form action="#" method="post" class="col-12 p-0 m-0 pt-4">
    <button type="submit" name="new" class="btn btn-outline-primary"><i class="fas fa-folder-plus"></i> Добавить поле для сертификата</button>
</form>