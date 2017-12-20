<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/4
 * Time: 下午9:17
 */

namespace server\user\impl;

use common\core\server\BaseServer;
use server\user\dao\User;
use server\user\dao\UserToken;
use server\user\UserInterface;


class UserImpl extends BaseServer implements UserInterface
{

    public $user;

    public function __construct(array $config = [])
    {
        $this->user = new User();
        parent::__construct($config);
    }

    /**
     *
     * 登录
     *
     * @param array $params [account, password, 'app_id']
     * @param bool  $isApi  是否app登录
     *
     * @return bool|mixed
     * @throws \yii\base\Exception
     * @throws \yii\base\UserException
     */
    public function login(array $params, $isApi = false)
    {
        $token = [];
        $model = $this->user;
        if ($isApi) {
            $model = $this->user->getUserOne([
                'account' => $params['account'],
            ]);
            if (empty($model)) {
                $this->invalidParamException('账号不存在');
            }
            if (!$model->validatePassword($params['password'], $model->password)) {
                $this->invalidParamException('密码错误');
            }
            $token = (new UserToken())->makeToken($model, $params['app_id']);
        } else {
            $model->scenario = 'login';
            $model->load($params);
        }
        if ($model->validate()) {
            \Yii::$app->user->login($this->user->getUserOne([
                'account' => $model->account,
            ]), \Yii::$app->params['user.expires_in']);
        }
        return $isApi ? $token : $model;
    }

    /**
     * 注册
     *
     * @param array $params [
     *                      'account',
     *                      'username',
     *                      'password',
     *                      'mobile',
     *                      'gender',
     *                      'email',
     *                      'face',
     *                      ]
     *
     * @param bool  $isApi  是否api
     *
     * @return array|mixed
     * @throws \yii\base\Exception
     */
    public function register(array $params, $isApi = false)
    {
        return $this->user->register($params, $isApi);
    }
}