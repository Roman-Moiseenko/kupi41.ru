<h1>Сертификаты</h1>
<div class="row">
        <?php foreach ($certificates as $certificate): ?>
            <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <div class="card border-info mt-2">
                    <div class="p-1 card-header text-center"><h5><?=$certificate->name?></h5></div>
                    <a href="<?=App::gI()->config->cert.$certificate->filename;?>" target="_blank"><img src="/assets/images/cert.jpg" class="card-img-top pl-5 pr-5 pt-1"></a>
                    <div class="card-body" style="height: 150px ">
                        <div><?=$certificate->descr?></div>
                        <div><a href="<?=$certificate->link?>" target="_blank">Сайт производителя</a></div>
                    </div>
                    <div class="card-footer text-center">
                        <a href="<?=App::gI()->config->cert.$certificate->filename;?>"  target="_blank" class="btn btn-primary">Загрузить</a>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
</div>