<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/28
 * Time: 下午9:33
 */

return [
    [
        'label'           => '控制面板',
        'url'             => '/dashboard/statistics',
        'dropDownOptions' => ['class' => 'nav nav-second-level'],
        'permission'      => 'all',
        'linkOptions'     => ['class' => 'J_menuItem'],
    ],
    [
        'label'           => '哈哈管理',
        'url'             => '',
        'dropDownOptions' => ['class' => 'nav nav-second-level'],
        'items'           => [
            [
                'label'       => '223222',
                'url'         => '/dashboard/demo',
                'linkOptions' => ['class' => 'J_menuItem'],
            ],
            [
                'label'       => '3333',
                'url'         => '/site/index',
                'linkOptions' => ['class' => 'J_menuItem'],
                'permission'  => 'edit',
            ],
        ],
    ],
];