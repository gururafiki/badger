<?php
use yii\helpers\Html;
use yii\helpers\Url;
$this->title='Products';
?>

<div id="menu" class="row-fluid hidden-sm hidden-xs">
    <div id="main_badger">
        <ul>
            <?= \app\components\NavigationBar::widget(['tpl' => 'navbar','url' => Url::to('') ])?>
            <?php if(strpos(Url::to(''),'/page')!=false):?>
                <?php if(strpos(Url::to(''),'/new')!=false):?>
                    <li class="listnav">
                        <a class="nav" href="<?=Url::to('')?>" style="color:#009adb;">Новинки</a>
                    </li>
                    <li class="listnav">
                        <a class="nav" href="<?=substr(Url::to(''),0,strpos(Url::to(''),'/new')).'/sale'.substr(Url::to(''),strpos(Url::to(''),'/page'))?>">Распродажа</a>
                    </li>
                <?php elseif(strpos(Url::to(''),'/sale')!=false):?>
                    <li class="listnav">
                        <a class="nav" href="<?=substr(Url::to(''),0,strpos(Url::to(''),'/sale')).'/new'.substr(Url::to(''),strpos(Url::to(''),'/page'))?>">Новинки</a>
                    </li>
                    <li class="listnav">
                        <a class="nav" href="<?=Url::to('')?>" style="color:#009adb;">Распродажа</a>
                    </li>
                <?php else:?>
                    <li class="listnav">
                        <a class="nav" href="<?=substr(Url::to(''),0,strpos(Url::to(''),'/page')-1).'/new'.substr(Url::to(''),strpos(Url::to(''),'/page'))?>">Новинки</a>
                    </li>
                    <li class="listnav">
                        <a class="nav" href="<?=substr(Url::to(''),0,strpos(Url::to(''),'/page')-1).'/sale'.substr(Url::to(''),strpos(Url::to(''),'/page'))?>">Распродажа</a>
                    </li>
                <?php endif;?>
            <?php else:?>
                <?php if(strpos(Url::to(''),'/new')!=false):?>
                    <li class="listnav">
                        <a class="nav" href="<?=Url::to('')?>" style="color:#009adb;">Новинки</a>
                    </li>
                    <li class="listnav">
                        <a class="nav" href="<?=substr(Url::to(''),0,strpos(Url::to(''),'/new')).'/sale'?>">Распродажа</a>
                    </li>
                <?php elseif(strpos(Url::to(''),'/sale')!=false):?>
                    <li class="listnav">
                        <a class="nav" href="<?=substr(Url::to(''),0,strpos(Url::to(''),'/sale')).'/new'?>">Новинки</a>
                    </li>
                    <li class="listnav">
                        <a class="nav" href="<?=Url::to('')?>" style="color:#009adb;">Распродажа</a>
                    </li>
                <?php else:?>
                    <li class="listnav">
                        <a class="nav" href="<?=substr(Url::to(''),0,-2).'/new'?>">Новинки</a>
                    </li>
                    <li class="listnav">
                        <a class="nav" href="<?=substr(Url::to(''),0,-2).'/sale'?>">Распродажа</a>
                    </li>
                <?php endif;?>
            <?php endif;?>
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

    <?php if(!empty($selected) ): ?>
        <ul class="way col-lg-12 col-sm-12 col-md-12 col-xs-12 hidden-sm hidden-xs" itemscope="" itemtype="http://schema.org/BreadcrumbList">
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
                                    $href='/category/0/0/0/0/0/'.$category->id.'/0';
                                    // $href='/category/$col/$spo/$gen/$brand/$size/$type/$byprice';
                                }
                                elseif($category->describtion=='type'){
                                    $type_name=$category->name;
                                    $buf=$category->id+1;
                                    $href='/category/0/0/0/0/0/'.$buf.'/0';
                                }
                                elseif($category->describtion=='gender'){
                                    $type_name=$category->name;
                                    $href='/category/0/0/'.$category->id.'/0/0/0/0';
                                }
                                elseif($category->describtion=='brand'){
                                    $type_name=$category->name;
                                    $href='/category/'.$category->id.'/0/0/0/0/0/0';
                                }
                                elseif($category->describtion=='sport'){
                                    $type_name=$category->name;
                                    $href='/category/0/'.$category->id.'/0/0/0/0/0';
                                }
                                elseif($category->describtion=='size'){
                                    $type_name=$category->name;
                                    $href='/category/0/0/0/0/'.$category->id.'/0/0';
                                }
                            ?>
                        <a itemprop="item" href="<?=$href ?>">
                            <span itemprop="name"><?=$category->name ?></span>                   
                        </a>
                        <meta itemprop="position" content="<?=$j++ ?>">
                    </li>
                <?php endforeach;?>
        </ul>
        <h2 class="row-fluid hidden-lg hidden-md">Выбраные категории</h2>
        <ul class="selected row-fluid hidden-lg hidden-md" style="list-style: none;padding-top: 10px;">
            <?php foreach ($selected as $category): ?>
                <li>
                    <?php 
                            if($category->describtion=='sub_type' ){
                                $sub_type_name=' / '.$category->name;
                                $href='/category/0/0/0/0/0/'.$category->id.'/0';
                                // $href='/category/$col/$spo/$gen/$brand/$size/$type/$byprice';
                            }
                            elseif($category->describtion=='type'){
                                $type_name=$category->name;
                                $buf=$category->id+1;
                                $href='/category/0/0/0/0/0/'.$buf.'/0';
                            }
                            elseif($category->describtion=='gender'){
                                $type_name=$category->name;
                                $href='/category/0/0/'.$category->id.'/0/0/0/0';
                            }
                            elseif($category->describtion=='brand'){
                                $type_name=$category->name;
                                $href='/category/'.$category->id.'/0/0/0/0/0/0';
                            }
                            elseif($category->describtion=='sport'){
                                $type_name=$category->name;
                                $href='/category/0/'.$category->id.'/0/0/0/0/0';
                            }
                            elseif($category->describtion=='size'){
                                $type_name=$category->name;
                                $href='/category/0/0/0/0/'.$category->id.'/0/0';
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

    <div id="side_left" class="col-lg-3 col-sm-12 col-md-3 col-xs-12">
        <div class="menu">
            <ul><?= \app\components\MenuWidget::widget(['tpl' => 'menu','url' => Url::to('') ])?>
            <?php if(!empty($selected)):?>
                <li><a href="<?=str_replace('category', 'advanced',  Url::to(''))?>">Перейти к расширеному меню</a></li>
            <?php endif;?>
            </ul>
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
        <div id="content_text" >
            <div class="head">
                <h1 class="left"><?=$type_name ?><?=$sub_type_name ?></h1>  
                <?=$button ?>
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
                                <?php if(!empty($product->photos)):?>
                                    <?php $i=-1;?>
                                    <?php foreach (json_decode($product->photos) as $photo => $value):?>
                                        <?php
                                            if($i==3) break;
                                            else $i++;
                                        ?>
                                        <?php if($photo!='_empty_' ) :?>
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
                <div class="clear"></div>
                <?php
                    echo \yii\widgets\LinkPager::widget([
                        'pagination' => $pages,
                    ]); 
                ?>
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