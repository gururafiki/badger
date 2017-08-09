<?php
    //Скачать библиотеку - http://phpexcel.codeplex.com/
    //Нашел русскую документацию - http://www.cyberforum.ru/php-beginners/thread1074684.html
    //Подключаем скачаную библиотеку
    include("Classes/PHPExcel.php");
    require "libs/phpQuery.php";
    require "db.php";
    header('content-type: text/html;charset=utf-8');

    function get_http_response_code($url) {
        $headers = get_headers($url);
        return substr($headers[0], 9, 3);
    }

    function photo_check($i,$article){
        $photo_url='http://demandware.edgesuite.net/sits_pod14-adidas/dw/image/v2/aagl_prd/on/demandware.static/-/Sites-adidas-products/default/dw5d486956/zoom/'.$article.'_0'.$i.'_standard.jpg';
        $response_code = get_http_response_code($photo_url);
        if($response_code==200){
            return $photo_url;
        }
        else{
            return 'No photo yet';
        }
    }
    //изменено 22 05
    function get_type_excel($name){
        $arr=explode(" ", $name);
            $i=0;
            foreach ($arr as $key) {
                for ($i=1;$i<=10;$i++) {
                    $where='keyword_'.$i.' = ?';
                    $find=R::findOne('categories',$where,array($key));
                    if(isset($find)){
                        if($find->describtion=='sub_type')
                            return $find;
                        elseif($find->describtion=='type'){
                            $id=$find->id+1;
                            $find=R::findOne('categories','id = ?',array($id));
                        }
                    }
                }
            }
            $find=R::findOne('categories','name = ? AND describtion = ?',array('Прочее','sub_type'));
            return $find;
    }
    function get_gender($name){
        $arr=explode(" ", $name);
            $i=0;
            foreach ($arr as $key) {
                for ($i=1;$i<=10;$i++) {
                    $where='keyword_'.$i.' = ? AND describtion = ?';
                    $find=R::findOne('categories',$where,array($key,'gender'));
                    if(isset($find)){
                        return $find;
                    }
                }
            }
            $find=R::findOne('categories','name = ? AND describtion = ?',array('Прочее','gender'));
            return $find;
    }

    function get_collection($name){
        $arr=explode(" ", $name);
            $i=0;
            foreach ($arr as $key) {
                for ($i=1;$i<=10;$i++) {
                    $where='keyword_'.$i.' = ? AND describtion = ?';
                    $find=R::findOne('categories',$where,array($key,'brand'));
                    if(isset($find)){
                        return $find;
                    }
                }
            }
            $find=R::findOne('categories','name = ? AND describtion = ?',array('Другие коллекции','brand'));
            return $find;
    }

    function get_sport($name){
        $arr=explode(" ", $name);
            $i=0;
            foreach ($arr as $key) {
                for ($i=1;$i<=10;$i++) {
                    $where='keyword_'.$i.' = ? AND describtion = ?';
                    $find=R::findOne('categories',$where,array($key,'sport'));
                    if(isset($find)){
                        return $find;
                    }
                }
            }
            $find=R::findOne('categories','name = ? AND describtion = ?',array('Другой вид спорта','sport'));
            return $find;
    }

        function data_parser($article,$flag){
        if($flag==0)
        {
            $url = 'http://www.adidas.ru/search?q='.$article;
            $file = file_get_contents($url);//скачиваем страницу по url

            $html_code = htmlspecialchars($file);//для вывода html
            $pos = strpos($html_code, 'Мы не смогли ничего найти по Вашему запросу: ');
            if ($pos != false) {
                $url = 'http://www.reebok.ru/search?q='.$article;
                $file = file_get_contents($url);
                $html_code = htmlspecialchars($file);
                $pos = strpos($html_code, 'Написать комментарий');
                if ($pos === false){
                    $res=data_parser_co_uk($article,0);
                    if($res===false){
                        $res=data_parser_draft($article);
                        if($res===false){
                            $res=data_parser_clubsale($article);
                            if($res===false){
                                $product=R::dispense('unique');
                                $product->article=$article;
                                $product->code='404';
                                $gender=get_gender(trim('Прочее'));
                                $product->gender_name=$gender->name;
                                $product->gender_id=$gender->id;
                                $product->sport_name='Другой вид спорта';
                                $sport=R::findOne('categories','describtion = ? AND name = ?',array('sport','Другой вид спорта'));
                                $product->sport_id=$sport->id;
                                $product->col_name='Другие коллекции';
                                $col=R::findOne('categories','describtion = ? AND name = ?',array('brand','Другие коллекции'));
                                $product->col_id=$col->id;
                                $product->photo_1=photo_check(1,$article);
                                R::store($product);
                                return false;
                            }
                        }
                    }
                    return true;
                }
                else{
                    $brand = 'reebok';
                    $html = phpQuery::newDocument($file);
                }
            }
            else{
                $url1 = 'http://www.reebok.ru/search?q='.$article;
                $file1 = file_get_contents($url1);
                $html_code1 = htmlspecialchars($file1);
                $pos1 = strpos($html_code1, 'Написать комментарий');
                if($pos1 != false){
                    $flag=1;
                    data_parser($article,$flag);
                }
                $brand = 'adidas';
                $html = phpQuery::newDocument($file);
            }
        }
        elseif($flag==1){
            $url = 'http://www.reebok.ru/search?q='.$article;
            $file = file_get_contents($url);
            $html = phpQuery::newDocument($file);
            $brand='reebok';
        }
                $photoCount=0;
                foreach ($html->find('segment:eq(0)')->find('div[id*="main-section"]')->find('div[id*="productInfo"]')->find('div[class*="col-8"]')->find('div[class*="image-carousel-zoom-container"]')->find('div[class*="image-carousel-container"]')->find('div[id*="image-carousel"]')->find('div[class*="pdp-image-carousel track stack"]')->find('ul[class*="pdp-image-carousel-list"]')->find('li') as $el){
                    $photo = pq($el)->find('img')->attr('src');
                    $photo = substr( $photo,0,-11).'2000&sfrm=jpg';
                    $photoCount++;
                    $photoArray[$photoCount] = $photo;
                }
                
                $model=pq($html)->find('segment:eq(0)')->find('div[id*="main-section"]')->find('div[id*="productInfo"]')->find('div[class*="col-8"]')->find('div[class*="image-carousel-zoom-container"]')->find('div[id*="main-image"]')->find('div:eq(1)')->text();
                
                
                $short_describtion=pq($html)->find('span[class*="pdp-category-in"]')->text();//Gender Col/Sport
                $gender=get_gender(trim($short_describtion));
                $gender_name=$gender->name;
                $gender_id=$gender->id;
                $collection=substr($short_describtion,strpos($short_describtion,' ')+1);
                
                $name = pq($html)->find('segment:eq(0)')->find('div[id*="main-section"]')->find('div[id*="productInfo"]')->find('div[class*="col-4"]')->find('div[id*="buy-block"]')->find('div[class*="buy-block-header"]')->find('h1')->text();
                $colour = pq($html)->find('segment:eq(0)')->find('div[id*="main-section"]')->find('div[id*="productInfo"]')->find('div[class*="col-4"]')->find('div[id*="buy-block"]')->find('div[class*="buy-block-header"]')->find('div[class*="rbk-rounded-block "]')->find('div:eq(0)')->find('span[class*="product-color-clear"]')->text();
                $sub_type=get_type_excel($name);
                $sub_type_name=$sub_type->name;
                $sub_type_id= $sub_type->id;
                $type_id=$sub_type->parent_id;
                $sport_name=R::findOne('categories','describtion = ? AND name =?',array('sport',trim($collection)))->name;
                if(!isset($sport_name)){
                    $sport_name='Другой вид спорта';
                }
                $sport_id=R::findOne('categories','describtion = ? AND name =?',array('sport',$sport_name))->id;

                $collection_name=R::findOne('categories','describtion = ? AND name =?',array('brand',trim($collection)))->name;
                if(!isset($collection_name)){
                    $collection_name='Другие коллекции';
                }
                $collection_id=R::findOne('categories','describtion = ? AND name =?',array('brand',$collection_name))->id;

                $sameCount=0;
                foreach ($html->find('div[id*="colorVariationsCarousel"]')->find('div[class*="color-variation-row"]')->find('div') as $key) {
                        $sameCount++;
                        $sameArray[$sameCount] = pq($key)->attr('data-articleno');
                }
                
                $type_from_site = pq($html)->find('segment:eq(1)')->find('div:eq(0)')->find('h4')->text();
                $describtion = pq($html)->find('segment:eq(1)')->find('div[itemprop*="description"]')->text();

                $advantagesCount=0;
                foreach ($html->find('segment:eq(1)')->find('div:eq(0)')->find('ul')->find('li') as $key) {
                        $advantagesCount++;
                        $advantagesArray[$advantagesCount] = pq($key)->text();
                }  

                phpQuery::unloadDocuments();//очистить оперативку от последствий парсинга
                $product=R::dispense('unique');
                $product->article = $article;
                $product->sport_name=$sport_name;
                $product->sport_id=$sport_id;
                $product->col_name=$collection_name;
                $product->col_id=$collection_id;
                $product->gender_name=$gender_name;
                $product->gender_id=$gender_id;
                $product->url=$url;
                if($name==''){
                    $product->code='500';
                    $product->photo_1=photo_check(1,$article);
                    R::store($product);
                }
                else{
                    $product->code='200';
                    $product->brand = $brand;
                    $product->model=$model;
                    $product->type_id=$type_id;
                    $product->type_name = R::findOne('categories','id = ?',array($type_id))->name;
                    $product->sub_type_name = $sub_type_name;
                    $product->sub_type_id = $sub_type_id;
                    $product->type_from_site= $type_from_site;
                    $product->name=$name;
                    $product->colour=$colour;
                    $product->describtion=$describtion;
                    $product->short_describtion=$short_describtion;
                    R::store($product);
                    for($i=1;$i<=$photoCount;$i++){
                        $query="UPDATE `unique` SET `unique`.`photo_".$i."`='".$photoArray[$i]."' WHERE `unique`.`article` = '".$article."' AND `unique`.`name` = '".$name."'";
                        R::exec($query);
                    }
                    for($i=1;$i<=$sameCount;$i++){
                        $query="UPDATE `unique` SET `unique`.`other_colour_".$i."`='".$sameArray[$i]."' WHERE `unique`.`article` = '".$article."' AND `unique`.`name` = '".$name."'";;
                        R::exec($query);
                    }
                    for($i=1;$i<=$advantagesCount;$i++){
                        $query="UPDATE `unique` SET `unique`.`advantages_".$i."`='".$advantagesArray[$i]."' WHERE `unique`.`article` = '".$article."' AND `unique`.`name` = '".$name."'";;
                        R::exec($query);
                    }
                }
                return true;
    }
    function data_parser_co_uk($article,$flag){
        if($flag==0)
        {
            $url = 'http://www.adidas.co.uk/search?q='.$article;
            $file = file_get_contents($url);//скачиваем страницу по url

            $html_code = htmlspecialchars($file);//для вывода html
            $pos = strpos($html_code, 'We are sorry but no results were found for: ');
            if ($pos != false) {
                $url = 'http://www.reebok.co.uk/search?q='.$article;
                $file = file_get_contents($url);
                $html_code = htmlspecialchars($file);
                $pos = strpos($html_code, 'RATINGS & REVIEWS');
                if ($pos === false){
                    return false;
                }
                else{
                    $brand = 'reebok';
                    $html = phpQuery::newDocument($file);
                }
            }
            else{
                $url1 = 'http://www.reebok.co.uk/search?q='.$article;
                $file1 = file_get_contents($url1);
                $html_code1 = htmlspecialchars($file1);
                $pos1 = strpos($html_code1, 'RATINGS & REVIEWS');
                if($pos1 != false){
                    $flag=1;
                    data_parser_co_uk($article,$flag);
                }
                $brand = 'adidas';
                $html = phpQuery::newDocument($file);
            }
        }
        elseif($flag==1){
            $url = 'http://www.reebok.co.uk/search?q='.$article;
            $file = file_get_contents($url);
            $html = phpQuery::newDocument($file);
            $brand='reebok';
        }
                $photoCount=0;
                foreach ($html->find('segment:eq(0)')->find('div[id*="main-section"]')->find('div[id*="productInfo"]')->find('div[class*="col-8"]')->find('div[class*="image-carousel-zoom-container"]')->find('div[class*="image-carousel-container"]')->find('div[id*="image-carousel"]')->find('div[class*="pdp-image-carousel track stack"]')->find('ul[class*="pdp-image-carousel-list"]')->find('li') as $el){
                    $photo = pq($el)->find('img')->attr('src');
                    $photo = substr( $photo,0,-11).'2000&sfrm=jpg';
                    $photoCount++;
                    $photoArray[$photoCount] = $photo;
                }
                
                $model=pq($html)->find('segment:eq(0)')->find('div[id*="main-section"]')->find('div[id*="productInfo"]')->find('div[class*="col-8"]')->find('div[class*="image-carousel-zoom-container"]')->find('div[id*="main-image"]')->find('div:eq(1)')->text();
                
                
                $short_describtion=pq($html)->find('span[class*="pdp-category-in"]')->text();//Gender Col/Sport
                $gender=get_gender(trim($short_describtion));
                $gender_name=$gender->name;
                $gender_id=$gender->id;
                $collection=substr($short_describtion,strpos($short_describtion,' ')+1);
                
                $name = pq($html)->find('segment:eq(0)')->find('div[id*="main-section"]')->find('div[id*="productInfo"]')->find('div[class*="col-4"]')->find('div[id*="buy-block"]')->find('div[class*="buy-block-header"]')->find('h1')->text();
                $colour = pq($html)->find('segment:eq(0)')->find('div[id*="main-section"]')->find('div[id*="productInfo"]')->find('div[class*="col-4"]')->find('div[id*="buy-block"]')->find('div[class*="buy-block-header"]')->find('div[class*="rbk-rounded-block "]')->find('div:eq(0)')->find('span[class*="product-color-clear"]')->text();
                $sub_type=get_type_excel($name);
                $sub_type_name=$sub_type->name;
                $sub_type_id= $sub_type->id;
                $type_id=$sub_type->parent_id;
                $sport_name=R::findOne('categories','describtion = ? AND name =?',array('sport',trim($collection)))->name;
                if(!isset($sport_name)){
                    $sport_name='Другой вид спорта';
                }
                $sport_id=R::findOne('categories','describtion = ? AND name =?',array('sport',$sport_name))->id;

                $collection_name=R::findOne('categories','describtion = ? AND name =?',array('brand',trim($collection)))->name;
                if(!isset($collection_name)){
                    $collection_name='Другие коллекции';
                }
                $collection_id=R::findOne('categories','describtion = ? AND name =?',array('brand',$collection_name))->id;

                $sameCount=0;
                foreach ($html->find('div[id*="colorVariationsCarousel"]')->find('div[class*="color-variation-row"]')->find('div') as $key) {
                        $sameCount++;
                        $sameArray[$sameCount] = pq($key)->attr('data-articleno');
                }
                
                $type_from_site = pq($html)->find('segment:eq(1)')->find('div:eq(0)')->find('h4')->text();
                $describtion = pq($html)->find('segment:eq(1)')->find('div[itemprop*="description"]')->text();

                $advantagesCount=0;
                foreach ($html->find('segment:eq(1)')->find('div:eq(0)')->find('ul')->find('li') as $key) {
                        $advantagesCount++;
                        $advantagesArray[$advantagesCount] = pq($key)->text();
                }  

                phpQuery::unloadDocuments();//очистить оперативку от последствий парсинга
                $product=R::dispense('unique');//findOne('unique','article = ?',array($article));
                $product->article = $article;
                $product->sport_name=$sport_name;
                $product->sport_id=$sport_id;
                $product->col_name=$collection_name;

                $product->col_id=$collection_id;
                $product->gender_name=$gender_name;
                $product->gender_id=$gender_id;
                $product->url=$url;
                if($name==''){
                    $product->code='500';
                    $product->photo_1=photo_check(1,$article);
                    R::store($product);
                }
                else{
                    $product->code='200';
                    $product->brand = $brand;
                    $product->model=$model;
                    $product->type_id=$type_id;
                    $product->type_name = R::findOne('categories','id = ?',array($type_id))->name;
                    $product->sub_type_name = $sub_type_name;
                    $product->sub_type_id = $sub_type_id;
                    $product->type_from_site= $type_from_site;
                    $product->name=$name;
                    $product->colour=$colour;
                    $product->describtion=$describtion;
                    $product->short_describtion=$short_describtion;
                    R::store($product);
                    for($i=1;$i<=$photoCount;$i++){
                        $query="UPDATE `unique` SET `unique`.`photo_".$i."`='".$photoArray[$i]."' WHERE `unique`.`article` = '".$article."' AND `unique`.`name` = '".$name."'";
                        R::exec($query);
                    }
                    for($i=1;$i<=$sameCount;$i++){
                        $query="UPDATE `unique` SET `unique`.`other_colour_".$i."`='".$sameArray[$i]."' WHERE `unique`.`article` = '".$article."' AND `unique`.`name` = '".$name."'";;
                        R::exec($query);
                    }
                    for($i=1;$i<=$advantagesCount;$i++){
                        $query="UPDATE `unique` SET `unique`.`advantages_".$i."`='".$advantagesArray[$i]."' WHERE `unique`.`article` = '".$article."' AND `unique`.`name` = '".$name."'";;
                        R::exec($query);
                    }
                }
                return true;
    }
     function data_parser_clubsale($article){
        $url = 'https://clubsale.com.ua/index.php?lan=rus&page=catalog&param=staff&znak=search&q='.$article.'&x=0&y=0';
        $file = file_get_contents($url);//скачиваем страницу по url

        $html_code = htmlspecialchars($file);//для вывода html

        $pos = strpos($html_code, 'Сейчас, этот товар отсутствует. Подберите себе, пожалуйста, другую модель.');
        if ($pos != false) 
            return false;
        
        $html = phpQuery::newDocument($file);
        $ref=pq($html)->find('div[class*="content"]')->find('div[class*="inf"]')->find('div[class*="tovar"]')->find('div[class*="konv"]')->find('div[class*="diks"]')->find('a[target*="_blank"]')->attr('href');

        $url='https://clubsale.com.ua'.$ref;   
        $file = file_get_contents($url);//скачиваем страницу по url
        $html = phpQuery::newDocument($file);
        $gender=pq($html)->find('div[class*="content"]')->find('div[class*="inf"]')->find('div[class*="path"]')->find('div[class*="breadcrumb"]')->find('span:eq(1)')->find('a')->text();

        $type=pq($html)->find('div[class*="content"]')->find('div[class*="inf"]')->find('div[class*="path"]')->find('div[class*="breadcrumb"]')->find('span:eq(2)')->find('a')->text();

        $brand=pq($html)->find('div[class*="content"]')->find('div[class*="inf"]')->find('div[class*="path"]')->find('div[class*="breadcrumb"]')->find('span:eq(3)')->find('a')->text();

        $collection=pq($html)->find('div[class*="content"]')->find('div[class*="inf"]')->find('div[class*="path"]')->find('div[class*="breadcrumb"]')->find('span:eq(4)')->find('a')->text();

        $gender=get_gender($gender);
        $gender_id=$gender->id;
        $gender_name=$gender->name;
        $sub_type=get_type_excel($type);
        $sub_type_id=$sub_type->id;
        $sub_type_name=$sub_type->name;
        $collection=get_collection($collection);
        $collection_id=$collection->id;
        $collection_name=$collection->name;
        //нету спорта

        $type=R::findOne('categories','id = ?',array($sub_type->parent_id));
        $type_name=$type->name;
        $type_id=$type->id;

        $product=R::dispense('unique');//findOne('unique','article = ?',array($article));
        $product->sport_name=$sport_name;
        $product->sport_id=$sport_id;
        $product->col_name=$collection_name;
        $product->col_id=$collection_id;
        $product->type_id=$type_id;
        $product->type_name=$type_name;
        $product->sub_type_id=$sub_type_id;
        $product->sub_type_name=$sub_type_name;
        $product->gender_name=$gender_name;
        $product->gender_id=$gender_id;
        $product->brand=$brand;
        $product->code='200';
        $product->url=$url;
        R::store($product);
        phpQuery::unloadDocuments();//очистить оперативку от последствий парсинга
        return true;
    }
    function data_parser_draft($article){
        $url = 'https://draft.in.ua/search/?%5B%5D='.$article;
        $file = file_get_contents($url);//скачиваем страницу по url

        $html_code = htmlspecialchars($file);//для вывода html

        $pos = strpos($html_code, 'По данному запросу товаров не найдено.');
        if ($pos != false) 
            return false;
        
        $html = phpQuery::newDocument($file);
        $ref=pq($html)->find('div[id*="content"]')->find('div[id*="contents"]')->find('div[id*="content_text"]')->find('div[class*="products-list"]')->find('div:eq(0)')->find('div:eq(0)')->find('a')->attr('href');

        $url='https://draft.in.ua'.$ref;   
        
        $file = file_get_contents($url);//скачиваем страницу по url
        $html = phpQuery::newDocument($file);
        $gender_and_type=pq($html)->find('div[id*="content"]')->find('ul[class*="way"]')->find('li:eq(4)')->find('a:eq(0)')->find('span:eq(0)')->text();


        $sub_type_pars=pq($html)->find('div[id*="content"]')->find('ul[class*="way"]')->find('li:eq(6)')->find('a:eq(0)')->find('span:eq(0)')->text();


        $brand_pars=pq($html)->find('div[id*="content"]')->find('ul[class*="way"]')->find('li:eq(8)')->find('a:eq(0)')->find('span:eq(0)')->text();


        $name=pq($html)->find('div[id*="content"]')->find('div[id*="contents"]')->find('div[id*="content_text"]')->find('h1:eq(0)')->text();        


        $photo=pq($html)->find('img[class*="zoomImg"]')->attr('src');

        $i=0;

        foreach ($html->find('a[rel*="prettyPhoto[product]"]') as $el) {
            $i++;
            $photo[$i]=pq($el)->attr('href');

        }

        $gender=get_gender($gender_and_type);
        $gender_id=$gender->id;
        $gender_name=$gender->name;

        $sub_type=get_type_excel($sub_type_pars);
        $sub_type_id=$sub_type->id;
        $sub_type_name=$sub_type->name;

        $collection=get_collection($name);
        $collection_id=$collection->id;
        $collection_name=$collection->name;

        $sport=get_sport($sub_type_pars);
        $sport_name=$sport->name;
        $sport_id=$sport->id;

        $type=R::findOne('categories','id = ?',array($sub_type->parent_id));
        $type_name=$type->name;
        $type_id=$type->id;
        $pos1 = strpos($name,'Adidas');
        if ($pos1 != false){ 
            $brand = 'adidas';          
        }
        $pos2 = strpos($name, 'Reebok');
        if ($pos2 != false){
            $brand = 'reebok';
        }
        $product=R::dispense('unique');//findOne('unique','article = ?',array($article));
        $product->article=$article;
        $product->code='200';
        $product->sport_name=$sport_name;
        $product->sport_id=$sport_id;
        $product->col_name=$collection_name;
        $product->col_id=$collection_id;
        $product->type_id=$type_id;
        $product->type_name=$type_name;
        $product->sub_type_id=$sub_type_id;
        $product->sub_type_name=$sub_type_name;
        $product->gender_name=$gender_name;
        $product->gender_id=$gender_id;
        $product->brand=$brand;
        $product->url=$url;
        R::store($product);
        for($i=1;$i<=$photoCount;$i++){
            $query="UPDATE `unique` SET `unique`.`photo_".$i."`='".$photoArray[$i]."' WHERE `unique`.`article` = '".$article."' AND `unique`.`name` = '".$name."'";
            R::exec($query);
        }
        phpQuery::unloadDocuments();//очистить оперативку от последствий парсинга
        return true;
    }


    function excel_to_db($start,$last,$excel_name){
        //------------------------------------
        //2 Часть: чтение файла
        //Файл лежит в директории веб-сервера!
        $objPHPExcel = PHPExcel_IOFactory::load($excel_name);
        //R::nuke();
        //createTable();
        foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
            //Имя таблицы
            $Title              = $worksheet->getTitle();
            //Последняя используемая строка
            $lastRow         = $worksheet->getHighestRow();
            //Последний используемый столбец
            $lastColumn      = $worksheet->getHighestColumn();
            //Последний используемый индекс столбца
            $lastColumnIndex = PHPExcel_Cell::columnIndexFromString($lastColumn);
            if($start>$lastRow ){
                return 'false';
                exit();
            }
            elseif($last>$lastRow){
                $last=$lastRow;
            }
            for ($row = $start/*10*/; $row <= $last/*$lastRow*/; ++$row) {
                if($worksheet->getCellByColumnAndRow(1, $row)->getValue()!='' ) {
                    $article = trim($worksheet->getCellByColumnAndRow(1, $row)->getValue());
                    $size=$worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $size_ru=$worksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $name_excel=$worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $count= $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    $price_buy= $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $price_sell=get_price($price_buy,1.07);
                    $product=R::findOne('base','article = ?',array($article));
                    if(isset($product)){
                        for($i=1;$i<=10;$i++){
                            $where='size_id_'.$i.' = ? AND article = ?';
                            $product=R::findOne('base',$where,array('empty',$article));
                            if(isset($product)){
                                $size_id=get_size($size,$size_ru,$product->gender_name,$product->type_id,$product->type_name,$product->brand);
                                $query="UPDATE `base` SET `size_id_".$i."`='".$size_id."' , `size_name_".$i."` = 'Size:".$size." Size_ru:".$size_ru."' WHERE `base`.`article` = '".$article."'";
                                R::exec($query);
                                break;
                            }
                        }
                        continue;
                    }

                    $parent_product=R::findOne('unique','article = ?',array($article));
                    if(!isset($parent_product)){
                        data_parser($article,0);
                        $parent_product=R::findOne('unique','article = ?',array($article));
                    }

                    if($parent_product->code=='404' || $parent_product->code=='500'){
                        $sub_type=get_type_excel($name_excel);
                        $sub_type_id=$sub_type->id;
                        $sub_type_name=$sub_type->name;
                        $type_id=$sub_type->parent_id;
                        $parent_product->type_id=$type_id;
                        $parent_product->sub_type_name=$sub_type_name;
                        $parent_product->sub_type_id=$sub_type_id;
                        $parent_product->name=$name_excel;
                        if($parent_product->code=='404')
                            $parent_product->code='100';
                    }
                    elseif($parent_product->code=='200'){
                        $parent_product->name_excel=$name_excel; 
                        $sub_type_id=$parent_product->sub_type_id;
                        $sub_type_name=$parent_product->sub_type_name;
                        $type_id=$parent_product->type_id;
                        $type_name=$parent_product->type_name;
                    }


                    $col_id=$parent_product->col_id;
                    $gender_id=$parent_product->gender_id;
                    $sport_id=$parent_product->sport_id;
                    $col_name=$parent_product->col_name;
                    $gender_name=$parent_product->gender_name;
                    $sport_name=$parent_product->sport_name;

                    $product=R::dispense('base');
                    $product->article = $article;
                    $product->col_id = $col_id;
                    $product->gender_id = $gender_id;
                    $product->sport_id = $sport_id;
                    $product->type_id=$type_id;
                    $product->sub_type_id=$sub_type_id;
                    $product->new = '';
                    $product->sale = '';
                    $product->popular = '';
                    $product->col_name = $col_name;
                    $product->gender_name = $gender_name;
                    $product->sport_name = $sport_name;
                    $product->type_name=$type_name;
                    $product->sub_type_name=$sub_type_name;
                    $product->size=$size;
                    $product->size_ru=$size_ru;
                    $product->name = $parent_product->name;
                    $product->model = $parent_product->model;
                    $product->brand= $parent_product->brand;
                    $product->colour=$parent_product->colour;
                    $product->describtion=$parent_product->describtion;
                    $product->type_from_site = $parent_product->type_from_site;
                    $product->name_excel = $name_excel;
                    $product->price_buy = $price_buy;
                    $product->price_sell= $price_sell;
                    $product->count=$count;
                    $product->photo_1=$parent_product->photo_1;
                    $product->photo_2=$parent_product->photo_2;
                    $product->photo_3=$parent_product->photo_3;
                    $product->photo_4=$parent_product->photo_4;
                    $product->photo_5=$parent_product->photo_5;
                    $product->photo_6=$parent_product->photo_6;
                    $product->photo_7=$parent_product->photo_7;
                    $product->photo_8=$parent_product->photo_8;
                    $product->photo_9=$parent_product->photo_9;
                    $product->phoro_10=$parent_product->phoro_10;
                    $product->other_colour_1=$parent_product->other_colour_1;
                    $product->other_colour_2=$parent_product->other_colour_2;
                    $product->other_colour_3=$parent_product->other_colour_3;
                    $product->other_colour_4=$parent_product->other_colour_4;
                    $product->other_colour_5=$parent_product->other_colour_5;
                    $product->other_colour_6=$parent_product->other_colour_6;
                    $product->other_colour_7=$parent_product->other_colour_7;
                    $product->other_colour_8=$parent_product->other_colour_8;
                    $product->other_colour_9=$parent_product->other_colour_9;
                    $product->other_colour_10=$parent_product->other_colour_10;
                    $product->advantages_1=$parent_product->advantages_1;
                    $product->advantages_2=$parent_product->advantages_2;
                    $product->advantages_3=$parent_product->advantages_3;
                    $product->advantages_4=$parent_product->advantages_4;
                    $product->advantages_5=$parent_product->advantages_5;
                    $product->advantages_6=$parent_product->advantages_6;
                    $product->advantages_7=$parent_product->advantages_7;
                    $product->advantages_8=$parent_product->advantages_8;
                    $product->advantages_9=$parent_product->advantages_9;
                    $product->advantages_10=$parent_product->advantages_10;
                    $product->size_id_1=get_size($size,$size_ru,$parent_product->gender_name,$parent_product->type_id,$parent_product->type_name,$parent_product->brand);
                    $product->size_id_2='empty';
                    $product->size_id_3='empty';
                    $product->size_id_4='empty';
                    $product->size_id_5='empty';
                    $product->size_id_6='empty';
                    $product->size_id_7='empty';
                    $product->size_id_8='empty';
                    $product->size_id_9='empty';
                    $product->size_id_10='empty';
                    $product->size_name_1='Size:'.$size.' Size_ru:'.$size_ru;
                    $product->size_name_2='empty';
                    $product->size_name_3='empty';
                    $product->size_name_4='empty';
                    $product->size_name_5='empty';
                    $product->size_name_6='empty';
                    $product->size_name_7='empty';
                    $product->size_name_8='empty';
                    $product->size_name_9='empty';
                    $product->size_name_10='empty';
                    R::store($parent_product);
                    R::store($product);
                }
            }
        }
    }
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

    function update_photos(){
        for($i=1;$i<=R::count( 'base' );$i++){
            $product=R::findOne('base','id = ?',array($i));
            $product->photo = R::findOne('unique','article =?',array($article))->photo_1;
            R::store($product);
        }
    }
    



    if($_POST['start']==0){
       excel_to_db(10,10,"xls123.xls"); 
    }
    else{
        $starti=$_POST['start'];
        $end=$_POST['start']+1;
        $from = $starti*10+1;
        $to = $end*10;
        for($i=$starti;$i<$end;$i++){//58
            $start=$i*10+1;
            $last=($i+1)*10;
            $flag = excel_to_db($start,$last,'xls123.xls');
            if($flag=='false')
            {
                echo 'end';
            }
            else{
                echo 'Now done from '.$from.' to '.$to.' rows.';
            }
        }
    }
    exit();
    /*
    function data_parser($article,$flag){
        if($flag==0)
        {
            $url = 'http://www.adidas.ru/search?q='.$article;
            $file = file_get_contents($url);//скачиваем страницу по url

            $html_code = htmlspecialchars($file);//для вывода html
            $pos = strpos($html_code, 'Мы не смогли ничего найти по Вашему запросу: ');
            if ($pos != false) {
                $url = 'http://www.reebok.ru/search?q='.$article;
                $file = file_get_contents($url);
                $html_code = htmlspecialchars($file);
                $pos = strpos($html_code, 'Написать комментарий');
                if ($pos === false){
                    $product=R::dispense('unique');
                    $product->article=$article;
                    $product->code='404';
                    $gender=get_gender(trim('Прочее'));
                    $product->gender_name=$gender->name;
                    $product->gender_id=$gender->id;
                    $product->sport_name='Другой вид спорта';
                    $sport=R::findOne('categories','describtion = ? AND name = ?',array('sport','Другой вид спорта'));
                    $product->sport_id=$sport->id;
                    $product->col_name='Другие коллекции';
                    $col=R::findOne('categories','describtion = ? AND name = ?',array('brand','Другие коллекции'));
                    $product->col_id=$col->id;
                    $product->photo_1=photo_check(1,$article);
                    R::store($product);
                    return false;
                }
                else{
                    $brand = 'reebok';
                    $html = phpQuery::newDocument($file);
                }
            }
            else{
                $url1 = 'http://www.reebok.ru/search?q='.$article;
                $file1 = file_get_contents($url1);
                $html_code1 = htmlspecialchars($file1);
                $pos1 = strpos($html_code1, 'Написать комментарий');
                if($pos1 != false){
                    $flag=1;
                    data_parser($article,$flag);
                }
                $brand = 'adidas';
                $html = phpQuery::newDocument($file);
            }
        }
        elseif($flag==1){
            $url = 'http://www.reebok.ru/search?q='.$article;
            $file = file_get_contents($url);
            $html = phpQuery::newDocument($file);
            $brand='reebok';
        }
                $photoCount=0;
                foreach ($html->find('segment:eq(0)')->find('div[id*="main-section"]')->find('div[id*="productInfo"]')->find('div[class*="col-8"]')->find('div[class*="image-carousel-zoom-container"]')->find('div[class*="image-carousel-container"]')->find('div[id*="image-carousel"]')->find('div[class*="pdp-image-carousel track stack"]')->find('ul[class*="pdp-image-carousel-list"]')->find('li') as $el){
                    $photo = pq($el)->find('img')->attr('src');
                    $photo = substr( $photo,0,-11).'2000&sfrm=jpg';
                    $photoCount++;
                    $photoArray[$photoCount] = $photo;
                }
                
                $model=pq($html)->find('segment:eq(0)')->find('div[id*="main-section"]')->find('div[id*="productInfo"]')->find('div[class*="col-8"]')->find('div[class*="image-carousel-zoom-container"]')->find('div[id*="main-image"]')->find('div:eq(1)')->text();
                
                
                $short_describtion=pq($html)->find('span[class*="pdp-category-in"]')->text();//Gender Col/Sport
                $gender=get_gender(trim($short_describtion));
                $gender_name=$gender->name;
                $gender_id=$gender->id;
                $collection=substr($short_describtion,strpos($short_describtion,' ')+1);
                
                $name = pq($html)->find('segment:eq(0)')->find('div[id*="main-section"]')->find('div[id*="productInfo"]')->find('div[class*="col-4"]')->find('div[id*="buy-block"]')->find('div[class*="buy-block-header"]')->find('h1')->text();
                $colour = pq($html)->find('segment:eq(0)')->find('div[id*="main-section"]')->find('div[id*="productInfo"]')->find('div[class*="col-4"]')->find('div[id*="buy-block"]')->find('div[class*="buy-block-header"]')->find('div[class*="rbk-rounded-block "]')->find('div:eq(0)')->find('span[class*="product-color-clear"]')->text();
                $sub_type=get_type_excel($name);
                $sub_type_name=$sub_type->name;
                $sub_type_id= $sub_type->id;
                $type_id=$sub_type->parent_id;
                $sport_name=R::findOne('categories','describtion = ? AND name =?',array('sport',trim($collection)))->name;
                if(!isset($sport_name)){
                    $sport_name='Другой вид спорта';
                }
                $sport_id=R::findOne('categories','describtion = ? AND name =?',array('sport',$sport_name))->id;

                $collection_name=R::findOne('categories','describtion = ? AND name =?',array('brand',trim($collection)))->name;
                if(!isset($collection_name)){
                    $collection_name='Другие коллекции';
                }
                $collection_id=R::findOne('categories','describtion = ? AND name =?',array('brand',$collection_name))->id;

                $sameCount=0;
                foreach ($html->find('div[id*="colorVariationsCarousel"]')->find('div[class*="color-variation-row"]')->find('div') as $key) {
                        $sameCount++;
                        $sameArray[$sameCount] = pq($key)->attr('data-articleno');
                }
                
                $type_from_site = pq($html)->find('segment:eq(1)')->find('div:eq(0)')->find('h4')->text();
                $describtion = pq($html)->find('segment:eq(1)')->find('div[itemprop*="description"]')->text();

                $advantagesCount=0;
                foreach ($html->find('segment:eq(1)')->find('div:eq(0)')->find('ul')->find('li') as $key) {
                        $advantagesCount++;
                        $advantagesArray[$advantagesCount] = pq($key)->text();
                }  

                phpQuery::unloadDocuments();//очистить оперативку от последствий парсинга
                $product=R::dispense('unique');
                $product->article = $article;
                $product->sport_name=$sport_name;
                $product->sport_id=$sport_id;
                $product->col_name=$collection_name;
                $product->col_id=$collection_id;
                $product->gender_name=$gender_name;
                $product->gender_id=$gender_id;
                if($name==''){
                    $product->code='500';
                    $product->photo_1=photo_check(1,$article);
                    R::store($product);
                }
                else{
                    $product->code='200';
                    $product->brand = $brand;
                    $product->model=$model;
                    $product->type_id=$type_id;
                    $product->type_name = R::findOne('categories','id = ?',array($type_id))->name;
                    $product->sub_type_name = $sub_type_name;
                    $product->sub_type_id = $sub_type_id;
                    $product->type_from_site= $type_from_site;
                    $product->name=$name;
                    $product->colour=$colour;
                    $product->describtion=$describtion;
                    $product->short_describtion=$short_describtion;
                    R::store($product);
                    for($i=1;$i<=$photoCount;$i++){
                        $query="UPDATE `unique` SET `unique`.`photo_".$i."`='".$photoArray[$i]."' WHERE `unique`.`article` = '".$article."' AND `unique`.`name` = '".$name."'";
                        R::exec($query);
                    }
                    for($i=1;$i<=$sameCount;$i++){
                        $query="UPDATE `unique` SET `unique`.`other_colour_".$i."`='".$sameArray[$i]."' WHERE `unique`.`article` = '".$article."' AND `unique`.`name` = '".$name."'";;
                        R::exec($query);
                    }
                    for($i=1;$i<=$advantagesCount;$i++){
                        $query="UPDATE `unique` SET `unique`.`advantages_".$i."`='".$advantagesArray[$i]."' WHERE `unique`.`article` = '".$article."' AND `unique`.`name` = '".$name."'";;
                        R::exec($query);
                    }
                }
    }
        // function get_gender($name){
    //     $arr=explode(" ", $name);
    //         $i=0;
    //         foreach ($arr as $key) {
    //             $find=R::findOne('categories','name = ? and describtion = ?',array($key,'gender'));
    //             if(isset($find)){
    //                 return $find;
    //             }
    //         }
    //         $find=R::findOne('categories','name = ? AND describtion = ?',array('Прочее','gender'));
    //         return $find;
    // }

    function size_processing($size,$size_ru,$gender_name,$type_name,$type_id){
        if($type_id!=0){
            if($type_id>R::findOne('categories','name = ?',array('Обувь'))->id){
                if($gender=='Мужчины'){//Мужчины обувь

                }
                elseif($gender=='Женщины'){//Женщины обувь

                }
                elseif($gender=='Мальчики'){//Мальчики обувь

                }
                elseif($gender=='Девочки'){//Девочки  обувь

                }
                elseif($gender=='Дети'){//1-8лет

                }
                elseif($gender=='Малыши'){//0-4лет

                }
            }
            else{
                if(R::findOne('categories','id = ?',array($type_id))->name=='Куртки' || R::findOne('categories','id = ?',array($type_id))->name=='Толстовки'){

                }
                elseif(R::findOne('categories','id = ?',array($type_id))->name=='Брюки и Юбки'){

                }
                elseif(R::findOne('categories','id = ?',array($type_id))->name=='Костюмы'){
                    
                }
                if($gender=='Мужчины'){//Мужчины одежда

                }
                elseif($gender=='Женщины'){//Женщины Одежда

                }
                elseif($gender=='Мальчики'){//Мальчики одежда

                }
                elseif($gender=='Девочки'){//Девочки одежда

                }
                elseif($gender=='Дети'){//1-8лет

                }
                elseif($gender=='Малыши'){//0-4лет

                }
            }
        }
    }

    function find_size_id($parent_size_id,$size,$size_ru){
        //cloth 
        if($size_ru=' '){
            //reebok cloth size_ru=' '
           $cloth=R::findOne('categories','EUR_reebok = ?',array($size));
           if(isset($cloth)){
                $brand='reebok'; 
                return $cloth;
           }
        }
        else{
            $find_val = '|';
            $pos = strpos($size_ru, $find_val);
            if($pos!= false){//if (size_ru=='X|Y')
                $arr=explode($size_ru,'|');
                $cloth=R::find('categories','EUR = ? AND RU = ?',array($size,$arr[0]));
                if(isset($cloth)){
                    foreach ($cloth as $key) {
                        $id=$key->id+1;
                        $second_cloth=R::findOne('categories','id = ? AND RU = ? AND EUR = ?',array($id,$arr[1],$size));
                        if(isset($second_cloth))
                            return $second_cloth;
                    }
                }
                else{//if not find in adidas and not jacket
                    $cloth=R::find('categories','EUR_reebok',array($size));
                    if(isset($cloth))
                        return $cloth;
                    // $shoes=R::find('categories','US = ? AND RU = ?',array($size,$size[0]));
                    // foreach ($cloth as $key) {
                    //     $id=$key->id+1;
                    //     $second_cloth=R::findOne('categories','id = ? AND RU = ? AND US = ?',array($id,$arr[1],$size));
                    //     if(isset($second_cloth)){
                    //         return $second_cloth;
                    //     }
                    // }
                }
            }
            elseif($size==$size_ru){//куртки,костюмы и дети if(size_ru!='X|Y')
                $cloth=R::findOne('categories','RU = ?',array($size_ru));
                if(isset($cloth)){//куртки и костюмы
                    $type='Jacket';
                    return $cloth
                }
                else{//Дети
                    $cloth=R::findOne('categories','Length = ?',array($size_ru));
                    if(isset($cloth)){
                        $gender='Дети';
                        return $cloth
                    }
                }
            }
            //тут носки
        //end of cloth
        }
        //start shoes
        if($size_ru<60 && $size<20){
            $shoes=R::findOne('categories','RU = ? AND US = ?',array($size_ru,$size));
            if(isset($shoes)){
                $brand='reebok';
                return $shoes;
            }
            else{
                $shoes=R::findOne('categories','RU = ? AND UK = ?',array($size_ru,$size));
            }
        }
        //end shoes
        // if($parent_size_id==0){
        //     for ($i=1;$i<=10;$i++) {
        //         $where='keyword_'.$i.' = ? AND  describtion = ?';
        //         $size_id=R::findOne('categories',$where,array($size_ru,'size'))->id;
        //         if(isset($size_id)){
        //             return $size_id;
        //         }
        //     }
        //     for ($i=1;$i<=10;$i++) {
        //         $where='keyword_'.$i.' = ? AND  describtion = ?';
        //         $size_id=R::findOne('categories',$where,array($size,'size'))->id;
        //         if(isset($size_id)){
        //             return $size_id;
        //         }
        //     }
        // }
        // else{
        //    for ($i=1;$i<=10;$i++) {
        //         $where='keyword_'.$i.' = ? AND  parent_id = ?';
        //         $size_id=R::findOne('categories',$where,array($size_ru,$parent_size_id))->id;
        //         if(isset($size_id)){
        //             return $size_id;
        //         }
        //     }
        //     for ($i=1;$i<=10;$i++) {
        //         $where='keyword_'.$i.' = ? AND  parent_id = ?';
        //         $size_id=R::findOne('categories',$where,array($size,$parent_size_id))->id;
        //         if(isset($size_id)){
        //             return $size_id;
        //         }
        //     }
        // }
        // $size_id=R::findOne('categories','name = ? AND describtion = ?',array('Неопределенный размер','size'))->id;        
        // return $size_id;
    }
    function get_size($size,$size_ru,$type_name,$gender_name,$sub_type_name){
        //чистка от носков
        $find_val = '|';
        $pos = strpos($size_ru, $find_val);
        $find_val1 = '-';
        $pos1 = strpos($size_ru, $find_val1);
        //конец чистки от носков
        if($type_name=='Прочее' && $size_ru>=15 && $size_ru<60 && $pos === false && $pos1 === false){
            $type_name='Обувь';
            $sub_type_name='Остальная обувь';
            $describtion='size_shoes';
            if($size_ru<$size){
                $gender_to_search='Infants';
            }
            elseif($size<5){
                $gender_to_search='Дети';
            }
            elseif($size_ru>39){
                $gender_to_search='Мужчины';
            }
            else{
                $gender_to_search='Женщины';
            }
        }

        $check=R::findOne('categories','name = ? AND describtion = ?',array('Неопределенный размер','size'))->id;
        
        if($type_name=='Прочее'){
            if($size_ru>100 && $size==$size_ru){
                $gender_to_search='Дети';
                $describtion='size_cloth';
                $type_name='Другая одежда';
                $sub_type_name='Вся другая одежда';
            }
            else{
                $size_id=R::findOne('categories','name = ? AND describtion = ?',array('Неопределенный размер','size'))->id;
                $product->size_shoes=$check;
                $product->size_cloth=$check;
                $product->sub_type_name=$sub_type_name;
                $product->type_name=$type_name;
                return $product;
            }
        }
        elseif($type_name=='Обувь' && $describtion!='size_shoes'){
            $describtion='size_shoes';
            $gender_to_search=$gender_name;
        }
        else{//Одежда
            $describtion='size_cloth';
            if($gender_name=='Прочее'){
                if($size_ru>100 && $size==$size_ru){
                    $gender_to_search='Дети';
                }
                else{
                    $gender_to_search='Унисекс';
                }
            }
            else{
                $gender_to_search=$gender_name;
            }
        }

        
        for ($i=1;$i<=10;$i++) {
            $where='keyword_'.$i.' = ? AND describtion = ?';
            $size_parent=R::findOne('categories',$where,array($gender_to_search,$describtion))->id;
            if(isset($size_parent)){
                $size_id=find_size_id($size_parent,$size,$size_ru);
                if($size_id!=$check){
                    if($describtion=='size_cloth'){
                        $product->size_cloth=$size_id;
                        $product->size_shoes=$check;
                    }
                    elseif($describtion=='size_shoes'){
                        $product->size_shoes=$size_id;
                        $product->size_cloth=$check;
                    }
                    $product->gender=$gender_to_search;
                    $product->gender_id=R::findOne('categories','name = ? AND describtion = ?',array($gender_to_search,'gender'))->id;
                    $product->sub_type_name=$sub_type_name;
                    $product->type_name=$type_name;
                    return $product;
                }
            }
        }


        //Второй проход
        $size_id=find_size_id(0,$size,$size_ru);
        if($size_id!=$check){
            $gender_by_size=R::findOne('categories','id = ?',array($size_id))->parent_id;
            $size_type=R::findOne('categories','id = ?',array($gender_by_size));
            $gender=R::findOne('categories','name = ? AND describtion = ?',array($size_type->keyword_1,'gender'));
            if($describtion=='size_cloth'){
                $product->size_cloth=$size_id;
                $product->size_shoes=$check;
            }
            elseif($describtion=='size_shoes'){
                $product->size_shoes=$size_id;
                $product->size_cloth=$check;
            }
            $product->gender_name=$gender->name;
            $product->gender_id=$gender->id;
            $product->type_name=$type_name;
            $product->sub_type_name=$sub_type_name;
            return $product;
        }
        else{ 
            $product->gender_name=$gender_name;
            $product->gender_id=R::findOne('categories','name = ? AND describtion = ?',array($gender_name,'gender'))->id;
            $product->size_shoes=$check;
            $product->size_cloth=$check;
            $product->type_name=$type_name;
            $product->sub_type_name=$sub_type_name;
            return $product;
        }

    }
    */
?>