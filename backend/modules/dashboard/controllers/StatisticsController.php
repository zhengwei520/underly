<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/21
 * Time: 上午1:02
 */

namespace backend\modules\dashboard\controllers;


use backend\common\core\base\Controller;

class StatisticsController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    

}