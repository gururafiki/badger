<?php

use yii\helpers\Html;
use yii\helpers\Url;
$this->title='Products';

?>
<div id="menu" class="row-fluid hidden-sm hidden-xs">
    <div id="main_badger">
        <ul>
            <?= \app\components\NavigationBar::widget(['tpl' => 'navbar','url' => Url::to('') ])?>
            <li class="listnav">
                <a class="nav" href="#">Новинки</a>
            </li>
            <li class="listnav">
                <a class="nav" href="#">Sale</a>
            </li>
            <li class="listnav infoback">
                <span class="nav helpnav">Помощь</span>
                <ul class="listcolumn helplistcolumn">
                    <li>
                        <a href="#">Доставка заказа</a>
                        <a href="#">Оплата товара</a>
                        <a href="#">Подобрать размер</a>
                        <a href="#">Узнать о скидках</a>
                        <a href="#">Оригинальные товары</a>
                        <a href="#">Задать вопрос</a>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</div>
    <ul class="way col-lg-12 col-sm-12 col-md-12 col-xs-12" itemscope="" itemtype="http://schema.org/BreadcrumbList">
        <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
            <a class="way-home" itemprop="item" href="https://asteamco.com.ua/">
                <img alt="На главную магазина Asteamco" title="На главную магазина Asteamco" src="/images/home.gif">
                <meta itemprop="name" content="На главную магазина Asteamco">
            </a>
            <meta itemprop="position" content="1">
        </li>
        <?php if(!empty($selected) ): ?>
            <?php $j=1; ?>
            <?php foreach ($selected as $category): ?>
                <li class="separator"></li>
                <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                    <a itemprop="item" href="https://asteamco.com.ua/catalog">
                        <span itemprop="name"><?=$category->name ?></span>
                        <?php 
                            if($category->describtion=='sub_type' ){
                                $sub_type_name=' / '.$category->name;
                            }
                            elseif($category->describtion=='type'){
                                $type_name=$category->name;
                            }
                        ?>
                    </a>
                    <meta itemprop="position" content="<?=$j++ ?>">
                </li>
            <?php endforeach;?>
        <?php endif;?>
    </ul>
    <div class="clear"></div>

    <div id="side_left" class="col-lg-3 col-sm-12 col-md-3 col-xs-12">
        <div class="menu">
            <ul><?= \app\components\MenuWidget::widget(['tpl' => 'menu','url' => Url::to('') ])?></ul>
        </div>
        <div class="side_basket hidden-sm hidden-xs">
            <div class="h3">Как мы работаем?</div>
            <ul class="list">
                <li>
                    <span>
                    <i class="fa fa-calendar" aria-hidden="true"></i>
                    <b>Пн, Вт, Ср, Чт, Пт, Сб, Вс:</b>
                    с 9:00 до 21:00        </span>
                </li>

            
                <li>
                    <span><b><i class="fa fa-truck" aria-hidden="true"></i></b>
                    Доставка по всей украине, по Киеву бесплатно. </span>
                </li>
            </ul>
            <div class="clear"></div>       
            <div class="h3"><a href="https://asteamco.com.ua/information">Частые вопросы</a></div>
            <ul class="list">
                <li><a title="Вам нужна предоплата?" href="">Вам нужна предоплата?</a></li>
                <li><a title="Я могу оплатить при получении?" href="">Я могу оплатить при получении?</a></li>
                <li><a title="У Вас товар оригинальный?" href="">У Вас товар оригинальный?</a></li>
                <li><a title="Товар можно примерить?" href="">Товар можно примерить?</a></li>
                <li><a title="А если размер не подойдет?" href="">А если размер не подойдет?</a></li>
                <li><a title="Программа лояльности" href="">Программа лояльности</a></li>
            </ul>
            <div class="clear"></div>               
            <div class="clear"></div>
        </div>
    </div>

    <div id="contents" class="col-lg-9 col-md-9 col-xs-12 col-sm-12">
        <div id="content_text" class="">
            <div class="head">
                <h1 class="left">Вы искали : <?=$q ?></h1>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
            <div class="products-list">
            <?php if(!empty($products) ): ?>
                <?php $j=0; ?>
                <?php foreach ($products as $product): ?>
                    <div class="col-lg-4 col-sm-12 col-md-4 col-xs-12 content_bloks re-product-item folder1 per_row3">
                        <div class="re-image" style="width: 100%;">
                            <a title="<?= $product->name ?>" href="<?= yii\helpers\Url::to(['product/view','id' => $product->id]) ?>">
                                <img alt="<?= $product->name ?>" title="" src="<?= $product->photo ?>" style="width:100%" >
                            </a>
                        </div>
                        <div class="re-images-table none">
                            <div class="re-images-tr">
                                <?php if(!empty($product->photo)):?>
                                    <div class="active" data-src="<?= $product->photo ?>"></div>
                                <?php endif;?>
                                <?php if(!empty($product->photos)):?>
                                    <?php $j=0;?>
                                    <?php foreach (json_decode($product->photos) as $photo => $value):?>
                                        <?php
                                            if($j==4) break;
                                            else $j++;
                                        ?>
                                        <?php if($photo!='_empty_') :?>
                                            <?php  $headers = get_headers($photo);?>
                                            <?php if(substr($headers[0], 9, 3)==200): ?>
                                                <div data-src="<?= $photo ?>"></div>
                                            <?php endif;?>
                                        <?php endif;?>
                                    <?php endforeach;?>
                                <?php endif;?>
                            </div>
                        </div>
                        <div class="title" style="height: 65px;">
                            <a title="<?= $product->name ?>" href="<?= yii\helpers\Url::to(['product/view','id' => $product->id]) ?>" data-brand="<?= $product->brand ?>"><?= $product->name ?> <?= $product->article ?></a>
                        </div>
                        <div class="price-old" title="Дешевле на <?=$product->price_buy-$product->price_sell?> грн."><?=$product->price_buy?> <span>грн.</span></div>
                        <div class="price isold"><span><?= $product->price_sell ?></span> грн.</div>
                        <div class="action"></div>                  
                        <div class="images-preview">
                            <a rel="prettyPhoto[gallery]" class="image-link" title="Увеличить изображение товара" data-href="#" data-title="<?= $product->name ?>" data-price="<?= $product->price_sell ?>" data-symbol="грн." href="<?= $product->photo ?>">
                                <img alt="" src="/images/images-enlarge.png">
                            </a>
                        </div>  
                    </div>
                    <?php 
                        $j++;
                        if($j%3==0){
                            echo '<div class="clear"></div>';
                    }?>
                <?php endforeach;?>
                <?php
                    echo \yii\widgets\LinkPager::widget([
                        'pagination' => $pages,
                    ]); 
                ?>
            <?php else:?>
                <h2>Ничего не найдено</h2>
            <?php endif;?>
            </div>
            <div class="clear"></div>
        </div>

        <div class="information col-sm-12 col-lg-12 col-xs-12 col-md-12">Мы Магазин спортивной одежды и обуви Badger. Только оригинальная продукция. Мировые бренды. Приемлемые цены. Рады стараться для вас.</div>
        <div class="clear"></div>
    </div><!--/contents-->
    
    <div class="clear"></div>

