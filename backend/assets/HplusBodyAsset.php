<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/20
 * Time: 下午7:59
 */

namespace backend\assets;


use yii\web\AssetBundle;

class HplusBodyAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [

    ];
    public $js = [
        'js/plugins/metisMenu/jquery.metisMenu.js',
        'js/plugins/slimscroll/jquery.slimscroll.min.js',
        'js/plugins/layer/layer.min.js',
        'js/hplus.min.js',
        'js/contabs.min.js',
        'js/plugins/pace/pace.min.js',
    ];
    public $depends = [
        'common\hplus\assets\HplusAsset'
    ];

}