<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/8
 * Time: 上午12:26
 */

namespace backend\common\core\base;

use common\core\base\WebController;

class Controller extends WebController
{
    /**
     * @param $action
     *
     * @return bool|\yii\web\Response
     * @throws \yii\web\BadRequestHttpException
     */
    public function beforeAction($action)
    {
        if (\Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        return parent::beforeAction($action); 
    }

    public function alert($type, $message)
    {
        \Yii::$app->session->setFlash($type, $message);
    }

    public function success($message)
    {
        $this->alert('success', $message);
    }

    public function info($message)
    {
        $this->alert('info', $message);
    }

    public function warning($message)
    {
        $this->alert('warning', $message);
    }

    public function error($message)
    {
        $this->alert('error', $message);
    }

}