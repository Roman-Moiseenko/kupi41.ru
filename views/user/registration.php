<h2>Регистрация нового пользователя</h2>
<form class="col-md-8" method="post" action="#" id="registration_form">
    <div class="row">
        <div class="col">
            <div class="form-group mb-2">
                <label for="firstname" class="form-control-sm m-0">Имя</label>
                <input type="text" class="form-control form-control-sm only_text <?=isset($errors['firstname']) ? 'is-invalid' : '';?>" id="firstname" name="firstname" placeholder="Введите имя"
                       value="<?=isset($model->firstname) ? $model->firstname: '';?>">
                <?php if (isset($errors['firstname'])):?>
                    <div class="invalid-feedback"><?=$errors['firstname'];?></div>
                <?php endif;?>
            </div>
        </div>
        <div class="col">
            <div class="form-group mb-2">
                <label for="secondname" class="form-control-sm m-0">Отчество</label>
                <input type="text" class="form-control form-control-sm only_text <?=isset($errors['secondname']) ? 'is-invalid' : '';?>" id="secondname" name="secondname" placeholder="Введите отчество"
                       value="<?=isset($model->secondname) ? $model->secondname: '';?>">
                <?php if (isset($errors['secondname'])):?>
                    <div class="invalid-feedback"><?=$errors['secondname'];?></div>
                <?php endif;?>
            </div>
        </div>
    </div>
    <div class="form-group mb-2">
        <label for="lastname" class="form-control-sm m-0">Фамилия</label>
        <input type="text" class="form-control form-control-sm only_text <?=isset($errors['lastname']) ? 'is-invalid' : '';?>" id="lastname" name="lastname" placeholder="Введите фамилию"
               value="<?=isset($model->lastname) ? $model->lastname: '';?>">
        <?php if (isset($errors['lastname'])):?>
            <div class="invalid-feedback"><?=$errors['lastname'];?></div>
        <?php endif;?>
    </div>
    <div class="row">
        <div class="col">
            <div class="form-group mb-2">
                <label for="email" class="form-control-sm m-0">Email</label>
                <input type="email" class="form-control form-control-sm <?=isset($errors['email']) ? 'is-invalid' : '';?>" id="email" name="email" placeholder="Введите email"
                    value="<?=isset($model->email) ? $model->email: '';?>">
                <?php if (isset($errors['email'])):?>
                    <div class="invalid-feedback"><?=$errors['email'];?></div>
                <?php endif;?>
           </div>
        </div>
        <div class="col">
            <div class="form-group mb-2">
                <label for="phone" class="form-control-sm m-0">Телефон</label>
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend ">
                        <div class="input-group-text"><i class="fas fa-phone"></i></div>
                    </div>
                <input type="text" class="form-control form-control-sm only_dig <?=isset($errors['phone']) ? 'is-invalid' : '';?>" id="phone" name="phone" placeholder="Введите телефон"
                    value="<?=isset($model->phone) ? $model->phone: '';?>">

                <?php if (isset($errors['phone'])):?>
                    <div class="invalid-feedback"><?=$errors['phone'];?></div>
                <?php endif;?>
                </div>
            </div>
        </div>
    </div>
    <div class="form-group mb-2">
        <label for="address" class="form-control-sm m-0">Адрес</label>
        <input type="text" class="form-control form-control-sm only_text <?=isset($errors['address']) ? 'is-invalid' : '';?>" id="address" name="address" placeholder="Введите адрес"
               value="<?=isset($model->address) ? $model->address: '';?>">
        <?php if (isset($errors['address'])):?>
            <div class="invalid-feedback"><?=$errors['address'];?></div>
        <?php endif;?>
    </div>

    <div class="form-group mb-2">
        <label for="password" class="form-control-sm m-0">Пароль</label>
        <input type="password" class="form-control form-control-sm <?=isset($errors['password']) ? 'is-invalid' : '';?>" id="password" name="password" placeholder="Введите пароль">
        <?php if (isset($errors['password'])):?>
            <div class="invalid-feedback"><?=$errors['password'];?></div>
        <?php endif;?>
    </div>
    <div class="form-group mb-2">
        <label for="password2" class="form-control-sm m-0">Повторите пароль</label>
        <input type="password" class="form-control form-control-sm" id="password2" placeholder="Повторите пароль">
        <div id="error_password_2" class="invalid-feedback" style="display: none">Пароли не совпадают</div>
    </div>
    <input type="text" id="firm" name="firm" style="display: none;" value="">
    <!-- СВЕДЕНИЯ ОБ ОРГАНИЗАЦИИ -->
    <div class="form-group form-check">
        <input type="checkbox" class="form-check-input form-control-sm" id="firmcheck" data-toggle="collapse"
               data-target="#collapseFirm" aria-expanded="false" aria-controls="collapseFirm"
               <?=isset($firm) ? 'checked' : '';?> >
        <label class="form-check-label form-control-sm" for="firmcheck" data-toggle="collapse" data-target="#collapseFirm" aria-expanded="false" aria-controls="collapseFirm">Зарегистрироваться как юридическое лицо</label>
    </div>
    <div class="collapse <?=isset($firm) ? 'show' : '';?>" id="collapseFirm">
        <div class="form-group mb-2">
            <label for="namefirm" class="form-control-sm m-0">Организация</label>
            <input type="text" class="form-control form-control-sm only_text <?=isset($errors['namefirm']) ? 'is-invalid' : '';?>" id="namefirm"  name="namefirm" placeholder="Введите наименование организации"
                   value="<?=isset($firm) ? $firm['namefirm']: '';?>">
            <?php if (isset($errors['namefirm'])):?>
                <div class="invalid-feedback"><?=$errors['namefirm'];?></div>
            <?php endif;?>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group mb-2">
                    <label for="INN" class="form-control-sm m-0">ИНН</label>
                    <input type="text" class="form-control form-control-sm only_dig <?=isset($errors['INN']) ? 'is-invalid' : '';?>" id="INN"  name="INN" placeholder="Введите ИНН организации"
                           value="<?=isset($firm) ? $firm['INN']: '';?>">
                    <?php if (isset($errors['INN'])):?>
                        <div class="invalid-feedback"><?=$errors['INN'];?></div>
                    <?php endif;?>
                </div>
            </div>
            <div class="col">
                <div class="form-group mb-2">
                    <label for="KPP" class="form-control-sm m-0">КПП</label>
                    <input type="text" class="form-control form-control-sm only_dig <?=isset($errors['KPP']) ? 'is-invalid' : '';?>" id="KPP" name="KPP" placeholder="Введите КПП организации"
                           value="<?=isset($firm) ? $firm['KPP']: '';?>">
                    <?php if (isset($errors['KPP'])):?>
                        <div class="invalid-feedback"><?=$errors['KPP'];?></div>
                    <?php endif;?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="form-group mb-2">
                    <label for="OGRN" class="form-control-sm m-0">ОГРН</label>
                    <input type="text" class="form-control form-control-sm only_dig <?=isset($errors['OGRN']) ? 'is-invalid' : '';?>" id="OGRN"  name="OGRN" placeholder="Введите ОГРН организации"
                           value="<?=isset($firm) ? $firm['OGRN']: '';?>">
                    <?php if (isset($errors['OGRN'])):?>
                        <div class="invalid-feedback"><?=$errors['OGRN'];?></div>
                    <?php endif;?>
                </div>
            </div>
            <div class="col">
                <div class="form-group mb-2">
                    <label for="BIK" class="form-control-sm m-0">БИК</label>
                    <input type="text" class="form-control form-control-sm only_dig <?=isset($errors['BIK']) ? 'is-invalid' : '';?>" id="BIK" name="BIK" placeholder="Введите БИК банка"
                           value="<?=isset($firm) ? $firm['BIK']: '';?>">
                    <?php if (isset($errors['BIK'])):?>
                        <div class="invalid-feedback"><?=$errors['BIK'];?></div>
                    <?php endif;?>
                </div>
            </div>
        </div>

        <div class="form-group mb-2">
            <label for="bank" class="form-control-sm m-0">Банк</label>
            <input type="text" class="form-control form-control-sm only_text <?=isset($errors['bank']) ? 'is-invalid' : '';?>" id="bank"  name="bank" placeholder="Введите наименование банка"
                   value="<?=isset($firm) ? $firm['bank']: '';?>">
            <?php if (isset($errors['bank'])):?>
                <div class="invalid-feedback"><?=$errors['bank'];?></div>
            <?php endif;?>
        </div>
        <div class="form-group mb-2">
            <label for="account" class="form-control-sm m-0">Счет</label>
            <input type="text" class="form-control form-control-sm only_dig <?=isset($errors['account']) ? 'is-invalid' : '';?>" id="account"  name="account" placeholder="Введите счет в банке"
                   value="<?=isset($firm) ? $firm['account']: '';?>">
            <?php if (isset($errors['account'])):?>
                <div class="invalid-feedback"><?=$errors['account'];?></div>
            <?php endif;?>
        </div>


    </div>
    <button type="submit" class="btn btn-default" id="registration_submit" name="submit">Зарегистрироваться</button>
</form>