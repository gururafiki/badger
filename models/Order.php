<?php

namespace app\models;
use yii\db\ActiveRecord;
class Order extends  ActiveRecord{

    public static function tableName(){
        return 'orders';
    }

    public function getCategory(){
        return $this->hasOne(Client::className(),['id' => 'client_id']);
    }
}