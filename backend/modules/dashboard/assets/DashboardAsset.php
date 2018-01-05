<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/20
 * Time: 下午7:59
 */

namespace backend\modules\dashboard\assets;


use yii\web\AssetBundle;

class DashboardAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
//        'css/bootstrap.min14ed.css',
//        'css/font-awesome.min.css',
        'css/plugins/morris/morris-0.4.3.min.css',
        'js/plugins/gritter/jquery.gritter.css',
//        'css/animate.min.css',
//        'css/style.min.css',
    ];

    public $js = [
//        'js/jquery.min.js',
//        'js/bootstrap.min.js',
        'js/plugins/flot/jquery.flot.js',
        'js/plugins/flot/jquery.flot.tooltip.min.js',
        'js/plugins/flot/jquery.flot.tooltip.min.js',
        'js/plugins/flot/jquery.flot.spline.js',
        'js/plugins/flot/jquery.flot.resize.js',
        'js/plugins/flot/jquery.flot.pie.js',
        'js/plugins/flot/jquery.flot.symbol.js',
        'js/plugins/peity/jquery.peity.min.js',
        'js/demo/peity-demo.min.js',
        'js/content.min.js',
        'js/plugins/jquery-ui/jquery-ui.min.js',
        'js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
        'js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
        'js/plugins/easypiechart/jquery.easypiechart.js',
        'js/plugins/sparkline/jquery.sparkline.min.js',
        'js/demo/sparkline-demo.min.js',
    ];
    public $depends = [
        'common\hplus\assets\HplusAsset'
    ];

}