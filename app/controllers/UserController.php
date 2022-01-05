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
                redirect();
            }
        }
        $this->setMeta('Регистрация');
    }

    public function loginAction() {

    }

    public function logoutAction() {

    }
}