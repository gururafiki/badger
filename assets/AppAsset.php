<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        //'css/site.css',
        'css/font-awesome.min.css',
        'css/prettyPhoto.css',
        'css/style.css',
        'css/main.css',
        'css/re-dialog.css',
        'css/ion.rangeSlider.css',
        'css/ion.rangeSlider.skinHTML5.css',
    ];
    public $js = [
        // 'js/jquery.accordion.js',
        // 'js/jquery.cookie.js',
        // 'js/main.js',
        // 'js/contact.js',
        // 'js/gmaps.js',
        // 'js/html5shiv.js',
        // 'js/jquery.prettyPhoto.js',
        // 'js/jquery.scrollUp.min.js',
        // 'js/jquery.slimscroll.min.js',
        // 'js/price-range.js',
        // 'js/respond.min.js',
        // 'styleSheetToogle.js',
        //  
        'js/jquery.inputmask.js',
        'js/jquery.prettyPhoto.js',
        'js/re-core.js',
        'js/re-dialog.js',
        'js/ion.rangeSlider.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
