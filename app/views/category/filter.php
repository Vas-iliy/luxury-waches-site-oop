
<?php if(!empty($products)): ?>
    <?php foreach($products as $product): ?>
        <div class="col-md-4 product-left p-left">
            <div class="product-main simpleCart_shelfItem">
                <a href="product/<?=$product->alias;?>" class="mask"><img class="img-responsive zoom-img" src="images/<?=$product->img;?>" alt="" /></a>
                <div class="product-bottom">
                    <h3><?=$product->title;?></h3>
                    <p>Explore Now</p>
                    <h4><a class="add-to-cart-link" data-id="<?=$product->id?>" href="cart/add?id=<?=$product->id?>"><i></i></a>
                        <span class=" item_price"><?=$curr['symbol']?> <?=$product->price*$curr['value']?></span>
                        <?if ($product->old_price*$curr['value']):?>
                            <small><del><?=$product->old_price*$curr['value']?></del></small>
                        <?endif;?>
                    </h4>
                </div>
                <?if($product->old_price):?>
                    <div class="srch">
                        <span>-<?=(100-$product->price*100/$product->old_price)?>%</span>
                    </div>
                <?endif;?>
            </div>
        </div>
    <?php endforeach; ?>
    <div class="clearfix"></div>
    <div class="text-center">
        <?if ($pagination->countPages > 1):?>
            <?=$pagination?>
        <?endif;?>
    </div>
<?else:?>
    <h3>Товаров не найдено</h3>
<?php endif; ?>