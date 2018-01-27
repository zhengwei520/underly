<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2018/1/27
 * Time: 下午12:45
 */

namespace common\hplus\assets;

use yii\web\AssetBundle;

class HplusMainAsset extends AssetBundle
{
    public $sourcePath = '@common/hplus/dist';

    public $js = [
        'js/bootstrap.min.js',
        "js/content.min.js",
    ];
    
    public $depends = [
        'common\hplus\assets\HplusAsset'
    ];
}