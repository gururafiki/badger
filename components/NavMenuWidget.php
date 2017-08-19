<?php

namespace app\components;
use yii\base\Widget;
use yii\db\ActiveRecord;
use app\models\Category;
use app\models\Product;


class NavMenuWidget extends  Widget{

    public $tpl;
    public $data;
    public $tree;
    public $menuHtml;
    public $url;
    public function init(){
        parent::init();
        if( $this->tpl === null){
            $this->tpl='navmenu';
        }
        $this->tpl.='.php';
    }
    public function run(){
        $start='<div class="clear"></div><hr><li style="list-style: none;width:100%;margin: 0px;"><a class="col-lg-2 bold level_opener opened" href="#" style="width:15%;float:left;">';
        $start_2='</a>
            <ul class="col-lg-8" style="display:inline-flex;width:83%">';
        $end='</ul></li>';
        $start_none='<div class="clear"></div><hr><li style="list-style: none;width:100%;margin: 0px;"><a class=" col-lg-2 bold level_opener opened" href="#" style="width:15%;float:left;">';
        $start_2_none='</a>
            <ul class="col-lg-8" style="display:inline-flex;width:83%">';
        $arr=explode('/',$this->url);
        $url_str=$this->url;
        if($arr[1]!='advanced'){
            for($i=0;$i<=8;$i++){
                $arr[$i]='0';
            }
        }
        else{
            $start_current='<li style="display: inline-block;vertical-align:top;text-align: center;width:100%;margin:0px;padding:0px;"><a style="width: 100%;" class="current_list" href="/advanced';
            $end_current='</a>';
            $this->menuHtml='<li style="width:100%;margin:0px;padding:0px;"><a class="bold level_opener opened" href="#" style="width:100%;float:left;"><h2>Скрыть меню</h2></a><ul style="width:100%;">';
            $this->menuHtml.='<li style="width:100%;margin:0px;padding:0px;"><a class="bold level_opener opened" href="#" style="width:15%;float:left;"><h2>Убрать :</h2></a><ul style="width:83%;display: inline-flex;">';
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
            $this->menuHtml.='<li style="display: inline-block;vertical-align:top;text-align: center;width:100%;margin:0px;padding:0px;"><a class="current_list" href="/';
            $this->menuHtml.='" title="Убрать все фильтры">Убрать все фильтры'.$end_current;
            $this->menuHtml.='</ul></li>';
        }
        //бренды
        $this->data = Category::find()->indexBy('id')->where(['describtion' => 'producer'])->asArray()->all();
        //print_r($this->data);
        $this->tree = $this->getTree();
        $text=$this->getMenuHtml($this->tree,$arr[2],$arr[3],$arr[4],'pro',$arr[6],$arr[7],$arr[8],$arr);
        $this->menuHtml = $this->menuHtml.$start.'<h2>Бренды<i class="fa fa-angle-down" aria-hidden="true" style="display: inline;float: right;"></i></h2>'.'</a>
            <ul class="col-lg-8" style="display:inline-flex;width:82%">'.$text.$end;
        //пол
        $this->data = Category::find()->indexBy('id')->where(['describtion' => 'gender'])->asArray()->all();
        $this->tree = $this->getTree();
        $text=$this->getMenuHtml($this->tree,$arr[2],$arr[3],'gen',$arr[5],$arr[6],$arr[7],$arr[8],$arr,1);
        if(strlen($text)>50)
            $this->menuHtml = $this->menuHtml.$start.'<h2>Пол<i class="fa fa-angle-down" aria-hidden="true" style="display: inline;float: right;"></i></h2>'.$start_2.$text.$end;
        //типы
        $this->data = Category::find()->indexBy('id')->where(['describtion' => ['type','sub_type']])->asArray()->all();
        $this->tree = $this->getTree();
        if(isset($arr[7]))
            $arr[]=$current_cat=Category::findOne(['id'=>$arr[7]])->parent_id;
        if(isset($arr[6]))
            $arr[]=$current_cat=Category::findOne(['id'=>$arr[6]])->parent_id;
        $text=$this->getMenuHtml($this->tree,$arr[2],$arr[3],$arr[4],$arr[5],$arr[6],'type',$arr[8],$arr,1);
        if(strlen($text)>50)
            $this->menuHtml = $this->menuHtml.$start.'<h2>Тип<i class="fa fa-angle-down" aria-hidden="true" style="display: inline;float: right;"></i></h2>'.$start_2.$text.$end;
        if($arr[7]!=0){
            //sizes
            $this->data = Category::find()->indexBy('id')->where(['describtion' => ['size', 'size_shoes','size_cloth']])->asArray()->all();
            $this->tree = $this->getTree();
            $text=$this->getMenuHtml($this->tree,$arr[2],$arr[3],$arr[4],$arr[5],'size',$arr[7],$arr[8],$arr,1);
            if(strlen($text)>50)
                $this->menuHtml = $this->menuHtml.$start_none.'<h2>Размеры<i class="fa fa-angle-down" aria-hidden="true" style="display: inline;float: right;"></i></h2>'.$start_2_none.$text.$end;
            //collection
            $this->data = Category::find()->indexBy('id')->where(['describtion' => 'brand'])->asArray()->all();
            $this->tree = $this->getTree();
            $text=$this->getMenuHtml($this->tree,'col',$arr[3],$arr[4],$arr[5],$arr[6],$arr[7],$arr[8],$arr,1);
            if(strlen($text)>50)
            $this->menuHtml = $this->menuHtml.$start_none.'<h2>Коллекция<i class="fa fa-angle-down" aria-hidden="true" style="display: inline;float: right;"></i></h2>'.$start_2_none.$text.$end;
            //sport
            $this->data = Category::find()->indexBy('id')->where(['describtion' => 'sport'])->asArray()->all();
            $this->tree = $this->getTree();
            $text=$this->getMenuHtml($this->tree,$arr[2],'spo',$arr[4],$arr[5],$arr[6],$arr[7],$arr[8],$arr,1);
            if(strlen($text)>50)
            $this->menuHtml = $this->menuHtml.$start_none.'<h2>Спорт<i class="fa fa-angle-down" aria-hidden="true" style="display: inline;float: right;"></i></h2>'.$start_2_none.$text.$end;

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

    public function getMenuHtml($tree,$col,$spo,$gen,$brand,$size,$type,$byprice,$current,$i=0,$end_ul='',$count_row=1,$visability=false){
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
                        if($i!=0){
                            $i++;
                        }
                        $str.=$this->catToTemplate($category,$col,$spo,$gen,$brand,$size,$type,$byprice,$count,$current,$i,$end_ul,$count_row,$visability);
                    }
                }
            }
            else{
                if($i!=0){
                    $i++;
                }
                $buf = $this->catToTemplate($category,$col,$spo,$gen,$brand,$size,$type,$byprice,$count,$current,$i,$end_ul,$count_row,$visability);
                if(substr_count($buf,'</li>')>=2) {
                    $flag_current=false;
                    foreach ($current as $now){
                        if($category['id']==$now){
                            $flag_current=true;
                        }
                    }
                    if($flag_current) {
                        $end_ul = $buf;
                    }
                    else {
                        $visability=false;
                        $str .= $buf;
                    }
                }
            }
        }
        if($end_ul!=1 && ((($i-1)%4!=0 && isset($category['childs']) && $type==='type') || (($i-3)%4!=0 && isset($category['childs']) && $size==='size') ))
            $str.='</ul><ul style="display:inline-flex;width:100%;">'.$end_ul.'</ul>';
        else
            $str.='<ul style="display:inline-flex;width:100%;">'.$end_ul.'</ul>';
        return $str;
    }
    protected function catToTemplate($category,$col,$spo,$gen,$brand,$size,$type,$byprice,$count,$current,$i,$end_ul,$count_row,$visability){
        ob_start();
        include __DIR__.'/menu_tpl/'.$this->tpl;
        return ob_get_clean();
    }
}