<h2>Изменить пароль</h2>
<form class="col-md-8" method="post" action="#" id="password_form">

    <div class="form-group mb-2">
        <label for="password" class="form-control-sm m-0">Старый пароль</label>
        <input type="password" class="form-control form-control-sm <?=isset($errors['passwordold']) ? 'is-invalid' : '';?>" id="passwordold" name="passwordold" placeholder="Введите пароль">
        <?php if (isset($errors['passwordold'])):?>
            <div class="invalid-feedback"><?=$errors['passwordold'];?></div>
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
    <button type="submit" class="btn btn-default" id="password_submit" name="submit">Сохранить</button>
</form>