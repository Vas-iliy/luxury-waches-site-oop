<?if(!empty($_SESSION['cart'])):?>
    <div class="table-responsive">
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th>Фото</th>
                <th>Наименование</th>
                <th>Размер</th>
                <th>Колличество</th>
                <th>Цена</th>
                <th><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></th>
            </tr>
            </thead>
            <tbody>
            <?foreach ($_SESSION['cart'] as $id => $item):?>
            <tr>
                <td><a href="product/<?=$item['alias']?>"><img src="images/<?=$item['img']?>" alt=""></a></td>
                <td><a href="product/<?=$item['alias']?>"><?=$item['title']?></a></td>
                <td><?=$item['size']?></td>
                <td><?=$item['qty']?></td>
                <td><?=$item['price']?></td>
                <td><span data-id="<?=$id?>" class="glyphicon glyphicon-remove text-danger del-item" aria-hidden="true"></span></td>
            </tr>
            <?endforeach;?>
            <tr>
                <td>Итого:</td>
                <td colspan="4" class="text-right cart-qty"><?=$_SESSION['cart.qty']?></td>
            </tr>
            <tr>
                <td>На сумму:</td>
                <td colspan="4" class="text-right cart-sum"><?=\luxury\App::$app->getProperty('currency')['symbol'] .$_SESSION['cart.sum']?></td>
            </tr>
            </tbody>
        </table>
    </div>
<?else:?>
    <h3>Корзина пуста</h3>
<?endif;?>
