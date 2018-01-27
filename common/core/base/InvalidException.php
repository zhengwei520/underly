<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/6
 * Time: 下午5:33
 */

namespace common\core\base;

use common\helpers\BaseHelper;
use common\helpers\CodeHelper;
use yii\base\UserException;


trait InvalidException
{

    /**
     * 参数无效异常
     *
     * @param int    $code
     * @param string $message
     *
     * @throws UserException
     */
    public function invalidParamException($message = '', $code = CodeHelper::SYS_PARAMS_ERROR)
    {
        if ($message == '') {
            $message = CodeHelper::getCodeText($code);
        }
        BaseHelper::invalidException($code, $message);
    }

    /**
     * 表单无效异常
     *
     * @param int    $code
     * @param string $message
     *
     * @throws UserException
     */
    public function invalidFormException($message = '', $code = CodeHelper::SYS_FORM_ERROR)
    {
        if ($message == '') {
            $message = CodeHelper::getCodeText($code);
        }
        BaseHelper::invalidException($code, $message);
    }

    /**
     * 请求无效异常
     *
     * @param int    $code
     * @param string $message
     *
     * @throws UserException
     */
    public function invalidRequestException($message = '', $code = CodeHelper::SYS_REQUEST_ERROR)
    {
        if ($message == '') {
            $message = CodeHelper::getCodeText($code);
        }
        BaseHelper::invalidException($code, $message);
    }

    /**
     * 其他无效异常
     *
     * @param int    $code
     * @param string $message
     *
     * @throws UserException
     */
    public function invalidOtherException($message = '', $code = CodeHelper::SYS_OTHER_ERROR)
    {
        if ($message == '') {
            $message = CodeHelper::getCodeText($code);
        }
        BaseHelper::invalidException($code, $message);
    }

    /**
     * @throws \yii\base\UserException
     */
    public function isPost()
    {
        if (!\Yii::$app->request->isPost) {
            $this->invalidRequestException();
        }
    }

    /**
     * 判断字段 是否 存在并且不为空
     *
     * @param array  $params
     * @param string $filed
     * @param bool   $isValidateZero 是否验证
     *
     * @return bool
     */
    public function issetAndEmpty(array $params, $filed, $isValidateZero = false)
    {
        $status = false;
        if (isset($params[$filed]) && !empty($params[$filed])) {
            $status = true;
            // 验证 大于0 如果不满足 为false
            if ($isValidateZero && (int)$params[$filed] === 0) {
                $status = false;
            }
        }
        return $status;
    }

}