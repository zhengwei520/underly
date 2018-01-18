<?php

$this->title = '列表';


//echo \common\widgets\table\ListView::widget([
//    'data' => $role,
//    'id' => 'name',
//    'columns' => [
//        '#',
//        'name|名称',
//        'description|描述',
//        'createdAt|创建时间|date,php:Y-d-d H:i:s',
//        'updatedAt|更新时间|date,php:Y-d-d H:i:s',
//        ['class' => \common\widgets\table\helpers\ActionColumn::className()]
//    ],
//]);


echo \common\widgets\table\ListView::widget([
    'data'    => $data,
    'order'   => 'all',
    'columns' => [
        //        [
        //            'class' => \common\widgets\table\helpers\Column::className(),
        //            'headerOption' => ['class' => '1'],
        //            'attribute' => 'c'
        //        ],
        //        [
        //            'class' => \common\widgets\table\helpers\CheckboxColumn::className(),
        //        ],
        '#',
        'id|ID',
        'account|账号',
        'auth_key',
        'password|密码',
        'created_at|开始时间|date,php:Y-m-d',
        [
            'class' => \common\widgets\table\helpers\ActionColumn::className(),
        ],
    ],

]);

?>

