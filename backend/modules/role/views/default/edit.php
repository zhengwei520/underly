<?php

$this->title = '编辑';

?>

<div class="col-sm-8">
    <div class="tabs-container">
        <div class="tabs-left">
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab-1">角色</a></li>
                <li class=""><a data-toggle="tab" href="#tab-2">子角色</a></li>
                <li class=""><a data-toggle="tab" href="#tab-3">权限</a></li>
            </ul>
            <div class="tab-content ">
                <div id="tab-1" class="tab-pane active">
                    <div class="panel-body">
                        <?php
                        $form = \common\widgets\form\ActiveForm::begin(['action' => \yii\helpers\Url::to(['update'])]);
                        echo $form->field($model, 'name')->textInput();
                        echo $form->field($model, 'description');
                        echo \common\helpers\Html::formButton();
                        \common\widgets\form\ActiveForm::end();
                        ?>
                    </div>
                </div>
                <div id="tab-2" class="tab-pane ">
                    <div class="panel-body">
                        <strong>2</strong>
                        <p>2</p>
                    </div>
                </div>
                <div id="tab-3" class="tab-pane ">
                    <div class="panel-body">
                        <strong>3</strong>
                        <p>3</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>







