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
<script src="js/jssor.slider-24.1.5.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        jssor_1_slider_init = function() {

            var jssor_1_SlideoTransitions = [
              [{b:900,d:2000,x:-379,e:{x:7}}],
              [{b:900,d:2000,x:-379,e:{x:7}}],
              [{b:-1,d:1,o:-1,sX:2,sY:2},{b:0,d:900,x:-171,y:-341,o:1,sX:-2,sY:-2,e:{x:3,y:3,sX:3,sY:3}},{b:900,d:1600,x:-283,o:-1,e:{x:16}}]
            ];

            var jssor_1_options = {
              $AutoPlay: 1,
              $SlideDuration: 800,
              $SlideEasing: $Jease$.$OutQuint,
              $CaptionSliderOptions: {
                $Class: $JssorCaptionSlideo$,
                $Transitions: jssor_1_SlideoTransitions
              },
              $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$
              },
              $BulletNavigatorOptions: {
                $Class: $JssorBulletNavigator$
              }
            };

            var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

            /*responsive code begin*/
            /*remove responsive code if you don't want the slider scales while window resizing*/
            function ScaleSlider() {
                var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
                if (refSize) {
                    refSize = Math.min(refSize, 1920);
                    jssor_1_slider.$ScaleWidth(refSize);
                }
                else {
                    window.setTimeout(ScaleSlider, 30);
                }
            }
            ScaleSlider();
            $Jssor$.$AddEvent(window, "load", ScaleSlider);
            $Jssor$.$AddEvent(window, "resize", ScaleSlider);
            $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
            /*responsive code end*/
        };
    </script>
    <style>
        /* jssor slider bullet navigator skin 05 css */
        /*
        .jssorb05 div           (normal)
        .jssorb05 div:hover     (normal mouseover)
        .jssorb05 .av           (active)
        .jssorb05 .av:hover     (active mouseover)
        .jssorb05 .dn           (mousedown)
        */
        .jssorb05 {
            position: absolute;
        }
        .jssorb05 div, .jssorb05 div:hover, .jssorb05 .av {
            position: absolute;
            /* size of bullet elment */
            width: 16px;
            height: 16px;
            background: url('/images/b05.png') no-repeat;
            overflow: hidden;
            cursor: pointer;
        }
        .jssorb05 div { background-position: -7px -7px; }
        .jssorb05 div:hover, .jssorb05 .av:hover { background-position: -37px -7px; }
        .jssorb05 .av { background-position: -67px -7px; }
        .jssorb05 .dn, .jssorb05 .dn:hover { background-position: -97px -7px; }

        .jssora031 {display:block;position:absolute;cursor:pointer;}
        .jssora031 .a {fill:#fff;}
        .jssora031:hover {opacity:.8;}
        .jssora031.jssora031dn {opacity:.5;}
        .jssora031.jssora031ds { opacity: .3; pointer-events: none; }
    </style>
    <div id="jssor_1" style="position:relative;margin:0 auto;top:-15px;left:0px;width:1300px;height:500px;overflow:hidden;visibility:hidden;">
        <!-- Loading Screen -->
        <div data-u="loading" style="position:absolute;top:0px;left:0px;background:url('/images/loading.gif') no-repeat 50% 50%;background-color:rgba(0, 0, 0, 0.7);"></div>
        <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:1300px;height:500px;overflow:hidden;">
            <div>
                <img data-u="image" src="/images/red.jpg" />
                <div style="position:absolute;top:30px;left:30px;width:480px;height:120px;z-index:0;font-size:50px;color:#ffffff;line-height:60px;">Попробуйте нашу мобильную версию!</div>
                <div style="position:absolute;top:300px;left:30px;width:480px;height:120px;z-index:0;font-size:30px;color:#ffffff;line-height:38px;">Теперь вы можете комфортно пользоваться нашим каталогом в дали от компьютера</div>
                <div style="position:absolute;top:20px;left:650px;width:220px;height:470px;z-index:0;">
                    <img style="position:absolute;top:0px;left:0px;width:220px;height:470px;z-index:0;" src="/images/phone_vertical.png" />
                    <div style="position:absolute;top:40px;left:10px;width:200px;height:390px;z-index:0; overflow:hidden;">
                        <img data-u="caption" data-t="0" style="position:absolute;top:0px;left:0px;width:200px;height:390px;z-index:0;" src="/images/phone_1.PNG" />
                        <img data-u="caption" data-t="1" style="position:absolute;top:0px;left:200px;width:179px;height:390px;z-index:0;" src="/images/phone_2.png" />
                        <img data-u="caption" data-t="1" style="position:absolute;top:0px;left:379px;width:200px;height:390px;z-index:0;" src="/images/phone_3.png" />
                    </div>
                    <img data-u="caption" data-t="2" style="position:absolute;top:476px;left:454px;width:63px;height:77px;z-index:0;" src="/images/hand.png" />
                </div>
            </div>
            <div>
                <img data-u="image" src="/images/slider_1.jpg" />
            </div>
            <div>
                <img data-u="image" src="/images/slider_2.jpg" />
            </div>
            <div>
                <img data-u="image" src="/images/slider_3.jpg" />
            </div>
            <a data-u="any" href="https://www.jssor.com/wordpress.html" style="display:none">wordpress gallery</a>
        </div>
        <!-- Bullet Navigator -->
        <div data-u="navigator" class="jssorb05" style="bottom:16px;right:16px;" data-autocenter="1">
            <!-- bullet navigator item prototype -->
            <div data-u="prototype" style="width:16px;height:16px;"></div>
        </div>
        <!-- Arrow Navigator -->
        <div data-u="arrowleft" class="jssora031" style="width:50px;height:50px;top:0px;left:20px;" data-autocenter="2">
            <svg viewbox="-12986 -2977 16000 16000" style="width:100%;height:100%;">
                <polygon class="a" points="-1182.1,12825.5 -792,12435.4 -8204.5,5023 -792,-2389.4 -1182.1,-2779.5 -8984.8,5023"></polygon>
            </svg>
        </div>
        <div data-u="arrowright" class="jssora031" style="width:50px;height:50px;top:0px;right:20px;" data-autocenter="2">
            <svg viewbox="-12986 -2977 16000 16000" style="width:100%;height:100%;">
                <polygon class="a" points="-8594.7,12825.5 -8984.8,12435.4 -1572.3,5023 -8984.8,-2389.4 -8594.7,-2779.5 -792,5023"></polygon>
            </svg>
        </div>
    </div>
    <script type="text/javascript">jssor_1_slider_init();</script>
    <?php if(!empty($selected) ): ?>
        <h2 class="row-fluid hidden-lg hidden-md">Выбраные категории</h2>
        <ul class="selected row-fluid hidden-lg hidden-md" style="list-style: none;padding-top: 10px;">
            <?php foreach ($selected as $category): ?>
                <li>
                    <?php 
                            if($category->describtion=='sub_type' ){
                                $sub_type_name=' / '.$category->name;
                                $href='/category/0/0/0/0/0/'.$category->id.'/0#selectedcat';
                                // $href='/category/$col/$spo/$gen/$brand/$size/$type/$byprice';
                            }
                            elseif($category->describtion=='type'){
                                $type_name=$category->name;
                                $buf=$category->id+1;
                                $href='/category/0/0/0/0/0/'.$buf.'/0#selectedcat';
                            }
                            elseif($category->describtion=='gender'){
                                $type_name=$category->name;
                                $href='/category/0/0/'.$category->id.'/0/0/0/0#selectedcat';
                            }
                            elseif($category->describtion=='producer'){
                                $type_name=$category->name;
                                $href='/category/0/0/0/'.$category->id.'/0/0/0#selectedcat';
                            }
                            elseif($category->describtion=='brand'){
                                $type_name=$category->name;
                                $href='/category/'.$category->id.'/0/0/0/0/0/0#selectedcat';
                            }
                            elseif($category->describtion=='sport'){
                                $type_name=$category->name;
                                $href='/category/0/'.$category->id.'/0/0/0/0/0#selectedcat';
                            }
                            elseif($category->describtion=='size'){
                                $type_name=$category->name;
                                $href='/category/0/0/0/0/'.$category->id.'/0/0#selectedcat';
                            }
                        ?>
                    <a itemprop="item" href="<?=$href ?>">
                        <span itemprop="name"><?=$category->name ?></span>
                    </a>
                    <meta itemprop="position" content="<?=$j++ ?>">
                </li>
                <li class="separator">&nbsp;</li>
            <?php endforeach;?>
        </ul>
        <h4 class="hidden-lg hidden-md"></h4>
        <div class="clear"></div>
    <?php endif;?>
    <div id="side_left" class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div class="menu container" style="font-size: 12px;line-height:7px">
            <ul><?= \app\components\NavMenuWidget::widget(['tpl' => 'navmenu','url' => Url::to('') ])?></ul>
<!--            <ul>--><?//= \app\components\MenuWidget::widget(['tpl' => 'menu','url' => Url::to('') ])?><!--</ul>-->
        </div>
<!--        <div class="side_basket hidden-sm hidden-xs">-->
<!--            <div class="h3">Как мы работаем?</div>-->
<!--            <ul class="list">-->
<!--                <li>-->
<!--                    <span>-->
<!--                    <i class="fa fa-calendar" aria-hidden="true"></i>-->
<!--                    <b>Пн, Вт, Ср, Чт, Пт, Сб, Вс:</b>-->
<!--                    с 9:00 до 21:00        </span>-->
<!--                </li>-->
<!---->
<!--            -->
<!--                <li>-->
<!--                    <span><b><i class="fa fa-truck" aria-hidden="true"></i></b>-->
<!--                    Доставка по всей украине, по Киеву бесплатно. </span>-->
<!--                </li>-->
<!--            </ul>-->
<!--            <div class="clear"></div>       -->
<!--            <div class="h3"><a href="https://asteamco.com.ua/information">Частые вопросы</a></div>-->
<!--            <ul class="list">-->
<!--                <li><a title="Вам нужна предоплата?" href="">Вам нужна предоплата?</a></li>-->
<!--                <li><a title="Я могу оплатить при получении?" href="">Я могу оплатить при получении?</a></li>-->
<!--                <li><a title="У Вас товар оригинальный?" href="">У Вас товар оригинальный?</a></li>-->
<!--                <li><a title="Товар можно примерить?" href="">Товар можно примерить?</a></li>-->
<!--                <li><a title="А если размер не подойдет?" href="">А если размер не подойдет?</a></li>-->
<!--                <li><a title="Программа лояльности" href="">Программа лояльности</a></li>-->
<!--            </ul>-->
<!--            <div class="clear"></div>               -->
<!--            <div class="clear"></div>-->
<!--        </div>-->
    </div>
    <?php if(!empty($selected) ): ?>
        <hr id="selectedcat" style="margin-bottom:50px;">
    <ul  class="way col-lg-12 col-sm-12 col-md-12 col-xs-12 hidden-sm hidden-xs" itemscope="" itemtype="http://schema.org/BreadcrumbList">
        <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
            <a class="way-home" itemprop="item" href="/">
                <i class="fa fa-home" aria-hidden="true" alt="На главную магазина Asteamco" title="На главную магазина Asteamco"></i>
                <meta itemprop="name" content="На главную магазина Asteamco">
            </a>
            <meta itemprop="position" content="1">
        </li>
        <?php foreach ($selected as $category): ?>
            <li><i class="fa fa-angle-right" aria-hidden="true"></i></li>
            <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
                <?php
                if($category->describtion=='sub_type' ){
                    $sub_type_name=' / '.$category->name;
                    $href='/category/0/0/0/0/0/'.$category->id.'/0#selectedcat';
                    // $href='/category/$col/$spo/$gen/$brand/$size/$type/$byprice';
                }
                elseif($category->describtion=='type'){
                    $type_name=$category->name;
                    $buf=$category->id+1;
                    $href='/category/0/0/0/0/0/'.$buf.'/0#selectedcat';
                }
                elseif($category->describtion=='gender'){
                    $type_name=$category->name;
                    $href='/category/0/0/'.$category->id.'/0/0/0/0#selectedcat';
                }
                elseif($category->describtion=='producer'){
                    $type_name=$category->name;
                    $href='/category/0/0/0/'.$category->id.'/0/0/0#selectedcat';
                }
                elseif($category->describtion=='brand'){
                    $type_name=$category->name;
                    $href='/category/'.$category->id.'/0/0/0/0/0/0#selectedcat';
                }
                elseif($category->describtion=='sport'){
                    $type_name=$category->name;
                    $href='/category/0/'.$category->id.'/0/0/0/0/0#selectedcat';
                }
                elseif($category->describtion=='size'){
                    $type_name=$category->name;
                    $href='/category/0/0/0/0/'.$category->id.'/0/0#selectedcat';
                }
                ?>
                <a itemprop="item" href="<?=$href ?>">
                    <span itemprop="name"><?=$category->name ?></span>
                </a>
                <meta itemprop="position" content="<?=$j++ ?>">
            </li>
        <?php endforeach;?>
    </ul>
    <?php endif;?>

    <div id="contents" class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
        <div id="content_text" >
            <div class="head">
                <h1 class="left"><?=$type_name ?><?=$sub_type_name ?></h1>
                <?=$button ?>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
            <div class="products-list">
                <div class="clear"></div>
                <div class="clear"></div>
            <?php if(!empty($products) ): ?>
                <?php $i=0; ?>
                <?php foreach ($products as $product): ?>
                    <div class="col-lg-3 col-sm-12 col-md-3 col-xs-12 content_bloks re-product-item folder1 per_row3">
                        <div class="re-image" style="width: 100%;">
                            <a title="<?= $product->name ?>" href="<?= yii\helpers\Url::to(['product/view','id' => $product->id]) ?>">
                                <img alt="<?= $product->name ?>" title="" src="<?= $product->photo ?>" style="width:100%" >
                            </a>
                        </div>
                        <div class="re-images-table none">
                            <div class="re-images-tr">
                                <?php if(!empty($product->photos)):?>
                                    <?php $j=-1;?>
                                    <?php foreach (json_decode($product->photos) as $photo => $value):?>
                                        <?php
                                            if($j==3) break;
                                            else $j++;
                                        ?>
                                        <?php if($photo!='_empty_' && $j!=0) :?>
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
                        $i++;
                        if($i%4==0){
                            echo '<div class="clear"></div>';
                    }?>
                <?php endforeach;?>
            <?php else:?>
                <h2>В данной категории пока нету товаров</h2>
            <?php endif;?>
            </div>
            <div class="clear"></div>
        </div>

        <div class="information col-sm-12 col-lg-12 col-xs-12 col-md-12">Мы Магазин спортивной одежды и обуви Badger. Только оригинальная продукция. Мировые бренды. Приемлемые цены. Рады стараться для вас.</div>
        <div class="clear"></div>
    </div><!--/contents-->
    
    <div class="clear"></div> 

