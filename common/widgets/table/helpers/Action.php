<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2018/1/23
 * Time: 上午10:47
 */

namespace common\widgets\table\helpers;


use common\helpers\BaseHelper;
use common\helpers\CodeHelper;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;

class Action extends BaseObject
{
    public $html = ['class' => '\yii\helpers\Html'];

    public $list;

    public $action;

    public $type;

    public $defaultAction;

    public $actionTemplate;

    private $isSubmit = false;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if ($this->type === null) {
            $this->type = 'a';
        }

        if ($this->actionTemplate === null) {
            $this->actionTemplate = [
                'add'    => [
                    'title'   => '添加',
                    'url'     => 'add',
                    'visible' => true,
                    'option'  => ['class' => "btn btn-primary"],
                ],
                'delete' => [
                    'title'   => '批量删除',
                    'url'     => 'delete',
                    'type'    => 'submit',
                    'visible' => true,
                    'option'  => ['class' => "btn btn-primary"],
                ],
            ];
        }

        if ($this->defaultAction === null) {
            $this->defaultAction = 'add';
        }

        if ($this->action === null) {
            $this->action = $this->defaultAction;
        }

        if (is_array($this->html)) {
            $this->html = \Yii::createObject($this->html);
        }
    }


    /**
     *
     * @return string
     * @throws \yii\base\UserException
     */
    public function renderAction()
    {
        if (is_string($this->action)) {
            $this->action = ArrayHelper::getValue($this->actionTemplate, $this->action, []);
        }
        if (empty($this->action)) {
            BaseHelper::invalidException(CodeHelper::SYS_PARAMS_ERROR, '操作参数错误');
        }
        $visible = ArrayHelper::getValue($this->action, 'visible', true);
        if (!$visible) {
            return '';
        }
        $type = ArrayHelper::getValue($this->action, 'type', $this->type);
        $title = ArrayHelper::getValue($this->action, 'title', '');
        $option = ArrayHelper::getValue($this->action, 'option', []);
        $content = ArrayHelper::getValue($this->action, 'content', $title);
        $url = ArrayHelper::getValue($this->action, 'url', '');
        if (is_string($url)) {
            $url = [$url];
        }
        if ($type === 'submit') {
            $type = 'button';
            $option['type'] = 'submit';
            $class = ArrayHelper::getValue($option, 'class', '');
            $class .= ' actionSubmit';
            $option['class'] = $class;
            if (!$this->isSubmit) {
                $this->isSubmit = true;
                $this->registerClientScript();
            }
        }
        return $this->html->tag($type, $content, ArrayHelper::merge($option, [
            'href'  => Url::to($url),
            'title' => $title,
        ]));
    }

    /**
     *
     */
    public function registerClientScript()
    {
        $id = $this->list->options['id'];
        $view = $this->list->getView();
        $option = [
            'method' => 'post',
            'action' => '',
            'id'     => 'actionSubmitForm',
        ];
        \Yii::$app->request->csrfToken;
        $csrf = $this->html->input('hidden',\Yii::$app->request->csrfParam, \Yii::$app->request->csrfToken);
        $p = Json::encode($option);
        $js = <<<js
            $("#{$id}").wrapInner($('<form>').attr({$p})); $("#{$id} #actionSubmitForm").append('{$csrf}');$("#{$id} .actionSubmit").click(function(){ $("#{$id} #actionSubmitForm").attr('action', $(this).attr('href'));});
js;
        $view->registerJs($js);
    }

}