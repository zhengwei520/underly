<?php

namespace backend\modules\role\controllers;

use backend\common\core\base\Controller;


/**
 * Default controller for the `role` module
 */
class DefaultController extends Controller
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
