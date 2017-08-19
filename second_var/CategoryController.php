<?php

namespace app\controllers;
use app\models\Category;
use app\models\Product;
use Yii;
use yii\data\Pagination;

class CategoryController extends AppController {
    public function actionIndex(){
        $Caps = Product::find()->where(['<>','photo', 'No photo yet'])->groupBy('photo')->limit(9)->all();

        $hot = Product::find()->where(['id' => 5886])->one();
        $name=Yii::$app->session->get('username');
        return $this->render('index',compact('Caps','hot','name'));
    }

    public function actionCreateTable(){
        return $this->render('createTable');
    }

    public function actionView($col,$spo,$gen,$brand,$size,$type,$byprice){
        $byprice = Yii::$app->request->get('byprice');
        $col = Yii::$app->request->get('col');
        $spo = Yii::$app->request->get('spo');
        $gen = Yii::$app->request->get('gen');
        $brand = Yii::$app->request->get('brand');
        $size = Yii::$app->request->get('size');
        $type = Yii::$app->request->get('type');
        $where='id != 0';
        $where_selected='id = 0';

        if($col!=0){
            $where_selected.=' OR id = '.$col;
            $where.=' AND col_id = '.$col;
        }
        if($spo!=0){
            $where_selected.=' OR id = '.$spo;
            $where.=' AND sport_id ='.$spo;
        }
        if($type!=0){
            $true_type=Category::find()->where(['id' => $type])->andwhere(['describtion' => 'type'])->one();
            if($type==$true_type->id){
                $where.=' AND type_id = '.$type;
                $where_selected.=' OR id = '.$type;
            }

            $sub=Category::find()->where(['id' => $type])->one();
            $type_id=$sub->parent_id;
            $all_products_by_type=$type_id+1;
            if($type==$all_products_by_type){
                $where.=' AND type_id = '.$type_id;
                $where_selected.=' OR id = '.$type_id;
            }
            else{
                $where_selected.=' OR id = '.$type_id;
                $where_selected.=' OR id = '.$type;
                $where.=' AND sub_type_id = '.$type;
            }
        }
        if($gen!=0){
            $where_selected.=' OR id = '.$gen;
            $where.=' AND gender_id = '.$gen;
        }
        if($brand!=0){
            $where_selected.=' OR id = '.$brand;
            $where.=' AND brand_id = '.$brand;
        }
        if($size!=0){
            $where_selected.=' OR id = '.$size;
            $where.=' AND (size_id_1 = '.$size.' OR size_id_2 = '.$size.' OR size_id_3 = '.$size.' OR size_id_4 = '.$size.' OR size_id_5 = '.$size.' OR size_id_6 = '.$size.' OR size_id_7 = '.$size.' OR size_id_8 = '.$size.' OR size_id_9 = '.$size.' OR size_id_10 = '.$size.')';
        }

        if($byprice==1){
            $query=Product::find()->where($where)->andwhere(['<>','photo', 'No photo yet'])->groupBy('photo')->orderBy('price_sell');
            $pages= new Pagination(['totalCount' => $query->count(), 'pageSize' => 12,'forcePageParam' => false,'pageSizeParam' => false]);
            $products = $query->offset($pages->offset)->limit($pages->limit)->all();
        }
        else{
            $query=Product::find()->where($where)->andwhere(['<>','photo', 'No photo yet'])->groupBy('photo');
            $pages= new Pagination(['totalCount' => $query->count(), 'pageSize' => 12,'forcePageParam' => false,'pageSizeParam' => false]);
            $products = $query->offset($pages->offset)->limit($pages->limit)->all();
        }
        
        // if($brand!=0){
        //     $tees=Product::find()->where(['size_brand_id'=>$brand,'type_id'=>34])->andwhere(['<>','photo_1', 'No photo yet'])->groupBy('photo_1')->limit(4)->all();
        //     $hoods=Product::find()->where(['size_brand_id'=>$brand,'type_id'=>43])->andwhere(['<>','photo_1', 'No photo yet'])->groupBy('photo_1')->limit(4)->all();
        //     $pants=Product::find()->where(['size_brand_id'=>$brand,'type_id'=>51])->andwhere(['<>','photo_1', 'No photo yet'])->groupBy('photo_1')->limit(4)->all();
        //     $shorts=Product::find()->where(['size_brand_id'=>$brand,'type_id'=>62])->andwhere(['<>','photo_1', 'No photo yet'])->groupBy('photo_1')->limit(4)->all();
        //     $jackets=Product::find()->where(['size_brand_id'=>$brand,'type_id'=>65])->andwhere(['<>','photo_1', 'No photo yet'])->groupBy('photo_1')->limit(4)->all();
        // }
        // else{
        //     $tees=Product::find()->where(['type_id'=>34])->andwhere(['<>','photo_1', 'No photo yet'])->groupBy('photo_1')->limit(4)->all();
        //     $hoods=Product::find()->where(['type_id'=>43])->andwhere(['<>','photo_1', 'No photo yet'])->groupBy('photo_1')->limit(4)->all();
        //     $pants=Product::find()->where(['type_id'=>51])->andwhere(['<>','photo_1', 'No photo yet'])->groupBy('photo_1')->limit(4)->all();
        //     $shorts=Product::find()->where(['type_id'=>62])->andwhere(['<>','photo_1', 'No photo yet'])->groupBy('photo_1')->limit(4)->all();
        //     $jackets=Product::find()->where(['type_id'=>65])->andwhere(['<>','photo_1', 'No photo yet'])->groupBy('photo_1')->limit(4)->all();
        // }

        $selected=Category::find()->where($where_selected)->all();
        $button='<div class="right">
                    <span>Сортировать по:</span><br>
                    <a href="/category/'.$col.'/'.$spo.'/'.$gen.'/'.$brand.'/'.$size.'/'.$type.'/0#selectedcat" title="" rel="nofollow">Популярности</a>         
                    <a href="/category/'.$col.'/'.$spo.'/'.$gen.'/'.$brand.'/'.$size.'/'.$type.'/1#selectedcat" title="" rel="nofollow">Цене</a>
                    <div class="clear"></div>
                </div>';
        $url='/category/'.$col.'/'.$spo.'/'.$gen.'/'.$brand.'/'.$size.'/'.$type.'/'.$byprice;
        return $this->render('view',compact('pages','products','button','selected'));
    }
    public function actionSearch(){
        $q = Yii::$app->request->get('q');
        $query = Product::find()->where(['like','name',$q])->orwhere(['=','article',$q])->orwhere(['like','gender_name',$q])->orwhere(['like','col_name',$q])->orwhere(['=','brand',$q])->orwhere(['like','sport_name',$q])->orwhere(['like','type_name',$q])->orwhere(['=','sub_type_name',$q])->andwhere(['<>','photo', 'No photo yet'])->groupBy('photo');
        $pages= new Pagination(['totalCount' => $query->count(), 'pageSize' => 15,'forcePageParam' => false,'pageSizeParam' => false]);
        $products = $query->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('search',compact('products','pages','q'));
    }
}