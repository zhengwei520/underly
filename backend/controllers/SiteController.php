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
        $model = $this->user->user;
        if(Yii::$app->request->isPost){
            $params = Yii::$app->request->post();
            $model = $this->user->login($params);
            if($model->validate()){
                return $this->redirect(Yii::$app->urlManager->createUrl('dashboard'));
            }
        }
        return $this->render('index', [
            'model' => $model
        ]);
    }
}
