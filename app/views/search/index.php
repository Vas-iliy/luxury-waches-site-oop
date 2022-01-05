<!--start-breadcrumbs-->
<div class="breadcrumbs">
    <div class="container">
        <div class="breadcrumbs-main">
            <ol class="breadcrumb">
                <li><a href="<?=PATH;?>">Главная</a></li>
                <li>Поиск по запросу "<?=h($query);?>"</li>
            </ol>
        </div>
    </div>
</div>
<!--end-breadcrumbs-->
<!--prdt-starts-->
<div class="prdt">
    <div class="container">
        <div class="prdt-top">
            <div class="col-md-9 prdt-left">
                <?php if(!empty($products)): ?>
                <div class="product-one">
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
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!--product-end-->