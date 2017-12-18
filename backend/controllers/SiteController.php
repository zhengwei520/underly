<?php
namespace backend\controllers;

use common\core\base\WebController;
use server\user\UserInterface;
use Yii;
use yii\base\Module;

/**
 * Site controller
 */
class SiteController extends WebController
{

    public $user;

    public function __construct($id, Module $module, UserInterface $user, array $config = [])
    {
        $this->user = $user;
        parent::__construct($id, $module, $config);
    }


    public function actionIndex()
    {
        $this->layout = 'login';
        return $this->render('index', [
            'model' => $this->user->user
        ]);
    }
}
