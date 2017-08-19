<?php

namespace app\components;
use yii\base\Widget;
use yii\db\ActiveRecord;
use app\models\Category;
use app\models\Product;


class MenuWidget extends  Widget{

    public $tpl;
    public $data;
    public $tree;
    public $menuHtml;
    public $url;
    public function init(){
        parent::init();
        if( $this->tpl === null){
            $this->tpl='menu';
        }
        $this->tpl.='.php';
    }
    public function run(){
        $start='<li><a class="bold level_opener" href="#" style="float:left;">';
        $start_2='</a>
            <div class="clear"></div>
            <ul style="display:none;">';
        $end='</ul></li>';
        $arr=explode('/',$this->url);
        $url_str=$this->url;
        if($arr[1]!='category'){
            for($i=0;$i<=8;$i++){
                $arr[$i]='0';
            }
        }
        else{
            $start_current='<li><a class="current_list" href="/category';
            $end_current='</a></li>';
            $this->menuHtml='<li><a class="bold level_opener" href="#" style="float:left;"><h2>Выбраные фильтры<i class="fa fa-angle-down" aria-hidden="true" style="display: inline;float: right;"></i></h2></a><ul>';
            for($i=2;$i<=7;$i++){
                if($arr[$i]!=0){
                    $name_cat=Category::findOne(['id'=>$arr[$i]]);
                    $this->menuHtml.=$start_current;
                    for($j=2;$j<=8;$j++){
                        if($i==$j)
                            $this->menuHtml.='/0';
                        else
                            $this->menuHtml.='/'.$arr[$j];
                    }
                    $this->menuHtml.='" title="Убрать '.$name_cat->name.'">'.$name_cat->name.$end_current;
                }
            }
            $this->menuHtml.='<li><a class="current_list" href="/';
            $this->menuHtml.='" title="Убрать все фильтры">Убрать все фильтры'.$end_current;
            $this->menuHtml.='<li><a class="short_rule">* Нажмите,что бы убрать категорию</a></li></ul></li>';
        }
        //бренды
        $this->data = Category::find()->indexBy('id')->where(['describtion' => 'producer'])->asArray()->all();
        //print_r($this->data);
        $this->tree = $this->getTree();
        $text=$this->getMenuHtml($this->tree,$arr[2],$arr[3],$arr[4],'pro',$arr[6],$arr[7],$arr[8],$arr[5]);
        $this->menuHtml = $this->menuHtml.$start.'<h2>Бренды<i class="fa fa-angle-down" aria-hidden="true" style="display: inline;float: right;"></i></h2>'.$start_2.$text.$end;
        //пол
        $this->data = Category::find()->indexBy('id')->where(['describtion' => 'gender'])->asArray()->all();
        $this->tree = $this->getTree();
        $text=$this->getMenuHtml($this->tree,$arr[2],$arr[3],'gen',$arr[5],$arr[6],$arr[7],$arr[8],$arr[4]);
        if(strlen($text)>50)
            $this->menuHtml = $this->menuHtml.$start.'<h2>Пол<i class="fa fa-angle-down" aria-hidden="true" style="display: inline;float: right;"></i></h2>'.$start_2.$text.$end;
        //типы
        $this->data = Category::find()->indexBy('id')->where(['describtion' => ['type','sub_type']])->asArray()->all();
        $this->tree = $this->getTree();
        $text=$this->getMenuHtml($this->tree,$arr[2],$arr[3],$arr[4],$arr[5],$arr[6],'type',$arr[8],$arr[7]);
        if(strlen($text)>50)
            $this->menuHtml = $this->menuHtml.$start.'<h2>Тип<i class="fa fa-angle-down" aria-hidden="true" style="display: inline;float: right;"></i></h2>'.$start_2.$text.$end;
        if($arr[7]!=0){
            //sizes
            $this->data = Category::find()->indexBy('id')->where(['describtion' => ['size', 'size_shoes','size_cloth']])->asArray()->all();
            $this->tree = $this->getTree();
            $text=$this->getMenuHtml($this->tree,$arr[2],$arr[3],$arr[4],$arr[5],'size',$arr[7],$arr[8],$arr[6]);
            if(strlen($text)>50)
                $this->menuHtml = $this->menuHtml.$start.'<h2>Размеры<i class="fa fa-angle-down" aria-hidden="true" style="display: inline;float: right;"></i></h2>'.$start_2.$text.$end;
            //collection
            $this->data = Category::find()->indexBy('id')->where(['describtion' => 'brand'])->asArray()->all();
            $this->tree = $this->getTree();
            $text=$this->getMenuHtml($this->tree,'col',$arr[3],$arr[4],$arr[5],$arr[6],$arr[7],$arr[8],$arr[2]);
            if(strlen($text)>50)
            $this->menuHtml = $this->menuHtml.$start.'<h2>Коллекция<i class="fa fa-angle-down" aria-hidden="true" style="display: inline;float: right;"></i></h2>'.$start_2.$text.$end;
            //sport
            $this->data = Category::find()->indexBy('id')->where(['describtion' => 'sport'])->asArray()->all();
            $this->tree = $this->getTree();
            $text=$this->getMenuHtml($this->tree,$arr[2],'spo',$arr[4],$arr[5],$arr[6],$arr[7],$arr[8],$arr[3]);
            if(strlen($text)>50)
            $this->menuHtml = $this->menuHtml.$start.'<h2>Спорт<i class="fa fa-angle-down" aria-hidden="true" style="display: inline;float: right;"></i></h2>'.$start_2.$text.$end;

        }
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

    public function getMenuHtml($tree,$col,$spo,$gen,$brand,$size,$type,$byprice,$current){
        $str='';
        foreach ($tree as $category){
            if(!isset($category['childs'])){
                $where='';
                if($col=='col'){
                    $where='col_id = '.$category['id'];
                }
                elseif($spo=='spo'){
                    $where='sport_id ='.$category['id'];
                }
                elseif($type=='type'){
                    $cat=Category::findOne(['id'=>$category['parent_id']]);
                    if($category['parent_id'] != $category['id']-1){
                        $where='sub_type_id = '.$category['id'];
                    }
                    else{
                        $where='type_id = '.$category['parent_id'];
                        // $count=Product::find()->where('type_id = '.$category['parent_id'])->count();
                        // $str.=$this->catToTemplate($category,$col,$spo,$gen,$brand,$size,$type,$byprice,$count,$current);
                        // continue;
                    }
                }
                elseif($gen=='gen'){
                    $where='gender_id = '.$category['id'];
                }
                elseif($brand=='pro'){
                    $where='brand_id = '.$category['id'];
                }
                elseif($size=='size'){
                    $where='(size_id_1 = '.$category['id'].' OR size_id_2 = '.$category['id'].' OR size_id_3 = '.$category['id'].' OR size_id_4 = '.$category['id'].' OR size_id_5 = '.$category['id'].' OR size_id_6 = '.$category['id'].' OR size_id_7 = '.$category['id'].' OR size_id_8 = '.$category['id'].' OR size_id_9 = '.$category['id'].' OR size_id_10 = '.$category['id'].')';
                }

                if($where!=''){
                    if($col!=0 && $col!='col'){
                        $where.=' AND col_id = '.$col;
                    }
                    if($spo!=0 && $spo!='spo'){
                        $where.=' AND sport_id ='.$spo;
                    }
                    if($type!=0 && $type!='type'){
                        $cat=Category::findOne(['id'=>$type]);
                        if($cat->id != $cat->parent_id+1)
                            $where.=' AND sub_type_id = '.$type;
                        else
                            $where.=' AND type_id = '.$cat->parent_id;
                    }
                    if($gen!=0 && $gen!='gen'){
                        $where.=' AND gender_id = '.$gen;
                    }
                    if($brand!=0 && $brand!='pro'){
                        $where.=' AND brand_id = '.$brand;
                    }
                    if($size!=0 && $size!='size'){
                        $where.=' AND (size_id_1 = '.$size.' OR size_id_2 = '.$size.' OR size_id_3 = '.$size.' OR size_id_4 = '.$size.' OR size_id_5 = '.$size.' OR size_id_6 = '.$size.' OR size_id_7 = '.$size.' OR size_id_8 = '.$size.' OR size_id_9 = '.$size.' OR size_id_10 = '.$size.')';
                    }

                    $count=Product::find()->where($where)->count();
                    if($count>0){
                        $str.=$this->catToTemplate($category,$col,$spo,$gen,$brand,$size,$type,$byprice,$count,$current);
                    }
                }
            }
            else{
                $current_cat=Category::findOne(['id'=>$current]);
                $buf = $this->catToTemplate($category,$col,$spo,$gen,$brand,$size,$type,$byprice,$count,$current_cat->parent_id);
                if(strlen($buf)>500)
                    $str.=$buf;
            }
        }
        return $str;
    }
    protected function catToTemplate($category,$col,$spo,$gen,$brand,$size,$type,$byprice,$count,$current){
        ob_start();
        include __DIR__.'/menu_tpl/'.$this->tpl;
        return ob_get_clean();
    }
}