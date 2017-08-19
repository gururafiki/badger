<?php

namespace app\controllers;
use app\models\Category;
use app\models\Product;
use Yii;
use yii\data\Pagination;

class CategoryController extends AppController {
    public function actionIndex(){
        $Caps = Product::find()->where(['type_id' => 94])->limit(6)->all();

        $Hot = Product::find()->where(['id' => 5886])->one();
        return $this->render('index',compact('Caps','Hot'));
    }

    public function actionCreateTable(){
        return $this->render('createTable');
    }

    public function actionView($col,$spo,$gen,$cloth,$shoes,$type,$byprice){
        $byprice = Yii::$app->request->get('byprice');
        $col = Yii::$app->request->get('col');
        $spo = Yii::$app->request->get('spo');
        $gen = Yii::$app->request->get('gen');
        $cloth = Yii::$app->request->get('cloth');
        $shoes = Yii::$app->request->get('shoes');
        $type = Yii::$app->request->get('type');
        $where='id != 0';
        if($col!=0){
            $where.=' AND col_id = '.$col;
        }
        if($spo!=0){
            $where.=' AND sport_id ='.$spo;
        }
        if($type!=0){
            $sub=Category::find()->where(['id' => $type])->one();
            $type_id=$sub->parent_id;
            $all_products_by_type=$type_id+1;
            if($type==$all_products_by_type){
                $where.=' AND type_id = '.$type_id;
            }
            else{
                $where.=' AND sub_type_id = '.$type;
            }
        }
        if($gen!=0){
            $where.=' AND gender_id = '.$gen;
        }
        if($cloth!=0){
            $where.=' AND size_cloth_id = '.$cloth;
        }
        if($shoes!=0){
            $where.=' AND size_shoes_id = '.$shoes;
        }
        if($byprice==1){
        //     $query= Product::find()->where();
        // $pages= new Pagination(['totalCount' => $query->count(), 'pageSize' => 3,'forcePageParam' => false,'pageSizeParam' => false]);
        // $products = $query->offset($pages->offset)->limit($pages->limit)->all();
            $query=Product::find()->where($where)->andwhere(['<>','photo_1', 'No photo yet'])->orderBy('price_sell');
            $pages= new Pagination(['totalCount' => $query->count(), 'pageSize' => 12,'forcePageParam' => false,'pageSizeParam' => false]);
            $products = $query->offset($pages->offset)->limit($pages->limit)->all();
        }
        else{
            $query=Product::find()->where($where)->andwhere(['<>','photo_1', 'No photo yet']);  
            $pages= new Pagination(['totalCount' => $query->count(), 'pageSize' => 12,'forcePageParam' => false,'pageSizeParam' => false]);
            $products = $query->offset($pages->offset)->limit($pages->limit)->all();
        }
        
        if($cloth!=0){
            $tees=Product::find()->where(['size_cloth_id'=>$cloth,'type_id'=>34])->andwhere(['<>','photo_1', 'No photo yet'])->limit(4)->all();
            $hoods=Product::find()->where(['size_cloth_id'=>$cloth,'type_id'=>43])->andwhere(['<>','photo_1', 'No photo yet'])->limit(4)->all();
            $pants=Product::find()->where(['size_cloth_id'=>$cloth,'type_id'=>51])->andwhere(['<>','photo_1', 'No photo yet'])->limit(4)->all();
            $shorts=Product::find()->where(['size_cloth_id'=>$cloth,'type_id'=>62])->andwhere(['<>','photo_1', 'No photo yet'])->limit(4)->all();
            $jackets=Product::find()->where(['size_cloth_id'=>$cloth,'type_id'=>65])->andwhere(['<>','photo_1', 'No photo yet'])->limit(4)->all();
        }
        else{
            $tees=Product::find()->where(['type_id'=>34])->andwhere(['<>','photo_1', 'No photo yet'])->limit(4)->all();
            $hoods=Product::find()->where(['type_id'=>43])->andwhere(['<>','photo_1', 'No photo yet'])->limit(4)->all();
            $pants=Product::find()->where(['type_id'=>51])->andwhere(['<>','photo_1', 'No photo yet'])->limit(4)->all();
            $shorts=Product::find()->where(['type_id'=>62])->andwhere(['<>','photo_1', 'No photo yet'])->limit(4)->all();
            $jackets=Product::find()->where(['type_id'=>65])->andwhere(['<>','photo_1', 'No photo yet'])->limit(4)->all();
        }
        return $this->render('view',compact('pages','products','rec','tees','hoods','pants','shorts','jackets'));
    }
}