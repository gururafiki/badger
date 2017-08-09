<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Авторизация';
?>
<div id="contents">
        <div id="content_text" class="">
                <p>
                    <?= $result ?>
                    <?php if(isset($name) ): ?>
                        , <?= $name ?> !
                    <?php endif;?>
                </p>

                <code><?= __FILE__ ?></code>
            <div class="clear"></div>
        </div>

        <div class="information">Мы Магазин спортивной одежды и обуви Badger. Только оригинальная продукция. Мировые бренды. Приемлемые цены. Рады стараться для вас.</div>
        <div class="clear"></div>
    </div><!--/contents-->




    <div id="side_left">
