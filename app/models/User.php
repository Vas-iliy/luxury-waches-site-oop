<?php


namespace app\models;


class User extends AppModel
{
    public $attributes = [
        'login' => '',
        'password' => '',
        'name' => '',
        'email' => '',
        'address' => '',
    ];

    public $rules = [
      'required' => [
          ['login'],
          ['password'],
          ['name'],
          ['email'],
          ['login'],
          ['address']
      ]  ,
        'email' => [
            ['email']
        ],
        'lengthMin' => [
            ['password', 6]
        ]
    ];

    public function checkUnique() {
        $user = \R::findOne('users', 'login = ? OR email = ?', [$this->attributes['login'], $this->attributes['email']]);
        if ($user) {
            if ($user->login == $this->attributes['login']) {
                $this->errors['unique'][] = 'Ха, ЛОХ. Логин занят';
            }
            if ($user->email == $this->attributes['email']) {
                $this->errors['unique'][] = 'Эмм, почта как бы занята';
            }
            return false;
        }
        return  true;
    }

    public function login($isAdmin = false) {
        $login = !empty(trim($_POST['login'])) ? trim($_POST['login']) : null;
        $password = !empty(trim($_POST['password'])) ? trim($_POST['password']) : null;
        if ($login && $password) {
            if ($isAdmin) {
                $user = \R::findOne('users', 'login = ? AND role = admin', [$login]);
            }
            else {
                $user = \R::findOne('users', 'login = ?', [$login]);
            }
            if ($user) {
                if (password_verify($password, $user->password)) {
                    $token = substr(bin2hex(random_bytes(256)), 0, 256);
                    $session = \R::dispense('sessions');
                    $session->id_user = $user->id; $session->token = $token;
                    \R::store($session);
                    if ($_POST['remember']) {
                        setcookie('token', $token, time()+3600*24*30, '/');
                    }
                    $_SESSION['token'] = $token;
                    return true;
                }
            }
        }
        return false;
    }

    public static function getUser() {
        $user = null;
        $token = $_SESSION['token'] ?? $_COOKIE['token'] ?? '';

        if (isset($token)) {
            $session = \R::findOne('sessions', 'token = ?', [$token]);

            if ($session) {
                $user = \R::getRow('SELECT id, login, email, name, address FROM users WHERE id = ?', [$session->id_user]);
            }

            if (!$user) {
                unset($_SESSION['token']);
                setcookie('token', '', time() - 1);
            }
        }

        return $user;
    }
}