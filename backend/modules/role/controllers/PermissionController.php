<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2018/1/1
 * Time: 下午9:35
 */

namespace backend\modules\role\controllers;


use backend\common\core\base\Controller;

class PermissionController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
}