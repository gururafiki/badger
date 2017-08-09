/**
 * Recommerce
 * Statistics visor data grabber
 *
 * @copyright Copyright (c) 2015 Recommerce Co. (http://recommerce.by)
 */
var Re = Re || {};
Re.Visor = Re.Visor || {

	visor_data: {
		scroll: new Array(),
		click: new Array(),
		mouse: new Array()
	},

	date_object: new Date(),
	start_time: 0,

	scroll_last_time: 0,
	click_last_time: 0,
	mouse_last_time: 0,

	// мин время простоя между записью в мс
	fixed_interval: 1000,

	is_closed_and_sended: false,


	/**
	 * Пихает данные в json в сессион сторадж
	 */
	setSessionStorage: function () {
		window.sessionStorage.setItem(
			'Re.Visor',
			JSON.stringify(this.visor_data)
		);
	},


	/**
	 * Обработка скроллинга
	 */
	eventScroll: function () {

		var temp_time;

		$(window).scroll(function(){
			Re.Visor.date_object = new Date();
			temp_time = Re.Visor.date_object.getTime() - Re.Visor.start_time;
			if ( temp_time - Re.Visor.scroll_last_time < Re.Visor.fixed_interval ) return;
			Re.Visor.scroll_last_time = temp_time;
			Re.Visor.visor_data.scroll.push([
				temp_time,
				$(window).scrollTop()
			]);
			Re.Visor.setSessionStorage();
		});

	},

	/**
	 * Обработка кликов
	 */
	eventClick: function () {

		var temp_time;

		$(window).click(function(e){
			Re.Visor.date_object = new Date();
			temp_time = Re.Visor.date_object.getTime() - Re.Visor.start_time;
			if ( temp_time - Re.Visor.click_last_time < Re.Visor.fixed_interval ) return;
			Re.Visor.click_last_time = temp_time;
			Re.Visor.visor_data.click.push([
				temp_time,
				e.pageX,
				e.pageY
			]);
			Re.Visor.setSessionStorage();
		});

	},

	/**
	 * Обработка движения курсора
	 */
	eventMouse: function () {

		var temp_time;

		$(window).mousemove(function(e){
			Re.Visor.date_object = new Date();
			temp_time = Re.Visor.date_object.getTime() - Re.Visor.start_time;
			if ( temp_time - Re.Visor.mouse_last_time < Re.Visor.fixed_interval ) return;
			Re.Visor.mouse_last_time = temp_time;
			Re.Visor.visor_data.mouse.push([
				temp_time,
				e.pageX,
				e.pageY
			]);
			Re.Visor.setSessionStorage();
		});

	},

	/**
	 * Отдача данных при закрытии вкладки
	 */
	getDataAndClean: function() {

		var json = window.sessionStorage.getItem('Re.Visor');
		window.sessionStorage.setItem('Re.Visor', null);

		return json;

	},



	init: function() {

		this.start_time = this.date_object.getTime();

		var json = window.sessionStorage.getItem('Re.Visor');
		window.sessionStorage.setItem('Re.Visor', null);

		this.eventScroll();
		this.eventClick();
		this.eventMouse();

		return json;

	},

	initOnClose: function() {

		window.onbeforeunload = function() {
			if ( !Re.Visor.is_closed_and_sended ) {
				Re.Visor.is_closed_and_sended = true;
				ReSendStatistics(true);
			}
		};

		window.onunload = function() {
			if ( !Re.Visor.is_closed_and_sended ) {
				Re.Visor.is_closed_and_sended = true;
				ReSendStatistics(true);
			}
		};

	}




};



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

function toPrice(value) {
	value = value.toString();
	return value.replace(/[^0-9\.]+/g, '').replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1 ');
}

function mintorgRound($price) {
	var $int = parseInt($price / 100) * 100;
	var $round = $price - $int;
	if ($round < 50) {
		$round = 0;
	} else {
		$round = 100;
	}
	return $int + $round;
}

function del_spaces(str) {
	if (str !== null) {
		str = str.replace(/\s/g, '');
	} else {
		str = '';
	}

	return str;
}

function getScreenSizes() {
	var screen_sizes = {
		width: (typeof(screen.width) != 'undefined' ? screen.width: ''),
		height: (typeof(screen.height) != 'undefined' ? screen.height: ''),
		window_width: $(window).width(),
		window_height: $(window).height()
	};
	var obj = document.compatMode == 'CSS1Compat' ? document.documentElement : document.body;
	if ( screen_sizes.width == '' ) {
		screen_sizes.width = obj.clientWidth;
		screen_sizes.height = obj.clientHeight;
	}
	if ( screen_sizes.window_width == '' ) {
		screen_sizes.window_width = obj.clientWidth;
		screen_sizes.window_height = obj.clientHeight;
	}
	return screen_sizes;
}