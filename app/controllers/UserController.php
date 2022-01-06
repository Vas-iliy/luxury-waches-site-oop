<?php

namespace app\controllers;

use app\models\User;

class UserController extends AppController
{
    public function signupAction() {
        if (!empty($_POST)) {
            $user = new User();
            $data = $_POST;
            $user->load($data);
            if (!$user->validate($data) || !$user->checkUnique()) {
                $user->getErrors();
                $this->set(compact('data'));
            }
            else {
                $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
                if ($user->save('users')) {
                    $_SESSION['success'] = 'Вы успешно зарегистрированы';
                }
                else {
                    $_SESSION['error'] = 'Ошибка';
                }
                redirect(PATH );
            }
        }
        $this->setMeta('Регистрация');
    }

    public function loginAction() {
        if (!empty($_POST)) {
            $user = new User();
            if ($user->login()) {
                $_SESSION['success'] = 'Вы успешно авторизованы';;
            }
            else {
                $_SESSION['error'] = 'Логин/пароль введены неверно';
            }
            redirect(PATH);
        }
        $this->setMeta('Вход');
    }

    public function logoutAction() {
        if (isset($_SESSION['token']) || isset($_COOKIE['token'])) {
            unset($_SESSION['token']);
            setcookie('token', '', time() - 1, '/');
        }
        redirect();
    }
}