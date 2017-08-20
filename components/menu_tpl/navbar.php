<?php if( isset($category['childs']) ):?>
    <?= $this->getMenuHtml($category['childs'],$gender_name,$gender_id,$brand_name,$brand_id,$buf,$count)?>
<?php else:?>
    <?php if( $category['describtion']=='sport' ):?>
        <a href="/category/0/<?=$category['id']+$buf?>/<?=$gender_id?>/<?=$brand_id?>/0/0/0/0"><?=$category['name']?> (<?=$count?>)</a>
    <?php endif;?>
    <?php if( $category['describtion']=='brand' ):?>
        <a href="/category/<?=$category['id']+$buf?>/0/<?=$gender_id?>/<?=$brand_id?>/0/0/0/0"><?=$category['name']?> (<?=$count?>)</a>
    <?php endif;?>
    <?php if( $category['describtion']=='sub_type' || $category['describtion']=='type'):?>
        <a href="/category/0/0/<?=$gender_id?>/<?=$brand_id?>/0/<?=$category['id']+$buf?>/0/0"><?=$category['name']?> (<?=$count?>)</a>
    <?php endif;?>
<?php endif;?>