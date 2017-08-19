<?php

$this->title = 'Categories';
?>
<div class="row">
<div class="col-sm-12">
<h2 class="title text-center">Интернет-магазин Asteamco</h2>

        <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel" >
            <div class="carousel-inner">
                <div class="item active">
                    <img src="http://www.prodirectsoccer.com/siteimages/Responsive/adidas/ace/top-banner-2.jpg" alt="Продукция adidas" />
                </div>
                <div class="item">
                    <?php if(!empty($hot)):?>
                        
                    <?php endif:?>
                </div>
            </div>
            <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                <i class="fa fa-angle-left"></i>
            </a>
            <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                <i class="fa fa-angle-right"></i>
            </a>
        </div>
</div>
<div class="clearfix"></div>
<div class="col-sm-4">
    <div class="left-sidebar">
        <h2>Category</h2>
        <div class="panel-group category-products"><!--category-productsr-->
            <div class="panel panel-default">
                    <?= \app\components\MenuWidget::widget(['tpl' => 'menu','url' => '/category/0/0/0/0/0/0/0' ])?>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-8">
    <div class="features_items"><!--features_items-->
        <h2 class="title text-center">Features Items</h2>
        <?php if(!empty($Caps) ): ?>
            <?php foreach ($Caps as $cap): ?>
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                        <img src="<?= $cap->photo_1?>" width="200" height="200" alt="" />
                        <h2>UAH<?= $cap->price_sell ?></h2>
                        <p><?= $cap->name ?></p>
                        <a href="#" class="btn btn-default"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                            </div>
                            <div class="choose">
                                <ul class="nav nav-pills nav-justified">
                                    <li><a href="#"><i class="fa fa-plus-square"></i>Add to wishlist</a></li>
                                    <li><a href="#"><i class="fa fa-plus-square"></i>Add to compare</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach;?>
        <?php endif;?>
    </div>
        
</div>
</div>