<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/17
 * Time: 下午2:00
 */

namespace common\hplus\assets;

use yii\web\AssetBundle;


class HplusLoginAsset extends AssetBundle
{
    public $sourcePath = '@common/hplus/dist';

    public $css = [
        'css/font-awesome.min.css',
        'css/animate.min.css',
        'css/style.min.css',
    ];

    public $depends = [
        'yii\bootstrap\BootstrapAsset',
    ];
    
}