<?php

namespace app\components;
use yii\base\Widget;
use yii\db\ActiveRecord;
use app\models\Category;
use app\models\Product;


class NavigationBar extends  Widget{

    public $tpl;
    public $data;
    public $tree;
    public $menuHtml;
    public $url;
    public function init(){
        parent::init();
        if( $this->tpl === null){
            $this->tpl='navbar';
        }
        $this->tpl.='.php';
    }

    public function run(){
        $this->menuHtml='';
        $gender = Category::find()->where(['name' => ['Мужчины','Женщины','Дети']])->andWhere(['describtion' =>['gender']])->all();
        foreach ($gender as $key) {
            $gender_id=$key->id;
            $gender_name=$key->name;
            $brand_id=0;
            $brand_name='';
            $start='<li class="listnav"><span class="nav marginnav">'.$gender_name.'</span>
                        <ul class="listcolumn marginlistcolumn">
                            <li class="columnnav">
                                <h4>'.$gender_name.' Одежда</h4>';
            $end='          </li>';
            $last='     </ul>
                    </li>';
            $this->data = Category::find()->indexBy('id')->where(['describtion' => ['type']])->andwhere(['<>','name', 'Обувь'])->andwhere(['<>','name', 'Аксессуары'])->asArray()->all();
            $this->tree = $this->getTree();
            $this->menuHtml = $this->menuHtml.$start.$this->getMenuHtml($this->tree,$gender_name,$gender_id,$brand_name,$brand_id,1,0).$end;

            $excepted=Category::find()->where(['name' => ['Обувь','Аксессуары']])->andWhere(['describtion' =>['type']])->all();
            foreach ($excepted as $except) { 
                if(!($except->name=='Аксессуары' && $gender_name=='Дети')){
                    $start='        <li class="columnnav">
                                        <h4>'.$gender_name.' '.$except->name.'</h4>';
                    $this->data = Category::find()->indexBy('id')->where(['parent_id' => $except->id])->asArray()->all();
                    $this->tree = $this->getTree();
                    $this->menuHtml = $this->menuHtml.$start.$this->getMenuHtml($this->tree,$gender_name,$gender_id,$brand_name,$brand_id,0,0).$end;
                }
            }
            $this->menuHtml.=$last;
        }

        $gender_id=0;
        $gender_name=0;

        $brand_id=1;
        $brand_name='adidas';

        $start='<li class="listnav"><span class="nav marginnav">'.$brand_name.'</span>
                    <ul class="listcolumn marginlistcolumn">
                        <li class="columnnav">
                            <h4>Колекции '.$brand_name.'</h4>';
        $end='          </li>';
        $last='     </ul>
                </li>';
        $this->data = Category::find()->indexBy('id')->where(['describtion' => ['brand']])->asArray()->all();
        $this->tree = $this->getTree();
        $this->menuHtml = $this->menuHtml.$start.$this->getMenuHtml($this->tree,$gender_name,$gender_id,$brand_name,$brand_id,0,0).$end;

        $start='        <li class="columnnav">
                            <h4>Виды спорта '.$brand_name.'</h4>';
        $this->data = Category::find()->indexBy('id')->where(['describtion' => ['sport']])->asArray()->all();
        $this->tree = $this->getTree();
        $this->menuHtml = $this->menuHtml.$start.$this->getMenuHtml($this->tree,$gender_name,$gender_id,$brand_name,$brand_id,0,0).$end;

        $start='        <li class="columnnav">
                            <h4>Одежда '.$brand_name.'</h4>';
        $this->data = Category::find()->indexBy('id')->where(['describtion' => ['type']])->andwhere(['<>','name', 'Обувь'])->andwhere(['<>','name', 'Аксессуары'])->asArray()->all();
        $this->tree = $this->getTree();
        $this->menuHtml = $this->menuHtml.$start.$this->getMenuHtml($this->tree,$gender_name,$gender_id,$brand_name,$brand_id,1,0).$end;

        $excepted=Category::find()->where(['name' => ['Обувь','Аксессуары']])->andWhere(['describtion' =>['type']])->all();
        foreach ($excepted as $except) { 
            $start='        <li class="columnnav">
                                <h4>'.$brand_name.' '.$except->name.'</h4>';
            $this->data = Category::find()->indexBy('id')->where(['parent_id' => $except->id])->asArray()->all();
            $this->tree = $this->getTree();
            $this->menuHtml = $this->menuHtml.$start.$this->getMenuHtml($this->tree,$gender_name,$gender_id,$brand_name,$brand_id,0,0).$end;
        }
        $this->menuHtml.=$last;

        $brand_id=2;
        $brand_name='reebok';

        $start='<li class="listnav"><span class="nav marginnav">'.$brand_name.'</span>
                    <ul class="listcolumn marginlistcolumn">
                        <li class="columnnav">
                            <h4>Колекции '.$brand_name.'</h4>';
        $end='          </li>';
        $last='     </ul>
                </li>';
        $this->data = Category::find()->indexBy('id')->where(['describtion' => ['brand']])->asArray()->all();
        $this->tree = $this->getTree();
        $this->menuHtml = $this->menuHtml.$start.$this->getMenuHtml($this->tree,$gender_name,$gender_id,$brand_name,$brand_id,0,0).$end;

        $start='        <li class="columnnav">
                            <h4>Виды спорта '.$brand_name.'</h4>';
        $this->data = Category::find()->indexBy('id')->where(['describtion' => ['sport']])->asArray()->all();
        $this->tree = $this->getTree();
        $this->menuHtml = $this->menuHtml.$start.$this->getMenuHtml($this->tree,$gender_name,$gender_id,$brand_name,$brand_id,0,0).$end;

        $start='        <li class="columnnav">
                            <h4>Одежда '.$brand_name.'</h4>';
        $this->data = Category::find()->indexBy('id')->where(['describtion' => ['type']])->andwhere(['<>','name', 'Обувь'])->andwhere(['<>','name', 'Аксессуары'])->asArray()->all();
        $this->tree = $this->getTree();
        $this->menuHtml = $this->menuHtml.$start.$this->getMenuHtml($this->tree,$gender_name,$gender_id,$brand_name,$brand_id,1,0).$end;

        $excepted=Category::find()->where(['name' => ['Обувь','Аксессуары']])->andWhere(['describtion' =>['type']])->all();
        foreach ($excepted as $except) { 
            $start='        <li class="columnnav">
                                <h4>'.$brand_name.' '.$except->name.'</h4>';
            $this->data = Category::find()->indexBy('id')->where(['parent_id' => $except->id])->asArray()->all();
            $this->tree = $this->getTree();
            $this->menuHtml = $this->menuHtml.$start.$this->getMenuHtml($this->tree,$gender_name,$gender_id,$brand_name,$brand_id,0,0).$end;
        }
        $this->menuHtml.=$last;
        return $this->menuHtml;
    }

    protected function getTree(){
        $tree =[];
        foreach ($this->data as $id=>&$node){
            if(!$node['parent_id']){
                $tree[$id]=&$node;
            }
            else{
                $this->data[$node['parent_id']]['childs'][$node['id']]=&$node;
            }
        }
        return $tree;
    }

    public function getMenuHtml($tree,$gender_name,$gender_id,$brand_name,$brand_id,$buf,$count){
        $str='';
        foreach ($tree as $category){
            $where='id != 0';
            if($brand_name!=''){
                $where.=" AND brand = '".$brand_name."'";
            }

            if($gender_id!=0){
                $where.=' AND gender_id = '.$gender_id;
            }

            if($category['describtion']=='type')
                $where.=' AND type_id ='.$category['id'];
            if($category['describtion']=='sub_type')
                $where.=' AND sub_type_id ='.$category['id'];
            if($category['describtion']=='sport')
                $where.=' AND sport_id = '.$category['id'];
            if($category['describtion']=='brand')
                $where.=' AND col_id = '.$category['id'];

            $count=Product::find()->where($where)->andwhere(['<>','photo', 'No photo yet'])->count();
            if($count!=0){
                 $str.=$this->catToTemplate($category,$gender_name,$gender_id,$brand_name,$brand_id,$buf,$count);
            }
        }
        return $str;
    }
    protected function catToTemplate($category,$gender_name,$gender_id,$brand_name,$brand_id,$buf,$count){
        ob_start();
        include __DIR__.'/menu_tpl/'.$this->tpl;
        return ob_get_clean();
    }
}