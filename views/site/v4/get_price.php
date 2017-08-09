<?php
    //Скачать библиотеку - http://phpexcel.codeplex.com/
    //Нашел русскую документацию - http://www.cyberforum.ru/php-beginners/thread1074684.html
    //Подключаем скачаную библиотеку
    include("Classes/PHPExcel.php");
    require "libs/phpQuery.php";
    require "db.php";
    header('content-type: text/html;charset=utf-8');

echo get_price('390.00',1.07);
function get_price($price_buy,$coef){
	$pos=strpos($price_buy,',');
	if($pos === false){
		$price_sell=floatval($price_buy);
		$price= $price_sell*$coef;
	}
	else{
		$position=(-1)*(strlen($price_buy)-$pos);
		$price_sell=substr($price_buy,0,$position);
		$price_sell.=substr($price_buy,$pos+1);
		$price= $price_sell*$coef;
	}
	return $price;
}
?>