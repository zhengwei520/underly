<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2018/1/23
 * Time: 下午11:49
 */

namespace common\assets;

use yii\web\AssetBundle;

/**
 * The asset bundle for the [[ActiveForm]] widget.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ActiveFormAsset extends AssetBundle
{
    public $sourcePath = '@yii/assets';
    public $js = [
        'yii.activeForm.js',
    ];
    public $depends = [
        'common\hplus\assets\HplusAsset'
    ];
}