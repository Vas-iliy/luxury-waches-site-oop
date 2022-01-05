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
}