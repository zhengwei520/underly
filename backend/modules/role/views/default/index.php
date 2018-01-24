<?php

$this->title = '列表';


echo \common\widgets\table\ListView::widget([
    'data'    => $role,
    'id'      => 'name',
    'columns' => [
        '#',
        'name|名称',
        'description|描述',
        'createdAt|创建时间|date,php:Y-d-d H:i:s',
        'updatedAt|更新时间|date,php:Y-d-d H:i:s',
        ['class' => \common\widgets\table\helpers\ActionColumn::className()],
    ],
]);
?>


