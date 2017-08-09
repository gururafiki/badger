$(document).ready(function(){

	// костыль для IE8
	// only run when the substr function is broken
	if ('ab'.substr(-1) != 'b') {
		String.prototype.substr = function(substr) {
			return function(start, length) {
			// did we get a negative start, calculate how much it is from the beginning of the string
			if (start < 0) start = this.length + start;

			// call the original function
			return substr.call(this, start, length);
			}
		}(String.prototype.substr);
	}


	var pricer = {
		discount: [],
		delivery: [],
		pay_fee: [],
		fees: [],
		settings:[]
	};

	if ($('span#settings_for_js_cart').length < 1) {
		var def = '{"locale": "DEV","titles": {"pay_post": "Наложенный платеж","delivery_cost": "Стоимость доставки","products_cost": "Стоимость товаров","discount_sum": "Сумма скидки","commision": "Комиссия","total": "Итого"}}';
		pricer.settings = jQuery.parseJSON(def);
	} else {
		pricer.settings = jQuery.parseJSON($('span#settings_for_js_cart').text());
	}



	pricer.product_cost = 0;

	pricer.discount['enable'] = false;
	pricer.discount['cost'] = 0;

	pricer.delivery['enable'] = false;
	pricer.delivery['cost'] = 0;

	pricer.pay_fee['enable'] = false;
	pricer.pay_fee['type'] = null;
	pricer.pay_fee['cost'] = 0;

	pricer.total = 0;

	pricer.fees['erip'] = [];
	pricer.fees['erip']['title'] = 'Ерип';
	pricer.fees['erip']['percent'] = 3;

	pricer.fees['post'] = [];
	pricer.fees['post']['title'] = pricer.settings['titles']['pay_post'];
	if ($('span#post-commission').length) {
		pricer.fees['post']['percent'] = parseFloat($('span#post-commission').text());
	} else {
		pricer.fees['post']['percent'] = 0;
	}

	pricer.fees['post_abroad'] = [];
	pricer.fees['post_abroad']['title'] = pricer.settings['titles']['pay_post'];
	if ($('span#post-abroad-commission').length) {
		pricer.fees['post_abroad']['percent'] = parseFloat($('span#post-abroad-commission').text());
	} else {
		pricer.fees['post_abroad']['percent'] = 0;
	}

	pricer.calc = function(){
		this.product_cost = parseFloat(del_spaces($('#re-total-price b').html()));

		this.total += this.product_cost;

		if (this.discount['enable']) {
			this.total -= this.discount['cost'];
		}

		if (this.delivery['enable']) {
			this.total += this.delivery['cost'];
		}

		if (this.pay_fee['enable']) {
			var fee_percent = this.fees[this.pay_fee['type']]['percent'];
			this.pay_fee['cost'] = this.total / 100 * fee_percent;
			this.total += this.pay_fee['cost'];
		}

		if (this.settings['locale'] == 'BY' || this.settings['locale'] == 'DEV') {
			this.total = Round(this.total);
		}
	};


	pricer.render = function() {
		this.calc();

		var root_node = $('.re-dialog-res-tfoot table');

		var table = '<tr><td  class="re-total">'+this.settings['titles']['products_cost']+'</td><td class="re-total-price">'+toPrice(this.product_cost)+'</td></tr>';

		if (this.discount['enable']) {
			table += '<tr><td class="re-total">'+this.settings['titles']['discount_sum']+'</td><td class="re-total-price">'+toPrice(this.discount['cost'])+'</td></tr>';
		}
		if (this.delivery['enable']) {
			table += '<tr><td class="re-total">'+this.settings['titles']['delivery_cost']+'</td><td class="re-total-price">'+toPrice(this.delivery['cost'])+'</td></tr>';
		}
		if (this.pay_fee['enable']) {
			table += '<tr><td class="re-total">'+this.settings['titles']['commision']+' "'+pricer.fees[this.pay_fee['type']]['title']+'"</td><td class="re-total-price">'+toPrice(this.pay_fee['cost'].toFixed(2))+'</td></tr>';
		}

		table += '<tr><td class="re-total"><b>'+this.settings['titles']['total']+'</b></td><td class="re-total-price"><b>'+toPrice(this.total)+'</b></td></tr>';

		root_node.text('').append(table);

		this.clean();
	};

	pricer.clean = function(){
		pricer.product_cost = 0;

		pricer.discount['enable'] = false;
		pricer.discount['cost'] = 0;

		pricer.delivery['enable'] = false;
		pricer.delivery['cost'] = 0;

		pricer.pay_fee['enable'] = false;
		pricer.pay_fee['type'] = null;
		pricer.pay_fee['cost'] = 0;

		pricer.total = 0;
	};

	$(document).on( "click",'#show-promo-input', function() {
		$(this).hide();
		$('#promo-input-area').show();
		return false;
	});

	function getCookie(cname) {
		var name = cname + "=";
		var ca = document.cookie.split(';');
		for(var i=0; i<ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1);
			if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
		}
		return "";
	}
    $(document).on( "click",'#send-promocode', function() {
		var promocode = $('#promo-input').val();
		var customer_hash = getCookie('customer_hash');

			$.ajax({
				url: '/cart/promocode/'+promocode+'/'+customer_hash,
				success: function(data) {
					data = $.parseJSON(data);
					$('promo-message').hide();
					if (data['status']) {
                        $.ajax({ url: '/',
                            async: true,
                            success: function(data) {
                                var post = $(data).find('#post-calc');
                                var post_abroad =  $(data).find('#post-calc-abroad');
                                var delivery = $(data).find('.re-dialog-tfoot');

                                $('#post-calc').html(post);
                                $('#post-calc-abroad').html(post_abroad);
                                $('.re-dialog-tfoot').html(delivery);
                                $('.ajax-save-count').eq(0).keyup();
                            }
                        });
					} else {
						$('#promo_message').remove();
						$('#send-promocode').after('<div id="promo_message" style="color:red;">'+data['message']+'</div>');
					}
				}
			});


		return false;
	});

	function ReMiddle(s) {
		$(s).css('top', '50%');
		$(s).css('margin-top', '-' + Math.round($(s).height() / 2) + 'px');
	}

	$("select.ac_courier").change(function(){
		if (!$(this).is(':disabled')) {
			del_cost_min_check($(this).find('option:selected'));
		}
	});

	$("select.ac_post").change(function(){
		if (!$(this).is(':disabled')) {
			del_cost_min_check($(this).find('option:selected'));
		}
	});

	function del_cost_min_check(option) {
		var min = parseFloat(option.data('min'));
		var cost = parseFloat(option.data('cost'));
		var sum = parseFloat(del_spaces($('div#re-step-2 div.re-dialog-res-tfoot table td.re-total-price b').html()));
		if (sum < min) {
			$('div#min-sum').show();
			return false;
		} else {
			$('div#min-sum').hide();
			return true;
		}
	}

	$('#re-cart').click(function () {
		$('.ajax-save-count').eq(0).keyup(); //подсчет скидки на первом шаге корзины
		$('input.re-step-next').show();
		$('input.re-step-issue').hide();
		$('div.re-step-number').hide();
		$('div#re-step-0').show();
		ReMiddle('div.re-cart');
		$('div.re-overlay').show();
		$('div.re-cart').fadeIn();
		$('body').css('overflow', 'hidden');
		return false;
	});

	$('#re-login, #re-login-p').click(function () {
		ReMiddle('div.re-login');
		$('div.re-overlay').show();
		$('div.re-login').fadeIn();
		$('body').css('overflow', 'hidden');
		return false;
	});

	$('#re-recover-password').click(function(){
		$('div.re-login').fadeOut();
		ReMiddle('div.re-recover');
		$('div.re-overlay').show();
		$('div.re-recover').fadeIn();
		$('body').css('overflow', 'hidden');
		return false;
	});

	$('#re-register, #re-register-p').click(function () {
		ReMiddle('div.re-register');
		$('div.re-overlay').show();
		$('div.re-register').fadeIn();
		$('body').css('overflow', 'hidden');
		return false;
	});

	$('#re-cabinet').click(function () {
		ReMiddle('div.re-cabinet');
		$('div.re-overlay').show();
		$('div.re-cabinet').fadeIn();
		$('body').css('overflow', 'hidden');
		return false;
	});

	$('#re-orders').click(function () {
		ReMiddle('div.re-orders');
		$('div.re-overlay').show();
		$('div.re-orders').fadeIn();
		$('body').css('overflow', 'hidden');
		return false;
	});

	$('.re-order-products').click(function () {
		$(this).parent().parent().next().find('table').toggle();
		return false;
	});

	$('#re-callme').click(function () {
		ReMiddle('div.re-callme');
		$('div.re-overlay').show();
		$('div.re-callme').fadeIn();
		$('body').css('overflow', 'hidden');
		return false;
	});

	$('.re-callbuy-button').click(function () {
		ReMiddle('div.re-callbuy');
		$('div.re-overlay').show();
		$('div.re-callbuy').fadeIn();
		$('body').css('overflow', 'hidden');
		return false;
	});

	function ReClose() {
		$('div.re-dialog').hide();
		$('div.re-overlay').hide();
		$('body').css('overflow', 'visible');
	}

	$('span.re-icon-close').parent().click(function () {
		ReClose();
		return false;
	});

	$('.re-cancel, div.re-overlay').click(function () {
		ReClose();
		return false;
	});

	$(document).keyup(function (e) {
		if (e.which == 27) {
			ReClose();
		}
	});


	$('#re-update-password').click(function () {
		$(this).parent().hide();
		$('#re-update-password-field input').attr('required', 'required');
		$('#re-update-password-field').show();
		return false;
	});



	$('.re-step-next').click(function () {
		$("select#contact_delivery").change();

		$(".ajax-save-count").each(function () {
			//проверка количества
			$(this).removeClass('error');
			$(this).next().css('color','black');

			var max_col = $(this).next().data('count');

			if (max_col != undefined) {
				if ($(this).val() > max_col) {
					$(this).addClass('error');
					$(this).next().css('color','red');
					flag = false;
				}
			}

		});

		if (flag == false) {
			return false;
		}

		if ($('div.re-step-number:visible').attr('id') == 're-step-1') {

			var flag = true; var delivery_show = false;


			//проверка минимальной суммы заказа
			if ($("select.any_cost:visible").length !=0 && !$("select.any_cost:visible").is(':disabled')){

				if (!del_cost_min_check($("select.any_cost:visible option:selected"))) {
					flag = false;
				}
			}

			//проверка обязательных полей на втором шаге

			$('#re-step-1:visible input, #re-step-1:visible textarea').removeClass('error');
			$('#re-step-1 .need:visible').each(function(){
				if ($(this).val() == '') {
					$(this).addClass('error');
					flag = false;
				}
			});
			if (flag == false) {
				return false;
			}
			switch ($('select#contact_delivery option:selected').attr('id')) {
				case 'courier':
					$('span#re-delivery').html( $('select#contact_delivery option:selected').html() );
					$('span#check-adr-label').html( $('#re-contact-address').html() + ':' );
					$('span#re-address').html($('textarea#contact_address').val());
					break;
				case 'pickup':
					$('span#re-delivery').html( $('select#contact_delivery option:selected').html() );
					$('span#check-adr-label').html( $('#hide-pickup .re-dialog-h4').html());
					$('span#check-adr-index').html('');
					$('span#re-address').html($('div.re-dialog-p-adr').html());
					break;
				case 'bel-post':
					$('span#re-delivery').html( $('select#contact_delivery option:selected').html() );
					$('span#check-adr-label').html( $('#re-contact-address').html() + ':' );
					$('span#check-adr-index').html($('input#contact_index').val());
					$('span#re-address').html($('textarea#contact_address').val());
					break;
			}
			$('span#re-payment').html($("select.pay-select:enabled option:selected").html());
			$('input.re-step-next').hide();
			$('input.re-step-issue').show();

			var payment = $("select.pay-select:enabled option:selected").attr('value');
			var delivery = $("select#contact_delivery:enabled option:selected").attr('value');

			if ($('div#post-calc').length && delivery == 'post' ) {
				pricer.delivery['enable'] = true;
				pricer.delivery['cost'] = parseFloat($('div#post-calc span#delivery-cost').html());

				if ($('div#post-fee-block:visible').length ) {
					pricer.pay_fee['enable'] = true;
					pricer.pay_fee['type'] = 'post';
					pricer.pay_fee['cost'] = 0;
				}

			} else if($('div#post-abroad-calc').length != 0 && delivery == 'post_abroad' ){
				pricer.delivery['enable'] = true;
				pricer.delivery['cost'] = parseFloat($('div#post-abroad-calc span#delivery-cost').html());

				if($('div#post-abroad-fee-block:visible').length) {
					pricer.pay_fee['enable'] = true;
					pricer.pay_fee['type'] = 'post_abroad';
				}
			}

			if ($('.any_cost:visible option:selected').length != 0) {
				pricer.delivery['enable'] = true;
				pricer.delivery['cost'] = parseFloat($('.any_cost:visible option:selected').data('cost'));
			}

			if ((payment == 'erip_courier' || payment == 'erip_post'
				|| payment == 'erip_post_abroad' || payment == 'erip_pickup') && $('span#payfee').length)  {
				pricer.pay_fee['enable'] = true;
				pricer.pay_fee['type'] = 'erip';
			}

			//отнимаем скидку
			if ($('span#discount-marker').length != 0) {
				pricer.discount['enable'] = true;
				pricer.discount['cost'] = parseFloat(del_spaces($('span#discount-sum').text()));
			}

			pricer.render();
		}


		//перелистываем на следующий шаг
		var $number = $('div.re-step-number:visible').attr('id').substr(-1, 1);
		$('div.re-step-number').animate({
			opacity:0
		}, 'fast', 'linear', function () {
			$(this).hide().css('opacity', '1');
			$('div#re-step-' + (parseFloat($number) + 1)).fadeIn();
		});
		ReMiddle('div.re-cart');
		return false;
	});


	$('.re-step-issue').click(function () {
		document.forms["cart_form"].submit();
		$('div.re-dialog').hide();
		return false;
	});



	$('.re-step-back').click(function () {

		if ($('div.re-step-number:visible').attr('id') == 're-step-0'){ //если первая вкладка ничего не делаем
			return false;
		}

		if ($('div.re-step-number:visible').attr('id') == 're-step-2'){ //если последняя вкладка и возвращаемся назад
			$('input.re-step-next').show();
			$('input.re-step-issue').hide();
		}

		var $number = $('div.re-step-number:visible').attr('id').substr(-1, 1);
		$('div.re-step-number').animate({
			opacity:0
		}, 'fast', 'linear', function () {
			$(this).hide().css('opacity', '1');
			$('div#re-step-' + (parseFloat($number) - 1)).fadeIn();
		});
		ReMiddle('div.re-cart');
		return false;
	});



	// из верстки
	$("select#contact_delivery").change(function(){

		$('#re-step-1:visible input, #re-step-1:visible textarea').removeClass('error');

		if ($(this).find('option:selected').attr('id') == 'courier') {
			$('span#re-delivery').html( $(this).find('option:selected').html() );
			$('select.pay-courier').removeAttr('disabled').show();
			$('select.pay-pickup').attr('disabled', true).hide();
			$('select.pay-post').attr('disabled', true).hide();
			$('select.pay-post-abroad').attr('disabled', true).hide();

			$('div#hide-pickup').hide();
			$('div#hide-address-all').show();
			$('div#hide-address').show();
			$('div#post-index').hide();

			$('div#post-abroad-calc').hide();
			$('div#post-calc').hide();

			$('span#surname-red').hide();
			$('input#contact_surname').removeClass('need');

			$('span#check-adr-label').html( $('#re-contact-address').html() + ':' );
			$('span#re-address').html($('textarea#contact_address').val());

			$('span#re-payment').html($("select.pay-select:enabled option:selected").html());

			$('.any_cost').each(function(){
				$(this).hide();
				$(this).attr('disabled','disabled');
			});

			$('.ac_courier').each(function(){
				$(this).show();
				$(this).removeAttr('disabled');
			});
			$("select.ac_courier").change();

		}
		if ($(this).find('option:selected').attr('id') == 'pickup') {
			$('span#re-delivery').html( $(this).find('option:selected').html() );
			$('select.pay-courier').attr('disabled', true).hide();
			$('select.pay-pickup').removeAttr('disabled').show();
			$('select.pay-post').attr('disabled', true).hide();
			$('select.pay-post-abroad').attr('disabled', true).hide();

			$('div#hide-address-all').hide();
			$('div#hide-pickup').show();

			$('div#post-abroad-calc').hide();
			$('div#post-calc').hide();

			$('span#surname-red').hide();
			$('input#contact_surname').removeClass('need');

			$('span#check-adr-label').html( $('#hide-pickup .re-dialog-h4').html() );
			$('span#check-adr-index').html('');
			$('span#re-address').html($('div.re-dialog-p-adr').html());

			$('span#re-payment').html($("select.pay-select:enabled option:selected").html());

			$('.any_cost').each(function(){
				$(this).hide();
				$(this).attr('disabled','disabled');
			});
			$('div#min-sum').hide();
		}

		if ($(this).find('option:selected').attr('id') == 'bel-post') {
			$('span#re-delivery').html( $(this).find('option:selected').html() );
			$('select.pay-courier').attr('disabled', true).hide();
			$('select.pay-pickup').attr('disabled', true).hide();
			$('select.pay-post-abroad').attr('disabled', true).hide();
			$('select.pay-post').removeAttr('disabled').show();

			$('div#hide-pickup').hide();
			$('div#hide-address-all').show();
			$('div#hide-address').show();
			$('div#post-index').show();

			$('div#post-abroad-calc').hide();
			$('div#post-calc').show();
			if ($('div#post-calc').length != 0) {

				var delivery_cost = $('div#post-calc span#delivery-cost').html();
				$('div#re-step-2 div.re-dialog-res-tfoot table td.re-pay-del-cost').html(delivery_cost);
				$('div#re-step-2 div.re-dialog-res-tfoot table tr.delivery-cost').show();
			}
			$('span#surname-red').show();
			$('input#contact_surname').addClass('need');

			$('span#check-adr-label').html( $(this).find('option:selected').html() );
			$('span#check-adr-index').html($('input#contact_index').val());
			$('span#re-address').html($('textarea#contact_address').val());

			$('span#re-payment').html($("select.pay-select:enabled option:selected").html());

			$('.any_cost').each(function(){
				$(this).hide();
				$(this).attr('disabled','disabled');
			});

			$('.ac_post').each(function(){
				$(this).show();
				$(this).removeAttr('disabled');
			});
			$("select.ac_post").change();
			$('div#min-sum').hide();

		}

		if ($(this).find('option:selected').attr('id') == 'post-abroad') {
			$('span#re-delivery').html( $(this).find('option:selected').html() );
			$('select.pay-courier').attr('disabled', true).hide();
			$('select.pay-pickup').attr('disabled', true).hide();
			$('select.pay-post').attr('disabled', true).hide();
			$('select.pay-post-abroad').removeAttr('disabled').show();

			$('div#hide-pickup').hide();
			$('div#hide-address-all').show();
			$('div#hide-address').show();
			$('div#post-index').show();
			$('div#post-abroad-calc').show();
			$('div#post-calc').hide();

			$('span#surname-red').show();
			$('input#contact_surname').addClass('need');

			$('span#check-adr-label').html( $(this).find('option:selected').html() );
			$('span#check-adr-index').html($('input#contact_index').val());
			$('span#re-address').html($('textarea#contact_address').val());

			$('span#re-payment').html($("select.pay-select:enabled option:selected").html());

			$('.any_cost').each(function(){
				$(this).hide();
				$(this).attr('disabled','disabled');
			});
			$('div#min-sum').hide();
		}



		//коммиссия наложенного платежа
		var delivery = $(this).find('option:selected').attr('id');
		var payment = $('select.pay-select:visible option:selected').attr('value');
		var is_post_fee = $('div#post-fee-block').length;
		var is_post_abroad_fee = $('div#post-abroad-fee-block').length;

		if ( payment == 'post_post' && is_post_fee > 0){
			show_post_fee('post');
		} else if(delivery == 'post_post_abroad' && is_post_abroad_fee > 0) {
			show_post_fee('abroad');
		} else {
			hide_post_fee()
		}
	});


	function show_post_fee(payment){
		if (payment == 'post') {
			$('div#post-fee-block').show();
			var fee_percent = parseFloat($('span#post-commission').text());
			var delivery_cost = parseFloat($('div#post-calc span#delivery-cost').text());
		} else {
			$('div#post-abroad-fee-block').show();
			var fee_percent = parseFloat($('span#post-abroad-commission').text());
			var delivery_cost = parseFloat($('div#post-abroad-calc span#delivery-cost').text());
		}

		var total_products = parseFloat(del_spaces($('td.re-total-price b').eq(0).text()));
		var fee_sum = Math.round((total_products + delivery_cost)/100 * fee_percent);
		var total_with_fee =  total_products + delivery_cost + fee_sum;

		$('div#re-step-2 div.re-dialog-res-tfoot table td.re-post-fee-cost').html(toPrice(fee_sum.toString()));
		$('div#re-step-2 div.re-dialog-res-tfoot table tr.post-fee').show();

		$('div#re-step-2 div.re-dialog-res-tfoot table td.re-total-with-fee-cost').html(toPrice(total_with_fee.toString()));
	}

	function hide_post_fee(){
		$('div#post-fee-block').hide();
		$('div#re-step-2 div.re-dialog-res-tfoot table tr.post-fee').hide();
	}

	function hide_post_abroad_fee(){
		$('div#post-abroad-fee-block').hide();
		$('div#re-step-2 div.re-dialog-res-tfoot table tr.post-fee').hide();
	}

	$("select.pay-post").change(function(){
		var payment = $(this).find('option:selected').attr('value');
		var is_post_fee = $('div#post-fee-block').length;
		var is_post_abroad_fee = $('div#post-abroad-fee-block').length;


		if ( payment == 'post_post' && is_post_fee > 0){
			show_post_fee('post');
		} else {
			hide_post_fee();
		}
		if(payment == 'post_post_abroad' && is_post_abroad_fee > 0) {
			show_post_fee('abroad');
		} else {
			hide_post_abroad_fee();
		}

		$('span#re-payment').html($("select.pay-select:enabled option:selected").html());
	});

	$("select.pay-post-abroad").change(function(){
		var payment = $(this).find('option:selected').attr('value');
		var is_post_fee = $('div#post-fee-block').length;
		var is_post_abroad_fee = $('div#post-abroad-fee-block').length;

		if (payment == 'post_post' && is_post_fee > 0){
			show_post_fee('post');
		} else {
			hide_post_fee();
		}

		if(payment == 'post_post_abroad' && is_post_abroad_fee > 0) {
			show_post_fee('abroad');
		} else {
			hide_post_abroad_fee();
		}

		$('span#re-payment').html($("select.pay-select:enabled option:selected").html());
	});

	$('input#contact_index').blur(function(){
		$('span#check-adr-index').html($(this).val().trim());
		$('span#check-adr-label').html( $('#re-contact-address').html() + ':' );
	});

	$('textarea#contact_address').blur(function(){
		$('span#re-address').html($(this).val().trim());
		$('span#check-adr-label').html( $('#re-contact-address').html() + ':' );
	});

	$('input#contact_name').blur(function(){
		$('span#re-name').html($(this).val().trim());
	});

	$('input#contact_phone').blur(function() {
		$('span#re-phone').html($(this).val().trim());
	});

	$('input#contact_email').blur(function() {
		$('span#re-email').html($(this).val().trim());

	});

	$('input#contact_surname').blur(function() {
		$('span#re-surname').html($(this).val().trim());
	});

	$('textarea#contact_note').blur(function() {
		$('span#re-note').html($(this).val().trim());
	});

	$('.re-dialog input, .re-dialog textarea').focus(function() {
		$(this).removeClass('error');
	});

	function toPrice(value) {
		value = Round(value,2);
		value = value.toFixed(2);
		value = value.toString();
		return value.replace(/[^0-9\.]+/g, '').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1 ');
	}


	function Round(value, precision) {
		precision = precision || 2;
		return Math.round(value * Math.pow(10, precision)) / Math.pow(10, precision);

	}

	function del_spaces(str)
	{
		if (str !== null) {
			str = str.replace(/\s/g, '');
		} else {
			str = '';
		}

		return str;
	}

	function add_discount(price, total) {
		if (!($('div#discount').length == undefined || $('div#discount').length == 0)) {
			var discount_percent = parseFloat($('div#discount').attr('data-percent'));
			var discount_sum = price / 100 * discount_percent;
			var discount_price = total - discount_sum;

			discount_price = toPrice(discount_price.toFixed(2).toString());
			discount_sum = toPrice(discount_sum.toFixed(2).toString());

			$('span#discount-sum').html(discount_sum);

			$('div#re-step-0 td.re-total-with-discount').html('<b>'+discount_price+'</b>');
			$('div#re-step-2 td.re-discount-cost').html(discount_sum);
			$('div#re-step-2 tr.re-discount').show();
		} else {
			return false;
		}
	}

	//Пересчет цены при изменении количества товара
	$('.ajax-save-count').keyup(function(){
		var start = this.selectionStart,
			end = this.selectionEnd;
		var count;
		var total = 0;

		// если не штуки
		if ( $(this).data('unit') != 'piece' ) {
			$(this).val( $(this).val().replace(/,/, '.') );
			$(this).val( $(this).val().replace(/[^0-9\.]/, '') );
		} else {
			$(this).val( $(this).val().replace(/[^0-9]/, '') );
		}

		var price = parseFloat(del_spaces($(this).parent().parent().find('td.re-price').html()));
		if ($(this).val() === '' || $(this).val() === '0' || $(this).val() === '.' || $(this).val() === '0.') {
			count = 1;
		} else {
			count = parseFloat(del_spaces($(this).val()));
		}
		var sum = toPrice(price * count);//удаление пробелов
		$(this).parent().parent().find('td.re-sum').html(sum);
		var id = $(this).attr('id');
		$('div#re-step-2 tr#'+id+' td.re-count').html($(this).val());
		$('div#re-step-2 tr#'+id+' td.re-sum').html(sum);

		var total_skipped_price = 0;
		$('div#re-step-0 td.re-sum:not(:first)').each(function() {
			total += parseFloat(del_spaces($(this).html()));

			if ($(this).hasClass('skip')) {
				total_skipped_price += parseFloat(del_spaces($(this).html()));
			}
		});

		add_discount(total-total_skipped_price, total);
		total = toPrice(total.toString());
		$('div#re-step-0 td.re-total-price').html('<b>'+total+'</b>');
		$('div#re-step-2 td.re-total-price').html('<b>'+total+'</b>');

		this.setSelectionRange(start, end);
	});

	$('.ajax-save-count').keydown(function(){
		// если не штуки
		var start = this.selectionStart,
			end = this.selectionEnd;
		if ( $(this).data('unit') != 'piece' ) {
			$(this).val( $(this).val().replace(/,/, '.') );
			$(this).val( $(this).val().replace(/[^0-9\.]/, '') );
		} else {
			$(this).val( $(this).val().replace(/[^0-9]/, '') );
		}

		this.setSelectionRange(start, end);
	});

	$('.ajax-save-count').focus(function(){
		$(this).removeClass('error');
		$(this).next().css('color','black');
	});

	//AJAX сохранение информации о количестве товаров
	$('.ajax-save-count').blur(function() {

		//проверка количества
		$(this).removeClass('error');
		$(this).next().css('color','black');

		var max_col = $(this).next().data('count');

		if (max_col != undefined) {
			if ($(this).val() > max_col) {
				$(this).addClass('error');
				$(this).next().css('color','red');
				flag = false;
			}
		}


		if ($(this).val() === '' || $(this).val() === '0' || $(this).val() === '.' || $(this).val() === '0.') {
			$(this).val('1');
		}
		var product_id = $(this).attr('id');
		var product_count = $(this).val();
		if ($(this).attr('mod') != undefined) {
			product_mod = '/'+$(this).attr('mod');
		} else {
			product_mod = '';
		}

		if ($(this).attr('com') != undefined) {
			product_com = '/'+$(this).attr('com');
		} else {
			product_com = '';
		}
		//сохраняем количетсво товара
		$.ajax({
			url: '/cart/upd_product_count/'+product_id+'/'+product_count+product_mod+product_com,
			async: false
		});

		//получаем данные о стоимости доставки почтой  и доставке из страницы
		$.ajax({ url: '/',
			async: true,
			success: function(data) {
				var post = $(data).find('#post-calc');
				var post_abroad =  $(data).find('#post-calc-abroad');
				var delivery = $(data).find('.re-dialog-tfoot');

				$('#post-calc').html(post);
				$('#post-calc-abroad').html(post_abroad);
				$('.re-dialog-tfoot').html(delivery);
				$('.ajax-save-count').eq(0).keyup();
			}
		});
	});

	//AJAX сохранение информации о заказе
	$('.ajax-save-info-select').change(function() {

		var field = $(this).attr('name');
		var value = $(this).find('option:selected').val();
		$.ajax({
			url: '/cart/upd_order_info/'+field+'/'+value
		})
	});

	$('.ajax-save-info-input').blur(function() {
		var field = $(this).attr('id');
		var value = $(this).val();
		var send = {
			inputs: []
		};
		// просто не пытайся понять зачем сделано именно так
		send['inputs'].push({field: field, value: value});
		$.ajax({
			type: "POST",
			url: '/cart/upd_order_info_i',
			data: send
		})
	});


	$('#login_submit').click(function(){
		if ( document.forms["login_form"].checkValidity() ) {
			document.forms["login_form"].submit();
			$('div.re-dialog').hide();
		} else {
			$('form#login_form input[required=required]').each(function(){
				if ( $(this).val() == '' ) {
					$(this).addClass('error');
				}
			});
		}
		return false;
	});

	$('#recover_submit').click(function(){
		if ( document.forms["recover_form"].checkValidity() ) {
			document.forms["recover_form"].submit();
			$('div.re-dialog').hide();
		} else {
			$('form#recover_form input[required=required]').each(function(){
				if ( $(this).val() == '' ) {
					$(this).addClass('error');
				}
			});
		}
		return false;
	});

	$('#register_submit').click(function(){
		if ( document.forms["register_form"].checkValidity() ) {
			document.forms["register_form"].submit();
			$('div.re-dialog').hide();
		} else {
			$('form#register_form input[required=required], form#register_form textarea[required=required]').each(function(){
				if ( $(this).val() == '' ) {
					$(this).addClass('error');
				}
			});
		}
		return false;
	});

	$('#cabinet_submit').click(function(){
		if ( document.forms["cabinet_form"].checkValidity() ) {
			document.forms["cabinet_form"].submit();
			$('div.re-dialog').hide();
		} else {
			$('form#cabinet_form input[required=required], form#cabinet_form textarea[required=required]').each(function(){
				if ( $(this).val() == '' ) {
					$(this).addClass('error');
				}
			});
		}
		return false;
	});

	$('#callme_submit').click(function(){
		if ( document.forms["callme_form"].checkValidity() ) {
			document.forms["callme_form"].submit();
			$(this).attr('disabled', '');
			$('div.re-dialog').hide();
		} else {
			$('form#callme_form input[required=required]').each(function(){
				if ( $(this).val() == '' ) {
					$(this).addClass('error');
				}
			});
		}
		return false;
	});

	$('#callbuy_submit').click(function(){
		if ( document.forms["callbuy_form"].checkValidity() ) {
			document.forms["callbuy_form"].submit();
			$(this).attr('disabled', '');
			$('div.re-dialog').hide();
		} else {
			$('form#callbuy_form input[required=required]').each(function(){
				if ( $(this).val() == '' ) {
					$(this).addClass('error');
				}
			});
		}
		return false;
	});


});

