<li>
        <?php if( isset($category['childs']) ):?>
            <?php if( isset($category['name']) ):?>
            <a class="bold" href="#" style="float:left;" title="<?=$category['name']?>"><?=$category['name']?></a>
            <a class="level_opener" style="float:right;" href="#"><i class="fa fa-angle-down" aria-hidden="true"></i></a>
            <div class="clear"></div>
            <ul style="display:none;">
                <?= $this->getMenuHtml($category['childs'],$col,$spo,$gen,$brand,$size,$type,$byprice,0)?>
            </ul>
            <?php endif;?>
        <?php else:?>
            <?php if($col=='col' && $type!=0) :?>
                <a  href="/category/<?=$category['id'].'/0/'.$gen.'/'.$brand.'/'.$size.'/'.$type.'/'.$byprice?>"><?=$category['name']?> ( <?=$count?> )
                        </a>
            <?php endif;?>
            <?php if($spo=='spo' && $type!=0) :?>
                <a  href="/category/<?='0/'.$category['id'].'/'.$gen.'/'.$brand.'/'.$size.'/'.$type.'/'.$byprice?>"><?=$category['name']?> ( <?=$count?> )</a>
            <?php endif;?>
            <?php if($gen=='gen') :?>
                <a  href="/category/<?=$col.'/'.$spo.'/'.$category['id'].'/'.$brand.'/'.$size.'/'.$type.'/'.$byprice?>"><?=$category['name']?> ( <?=$count?> )</a>
            <?php endif;?>
            <?php if($brand=='brand') :?>
                <a  href="/category/<?=$col.'/'.$spo.'/'.$gen.'/'.$category['id'].'/0/'.$type.'/'.$byprice?>"><?=$category['name']?> ( <?=$count?> )</a>
            <?php endif;?>
            <?php if($size=='size' && $type!=0) :?>
                <a  href="/category/<?=$col.'/'.$spo.'/'.$gen.'/0/'.$category['id'].'/'.$type.'/'.$byprice?>"><?=$category['name']?> ( <?=$count?> )</a>
            <?php endif;?>
            <?php if($type=='type') :?>
                <a  href="/category/<?=$col.'/'.$spo.'/'.$gen.'/'.$brand.'/0/'.$category['id'].'/'.$byprice?>"><?=$category['name']?> ( <?=$count?> )</a>
            <?php endif;?>
        <?php endif;?>
</li>