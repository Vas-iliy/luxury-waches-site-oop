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
            if (!$user->validate($data) || !$user->checkUnique($this->user)) {
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
            redirect(PATH.'/user/cabinet');
        }
        $this->setMeta('Вход');
    }

    public function logoutAction() {
        if (isset($_SESSION['token']) || isset($_COOKIE['token'])) {
            unset($_SESSION['token']);
            setcookie('token', '', time() - 1, '/');
        }
        redirect(PATH);
    }

    public function cabinetAction() {
        if (empty($this->user)) redirect();
        $this->setMeta('Cabinet');
    }

    public function editAction() {
        if (empty($this->user)) redirect(PATH . '/user/login');
        if (!empty($_POST)) {
            $user = new User;
            $data = $_POST;
            $user->load($data);
            $user->attributes['id'] = $this->user['id'];
            if (!$user->attributes['password']) {
                unset($user->attributes['password']);
                foreach ($user->rules as $key => $rule) {
                    foreach ($rule as $k => $attr) {
                        foreach ($attr as $item) {
                            if ($item === 'password') {
                                unset($user->rules[$key][$k]);
                            }
                        }
                    }
                }
            }
            else {
                $user->attributes['password'] = password_hash($user->attributes['password'], PASSWORD_DEFAULT);
            }
            if (!$user->validate($data) || !$user->checkUnique($this->user)) {
                $user->getErrors();
                $this->set(compact('data'));
            }
            else {
                if ($user->update('users', $this->user['id'])) {
                    if (!empty($_SESSION['token'])) {
                        unset($_SESSION['token']);
                    }
                    setcookie('token', '', time() - 1);
                    $_SESSION['success'] = 'Вы успешно изменили данные. Войдите в аккаунт чтобы убедиться в этом!';
                    redirect(PATH . '/user/login');
                    die();
                }
            }
        }
        $user = $this->user;
        $this->set(compact('user'));
        $this->setMeta('User');
    }

    public function ordersAction() {
        if (empty($this->user)) redirect(PATH . '/user/login');
        $orders = \R::findAll('orders', "id_user = ?", [$this->user['id']]);
        $this->setMeta('Store orders');
        $this->set(compact('orders'));
    }

    public function orderAction() {
        if (empty($this->user)) redirect(PATH . '/user/login');
        if (empty(h(trim((int)$_GET['id'])))) redirect();
        $id_order = h(trim((int)$_GET['id']));
        $order = \R::findOne('orders', 'id = ?', [$id_order]);
        $order_products = \R::findAll('order_products', 'id_order = ?', [$id_order]);
        $this->set(compact('order', 'order_products'));
        $this->setMeta("Order № $id_order");

    }
}