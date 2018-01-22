<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2018/1/21
 * Time: 下午6:08
 */

namespace common\assets;

use yii\web\AssetBundle;

class StepsAsset extends AssetBundle
{
    public $sourcePath = '@common/dist';

    public $css = [
        'css/steps/jquery.steps.css',
    ];
    public $js = [
        'js/steps/jquery.steps.min.js',
    ];

    public $depends = [
        
    ];
}