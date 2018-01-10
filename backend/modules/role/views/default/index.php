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
    'data'    => [
        ['a' => '1', 'b' => 2, 'c' => 3],
        ['a' => '13', 'b' => 2, 'c' => 3],
        ['a' => '15', 'b' => 2, 'c' => 3],
    ],
    'order'   => 'all',
    'id'      => 'a',
    'columns' => [
        //        [
        //            'class' => \common\widgets\table\helpers\Column::className(),
        //            'headerOption' => ['class' => '1'],
        //            'attribute' => 'c'
        //        ],
        [
            'class' => \common\widgets\table\helpers\CheckboxColumn::className(),
        ],
        '#',
        'a:呵呵',
        'b:呵呵2',
        'c:呵呵5',
        [
            'class' => \common\widgets\table\helpers\ActionColumn::className(),
        ],
    ],

]);

?>
