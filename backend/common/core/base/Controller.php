<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/8
 * Time: 上午12:26
 */

namespace backend\common\core\base;

use common\core\base\WebController;
use yii\filters\auth\HttpBasicAuth;
use yii\helpers\ArrayHelper;

class Controller extends WebController
{

    public function behaviors()
    {
        $behaviors = parent::behaviors();
//        $behaviors = ArrayHelper::merge($behaviors, [
//            'basicAuth' => [
//                'class' => HttpBasicAuth::className(),
//            ],
//        ]);
        return $behaviors;
    }
}