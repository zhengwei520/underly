<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2018/1/4
 * Time: 下午4:59
 */

namespace common\core\models;

use yii\helpers\ArrayHelper;

class Role extends \common\core\server\ActiveRecord
{

    private $auth;

    public $name;

    public $description;

    public $rule;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->auth = \Yii::$app->authManager;
    }

    public static function tableName()
    {
        return '{{%auth_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 64],
            [['description', 'rule'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name'        => '名称',
            'description' => '描述',
            'rule'        => '规则',
        ];
    }

    /**
     * 通过名称获得角色
     *
     * @param $name
     *
     * @return null|\yii\rbac\Role
     * @throws \yii\base\UserException
     */
    public function getRoleByName($name)
    {
        $role = $this->auth->getRole($name);
        if (empty($role)) {
            $this->invalidParamException();
        }
        return $role;
    }

    /**
     * 获得所有角色
     *
     * @return array|\yii\rbac\Role[]
     */
    public function getRoles()
    {
        return $this->auth->getRoles();
    }

    /**
     * 获得所有权限
     *
     * @return array|\yii\rbac\Role[]
     */
    public function getPermissions()
    {
        return $this->auth->getPermissions();
    }

    /**
     * 角色获得所有下级角色
     *
     * @param string $name
     *
     * @return array|\yii\rbac\Role[]
     */
    public function getChildRoles($name = null)
    {
        $name = $name ? $name : $this->name;
        return $name ? $this->auth->getChildRoles($name) : [];
    }

    /**
     * 角色获得所有权限
     *
     * @param string $name
     *
     * @return array|\yii\rbac\Role[]
     */
    public function getPermissionsByRole($name = null)
    {
        $name = $name ? $name : $this->name;
        return $name ? $this->auth->getPermissionsByRole($name) : [];
    }

    /**
     * 添加角色
     *
     * @param array $params
     *
     * @return bool
     * @throws \Exception
     */
    public function updateRole($params)
    {
        $auth = $this->auth->createRole($this->name);
        $auth->description = $this->description;
        $status = $this->auth->getRole($this->name) ? $this->auth->update($this->name, $auth) : $this->auth->add($auth);

        // 先删除已有的角色和权限
        $this->auth->removeChildren($this->auth->getRole($this->name));
        $role = $this->getRoleByName($this->name);
        // 子角色
        $childRoles = ArrayHelper::getValue($params, 'r', []);
        $this->batchAddRoles($role, $childRoles);
        // 权限
        $permissions = ArrayHelper::getValue($params, 'p', []);
        $this->batchAddPermission($role, $permissions);

        return $status;
    }

    /**
     * 批量添加 角色
     *
     * @param \yii\rbac\Role $role
     * @param array          $childRoles
     *
     * @throws \yii\base\Exception
     */
    public function batchAddRoles(\yii\rbac\Role $role, array $childRoles)
    {
        foreach ($childRoles as $childRole) {
            if (!$this->auth->hasChild($role, $this->auth->getRole(($childRole))) && (string)$this->name !== $childRole) {
                $this->auth->addChild($role, $this->auth->getRole(($childRole)));
            }
        }
    }

    /**
     *  批量添加 权限
     *
     * @param \yii\rbac\Role $role
     * @param array          $permissions
     *
     * @throws \yii\base\Exception
     */
    public function batchAddPermission(\yii\rbac\Role $role, array $permissions)
    {
        foreach ($permissions as $permission) {
            if (!$this->auth->hasChild($role, $this->auth->getPermission(($permission)))) {
                $this->auth->addChild($role, $this->auth->getPermission(($permission)));
            }
        }
    }


    /**
     * 删除 权限 或者 角色
     *
     * @param $name
     *
     * @return bool
     * @throws \yii\base\UserException
     */
    public function remove($name)
    {
        $role = $this->getRoleByName($name);
        $this->auth->remove($role);
        return true;
    }

}