<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2018/1/25
 * Time: 下午10:24
 */

namespace common\widgets;


use common\assets\DoubleBoxAsset;
use yii\bootstrap\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class DoubleBox extends Widget
{

    public $html = ['class' => '\common\helpers\Html'];
    public $leftLabel;
    public $left;
    public $rightLabel;
    public $right;
    public $name;
    public $options;
    public $selectOption;


    public function init()
    {
        parent::init();
        if (is_array($this->html)) {
            $this->html = \Yii::createObject($this->html);
        }

        if ($this->left === null) {
            $this->left = [];
        }

        if ($this->right === null) {
            $this->right = [];
        }
        if ($this->selectOption === null) {
            $this->selectOption = [];
        }
    }

    public function renderSelect()
    {
        $name = $this->name ? $this->name : $this->options['id'];
        $select = $this->html->dropDownList($name, '', [], ArrayHelper::merge([
            'multiple' => 'multiple',
            'size'     => 10,
        ], $this->selectOption));
        return $this->html->tag('div', $select, $this->options);
    }

    public function run()
    {
        parent::run();
        $view = $this->getView();
        DoubleBoxAsset::register($view);
        $json = Json::encode([
            'nonSelectedListLabel'    => $this->leftLabel,
            'selectedListLabel'       => $this->rightLabel,
            'preserveSelectionOnMove' => false,
            'moveOnSelect'            => false,
            'filterPlaceHolder'       => '',
            'doubleMove'              => true,
            'optionValue'             => "id",
            'optionText'              => "text",
            'nonSelectedList'         => $this->left,
            'selectedList'            => $this->right,
        ]);
        $id = $this->options['id'];
        $js = <<<js
            $("#{$id} select").doublebox({$json}) ;
js;
        $view->registerJs($js);
        echo $this->renderSelect();
    }

}