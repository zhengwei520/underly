<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2018/1/24
 * Time: 上午12:27
 */

namespace common\assets;

use yii\web\AssetBundle;

class ToastrAsset extends AssetBundle
{
    public $sourcePath = '@common/dist';

    public $css = [
        'css/toastr/toastr.min.css',
    ];
    public $js = [
        'js/toastr/toastr.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}