<?php

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language'   => 'zh-CN',
    'timeZone'   => 'Asia/Shanghai',
    'bootstrap'  => [
        'queue', // 把这个组件注册到控制台
    ],
    'components' => [
        'commonCache'  => [
            'class' => 'yii\caching\FileCache',
        ],
        'nav'          => [
            'class' => \common\core\filter\Menu::className(),
        ],
        'authManager'  => [
            'class' => 'yii\rbac\DbManager',
        ],
        'assetManager' => [
            'linkAssets' => true,
        ],
        'queue'        => [
            'class'     => \yii\queue\db\Queue::className(),
            'as log'    => \yii\queue\LogBehavior::className(),
            'db'        => 'db',
            'tableName' => '{{%queue}}', // 表名
            'channel'   => 'default', // Queue channel key
            'mutex'     => \yii\mutex\MysqlMutex::className(), // Mutex that used to sync queries
            'ttr'       => 2 * 60, // Max time for anything job handling
            'attempts'  => 3, // Max number of attempts
        ],
    ],
    'container'  => [
        'singletons' => \common\helpers\DiHelper::di(),
    ],

];
