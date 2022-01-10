<!--start-breadcrumbs-->
<div class="breadcrumbs">
    <div class="container">
        <div class="breadcrumbs-main">
            <ol class="breadcrumb">
                <?=$breadcrumbs?>
            </ol>
        </div>
    </div>
</div>
<!--end-breadcrumbs-->
<!--start-single-->
<div class="single contact">
    <div class="container">
        <div class="single-main">
            <div class="col-md-9 single-main-left">
                <div class="sngl-top">
                    <div class="col-md-5 single-top-left">
                        <?if($gallery):?>
                        <div class="flexslider">
                            <ul class="slides">
                                <?foreach ($gallery as $value):?>
                                <li data-thumb="images/<?=$value->img?>">
                                    <div class="thumb-image"> <img src="images/<?=$value->img?>" data-imagezoom="true" class="img-responsive" alt=""/> </div>
                                </li>
                                <?endforeach;?>
                            </ul>
                        </div>
                        <?else:?>
                            <img src="images/<?=$product->img?>" alt="">
                        <?endif;?>
                    </div>
                    <div class="col-md-7 single-top-right">
                        <div class="single-para simpleCart_shelfItem">
                            <h2><?=$product->title?></h2>
                            <div class="star-on">
                                <ul class="star-footer">
                                    <li><a href="#"><i> </i></a></li>
                                    <li><a href="#"><i> </i></a></li>
                                    <li><a href="#"><i> </i></a></li>
                                    <li><a href="#"><i> </i></a></li>
                                    <li><a href="#"><i> </i></a></li>
                                </ul>
                                <div class="review">
                                    <a href="#"> 1 customer review </a>

                                </div>
                                <div class="clearfix"> </div>
                            </div>

                            <h5 class="item_price" id="base-price" data-base="<?=$product->price*$curr['value']?>"><?=$curr['symbol']?> <?=$product->price*$curr['value']?></h5>
                            <?if ($product->old_price*$curr['value']):?>
                                <del><?=$product->old_price*$curr['value']?></del>
                            <?endif;?>
                            <p><?=$product->content?></p>
                            <?if($mods):?>
                            <div class="available">
                                <ul>
                                    <li>Color
                                        <select class="color">
                                            <option >Выбрать цвет</option>
                                            <?foreach ($mods as $mod):?>
                                            <option data-price="<?=$mod->price*$curr['value']?>" value="<?=$mod->id?>"><?=$mod->title?></option>
                                            <?endforeach;?>
                                        </select>
                                    </li>
                                    <?if(!empty($size)):?>
                                    <li class="size-in">Size
                                        <select class="size">
                                            <?foreach ($size as $item):?>
                                            <option data-size="<?=$item['proc']?>" value="<?=$item['id']?>"><?=$item['title']?></option>
                                            <?endforeach;?>
                                        </select>
                                    </li>
                                    <?endif;?>
                                    <div class="clearfix"> </div>
                                </ul>
                            </div>
                            <?endif;?>
                            <ul class="tag-men">
                                <li><span>Category</span>
                                    <span>: <a href="category/<?=$category[$product->id_category]['alias']?>"><?=$category[$product->id_category]['title']?></a></span></li>
                            </ul>
                            <div class="quantity">
                                <input type="number" size="4"value="1" name="quantity" min="1" step="1">
                                <a id="productAdd" href="cart/add?id=<?=$product->id?>" data-id="<?=$product->id?>" class="add-cart item_add add-to-cart-link">ADD TO CART</a>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"> </div>
                </div>
                <?if(!empty($descriptions)):?>
                <div class="tabs">
                    <?foreach ($descriptions as $key => $description):?>
                        <ul class="menu_drop">
                            <?if($description):?>
                            <li class="item1"><a><?=$key?></a>
                                    <li class="subitem1"><?=$description?></li>
                            </li>
                            <?endif;?>
                        </ul>
                    <?endforeach;?>
                </div>
                <?endif;?>
                <?if(!empty($reviews)):?>
                    <div class="comments">
                        <h3 class="title-comments">Review (<?=count($reviews)?>)</h3>
                        <ul class="media-list">
                            <?foreach ($reviews as $review):?>
                            <li class="media">
                                <div class="media-left">
                                    <a href="#">
                                        <?if($review['img']):?>
                                        <img class="media-object img-rounded" src="images/users/<?=$review['img']?>" alt="...">
                                        <?else:?>
                                            <img class="media-object img-rounded" src="images/users/no_image.jpg" alt="...">
                                        <?endif;?>
                                    </a>
                                </div>
                                <div class="media-body">
                                    <div class="media-heading">
                                        <div class="author"><?=mb_strtoupper($review['login'])?></div>
                                        <div class="metadata">
                                            <span class="date"><?=date('d F Y, H:i', strtotime($review['dt_add']))?></span>
                                        </div>
                                    </div>
                                    <div class="rating-result">
                                        <?for($i = 0; $i<round($review['rating']); $i++):?>
                                        <span class="active"></span>
                                        <?endfor;?>
                                        <?for ($i = 0; $i<5-round($review['rating']); $i++):?>
                                        <span></span>
                                        <?endfor;?>
                                    </div>
                                </div>
                                <div class="media-text text-justify"><?=$review['review']?></div>
                            </li>
                            <?endforeach;?>
                        </ul>
                    </div>
                <?endif;?>
                <?if($related):?>
                <div class="latestproducts">
                    <div class="product-one">
                        <h3>С этим товаром также покупают</h3>
                        <?foreach ($related as $item):?>
                        <div class="col-md-4 product-left p-left">
                            <div class="product-main simpleCart_shelfItem">
                                <a href="product/<?=$item['alias']?>" class="mask"><img class="img-responsive zoom-img" src="images/<?=$item['img']?>" alt="" /></a>
                                <div class="product-bottom">
                                    <h3><a href="product/<?=$item['alias']?>"><?=$item['title']?></a></h3>
                                    <p>Explore Now</p>
                                    <h4><a class="item_add add-to-cart-link" data-id="<?=$item->id?>" href="cart/add?id=<?=$item['id']?>"><i></i></a>
                                        <span class=" item_price"><?=$curr['symbol']?> <?=$item['price']*$curr['value']?></span></h4>
                                    <?if ($item['old_price']*$curr['value']):?>
                                        <del><?=$item['old_price']*$curr['value']?></del>
                                    <?endif;?>
                                </div>
                                <?if($item['old_price']):?>
                                    <div class="srch">
                                        <span>-<?=(100-$item['price']*100/$item['old_price'])?>%</span>
                                    </div>
                                <?endif;?>
                            </div>
                        </div>
                        <?endforeach;?>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <?endif;?>
                <?if($recentlyViewed):?>
                    <div class="latestproducts">
                        <div class="product-one">
                            <h3>Недавно просмотренные</h3>
                            <?foreach ($recentlyViewed as $item):?>
                                <div class="col-md-4 product-left p-left">
                                    <div class="product-main simpleCart_shelfItem">
                                        <a href="product/<?=$item['alias']?>" class="mask"><img class="img-responsive zoom-img" src="images/<?=$item['img']?>" alt="" /></a>
                                        <div class="product-bottom">
                                            <h3><a href="product/<?=$item['alias']?>"><?=$item['title']?></a></h3>
                                            <p>Explore Now</p>
                                            <h4><a class="item_add add-to-cart-link" data-id="<?=$item->id?>" href="cart/add?id=<?=$item['id']?>"><i></i></a>
                                                <span class=" item_price"><?=$curr['symbol']?> <?=$item['price']*$curr['value']?></span></h4>
                                            <?if ($item['old_price']*$curr['value']):?>
                                                <del><?=$item['old_price']*$curr['value']?></del>
                                            <?endif;?>
                                        </div>
                                        <?if($item['old_price']):?>
                                            <div class="srch">
                                                <span>-<?=(100-$item['price']*100/$item['old_price'])?>%</span>
                                            </div>
                                        <?endif;?>
                                    </div>
                                </div>
                            <?endforeach;?>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                <?endif;?>
            </div>
        </div>
    </div>
</div>
<!--end-single-->