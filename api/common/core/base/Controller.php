<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/8
 * Time: 上午12:26
 */

namespace api\common\core\base;

use common\core\base\RestController;
use common\core\filter\QueryParamAuth;
use yii\helpers\ArrayHelper;

class Controller extends RestController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors = ArrayHelper::merge($behaviors, [
            'queryParamAuth' => [
                'class' => QueryParamAuth::className(),
            ],
        ]);
        return $behaviors;
    }
}