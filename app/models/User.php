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
}