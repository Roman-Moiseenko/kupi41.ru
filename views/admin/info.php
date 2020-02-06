

<form class="col-md-8" method="post" action="#" id="admin_form">

    <div class="d-flex flex-column">
        <div><h3>Настройки доставки</h3></div>
        <div class="row">
            <div class="form-group mb-2 col-6">
                <label for="delivery" class="form-control-sm m-0">Стоимость доставки</label>
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend ">
                        <div class="input-group-text">&#8381;</div>
                    </div>
                    <input type="text" class="form-control form-control-sm only_dig <?=isset($errors['delivery']) ? 'is-invalid' : '';?>" id="delivery" name="delivery" placeholder=""
                           value="<?=isset($model->delivery) ? $model->delivery : '';?>">
                    <?php if (isset($errors['delivery'])): ?>
                        <div class="invalid-feedback"><?=$errors['delivery'];?></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group mb-2 col-6">
                <label for="freedelivery" class="form-control-sm m-0">Порог бесплатной доставки</label>
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend ">
                        <div class="input-group-text">&#8381;</div>
                    </div>
                    <input type="text" class="form-control form-control-sm only_dig <?=isset($errors['freedelivery']) ? 'is-invalid' : '';?>" id="freedelivery" name="freedelivery" placeholder=""
                           value="<?=isset($model->freedelivery) ? $model->freedelivery : '';?>">

                    <?php if (isset($errors['freedelivery'])): ?>
                        <div class="invalid-feedback"><?=$errors['freedelivery'];?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="form-group mb-2">
            <label for="phone" class="form-control-sm m-0">Телефон ответственного</label>
            <div class="input-group input-group-sm">
                <div class="input-group-prepend ">
                    <div class="input-group-text"><i class="fas fa-phone"></i></div>
                </div>
                <input type="text" class="form-control form-control-sm only_dig <?=isset($errors['phone']) ? 'is-invalid' : '';?>" id="phone" name="phone" placeholder=""
                       value="<?=isset($model->phone) ? $model->phone : '';?>">

                <?php if (isset($errors['phone'])): ?>
                    <div class="invalid-feedback"><?=$errors['phone'];?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="pt3"><h3>Сведения об организации (для счетов)</h3></div>

        <div class="form-group mb-2">
            <label for="name" class="form-control-sm m-0">Наименование организации</label>
            <input type="text" class="form-control form-control-sm only_text <?=isset($errors['name']) ? 'is-invalid' : '';?>" id="name" name="name" placeholder=""
                   value="<?=isset($model->name) ? $model->name : '';?>">
            <?php if (isset($errors['name'])): ?>
                <div class="invalid-feedback"><?=$errors['name'];?></div>
            <?php endif; ?>
        </div>
        <div class="row">
            <div class="form-group mb-2 col-6">
                <label for="INN" class="form-control-sm m-0">ИНН</label>
                <input type="text" class="form-control form-control-sm only_dig <?=isset($errors['INN']) ? 'is-invalid' : '';?>" id="INN" name="INN" placeholder=""
                       value="<?=isset($model->INN) ? $model->INN : '';?>">
                <?php if (isset($errors['INN'])): ?>
                    <div class="invalid-feedback"><?=$errors['INN'];?></div>
                <?php endif; ?>
            </div>
            <div class="form-group mb-2 col-6">
                <label for="KPP" class="form-control-sm m-0">КПП</label>
                <input type="text" class="form-control form-control-sm only_dig <?=isset($errors['KPP']) ? 'is-invalid' : '';?>" id="KPP" name="KPP" placeholder=""
                       value="<?=isset($model->KPP) ? $model->KPP : '';?>">
                <?php if (isset($errors['KPP'])): ?>
                    <div class="invalid-feedback"><?=$errors['KPP'];?></div>
                <?php endif; ?>
            </div>
        </div>
            <div class="form-group mb-2">
                <label for="OGRN" class="form-control-sm m-0">ОГРН</label>
                <input type="text" class="form-control form-control-sm only_dig <?=isset($errors['OGRN']) ? 'is-invalid' : '';?>" id="OGRN" name="OGRN" placeholder=""
                       value="<?=isset($model->OGRN) ? $model->OGRN : '';?>">
                <?php if (isset($errors['OGRN'])): ?>
                    <div class="invalid-feedback"><?=$errors['OGRN'];?></div>
                <?php endif; ?>
            </div>
        <div class="row pt-2">
            <div class="form-group mb-2 col-6">
                <label for="BIK" class="form-control-sm m-0">БИК</label>
                <input type="text" class="form-control form-control-sm only_dig <?=isset($errors['BIK']) ? 'is-invalid' : '';?>" id="BIK" name="BIK" placeholder=""
                       value="<?=isset($model->BIK) ? $model->BIK : '';?>">
                <?php if (isset($errors['BIK'])): ?>
                    <div class="invalid-feedback"><?=$errors['BIK'];?></div>
                <?php endif; ?>
            </div>
        <div class="form-group mb-2 col-6">
            <label for="accountbank" class="form-control-sm m-0">Кор.счет</label>
            <input type="text" class="form-control form-control-sm only_dig <?=isset($errors['accountbank']) ? 'is-invalid' : '';?>" id="accountbank" name="accountbank" placeholder=""
                   value="<?=isset($model->accountbank) ? $model->accountbank : '';?>">
            <?php if (isset($errors['accountbank'])): ?>
                <div class="invalid-feedback"><?=$errors['accountbank'];?></div>
            <?php endif; ?>
        </div>
    </div>

            <div class="form-group mb-2 ">
                <label for="bank" class="form-control-sm m-0">Банк</label>
                <input type="text" class="form-control form-control-sm only_text <?=isset($errors['bank']) ? 'is-invalid' : '';?>" id="bank" name="bank" placeholder=""
                       value="<?=isset($model->bank) ? $model->bank : '';?>">
                <?php if (isset($errors['bank'])): ?>
                    <div class="invalid-feedback"><?=$errors['bank'];?></div>
                <?php endif; ?>
            </div>

            <div class="form-group mb-2 ">
                <label for="account" class="form-control-sm m-0">Расч.счет</label>
                <input type="text" class="form-control form-control-sm only_dig <?=isset($errors['account']) ? 'is-invalid' : '';?>" id="account" name="account" placeholder=""
                       value="<?=isset($model->account) ? $model->account : '';?>">
                <?php if (isset($errors['account'])): ?>
                    <div class="invalid-feedback"><?=$errors['account'];?></div>
                <?php endif; ?>
            </div>

        <div class="row">
            <div class="form-group mb-2 col-6">
                <label for="director" class="form-control-sm m-0">Руководитель (Фамилия И.О.)</label>
                <input type="text" class="form-control form-control-sm only_text <?=isset($errors['director']) ? 'is-invalid' : '';?>" id="director" name="director" placeholder=""
                       value="<?=isset($model->director) ? $model->director : '';?>">
                <?php if (isset($errors['director'])): ?>
                    <div class="invalid-feedback"><?=$errors['director'];?></div>
                <?php endif; ?>
            </div>
            <div class="form-group mb-2 col-6">
                <label for="accountant" class="form-control-sm m-0">Главный бухгалтер (Фамилия И.О.)</label>
                <input type="text" class="form-control form-control-sm only_text <?=isset($errors['accountant']) ? 'is-invalid' : '';?>" id="accountant" name="accountant" placeholder=""
                       value="<?=isset($model->accountant) ? $model->accountant : '';?>">
                <?php if (isset($errors['accountant'])): ?>
                    <div class="invalid-feedback"><?=$errors['accountant'];?></div>
                <?php endif; ?>
            </div>
        </div>


    </div>
<button type="submit" class="btn btn-default" id="admin_submit" name="submit">Сохранить</button>
</form>