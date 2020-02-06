<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 11.02.2019
 * Time: 0:11
 */

class User extends ModelTable
{
    public $safe = array('id', 'firstname', 'secondname', 'lastname', 'email', 'phone', 'address', 'role', 'cardpay', 'password', 'firm');
    //json firm = 'namefirm', 'INN', 'KPP', 'OGRN', 'BIK', 'bank', 'account'
    const TABLE_NAME = 'user';
    function beforeSave () {
        $this->errors = null;
        if (strlen($this->firstname) < 3) $this->errors['firstname'] = 'Слишком короткое имя';
        if (strlen($this->lastname) < 3) $this->errors['lastname'] = 'Слишком короткое имя';
        if (strlen($this->phone) < 4 || strlen($this->phone) > 11) $this->errors['phone'] = 'Неверная длина телефона';
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) $this->errors['email'] = 'Неправильное имя для почтового ящика';
        if (strlen($this->address) < 10) $this->errors['address'] = 'Адрес должен быть введен';
        //$this->errors['password'] = $this->validatePassword($this->password);
        if (isset($this->password)) {
            $this->errors['password'] = (strlen($this->password) < 6) ? 'Слишком короткий пароль, не менее 6 символов' : null;
            //Другие проверки пароля
        };
        if (!$this->emailExist()) $this->errors['email'] = 'Такой почтовый ящик уже существует';
        //$this->validatePassword($this->password);
        //echo $this->firm;
        if ($this->firm != '') {
            //Валидация полей фирм
            $arr= (array)json_decode($this->firm);
          //  print_r($arr);
            if (strlen($arr['namefirm']) < 6) $this->errors['namefirm'] = 'Слишком короткое название фирмы';
            if (strlen($arr['INN']) != 10 && strlen($arr['INN']) != 12) $this->errors['INN'] = 'Неверная длина ИНН';
            if (strlen($arr['INN']) == 10 && strlen($arr['KPP']) != 9) $this->errors['KPP'] = 'Неверная длина КПП';
            if (strlen($arr['INN']) == 12 && strlen($arr['KPP']) != 0) $this->errors['KPP'] = 'Неверная длина КПП';
            if (strlen($arr['OGRN']) != 13) $this->errors['OGRN'] = 'Неверная длина ОГРН';
            if (strlen($arr['BIK']) != 9) $this->errors['BIK'] = 'Неверная длина БИК';
            if (strlen($arr['bank']) < 6) $this->errors['bank'] = 'Слишком короткое название банка';
            if (strlen($arr['account']) != 20) $this->errors['account'] = 'Неверная длина № счета';
        }
        return parent::beforeSave();
    }
    static public function validatePassword($password)
    {
        if (strlen($password) < 6) {$errors = 'Длина пароля должна быть не менее 6 символов!'; return $errors;}
        //TODO Валидация пароля на сложность
        return null;
    }
    public function savePassword($password)
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        //Если пользователь не зашел в систему - recovery
        if (!isset(App::gI()->user->id))
        {
            $items = App::gI()->db->queryPrepare('SELECT id FROM ' .self::TABLE_NAME . ' WHERE email = :email',
                array('email' => $this->email));
            $id = $items[0]['id'];
        } else {
            $id = $this->__get(self::PRIMARY_NAME);
        }

        App::gI()->db->update(self::TABLE_NAME, array('password' => $hash), $id);
        $this->password = $hash;
    }
    public function load()  //Загрузка данных пользователя по email!!! а не по id!!! /-- либо primery = email но тогда нельзя менять email
    {
        $items = App::gI()->db->queryPrepare('SELECT * FROM ' . self::TABLE_NAME . ' WHERE email = :email',
            array('email' => $this->email));
        if($items == false) return false; //нет такого пользователя
        //проверка пароля
        $hash = $items[0]['password'];
        if (!password_verify($this->password, $hash)) return false; //неверный пароль
        $this->__attributes = $items[0];
        return true;
    }
    public function emailExist() //существует email уже
    {
        if (!is_numeric($this->id)) {
            //новый пользователь
            $row = App::gI()->db->queryPrepare('SELECT COUNT(*) as count FROM '. self::TABLE_NAME . ' WHERE email = :email',
                            array('email' => $this->email));
        } else {
            //уже имеющийся, но изменивший email
            $row = App::gI()->db->queryPrepare('SELECT COUNT(*) as count FROM '. self::TABLE_NAME . ' WHERE email = :email AND id != :id',
                array('email' => $this->email, 'id' => $this->id));
        }
        if ($row[0]['count'] != 0) return false; //Такой email есть уже у другого пользователя
        return true;
    }
    public static function generatePassword($number = 6)
    {
        $arr = array('a','b','c','d','e','f',
            'g','h','i','j','k','l',
            'm','n','o','p','r','s',
            't','u','v','x','y','z',
            'A','B','C','D','E','F',
            'G','H','I','J','K','L',
            'M','N','O','P','R','S',
            'T','U','V','X','Y','Z',
            '1','2','3','4','5','6',
            '7','8','9','0');
        // Генерируем пароль
        $pass = "";
        for($i = 0; $i < $number; $i++)
        {
            // Вычисляем случайный индекс массива
            $index = rand(0, count($arr) - 1);
            $pass .= $arr[$index];
        }
        return $pass;
    }

}



