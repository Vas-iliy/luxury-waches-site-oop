<div class="breadcrumbs">
    <div class="container">
        <div class="breadcrumbs-main">
            <ol class="breadcrumb">
                <?=$breadcrumbs?>
            </ol>
        </div>
    </div>
</div>

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
                                            <span>-<?=round((100-$product->price*100/$product->old_price))?>%</span>
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
                    </div>
                <?else:?>
                <h3>Эта категория пуста</h3>
                <?php endif; ?>
            </div>
            <div class="col-md-3 single-right">
                <div class="w_sidebar">
                    <?new \app\widgets\filter\Filter();?>
                </div>
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>
</div>