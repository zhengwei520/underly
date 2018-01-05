<?php

namespace backend\modules\role\controllers;

use backend\common\core\base\Controller;
use yii\base\Module;

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
        return $this->render('index', ['role' => $this->auth->getRoles()]);
    }

    public function actionEdit()
    {
        return $this->render('edit');
    }

}
