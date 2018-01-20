<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2018/1/20
 * Time: 下午8:42
 */

namespace common\assets;

use yii\web\AssetBundle;

class UtilAsset extends AssetBundle
{
    public $sourcePath = '@common/dist';
    
    public $js = [
        'js/util.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}