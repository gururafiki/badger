
    <a><?=$category['name']?>
            <?php if( isset($category['childs']) ):?>
                <span class="budge pull-right">
                <i class="fa fa-plus"></i>
            </span>
            <?php endif;?>
        </a>
    <?php if( isset($category['childs']) ):?>
        <div>
                <?= $this->getMenuHtml($category['childs'])?>
            </div>
    <?php endif;?>
