<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/29
 * Time: 上午11:23
 */

namespace common\core\filter;


use yii\base\Component;
use yii\helpers\ArrayHelper;

/**
 * 导航 权限 过滤器
 * config.php
 * 'components' => [
 *      'nav' => [
 *          'class' => \common\core\filter\Menu::className(),
 *          //'role' => ['root', 'admin', 'user'],
 *          // 'admin' => 'admin',
 *          // 'api' => '1',
 *      ],
 *  ],
 *  //参数 ， 导航参数
 *  'params' => [
 *      'nav' => [
 *                  'label'       => '控制面板',
 *                  'url'         => '/dashboard/statistics',
 *                  'permission'  => 'all',
 *                 // 'role'      => 'all',
 *                  'items'           => [
 *
 *                   ]
 *              ],
 *   ]
 *
 *
 * Class Menu
 * @package common\core\filter
 */
class Menu extends Component
{

    /**
     * 是否为接口导航，用于前后端分离
     * @var bool
     */
    public $api = false;
    /**
     * 菜单 导航数据
     * @var array
     */
    public $menus;
    /**
     * 超级管理员账号 默认为 root 账号
     * @var string
     */
    public $admin = 'root';

    /**
     * 验证角色组
     * @var array
     */
    public $role = [];

    /**
     * 导航
     * @var array
     */
    private $menu = [];

    /**
     * 递归导航状态
     * @var bool
     */
    private $status = false;

    /**
     * 初始化
     */
    public function init()
    {
        parent::init();
        if ($this->menus === null) {
            $this->menus = isset(\Yii::$app->params['nav']) ? \Yii::$app->params['nav'] : [];
        }
    }

    /**
     * 获得 数据
     *
     * @param array $item
     *
     * @return array
     */
    protected function getLabel($item)
    {
        return [
            'label' => ArrayHelper::getValue($item, 'label'),
            'url'   => ArrayHelper::getValue($item, 'url'),
        ];
    }

    /**
     * 菜单处理逻辑
     * 递归 获得菜单
     *
     * @param array $items
     * @param bool  $isRecord 是否记录
     *
     * @return array
     */
    protected function menusProcess($items, $isRecord = true)
    {
        $data = [];
        foreach ($items as $key => $item) {
            // 权限
            // 如果是超级管理员账号, 直接通过
            $identity = \Yii::$app->user->identity;
            $visible = (isset($identity['account']) ? $identity['account'] : '') === $this->admin ? true : false;
            if (!$visible) {
                // 根据验证角色组是否有值，判断走那种验证规则
                // 如果为空 或者 all , 通过
                if ($this->role) {
                    $role = ArrayHelper::getValue($item, 'role', []);
                    if (empty($role) || $role === 'all' || array_intersect($this->role, $role)) {
                        $visible = true;
                    }
                } else {
                    $permission = ArrayHelper::getValue($item, 'permission', 'all');
                    if ($permission === 'all' || \Yii::$app->user->can($permission)) {
                        $visible = true;
                    }
                }
            }
            $item['visible'] = $visible;
            $breadcrumb = $this->getLabel($item);
            $key = ArrayHelper::getValue($item, 'key', null);
            if ($key !== null) {
                $breadcrumb['key'] = $key;
            }
            //如果有子项， 递归，数据不记录，但是要返回 当前子项的权限
            if (!empty($item['items'])) {
                $item['items'] = $this->menusProcess($item['items'], false);
                $breadcrumb['items'] = $item['items'];
            }
            //当是 api的时候， 如果菜单没的权限，则为空，过滤掉数据
            $menu = $this->api ? ($visible ? $breadcrumb : []) : $item;
            if (!empty($menu)) {
                $data[] = $menu;
                if ($isRecord) {
                    $this->menu[] = $menu;
                }
            }
        }
        return $data;
    }

    /**
     * 获得 菜单
     * @return array
     */
    public function getMenu()
    {
        $this->menusProcess($this->menus);
        return $this->menu;
    }

    /**
     * 面包屑处理逻辑
     * 递归 获得面包屑
     *
     * @param array  $items
     * @param string $path 当前访问url path(路径）
     *
     * @return array
     */
    protected function menusBreadcrumb($items, $path)
    {
        $breadcrumbs = [];
        foreach ($items as $item) {
            // 当 递归状态 为true的时候, 递归结束
            if ($this->status) {
                break;
            }
            //每次循环，清空数据。应为当前没有匹配到 url path
            $breadcrumbs = [];
            // 如果没有设置 url 参数， 过滤
            if (!isset($item['url'])) {
                continue;
            }
            $breadcrumbs[] = $this->getLabel($item);
            // 当url参数 等于当前访问 url 路径,递归结束
            if ($item['url'] === $path) {
                $this->status = true;
                break;
            }
            // 如果有子项，递归。 与父数据合并
            if (!empty($item['items'])) {
                $breadcrumb = $this->menusBreadcrumb($item['items'], $path);
                $breadcrumbs = ArrayHelper::merge($breadcrumbs, $breadcrumb);
            }
        }
        return $breadcrumbs;
    }

    /**
     * 获得面包屑
     * @return array
     */
    public function getBreadcrumb()
    {
        $currentUrl = parse_url(\Yii::$app->request->absoluteUrl);
        $path = isset($currentUrl['path']) ? $currentUrl['path'] : '/';
        return $this->menusBreadcrumb($this->menus, $path);
    }

}