<?php
/**
 * Created by PhpStorm.
 * User: Роман
 * Date: 11.02.2019
 * Time: 0:10
 */

class UserController extends Controller
{
    const USER_CABINET_EDITDATA = 1;
    const USER_CABINET_EDITPASSWORD = 2;
    const USER_CABINET_ARCH = 3;
    const USER_CABINET_ECHECK = 4;
    public $layout ='tpl_user';
    private function user_activ($active)
    {
        $_SESSION['user_activ'] = array_fill(self::USER_CABINET_EDITDATA, self::USER_CABINET_ECHECK, '');
        $_SESSION['user_activ'][$active] = 'active';
    }
    function actionIndex() //Кабинет пользователя
    {
        $ajaxcall = isset($_POST['AjaxCall']) ? true : false;
        if (!isset($_SESSION['auth'])) {header('Location: /user/login'); return false;}
        $this->user_activ(self::USER_CABINET_EDITDATA);
        $firm = (App::gI()->user->firm != '') ? (array)json_decode(App::gI()->user->firm) : null;

        if (isset($_POST['submit']))
        {
            App::gI()->user->__attributes = $_POST;
            if (App::gI()->user->save() != false)
            {
                header('Location: /user/index');
                return true;
            }
        }
        $this->render('index', array('model' => App::gI()->user->__attributes,
            'errors' => App::gI()->user->errors,
            'firm' => $firm), $ajaxcall);
    }
    function actionLogin()
    {
        $error = null;
        $email = '';
        if (isset($_SESSION['temp_email'])) {$email = $_SESSION['temp_email']; unset($_SESSION['temp_email']);}
        $ajaxcall = isset($_POST['AjaxCall']) ? true : false;
        if (isset($_POST['email']) && isset($_POST['password'])) {
            App::gI()->user->email = $_POST['email'];
            App::gI()->user->password = $_POST['password'];
            if(App::gI()->user->load()) {
                //Запоминаем пользователя в сессии, загружаем данные из DB
                $_SESSION['auth'] = App::gI()->user->id;
                header('Location: /');
            } else {
                $error = 'Неверный логин или пароль';
                $email = $_POST['email'];
            }
        }
        $this->render('login', array('model' => $email, 'error' => $error), $ajaxcall);
    }
    function actionLogout()
    {
        if (isset($_SESSION['auth'])) unset($_SESSION['auth']);
        header('Location: /');
    }
    function actionRegistration()
    {
        $ajaxcall = isset($_POST['AjaxCall']) ? true : false;
        if (isset($_SESSION['auth'])) {header('Location: /user/index'); return false;} //Авторизованному пользователю запрещен вход
        $firm = null;
        if (isset($_POST['submit']))
        {
            unset($_POST['submit']);
            App::gI()->user->__attributes = $_POST;
            App::gI()->user->password = null;
            if (App::gI()->user->firm != '') $firm = (array)json_decode(App::gI()->user->firm);
            if (App::gI()->user->save() != false)
            {
                App::gI()->user->savePassword($_POST['password']);
                App::gI()->user->id = null;
                $_SESSION['temp_email'] = App::gI()->user->email;
                unset($_POST['password']);
                UserController::gI()->actionLogin();
                //header('Location: /user/login');
                return true;
            }
        }
        $this->render('registration',
                      array('model' => App::gI()->user->__attributes,
                            'errors' => App::gI()->user->errors,
                            'firm' => $firm), $ajaxcall);
    }
    function actionPassword()
    {
        $ajaxcall = isset($_POST['AjaxCall']) ? true : false;
        if (!isset($_SESSION['auth'])) {header('Location: /user/login'); return false;}
        $this->user_activ(self::USER_CABINET_EDITPASSWORD);
        $errors = null;
        if (isset($_POST['submit']))
        {
            if (!password_verify($_POST['passwordold'], App::gI()->user->password)) {
                $errors['passwordold'] = 'Неверный текущий пароль'; //неверный пароль
            }
            $_er = User::validatePassword($_POST['password']);
            if($_er != null) $errors['password'] = $_er;

            if (!isset($errors))
            {
                App::gI()->user->savePassword($_POST['password']);
                header('Location: /user/index');
                return true;
            }
        }
        $this->render('password', array('model' => App::gI()->user, 'errors' => $errors), $ajaxcall);
    }
    function actionPaydoc()
    {
        $ajaxcall = isset($_POST['AjaxCall']) ? true : false;
        if (!isset($_SESSION['auth'])) {header('Location: /user/login'); return false;}
        $this->user_activ(self::USER_CABINET_ECHECK);
        $paydocs = Paydoc::_models(App::gI()->user->id);
        $this->render('paydoc', array('paydocs' => $paydocs), $ajaxcall);
    }
    function actionRecovery()
    {
        $ajaxcall = isset($_POST['AjaxCall']) ? true : false;
        if (isset($_SESSION['auth'])) {header('Location: /user/index'); return false;} //Авторизованному пользователю запрещен вход
        $error = null;
        if (isset($_POST['submit'])) {
            //Проверяем существует ли такой email в базе
            App::gI()->user->email = $_POST['email'];
            if (!App::gI()->user->emailExist()) {
                //Если да, отправляем пароль
                $new_password =User::generatePassword();
                App::gI()->user->savePassword($new_password);
//echo $new_password;
                $headers = "From: Администрация сайта <admin@kupi41.ru> \r\n";
                $headers .= "Content-type: text/html; charset=utf-8 \r\n";

                $subject = '<h3> Восстановление пароля </h3><br> Ваш временный пароль '
                    . ' <span style="color: #2e6da4; font-weight: bold">' . $new_password . '</span> <br>'
                    . 'Не забудьте сменить пароль! <br>'
                    . 'С уважением администрация сайта <a href="http://kupi41.ru">kupi41.ru</a>';


                $result = mail(App::gI()->user->email, 'Восстановление пароля', $subject, $headers);
                if ($result == false) die('Почта не работает');
                $_SESSION['temp_email'] = App::gI()->user->email;
                UserController::gI()->actionLogin();
                return true;
            } else {
                //иначе, сообщение об ошибке
                $error = 'Пользователь с таким email не зарегистрирован!';
            }

        }
        $this->render('recovery',
            array('model' => App::gI()->user->email,
                'error' => $error), $ajaxcall);
    }

}