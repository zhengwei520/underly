<?php

namespace backend\modules\dashboard\controllers;

use backend\common\core\base\Controller;


/**
 * Default controller for the `dashboard` module
 */
class DefaultController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = '@backend/views/layouts/body';
        return $this->render('index');
    }
    
}
