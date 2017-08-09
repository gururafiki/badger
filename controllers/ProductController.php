<?php

namespace app\controllers;
use app\models\Category;
use app\models\Product;
use Yii;

class ProductController extends AppController {

    public function actionView($id){
        $id = Yii::$app->request->get('id');
        $product = Product::find()->where(['id' => $id])->one();
        if($product->other_colours!='{"":10}') {
            $articles[]=$product->article;
            foreach (json_decode($product->other_colours) as $key => $value) {
                if($key!='_empty_' && $key!=$product->article)
                    $articles[] = $key;
            }
            $query=Product::find();
            unset( $articles[0]);
            if (!empty( $articles)) {
                foreach ( $articles as $key) {
                    $query->orWhere(['article' => $key]);
                }
                $other_colours = $query->andWhere(['<>','photo', 'No photo yet'])->all();
            }
        }
        $query=Category::find();
        $flag=false;
        if($product->size_id_1!='empty'){
            $flag=true;
            $query=$query->where(['id' => $product->size_id_1]);
        }
        if($product->size_id_2!='empty'){
            $flag=true;
            $query=$query->orWhere(['id' => $product->size_id_2]);
        }
        if($product->size_id_3!='empty'){
            $flag=true;
            $query=$query->orWhere(['id' => $product->size_id_3]);
        }
        if($product->size_id_4!='empty'){
            $flag=true;
            $query=$query->orWhere(['id' => $product->size_id_4]);
        }
        if($product->size_id_5!='empty'){
            $flag=true;
            $query=$query->orWhere(['id' => $product->size_id_5]);
        }
        if($product->size_id_6!='empty'){
            $flag=true;
            $query=$query->orWhere(['id' => $product->size_id_6]);
        }
        if($product->size_id_7!='empty'){
            $flag=true;
            $query=$query->orWhere(['id' => $product->size_id_7]);
        }
        if($product->size_id_8!='empty'){
            $flag=true;
            $query=$query->orWhere(['id' => $product->size_id_8]);
        }
        if($product->size_id_9!='empty'){
            $flag=true;
            $query=$query->orWhere(['id' => $product->size_id_9]);
        }
        if($product->size_id_10!='empty'){
            $flag=true;
            $query=$query->orWhere(['id' => $product->size_id_10]);
        }
        if($product->size_id_11!='empty'){
            $flag=true;
            $query=$query->orWhere(['id' => $product->size_id_11]);
        }
        if($product->size_id_12!='empty'){
            $flag=true;
            $query=$query->orWhere(['id' => $product->size_id_12]);
        }
        if($product->size_id_13!='empty'){
            $flag=true;
            $query=$query->orWhere(['id' => $product->size_id_13]);
        }
        if($product->size_id_14!='empty'){
            $flag=true;
            $query=$query->orWhere(['id' => $product->size_id_14]);
        }
        if($product->size_id_15!='empty'){
            $flag=true;
            $query=$query->orWhere(['id' => $product->size_id_15]);
        }
        if($product->size_id_16!='empty'){
            $flag=true;
            $query=$query->orWhere(['id' => $product->size_id_16]);
        }
        if($product->size_id_17!='empty'){
            $flag=true;
            $query=$query->orWhere(['id' => $product->size_id_17]);
        }
        if($product->size_id_18!='empty'){
            $flag=true;
            $query=$query->orWhere(['id' => $product->size_id_18]);
        }
        if($product->size_id_19!='empty'){
            $flag=true;
            $query=$query->orWhere(['id' => $product->size_id_19]);
        }
        if($product->size_id_20!='empty'){
            $flag=true;
            $query=$query->orWhere(['id' => $product->size_id_20]);
        }
        if($product->size_id_21!='empty'){
            $flag=true;
            $query=$query->orWhere(['id' => $product->size_id_21]);
        }
        if($product->size_id_22!='empty'){
            $flag=true;
            $query=$query->orWhere(['id' => $product->size_id_22]);
        }
        if($product->size_id_23!='empty'){
            $flag=true;
            $query=$query->orWhere(['id' => $product->size_id_23]);
        }
        if($product->size_id_24!='empty'){
            $flag=true;
            $query=$query->orWhere(['id' => $product->size_id_24]);
        }
        if($product->size_id_25!='empty'){
            $flag=true;
            $query=$query->orWhere(['id' => $product->size_id_25]);
        }
        if($product->size_id_26!='empty'){
            $flag=true;
            $query=$query->orWhere(['id' => $product->size_id_26]);
        }
        if($product->size_id_27!='empty'){
            $flag=true;
            $query=$query->orWhere(['id' => $product->size_id_27]);
        }
        if($product->size_id_28!='empty'){
            $flag=true;
            $query=$query->orWhere(['id' => $product->size_id_28]);
        }
        if($product->size_id_29!='empty'){
            $flag=true;
            $query=$query->orWhere(['id' => $product->size_id_29]);
        }
        if($product->size_id_30!='empty'){
            $flag=true;
            $query=$query->orWhere(['id' => $product->size_id_30]);
        }
        if($flag==true){
            $Sizes=$query->all();
            $i=0;
            foreach ($Sizes as $size) {
                $i++;
                $j = 0;
                if ($size->keyword_1 != '') {
                    $j++;
                    $size_names[$i][$j] = $size->keyword_1;
                }
                if ($size->keyword_2 != '') {
                    $j++;
                    $size_names[$i][$j] = $size->keyword_2;
                }
                if ($size->keyword_3 != '') {
                    $j++;
                    $size_names[$i][$j] = $size->keyword_3;
                }
                if ($size->keyword_4 != '') {
                    $j++;
                    $size_names[$i][$j] = $size->keyword_4;
                }
                if ($size->keyword_5 != '') {
                    $j++;
                    $size_names[$i][$j] = $size->keyword_5;
                }
                if ($size->keyword_6 != '') {
                    $j++;
                    $size_names[$i][$j] = $size->keyword_6;
                }
                if ($size->keyword_7 != '') {
                    $j++;
                    $size_names[$i][$j] = $size->keyword_7;
                }
                if ($size->keyword_8 != '') {
                    $j++;
                    $size_names[$i][$j] = $size->keyword_8;
                }
                if ($size->keyword_9 != '') {
                    $j++;
                    $size_names[$i][$j] = $size->keyword_9;
                }
                if ($size->keyword_10 != '') {
                    $j++;
                    $size_names[$i][$j] = $size->keyword_10;
                }
                if ($size->keyword_11 != '') {
                    $j++;
                    $size_names[$i][$j] = $size->keyword_11;
                }
                if ($size->keyword_12 != '') {
                    $j++;
                    $size_names[$i][$j] = $size->keyword_12;
                }
            }
        }
        return $this->render('view',compact('product','articles','other_colours','size_names','Sizes'));
    }
}