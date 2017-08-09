<?php

namespace app\models;
use yii\db\ActiveRecord;
class Client extends  ActiveRecord{
public $name;
public $password;
public $email;
public $phone ;
public $postcode;
public $city='sdasd';
public $adress;
    public static function tableName(){
        return 'clients';
    }

    public function getOrders(){
        return $this->hasMany(Order::className(),['client_id' => 'id']);
    }
}