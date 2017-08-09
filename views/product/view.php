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
<link rel="stylesheet" type="text/css" href="/css/card.css">

<div id="contents">
    <div id="content_text" class="col-lg-12">
        <div class="description" itemscope="" itemtype="http://schema.org/Product">
            <meta itemprop="name" content="<?=$product->name?>">
            <meta itemprop="sku" content="<?=$product->article?>">
            <meta itemprop="model" content="<?=$product->article?>">
            <div itemprop="brand" itemscope="" itemtype="http://schema.org/Brand">
                <meta itemprop="name" content="<?=$product->brand?>">
            </div>
            <meta itemprop="image" content="<?=$product->photo?>">
            <div itemprop="offers" itemscope="" itemtype="http://schema.org/Offer">
                <meta itemprop="price" content="<?=$product->price_sell?>">
                <meta itemprop="priceCurrency" content="UAH">
                <link itemprop="availability" href="http://schema.org/InStock">
            </div>
            <div itemprop="description" style="display:none;">
                <?=$product->describtion?>
            </div>
        </div>
        <h1 class="product_title rebrand-title"><?=$product->name?> <?=$product->brand?> <?=$product->article?> (OBL)</h1>

        <div class="clear"></div>
        <div class="description cart_product col-md-8 col-lg-8 col-sm-8 col-xs-12">
            <div class="action rebrand-action"></div>
            <link type="text/css" rel="stylesheet" href="/css/swiper.min.css">
            <script type="text/javascript" src="/js/swiper.min.js"></script>
            <div class="img_big_all swiper-container re-swiper-container swiper-container-horizontal swiper-container-free-mode">
                <div class="swiper-wrapper" style="transition-duration: 0ms; transform: translate3d(-1020px, 0px, 0px);">
                    <?php $i=0; ?>
                    <?php if(!empty($product->photo)):?>
                        <div class="img_big swiper-slide re-main-image">
                            <a rel="prettyPhoto[product]" id="re-image-id-<?=$i++?>" data-id="<?=$i?>" href="<?=$product->photo?>" style="position: relative; overflow: hidden;">
                                <img alt="<?=$product->name?> <?=$product->brand ?> <?=$product->article?>" title="<?=$product->name?> <?=$product->brand ?> <?=$product->article?>" src="<?= $product->photo ?>">
                                <img src="<?= $product->photo ?>" class="zoomImg" style="position: absolute; top: 0px; left: 0px; opacity: 0; width: 1050px; height: 1050px; border: none; max-width: none; max-height: none;">
                            </a>
                        </div>
                    <?php endif;?>
                    <?php if(!empty($product->photos)):?>
                        <?php foreach (json_decode($product->photos) as $photo => $value):?>
                            <?php if($photo!='_empty_') :?>
                                <?php  $headers = get_headers($photo);?>
                                <?php if(substr($headers[0], 9, 3)==200): ?>
                                    <div class="img_big swiper-slide re-main-image">
                                        <a rel="prettyPhoto[product]" id="re-image-id-<?=$i++?>" data-id="<?=$i?>" href="<?=$photo?>" style="position: relative; overflow: hidden;">
                                            <img alt="<?=$product->name?> <?=$product->brand ?> <?=$product->article?>" title="<?=$product->name?> <?=$product->brand ?> <?=$product->article?>" src="<?= $photo ?>">
                                            <img src="<?= $photo ?>" class="zoomImg" style="position: absolute; top: 0px; left: 0px; opacity: 0; width: 1050px; height: 1050px; border: none; max-width: none; max-height: none;">
                                        </a>
                                    </div>
                                <?php endif;?>
                            <?php endif;?>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>
                <div class="swiper-pagination swiper-pagination-clickable">
                    <span class="swiper-pagination-bullet"></span>
                    <span class="swiper-pagination-bullet"></span>
                    <span class="swiper-pagination-bullet swiper-pagination-bullet-active"></span>
                    <span class="swiper-pagination-bullet"></span>
                    <span class="swiper-pagination-bullet"></span>
                    <span class="swiper-pagination-bullet"></span>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            <div class="clear"></div>
        </div>

        <div class="col-md-4 col-lg-4 col-sm-4 col-xs-12">
            <?php if(!empty($other_colours)): ?>
                <div class="recommended_items"><!--recommended_items-->
                    <h4 style="margin-bottom: 10px;">Другие цвета:</h4>
                    <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php $j=0;?>
                            <?php foreach ($other_colours as $other_colour):?>
                                <?php
                                $j++;
                                if(($j-1)%4==0 && $j-1!=0)
                                    echo '<div class="item">';
                                elseif($j-1==0)
                                    echo '<div class="item active">';
                                ?>
                                <div class="col-md-4 col-lg-4 col-xs-6 col-sm-6">
                                    <div class="product-image-wrapper">
                                        <div class="single-products">
                                            <div class="productinfo text-center">
                                                <?=\yii\helpers\Html::img("{$other_colour->photo}",['alt' => $other_colour->colour, 'width' => '100%']) ?>
                                                <h5>Цвет: <?= $other_colour->colour ?></h5>
                                                <a href="#" class="btn btn-default"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                if($j%4==0){
                                    echo '</div>';
                                }?>
                            <?endforeach;?>
                            <?php if($j%4!=0) echo '</div>';?>
                        </div>
                    </div>
                </div><!--/recommended_items-->
            <?php endif;?>
            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12" style="margin:10% 0px 0px 0px;">
                <div class="price">
                    <!--                    <div class="price-old" title="Дешевле на --><?//=$product->price_buy-$product->price_sell?><!-- грн.">--><?//=$product->price_buy?><!-- <span>грн.</span></div>-->
                    <div class="re-main-price"><?=$product->price_sell?> <span>грн.</span></div>
                    <!--                    <div class="re-modification-price" id="re-modification-price-0" style="display:none;">Всего --><?//=$product->price_sell?><!-- <span>грн.</span></div>-->
                </div>
                <div class="sku">Артикул: <span class="re-main-sku"><?=$product->article?></span></div>
                <br>
                <form id="buy_now" action=" <?= \yii\helpers\Url::to(['cart/buy']) ?>" method="get">
                    <input class="btn submit" title="Заказать сейчас!" type="submit" value="Заказать!">
                </form>
            </div>
            <div class="col-md-6 col-lg-6 col-xs-12 col-sm-12">
                <!--                <div class="request hidden-xs hidden-sm"><span>Заказывайте прямо сейчас</span><br>Доставка в кратчайшие сроки</div>-->
                <div class="clear"></div>
                <div id="boxbuttonsize">
                    <a id="cakk" title="">Таблица размеров</a>
                    <div class="re-dialog cakk">
                        <div class="re-dialog-titlebar">
                            <span class="re-dialog-title">Таблица размеров <span></span></span>
                            <a class="re-dialog-icon" title="Закрыть">
                                <span class="re-icon re-icon-close">×</span>
                            </a>
                        </div>
                        <div class="re-dialog-content">
                            <div id="tablesizeproduct">&nbsp;
                                <table id="mensobuv<?=$product->brand ?>">
                                    <tbody>
                                    <tr class="nametable">
                                        <td>UK</td>
                                        <td>Стелька</td>
                                        <td>Украина</td>
                                        <td>US</td>
                                    </tr>
                                    <tr>
                                        <td class="mainsize">7</td>
                                        <td>25.5 см</td>
                                        <td>39</td>
                                        <td>7.5</td>
                                    </tr>
                                    <tr>
                                        <td class="mainsize">7.5</td>
                                        <td>26 см</td>
                                        <td>40</td>
                                        <td>8</td>
                                    </tr>
                                    <tr>
                                        <td class="mainsize">8</td>
                                        <td>26.5 см</td>
                                        <td>40.5</td>
                                        <td>8.5</td>
                                    </tr>
                                    <tr>
                                        <td class="mainsize">8.5</td>
                                        <td>27 см</td>
                                        <td>41</td>
                                        <td>9</td>
                                    </tr>
                                    <tr>
                                        <td class="mainsize">9</td>
                                        <td>27.5 см</td>
                                        <td>42</td>
                                        <td>9.5</td>
                                    </tr>
                                    <tr>
                                        <td class="mainsize">9.5</td>
                                        <td>28 см</td>
                                        <td>42.5</td>
                                        <td>10</td>
                                    </tr>
                                    <tr>
                                        <td class="mainsize">10</td>
                                        <td>28.5 см</td>
                                        <td>43</td>
                                        <td>10.5</td>
                                    </tr>
                                    <tr>
                                        <td class="mainsize">10.5</td>
                                        <td>29 см</td>
                                        <td>44</td>
                                        <td>11</td>
                                    </tr>
                                    <tr>
                                        <td class="mainsize">11</td>
                                        <td>29.5 см</td>
                                        <td>44.5</td>
                                        <td>11.5</td>
                                    </tr>
                                    <tr>
                                        <td class="mainsize">11.5</td>
                                        <td>30 см</td>
                                        <td>45</td>
                                        <td>12</td>
                                    </tr>
                                    <tr>
                                        <td class="mainsize">12</td>
                                        <td>30.5 см</td>
                                        <td>46</td>
                                        <td>12.5</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="re-dialog-footerbar">
                            <div class="re-float-left">
                                <input class="re-button re-cancel" style="margin-right: 10px; font-weight: normal;" name="lol" type="button" value="Закрыть таблицу">
                            </div>
                            <div class="re-float-right">В товаре нет Вашего размера? Выбирайте любой другой.
                                <br>Мы обязательно перезвоним и поможем найти Ваш размер
                            </div>
                        </div>
                    </div>
                </div>
                <div id="boxbuttoninfo">
                    <a id="bakk" title="">Доставка и оплата</a>
                    <div class="re-dialog bakk">
                        <div class="re-dialog-titlebar"><span class="re-dialog-title">Информация по данному товару<span></span></span>
                            <a class="re-dialog-icon" title="Закрыть"><span class="re-icon re-icon-close">×</span></a>
                        </div>
                        <div id="help_product" class="re-dialog-content">
                            <h4>Стоимость доставки?</h4>
                            <ul class="dostavka">
                                <li class="d_np">Новой Почтой по Украине. <span> Бесплатно</span></li>
                                <li class="d_kyiv">Курьером по Киеву.<span> Бесплатно</span></li>
                            </ul>
                            <h4>Полная стоимость товара?</h4>
                            <ul class="oplata">
                                <li class="o_np">При получении на почте -&nbsp;<span>Уточняйте у консультанта</span></li>
                                <li class="o_kyiv">Наличными курьеру в Киеве -&nbsp;<span>№точняйте у консультанта</span></li>
                                <li class="o_pb">На карту ПриватБанка -&nbsp;<span>№точняйте у консультанта</span></li>
                            </ul>
                            <h4>Обмен и возврат?</h4>
                            <p class="obmen"><span>14 дней.<br>Акции и скидки от Badger<br>Для получения консультации можно обратится по номеру телефона +38 (063) 595-39-77 ,+38 (063) 953-78-69 или +38 (068) 983-96-72</span></p>
                            <div class="date_dostavka"><strong>Доставка в течении</strong> <span>2</span> <strong>дней</strong></div>
                        </div>
                        <div class="re-dialog-footerbar">
                            <div class="re-float-left">
                                <input class="re-button re-cancel" style="margin-right: 10px; font-weight: normal;" name="lol" type="button" value="Закрыть">
                                <div class="re-float-right">Оригинальные <?=$product->type_name?> <?=$product->name?> производства <?=$product->brand?>
                                    <br>Мы всегда поможем подобрать подходящий вам товар.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modifications col-md-8 col-lg-8 col-xs-12 col-sm-12">
            <?php if(!empty($size_names)): ?>
                <?php $size_counter=0; ?>
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <?php foreach($size_names as $sizes ) :?>
                        <?php $size_counter++;?>
                        <?php if($size_counter==1):?>
                            <thead>
                                <?php $size_heads_count=0;?>
                                <?php foreach($sizes as $size):?>
                                    <?php
                                    $arrSizes=explode(':',$size);
                                    if(substr($arrSizes[0],-2)=='_A'){
                                        $size_key='<br>для Adidas';
                                        $size_key=substr($arrSizes[0],0,-2).$size_key;
                                        $cell=1;
                                    }
                                    elseif(substr($arrSizes[0],-2)=='_R'){
                                        $size_key='<br>для Reebok';
                                        $size_key=substr($arrSizes[0],0,-2).$size_key;
                                        $cell=1;
                                    }
                                    elseif(substr($arrSizes[1],-2)=='_A'){
                                        $size_key='<br>для Adidas';
                                        $size_key=substr($arrSizes[1],0,-2).$size_key;
                                        $cell=0;
                                    }
                                    elseif(substr($arrSizes[1],-2)=='_R'){
                                        $size_key='<br>для Reebok';
                                        $size_key=substr($arrSizes[1],0,-2).$size_key;
                                        $cell=0;
                                    }
                                    elseif($arrSizes[0]=='Height'){
                                        $size_key='Рост';
                                        $cell=1;
                                    }
                                    elseif($arrSizes[0]=='EUR'){
                                        $size_key='EUR';
                                        $cell=1;
                                    }
                                    elseif(strpos($arrSizes[1],'_')!=false){
                                        $size_key=$arrSizes[1];
                                        $cell=0;
                                    }
                                    elseif(strpos($arrSizes[0],'_')!=false){
                                        $size_key=$arrSizes[0];
                                        $cell=1;
                                    }
                                    else{
                                        $size_key='';
                                        $arrSizes[1]='buf';
                                        $cell=0;
                                    }

                                    $size_heads_count++;
                                    if($cell==1){
                                        $size_heads[$size_heads_count]['name']=$arrSizes[0];
                                        $size_heads[$size_heads_count]['key']=0;
                                        $size_heads[$size_heads_count]['value']=1;
                                    }
                                    else{
                                        $size_heads[$size_heads_count]['name']=$arrSizes[1];
                                        $size_heads[$size_heads_count]['key']=1;
                                        $size_heads[$size_heads_count]['value']=0;
                                    }
                                    echo '<th>'.$size_key.'</th>';
                                    ?>
                                <?php endforeach;?>
                            </thead>
                            <tbody>
                        <?php endif; ?>
                        <tr>
                            <?php $size_heads_counter=1;?>
                            <?php foreach($sizes as $size):?>
                                <?php
                                $arrSizes=explode(':',$size);
                                if(empty($arrSizes[1]))
                                    $arrSizes[1]='buf';
                                $flag=false;
                                for($i=$size_heads_counter;$i<=$size_heads_count;$i++){
                                    if($size_heads[$i]['name']=='RU_A' && $arrSizes[$size_heads[$i]['key']]=='RU_R') {
                                        if (!empty($arrSizes[$size_heads[$i]['value']]))
                                            echo '<td>' . $arrSizes[$size_heads[$i]['value']] . '</td>';
                                        $size_heads_counter=$i+1;
                                        $flag=true;
                                        break;
                                    }
                                }
                                if($flag==false){
                                    for($i=$size_heads_counter;$i<=$size_heads_count;$i++){
                                        if($size_heads[$i]['name']==$arrSizes[$size_heads[$i]['key']]) {
                                            if (!empty($arrSizes[$size_heads[$i]['value']]))
                                                echo '<td>' . $arrSizes[$size_heads[$i]['value']] . '</td>';
                                            $size_heads_counter=$i+1;
                                            $flag=true;
                                            break;
                                        }
                                        else
                                            echo '<td>'.'</td>';
                                    }
                                }
                                ?>
                            <?php endforeach;?>
                        </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
            <!--            <div class="re-modification" data-id="0">-->
            <!--                --><?php //if($product->size_names!=''):?>
            <!--                    <div class="mod-title">Размеры:</div>-->
            <!--                    --><?php //$i=0; ?>
            <!--                    --><?php //foreach (json_decode($product->size_names) as $size => $value):?>
            <!--                        <div class="mod-value">-->
            <!--                            <input id="mod_checkbox_0_--><?//=$i++?><!--" class="re-modification-checkbox mod-checkbox" type="checkbox" name="0" value="--><?//=$i?><!--">-->
            <!--                            <label for="mod_checkbox_0_--><?//=$i?><!--" class="mod-label">--><?//=$value?><!--</label>-->
            <!--                        </div>-->
            <!--                    --><?php //endforeach;?>
            <!--                --><?php //endif;?>
            <!--            </div>-->
        </div>

        <div class="clear" style="margin-bottom:20px;"></div>
        <p><?=$product->describtion?></p>
        <div class="clear"></div>
        <div class="clear"></div>
        </table>
    </div>
    <div class="clear" style="margin-bottom:30px;"></div>
    <!--noindex-->
    <a name="feeds"></a>
    <div id="re-review-block" class="block_spec border_none feed_block">
        <div class="div-h3 review-title">Оставить отзыв об этом товаре:</div>
        <div class="or-block">...или задайте
            <a title="" id="re-question">
                <b>вопрос</b>
            </a>
        </div>
        <div class="clear"></div>
        <div id="re-form-review">
            <form action=" <?= \yii\helpers\Url::to(['product/feed']) ?>" method="get" id="review_form">
                <input type="hidden" name="id_product" value="27112">
                <input type="hidden" name="product" value="<?=$product->name?> <?=$product->brand ?> <?=$product->article?>">
                <label class="labele" for="review_name">Представьтесь *</label>
                <input class="input_text" id="review_name" placeholder="Ваше имя" type="text" name="customer" value="" required="">
                <div class="clear"></div>
                <label class="labele" for="review_email">Ваш e-mail *</label>
                <input class="input_text" id="review_email" placeholder="example@badger.com" type="text" name="email" value="" required="">
                <div class="clear"></div>
                <label class="labele" for="review_quest">Ваш отзыв *</label>
                <textarea class="quest_text" placeholder="<?=$product->type_name?> <?=$product->name?> отличного качества.<?php if(!empty($product->advantages_1)) echo $product->advantages_1;?>! Как раз то,что я искал!" id="review_quest" rows="4" cols="20" name="review" required=""></textarea>
                <div class="clear"></div>
                <input class="btn submit" name="submit" value="Отправить отзыв" type="submit" style="float: right; margin: 10px 0 0;">
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div id="re-question-block" class=" col-lg-12 col-xs-12 col-md-12 col-sm-12 block_spec border_none feed_block" style="display:none;">
        <div class="div-h3 review-title">Задайте вопрос об этом товаре:</div>
        <div class="or-block">
            <a title="" id="re-review">
                <b>назад</b>
            </a>
        </div>
        <div class="clear"></div>
        <div id="re-form-question">
            <form action=" <?= \yii\helpers\Url::to(['product/question']) ?>" method="get" id="question_form">
                <input type="hidden" name="id_product" value="27112">
                <input type="hidden" name="product" value="<?=$product->name?> <?=$product->brand ?> <?=$product->article?>">
                <label class="labele" for="question_name">Представьтесь *</label>
                <input class="input_text" id="question_name" placeholder="Ваше имя" type="text" name="customer" value="" required="">
                <div class="clear"></div>
                <label class="labele" for="review_email">Ваш e-mail *</label>
                <input class="input_text" id="review_email" placeholder="example@badger.com" type="text" name="email" value="" required="">
                <div class="clear"></div>
                <label class="labele" for="question_quest">Ваш вопрос *</label>
                <textarea class="quest_text" placeholder="Ваш вопрос" id="question_quest" rows="4" cols="20" name="question" required=""></textarea>
                <div class="clear"></div>
                <input class="btn submit" name="submit" value="Задать вопрос" type="submit" style="float: right; margin: 10px 0 0;">
            </form>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#re-question').click(function(){
                $('#re-review-block').hide();
                $('#re-question-block').show();
                return false;
            });
            $('#re-review').click(function(){
                $('#re-review-block').show();
                $('#re-question-block').hide();
                return false;
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
            var reSwiper = new Swiper('.re-swiper-container', {
                pagination: '.swiper-pagination',
                nextButton: '.swiper-button-next',
                prevButton: '.swiper-button-prev',
                slidesPerView: 'auto',
                paginationClickable: true,
                centeredSlides: false,
                spaceBetween: 0,
                grabCursor: false,
                freeMode: true,
                keyboardControl: true
            });

            $("a[rel^='prettyPhoto']").prettyPhoto();
        });
    </script>
</div>
</div>

<div class="clear"></div>

<script type="text/javascript">

    window.setTimeout(function(){
        $("#register_phone").inputmasks(maskOpts);
        $("#cabinet_phone").inputmasks(maskOpts);
    }, 200);

</script>
<script type="text/javascript">

    $(document).ready(function() {
        function ReMiddle(s) {
            $(s).css('top', '50%');
            $(s).css('margin-top', '-' + Math.round($(s).height() / 2) + 'px');
        }
        $('#cakk, .cakk').click(function () {
            ReMiddle('div.cakk');
            $('div.cakk').fadeIn();
            $('body').css('overflow', 'hidden');
            return false;
        });
        $('#bakk, .bakk').click(function () {
            ReMiddle('div.bakk');
            $('div.bakk').fadeIn();
            $('body').css('overflow', 'hidden');
            return false;
        });
        $("#boxbuttonsize").appendTo(".description .btn_right");
        $("#boxbuttoninfo").appendTo(".description .btn_right");
    });


    $(document).ready(function() {
        $('input').click(function(){
            if ($(this).is('b.brand-filters input:checked')) {
                setTimeout(function() {
                    $('#re-filters-form').submit(); },2600);
            }});
        $('input').click(function(){
            if ($(this).is('b.size-filters input:checked')) {
                setTimeout(function() {
                    $('#re-filters-form').submit(); },1800);
            }});
        $('input').click(function(){
            if ($(this).is('input:not(:checked)')) {
                setTimeout(function() {
                    $('#re-filters-form').submit(); },1000);
            }});
    });


    $(".re-hint").text("Пожалуйста, выберите размер"),
        $(".fastbuy .m_link a").text("Купить"),
        $("#re-brands-tree-show").text("Сортировать по разделу"),window.innerWidth>1100&&$("body").addClass("zoom"),window.innerWidth>850&&$("body").addClass("zoomz");
    $("#brands").prependTo("#footer").appendTo("#slideshow");
    $("#badger_footer").appendTo(".footer_body");
    $('.block_spec:contains("Отделение «Новая Почта»")').prependTo('.block_spec:contains("Самовывоз")');
    $("select#contact_delivery").change(function(){
        if ($(this).find('option:selected').attr('id') == 'bel-post') {
            $("div#post-index>label").text("Город");
            $("#re-contact-address").text("Номер или адрес отделения");
        }
        if ($(this).find('option:selected').attr('id') == 'post-abroad') {
            $("div#post-index>label").text("Страна и город");
            $("#re-contact-address").text("Адрес доставки");
        }
        if ($(this).find('option:selected').attr('id') == 'courier') {
            $("#re-contact-address").text("Адрес доставки");
        }});

    $(document).ready(function() {
        $('input[class=" ajax-save-info-input"]').removeAttr('placeholder') == '03118';
        $('textarea[class="need ajax-save-info-input"]').removeAttr('placeholder') == 'г. Киев, ул. Центральная , 12-34';
    });

    $(document).ready(function() {
        var price = parseInt($('meta[itemprop="price"]').attr('content'));
        if (price >= 1000) {
            $(".d_kyiv span").text(" Бесплатно");
        } else {
            $(".d_kyiv span").text(" 25 грн");
        }
        if (price >= 1500) {
            $(".d_np span").text(" Бесплатно");
        } else {
            $(".d_np span").text((30+(0.01*price)).toFixed() + " грн");
        }

        var p = parseInt($('meta[itemprop="price"]').attr('content'));
        {
            $(".o_np span").text((20+(1.02*p)).toFixed() + " грн");
            $(".o_kyiv span").text(p + " грн");
            $(".o_pb span").text(p + " грн");
        }
    });

    $(document).ready(function() {

    }),

        function(a){var b={url:!1,callback:!1,target:!1,duration:200,on:"mouseover",touch:!0,onZoomIn:!1,onZoomOut:!1,magnify:1.05};a.zoom=function(b,c,d,e){var f,g,h,i,j,k,l,m=a(b),n=m.css("position"),o=a(c);return b.style.position=/(absolute|fixed)/.test(n)?n:"relative",b.style.overflow="hidden",d.style.width=d.style.height="",a(d).addClass("zoomImg").css({position:"absolute",top:0,left:0,opacity:0,width:d.width*e,height:d.height*e,border:"none",maxWidth:"none",maxHeight:"none"}).appendTo(b),{init:function(){g=m.outerWidth(),f=m.outerHeight(),c===b?(i=g,h=f):(i=o.outerWidth(),h=o.outerHeight()),j=(d.width-g)/i,k=(d.height-f)/h,l=o.offset();},move:function(a){var b=a.pageX-l.left,c=a.pageY-l.top;c=Math.max(Math.min(c,h),0),b=Math.max(Math.min(b,i),0),d.style.left=b*-j+"px",d.style.top=c*-k+"px";}};},a.fn.zoom=function(c){return this.each(function(){var d=a.extend({},b,c||{}),e=d.target&&a(d.target)[0]||this,f=this,g=a(f),h=document.createElement("img"),i=a(h),j="mousemove.zoom",k=!1,l=!1;if(!d.url){var m=f.querySelector("img");if(m&&(d.url=m.getAttribute("data-src")||m.currentSrc||m.src),!d.url)return;}
            g.one("zoom.destroy",function(a,b){g.off(".zoom"),e.style.position=a,e.style.overflow=b,h.onload=null,i.remove();}.bind(this,e.style.position,e.style.overflow)),h.onload=function(){function b(){m.init(),m.move(b),i.stop().fadeTo(a.support.opacity?d.duration:0,1,!!a.isFunction(d.onZoomIn)&&d.onZoomIn.call(h));}
                function c(){i.stop().fadeTo(d.duration,0,!!a.isFunction(d.onZoomOut)&&d.onZoomOut.call(h));}
                var m=a.zoom(e,f,h,d.magnify);"grab"===d.on?g.on("mousedown.zoom",function(d){1===d.which&&(a(document).one("mouseup.zoom",function(){c(),a(document).off(j,m.move);}),b(d),a(document).on(j,m.move),d.preventDefault());}):"click"===d.on?g.on("click.zoom",function(d){return k?void 0:(k=!0,b(d),a(document).on(j,m.move),a(document).one("click.zoom",function(){c(),k=!1,a(document).off(j,m.move);}),!1);}):"toggle"===d.on?g.on("click.zoom",function(a){k?c():b(a),k=!k;}):"mouseover"===d.on&&(m.init(),g.on("mouseenter.zoom",b).on("mouseleave.zoom",c).on(j,m.move)),d.touch&&g.on("touchstart.zoom",function(a){a.preventDefault(),l?(l=!1,c()):(l=!0,b(a.originalEvent.touches[0]||a.originalEvent.changedTouches[0]));}).on("touchmove.zoom",function(a){a.preventDefault(),m.move(a.originalEvent.touches[0]||a.originalEvent.changedTouches[0]);}).on("touchend.zoom",function(a){a.preventDefault(),l&&(l=!1,c());}),a.isFunction(d.callback)&&d.callback.call(h);},h.src=d.url;});},a.fn.zoom.defaults=b;}(window.jQuery),$(document).ready(function(){var a=$(".img_big_all .img_big a");$.each(a,function(a,b){var c=$(b).attr("href");$(b).zoom({url:c});});});</script><div class="re-overlay"></div>