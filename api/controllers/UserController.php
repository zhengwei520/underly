<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/8
 * Time: 上午10:53
 */

namespace api\controllers;

use api\common\core\base\Controller;

class UserController extends Controller
{

    public function actionIndex()
    {

        var_dump(\Yii::$app->user->getIdentity());
        die;
        return [1];
    }

}                                                                                                                   