<?php


namespace app\models;

use luxury\App;

class Order extends AppModel
{
    public static function saveOrder($data) {
        $order = new Order();
        $order->attributes = [
            'id_user' => $data['id_user'],
            'currency' => App::$app->getProperty('currency')['code'],
            'note' => $data['note']
        ];
        $idOrder = $order->save('orders');
        self::saveOrderProduct($idOrder);
        return $idOrder;
    }

    public static function saveOrderProduct($idOrder) {

    }

    public static function mailOrder($idOrder, $user_email) {

    }


}