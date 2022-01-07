<?php


namespace app\models;

use luxury\App;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

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
        // Create the Transport
        $transport = (new Swift_SmtpTransport(App::$app->getProperty('smtp_host'), App::$app->getProperty('smtp_port'), App::$app->getProperty('smtp_protocol')))
            ->setUsername(App::$app->getProperty('smtp_login'))
            ->setPassword(App::$app->getProperty('smtp_password'))
        ;
        // Create the Mailer using your created Transport
        $mailer = new Swift_Mailer($transport);

        // Create a message
        ob_start();
        require APP . '/views/mail/mail_order.php';
        $body = ob_get_clean();

        $message_client = (new Swift_Message("Вы совершили заказ №{$idOrder} на сайте " . App::$app->getProperty('shop_name')))
            ->setFrom([App::$app->getProperty('smtp_login') => App::$app->getProperty('shop_name')])
            ->setTo($user_email)
            ->setBody($body, 'text/html')
        ;

        $message_admin = (new Swift_Message("Сделан заказ №{$idOrder}"))
            ->setFrom([App::$app->getProperty('smtp_login') => App::$app->getProperty('shop_name')])
            ->setTo(App::$app->getProperty('admin_email'))
            ->setBody($body, 'text/html')
        ;

        // Send the message
        $mailer->send($message_client);
        $mailer->send($message_admin);
        unset($_SESSION['cart']);
        unset($_SESSION['cart.qty']);
        unset($_SESSION['cart.sum']);
        $_SESSION['success'] = 'Спасибо за Ваш заказ. В ближайшее время с Вами свяжется менеджер для согласования заказа';

    }


}