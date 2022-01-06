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
        $sql_part = '';
        foreach ($_SESSION['cart'] as $idProduct => $product) {
            $idProduct = (int)$idProduct;
            $sql_part .= "($idOrder, $idProduct, {$product['qty']}, '{$product['title']}-({$product['size']})', {$product['price']}),";
        }
        $sql_part = rtrim($sql_part, ',');
        \R::exec("INSERT INTO order_products (id_order, id_product, qty, title, price) VALUES $sql_part");

    }

    public static function mailOrder($idOrder, $user_email) {

    }


}