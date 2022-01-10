<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container">
        <div class="breadcrumbs-main">
            <ol class="breadcrumb">
                <li><a href=""><i class="fa fa-dashboard"></i> Главная</a></li>
                <li><a href="<?=PATH?>/user/orders">Список заказов</a></li>
                <li class="active">Заказ №<?=$order->id;?></li>
            </ol>
        </div>
    </div>
</section>

<!-- Main content -->
<div class="prdt">
    <div class="container">
        <div class="prdt-top">
            <div class="col-md-12 prdt-left">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <tbody>
                        <tr>
                            <td>Номер заказа</td>
                            <td><?=$order->id;?></td>
                        </tr>
                        <tr>
                            <td>Дата заказа</td>
                            <td><?=$order->date;?></td>
                        </tr>
                        <tr>
                            <td>Дата изменения</td>
                            <td><?=$order->update_at;?></td>
                        </tr>
                        <tr>
                            <td>Кол-во позиций в заказе</td>
                            <td><?=count($order_products);?></td>
                        </tr>
                        <tr>
                            <td>Сумма заказа</td>
                            <td><?=$order->sum;?> <?=$order->currency;?></td>
                        </tr>
                        <tr>
                            <td>Статус</td>
                            <td>
                                <?//=$order['status'] ? 'Завершен' : 'Новый';?>
                                <?php
                                if($order->status == '1'){
                                    echo 'Завершен';
                                }elseif($order->status == '2'){
                                    echo 'Оплачен';
                                }else{
                                    echo 'Новый';
                                }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Комментарий</td>
                            <td><?=$order->note;?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            <h3>Детали заказа</h3>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th style="width: 10%">ID</th>
                            <th style="width: 30%">Наименование</th>
                            <th style="width: 20%">Размер</th>
                            <th style="width: 20%">Колличество</th>
                            <th style="width: 20%">Цена</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $qty = 0; foreach($order_products as $product): ?>
                            <tr>
                                <td><?=$product->id;?></td>
                                <td><a href="<?=PATH?>/product/<?=str_replace(' ', '-', mb_strtolower(preg_replace("#(\s\(.+|-\().+$#", '', $product->title)));?>"><?=preg_replace("#(-\().+$#", '', $product->title);?></a></td>
                                <td><?=rtrim(preg_replace("#^[aA-zZ0-9\s]*((\s\().+-\(|-\()#", '', $product->title), ')');?></td>
                                <td><?=$product->qty; $qty += $product->qty?></td>
                                <td><?=$product->price;?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="active">
                            <td colspan="3">
                                <b>Итого:</b>
                            </td>
                            <td><b><?=$qty;?></b></td>
                            <td><b><?=$order->sum;?> <?=$order->currency;?></b></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.content -->