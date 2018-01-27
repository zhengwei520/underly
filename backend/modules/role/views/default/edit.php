<?php

use yii\helpers\ArrayHelper;

$this->title = '编辑';

$form = \yii\bootstrap\ActiveForm::begin([
    'action' => \yii\helpers\Url::to(ArrayHelper::merge(['update'], $params)),
]);
echo $form->field($model, 'name');
echo $form->field($model, 'description');
echo \common\widgets\DoubleBox::widget([
    'name'       => 'r',
    'leftLabel'  => '全部角色',
    'left'       => $roleLeft,
    'rightLabel' => '子角色',
    'right'      => $roleRight,
    'options'    => ['class' => 'form-group'],
]);
echo \common\widgets\DoubleBox::widget([
    'name'       => 'p',
    'leftLabel'  => '全部权限',
    'left'       => $permissionLeft,
    'rightLabel' => '权限',
    'right'      => $permissionRight,
    'options'    => ['class' => 'form-group'],
]);
echo \common\helpers\Html::formButton(['index']);
\yii\bootstrap\ActiveForm::end();
?>







