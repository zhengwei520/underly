<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/4
 * Time: 下午9:17
 */

namespace server\user;

interface UserInterface
{

    const EVENT_USER_LOGIN_LOG = 'user.event_user_login_log';
    const EVENT_USER_SENDER_SMS = 'user.event_user_sender_sms';
    const EVENT_USER_SENDER_EMAIL = 'user.event_user_sender_email';

    /**
     * 登录
     *
     * @param array $params [
     *                      'account',
     *                      'password'
     *                      'app_id'
     *                      ]
     * @param bool  $isApi  是否api
     *
     * @return mixed
     */
    public function login(array $params, $isApi = false);

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
     * @return mixed
     */
    public function register(array $params, $isApi = false);

}

