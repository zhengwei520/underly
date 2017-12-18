<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/8
 * Time: 上午9:58
 */

namespace api\controllers;


use common\core\base\RestController;
use server\user\UserInterface;
use yii\base\Module;

class LoginController extends RestController
{

    protected $user;

    public function __construct($id, Module $module, UserInterface $user, array $config = [])
    {
        $this->user = $user;
        parent::__construct($id, $module, $config);
    }

    /**
     * 登录
     *
     * @return mixed
     * @throws \yii\base\UserException
     */
    public function actionIndex()
    {
        //$params = \Yii::$app->request->post();
        $params = \Yii::$app->request->get();
        $data = $this->validateRequestParams($params, [
            'account',
            'password',
        ]);
        $data['app_id'] = \Yii::$app->id;
        return $this->user->login($data, true);
    }

    /**
     * 注册
     * @return array
     * @throws \yii\base\UserException
     */
    public function actionRegister()
    {
        $param = \Yii::$app->request->post();
        $data = $this->validateRequestParams($param, [
            'account',
            'username',
            'password',
            'mobile',
            'gender',
            'email',
            'face',
        ]);
        $this->user->register($data, true);
        return [];
    }

}