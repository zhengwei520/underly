<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2018/1/25
 * Time: 下午10:29
 */

namespace common\assets;

use yii\web\AssetBundle;

class DoubleBoxAsset extends AssetBundle
{
    public $sourcePath = '@common/dist';

    public $css = [
        'css/boostrap-doublebox/doublebox-bootstrap.css',
    ];
    public $js = [
        'js/boostrap-doublebox/doublebox-bootstrap.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}