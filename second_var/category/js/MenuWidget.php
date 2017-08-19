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
        $start='<ul class="panel-group category-products" id="accordion">';
        $end='</ul>';
        $arr=explode('/',$this->url);

        $this->data = Category::find()->indexBy('id')->where(['describtion' => 'gender'])->asArray()->all();
        $this->tree = $this->getTree();
        $this->menuHtml = $start.$this->getMenuHtml($this->tree,$arr[2],$arr[3],'gen',$arr[5],$arr[6],$arr[7],$arr[8]).$end;
            $this->data = Category::find()->indexBy('id')->where(['describtion' => ['type','sub_type']])->asArray()->all();
            $this->tree = $this->getTree();
            $this->menuHtml = $this->menuHtml.$start.$this->getMenuHtml($this->tree,$arr[2],$arr[3],$arr[4],$arr[5],$arr[6],'type',$arr[8]).$end;

        if($arr[7]>=94){
            $this->data = Category::find()->indexBy('id')->where(['describtion' => ['size_shoes', 'size']])->asArray()->all();
            $this->tree = $this->getTree();
            $this->menuHtml = $this->menuHtml.$start.$this->getMenuHtml($this->tree,$arr[2],$arr[3],$arr[4],$arr[5],'shoes',$arr[7],$arr[8]).$end;
        }
        elseif($arr[7]<94 && $arr[7]>0){
            $this->data = Category::find()->indexBy('id')->where(['describtion' => ['size_cloth', 'size']])->asArray()->all();
            $this->tree = $this->getTree();
            $this->menuHtml = $this->menuHtml.$start.$this->getMenuHtml($this->tree,$arr[2],$arr[3],$arr[4],'cloth',$arr[6],$arr[7],$arr[8]).$end;
        }
        elseif($arr[7]==0){
            $this->data = Category::find()->indexBy('id')->where(['describtion' => ['size_shoes', 'size']])->asArray()->all();
            $this->tree = $this->getTree();
            $this->menuHtml = $this->menuHtml.$start.$this->getMenuHtml($this->tree,$arr[2],$arr[3],$arr[4],$arr[5],'shoes',$arr[7],$arr[8]).$end;
            $this->data = Category::find()->indexBy('id')->where(['describtion' => ['size_cloth', 'size']])->asArray()->all();
            $this->tree = $this->getTree();
            $this->menuHtml = $this->menuHtml.$start.$this->getMenuHtml($this->tree,$arr[2],$arr[3],$arr[4],'cloth',$arr[6],$arr[7],$arr[8]).$end;
        }
        $this->data = Category::find()->indexBy('id')->where(['describtion' => 'brand'])->asArray()->all();
        $this->tree = $this->getTree();
        $this->menuHtml = $this->menuHtml.$start.$this->getMenuHtml($this->tree,'col',$arr[3],$arr[4],$arr[5],$arr[6],$arr[7],$arr[8]).$end;
        $this->data = Category::find()->indexBy('id')->where(['describtion' => 'sport'])->asArray()->all();
        $this->tree = $this->getTree();
        $this->menuHtml = $this->menuHtml.$start.$this->getMenuHtml($this->tree,$arr[2],'spo',$arr[4],$arr[5],$arr[6],$arr[7],$arr[8]).$end;
        $filters=Category::find()->where(['id' => [$arr[2],$arr[3],$arr[4],$arr[5],$arr[6],$arr[7]]])->all();
        if(!empty($filters) ){
            $filter_line='<li><h2>Выбранные фильтры</h2></li>';
            foreach ($filters as $filter){
                    $filter_line=$filter_line.'<li>'.$filter->name.'</li>'; 
            }
        }      
        else{
            $filter_line='<h2>Сделайте выбор категорий</h2>';
        }
        if($arr[8]==0){
        $filter_line=$filter_line.'<a type="button" class="btn btn-primary" href="/category/'.$arr[2].'/'.$arr[3].'/'.$arr[4].'/'.$arr[5].'/'.$arr[6].'/'.$arr[7].'/1">Сортировка по цене</a>';
        }
        if($arr[8]==1){
        $filter_line=$filter_line.'<a type="button" class="btn btn-primary" href="/category/'.$arr[2].'/'.$arr[3].'/'.$arr[4].'/'.$arr[5].'/'.$arr[6].'/'.$arr[7].'/0">Отключить сортировку по цене</a>';
        }
        $filter_line=$filter_line.'<a type="button" class="btn btn-primary" href="/">Убрать все фильтры</a>';
        $this->menuHtml ='<ul>'.$filter_line.'</ul>'.$this->menuHtml;
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

    public function getMenuHtml($tree,$col,$spo,$gen,$cloth,$shoes,$type,$byprice){
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
                        $str.=$this->catToTemplate($category,$col,$spo,$gen,$cloth,$shoes,$type,$byprice);
                    }
                }
                elseif($gen=='gen'){
                    $where='gender_id = '.$category['id'];
                }
                elseif($cloth=='cloth'){
                    $where='size_cloth_id = '.$category['id'];
                }
                elseif($shoes=='shoes'){
                    $where='size_shoes_id = '.$category['id'];
                }

                if($where!=''){
                    if($col!=0 && $col!='col'){
                        $where.=' AND col_id = '.$col;
                    }
                    if($spo!=0 && $spo!='spo'){
                        $where.=' AND sport_id ='.$spo;
                    }
                    if($type!=0 && $type!='type'){
                        $where.=' AND sub_type_id = '.$type;
                    }
                    if($gen!=0 && $gen!='gen'){
                        $where.=' AND gender_id = '.$gen;
                    }
                    if($cloth!=0 && $cloth!='cloth'){
                        $where.=' AND size_cloth_id = '.$cloth;
                    }
                    if($shoes!=0 && $shoes!='shoes'){
                        $where.=' AND size_shoes_id = '.$shoes;
                    }

                    $Product=Product::find()->where($where)->one();
                    if(isset($Product)){
                        $str.=$this->catToTemplate($category,$col,$spo,$gen,$cloth,$shoes,$type,$byprice);
                    }
                }
            }
            else{
                $str.=$this->catToTemplate($category,$col,$spo,$gen,$cloth,$shoes,$type,$byprice);
            }
            // $cat=Category::findOne(['id'=>$category['parent_id']]);
            // if($cat->describtion=='size_cloth' && $cloth!='cloth'){

            // }
            // elseif($cat->describtion=='size_shoes' && $shoes!='shoes'){

            // }
            // else{
            //     $str.=$this->catToTemplate($category,$col,$spo,$gen,$cloth,$shoes,$type);
            // }
        }
        return $str;
    }
    protected function catToTemplate($category,$col,$spo,$gen,$cloth,$shoes,$type,$byprice){
        ob_start();
        include __DIR__.'/menu_tpl/'.$this->tpl;
        return ob_get_clean();
    }
}