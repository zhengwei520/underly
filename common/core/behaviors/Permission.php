<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2018/1/21
 * Time: 上午10:42
 */

namespace common\core\behaviors;


use common\helpers\BaseHelper;
use common\helpers\CodeHelper;
use yii\base\Behavior;
use yii\base\Controller;
use yii\helpers\ArrayHelper;

class Permission extends Behavior
{

    public $isValidate;

    private $isRecord;

    private $permission;

    public function events()
    {
        $events = parent::events();
        $events = ArrayHelper::merge($events, [
            Controller::EVENT_AFTER_ACTION => 'addPermission',
            Controller::EVENT_BEFORE_ACTION=> 'validatePermission',
        ]);
        return $events;
    }

    public function init()
    {
        parent::init();

        if ($this->isValidate === null) {
            $this->isValidate = false;
        }

        $this->isRecord = ArrayHelper::getValue(\Yii::$app->params, 'initPermission', YII_ENV_DEV);
        $this->permission = DIRECTORY_SEPARATOR . \Yii::$app->controller->uniqueId . DIRECTORY_SEPARATOR . \Yii::$app->controller->action->id;
    }

    /**
     * @param $event
     *
     * @return mixed
     * @throws \Exception
     */
    public function addPermission($event)
    {
        $auth = \Yii::$app->authManager;
        $hasPermission = $auth->getPermission($this->permission);
        if ($this->isRecord && $hasPermission === null) {
            $add = $auth->createPermission($this->permission);
            $add->description = $this->permission;
            $auth->add($add);
        }
        return $event;
    }

    /**
     * @throws \yii\base\UserException
     */
    public function validatePermission()
    {
        if ($this->isValidate && !\Yii::$app->user->can($this->permission)) {
            BaseHelper::invalidException(CodeHelper::TOKEN_PERMISSION_ERROR, CodeHelper::getCodeText(CodeHelper::TOKEN_PERMISSION_ERROR));
        }
    }

}