<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2018/1/19
 * Time: 下午10:17
 */

namespace common\widgets\table\helpers;

use common\helpers\BaseHelper;
use common\helpers\CodeHelper;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;

class SearchColumn extends BaseObject
{

    public $html = ['class' => '\common\helpers\Html'];

    public $name;

    public $type;

    public $data;

    public $options;

    private $types = ['text', 'select'];


    /**
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\UserException
     */
    public function init()
    {
        parent::init();
        if (!in_array($this->type, $this->types)) {
            BaseHelper::invalidException(CodeHelper::SYS_PARAMS_ERROR, '查询条件类型不支持， 当前只支持 text, select');
        }

        if (is_array($this->html)) {
            $this->html = \Yii::createObject($this->html);
        }
    }

    public function renderSearchCellContent()
    {
        $params = \Yii::$app->request->getQueryParams();
        $value = ArrayHelper::getValue($params, $this->name);
        $defaultClass = 'list_table_search';
        $class = ArrayHelper::remove($this->options, 'class');
        $class = $defaultClass . ' ' . $class;
        $options = ArrayHelper::merge($this->options, ['class' => $class]);
        switch ($this->type) {
            case 'text':
                $content = $this->html->textInput($this->name, $value, $options);
                break;
            case 'select':
                $options = ArrayHelper::merge($options, ['prompt' => '请选择']);
                $content = $this->html->dropDownList($this->name, $value, $this->data, $options);
                break;
            default:
                $content = '';
                break;

        }
        return $content;
    }

}