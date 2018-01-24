<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2018/1/23
 * Time: 下午11:48
 */

namespace common\widgets\form;

use common\assets\ActiveFormAsset;
use yii\helpers\Json;

class ActiveForm extends \yii\widgets\ActiveForm
{
    public function registerClientScript()
    {
        $id = $this->options['id'];
        $options = Json::htmlEncode($this->getClientOptions());
        $attributes = Json::htmlEncode($this->attributes);
        $view = $this->getView();
        ActiveFormAsset::register($view);
        $view->registerJs("jQuery('#$id').yiiActiveForm($attributes, $options);");
    }
}