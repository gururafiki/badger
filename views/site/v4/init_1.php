 <?php
    //Скачать библиотеку - http://phpexcel.codeplex.com/
    //Нашел русскую документацию - http://www.cyberforum.ru/php-beginners/thread1074684.html
    //Подключаем скачаную библиотеку
    require "db.php";
    function init(){
        $product_gen=R::dispense('unique');
        $product_gen->article = '';
        $product_gen->code='';
        $product_gen->col_id = '';
        $product_gen->gender_id = '';
        $product_gen->sport_id = '';
        $product_gen->type_id='';
        $product_gen->sub_type_id='';
        $product_gen->size_cloth_id='';
        $product_gen->size_shoes_id='';
        $product_gen->new = '';
        $product_gen->sale = '';
        $product_gen->popular = '';
        $product_gen->col_name = '';
        $product_gen->gender_name = '';
        $product_gen->sport_name = '';
        $product_gen->type_name='';
        $product_gen->sub_type_name='';
        $product_gen->size='';
        $product_gen->size_ru='';
        $product_gen->name = '';
        $product_gen->model = '';
        $product_gen->brand= '';
        $product_gen->colour='';
        $product_gen->short_describtion='';
        $product_gen->describtion='';
        $product_gen->type_from_site = '';
        $product_gen->name_excel = '';
        $product_gen->price_buy = '';
        $product_gen->price_sell='';
        $product_gen->count='';
        $product_gen->photo_1='';
        $product_gen->photo_2='';
        $product_gen->photo_3='';
        $product_gen->photo_4='';
        $product_gen->photo_5='';
        $product_gen->photo_6='';
        $product_gen->photo_7='';
        $product_gen->photo_8='';
        $product_gen->photo_9='';
        $product_gen->phoro_10='';
        $product_gen->other_colour_1='';
        $product_gen->other_colour_2='';
        $product_gen->other_colour_3='';
        $product_gen->other_colour_4='';
        $product_gen->other_colour_5='';
        $product_gen->other_colour_6='';
        $product_gen->other_colour_7='';
        $product_gen->other_colour_8='';
        $product_gen->other_colour_9='';
        $product_gen->other_colour_10='';
        $product_gen->advantages_1='';
        $product_gen->advantages_2='';
        $product_gen->advantages_3='';
        $product_gen->advantages_4='';
        $product_gen->advantages_5='';
        $product_gen->advantages_6='';
        $product_gen->advantages_7='';
        $product_gen->advantages_8='';
        $product_gen->advantages_9='';
        $product_gen->advantages_10='';
        R::store($product_gen);
        $user = R::dispense('clients');
        $user->name = $_POST['name'];
        $user->email = $_POST['email'];
        $user->password = $_POST['password'];
        $user->postcode = $_POST['postcode'];
        $user->city = $_POST['city'];
        $user->adress = $_POST['adress'];
        R::store($user);
    }
    function update($parent){
        create_db('Все коллекции',$parent,'brand','');
        create_db('Originals',$parent,'brand','Originals');
        create_db('Performance',$parent,'brand','Performance');
        create_db('Athletics',$parent,'brand','Athletics');
        create_db('Porsche Design Sport by adidas',$parent,'brand','Porsche,Porsche Design Sport,Porsche Design Sport by adidas');
        create_db('adidas neo',$parent,'brand','adidas neo,neo');
        create_db('TERREX',$parent,'brand','TERREX');
        create_db('Y-3',$parent,'brand','Y-3');
        create_db('adidas by Stella McCartney',$parent,'brand','McCartney,Stella McCartney,Stella');
        create_db('CrossFit Games',$parent,'brand','CrossFit Games,CrossFit');
        create_db('Open Mag',$parent,'brand','Open Mag,Mag');
        create_db('UFC Gear',$parent,'brand','UFC Gear,UFC');
        create_db('Combar Gear',$parent,'brand','Combar Gear,Combat');
        create_db('Les Mills',$parent,'brand','Les Mills,Mills,Les');
        create_db('Retro Revival',$parent,'brand','Retro Revival,Retro,Revival');
        create_db('Spartan Race',$parent,'brand','Spartan Race,Spartan,Race');
        create_db('Noble Fight',$parent,'brand','Noble Fight,Noble,Fight');
        create_db('Binky',$parent,'brand','Binky');
        create_db('City Series',$parent,'brand','City Series,City,Series');
        create_db('Sport Essentials',$parent,'brand','Sport Essentials,Essentials');
        create_db('Super Nasty Boardshorts',$parent,'brand','Super Nasty Boardshorts,Super,Nasty,Boardshorts');
        create_db('Nano',$parent,'brand','Nano');
        create_db('Elements',$parent,'brand','Elements');
        create_db('Local Heroes',$parent,'brand','Local Heroes,Local,Heroes');
        create_db('Reebok ONE',$parent,'brand','Reebok ONE');
        create_db('BodyPump 100',$parent,'brand','BodyPump 100,BodyPump');
        create_db('Almotio',$parent,'brand','Almotio');
        create_db('Fitness Heritage',$parent,'brand','Fitness Heritage,Fitness,Heritage');
        create_db('Hayasu',$parent,'brand','Hayasu');
        create_db('Workout Ready',$parent,'brand','Workout Ready,Workout,Ready');
        create_db('Cardio Ultra',$parent,'brand','Cardio Ultra,Cardio');
        create_db('Guresu',$parent,'brand','Guresu');
        create_db('Ultra',$parent,'brand','Ultra');
        create_db('Izarre',$parent,'brand','Izarre');
        create_db('Inspire',$parent,'brand','Inspire');
        create_db('Wave Glider',$parent,'brand','Wave Glider,Wave,Glider');
        create_db('Другие коллекции',$parent,'brand','');


        create_db('Все виды спорта',$parent,'sport','');
        create_db('Футбол',$parent,'sport','Футбол,Football');
        create_db('Бег',$parent,'sport','Бег,Running');
        create_db('Гандбол',$parent,'sport','Гандбол,Handball');
        create_db('Outdoor',$parent,'sport','Outdoor');
        create_db('Скейтбординг',$parent,'sport','Скейтбординг,Skateboarding');
        create_db('Баскетбол',$parent,'sport','Баскетбол,Bascketball');
        create_db('Фитнес',$parent,'sport','Фитнес');
        create_db('Теннис',$parent,'sport','Теннис,Tennis');
        create_db('Регби',$parent,'sport','Регби,Rugby');
        create_db('Тренировки',$parent,'sport','Тренировки,Training');
        create_db('Скалолазание',$parent,'sport','Скалолазание,Climbing');
        create_db('Гольф',$parent,'sport','Гольф,Golf');
        create_db('Плавание',$parent,'sport','Плавание,Swimming');
        create_db('Сноубординг',$parent,'sport','Сноубординг');
        create_db('Тяжелая атлетика',$parent,'sport','Тяжелая атлетика');
        create_db('Легкая атлетика',$parent,'sport','Легкая атлетика');
        create_db('Бокс',$parent,'sport','Бокс');
        create_db('Волейбол',$parent,'sport','Волейбол,Volleyball');
        create_db('Бейсбол',$parent,'sport','Бейсбол,Baseball');
        create_db('Велоспорт',$parent,'sport','Велоспорт,Cycling,MTB');
        create_db('Йога',$parent,'sport','Йога');
        create_db('Другой вид спорта',$parent,'sport','');
    }
    function create_db($name,$parent,$describtion,$keywords){
        if ( $parent=='main' ) {
            $parent_id=0;
        }
        else{
            $parent_id=R::findOne('categories','name = ?',array($parent))->id;
        }
        $category = R::dispense('categories');
        $category->parent_id = $parent_id; 
        $category->name = $name;
        $category->need = 1;
        $category->keywords = $keywords;
        $category->keyword_1 = '';
        $category->keyword_2 = '';
        $category->keyword_3 = '';
        $category->keyword_4 = '';
        $category->keyword_5 = '';
        $category->keyword_6 = '';
        $category->keyword_7 = '';
        $category->keyword_8 = '';
        $category->keyword_9 = '';
        $category->keyword_10 = '';
        $category->keyword_11 = '';
        $category->keyword_12 = '';
        $category->describtion =$describtion;
        R::store($category);
        $arr=explode(",", $keywords);
        $i=0;
        foreach ($arr as $key) {
            $i++;
            $query="UPDATE `categories` SET `categories`.`keyword_".$i."`='".$key."' WHERE `categories`.`name` = '".$name."' AND `categories`.`parent_id` = '".$parent_id."'";
            R::exec($query);
        }
        $query="UPDATE `categories` SET `categories`.`keywords`='".$i."' WHERE `categories`.`name` = '".$name."' AND `categories`.`parent_id` = '".$parent_id."'";
            R::exec($query);
    }
    create_db('Прочее','main','type','');
        create_db('Прочее','Прочее','sub_type','');
    update('main');
    create_db('Мужчины','main','gender','Мужчины,Мужская,Мужчинам,Men');
        //мужчины
            create_db('Одежда','main','Main','');
            //одежда
                create_db('Футболки','main','type','');
                //футболки
                    create_db('Все футболки','Футболки','sub_type','');
                    create_db('Футболки с коротким рукавом','Футболки','sub_type','Футболка,Футболки,TEE,TEE1');
                    create_db('Джерси','Футболки','sub_type','Джерси,JSY,Jersey');
                    create_db('Поло','Футболки','sub_type','Поло,POLO,футболка-поло');
                    create_db('Майки','Футболки','sub_type','Майка,Майки,TANK');
                    create_db('Лонгсливы','Футболки','sub_type','Лонгслив,Лонгсливы,Long Sleeve,Sleeve');
                    create_db('Топы','Футболки','sub_type','Топ,TOP');
                    create_db('Остальные футболки','Футболки','sub_type','Рубашка,Майка-платье');
                //конец футболки
                create_db('Толстовки','main','type','');
                //начало Толстовки
                    create_db('Все толстовки','Толстовки','sub_type','');
                    create_db('Худи','Толстовки','sub_type','Толстовка,Толстовки,Худи,HOOD,HOODB,HOODIE,HOODY');
                    create_db('Олимпийки','Толстовки','sub_type','Олимпийка,Олимпийки,Olimpique');
                    create_db('Джемпер','Толстовки','sub_type','Джемпер,Джемперы');
                    create_db('Свитшоты','Толстовки','sub_type','Свитшот,Sweatshirt');
                    create_db('Ветровки','Толстовки','sub_type','Ветровка,Ветровки');
                    create_db('Остальные толстовки','Толстовки','sub_type','');
                //Конец толстовки
                create_db('Брюки и юбки','main','type','');
                //начало брюки
                    create_db('Все брюки и юбки','Брюки и юбки','sub_type','');
                    create_db('Брюки','Брюки и юбки','sub_type','Брюки,PNT,PANT,PANTS');
                    create_db('Спортивные штаны','Брюки и юбки','sub_type','Штаны');
                    create_db('Леггинсы','Брюки и юбки','sub_type','Леггинсы,Leggings');
                    create_db('Платья','Брюки и юбки','sub_type','Платье,Skirt,dress,Платья,Платье-футболка');
                    create_db('Юбки','Брюки и юбки','sub_type','Юбка,Юбки');
                    create_db('Бриджи','Брюки и юбки','sub_type','Бриджи');
                    create_db('Тайтсы','Брюки и юбки','sub_type','Тайтсы,Tight,Tights');
                    create_db('Чиносы','Брюки и юбки','sub_type','Чиносы');
                    create_db('Остальная нижняя одежда','Брюки и юбки','sub_type','Брюки-колюты,Брюки-чиносы');

                //Конец брюки
                create_db('Шорты','main','type','');

                    create_db('Все шорты','Шорты','sub_type','Шорты,SHO,SHTS,SHORTS,SHORT');
                    create_db('Остальные шорты','Шорты','sub_type','Капри');
                
                create_db('Куртки','main','type','');
                //начало куртки
                    create_db('Все куртки','Куртки','sub_type','');
                    create_db('Ветровки','Куртки','sub_type','Ветровка,Ветровки');
                    create_db('Куртки','Куртки','sub_type','Куртка,Куртки,PAD,SDPJKT,JACKET,JKT,TOP');
                    create_db('Жилетки','Куртки','sub_type','Жилетка,VEST,Жилетки,Жилет');
                    create_db('Пуховики','Куртки','sub_type','Пуховик,Пуховики');
                    create_db('Бомберы','Куртки','sub_type','Бомбер,Бомберы');
                    create_db('Парки','Куртки','sub_type','Парка,Парки,Parka');
                    create_db('Пальто','Куртки','sub_type','Пальто');
                    create_db('Плащи','Куртки','sub_type','Плащ,Плащи');
                    create_db('Остальные куртки','Куртки','sub_type','');
                //Конец куртки
                create_db('Одежда для плавания','main','type','');

                    create_db('Вся одежда для плавания','Одежда для плавания','sub_type','');
                    create_db('Плавки','Одежда для плавания','sub_type','Плавки,Плавки-боксеры');
                    create_db('Слитный Купальник','Одежда для плавания','sub_type','Купальник,Swimsuit');
                    create_db('Раздельный Купальник','Одежда для плавания','sub_type','Купальника');
                    create_db('Остальная одежда для плавания','Одежда для плавания','sub_type','Плавания,Плавательная,SWIM');

                create_db('Спортивные костюмы','main','type','');

                    create_db('Все спортивные костюмы','Спортивные костюмы','sub_type','');
                    create_db('Комплекты','Спортивные костюмы','sub_type','Комплект:,Костюм,SUIT,Комплект');
                    create_db('Комбинезоны','Спортивные костюмы','sub_type','Комбинезон,');
                    create_db('Остальные спортивные костюмы','Спортивные костюмы','sub_type','');

                create_db('Нижнее белье','main','type','');

                    create_db('Всё нижнее белье','Нижнее белье','sub_type','');
                    create_db('Трусы','Нижнее белье','sub_type','Трусы,трусов-боксеров,трусов,трусы-боксеры');
                    create_db('Бюстгальтеры','Нижнее белье','sub_type','Бюстгальтер,BRA');
                    create_db('Остальное нижнее белье','Нижнее белье','sub_type','Underwear');

                create_db('Другая одежда','main','type','');
                    create_db('Вся другая одежда','Другая одежда','sub_type','');

            //конец одежды
            create_db('Обувь','main','type','');
            //начало обувь
                create_db('Вся обувь','Обувь','sub_type','Обувь,Shoes');
                create_db('Кроссовки','Обувь','sub_type','Кроссовки');
                create_db('Шлепанцы','Обувь','sub_type','Шлепанцы,Сланцы,Slides');
                create_db('Сандали','Обувь','sub_type','Сандали,Sandals,Сандалии');
                create_db('Бутсы','Обувь','sub_type','Бутсы,Boots');
                create_db('Остальная обувь','Обувь','sub_type','Cribs,Trainers,Sneakers,Ботинки,Кеды');
            //конец обувь
            create_db('Аксессуары','main','Main','');
            //начало Аксессуары 
                create_db('Все аксессуары','Аксессуары','sub_type','');
                create_db('Рюкзаки и сумки','Аксессуары','sub_type','Рюкзак,Сумка,Сумка-Мешок,BAG,BACKPACK,TROLLEY,SACK,Сумка-органайзер');
                create_db('Носки','Аксессуары','sub_type','Носков,Носки,SOCK,ГЕТРЫ,SOCKS');
                create_db('Шапки','Аксессуары','sub_type','Шапка,BEANIE,WOOLLY,Шапка-бини');
                create_db('Кепки','Аксессуары','sub_type','Кепка,Панама,Повзяка,HEAD,HAT,CAP,HEAD,HEADBAND,Кепка-козырек');
                create_db('Перчатки','Аксессуары','sub_type','Перчатки,Рукавицы,Gloves');
                create_db('Мячи','Аксессуары','sub_type','BALL,Мяч,Мини-мяч');
                create_db('Шарфы','Аксессуары','sub_type','Шарф,SCARF');
                create_db('Спортивные пренадлежности','Аксессуары','sub_type','Велошорты,Манишка,Щитки,Фиксатор,Утяжелители,Мат,Guards');
                create_db('Остальные аксессуары','Аксессуары','sub_type','Пояс,бутылка,Напульсники,Карман,Wallet,Очки,Кошелек,Goggles,Bathrobe');
            //конец аксессуары
        //конец мужчины
            create_db('Размер одежды для Мужчин','main','size_cloth','Мужчины');
                create_db('40|42(XS)','Размер одежды для Мужчин','size','40|42,RU_1_A:40,RU_2_A:42,RU_R:42,EUR:XS,83-86/71-74/82-85');
                create_db('44|46(S)','Размер одежды для Мужчин','size','44|46,RU_1_A:44,RU_2_A:46,RU_R:46,EUR:S,89-92/77-80/88-91');
                create_db('48|50(M)','Размер одежды для Мужчин','size','48|50,RU_1_A:48,RU_2_A:50,RU_R:50,EUR:M,96-100/84-88/95-99');
                create_db('52|54(L)','Размер одежды для Мужчин','size','52|54,RU_1_A:52,RU_2_A:54,RU_R:54,EUR:L,104-108/92-96/103-107');
                create_db('56|58(XL)','Размер одежды для Мужчин','size','56|58,RU_1_A:56,RU_2_A:58,RU_R:58,EUR:XL,113-118/101-106/111.5-116');
                create_db('60|62(2XL)','Размер одежды для Мужчин','size','60|62,RU_1_A:60,RU_2_A:62,RU_R:62,EUR:2XL,124-130/112.5-119/120.5-125');
                create_db('64|66(3XL)','Размер одежды для Мужчин','size','64|66,RU_1_A:64,RU_2_A:66,RU_R:66,EUR:3XL,136-142/125.5-132/130-135');
                create_db('68|70(4XL)','Размер одежды для Мужчин','size','68|70,RU_1_A:68,RU_2_A:70,EUR:4XL,148-154/138.5-145/140-145');
                create_db('40|42(XST) для высоких Мужчин','Размер одежды для Мужчин','size','EUR:XST');
                create_db('44|46(ST) для высоких Мужчин','Размер одежды для Мужчин','size','EUR:ST');
                create_db('48|50(MT) для высоких Мужчин','Размер одежды для Мужчин','size','EUR:MT');
                create_db('52|54(LT) для высоких Мужчин','Размер одежды для Мужчин','size','EUR:LT');
                create_db('56|58(XLT) для высоких Мужчин','Размер одежды для Мужчин','size','EUR:XLT');
                create_db('60|62(2XLT) для высоких Мужчин','Размер одежды для Мужчин','size','EUR:2XLT');
                create_db('64|66(3XLT) для высоких Мужчин','Размер одежды для Мужчин','size','EUR:3XLT');

            create_db('Размер обуви для Мужчин','main','size_shoes','Мужчины');
                    //RU,EUR(FR),US,UK,Длина стопы
                create_db('35.5','Размер обуви для Мужчин','size','RU_A:35.5,EUR_A:36,UK_A:3.5,L_F_A:22.1');
                create_db('36','Размер обуви для Мужчин','size','RU_A:36,EUR_A:36 2/3,UK_A:4,L_F_A:22.5');
                create_db('36.5','Размер обуви для Мужчин','size','RU_A:36.5,EUR_A:37 1/3,US_A:5,UK_A:4.5,L_F_A:22.9');
                create_db('37','Размер обуви для Мужчин','size','RU_A:37,EUR_A:38,US_A:5.5,UK_A:5,L_F_A:23.3');
                create_db('37.5','Размер обуви для Мужчин','size','RU_A:37.5,EUR_A:38 2/3,US_A:6,UK_A:5.5,L_F_A:23.8');
                create_db('38','Размер обуви для Мужчин','size','RU_A:38,39 1/3,US_A:6.5,UK_A:6,L_F_A:24.2');
                create_db('38.5','Размер обуви для Мужчин','size','RU_A:38.5,EUR_A:40,US_A:7,UK_A:6.5,L_F_A:24.6');
                create_db('39','Размер обуви для Мужчин','size','RU_A:39,EUR_A:40 2/3,US_A:7.5,UK_A:7,L_F_A:24.6,EUR_R:39,US_R:7,UK_R:6,L_F_R:25');
                create_db('40','Размер обуви для Мужчин','size','RU_A:40,EUR_A:41 1/3,US_A:8,UK_A:7.5,L_F_A:25.5,EUR_R:40,US_R:7.5,UK_R:6.5,L_F_R:25.5');
                create_db('40.5','Размер обуви для Мужчин','size','RU_A:40.5,EUR_A:42,US_A:8.5,UK_A:8,L_F_A:25.9,EUR_R:40.5,US_R:8,UK_R:7,L_F_R:26');
                create_db('41','Размер обуви для Мужчин','size','RU_A:41,EUR_A:42 2/3,US_A:9,UK_A:8.5,L_F_A:26.3,EUR_R:41,US_R:8.5,UK_R:7.5,L_F_R:26.5');
                create_db('42','Размер обуви для Мужчин','size','RU_A:42,EUR_A:43 1/3,US_A:9.5,UK_A:9,L_F_A:26.7,EUR_R:42,US_R:9,UK_R:8,L_F_R:27');
                create_db('42.5','Размер обуви для Мужчин','size','RU_A:42.5,EUR_A:44,US_A:10,UK_A:9.5,L_F_A:27.1');
                create_db('43','Размер обуви для Мужчин','size','RU_A:43,EUR_A:44 2/3,US_A:10.5,UK_A:10,L_F_A:27.6,EUR_R:42.5,US_R:9.5,UK_R:8.5,L_F_R:27.5');
                create_db('43.5','Размер обуви для Мужчин','size','RU_R:43.5,EUR_R:43,US_R:10,UK_R:9,L_F_R:28');
                create_db('44','Размер обуви для Мужчин','size','RU_A:44,EUR_A:45 1/3,US_A:11,UK_A:10.5,L_F_A:28,EUR_R:44,US_R:10.5,UK_R:9.5,L_F_R:28.5');
                create_db('44.5','Размер обуви для Мужчин','size','RU_A:44.5,EUR_A:46,US_A:11.5,UK_A:11,L_F_A:28.4');
                create_db('45','Размер обуви для Мужчин','size','RU_A:45,EUR_A:46 2/3,US_A:12,UK_A:11.5,L_F_A:28.8,EUR_R:44.5,US_R:11,UK_R:10,L_F_R:29');
                create_db('46','Размер обуви для Мужчин','size','RU_A:46,EUR_A:47 1/3,US_A:12.5,UK_A:12,L_F_A:29.3,EUR_R:45,US_R:11.5,UK_R:10.5,L_F_R:29.5');
                create_db('46.5','Размер обуви для Мужчин','size','RU_A:46.5,EUR_A:48,US_A:13,UK_A:12.5,L_F_A:29.7,EUR_R:45.5,US_R:12,UK_R:11,L_F_R:30');
                create_db('47','Размер обуви для Мужчин','size','RU_A:47,EUR_A:48 2/3,US_A:13.5,UK_A:13,L_F_A:30.1,EUR_R:46,US_R:12.5,UK_R:11.5,L_F_R:30.5');
                create_db('47.5','Размер обуви для Мужчин','size','RU_R:47.5,EUR_R:47,US_R:13,UK_R:12,L_F_R:31');
                create_db('48','Размер обуви для Мужчин','size','RU_A:48,EUR_A:49 1/3,US_A:14,UK_A:13.5,L_F_A:30.5,EUR_R:48,US_R:13.5,UK_R:12.5,L_F_R:31.5');
                create_db('48.5','Размер обуви для Мужчин','size','RU_R:48.5,EUR_R:48.5,US_R:14,UK_R:13,L_F_R:32');
                create_db('49','Размер обуви для Мужчин','size','RU_A:49,EUR_A:50,US_A:14.5,UK_A:14,L_F_A:31,EUR_R:49,US_R:14.5,UK_R:13.5,L_F_R:32.5');
                create_db('49.5','Размер обуви для Мужчин','size','RU_A:49.5,EUR_A:50 2/3,US_A:15,UK_A:14.5,L_F_A:31.4,EUR_R:50,US_R:15,UK_R:14,L_F_R:33');
                create_db('50','Размер обуви для Мужчин','size','RU_A:50,EUR_A:51 1/3 2/3,US_A:15.5,UK_A:15,L_F_A:32.2');
                create_db('51','Размер обуви для Мужчин','size','RU_A:51,EUR_A:52,US_A:16,UK_A:15.5,L_F_A:33.1');
                create_db('52','Размер обуви для Мужчин','size','RU_A:52,EUR_A:52 2/3,US_A:16.5,UK_A:16,L_F_A:33.9');
                create_db('53','Размер обуви для Мужчин','size','RU_A:53,EUR_A:53 1/3,US_A:17,UK_A:17,L_F_A:34.8');
                create_db('54','Размер обуви для Мужчин','size','RU_A:54,EUR_A:54 2/3,US_A:17.5,UK_A:18,L_F_A:35.6');
                
        create_db('Женщины','main','gender','Женщины,Women,Женщинам,Женская');
            create_db('Размер одежды для Женщин','main','size_cloth','Женщины');
                create_db('38(2XS)','Размер одежды для Женщин','size','RU_1_A:38,RU_2_A:38,RU_R:38,EUR:2XS,GER_1_A:28,GER_2_A:28,76/60/85');//RU,EUR,GER,грудь/талия/бедра
                create_db('40|42(XS)','Размер одежды для Женщин','size','40|42,RU_1_A:40,RU_2_A:42,RU_R:40,EUR:XS,GER_1_A:30,GER_2_A:32,79-82/63-66/88-91');
                create_db('42|44(S)','Размер одежды для Женщин','size','42|44,RU_1_A:42,RU_2_A:44,RU_R:44,EUR:S,GER_1_A:34,GER_2_A:36,85-88/69-72/94-97');
                create_db('46|48(M)','Размер одежды для Женщин','size','46|48,RU_1_A:46,RU_2_A:48,RU_R:48,EUR:M,GER_1_A:38,GER_2_A:40,91-94/75-78/100-103');
                create_db('48|50(L)','Размер одежды для Женщин','size','48|50,RU_1_A:48,RU_2_A:50,RU_R:52,EUR:L,GER_1_A:42,GER_2_A:44,97.5-101/81.5-85/106.5-110');
                create_db('52|54(XL)','Размер одежды для Женщин','size','52|54,RU_1_A:52,RU_2_A:54,RU_R:54,EUR:XL,GER_1_A:46,GER_2_A:48,105-109/89.5-94/113.5-117');
                create_db('56|58(2XL)','Размер одежды для Женщин','size','56|58,RU_1_A:56,RU_2_A:58,RU_R:58,EUR:2XL,GER_1_A:50,GER_2_A:52,113-118/99-104/121-125');
                create_db('40|42(XST) для высоких Женщин','Размер одежды для Женщин','size','EUR:XST');
                create_db('42|44(ST) для высоких Женщин','Размер одежды для Женщин','size','EUR:ST');
                create_db('46|48(MT) для высоких Женщин','Размер одежды для Женщин','size','EUR:MT');
                create_db('48|50(LT) для высоких Женщин','Размер одежды для Женщин','size','EUR:LT');
                create_db('52|54(XLT) для высоких Женщин','Размер одежды для Женщин','size','EUR:XLT');
                create_db('56|58(2XLT) для высоких Женщин','Размер одежды для Женщин','size','EUR:2XLT');
            
            create_db('Размер обуви для Женщин','main','size_shoes','Женщины');
                create_db('34.5','Размер обуви для Женщин','size','RU_R:34.5,EUR_R:35,US_R:5,UK_R:2.5,L_F_R:22');
                create_db('35','Размер обуви для Женщин','size','RU_R:35,EUR_R:35.5,US_R:5.5,UK_R:3,L_F_R:22.5');
                create_db('35.5','Размер обуви для Женщин','size','RU_A:35.5,EUR_A:36,US_A:5,UK_A:3.5,L_F_A:22.1');
                create_db('36','Размер обуви для Женщин','size','RU_A:36,EUR_A:36 2/3,US_A:5.5,UK_A:4,L_F_A:22.5,EUR_R:36,US_R:6,UK_R:3.5,L_F_R:23');
                create_db('36.5','Размер обуви для Женщин','size','RU_A:36.5,EUR_A:37 1/3,US_A:6,UK_A:4.5,L_F_A:22.9');
                create_db('37','Размер обуви для Женщин','size','RU_A:37,EUR_A:38,US_A:6.5,UK_A:5,L_F_A:23.3,EUR_R:37,US_R:6.5,UK_R:4,L_F_R:23.5');
                create_db('37.5','Размер обуви для Женщин','size','RU_A:37.5,EUR_A:38 2/3,US_A:7,UK_A:5.5,L_F_A:23.8,EUR_R:37.5,US_R:7,UK_R:4.5,L_F_R:24');
                create_db('38','Размер обуви для Женщин','size','RU_A:38,39 1/3,US_A:7.5,UK_A:6,L_F_A:24.2,EUR_R:38,US_R:7.5,UK_R:5,L_F_R:24.5');
                create_db('38.5','Размер обуви для Женщин','size','RU_A:38.5,EUR_A:40,US_A:8,UK_A:6.5,L_F_A:24.6');
                create_db('39','Размер обуви для Женщин','size','RU_A:39,EUR_A:40 2/3,US_A:8.5,UK_A:7,L_F_A:24.6,EUR_R:38.5,US_R:8,UK_R:5.5,L_F_R:25');
                create_db('40','Размер обуви для Женщин','size','RU_A:40,EUR_A:41 1/3,US_A:9,UK_A:7.5,L_F_A:25.5,EUR_R:39,US_R:8.5,UK_R:6,L_F_R:25.5');
                create_db('40.5','Размер обуви для Женщин','size','RU_A:40.5,EUR_A:42,US_A:9.5,UK_A:8,L_F_A:25.9,EUR_R:40,US_R:9,UK_R:6.5,L_F_R:26');
                create_db('41','Размер обуви для Женщин','size','RU_A:41,EUR_A:42 2/3,US_A:10,UK_A:8.5,L_F_A:26.3,EUR_R:40.5,US_R:9.5,UK_R:7,L_F_R:26.5');
                create_db('42','Размер обуви для Женщин','size','RU_A:42,EUR_A:43 1/3,US_A:10.5,UK_A:9,L_F_A:26.7,EUR_R:41,US_R:10,UK_R:7.5,L_F_R:27');
                create_db('42.5','Размер обуви для Женщин','size','RU_A:42.5,EUR_A:44,US_A:11,UK_A:9.5,L_F_A:27.1');
                create_db('43','Размер обуви для Женщин','size','RU_A:43,EUR_A:44 2/3,US_A:11.5,UK_A:10,L_F_A:27.6,EUR_R:42,US_R:10.5,UK_R:8,L_F_R:27.5');
                create_db('43.5','Размер обуви для Женщин','size','RU_R:43.5,EUR_R:42.5,US_R:11,UK_R:8.5,L_F_R:28');
                create_db('44','Размер обуви для Женщин','size','RU_A:44,EUR_A:45 1/3,US_A:12,UK_A:10.5,L_F_A:28,EUR_R:43,US_R:11.5,UK_R:9,L_F_R:28.5');
                create_db('44.5','Размер обуви для Женщин','size','RU_A:44.5,EUR_A:46,US_A:12.5,UK_A:11,L_F_A:28.4');
                create_db('45','Размер обуви для Женщин','size','RU_R:45,EUR_R:44,US_R:12,UK_R:9.5,L_F_R:29');



        create_db('Дети','main','gender','Дети,Детская,Детям');
            create_db('Размер одежды для Подростков','main','size_cloth','Подростки');
                create_db('116','Размер одежды для Подростков','size','Height:116');
                create_db('122','Размер одежды для Подростков','size','Height:122');
                create_db('128','Размер одежды для Подростков','size','Height:128');
                create_db('134','Размер одежды для Подростков','size','Height:134');
                create_db('140','Размер одежды для Подростков','size','Height:140');
                create_db('146','Размер одежды для Подростков','size','Height:146');
                create_db('152','Размер одежды для Подростков','size','Height:152');
                create_db('158','Размер одежды для Подростков','size','Height:158');
                create_db('164','Размер одежды для Подростков','size','Height:164');
                create_db('170','Размер одежды для Подростков','size','Height:170');
                create_db('176','Размер одежды для Подростков','size','Height:176');

            create_db('Размер одежды для Детей','main','size_cloth','Дети');
                create_db('92','Размер одежды для Детей','size','Height:92');
                create_db('98','Размер одежды для Детей','size','Height:98');
                create_db('104','Размер одежды для Детей','size','Height:104');
                create_db('110','Размер одежды для Детей','size','Height:110');
                create_db('116','Размер одежды для Детей','size','Height:116');
                create_db('122','Размер одежды для Детей','size','Height:122');
                create_db('128','Размер одежды для Детей','size','Height:128');
                
            create_db('Размер обуви для детей и подростков','main','size_shoes','Дети');
                create_db('16.5 adidas','Размер обуви для детей и подростков','size','EUR_A:26.5,L_F_A:15.7,RU_A:16.5,US_A:9.5,UK_A:9K');//EUR,Length,RU,US,UK
                create_db('17 adidas','Размер обуви для детей и подростков','size','EUR_A:27,L_F_A:16.1,RU_A:17,US_A:10,UK_A:9.5K');
                create_db('26(17.5 adidas)','Размер обуви для детей и подростков','size','EUR_A:28,L_F_A:16.6,RU_A:17.5,US_A:10.5,UK_A:10K,RU_R:26,EUR_R:27,US_R:10.5,UK_R:10,L_F_R:16.5');
                create_db('27.5','Размер обуви для детей и подростков','size','EUR_A:28.5,L_F_A:17,US_A:11,UK_A:10.5,RU_R:27.5,EUR_R:27.5,US_R:11,UK_R:10.5,L_F_R:17');
                create_db('28(18 adidas)','Размер обуви для детей и подростков','size','EUR_A:29,L_F_A:17.4,RU_A:18,US_A:11.5,UK_A:11K,RU_R:28,EUR_R:28,US_R:11.5,UK_R:11,L_F_R:17.5');
                create_db('28.5(18.5 adidas)','Размер обуви для детей и подростков','size','EUR_A:30,L_F_A:17.8,RU_A:18.5,US_A:12,UK_A:11.5K,RU_R:28.5,EUR_R:29,US_R:12,UK_R:11.5,L_F_R:18');
                create_db('29','Размер обуви для детей и подростков','size','EUR_A:30.5,L_F_A:18.3,US_A:12.5,UK_A:12K,RU_R:29,EUR_R:30,US_R:12.5,UK_R:12,L_F_R:18.5');
                create_db('30(19 adidas)','Размер обуви для детей и подростков','size','EUR_A:31,L_F_A:18.7,RU_A:19,US_A:13,UK_A:12.5K,RU_R:30,EUR_R:30.5,US_R:13,UK_R:12.5,L_F_R:19');
                create_db('19.5 adidas','Размер обуви для детей и подростков','size','EUR_A:31.5,L_F_A:19.1,RU_A:19.5,US_A:13.5,UK_A:13K');
                create_db('31(20 adidas)','Размер обуви для детей и подростков','size','EUR_A:33,L_F_A:19.5,RU_A:20,US_A:1,UK_A:13.5K,RU_R:31,EUR_R:31,US_R:13.5,UK_R:13,L_F_R:19.5');
                 create_db('31.5(21 adidas)','Размер обуви для детей и подростков','size','EUR_A:33,L_F_A:20,RU_A:21,US_A:1.5,UK_A:1,RU_R:31.5,EUR_R:31.5,US_R:1,UK_R:13.5,L_F_R:20');
                create_db('32','Размер обуви для детей и подростков','size','EUR_A:33.5,L_F_A:20.4,US_A:2,UK_A:1.5,RU_R:32,EUR_R:32,US_R:1.5,UK_R:1,L_F_R:20.5');
                create_db('33(21.5 adidas)','Размер обуви для детей и подростков','size','EUR_A:34,L_F_A:20.8,RU_A:21.5,US_A:2.5,UK_A:2,RU_R:33,EUR_R:32.5,US_R:2,UK_R:1.5,L_F_R:21');
                create_db('22 adidas','Размер обуви для детей и подростков','size','EUR_A:35,L_F_A:21.2,RU_A:22,US_A:3,UK_A:2.5');
                create_db('34(22.5 adidas)','Размер обуви для детей и подростков','size','EUR_A:35.5,L_F_A:21.6,RU_A:22.5,US_A:3.5,UK_A:3,RU_R:34,EUR_R:33,US_R:2.5,UK_R:2,L_F_R:21.5');
                create_db('34.5','Размер обуви для детей и подростков','size','RU_R:34.5,EUR_R:34,US_R:3,UK_R:2.5,L_F_R:22');
                create_db('35','Размер обуви для детей и подростков','size','RU_R:35,EUR_R:34.5,US_R:3.5,UK_R:3,L_F_R:22.5');
                create_db('35.5','Размер обуви для детей и подростков','size','EUR_A:36,L_F_A:22.1,RU_A:35.5,US_A:4,UK_A:3.5');
                create_db('36','Размер обуви для детей и подростков','size','EUR_A:36 2/3,L_F_A:22.5,RU_A:36,US_A:4.5,UK_A:4,RU_R:36,EUR_R:35,US_R:4,UK_R:3.5,L_F_R:23');
                create_db('36.5','Размер обуви для детей и подростков','size','EUR_A:37 1/3,L_F_A:22.9,RU_A:36.5,US_A:5,UK_A:4.5,RU_R:36.5,EUR_R:36,US_R:4.5,UK_R:4,L_F_R:23.3');
                create_db('37','Размер обуви для детей и подростков','size','RU_R:37,EUR_R:36.5,US_R:5,UK_R:4.5,L_F_R:23.3');
                create_db('37.5','Размер обуви для детей и подростков','size','RU_R:37.5,EUR_R:37,US_R:5.5,UK_R:5,L_F_R:23.3');
                create_db('38','Размер обуви для детей и подростков','size','RU_R:38,EUR_R:38,US_R:6,UK_R:5.5,L_F_R:23.3');
                create_db('38.5','Размер обуви для детей и подростков','size','RU_R:38.5,EUR_R:38.5,US_R:6.5,UK_R:6,L_F_R:23.3');
                create_db('39','Размер обуви для детей и подростков','size','RU_R:39,EUR_R:39,US_R:7,UK_R:6.5,L_F_R:23.3');

        create_db('Малыши','main','gender','Малыши,Infants,Kids,kid');
            create_db('Размер одежды для Малышей','main','size_cloth','Малыши');
                    create_db('56','Размер одежды для Малышей','size','Height:56');
                    create_db('62','Размер одежды для Малышей','size','Height:62');
                    create_db('68','Размер одежды для Малышей','size','Height:68');
                    create_db('74','Размер одежды для Малышей','size','Height:74');
                    create_db('80','Размер одежды для Малышей','size','Height:80');
                    create_db('86','Размер одежды для Малышей','size','Height:86');
                    create_db('92','Размер одежды для Малышей','size','Height:92');
                    create_db('98','Размер одежды для Малышей','size','Height:98');
                    create_db('104','Размер одежды для Малышей','size','Height:104');

            create_db('Размер обуви для малышей','main','size_shoes','Малыши');
                create_db('13','Размер обуви для малышей','size','EUR_A:16,UK_A:0K,L_F_A:8.1');

                create_db('13.5','Размер обуви для малышей','size','EUR_A:17,US_A:1,UK_A:1K,L_F_A:9,RU_R:13.5,EUR_R:17,US_R:1,UK_R:1K,L_F_R:8');
                //create_db('14.5','Размер обуви для малышей','size','EUR_A:18,US_A:2.5,UK_A:2K,L_F_A:9.8');
                create_db('15','Размер обуви для малышей','size','RU_R:15,EUR_R:18.5,US_R:2,UK_R:2.5K,L_F_R:9');
                create_db('16.5','Размер обуви для малышей','size','EUR_A:18,US_A:2.5,UK_A:2K,L_F_A:9.8,RU_R:16.5,EUR_R:19.5,US_R:3,UK_R:3.5K,L_F_R:10');
                create_db('17','Размер обуви для малышей','size','EUR_A:19,US_A:3.5,UK_A:3K,L_F_A:10.6');
                create_db('18','Размер обуви для малышей','size','EUR_A:20,US_A:4.5,UK_A:4K,L_F_A:11.5,RU_R:18,EUR_R:21,US_R:4,UK_R:5K,L_F_R:11');
                create_db('19.5','Размер обуви для малышей','size','EUR_A:21,US_A:5.5,UK_A:5K,L_F_A:12.3,RU_R:19.5,EUR_R:22,US_R:5.5,UK_R:5.5K,L_F_R:12');
                create_db('21','Размер обуви для малышей','size','EUR_A:22,US_A:6,UK_A:5.5K,L_F_A:12.8,RU_R:21,EUR_R:23.5,US_R:6,UK_R:6.5K,L_F_R:13');
                create_db('21.5','Размер обуви для малышей','size','EUR_A:23,US_A:6.5,UK_A:6K,L_F_A:13.2');
                create_db('22','Размер обуви для малышей','size','EUR_A:23.5,US_A:7,UK_A:6.5K,L_F_A:13.6');
                create_db('22.5','Размер обуви для малышей','size','EUR_A:24,US_A:7.5,UK_A:7K,L_F_A:14,RU_R:22.5,EUR_R:24.5,US_R:8,UK_R:7.5K,L_F_R:14');
                create_db('23','Размер обуви для малышей','size','EUR_A:25,US_A:8,UK_A:7.5K,L_F_A:14.5');
                create_db('24','Размер обуви для малышей','size','EUR_A:25.5,US_A:8.5,UK_A:8K,L_F_A:14.9,RU_R:24,EUR_R:25.5,US_R:8.5,UK_R:8K,L_F_R:15');

                create_db('24.5','Размер обуви для малышей','size','EUR_A:26,US_A:9,UK_A:8.5K,L_F_A:15.3');
                create_db('25','Размер обуви для малышей','size','EUR_A:26.5,US_A:9.5,UK_A:9K,L_F_A:15.7');
                create_db('25.5','Размер обуви для малышей','size','EUR_A:27,US_A:10,UK_A:9.5K,L_F_A:16.1,RU_R:25.5,EUR_R:26.5,US_R:9.5,UK_R:9.5K,L_F_R:16');
            
        create_db('Мальчики','main','gender','Мальчики,Мальчикам,Boy,boys');
        create_db('Девочки','main','gender','Девочки,Девочкам,girl,girls');
        create_db('Унисекс','main','gender','Unisex,Унисекс');
        create_db('Прочее','main','gender','');

        create_db('Неопределенный размер','main','size','');
        init();
        // create_db('Размер обуви для Женщин','main','size_shoes','Женщины');
            //     create_db('35.5','Размер обуви для Женщин','size','35.5,36,3.5,5,22.1');//RU,EUR(FR),US,UK,Длина стопы
            //     create_db('36','Размер обуви для Женщин','size','36,36 2/3,5.5,4,22.5');
            //     create_db('36.5','Размер обуви для Женщин','size','36.5,37 1/3,6,4.5,22.9');
            //     create_db('37','Размер обуви для Женщин','size','37,38,6.5,5,23.3');
            //     create_db('37.5','Размер обуви для Женщин','size','37.5,38 2/3,7,5.5,23.8');
            //     create_db('38','Размер обуви для Женщин','size','38,39 1/3,7.5,6,24.2');
            //     create_db('38,5','Размер обуви для Женщин','size','38.5,40,8,6.5,24.6');
            //     create_db('39','Размер обуви для Женщин','size','39,40,8.5,6.5,24.6');
            //     create_db('40','Размер обуви для Женщин','size','40,41 1/3,9,7.5,25.5');
            //     create_db('40.5','Размер обуви для Женщин','size','40.5,42,9.5,8,25.9');//тут остановился
            //     create_db('41','Размер обуви для Женщин','size','41,42 2/3,10,8.5,26.3');
            //     create_db('42','Размер обуви для Женщин','size','42,43 1/3,10.5,9,26.7');
            //     create_db('42.5','Размер обуви для Женщин','size','42.5,44,11,9.5,27.1');
            //     create_db('43','Размер обуви для Женщин','size','43,44 2/3,11.5,10,27.6');
            //     create_db('44','Размер обуви для Женщин','size','44,45 1/3,12,10.5,28');
            //     create_db('44.5','Размер обуви для Женщин','size','44.5,46,12.5,11,28.4');
            //     create_db('45','Размер обуви для Женщин','size','45,46 2/3,13,11.5,28.8');

        //Совместимость размеров верх
            // create_db('Размер для детей','main','size_cloth','Дети,Девочки,Мальчики,Infants');
            //     create_db('28|30(3T-4T)','Размер для детей','size','28|30,98,104');
            //     create_db('30(XS)','Размер для детей','size','30,110');
            //     create_db('32(XS)','Размер для детей','size','32,116');
            //     create_db('32|34(XS)','Размер для детей','size','32|34,122');
            //     create_db('34(XS)','Размер для детей','size','128,34');
            //     create_db('36(S)','Размер для детей','size','134,36');
            //     create_db('38(S)','Размер для детей','size','140');
            //     create_db('38|40(S/M)','Размер для детей','size','146,38|40');
            //     create_db('40(M/L)','Размер для детей','size','152,40');
            //     create_db('40|42(L)','Размер для детей','size','156,40|42,158,164');
            //     create_db('42(XL)','Размер для детей','size','170,176');


            // create_db('Размер для взрослых','main','size_cloth','Мужчины,Женщины,Унисекс');
            //     create_db('40|42(XS)','Размер для взрослых','size','40|42,XS');
            //     create_db('44|46(S)','Размер для взрослых','size','S,44|46');
            //     create_db('48|50(M)','Размер для взрослых','size','M,48|50');
            //     create_db('52|54(L)','Размер для взрослых','size','52|54,L');
            //     create_db('56|58(XL)','Размер для взрослых','size','XL,56|58');
            //     create_db('60|62(2XL)','Размер для взрослых','size','2XL,60|62');
            //     create_db('64|66(3XL)','Размер для взрослых','size','3XL,64|66');
            //     create_db('40|42(XST) для высоких','Размер для взрослых','size','XST');
            //     create_db('44|46(ST) для высоких','Размер для взрослых','size','ST');
            //     create_db('48|50(MT) для высоких','Размер для взрослых','size','MT');
            //     create_db('52|54(LT) для высоких','Размер для взрослых','size','LT');
            //     create_db('56|58(XLT) для высоких','Размер для взрослых','size','XLT');
            //     create_db('60|62(2XLT) для высоких','Размер для взрослых','size','2XLT');
            //     create_db('64|66(3XLT) для высоких','Размер для взрослых','size','3XLT');

        // create_db('Размер обуви для детей до 7','main','size_shoes','Infants');
        //     create_db('16','Размер обуви для детей до 7','size','16,0.5');
        //     create_db('16.5','Размер обуви для детей до 7','size','16.5,1');
        //     create_db('17','Размер обуви для детей до 7','size','17,1-');
        //     create_db('17.5','Размер обуви для детей до 7','size','17.5,2');
        //     create_db('18','Размер обуви для детей до 7','size','18,2-');
        //     create_db('18.5','Размер обуви для детей до 7','size','18.5,3');
        //     create_db('19','Размер обуви для детей до 7','size','19,3-');
        //     create_db('19.5','Размер обуви для детей до 7','size','19.5,4');
        //     create_db('20','Размер обуви для детей до 7','size','20,4-');
        //     create_db('20.5','Размер обуви для детей до 7','size','20.5,5');
        //     create_db('21','Размер обуви для детей до 7','size','21,21.5,5-');
        //     create_db('22','Размер обуви для детей до 7','size','22,6');
        //     create_db('22.5','Размер обуви для детей до 7','size','22.5,6-');
        //     create_db('23','Размер обуви для детей до 7','size','23,7');
        //     create_db('23.5','Размер обуви для детей до 7','size','23.5,7-');
        //     create_db('24','Размер обуви для детей до 7','size','24,8,24.5');
        //     create_db('25','Размер обуви для детей до 7','size','25,8-');
        //     create_db('25.5','Размер обуви для детей до 7','size','25.5,9');
        //     create_db('26','Размер обуви для детей до 7','size','26,26.5,9-');
        //     create_db('27','Размер обуви для детей до 7','size','27,10');
        //     create_db('27.5','Размер обуви для детей до 7','size','27.5,10-');
        //     create_db('28','Размер обуви для детей до 7','size','28,11');
        //     create_db('28.5','Размер обуви для детей до 7','size','28.5,29,11-');
        //     create_db('30','Размер обуви для детей до 7','size','30,29.5,12');
        //     create_db('30.5','Размер обуви для детей до 7','size','30.5,12-');
        //     create_db('31','Размер обуви для детей до 7','size','31,13');
        //     create_db('31.5','Размер обуви для детей до 7','size','31.5,13-');

        // create_db('Размер обуви для детей от 7 до 10','main','size_shoes','Дети,Мальчики,Девочки');
        //     create_db('32','Размер обуви для детей от 7 до 10','size','32,32.5,1');
        //     create_db('33','Размер обуви для детей от 7 до 10','size','33,1-');
        //     create_db('33.5','Размер обуви для детей от 7 до 10','size','33.5,2');
        //     create_db('34','Размер обуви для детей от 7 до 10','size','34,2-');
        //     create_db('34.5','Размер обуви для детей от 7 до 10','size','34.5,3');
        //     create_db('35','Размер обуви для детей от 7 до 10','size','35,35.5,3-');
        //     create_db('36','Размер обуви для детей от 7 до 10','size','36,4');
        //     create_db('36.5','Размер обуви для детей от 7 до 10','size','36.5,4-');
        //     create_db('37','Размер обуви для детей от 7 до 10','size','37,5');
        //     create_db('37.5','Размер обуви для детей от 7 до 10','size','37.5,29,5-');
        //     create_db('38','Размер обуви для детей от 7 до 10','size','38,6');
        //     create_db('38.5','Размер обуви для детей от 7 до 10','size','38.5,6-');


        // create_db('Размер обуви для Мужчин','main','size_shoes','Мужчины,Унисекс');
        //     create_db('39','Размер обуви для Мужчин','size','39,7');
        //     create_db('39.5','Размер обуви для Мужчин','size','39.5,7-');
        //     create_db('40','Размер обуви для Мужчин','size','40,8');
        //     create_db('40.5','Размер обуви для Мужчин','size','40.5,8-');
        //     create_db('41','Размер обуви для Мужчин','size','41,9');
        //     create_db('41.5','Размер обуви для Мужчин','size','41.5,9-');
        //     create_db('42','Размер обуви для Мужчин','size','42,10');
        //     create_db('42.5','Размер обуви для Мужчин','size','42.5,10-');
        //     create_db('43','Размер обуви для Мужчин','size','43,11');
        //     create_db('43.5','Размер обуви для Мужчин','size','43.5,11-');
        //     create_db('44','Размер обуви для Мужчин','size','44,12,12-');
        //     create_db('45','Размер обуви для Мужчин','size','45,45.5,13,13-');
        //     create_db('46','Размер обуви для Мужчин','size','46,46.5,14,14-');
        //     create_db('47','Размер обуви для Мужчин','size','47,47.5,15,15-');
        //     create_db('48','Размер обуви для Мужчин','size','48,48.5');
        //     create_db('49','Размер обуви для Мужчин','size','49,49.5');
        //     create_db('50-55','Размер обуви для Мужчин','size','50,51,52,53,54,55');
        //     create_db('56-60','Размер обуви для Мужчин','size','56,57,58,59,60');


        // create_db('Размер обуви для Женщин','main','size_shoes','Женщины');
        //     create_db('34','Размер обуви для Женщин','size','34,5');
        //     create_db('34.5','Размер обуви для Женщин','size','34.5,5-');
        //     create_db('35','Размер обуви для Женщин','size','35,35.5,6');
        //     create_db('36','Размер обуви для Женщин','size','36,6-');
        //     create_db('36.5','Размер обуви для Женщин','size','36.5,7');
        //     create_db('37','Размер обуви для Женщин','size','37,7-');
        //     create_db('37.5','Размер обуви для Женщин','size','37.5,8');
        //     create_db('38','Размер обуви для Женщин','size','38,38.5,8-');
        //     create_db('39','Размер обуви для Женщин','size','39,9');
        //     create_db('39.5','Размер обуви для Женщин','size','39.5,9-');
        //     create_db('40','Размер обуви для Женщин','size','40,40.5,10');
        //     create_db('41','Размер обуви для Женщин','size','41,10-');
        //     create_db('41.5','Размер обуви для Женщин','size','41.5,11');
        //     create_db('42','Размер обуви для Женщин','size','42,11-');
        //     create_db('42.5','Размер обуви для Женщин','size','42.5,12');
        //     create_db('43','Размер обуви для Женщин','size','43,43.5,12-,13');
        //     create_db('44','Размер обуви для Женщин','size','44,44.5,13-,14');
        //     create_db('45','Размер обуви для Женщин','size','45,45.5,14-,15');
        //     create_db('46-50','Размер обуви для Женщин','size','46,47,48,49,50');

        // function create_db_shoes_men($RU,$param,$RU_adidas,$EUR_men_adidas,$UK_men_adidas,$US_men_adidas,$Length_foot_adidas,$RU_reebok,$EUR_men_reebok,$UK_men_reebok,$US_men_reebok,$Length_foot_reebok){
        //     $size=R::dispense('categories');
        //     $size->parent_id=R::findOne('categories','name = ?',array($param))->id;
        //     $size->describtion=$size;
        //     $size->ru=$ru;
        //     $size->RU_adidas=$RU_adidas;
        //     $size->EUR_men_adidas=$EUR_men_adidas;
        //     $size->UK_men_adidas=$UK_men_adidas;
        //     $size->US_men_adidas=$US_men_adidas;
        //     $size->Length_foot_adidas=$Length_foot_adidas;

        //     $size->RU_reebok=$RU_reebok;
        //     $size->EUR_men_reebok=$EUR_men_reebok;
        //     $size->UK_men_reebok=$UK_men_reebok;
        //     $size->US_men_reebok=$US_men_reebok;
        //     $size->Length_foot_reebok=$Length_foot_reebok;
        //     R::store($size);
        // }
        // function create_db_shoes($RU,$param,$RU_adidas,$EUR_men_adidas,$EUR_women_adidas,$EUR_teenager_adidas,$EUR_children_adidas,$EUR_kids_adidas,$UK_men_adidas,$UK_women_adidas,$UK_teenager_adidas,$UK_children_adidas,$UK_kids_adidas,$US_men_adidas,$US_women_adidas,$US_teenager_adidas,$US_children_adidas,$US_kids_adidas,$Length_foot_adidas,$RU_reebok,$EUR_men_reebok,$EUR_women_reebok,$EUR_teenager_reebok,$EUR_children_reebok,$EUR_kids_reebok,$UK_men_reebok,$UK_women_reebok,$UK_teenager_reebok,$UK_children_reebok,$UK_kids_reebok,$US_men_reebok,$US_women_reebok,$US_teenager_reebok,$US_children_reebok,$US_kids_reebok,$Length_foot_reebok){
        //     $size=R::dispense('categories');
        //     $size->ru=$ru;
        //     $size->RU_adidas=$RU_adidas;
        //     $size->EUR_men_adidas=$EUR_men_adidas;
        //     $size->EUR_women_adidas=$EUR_women_adidas;
        //     $size->EUR_teenager_adidas=$EUR_teenager_adidas;
        //     $size->EUR_children_adidas=$EUR_children_adidas;
        //     $size->EUR_kids_adidas=$EUR_kids_adidas;
        //     $size->UK_men_adidas=$UK_men_adidas;
        //     $size->UK_women_adidas=$UK_women_adidas;
        //     $size->UK_teenager_adidas=$UK_teenager_adidas;
        //     $size->UK_kids_adidas=$UK_kids_adidas;
        //     $size->UK_children_adidas=$UK_children_adidas;
        //     $size->US_men_adidas=$US_men_adidas;
        //     $size->US_women_adidas=$US_women_adidas;
        //     $size->US_teenager_adidas=$US_teenager_adidas;
        //     $size->US_children_adidas=$US_teenager_adidas;
        //     $size->US_kids_adidas=$US_kids_adidas;
        //     $size->Length_foot_adidas=$Length_foot_adidas;

        //     $size->RU_reebok=$RU_reebok;
        //     $size->EUR_men_reebok=$EUR_men_reebok;
        //     $size->EUR_women_reebok=$EUR_women_reebok;
        //     $size->EUR_teenager_reebok=$EUR_teenager_reebok;
        //     $size->EUR_children_reebok=$EUR_children_reebok;
        //     $size->EUR_kids_reebok=$EUR_kids_reebok;
        //     $size->UK_men_reebok=$UK_men_reebok;
        //     $size->UK_women_reebok=$UK_women_reebok;
        //     $size->UK_teenager_reebok=$UK_teenager_reebok;
        //     $size->UK_kids_reebok=$UK_kids_reebok;
        //     $size->UK_children_reebok=$UK_children_reebok;
        //     $size->US_men_reebok=$US_men_reebok;
        //     $size->US_women_reebok=$US_women_reebok;
        //     $size->US_teenager_reebok=$US_teenager_reebok;
        //     $size->US_children_reebok=$US_teenager_reebok;
        //     $size->US_kids_reebok=$US_kids_reebok;
        //     $size->Length_foot_reebok=$Length_foot_reebok;
        //     R::store($size);
        // }

        //create_db_shoes('40','40','41 2/3','8','9','7-','25.5','40','25.5','7.5','6.5','-');

    ?>