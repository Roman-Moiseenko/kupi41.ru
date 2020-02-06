<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 13.02.2019
 * Time: 22:41
 */

class Info extends ModelTable
{
    public $safe = array('id', 'name', 'INN', 'KPP', 'OGRN', 'BIK', 'bank', 'account', 'delivery','accountbank','address','director', 'accountant','phone','freedelivery');
    const TABLE_NAME = 'info';
    public function load()
    {
        $sql = 'SELECT * FROM ' . self::TABLE_NAME . ' WHERE current = 1';
        $items = App::gI()->db->query($sql);
        if ($items != false) $this->__attributes = $items[0];
    }
    public function beforeSave()
    {
        $this->errors = null;
        if ((int)$this->delivery < 100) $this->errors['delivery'] = 'Слишком дешевая доставка!';
        if ((int)$this->freedelivery < 1000) $this->errors['freedelivery'] = 'Слишком низкий порог!';
        if (strlen($this->phone) < 4 || strlen($this->phone) > 11) $this->errors['phone'] = 'Неверная длина телефона';
        if (strlen($this->name) < 6) $this->errors['namefirm'] = 'Слишком короткое название фирмы';
        if (strlen($this->INN) != 10 && strlen($this->INN) != 12) $this->errors['INN'] = 'Неверная длина ИНН';
        if (strlen($this->INN) == 10 && strlen($this->KPP) != 9) $this->errors['KPP'] = 'Неверная длина КПП';
        if (strlen($this->INN) == 12 && strlen($this->KPP) != 0) $this->errors['KPP'] = 'Неверная длина КПП';
        if (strlen($this->OGRN) != 13) $this->errors['OGRN'] = 'Неверная длина ОГРН';
        if (strlen($this->BIK) != 9) $this->errors['BIK'] = 'Неверная длина БИК';
        if (strlen($this->bank) < 6) $this->errors['bank'] = 'Слишком короткое название банка';
        if (strlen($this->account) != 20) $this->errors['account'] = 'Неверная длина № счета';
        if (strlen($this->accountbank) != 20) $this->errors['accountbank'] = 'Неверная длина № счета';
        if (strlen($this->address) < 10) $this->errors['address'] = 'Адрес должен быть введен';

        return parent::beforeSave();

    }
}