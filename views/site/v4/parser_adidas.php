<?php
    require "db.php";
    require "libs/phpQuery.php";
    header('content-type: text/html;charset=utf-8');
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
                    if(isset($find))
                        return $find;
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
    data_parser('X57971',0);

    //  data_parser_clubsale('X19177');

    // data_parser_co_uk('033620',0);

    //  data_parser_draft('X19177');
?>