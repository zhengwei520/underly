<?php

$this->title = '登录';
?>


<div>
    <h1 class="logo-name">心连网</h1>
</div>
<h3>欢迎使用 管理系统</h3>

<?php
$form = \yii\widgets\ActiveForm::begin([
    'id'      => 'login-form',
    'options' => [
        'class' => 'm-t',
    ],
]);

echo $form->field($model, 'account')->textInput(['placeholder' => $model->getAttributeLabel('account')])->label('');
echo $form->field($model, 'password')->passwordInput(['placeholder' => $model->getAttributeLabel('password')])->label('');

echo \yii\helpers\Html::submitButton('登 录', [
    'class' => 'btn btn-primary block full-width m-b',
]);

\yii\widgets\ActiveForm::end();

?>

<!--<p class="text-muted text-center"><a href="login.html#">-->
<!--        <small>忘记密码了？</small>-->
<!--    </a> | <a href="register.html">注册一个新账号</a>-->
<!--</p>-->