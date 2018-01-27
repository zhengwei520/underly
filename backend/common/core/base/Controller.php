<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/8
 * Time: 上午12:26
 */

namespace backend\common\core\base;

use common\core\base\WebController;
use yii\helpers\ArrayHelper;

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

    public function successAlert($message = '保存成功')
    {
        $this->alert('success', $message);
    }

    public function infoAlert($message)
    {
        $this->alert('info', $message);
    }

    public function warningAlert($message)
    {
        $this->alert('warning', $message);
    }

    public function errorAlert($message = '保存失败')
    {
        $this->alert('error', $message);
    }

    public function redirect($url, $returnPage = false)
    {
        if ($returnPage) {
            $params = \Yii::$app->request->getQueryParams();
            ArrayHelper::remove($params, 'id');
            $url = ArrayHelper::merge((array)$url, $params);
        }
        return parent::redirect($url);
    }

}