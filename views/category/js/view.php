<?php

use yii\helpers\Html;
use yii\helpers\Url;
$this->title='Products';

?>
<div class="row">
    <div class="col-sm-4">
        <div class="left-sidebar">
            <h2>Category</h2>
            <div class="panel-group category-products"><!--category-productsr-->
                <div class="panel panel-default">
                        <?= \app\components\MenuWidget::widget(['tpl' => 'menu','url' => Url::to('') ])?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="features_items"><!--features_items-->
            <h2 class="title text-center">Features Items</h2>
        <?php if(!empty($products) ): ?>
            <?php foreach ($products as $product): ?>
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="<?= $product->photo_1 ?>"  alt="" />
                                <h2>UAH<?= $product->price_sell ?></h2>
                                <p><?= $product->name ?></p>
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
            <div class="clearfix"></div>
            <?php
                echo \yii\widgets\LinkPager::widget([
                    'pagination' => $pages,
                ]); 
            ?>
            <!-- <ul class="pagination">
                <li class="active"><a href="">1</a></li>
                <li><a href="">2</a></li>
                <li><a href="">3</a></li>
                <li><a href="">&raquo;</a></li>
            </ul> -->
            <?php else:?>
            <h2>В данной категории пока нету товаров</h2>
        <?php endif;?>
        </div>
        <div class="category-tab"><!--category-tab-->
            <div class="col-sm-12">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tshirt" data-toggle="tab">Футболки</a></li>
                    <li><a href="#blazers" data-toggle="tab">Толстовки</a></li>
                    <li><a href="#kids" data-toggle="tab">Шорты</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade active in" id="tshirt" >
                <?php if(!empty($tees) ): ?>
                <?php foreach ($tees as $product): ?>
                    <div class="col-sm-3">
                        <div class="product-image-wrapper">
                            <div class="single-products">
                                <div class="productinfo text-center">
                                    <img src="<?= $product->photo_1 ?>"  alt="" />
                                    <h2>UAH<?= $product->price_sell ?></h2>
                                    <p><?= $product->name ?></p>
                                    <a href="#" class="btn btn-default"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;?>
                <?php endif;?>
                </div>

                <div class="clearfix"></div>
                <div class="tab-pane fade" id="blazers" >
                    <?php if(!empty($hoods) ): ?>
                    <?php foreach ($hoods as $product): ?>
                        <div class="col-sm-3">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="<?= $product->photo_1 ?>"  alt="" />
                                        <h2>UAH<?= $product->price_sell ?></h2>
                                        <p><?= $product->name ?></p>
                                        <a href="#" class="btn btn-default"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>

                <div class="clearfix"></div>
                <div class="tab-pane fade" id="kids" >
                    <?php if(!empty($shorts) ): ?>
                    <?php foreach ($shorts as $product): ?>
                        <div class="col-sm-3">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <img src="<?= $product->photo_1 ?>"  alt="" />
                                        <h2>UAH<?= $product->price_sell ?></h2>
                                        <p><?= $product->name ?></p>
                                        <a href="#" class="btn btn-default"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>
                <div class="clearfix"></div>    
            </div>
        </div><!--/category-tab-->

            <div class="clearfix"></div>
        <div class="recommended_items"><!--recommended_items-->
            <h2 class="title text-center">recommended items</h2>

            <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="item active">
                        <?php if(!empty($pants) ): ?>
                        <?php foreach ($pants as $product): ?>
                            <div class="col-sm-3">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <img src="<?= $product->photo_1 ?>"  alt="" />
                                            <h2>UAH<?= $product->price_sell ?></h2>
                                            <p><?= $product->name ?></p>
                                            <a href="#" class="btn btn-default"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;?>
                        <?php endif;?>

                        <div class="clearfix"></div>
                    </div>
                    <div class="item">
                        <?php if(!empty($jackets) ): ?>
                        <?php foreach ($jackets as $product): ?>
                            <div class="col-sm-3">
                                <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <img src="<?= $product->photo_1 ?>"  alt="" />
                                            <h2>UAH<?= $product->price_sell ?></h2>
                                            <p><?= $product->name ?></p>
                                            <a href="#" class="btn btn-default"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;?>
                        <?php endif;?>

                        <div class="clearfix"></div>
                    </div>
                </div>
                <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                    <i class="fa fa-angle-left"></i>
                </a>
                <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
        </div><!--/recommended_items-->
    </div>
</div>