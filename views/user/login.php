<div class="row pt-5"></div>
<div class="col-md-6 rounded pt-0 pb-2" style="background: #ffffff">
    <h1 class="pt-3">Войти на сайт</h1>
    <form class="col-sm-12" action="/user/login" method="post">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Введите email" value="<?=isset($model) ? $model : '';?>" required>
        </div>
        <div class="form-group">
            <label for="password">Пароль</label>
            <input type="password" class="form-control <?=isset($error) ? 'is-invalid' : '';?>" id="password" name="password" placeholder="Password" required>
            <?php if (isset($error)):?>
                <div class="invalid-feedback"><?=$error;?></div>
            <?php endif;?>
        </div>
        <div class="form-group">
        <button type="submit" class="btn btn-default">Войти</button>
        </div>
        <div class="text-center">
            <a href="/user/recovery" class="text-center pt-5" style="font-size: 14px">Забыли пароль?</a><br>
            <a href="/user/registration" class="text-center" style="font-size: 14px">Регистрация</a>
        </div>
    </form>
</div>

<div class="row" style="height: 250px"></div>
