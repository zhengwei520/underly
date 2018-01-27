<?php

namespace backend\modules\role\controllers;

use backend\common\core\base\Controller;
use common\core\models\Role;
use yii\base\Module;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * Default controller for the `role` module
 */
class DefaultController extends Controller
{

    private $auth;

    public function __construct($id, Module $module, array $config = [])
    {
        $this->auth = \Yii::$app->authManager;
        parent::__construct($id, $module, $config);
    }


    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        //
        //        // 添加 "createPost" 权限
        //        $createPost = $auth->createPermission('createPost');
        //        $createPost->description = 'Create a post';
        //        $auth->add($createPost);
        //
        //        // 添加 "updatePost" 权限
        //        $updatePost = $auth->createPermission('updatePost');
        //        $updatePost->description = 'Update post';
        //        $auth->add($updatePost);
        //
        //        // 添加 "author" 角色并赋予 "createPost" 权限
        //        $author = $auth->createRole('author');
        //        $auth->add($author);
        //        $auth->addChild($author, $createPost);
        //
        //        // 添加 "admin" 角色并赋予 "updatePost"
        //        // 和 "author" 权限
        //        $admin = $auth->createRole('admin');
        //        $auth->add($admin);
        //        $auth->addChild($admin, $updatePost);
        //        $auth->addChild($admin, $author);
        //
        //        // 为用户指派角色。其中 1 和 2 是由 IdentityInterface::getId() 返回的id （译者注：user表的id）
        //        // 通常在你的 User 模型中实现这个函数。
        //        $auth->assign($author, 22);
        //        $auth->assign($admin, 21);
        //
        //        // 添加规则
        //        $rule = new AuthorRule();
        //        $auth->add($rule);
        //
        //        // 添加 "updateOwnPost" 权限并与规则关联
        //        $updateOwnPost = $auth->createPermission('updateOwnPost');
        //        $updateOwnPost->description = 'Update own post';
        //        $updateOwnPost->ruleName = $rule->name;
        //        $auth->add($updateOwnPost);
        //
        //        // "updateOwnPost" 权限将由 "updatePost" 权限使用
        //        $auth->addChild($updateOwnPost, $updatePost);
        //
        //        // 允许 "author" 更新自己的帖子
        //        $auth->addChild($author, $updateOwnPost);

        //'role' => $this->auth->getRoles()

        //        //$uid = \Yii::$app->user->id;
        //        $uid = 21;
        //        //$this->auth->getRolesByUser($uid)
        //        //
        //
        //        var_dump($this->auth->getPermissionsByUser(21), $this->auth->getPermissionsByUser(22));
        $role = new Role();
        return $this->render('index', ['role' => $role->getRoles()]);
    }

    protected function asArray(array $roles, array $excepts = [])
    {
        $data = [];
        foreach ($roles as $key => $role) {
            if (isset($excepts[$key])) {
                continue;
            }
            $name = ArrayHelper::getValue($role, 'name');
            $data[] = [
                'id'   => $name,
                'text' => $name,
            ];
        }
        return $data;
    }

    protected function getOtherPermission(Role $model, &$childRoles, &$permissions)
    {
        foreach ($childRoles as $name => $role) {
            if ((string)$name === (string)$model->name) {
                unset($childRoles[$name]);
                continue;
            }
            $rolePermissions = $model->getPermissionsByRole($name);
            foreach ($permissions as $key => $permission) {
                if (isset($rolePermissions[$permission['id']])) {
                    unset($permissions[$key]);
                    array_push($permissions, [
                        'id'   => $permission['id'],
                        'text' => $permission['id'] . '(' . $name . ')',
                    ]);
                }
            }
        }
    }

    protected function getRoleData(Role $model)
    {
        $childRoles = $model->getChildRoles();
        $otherRoles = $this->asArray($model->getRoles(), $childRoles);
        $childPermission = $model->getPermissionsByRole();
        $permissions = $this->asArray($childPermission);
        $this->getOtherPermission($model, $childRoles, $permissions);
        return [
            'model'           => $model,
            'roleLeft'        => $otherRoles,
            'roleRight'       => $this->asArray($childRoles),
            'permissionLeft'  => $this->asArray($model->getPermissions(), $childPermission),
            'permissionRight' => $permissions,
            'params'          => \Yii::$app->request->getQueryParams(),
        ];
    }

    public function actionAdd()
    {
        $role = new Role();
        return $this->render('edit', $this->getRoleData($role));
    }

    /**
     * @return string
     * @throws \yii\base\UserException
     */
    public function actionEdit()
    {
        $obj = new Role();
        $name = \Yii::$app->request->get('name');
        $role = $obj->getRoleByName($name);
        $obj->setAttributes(ArrayHelper::toArray($role), false);
        return $this->render('edit', $this->getRoleData($obj));
    }

    /**
     * @return string|\yii\web\Response
     * @throws \Exception
     */
    public function actionUpdate()
    {
        $this->isPost();
        $params = \Yii::$app->request->post();
        $role = new Role();
        if ($role->load($params) && $role->validate(['name', 'description'])) {
            $role->updateRole($params) ? $this->successAlert() : $this->errorAlert();
            return $this->redirect(Url::to(['index']), true);
        }
        return $this->render('edit', $this->getRoleData($role));
    }

    /**
     * @return \yii\web\Response
     * @throws \yii\base\UserException
     */
    public function actionDelete()
    {
        $name = \Yii::$app->request->get('name');
        (new Role())->remove($name);
        $this->successAlert('删除成功');
        return $this->redirect(Url::to(['index']), true);
    }
}
