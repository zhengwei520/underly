<?php

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language'=>'zh-CN',
    'timeZone'=>'Asia/Shanghai',
    'components' => [
        'commonCache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'nav' => [
            'class' => \common\core\filter\Menu::className(),
        ],
    ],
    'container'  => [
        'singletons' => \common\helpers\DiHelper::di(),
    ],
    
];
