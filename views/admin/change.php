<h2>Обмен с 1С (ручной режим)</h2>


<form class="" action="#" method="post" enctype="multipart/form-data">
<div class="d-flex flex-row pt-3">
    <div class="form-group mb-2 col-md-6">
        <label for="filename" class="form-control-sm m-0">Загрузить группы товаров</label>
        <div class="custom-file ">
            <input type="file" class="custom-file-input choose_file " id="filename" name="filename">
            <label class="custom-file-label" for="filename">Выберите файл</label>
        </div>
    </div>
    <div class="d-flex align-items-end">
        <input type="submit" class="btn btn-success mb-2" name="loadcatalog" value="Загрузить">
    </div>
</div>
</form>

<form class="" action="#" method="post" enctype="multipart/form-data">
    <div class="d-flex flex-row pt-3">
        <div class="form-group mb-2 col-md-6">
            <label for="filename" class="form-control-sm m-0">Загрузить товары</label>
            <div class="custom-file ">
                <input type="file" class="custom-file-input choose_file " id="filename" name="filename">
                <label class="custom-file-label" for="filename">Выберите файл</label>
            </div>
        </div>
        <div class="d-flex align-items-end">
            <input type="submit" class="btn btn-success mb-2" name="loadproduct" value="Загрузить">
        </div>
    </div>
</form>

<form class="" action="#" method="post" enctype="multipart/form-data">
    <div class="d-flex flex-row pt-3">
        <div class="form-group mb-2 col-md-6">
            <label for="filename" class="form-control-sm m-0">Загрузить свойства товаров</label>
            <div class="custom-file ">
                <input type="file" class="custom-file-input choose_file " id="filename" name="filename">
                <label class="custom-file-label" for="filename">Выберите файл</label>
            </div>
        </div>
        <div class="d-flex align-items-end">
            <input type="submit" class="btn btn-success mb-2" name="loadproperty" value="Загрузить">
        </div>
    </div>
</form>

<form class="" action="#" method="post" enctype="multipart/form-data">
    <div class="d-flex flex-row pt-3">
        <div class="form-group mb-2 col-md-6">
            <label for="filename" class="form-control-sm m-0">Загрузить заявку</label>
            <div class="custom-file ">
                <input type="file" class="custom-file-input choose_file " id="filename" name="filename" disabled>
                <label class="custom-file-label" for="filename">Выберите файл</label>
            </div>
        </div>
        <div class="d-flex align-items-end">
            <input type="submit" class="btn btn-success mb-2" name="loadorder" value="Загрузить" disabled>
        </div>
    </div>
</form>