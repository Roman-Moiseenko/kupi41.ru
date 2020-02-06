<div class="row pt-5"></div>
<div class="col-md-6 rounded pt-0 pb-2" style="background: #ffffff">
    <h4 class="pt-3">Восстановление пароля</h4>
    <form class="col-sm-12" action="#" method="post">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control <?=isset($error) ? 'is-invalid' : '';?>" id="email" name="email" placeholder="Введите email" value="<?=isset($model) ? $model : '';?>" required>
            <?php if (isset($error)):?>
                <div class="invalid-feedback"><?=$error;?></div>
            <?php endif;?>
        </div>

        <div class="form-group">
            <button type="submit" name="submit" class="btn btn-default">Прислать новый пароль</button>
        </div>
    </form>
</div>

<div class="row" style="height: 250px"></div>