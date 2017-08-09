
<!--     <div class="row">
        <div class="col-sm-3">
            <h2>Categories</h2>
            <ul id="accordion">
            <?= \app\components\MenuWidget::widget(['tpl' => 'menu'])?>
            </ul>
        </div>
        <div class="col-sm-9">
            <?php if(!empty($Caps) ): ?>
            <?php foreach ($Caps as $cap): ?>
                <div class="col-sm-4">
                    <div class="single-products">
                        <img src="<?= $cap->photo?>" width="200" height="200" alt="" />
                        <h2>UAH<?= $cap->price_sell ?></h2>
                        <p><?= $cap->name ?></p>
                        <a href="#" class="btn btn-default"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                    </div>
                </div>
            <?php endforeach;?>
            <?php endif;?>
        </div>
    </div> -->

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
    $('a.pp_close, .pp_overlay').live('click', function(){
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




<div id="content">
    <ul class="way" itemscope="" itemtype="http://schema.org/BreadcrumbList">
        <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
            <a class="way-home" itemprop="item" href="https://asteamco.com.ua/">
                <img alt="На главную магазина Asteamco" title="На главную магазина Asteamco" src="./images/home.gif">
                <meta itemprop="name" content="На главную магазина Asteamco">
            </a>
            <meta itemprop="position" content="1">
        </li>
        <li class="separator"></li>
        <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
            <a itemprop="item" href="https://asteamco.com.ua/catalog">
                <span itemprop="name">Каталог</span>
            </a>
            <meta itemprop="position" content="2">
        </li>
        <li class="separator"></li>
        <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
            <a itemprop="item" href="https://asteamco.com.ua/catalog/zhenskaya-obuv">
                <span itemprop="name">Женская обувь</span>
            </a>
            <meta itemprop="position" content="3">
        </li>
        <li class="separator"></li>
        <li itemprop="itemListElement" itemscope="" itemtype="http://schema.org/ListItem">
            <a class="way-last" itemprop="item" href="https://asteamco.com.ua/catalog/zhenskaya-obuv/sapogi---botinki">
                <span itemprop="name">Сапоги / Ботинки</span>
            </a>
            <meta itemprop="position" content="4">
        </li>
    </ul>
    <div class="clear"></div>



    <div id="contents">
        <div id="content_text" class="">
            <div class="head">
                <h1 class="left">Сапоги / Ботинки</h1>  
                <div class="right">
                    <a href="#" title="" rel="nofollow">Новизне</a>         
                    <a href="#" title="" rel="nofollow">Цене</a>
                    <span>Сортировать по:</span>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
            <div class="products-list">
                <div class="content_bloks re-product-item folder1 per_row3" style="height: 350px;">
                    <div class="image re-image" style="height: 227px;">
                        <a title="" href="#">
                            <img alt="Ботинки Adidas треккинговые Womens CW CHOLEAH SNEAKER Adidas AQ2581" title="" src="./Categories_files/196949335357f1878bce9d2_small.jpg" style="max-height: 227px;">
                        </a>
                    </div>
                    <div class="re-images-table none">
                        <div class="re-images-tr">
                            <div class="active" data-src="https://185504.selcdn.ru/static/draft.reshop.com.ua/catalog/30919/196949335357f1878bce9d2_small.jpg"></div>
                            <div data-src="https://185504.selcdn.ru/static/draft.reshop.com.ua/catalog/30919/206259047957f1878d34e2b_small.jpg"></div>
                            <div data-src="https://185504.selcdn.ru/static/draft.reshop.com.ua/catalog/30919/189229928157f1878e8f34d_small.jpg"></div>
                            <div data-src="https://185504.selcdn.ru/static/draft.reshop.com.ua/catalog/30919/141291381157f1878fe668c_small.jpg"></div>
                            <div data-src="https://185504.selcdn.ru/static/draft.reshop.com.ua/catalog/30919/103681226757f18791511bf_small.jpg"></div>
                            <div data-src="https://185504.selcdn.ru/static/draft.reshop.com.ua/catalog/30919/93423630357f18792ad3fe_small.jpg"></div>
                            <div data-src="https://185504.selcdn.ru/static/draft.reshop.com.ua/catalog/30919/39544673957f1879451d9b_small.jpg" class=""></div>
                        </div>
                    </div>
                    <div class="title" style="height: 65px;">
                        <a title="Ботинки Adidas треккинговые Womens CW CHOLEAH SNEAKER Adidas AQ2581" href="#" data-brand="Adidas">Ботинки Adidas треккинговые Womens CW CHOLEAH SNEAKER Adidas AQ2581</a>
                    </div>
                    <div class="price-old" title="Дешевле на 1 912 грн.">4 302 <span>грн.</span></div>
                    <div class="price isold"><span>2 390</span> грн.</div>
                    <div class="action"></div>                  
                    <div class="images-preview">
                        <a rel="prettyPhoto[gallery]" class="image-link" title="Увеличить изображение товара" data-href="/catalog/zhenskaya-obuv/sapogi---botinki/botinki-adidas-trekkingovye-womens-cw-choleah-sneaker-adidas-aq2581" data-title="Ботинки Adidas треккинговые Womens CW CHOLEAH SNEAKER Adidas AQ2581" data-price="2 390" data-symbol="грн." href="https://185504.selcdn.ru/static/draft.reshop.com.ua/catalog/30919/196949335357f1878bce9d2_original.jpg">
                            <img alt="" src="./images/images-enlarge.png">
                        </a>
                    </div>  
                </div>
                <div class="content_bloks re-product-item folder1 per_row3" style="height: 350px;">
                    <div class="image re-image" style="height: 227px;">
                        <a title="" href="#">
                            <img alt="Ботинки Adidas CW CHOLEAH PADDED CP Womens Adidas AQ2598" title="" src="./Categories_files/1032569394588ac00eaafa1_small.jpg" style="max-height: 227px;">
                        </a>
                    </div>
                    <div class="re-images-table none">
                        <div class="re-images-tr">
                            <div class="active" data-src="https://185504.selcdn.ru/static/draft.reshop.com.ua/catalog/35568/1032569394588ac00eaafa1_small.jpg"></div>
                            <div data-src="https://185504.selcdn.ru/static/draft.reshop.com.ua/catalog/35568/1300547042588ac00f015c5_small.jpg" class=""></div>
                            <div data-src="https://185504.selcdn.ru/static/draft.reshop.com.ua/catalog/35568/1872933793588ac00f24aa4_small.jpg" class=""></div>
                            <div data-src="https://185504.selcdn.ru/static/draft.reshop.com.ua/catalog/35568/1922127274588ac00f4d829_small.jpg" class=""></div>
                        </div>
                    </div>
                    <div class="title" style="height: 65px;">
                        <a title="Ботинки Adidas CW CHOLEAH PADDED CP Womens Adidas AQ2598" href="#" data-brand="Adidas">Ботинки Adidas CW CHOLEAH PADDED CP Womens Adidas AQ2598</a>
                    </div>
                    <div class="price-old" title="Дешевле на 1 352 грн.">3 042 <span>грн.</span></div>
                    <div class="price isold"><span>1 690</span> грн.</div>
                    <div class="action"></div>                  
                    <div class="images-preview">
                        <a rel="prettyPhoto[gallery]" class="image-link" title="Увеличить изображение товара" data-href="/catalog/zhenskaya-obuv/sapogi---botinki/botinki-adidas-cw-choleah-padded-cp-womens-adidas-aq2598" data-title="Ботинки Adidas CW CHOLEAH PADDED CP Womens Adidas AQ2598" data-price="1 690" data-symbol="грн." href="https://185504.selcdn.ru/static/draft.reshop.com.ua/catalog/35568/1032569394588ac00eaafa1_original.jpg">
                            <img alt="" src="./images/images-enlarge.png">
                        </a>
                    </div>  
                </div>
                <div class="content_bloks re-product-item folder1 per_row3" style="height: 350px;">
                    <div class="image re-image" style="height: 227px;">
                        <a title="" href="#"><img alt="Ботинки Adidas WARM COMFORT BOOT W Womens Adidas F38605" title="" src="./Categories_files/136701830588ac00246d4d_small.jpg" style="max-height: 227px;">
                        </a>
                    </div>
                    <div class="re-images-table none">
                        <div class="re-images-tr">
                            <div class="active" data-src="https://185504.selcdn.ru/static/draft.reshop.com.ua/catalog/35567/136701830588ac00246d4d_small.jpg"></div>
                            <div data-src="https://185504.selcdn.ru/static/draft.reshop.com.ua/catalog/35567/1396552500588ac00290a6c_small.jpg" class=""></div>
                            <div data-src="https://185504.selcdn.ru/static/draft.reshop.com.ua/catalog/35567/58461910588ac002c0b8c_small.jpg" class=""></div>
                            <div data-src="https://185504.selcdn.ru/static/draft.reshop.com.ua/catalog/35567/784213530588ac002f1bbd_small.jpg" class=""></div>
                        </div>
                    </div>
                    <div class="title" style="height: 65px;">
                        <a title="Ботинки Adidas WARM COMFORT BOOT W Womens Adidas F38605" href="https://draft.in.ua/catalog/zhenskaya-obuv/sapogi---botinki/botinki-adidas-warm-comfort-boot-w-womens-adidas-f38605" data-brand="Adidas">Ботинки Adidas WARM COMFORT BOOT W Womens Adidas F38605</a>
                    </div>
                    <div class="price-old" title="Дешевле на 1 112 грн.">2 502 <span>грн.</span></div>
                    <div class="price isold"><span>1 390</span> грн.</div>
                    <div class="action">
                        
                    </div>                  
                    <div class="images-preview">
                        <a rel="prettyPhoto[gallery]" class="image-link" title="Увеличить изображение товара" data-href="/catalog/zhenskaya-obuv/sapogi---botinki/botinki-adidas-warm-comfort-boot-w-womens-adidas-f38605" data-title="Ботинки Adidas WARM COMFORT BOOT W Womens Adidas F38605" data-price="1 390" data-symbol="грн." href="https://185504.selcdn.ru/static/draft.reshop.com.ua/catalog/35567/136701830588ac00246d4d_original.jpg">
                            <img alt="" src="./images/images-enlarge.png">
                        </a>
                    </div>
                </div>

            </div>
            <div class="clear"></div>
        </div>
    </div><!--/contents-->




    <div id="side_left">
        <div class="menu">
            <div class="head" onclick="location.href=&#39;/catalog&#39;;">Каталог</div>
            <ul>        
                <li>
                    <a class="level_opener" href="#"><i class="fa fa-arrow-down" aria-hidden="true"></i></a>
                    <a class="bold" href="#" title="Мужская обувь">Мужская обувь</a>
                    <ul style="display:none;">      
                        <li>
                            <a href="#" title="Кроссовки повседневные">Кроссовки повседневные</a>
                        </li>       
                        <li>
                            <a href="#" title="Кроссовки для бега">Кроссовки для бега</a>
                        </li>       
                        <li>
                            <a href="#" title="Кроссовки для тренировок">Кроссовки для тренировок</a>
                            <ul style="display:none;"></ul>
                        </li>       
                        <li>
                            <a href="#" title="Ботинки">Ботинки</a>
                        </li>       
                        <li>
                            <a href="#" title="Обувь для туризма">Обувь для туризма</a>
                            <ul style="display:none;"></ul>
                        </li>       
                        <li>
                            <a href="#" title="Обувь для тенниса">Обувь для тенниса</a>
                            <ul style="display:none;"></ul>
                        </li>       
                        <li>
                            <a href="#" title="Обувь для волейбола">Обувь для волейбола</a>
                            <ul style="display:none;"></ul>
                        </li>       
                        <li>
                            <a href="#" title="Бутсы / Футзалки">Бутсы / Футзалки</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>  
        <div class="side_basket">
            <div class="h3">С нами можно связаться:</div>
            <ul class="list">
                <li>
                    <span>
                    <b>Пн, Вт, Ср, Чт, Пт:</b>
                    с 11:00 до 18:00        </span>
                </li>

            
                <li>
                    <span><b>Сб, Вс:</b>
                    Выходной        </span>
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
<div class="information">Мы Магазин спортивной одежды и обуви Badger. Только оригинальная продукция. Мировые бренды. Приемлемые цены. Рады стараться для вас.</div>
