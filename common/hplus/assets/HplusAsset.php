<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/28
 * Time: 下午5:08
 */

namespace common\hplus\assets;

use yii\web\AssetBundle;

class HplusAsset extends AssetBundle
{
    public $sourcePath = '@common/hplus/dist';
    
    public $js = [
        'js/jquery.min.js',
        'js/bootstrap.min.js',
        "js/content.min.js",
    ];

    public $depends = [
        'common\hplus\assets\HplusLoginAsset'
    ];

}