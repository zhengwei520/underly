<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2018/1/6
 * Time: 下午10:49
 */

namespace common\widgets\table\helpers;


use common\assets\SweetAlertAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class ActionColumn extends Column
{
    public $actions;

    public $type;

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if ($this->type === null) {
            $this->type = 'a';
        }

        if ($this->actions === null) {
            $this->actions = [
                [
                    'title'   => '编辑',
                    'url'     => 'edit',
                    'visible' => true,
                    'option'  => [],
                ],
                [
                    'title'   => '删除',
                    'url'     => 'delete',
                    'visible' => true,
                    'option'  => ['class' => 'delete'],
                ],
            ];
        }

        $this->registerClientScript();
    }

    /**
     * @inheritdoc
     */
    protected function renderDataCellContent()
    {
        $data = [];
        foreach ($this->actions as $action) {
            $visible = ArrayHelper::getValue($action, 'visible', true);
            if (!$visible) {
                continue;
            }
            $title = ArrayHelper::getValue($action, 'title', '');
            $option = ArrayHelper::getValue($action, 'option', []);
            $content = ArrayHelper::getValue($action, 'content', $title);
            $url = ArrayHelper::getValue($action, 'url', '');
            if (is_string($url)) {
                $url = [$url];
            }
            $model = ArrayHelper::getValue($this->list->models, $this->index, []);
            $href = ArrayHelper::merge($url, ArrayHelper::merge([
                $this->list->id => ArrayHelper::getValue($model, $this->list->id),
            ], \Yii::$app->request->getQueryParams()));
            $data[] = $this->html->tag($this->type, $content, ArrayHelper::merge($option, [
                'href'  => Url::to($href),
                'title' => $title,
            ]));
        }
        return implode("\n", $data);
    }

    /**
     * Registers the needed JavaScript.
     * @since 2.0.8
     */
    public function registerClientScript()
    {
        $id = $this->list->options['id'];
        $view = $this->list->getView();
        SweetAlertAsset::register($view);
        $js = <<<js
            $("#$id .delete").click(function(){var _this=$(this);swal({title:"您确定要删除这条信息吗",text:"删除后将无法恢复，请谨慎操作！",type:"warning",showCancelButton:true,cancelButtonText:'取消',confirmButtonColor:"#DD6B55",confirmButtonText:"删除",closeOnConfirm:false,closeOnCancel:false},function(isConfirm){if(isConfirm){window.location.href=_this.attr('href')}else{swal("已取消","您取消了删除操作！","error")}});return false});
js;
        $view->registerJs($js);
    }
}