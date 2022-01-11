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
                <div class="product-one">
                       <?=$productsView?>
                </div>
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