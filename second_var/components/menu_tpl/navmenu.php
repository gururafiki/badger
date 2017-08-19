<?php
    $flag=false;
    $flag_current=$false;
?>
<?php foreach($current as $now):?>
    <?php if($category['id']==$now) {
        $style="
                            text - shadow: rgba(0, 0, 0, 0.15) 0px 1px 1px;
                            color: rgb(0, 154, 219);
                            border - radius: 4px;
                            transition: none;";
        $flag_current=true;
    }
    ?>
<?php endforeach;?>
        <?php if( isset($category['childs']) ):?>
        <?php $flag=2;?>
        <li style="display: inline-block;vertical-align:top;text-align: center;width:100%;margin:0px 30px 0px 0px;padding:0px;">
            <?php if( isset($category['name']) ):?>
            <a class="bold level_opener btn btn-default" href="#" title="<?=$category['name']?>"
            <?php if($flag_current):?>
                <?='class="opened" style="width:100%;'.$style.'"'?>
            <?php else:?>
                <?='style="width:100%;"'?>
            <?php endif;?>
                    ><?=$category['name']?><i class="fa fa-angle-down" aria-hidden="true" style="display: inline;float: right;"></i>
            </a>
            <div class="clear"></div>
            <?php if($flag_current):?>
                <ul style="display:block;width:100%">
            <?php else:?>
                <ul style="display:none;width:100%">
            <?php endif;?>
                <?= $this->getMenuHtml($category['childs'],$col,$spo,$gen,$brand,$size,$type,$byprice,$current,1)?>
            </ul>
            <?php endif;?>
        <?php else:?>
        <li style="display: inline-block;vertical-align:top;text-align: center;width:100%;margin:0px 30px 0px 0px;padding:0px;">
            <?php if($col=='col' && $type!=0) :?>
                <?php $flag=1;?>
                <?php if($flag_current):?>
                    <a class="btn btn-success" style="color: rgb(0, 154, 219);transition: none;background: border-box;width: 100%;margin-left:17px;padding:5px;"
                <?php else:?>
                    <a class="btn btn-default" style="width:100%;margin-left:17px;padding:5px;background-color: #009adb;color:#c4e3f3;"
                <?php endif;?>
                 href="/category/<?=$category['id'].'/0/'.$gen.'/'.$brand.'/'.$size.'/'.$type.'/'.$byprice?>#selectedcat"><?=$category['name']?> ( <?=$count?> )
                        </a>
            <?php endif;?>
            <?php if($spo=='spo' && $type!=0) :?>
                <?php $flag=1;?>
                <?php if($flag_current):?>
                    <a class="btn btn-success" style="color: rgb(0, 154, 219);transition: none;background: border-box;width: 100%;margin-left:17px;padding:5px;"
                <?php else:?>
                    <a class="btn btn-default" style="width:100%;margin-left:17px;padding:5px;background-color: #009adb;color:#c4e3f3;"
                <?php endif;?>
                 href="/category/<?='0/'.$category['id'].'/'.$gen.'/'.$brand.'/'.$size.'/'.$type.'/'.$byprice?>#selectedcat"><?=$category['name']?> ( <?=$count?> )</a>
            <?php endif;?>
            <?php if($gen=='gen') :?>
                <?php if($flag_current):?>
                    <a class="btn btn-success" style="color: rgb(0, 154, 219);transition: none;background: border-box;width: 100%;margin-left:17px;padding:5px;"
                <?php else:?>
                    <a class="btn btn-default" style="width:100%;margin-left:17px;padding:5px;background-color: #009adb;color:#c4e3f3;"
                <?php endif;?>
                 href="/category/<?=$col.'/'.$spo.'/'.$category['id'].'/'.$brand.'/'.$size.'/'.$type.'/'.$byprice?>#selectedcat"><?=$category['name']?> ( <?=$count?> )</a>
            <?php endif;?>
            <?php if($brand=='pro') :?>
                <?php if($flag_current):?>
                    <a class="btn btn-success" style="color: rgb(0, 154, 219);transition: none;background: border-box;width: 100%;margin-left:17px;padding:5px;"
                <?php else:?>
                    <a class="btn btn-default" style="width:100%;margin-left:17px;padding:5px;background-color: #009adb;color:#c4e3f3;"
                <?php endif;?>
                 href="/category/<?=$col.'/'.$spo.'/'.$gen.'/'.$category['id'].'/0/'.$type.'/'.$byprice?>#selectedcat"><?=$category['name']?> ( <?=$count?> )</a>
            <?php endif;?>
            <?php if($size=='size' && $type!=0) :?>
                <?php if($flag_current):?>
                    <a class="btn btn-success" style="color: rgb(0, 154, 219);transition: none;background: border-box;width: 100%;margin-left:17px;padding:5px;"
                <?php else:?>
                    <a class="btn btn-default" style="width:100%;margin-left:17px;padding:5px;background-color: #009adb;color:#c4e3f3;"
                <?php endif;?>
                 href="/category/<?=$col.'/'.$spo.'/'.$gen.'/0/'.$category['id'].'/'.$type.'/'.$byprice?>#selectedcat"><?=$category['name']?> ( <?=$count?> )</a>
            <?php endif;?>
            <?php if($type=='type') :?>
                <?php if($flag_current):?>
                    <a class="btn btn-success" style="color: rgb(0, 154, 219);transition: none;background: border-box;width: 100%;margin-left:17px;padding:5px;"
                <?php else:?>
                    <a class="btn btn-default" style="width:100%;margin-left:17px;padding:5px;background-color: #009adb;color:#c4e3f3;"
                <?php endif;?>
                 href="/category/<?='0/0/'.$gen.'/'.$brand.'/0/'.$category['id'].'/'.$byprice?>#selectedcat"><?=$category['name']?> ( <?=$count?> )</a>
            <?php endif;?>
        <?php endif;?>
</li>
    <?php if($i%7==0 && $flag==2):?>
        </ul>
        <ul style="display:inline-flex;width:100%">
    <?php elseif($i%7==0 && $flag==1):?>
        </ul>
        <ul style="display:inline-flex;width:100%">
    <?php endif;?>
