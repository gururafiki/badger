<li>
        <?php if( isset($category['childs']) ):?>
            <?php if( isset($category['name']) ):?>
            <dt>
                <a><?=$category['name']?>
                <span class="budge pull-right" style="padding-right: 30px;">
                    <i class="fa fa-plus"></i>
                </span>
                    </a></dt>
            <?php endif;?>
        <?php else:?>
            <?php if($col=='col') :?>
                <dt><a  href="/category/<?=$category['id'].'/0/'.$gen.'/'.$cloth.'/'.$shoes.'/'.$type.'/'.$byprice?>"><?=$category['name']?>
                        </a></dt>
            <?php endif;?>
            <?php if($spo=='spo') :?>
                <dt><a  href="/category/<?='0/'.$category['id'].'/'.$gen.'/'.$cloth.'/'.$shoes.'/'.$type.'/'.$byprice?>"><?=$category['name']?>
                    </a></dt>
            <?php endif;?>
            <?php if($gen=='gen') :?>
                <dt><a  href="/category/<?=$col.'/'.$spo.'/'.$category['id'].'/'.$cloth.'/'.$shoes.'/'.$type.'/'.$byprice?>"><?=$category['name']?>
                    </a></dt>
            <?php endif;?>
            <?php if($cloth=='cloth') :?>
                <dt><a  href="/category/<?=$col.'/'.$spo.'/'.$gen.'/'.$category['id'].'/0/'.$type.'/'.$byprice?>"><?=$category['name']?>
                    </a></dt>
            <?php endif;?>
            <?php if($shoes=='shoes') :?>
                <dt><a  href="/category/<?=$col.'/'.$spo.'/'.$gen.'/0/'.$category['id'].'/'.$type.'/'.$byprice?>"><?=$category['name']?>
                    </a></dt>
            <?php endif;?>
            <?php if($type=='type') :?>
                <dt><a  href="/category/<?=$col.'/'.$spo.'/'.$gen.'/'.$cloth.'/'.$shoes.'/'.$category['id'].'/'.$byprice?>"><?=$category['name']?>
                    </a></dt>
            <?php endif;?>
        <?php endif;?>
    <?php if( isset($category['childs']) ):?>
        <dd><ul>
            <?= $this->getMenuHtml($category['childs'],$col,$spo,$gen,$cloth,$shoes,$type,$byprice)?>
            </ul></dd>
    <?php endif;?>
</li>