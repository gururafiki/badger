<?php
    //Скачать библиотеку - http://phpexcel.codeplex.com/
    //Нашел русскую документацию - http://www.cyberforum.ru/php-beginners/thread1074684.html
    //Подключаем скачаную библиотеку
    require "db.php";
    header('content-type: text/html;charset=utf-8');

   	$client=R::dispense('clients');
	$client->name = 'admin';
	$client->email='admin@gmail.com';
	$client->password='admin';
	$client->adress='Street.Krusheva 4';
	$client->postcode='02068';
	$client->city='Kharkiv';
	$client->phone='+38(063)921-20-20';
	R::store($client);
?>