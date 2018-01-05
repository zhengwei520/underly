<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/28
 * Time: 下午9:33
 */

/**
 * [
 * 'label'           => '控制面板',
 * 'url'             => '/dashboard/statistics',
 * 'dropDownOptions' => ['class' => 'nav nav-second-level'],
 * 'permission'      => 'all',
 * 'linkOptions'     => ['class' => 'J_menuItem'],
 * ],
 * [
 * 'label'           => '账号中心',
 * 'dropDownOptions' => ['class' => 'nav nav-second-level'],
 * 'items'           => [
 * [
 * 'label'       => '用户管理',
 * 'items'       => [
 * [
 * 'label'       => '用户列表',
 * 'url'         => '#',
 * 'linkOptions' => ['class' => 'J_menuItem'],
 * ],
 * ],
 * ],
 * [
 * 'label'       => '权限管理',
 * 'items'       => [
 * [
 * 'label'       => '角色列表',
 * 'url'         => '/role',
 * 'linkOptions' => ['class' => 'J_menuItem'],
 * ],
 * [
 * 'label'       => '权限列表',
 * 'url'         => '/role/permission',
 * 'linkOptions' => ['class' => 'J_menuItem'],
 * ],
 * ],
 * ],
 * ],
 * ],
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
        'label'           => '账号中心',
        'dropDownOptions' => ['class' => 'nav nav-second-level'],
        'items'           => [
            [
                'label' => '用户管理',
                'items' => [
                    [
                        'label'       => '用户列表',
                        'url'         => '#',
                        'linkOptions' => ['class' => 'J_menuItem'],
                    ],
                ],
            ],
            [
                'label' => '权限管理',
                'items' => [
                    [
                        'label'       => '角色列表',
                        'url'         => '/role',
                        'linkOptions' => ['class' => 'J_menuItem'],
                    ],
                    [
                        'label'       => '权限列表',
                        'url'         => '/role/permission',
                        'linkOptions' => ['class' => 'J_menuItem'],
                    ],
                ],
            ],
        ],
    ],
];