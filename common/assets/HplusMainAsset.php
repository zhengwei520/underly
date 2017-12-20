<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/20
 * Time: 下午7:59
 */

namespace common\assets;


use yii\web\AssetBundle;

class HplusMainAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/font-awesome.min.css',
        'css/animate.min.css',
        'css/style.min.css',
    ];

    public $js = [
        'js/jquery.min.js',
        'js/bootstrap.min.js',
        'js/plugins/metisMenu/jquery.metisMenu.js',
        'js/plugins/slimscroll/jquery.slimscroll.min.js',
        'js/plugins/layer/layer.min.js',
        'js/hplus.min.js',
        'js/contabs.min.js',
        'js/plugins/pace/pace.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}