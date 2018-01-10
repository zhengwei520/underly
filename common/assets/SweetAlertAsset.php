<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2018/1/10
 * Time: 上午9:50
 */

namespace common\assets;


use yii\web\AssetBundle;

class SweetAlertAsset extends AssetBundle
{
    public $sourcePath = '@common/dist';

    public $css = [
        'css/sweetalert/sweetalert.css',
    ];
    public $js = [
        'js/sweetalert/sweetalert.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}