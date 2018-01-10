<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2018/1/8
 * Time: 下午1:38
 */

namespace common\widgets\table\helpers;


use yii\helpers\ArrayHelper;
use yii\helpers\Json;

class CheckboxColumn extends Column
{
    public $header;

    public $name = 'selection';

    public $multiple = true;

    public $cssClass;

    public $selectionOption = [];

    public function init()
    {
        parent::init();
        if ($this->header === null) {
            $this->header = $this->html->tag('input', '', ArrayHelper::merge($this->selectionOption, [
                'type'  => 'checkbox',
                'class' => 'select-on-check-all',
                'name'  => $this->name . '_all',
            ]));
        }
        $this->registerClientScript();
    }

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent()
    {
        $model = ArrayHelper::getValue($this->list->models, $this->index, []);
        return $this->html->tag('input', ArrayHelper::getValue($model, $this->list->id), ArrayHelper::merge($this->selectionOption, [
            'type'  => 'checkbox',
            'name'  => $this->name . '[]',
            'class' => 'select-on-check',
            'value' => ArrayHelper::getValue($model, $this->list->id),
        ]));
    }

    /**
     * Registers the needed JavaScript.
     * @since 2.0.8
     */
    public function registerClientScript()
    {
        $id = $this->list->options['id'];
        $view = $this->list->getView();
        $js = <<<js
            var {$this->name}_checkBox_all=$("#$id .select-on-check-all");var {$this->name}_checkBox=$("#$id .select-on-check");{$this->name}_checkBox_all.change(function(){{$this->name}_checkBox.prop('checked',$(this).prop('checked'))});{$this->name}_checkBox.change(function(){var checkAll=$("#$id .select-on-check").length===$("#$id .select-on-check:checked").length;{$this->name}_checkBox_all.prop('checked',checkAll)});
js;
        $view->registerJs($js);
    }
}