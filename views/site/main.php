<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style type="text/css">body{background-color:#fff !important;}</style>
    <style type="text/css">body{background-image:none;}</style>
    <link rel="shortcut icon" type="image/vnd.microsoft.icon" href="/images/favicon.png">
    <script src="/js/jquery-1.7.2.min.js"></script>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
<script>
    $("div.items").appendTo("#headerlogin");
    $("#re-callme").appendTo("#headercallback");
    $("#re-login > span").text("Вход");
    $("#re-register > span").text("Регистрация");
    $("#re-callme").text("063 595 3977");
    $("div.itemsl").appendTo("#headercart");
</script>
<script type="text/javascript">
    $(document).ready(function(){

    var Re = Re || {};
    Re.Filters = Re.Filters || {

        scrolltop: 0,
        all_scrolltop: 0,
        obj_window: null,
        obj_opened_window: null,
        obj_filters: null,

        /**
         * Закрывает окна для селектов
         */
        waitClickToCloseWindow: function () {
            $('body').one('click', function(e){
                if (
                    e.target == Re.Filters.obj_opened_window.get(0) ||
                    $(e.target).parents('.re-filters-window').get(0) == Re.Filters.obj_opened_window.get(0)
                ) {
                    Re.Filters.waitClickToCloseWindow();
                    return;
                }
                Re.Filters.obj_window.hide();
            });
        },

        /**
         * Делает чеки для обычных окон
         */
        checkSimple: function (obj, is_each) {
            var flag = obj.prev().is(':checked');
            var obj_for = obj.attr('for');
            if ( !is_each ) flag = !flag;
            if ( flag ) {
                obj.parent().parent().parent().find('b').after(
                    '<i class="' + obj_for + '">' + obj.html() + '</i>'
                );
                $('i.' + obj_for).click(function(){
                    $('#' + obj_for).next().trigger('click');
                });
            } else {
                obj.parent().parent().parent().find('.' + obj_for).remove();
            }
        },

        /**
         * Делает чеки для селектов
         */
        checkSelect: function (obj, is_each) {
            var flag = obj.prev().is(':checked');
            var obj_select = obj.parent().parent().parent().find('.re-filters-select');
            var obj_onecheck = null;
            if ( !is_each ) flag = !flag;
            if ( flag ) {

                obj_select.addClass('selected');
                if ( obj_select.data('selected') <= 0 ) {
                    obj_select
                        .html( obj.html() )
                        .data('selected', 1);
                } else {
                    obj_select
                        .html( 'Выбрано: ' + (obj_select.data('selected')+1) )
                        .data( 'selected', obj_select.data('selected')+1 );
                }


            } else if ( !is_each ) {

                if ( obj_select.data('selected') > 2 ) {
                    obj_select
                        .html( 'Выбрано: ' + (obj_select.data('selected')-1) )
                        .data( 'selected', obj_select.data('selected')-1 );
                } else if ( obj_select.data('selected') > 1 ) {
                    if ( obj.parent().find('input:checked').eq(0).val() == obj.prev().val() ) obj_onecheck = obj.parent().find('input:checked').eq(1);
                    else obj_onecheck = obj.parent().find('input:checked').eq(0);
                    obj_select
                        .html( obj_onecheck.next().html() )
                        .data( 'selected', 1 );
                } else if ( obj_select.data('selected') <= 1 ) {
                    obj_select
                        .removeClass('selected')
                        .html( 'Выбрать ('+ obj_select.data('count') +')' )
                        .data( 'selected', 0 );
                }

            }
        },

        /**
         * Вешает стартовые события
         */
        bindStartEvents: function () {

            $('.re-filters-window label').click(function(){
                if ( Re.Filters.obj_filters.hasClass('re-filters-with-select') ) Re.Filters.checkSelect($(this), false);
                else Re.Filters.checkSimple($(this), false);
            }).each(function(){
                if ( Re.Filters.obj_filters.hasClass('re-filters-with-select') ) Re.Filters.checkSelect($(this), true);
                else Re.Filters.checkSimple($(this), true);
            });

        },

        /**
         * Вешает события
         */
        bindEvents: function () {

            // не передаем значения в сабмит формы если у нас дефолтные значения
            $('#re-filters-form').submit(function(){
                $('.re-filters-range-input').each(function(){
                    if ( $(this).data('default') == $(this).val() ) $(this).addClass('default');
                });
                $('.re-filters-range').each(function(){
                    if ( $(this).find('.default').length == 2 ) {
                        $(this).find('.default').each(function(){
                            $(this).attr('name', '');
                        });
                    }
                });
            });

            
            $('.re-filters-show').click(function(){
                $(this).next('.re-filters-window')
                    .toggle()
                    .css('top', $(this).offset().top + $(this).outerHeight() + 5 - Re.Filters.obj_filters.offset().top);
                Re.Filters.scrolltop = $(window).scrollTop();
                return false;
            });

            
            $('.re-filters-select').click(function(){
                var obj_window = $(this).next('.re-filters-window');
                if ( !obj_window.is(':visible') ) {
                    Re.Filters.obj_window.hide();
                    obj_window
                        .show()
                        .css('top', $(this).offset().top + $(this).outerHeight() + 5 - Re.Filters.obj_filters.offset().top);
                    if ( obj_window.offset().left + obj_window.outerWidth() >= $(window).width() ) {
                        obj_window.addClass('right-pos');
                    }
                    Re.Filters.obj_opened_window = obj_window;
                    Re.Filters.waitClickToCloseWindow();
                } else {
                    obj_window.hide();
                }
                return false;
            });

            
            $('.re-filters-close').click(function(){
                if ( Re.Filters.scrolltop != 0 ) {
                    $('html, body').animate({
                        scrollTop: Re.Filters.scrolltop
                    }, 'slow');
                    Re.Filters.scrolltop = 0;
                }
                Re.Filters.obj_window.hide();
                return false;
            });


            $('.re-filters-uncheckall').click(function(){
                $(this).parent().parent().find('input:checked').next().trigger('click');
                return false;
            });
            $('.re-filters-checkall').click(function(){
                $(this).parent().parent().find('input:not(:checked)').next().trigger('click');
                return false;
            });

            
            $('.re-filters-delselected').click(function(){
                var obj_clicked;
                
                if ( $(this).data('inputid') != undefined ) {
                    $('#' + $(this).data('inputid')).next().trigger('click');
                }
                if ( $(this).data('rangeid') != undefined ) {
                    obj_clicked = $('#' + $(this).data('rangeid') + '-from');
                    obj_clicked.val( obj_clicked.data('default') );
                    obj_clicked.trigger('change');
                    obj_clicked = $('#' + $(this).data('rangeid') + '-to');
                    obj_clicked.val( obj_clicked.data('default') );
                    obj_clicked.trigger('change');
                }
                $(this).parent().remove();
                $('#re-filters-form').submit();
                return false;
            });

            
            $('.re-filters-show-all').click(function(){
                $('.re-filters-hide').show();
                $('.re-filters-hide-all').show();
                $(this).hide();
                Re.Filters.all_scrolltop = $(window).scrollTop();
                return false;
            });

            
            $('.re-filters-hide-all').click(function(){
                $('.re-filters-hide').hide();
                $('.re-filters-show-all').show();
                $(this).hide();
                if ( Re.Filters.all_scrolltop != 0 ) {
                    $('html, body').animate({
                        scrollTop: Re.Filters.all_scrolltop
                    }, 'slow');
                    Re.Filters.all_scrolltop = 0;
                }
                return false;
            });

        },


        init: function() {

            this.obj_window = $('.re-filters-window');
            this.obj_filters = $('.re-filters');

            this.bindEvents();
            this.bindStartEvents();

        }

    };

        Re.Filters.init();

    });
</script>
<!--/noindex-->
<script type="text/javascript">
var re_per_row = re_per_row || 3;

$(window).load(function() {

$('div.products-list').each(function(){

    var $maxh = 200, $iter = 1, $t = 0, $i = 0, $row = 0, $wd = 0, $wi = 0, $hd = 0, $hi = 0, $a = Array(), $ai = Array(), $aw = 1000, $tit;
    var $len = $(this).find('div.content_bloks').length;
    if ( re_per_row == 3 ) $maxh = 250;
    if ( re_per_row < 3 ) $maxh = 350;
    $a[0] = 1000; $ai[0] = 1000;
    $(this).find('div.content_bloks').each(function(){
        $tit = $(this).find('div.title');
        $t = $tit.height() - $(this).find('div.title a').height();
        if ( !$tit.length ) {
            $t = $(this).find('div.descr').height() - 8 - $(this).find('div.descr a').height() - $(this).find('div.descr span').height();
        }
        if ( $t - 5 > 0 ) $a[$row] = Math.min($t - 5, $a[$row]);
        else $a[$row] = 0;

        $hd = $(this).find('div.image').height();
        $hi = $(this).find('div.image img').height();
        if ( $hd - $hi - 5 > 0 ) $ai[$row] = Math.min($hd - $hi - 5, $ai[$row]);
        else $ai[$row] = 0;

        $wd = $(this).find('div.image').width();
        $wi = $(this).find('div.image img').width();
        if ( $wd - $wi > 0 ) $aw = Math.min( Math.round(($wd - $wi) * $hi / $wi), $aw );
        else $aw = 0;

        if ( ($i + 1) % re_per_row == 0 || $iter == $len ) {
            if ( $ai[$row] == 0 ) {
                $ai[$row] = ( $hd + $aw > $maxh ) ? $hd - $maxh : - $aw ;
            }
            $row++;
            $a[$row] = 1000;
            $ai[$row] = 1000;
            $aw = 1000;
            $i = 0;
        } else { $i++; }
        $iter++;
    });

    $row = 0;
    $i = 0;
    $iter = 1;
    $(this).find('div.content_bloks').each(function(){
        $(this).height( $(this).height() - $a[$row] - $ai[$row] );
        $(this).find('.content_bloks_folder').height( $(this).height() );
        $tit = $(this).find('div.title');
        $tit.height( $tit.height() - $a[$row] );
        if ( !$tit.length ) {
            $(this).find('div.descr').height( $(this).find('div.descr').height() - $a[$row] );
        }
        $hd = $(this).find('div.image').height();
        $(this).find('div.image').height( $hd - $ai[$row] );

        $(this).find('div.image img').css( 'max-height', $hd - $ai[$row] );
        if ( ($i + 1) % re_per_row == 0 || $iter == $len ) {
            $row++;
            $i = 0;
        } else { $i++; }
        $iter++;
    });

});

});
</script>
<script type="text/javascript">
$(document).ready(function(){

    $('.re-product-item').mouseenter(function(){
        $(this).find('.re-images-table').removeClass('none');
    }).mouseleave(function(){
        $(this).find('.re-images-table').addClass('none');

        var $images_tr_div_obj = $(this).find('.re-images-tr div');
        $(this).find('.re-image img').attr('src', $images_tr_div_obj.eq(0).data('src'));
        $images_tr_div_obj.removeClass('active');
        $images_tr_div_obj.eq(0).addClass('active');
    });

    $('.re-image').mousemove(function(e){
        var $dobjects = $(this).parent().find('.re-images-tr div');
        var $current = Math.floor((e.pageX - Math.floor($(this).offset().left)) / ($(this).width()+1) * $dobjects.length);
        $dobjects.removeClass('active');
        $dobjects.eq( $current ).addClass('active');
        $(this).find('img').attr('src', $dobjects.eq( $current ).data('src'));
    });
    $('.re-images-tr div').mousemove(function(){
        $(this).parent().find('div').removeClass('active');
        $(this).addClass('active');
        $(this).parent().parent().parent().find('.re-image img').attr('src', $(this).data('src'));
    });

});
</script>

<script type="text/javascript">
$(document).ready(function(){
    $("a[rel^='prettyPhoto']").prettyPhoto();
    $('a.image-link').mousedown(function(){
        $('a.image-link').each(function(){
            $(this).attr('title', '<a href="'+$(this).attr('data-href')+'">Перейти к товару «<b>'+$(this).attr('data-title')+'</b>»</a> / <span style="white-space:nowrap;">'+$(this).attr('data-price')+' '+$(this).attr('data-symbol')+'</span>');
        });
    });
    $('a.pp_close').on('click','.pp_overlay', function(){
        $('a.image-link').each(function(){
            $(this).attr('title', 'Увеличить изображение товара');
        });
    });
});
</script>

<script type="text/javascript">
$(document).ready(function(){
    $('.re-brands').click(function(){
        $('.brands').show();
        return false;
    });
    $('.re-brands-close').click(function(){
        $('.brands').hide();
        return false;
    });
});
</script>
</head>
<body class="zoom zoomz">
<?php $this->beginBody() ?>
<div id="body">
    <div id="header">
        <div class="arbitrary_javascript_top">
            <header>
                <div class="top">
                    <ul>
                        <li id="headercallback"></li>
                        <li class="tel"><a href="https://asteamco.com.ua/contacts#question">Задать вопрос</a></li>
                        <li class="email"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;asteamco@ukr.net</span></li>
                        <li id="headerlogin">
                            <div class="items">
                                <a id="re-login" class="login" title="Войти - «Badger Sportswear»" href="#"><span>Вход</span></a> 
                                <div class="left sep">|</div> 
                                <a id="re-register" class="" title="Зарегистрироваться - «Badger Sportswear»" href="#"><span>Регистрация</span></a> 
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="hello">
                    <div style="width:1240px;">
                        <div id="headerlogo"><a href="https://asteamco.com.ua/" title="Интернет-магазин «Asteamco»"><img src="/images/logo_badger.jpg"></a></div>
                        <div id="headersearch">
                            <form id="search1" action=" <?= \yii\helpers\Url::to(['category/search']) ?>" method="get">
                                <input class="q" name="q" type="text" placeholder="Поиск по товарам...">
                                <input class="search_sumbit" title="Нажмите для поиска" type="submit" value=" "> 
                            </form>
                            <div class="contact_bar">
                                <i class="fa fa-phone" aria-hidden="true" > <a>+38(063) 595-39-77</a></i>
                                <i class="fa fa-phone" aria-hidden="true"> <a>+38(063) 963-78-69</a></i>
                                <i class="fa fa-phone" aria-hidden="true"> <a>+38(068) 983-96-72</a></i>
                            </div>
                        </div>
                        <div id="visitedee"><a class="ivisited" href="#">Кнопочка</a></div>
                        <div id="headercart">
                            <div class="itemsl">
                                В корзине нет товаров. Начните покупки в <a class="catalog" title="Перейти к каталогу товаров" href="https://asteamco.com.ua/catalog">нашем каталоге</a>    
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div style="clear: both;">&nbsp;</div>
            <div id="menu">
                <div id="main_badger">
                    <ul>
                        <li class="listnav"><span class="nav marginnav">Спортивная обувь</span>
                            <ul class="listcolumn marginlistcolumn">
                                <li class="columnnav">
                                    <h4>Мужская обувь</h4>
                                    <a href="#">Кроссовки повседневные</a> 
                                    <a href="#">Кроссовки для бега</a> 
                                    <a href="#">Кроссовки для тренировок</a> 
                                    <a href="#">Ботинки</a> 
                                    <a href="#">Обувь для туризма</a> 
                                    <a href="#">Обувь для тенниса</a> 
                                    <a href="#">Бутсы / Футзалки</a> 
                                    <a href="#">Тапочки / Сланцы</a>
                                </li>
                                <li class="columnnav">
                                    <h4>Женская обувь</h4>
                                    <a href="#">Кроссовки повседневные</a> 
                                    <a href="#">Кроссовки для бега</a> 
                                    <a href="#">Кроссовки для фитнеса</a> 
                                    <a href="#">Сапоги / Ботинки</a> 
                                    <a href="#">Обувь для туризма</a> 
                                    <a href="#">Обувь для тенниса</a> 
                                    <a href="#">Кеды / Слипоны</a> 
                                    <a href="#">Тапочки / Сланцы</a>
                                </li>
                                <li class="columnnav">
                                    <h4>Детская обувь</h4>
                                    <a href="#">Кроссовки</a> 
                                    <a href="#">Сапоги / Ботинки</a> 
                                    <a href="#">Обувь для бега</a> 
                                    <a href="#">Обувь для тенниса</a> 
                                    <a href="#">Бутсы / Футзалки</a> 
                                    <a href="#">Тапочки / Сланцы</a>
                                </li>
                            </ul>
                        </li>
                        <li class="listnav"><span class="nav">Спортивная одежда</span>
                            <ul class="listcolumn">
                                <li class="columnnav">
                                    <h4>Мужская одежда</h4>
                                    <a href="#">Футболки / Поло</a> 
                                    <a href="#">Шорты</a> 
                                    <a href="#">Тайтсы / Леггинсы</a> 
                                    <a href="#">Толстовки / Джемперы</a> 
                                    <a href="#">Лонгсливы / Регланы</a> 
                                    <a href="#">Брюки спортивные</a> 
                                    <a href="#">Костюмы спортивные</a> 
                                    <a href="#">Термобелье</a> 
                                    <a href="#">Жилетки</a> 
                                    <a href="#">Куртки</a> 
                                    <a href="#">Пуховики</a>
                                </li>
                                <li class="columnnav">
                                    <h4>Женская одежда</h4>
                                    <a href="#">Футболки / Поло</a> 
                                    <a href="#">Топ-бра / Майки</a> 
                                    <a href="#">Шорты</a> 
                                    <a href="#">Леггинсы / Капри</a> 
                                    <a href="#">Толстовки / Джемперы</a> 
                                    <a href="#">Брюки спортивные</a> 
                                    <a href="#">Костюмы спортивные</a> 
                                    <a href="#">Термобелье</a> 
                                    <a href="#">Жилетки</a> 
                                    <a href="#">Куртки</a> 
                                    <a href="#">Пуховики</a>
                                </li>
                                <li class="columnnav">
                                    <h4>Детская одежда</h4>
                                    <a href="#">Футболки / Поло</a> 
                                    <a href="#">Шорты</a> 
                                    <a href="#">Толстовки</a> 
                                    <a href="#">Брюки спортивные</a> 
                                    <a href="#">Костюмы спортивные</a> 
                                    <a href="#">Термобелье</a> 
                                    <a href="#">Жилетки</a> 
                                    <a href="#">Комбинезоны</a> 
                                    <a href="#">Пуховики / Куртки</a>
                                </li>
                            </ul>
                        </li>
                        <li class="listnav">
                            <span class="nav">Аксессуары</span>
                            <ul class="listcolumn">
                                <li class="columnnav">
                                    <h4>Рюкзаки и сумки</h4>
                                    <a href="#">Рюкзаки</a> 
                                    <a href="#">Спортивные сумки</a> 
                                    <a href="#">Повседневные сумки</a> 
                                    <a href="#">Маленькие сумки</a> 
                                    <a href="#">Дорожные сумки</a> 
                                    <a href="#">Сумки для обуви</a> 
                                    <a href="#">Кошельки</a>
                                </li>
                                <li class="columnnav">
                                    <h4>Аксессуары</h4>
                                    <a href="#">Шапки</a> 
                                    <a href="#">Шарфы</a> 
                                    <a href="#">Перчатки</a> 
                                    <a href="#">Средние носки</a> 
                                    <a href="#">Короткие носки</a> 
                                    <a href="#">Гетры</a> 
                                    <a href="#">Кепки</a>
                                </li>
                                <li class="columnnav">
                                    <h4>Виды спорта</h4>
                                    <a href="#">Тренировки / Бег</a> 
                                    <a href="#">Игры с мячем</a> 
                                    <a href="#">Плавание</a> 
                                    <a href="#">Велоспорт</a> 
                                    <a href="#">Туризм / Путешествия</a> 
                                    <a href="#">Лыжи / Горный спорт</a> 
                                    <a href="#">Электроника</a> 
                                </li>
                            </ul>
                        </li>
                        <li class="listnav">
                            <a class="nav" href="#">Бренды</a>
                            <ul class="listcolumn">
                                <li class="columnnav"> 
                                    <h4>Adidas - обувь</h4>
                                    <a href="#">Мужские кроссовки Adidas</a>
                                    <a href="#">Мужская беговая обувь Adidas</a>
                                    <a href="#">Мужские ботинки Adidas</a>
                                    <a href="#">Мужские тапочки Adidas</a>
                                    <a href="#">Женские кроссовки Adidas</a>
                                    <a href="#">Женская беговая обувь Adidas</a>
                                    <a href="#">Женские тапочки Adidas</a>
                                </li>
                                <li class="columnnav"> 
                                    <h4>Reebok - обувь</h4>
                                        <a href="#">Мужские кроссовки Reebok</a>
                                        <a href="#">Мужская беговая обувь Reebok</a>
                                        <a href="#">Мужские тапочки Reebok</a>
                                        <a href="#">Женские кроссовки Reebok</a>
                                        <a href="#">Женские кроссовки Reebok для фитнеса</a>
                                        <a href="#">Женская беговая обувь Reebok</a>
                                </li>
                            </ul>
                        </li>
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
        </div>
    </div><!--/header-->
</div><!--/body-->
<?= Breadcrumbs::widget([
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
]) ?>
<div id="content">
<?= $content ?>
        <div class="side_basket">
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
    <div class="clear"></div>
</div><!--/content-->
    <div id="footer">
        <div class="footer_body">
            <div class="clear"></div>
            <div id="badger_footer"> 
                <footer> 
                    <div class="company"> 
                        <p>Интернет-магазин Badger © 2015-2017</p> 
                        <p>02000, Украина, г. Киев</p>
                        <p>Вопросы сотрудничества: +38 (063) 595 3977</p>
                        <p>Skype: asteam.com.ua</p>
                        <p>Viber: + 38 (063) 595 3977</p>
                        <br>
                        <p><a href="https://www.facebook.com/badgerstore/"><i class="fa fa-facebook-square" aria-hidden="true"></i></a><a href="https://vk.com/badger_shop">  <i class="fa fa-vk" aria-hidden="true"></i></a></p><br>
                    </div> 
                    <div class="help"> 
                        <h5 class="h_footer">Помощь</h5> 
                        <ul> 
                            <li><a href="">Доставка</a></li> 
                            <li><a href="">Оплата</a></li> 
                            <li><a href="">Обмен и возврат</a></li> 
                            <li><a href="">Таблицы размеров</a></li> 
                            <li><a href="">Частые вопросы</a></li>
                            <li><a href="">Контакты</a></li>
                         </ul> 
                    </div> 
                    <div class="badgerstore"> 
                        <h5 class="h_footer">Badger</h5> 
                        <ul> 
                            <li><a href="">О компании</a></li> 
                            <li><a href="">Новости</a></li>
                            <li><a href="">Оригинальный товар</a></li>
                            <li><a href="">Программа лояльности</a></li>
                            <li><a href="">Защита покупателей</a></li>
                            <li><a href="">Отзывы о магазине</a></li> 
                        </ul> 
                    </div>
                </footer> 
                <div style="clear: both;"> </div>
            </div>
        </div>
    </div><!--/footer-->
        <div class="re-dialog re-login">
        <div class="re-dialog-titlebar">
            <span class="re-dialog-title">Вход в личный кабинет</span>
            <a href="#" class="re-dialog-icon" title="Закрыть"><span class="re-icon re-icon-close">×</span></a>
        </div>
        <div class="re-dialog-content">
            <form method="post" action="https://asteamco.com.ua/login" name="login_form" id="login_form">
                <div class="re-form-field">
                    <label for="login_email">Email <span class="re-red">*</span></label>
                    <input type="text" maxlength="100" value="" size="35" name="email" id="login_email" required="required">
                </div>
                <div class="re-form-field">
                    <label for="login_password">Пароль <span class="re-red">*</span></label>
                    <input type="password" maxlength="32" value="" size="35" name="password" id="login_password" required="required">
                </div>
                <div class="re-form-field">
                    <a class="re-right" id="re-recover-password" title="Кликните, чтобы перейти к восстановлению пароля" href="#">Забыли пароль?</a>
                </div>
            </form>
        </div>
        <div class="re-dialog-footerbar">
            <div class="re-float-right">
                <input type="button" class="re-button re-cancel" style="margin-right: 10px; font-weight: normal;" value="Отмена" name="lol">
                <input type="button" class="re-button re-button-blue" id="login_submit" value="Войти" name="lol">
            </div>
        </div>
    </div>
    <div class="re-dialog re-recover">
        <div class="re-dialog-titlebar">
            <span class="re-dialog-title">Восстановление пароля</span>
            <a href="#" class="re-dialog-icon" title="Закрыть"><span class="re-icon re-icon-close">×</span></a>
        </div>
        <div class="re-dialog-content">
            <form method="post" action="https://asteam.com.ua/recover" name="recover_form" id="recover_form">
                <div class="re-form-field">
                    <label for="recover_email">Email <span class="re-red">*</span></label>
                    <input type="text" maxlength="100" value="" size="35" name="email" id="recover_email" required="required">
                </div>
                <div class="re-form-field">
                    Введите email адрес, который Вы указывали при регистрации.<br> Мы отправим на него письмо со ссылкой для восстановления пароля.             </div>
            </form>
        </div>
        <div class="re-dialog-footerbar">
            <div class="re-float-right">
                <input type="button" class="re-button re-cancel" style="margin-right: 10px; font-weight: normal;" value="Отмена" name="lol">
                <input type="button" class="re-button re-button-blue" id="recover_submit" value="Отправить письмо" name="lolka">
            </div>
        </div>
    </div>

    <div class="re-dialog re-register">
        <div class="re-dialog-titlebar">
            <span class="re-dialog-title">Регистрация личного кабинета покупателя</span>
            <a href="#" class="re-dialog-icon" title="Закрыть"><span class="re-icon re-icon-close">×</span></a>
        </div>
        <div class="re-dialog-content" id="re-form-register">
            <form method="get" action="<?= \yii\helpers\Url::to(['site/register']) ?>" name="register_form" id="register_form">
                <div class="re-left">
                    <div class="re-form-field">
                        <label for="register_name">Имя <span class="re-red">*</span></label>
                        <input type="text" maxlength="100" value="" size="35" name="name" id="register_name" required="required">
                    </div>
                    <div class="re-form-field">
                        <label for="register_email">Email <span class="re-red">*</span></label>
                        <input type="text" maxlength="100" value="" size="35" name="email" id="register_email" required="required">
                    </div>
                    <div class="re-form-field">
                        <label for="register_password">Пароль <span class="re-red">*</span></label>
                        <input type="password" maxlength="32" value="" size="35" name="password" id="register_password" required="required">
                    </div>
                </div>
                <div class="re-right">
                    <div class="re-form-field">
                        <label for="register_phone">Телефон</label>
                        <input type="text" placeholder="+_(___)___-____" value="" size="35" name="phone" id="register_phone" maxlength="30">
                    </div>
                    <div class="re-form-field">
                        <label for="register_postcode">Индекс</label>
                        <input type="text" maxlength="20" value="" size="35" name="postcode" id="register_postcode">
                    </div>
                    <div class="re-form-field">
                        <label for="register_city">Город</label>
                        <input type="text" maxlength="100" value="" size="35" name="city" id="register_city">
                    </div>
                </div>
                <div style="clear:both;"></div>
                <div class="re-form-field">
                    <label for="register_address">Адрес</label>
                    <textarea rows="3" cols="78" name="address" id="register_address" style="width:98%;"></textarea>
                </div>
            </form>
        </div>
        <div class="re-dialog-footerbar">
            <div class="re-float-right">
                <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
                <input type="button" class="re-button re-cancel" style="margin-right: 10px; font-weight: normal;" value="Отмена" name="lol">
                <input type="submit" class="re-button re-button-blue" id="register_submit" value="Зарегистрироваться" name="lol">
            </div>
        </div>
    </div>

<div class="re-overlay"></div>
<script type="text/javascript">
    $('a.level_opener').click(function(){
        if( $(this).hasClass('opened') ) {
            $(this).removeClass('opened');
            $(this).html('<i class="fa fa-angle-down" aria-hidden="true"></i>');
            $(this).parent().find('>ul').slideUp('fast');
        }
        else {
            $(this).addClass('opened');
            $(this).html('<i class="fa fa-angle-double-down" aria-hidden="true"></i>');
            $(this).parent().find('>ul').slideDown('fast');
        }
        return false;
    });
</script>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
