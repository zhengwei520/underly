<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2018/1/13
 * Time: 下午10:47
 */

namespace common\assets;


use yii\web\AssetBundle;

class BootstrapTableAsset extends AssetBundle
{
    public $sourcePath = '@common/dist';

    public $css = [
        'css/bootstrap-table/bootstrap-table.min.css',
    ];
}