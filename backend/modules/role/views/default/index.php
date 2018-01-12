<?php

$this->title = '列表';
//    \yii\grid\GridView::widget([
//        'dataProvider' => $dataProvider,
//        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//
//            'id',
//            'account',
//            'username',
//            'auth_key',
//            'password',
//            // 'mobile',
//            // 'gender',
//            // 'email:email',
//            // 'face',
//            // 'address:ntext',
//            // 'is_delete',
//            // 'created_at',
//            // 'updated_at',
//
//            ['class' => 'yii\grid\ActionColumn'],
//        ],
//    ]);

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
