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
        'libs/bxslider/jquery.bxslider.css',
        'libs/lightbox/css/lightbox.css',
        'css/site.css',
    ];
    public $js = [
        'libs/bxslider/jquery.bxslider.min.js',
        'libs/jqueryui/jquery.ui.min.js',
        'libs/lightbox/js/lightbox.min.js',
        'libs/cart.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
