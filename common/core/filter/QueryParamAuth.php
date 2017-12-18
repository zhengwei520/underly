<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/10
 * Time: 下午5:50
 */

namespace common\core\filter;


use common\core\base\InvalidException;
use common\helpers\CodeHelper;

class QueryParamAuth extends \yii\filters\auth\QueryParamAuth
{

    use InvalidException;

    /**
     *
     *
     * @param \yii\web\Response $response
     *
     * @throws \yii\base\UserException
     */
    public function handleFailure($response)
    {
        $this->invalidRequestException('', CodeHelper::TOKEN_INVALID);
    }




}