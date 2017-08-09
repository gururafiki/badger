	$("div.items").appendTo("#headerlogin");
	$("#re-callme").appendTo("#headercallback");
	$("#re-login > span").text("Вход");
	$("#re-register > span").text("Регистрация");
	$("#re-callme").text("044 353 01 06");
	$("div.itemsl").appendTo("#headercart");
	var maskList = $.masksSort($.masksLoad("/media/system/json/phone-codes.json"), ["#"], /[0-9]|#/, "mask");
	var maskOpts = {
	    inputmask: {
	        definitions: {
	            "#": {
	                validator: "[0-9]",
	                cardinality: 1
	            }
	        },
	        showMaskOnHover: false,
	        autoUnmask: true
	    },
	    match: /[0-9]/,
	    replace: "#",
	    list: maskList,
	    listKey: "mask",
	    onMaskChange: function(maskObj, determined) {
	        $(this).attr("placeholder", $(this).inputmask("getemptymask"));
	    }
	};
	$(document).ready(function() {
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
	        waitClickToCloseWindow: function() {
	            $('body').one('click', function(e) {
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
	        checkSimple: function(obj, is_each) {
	            var flag = obj.prev().is(':checked');
	            var obj_for = obj.attr('for');
	            if (!is_each) flag = !flag;
	            if (flag) {
	                obj.parent().parent().parent().find('b').after(
	                    '<i class="' + obj_for + '">' + obj.html() + '</i>'
	                );
	                $('i.' + obj_for).click(function() {
	                    $('#' + obj_for).next().trigger('click');
	                });
	            } else {
	                obj.parent().parent().parent().find('.' + obj_for).remove();
	            }
	        },

	        /**
	         * Делает чеки для селектов
	         */
	        checkSelect: function(obj, is_each) {
	            var flag = obj.prev().is(':checked');
	            var obj_select = obj.parent().parent().parent().find('.re-filters-select');
	            var obj_onecheck = null;
	            if (!is_each) flag = !flag;
	            if (flag) {

	                obj_select.addClass('selected');
	                if (obj_select.data('selected') <= 0) {
	                    obj_select
	                        .html(obj.html())
	                        .data('selected', 1);
	                } else {
	                    obj_select
	                        .html('Выбрано: ' + (obj_select.data('selected') + 1))
	                        .data('selected', obj_select.data('selected') + 1);
	                }


	            } else if (!is_each) {

	                if (obj_select.data('selected') > 2) {
	                    obj_select
	                        .html('Выбрано: ' + (obj_select.data('selected') - 1))
	                        .data('selected', obj_select.data('selected') - 1);
	                } else if (obj_select.data('selected') > 1) {
	                    if (obj.parent().find('input:checked').eq(0).val() == obj.prev().val()) obj_onecheck = obj.parent().find('input:checked').eq(1);
	                    else obj_onecheck = obj.parent().find('input:checked').eq(0);
	                    obj_select
	                        .html(obj_onecheck.next().html())
	                        .data('selected', 1);
	                } else if (obj_select.data('selected') <= 1) {
	                    obj_select
	                        .removeClass('selected')
	                        .html('Выбрать (' + obj_select.data('count') + ')')
	                        .data('selected', 0);
	                }

	            }
	        },

	        /**
	         * Вешает стартовые события
	         */
	        bindStartEvents: function() {

	            $('.re-filters-window label').click(function() {
	                if (Re.Filters.obj_filters.hasClass('re-filters-with-select')) Re.Filters.checkSelect($(this), false);
	                else Re.Filters.checkSimple($(this), false);
	            }).each(function() {
	                if (Re.Filters.obj_filters.hasClass('re-filters-with-select')) Re.Filters.checkSelect($(this), true);
	                else Re.Filters.checkSimple($(this), true);
	            });

	        },

	        /**
	         * Вешает события
	         */
	        bindEvents: function() {

	            // не передаем значения в сабмит формы если у нас дефолтные значения
	            $('#re-filters-form').submit(function() {
	                $('.re-filters-range-input').each(function() {
	                    if ($(this).data('default') == $(this).val()) $(this).addClass('default');
	                });
	                $('.re-filters-range').each(function() {
	                    if ($(this).find('.default').length == 2) {
	                        $(this).find('.default').each(function() {
	                            $(this).attr('name', '');
	                        });
	                    }
	                });
	            });


	            $('.re-filters-show').click(function() {
	                $(this).next('.re-filters-window')
	                    .toggle()
	                    .css('top', $(this).offset().top + $(this).outerHeight() + 5 - Re.Filters.obj_filters.offset().top);
	                Re.Filters.scrolltop = $(window).scrollTop();
	                return false;
	            });


	            $('.re-filters-select').click(function() {
	                var obj_window = $(this).next('.re-filters-window');
	                if (!obj_window.is(':visible')) {
	                    Re.Filters.obj_window.hide();
	                    obj_window
	                        .show()
	                        .css('top', $(this).offset().top + $(this).outerHeight() + 5 - Re.Filters.obj_filters.offset().top);
	                    if (obj_window.offset().left + obj_window.outerWidth() >= $(window).width()) {
	                        obj_window.addClass('right-pos');
	                    }
	                    Re.Filters.obj_opened_window = obj_window;
	                    Re.Filters.waitClickToCloseWindow();
	                } else {
	                    obj_window.hide();
	                }
	                return false;
	            });


	            $('.re-filters-close').click(function() {
	                if (Re.Filters.scrolltop != 0) {
	                    $('html, body').animate({
	                        scrollTop: Re.Filters.scrolltop
	                    }, 'slow');
	                    Re.Filters.scrolltop = 0;
	                }
	                Re.Filters.obj_window.hide();
	                return false;
	            });


	            $('.re-filters-uncheckall').click(function() {
	                $(this).parent().parent().find('input:checked').next().trigger('click');
	                return false;
	            });
	            $('.re-filters-checkall').click(function() {
	                $(this).parent().parent().find('input:not(:checked)').next().trigger('click');
	                return false;
	            });


	            $('.re-filters-delselected').click(function() {
	                var obj_clicked;

	                if ($(this).data('inputid') != undefined) {
	                    $('#' + $(this).data('inputid')).next().trigger('click');
	                }
	                if ($(this).data('rangeid') != undefined) {
	                    obj_clicked = $('#' + $(this).data('rangeid') + '-from');
	                    obj_clicked.val(obj_clicked.data('default'));
	                    obj_clicked.trigger('change');
	                    obj_clicked = $('#' + $(this).data('rangeid') + '-to');
	                    obj_clicked.val(obj_clicked.data('default'));
	                    obj_clicked.trigger('change');
	                }
	                $(this).parent().remove();
	                $('#re-filters-form').submit();
	                return false;
	            });


	            $('.re-filters-show-all').click(function() {
	                $('.re-filters-hide').show();
	                $('.re-filters-hide-all').show();
	                $(this).hide();
	                Re.Filters.all_scrolltop = $(window).scrollTop();
	                return false;
	            });


	            $('.re-filters-hide-all').click(function() {
	                $('.re-filters-hide').hide();
	                $('.re-filters-show-all').show();
	                $(this).hide();
	                if (Re.Filters.all_scrolltop != 0) {
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
	$(document).ready(function() {
	    $("a[rel^='prettyPhoto']").prettyPhoto();
	    $('a.image-link').mousedown(function() {
	        $('a.image-link').each(function() {
	            $(this).attr('title', '<a href="' + $(this).attr('data-href') + '">Перейти к товару «<b>' + $(this).attr('data-title') + '</b>»</a> / <span style="white-space:nowrap;">' + $(this).attr('data-price') + ' ' + $(this).attr('data-symbol') + '</span>');
	        });
	    });
	    $('a.pp_close, .pp_overlay').live('click', function() {
	        $('a.image-link').each(function() {
	            $(this).attr('title', 'Увеличить изображение товара');
	        });
	    });
	});
	$(document).ready(function() {

	    $('.re-product-item').mouseenter(function() {
	        $(this).find('.re-images-table').removeClass('none');
	    }).mouseleave(function() {
	        $(this).find('.re-images-table').addClass('none');

	        var $images_tr_div_obj = $(this).find('.re-images-tr div');
	        $(this).find('.re-image img').attr('src', $images_tr_div_obj.eq(0).data('src'));
	        $images_tr_div_obj.removeClass('active');
	        $images_tr_div_obj.eq(0).addClass('active');
	    });

	    $('.re-image').mousemove(function(e) {
	        var $dobjects = $(this).parent().find('.re-images-tr div');
	        var $current = Math.floor((e.pageX - Math.floor($(this).offset().left)) / ($(this).width() + 1) * $dobjects.length);
	        $dobjects.removeClass('active');
	        $dobjects.eq($current).addClass('active');
	        $(this).find('img').attr('src', $dobjects.eq($current).data('src'));
	    });
	    $('.re-images-tr div').mousemove(function() {
	        $(this).parent().find('div').removeClass('active');
	        $(this).addClass('active');
	        $(this).parent().parent().parent().find('.re-image img').attr('src', $(this).data('src'));
	    });

	});

	var re_per_row = re_per_row || 3;

	$(window).load(function() {

	    $('div.products-list').each(function() {

	        var $maxh = 200,
	            $iter = 1,
	            $t = 0,
	            $i = 0,
	            $row = 0,
	            $wd = 0,
	            $wi = 0,
	            $hd = 0,
	            $hi = 0,
	            $a = Array(),
	            $ai = Array(),
	            $aw = 1000,
	            $tit;
	        var $len = $(this).find('div.content_bloks').length;
	        if (re_per_row == 3) $maxh = 250;
	        if (re_per_row < 3) $maxh = 350;
	        $a[0] = 1000;
	        $ai[0] = 1000;
	        $(this).find('div.content_bloks').each(function() {
	            $tit = $(this).find('div.title');
	            $t = $tit.height() - $(this).find('div.title a').height();
	            if (!$tit.length) {
	                $t = $(this).find('div.descr').height() - 8 - $(this).find('div.descr a').height() - $(this).find('div.descr span').height();
	            }
	            if ($t - 5 > 0) $a[$row] = Math.min($t - 5, $a[$row]);
	            else $a[$row] = 0;

	            $hd = $(this).find('div.image').height();
	            $hi = $(this).find('div.image img').height();
	            if ($hd - $hi - 5 > 0) $ai[$row] = Math.min($hd - $hi - 5, $ai[$row]);
	            else $ai[$row] = 0;

	            $wd = $(this).find('div.image').width();
	            $wi = $(this).find('div.image img').width();
	            if ($wd - $wi > 0) $aw = Math.min(Math.round(($wd - $wi) * $hi / $wi), $aw);
	            else $aw = 0;

	            if (($i + 1) % re_per_row == 0 || $iter == $len) {
	                if ($ai[$row] == 0) {
	                    $ai[$row] = ($hd + $aw > $maxh) ? $hd - $maxh : -$aw;
	                }
	                $row++;
	                $a[$row] = 1000;
	                $ai[$row] = 1000;
	                $aw = 1000;
	                $i = 0;
	            } else {
	                $i++;
	            }
	            $iter++;
	        });

	        $row = 0;
	        $i = 0;
	        $iter = 1;
	        $(this).find('div.content_bloks').each(function() {
	            $(this).height($(this).height() - $a[$row] - $ai[$row]);
	            $(this).find('.content_bloks_folder').height($(this).height());
	            $tit = $(this).find('div.title');
	            $tit.height($tit.height() - $a[$row]);
	            if (!$tit.length) {
	                $(this).find('div.descr').height($(this).find('div.descr').height() - $a[$row]);
	            }
	            $hd = $(this).find('div.image').height();
	            $(this).find('div.image').height($hd - $ai[$row]);

	            $(this).find('div.image img').css('max-height', $hd - $ai[$row]);
	            if (($i + 1) % re_per_row == 0 || $iter == $len) {
	                $row++;
	                $i = 0;
	            } else {
	                $i++;
	            }
	            $iter++;
	        });

	    });

	});

	$(document).ready(function() {
	    $('.re-brands').click(function() {
	        $('.brands').show();
	        return false;
	    });
	    $('.re-brands-close').click(function() {
	        $('.brands').hide();
	        return false;
	    });
	});