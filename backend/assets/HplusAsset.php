<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/17
 * Time: 下午2:00
 */

namespace backend\assets;


use yii\web\AssetBundle;


class HplusAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/font-awesome.min.css',
        'css/animate.min.css',
        'css/style.min.css'
    ];
    public $js = [
        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}