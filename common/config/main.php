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
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'assetManager' => [
            'linkAssets' => true,
        ],
    ],
    'container'  => [
        'singletons' => \common\helpers\DiHelper::di(),
    ],
    
];
