<?php
    //Скачать библиотеку - http://phpexcel.codeplex.com/
    //Нашел русскую документацию - http://www.cyberforum.ru/php-beginners/thread1074684.html
    //Подключаем скачаную библиотеку
    include("Classes/PHPExcel.php");
    require "libs/phpQuery.php";
    require "db.php";
    header('content-type: text/html;charset=utf-8');

echo get_size('10.5','43','Мужчины',125,'Обувь','reebok');
function get_size($size,$size_ru,$gender_name,$type_id,$type_name,$brand){

        if($type_id==125){//Обувь
            if($brand=='adidas'){
                $first='RU_A:'.$size_ru;
                $second='UK_A:'.$size;
                if($gender_name=='Мальчики' || $gender_name=='Девочки' || $gender_name=='Дети'){
                    $gender_name=='Дети';
                    $first='EUR_A:'.$size;//в некоторых случаях size=UK size_ru=RU
                    $second='RU_A:'.$size_ru;//RU нету в таблице
                }
            }
            elseif($brand=='reebok'){
                $first.='RU_R:'.$size_ru;
                $second='US_R:'.$size;
                if($gender_name=='Мальчики' || $gender_name=='Девочки' || $gender_name=='Дети'){
                    $gender_name=='Дети';
                }
            }

            $parent_size_id=R::findOne('categories','keyword_1 = ? AND parent_id = ? AND describtion = ?',array($gender_name,0,'size_shoes'))->id;

            for ($i=1;$i<=10;$i++) {
                $first_where='keyword_'.$i.' = ? AND parent_id = ?';
                $first_find=R::findOne('categories',$first_where,array($first,$parent_size_id));
                if(isset($first_find)){
                    for ($j=1;$j<=10;$j++) {
                        $where='id = ? AND keyword_'.$j.' = ? AND parent_id = ?';
                        $find=R::findOne('categories',$where,array($first_find->id,$second,$parent_size_id));
                        if(isset($find)){
                            return $find->id;
                        }
                    }
                    return $first_find->id;
                }
            }
            for ($i=1;$i<=10;$i++) {
                $first_where='keyword_'.$i.' = ? AND parent_id = ?';
                $first_find=R::findOne('categories',$first_where,array($second,$parent_size_id));
                if(isset($first_find)){
                    return $first_find->id;
                }
            }
        }//Конец обувь
        elseif($type_id<123 && $type_id>64){//Одежда
            if($gender_name=='Мальчики' || $gender_name=='Девочки'){
                $gender_name=='Подростки';
            }

            if($gender_name=='Подростки' || $gender_name=='Дети' || $gender_name=='Малыши'){
                $first='Height:'.$size;
                $second='Height:'.$size_ru;
            }
            else{
                $find_val = '|';
                $pos = strpos($size_ru, $find_val);
                if($pos!= false){//if (size_ru=='X|Y')
                    $first='RU_1_A:'.substr( $size_ru,0,-3);
                    $second='RU_2_A:'.substr( $size_ru,-2);
                }
                elseif($size==$size_ru){
                    $first='RU_1_A:'.$size;
                    $second='RU_2_A:'.$size;
                }
                elseif($size_ru==' ' && $brand=='reebok'){
                    $first='EUR_R:'.$size;
                    $second='EUR_R:'.$size;
                }
                elseif($brand=='adidas'){
                    $first='RU_1_A:'.$size_ru;
                    $second='RU_2_A:'.$size_ru;
                }
                elseif($brand=='reebok'){
                    $first='EUR_R:'.$size;
                    $second='EUR_R:'.$size;
                }
            }

            $parent_size_id=R::findOne('categories','keyword_1 = ? AND parent_id = ? AND describtion = ?',array($gender_name,0,'size_cloth'))->id;


            for ($i=1;$i<=10;$i++) {
                $first_where='keyword_'.$i.' = ? AND parent_id = ?';
                $first_find=R::findOne('categories',$first_where,array($first,$parent_size_id));
                if(isset($first_find)){
                    for ($j=1;$j<=10;$j++) {
                        $where='id = ? AND keyword_'.$j.' = ? AND parent_id = ?';
                        $find=R::findOne('categories',$where,array($first_find->id,$second,$parent_size_id));
                        if(isset($find)){
                            return $find->id;
                        }
                    }
                    return $first_find->id;
                }
            }
            for ($i=1;$i<=10;$i++) {
                $first_where='keyword_'.$i.' = ? AND parent_id = ?';
                $first_find=R::findOne('categories',$first_where,array($second,$parent_size_id));
                if(isset($first_find)){
                    return $first_find->id;
                }
            }
        }
        else{
            return 'Undefined';
        }

        for ($i=1;$i<=10;$i++) {
            $where='(keyword_'.$i.' = ? OR keyword_'.$i.' = ?) AND parent_id = ?';
            $find=R::findOne('categories',$where,array($size_ru,$size,$parent_size_id));
            if(isset($find)){
                return $find->id;
            }
        }
    }

?>