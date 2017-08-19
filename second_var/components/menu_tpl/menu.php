<li>
        <?php if( isset($category['childs']) ):?>
            <?php if( isset($category['name']) ):?>
            <a class="bold level_opener<?php if($category['id']==$current) :?> current<?php endif;?>" href="#" title="<?=$category['name']?>"><?=$category['name']?><i class="fa fa-angle-down" aria-hidden="true" style="display: inline;float: right;"></i>
            </a>
            <div class="clear"></div>
            <ul style="display:none;">
                <?= $this->getMenuHtml($category['childs'],$col,$spo,$gen,$brand,$size,$type,$byprice,0)?>
            </ul>
            <?php endif;?>
        <?php else:?>
            <?php if($col=='col' && $type!=0) :?>
                <a 
                <?php if($category['id']==$current) :?>
                        class="current" 
                <?php endif;?>
                 href="/category/<?=$category['id'].'/0/'.$gen.'/'.$brand.'/'.$size.'/'.$type.'/'.$byprice?>#selectedcat"><?=$category['name']?> ( <?=$count?> )
                        </a>
            <?php endif;?>
            <?php if($spo=='spo' && $type!=0) :?>
                <a 
                <?php if($category['id']==$current) :?>
                        class="current" 
                <?php endif;?>
                 href="/category/<?='0/'.$category['id'].'/'.$gen.'/'.$brand.'/'.$size.'/'.$type.'/'.$byprice?>#selectedcat"><?=$category['name']?> ( <?=$count?> )</a>
            <?php endif;?>
            <?php if($gen=='gen') :?>
                <a 
                <?php if($category['id']==$current) :?>
                        class="current" 
                <?php endif;?>
                 href="/category/<?=$col.'/'.$spo.'/'.$category['id'].'/'.$brand.'/'.$size.'/'.$type.'/'.$byprice?>#selectedcat"><?=$category['name']?> ( <?=$count?> )</a>
            <?php endif;?>
            <?php if($brand=='pro') :?>
                <a 
                <?php if($category['id']==$current) :?>
                        class="current" 
                <?php endif;?>
                 href="/category/<?=$col.'/'.$spo.'/'.$gen.'/'.$category['id'].'/0/'.$type.'/'.$byprice?>#selectedcat"><?=$category['name']?> ( <?=$count?> )</a>
            <?php endif;?>
            <?php if($size=='size' && $type!=0) :?>
                <a 
                <?php if($category['id']==$current) :?>
                        class="current" 
                <?php endif;?>
                 href="/category/<?=$col.'/'.$spo.'/'.$gen.'/0/'.$category['id'].'/'.$type.'/'.$byprice?>#selectedcat"><?=$category['name']?> ( <?=$count?> )</a>
            <?php endif;?>
            <?php if($type=='type') :?>
                <a 
                <?php if($category['id']==$current) :?>
                        class="current" 
                <?php endif;?>
                 href="/category/<?='0/0/'.$gen.'/'.$brand.'/0/'.$category['id'].'/'.$byprice?>#selectedcat"><?=$category['name']?> ( <?=$count?> )</a>
            <?php endif;?>
        <?php endif;?>
</li>