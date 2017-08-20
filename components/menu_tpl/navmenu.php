<?php
    $flag=0;
    $flag_current=$false;
?>
<?php foreach($current as $now):?>
    <?php if($category['id']==$now ) {
        $style="
                            text - shadow: rgba(0, 0, 0, 0.15) 0px 1px 1px;
                            background-color: #009adb;color:#c4e3f3;
                            border - radius: 4px;
                            transition: none;";
        $flag_current=true;
    }
    ?>
<?php endforeach;?>
        <?php if( isset($category['childs']) ):?>
            <?php $flag=2;?>

            <?php if($flag_current):?>
                <?php if((($i-1)%4!=0 && $flag==2 && isset($category['childs']) && $type==='type') || (($i-3)%4!=0 && $flag==2 && isset($category['childs']) && $size==='size') )
                    //echo '<ul style="display:inline-flex;width:85%;margin-left: 15%;">';
                ?>
                <li style="display: inline-block;vertical-align:top;text-align: center;width:100%;margin:0px 0px 0px 0px;padding:0px 10px 0px 10px;">
            <?php else:?>
                    <li style="display: inline-block;vertical-align:top;text-align: center;width:100%;margin:0px 0px 0px 0px;padding:0px 10px 0px 10px;">
            <?php endif;?>
            <?php if( isset($category['name']) ):?>
            <?php if($flag_current):?>
                <a class="bold level_opener btn btn-default opened" href="#" title="<?=$category['name']?>"
                <?=' style="width:100%;'.$style.'"'?>
            <?php else:?>
                <a class="bold level_opener btn btn-default" href="#" title="<?=$category['name']?>"
                <?='style="width:100%;"'?>
            <?php endif;?>
                    ><?=$category['name']?><i class="fa fa-angle-down" aria-hidden="true" style="display: inline;float: right;"></i>
            </a>
            <div class="clear"></div>
            <?php if($flag_current):?>
                <ul style="display:inline-flex;width:100%;">
                    <?= $this->getMenuHtml($category['childs'],$col,$spo,$gen,$brand,$size,$type,$byprice,$product_type,$current,1,1,1,true)?>
            <?php else:?>
                <ul style="display:none;width:100%">
                    <?= $this->getMenuHtml($category['childs'],$col,$spo,$gen,$brand,$size,$type,$byprice,$product_type,$current,1,1,1,false)?>
            <?php endif;?>
            </ul>
            <?php endif;?>
        <?php else:?>
        <li style="display: inline-block;vertical-align:top;text-align: center;width:100%;padding:0px 10px 0px 10px;">
            <?php if($col=='col' && $type!=0) :?>
                <?php $flag=1;?>
                <?php if(!$flag_current):?>
                    <a class="btn btn-success" style="font-size: 15px;line-height:17px;color: rgb(0, 154, 219);transition: none;background: border-box;width: 100%;margin-left:0px;padding:5px;"
                <?php else:?>
                    <a class="btn btn-default" style="font-size: 15px;line-height:17px;width:100%;margin-left:0px;padding:5px;background-color: #009adb;color:#c4e3f3;"
                <?php endif;?>
                 href="/advanced/<?=$category['id'].'/0/'.$gen.'/'.$brand.'/'.$size.'/'.$type.'/'.$byprice.'/'.$product_type?>#selectedcat"><?=$category['name']?> ( <?=$count?> )
                        </a>
            <?php endif;?>
            <?php if($spo=='spo' && $type!=0) :?>
                <?php $flag=1;?>
                <?php if(!$flag_current):?>
                    <a class="btn btn-success" style="font-size: 15px;line-height:17px;color: rgb(0, 154, 219);transition: none;background: border-box;width: 100%;margin-left:0px;padding:5px;"
                <?php else:?>
                    <a class="btn btn-default" style="font-size: 15px;line-height:17px;width:100%;margin-left:0px;padding:5px;background-color: #009adb;color:#c4e3f3;"
                <?php endif;?>
                 href="/advanced/<?='0/'.$category['id'].'/'.$gen.'/'.$brand.'/'.$size.'/'.$type.'/'.$byprice.'/'.$product_type?>#selectedcat"><?=$category['name']?> ( <?=$count?> )</a>
            <?php endif;?>
            <?php if($gen=='gen') :?>
                <?php $flag=1;?>
                <?php if(!$flag_current):?>
                    <a class="btn btn-success" style="font-size: 15px;line-height:17px;color: rgb(0, 154, 219);transition: none;background: border-box;width: 100%;margin-left:0px;padding:5px;"
                <?php else:?>
                    <a class="btn btn-default" style="font-size: 15px;line-height:17px;width:100%;margin-left:0px;padding:5px;background-color: #009adb;color:#c4e3f3;"
                <?php endif;?>
                 href="/advanced/<?=$col.'/'.$spo.'/'.$category['id'].'/'.$brand.'/'.$size.'/'.$type.'/'.$byprice.'/'.$product_type?>#selectedcat"><?=$category['name']?> ( <?=$count?> )</a>
            <?php endif;?>
            <?php if($brand=='pro') :?>
                <?php if(!$flag_current):?>
                    <a class="btn btn-success" style="font-size: 15px;line-height:17px;color: rgb(0, 154, 219);transition: none;background: border-box;width: 100%;margin-left:0px;padding:5px;"
                <?php else:?>
                    <a class="btn btn-default" style="font-size: 15px;line-height:17px;width:100%;margin-left:0px;padding:5px;background-color: #009adb;color:#c4e3f3;"
                <?php endif;?>
                 href="/advanced/<?=$col.'/'.$spo.'/'.$gen.'/'.$category['id'].'/0/'.$type.'/'.$byprice.'/'.$product_type?>#selectedcat"><?=$category['name']?> ( <?=$count?> )</a>
            <?php endif;?>
            <?php if($size=='size' && $type!=0) :?>
                <?php $flag=2;?>
                <?php if(!$flag_current):?>
                    <a class="btn btn-success" style="font-size: 15px;line-height:17px;color: rgb(0, 154, 219);transition: none;background: border-box;width: 100%;margin-left:0px;padding:5px;"
                <?php else:?>
                    <a class="btn btn-default" style="font-size: 15px;line-height:17px;width:100%;margin-left:0px;padding:5px;background-color: #009adb;color:#c4e3f3;"
                <?php endif;?>
                 href="/advanced/<?=$col.'/'.$spo.'/'.$gen.'/0/'.$category['id'].'/'.$type.'/'.$byprice.'/'.$product_type?>#selectedcat"><?=$category['name']?> ( <?=$count?> )</a>
            <?php endif;?>
            <?php if($type=='type') :?>
                <?php $flag=2;?>
                <?php if(!$flag_current):?>
                    <a class="btn btn-success" style="font-size: 15px;line-height:17px;color: rgb(0, 154, 219);transition: none;background: border-box;width: 100%;margin-left:0px;padding:5px;"
                <?php else:?>
                    <a class="btn btn-default" style="font-size: 15px;line-height:17px;width:100%;margin-left:0px;padding:5px;background-color: #009adb;color:#c4e3f3;"
                <?php endif;?>
                 href="/advanced/<?='0/0/'.$gen.'/'.$brand.'/0/'.$category['id'].'/'.$byprice.'/'.$product_type?>#selectedcat"><?=$category['name']?> ( <?=$count?> )</a>
            <?php endif;?>
        <?php endif;?>
</li>
    <?php if(($i-1)%5==0 && $flag==1):?>
        </ul>
        <ul style="display:inline-flex;width:83%;margin-left: 17%;margin-bottom:12px;">
    <?php elseif(($i-3)%3==0 && $flag==2 && isset($category['childs']) && $size==='size'): ?>
        </ul>
        <ul style="display:inline-flex;width:83%;margin-left: 16.5%;margin-bottom:12px;">
    <?php elseif(($i-3)%5==0 && $flag==2 && isset($category['childs']) && $type==='type'): ?>
        </ul>
        <ul style="display:inline-flex;width:83%;margin-left: 16.5%;margin-bottom:12px;">
    <?php elseif(($i-1)%4==0 && $i>3  && $flag==2 && $visability && $type==='type' ): ?>
            </ul>
            <ul style="display:inline-flex;width:100%;">
    <?php elseif( ($i-3)%4==0 && $i>3 && $flag==2 && $visability && $size==='size' ): ?>
            </ul>
            <ul style="display:inline-flex;width:100%;">
    <?php endif;?>