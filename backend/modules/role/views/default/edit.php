<?php

use yii\helpers\ArrayHelper;

$this->title = '编辑';
$params = Yii::$app->request->getQueryParams();

$form = \common\widgets\form\ActiveForm::begin([
    'action' => \yii\helpers\Url::to(ArrayHelper::merge(['update'], $params)),
]);
echo $form->field($model, 'name')->textInput();
echo $form->field($model, 'description');
echo \common\widgets\DoubleBox::widget([
    'leftLabel'  => '全部角色',
    'left'       => $roleLeft,
    'rightLabel' => '子角色',
    'right'      => $roleRight,
    'options'    => ['class' => 'form-group'],
]);
echo \common\widgets\DoubleBox::widget([
    'leftLabel'  => '全部权限',
    'left'       => $permissionLeft,
    'rightLabel' => '权限',
    'right'      => $permissionRight,
    'options'    => ['class' => 'form-group'],
]);
echo \common\helpers\Html::formButton(['index']);
\common\widgets\form\ActiveForm::end();
?>







