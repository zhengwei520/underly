<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/14
 * Time: 下午4:49
 */

namespace common\core\base;


use common\core\behaviors\Permission;
use common\core\server\ActiveRecord;
use yii\base\Module;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\widgets\ActiveForm;

class WebController extends \yii\web\Controller
{
    use InvalidException;
    use Controller;

    public function __construct($id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors = ArrayHelper::merge($behaviors, [
            [
                'class'      => Permission::className(),
                'isValidate' => false,
            ],
        ]);
        return $behaviors;
    }

    /**
     * ajax 验证
     *
     * @param ActiveRecord $model
     *
     * @return array
     */
    public function ajaxValidation(ActiveRecord $model)
    {
        if (\Yii::$app->request->isAjax && $model->load(\Yii::$app->request->post())) {
            \Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
    }

}