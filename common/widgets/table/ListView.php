<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2018/1/5
 * Time: 下午4:46
 */

namespace common\widgets\table;

use common\helpers\BaseHelper;
use common\helpers\CodeHelper;
use common\widgets\table\helpers\Column;
use common\widgets\table\helpers\Formatter;
use common\widgets\table\helpers\LineColumn;
use yii\base\Widget;
use yii\helpers\ArrayHelper;

/**
 * Class ListView
 * [
 *      'data' => [
 *          ['a' => '1', 'b' => 2, 'c' => 3],
 *          ['a' => '1', 'b' => 2, 'c' => 3],
 *          ['a' => '1', 'b' => 2, 'c' => 3],
 *  ],
 *  'order' => 'all',
 *  'columns' => [
 *         [
 *          'class' => \common\widgets\table\helpers\ActionColumn::className(),
 *          ‘action’ => [[
 *                  'title' => ''
 *                  ‘url’   => [] / '',
 *                ]]
 *         ],
 *         [
 *            'class' => \common\widgets\table\helpers\Column::className(),
 *             'headerOption' => ['class' => '1'],
 *             'attribute' => 'c'
 *         ],
 *         '#',
 *         'a:呵呵',
 *         'b:呵呵2',
 *         'c:呵呵5',
 *         [
 *          'class' => \common\widgets\table\helpers\ActionColumn::className(),
 *          ‘action’ => [[
 *                  'title' => ''
 *                  ‘url’   => [] / '',
 *                ]]
 *         ],
 *  ],
 *
 * ])
 * @package common\widgets\table
 */
class ListView extends Widget
{
    // html 帮助类
    public $html = ['class' => '\yii\helpers\Html'];
    // 展示数据  ['models' => [], 'pages' => []]  or []
    public $data = [];
    // 展示列
    public $columns = [];
    //排序列 默认不排序， 指定排序字段，支持别名字段, all 表示所有
    public $order;
    //id
    public $id = 'id';
    // order by
    public $orderParam = 'sort';
    // 空数据展示
    public $emptyText;
    // 空数据样式
    public $emptyTextOptions = ['class' => 'empty'];
    // table option
    public $tableOptions = ['class' => 'table table-striped table-bordered'];
    public $tableThOption = [];
    public $tableTrOption = [];
    public $sortOption = [];

    // div option
    public $options = ['class' => 'grid-view'];
    // page option
    public $pageOption = [];

    public $formatter;

    public $models;
    public $pages;

    /**
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\base\UserException
     */
    public function init()
    {
        parent::init();
        if (is_array($this->html)) {
            $this->html = \Yii::createObject($this->html);
        }

        if ($this->formatter === null) {
            $this->formatter = \Yii::createObject(['class' => Formatter::className()]);
        } elseif (is_array($this->formatter)) {
            $this->formatter = \Yii::createObject($this->formatter);
        }
        if (!$this->formatter instanceof Formatter) {
            BaseHelper::invalidException(CodeHelper::SYS_PARAMS_ERROR, 'The "formatter" property must be either a Format object or a configuration array.');
        }

        // 分离数据
        $page = ArrayHelper::getValue($this->data, 'pages');
        if ($page !== null) {
            $this->pages = $page;
            $this->models = ArrayHelper::getValue($this->data, 'models');
        } else {
            $this->models = $this->data;
        }

        if ($this->emptyText === null) {
            $this->emptyText = \Yii::t('yii', 'No results found.');
        }

        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }

        if (is_string($this->order)) {
            $this->order = strtolower($this->order) === 'all' ? $this->defaultColumns() : [$this->order];
        }
        if ($this->order === null) {
            $this->order = [];
        }

        $this->initColumns();
    }

    /**
     * 如果 没有列数据，默认从数据中拉取
     */
    protected function defaultColumns()
    {
        if (empty($this->models)) {
            return [];
        }
        $models = $this->models;
        $model = array_shift($models);
        $columns = array_keys($model);;
        if (empty($this->columns)) {
            $this->columns = $columns;
        }
        return $columns;
    }

    /**
     * 创建数据列 对象
     *
     * @param $text
     *
     * @return mixed
     *
     * @throws \yii\base\InvalidConfigException
     */
    protected function createDataColumn($text)
    {
        $matches = explode(':', $text);

        return \Yii::createObject([
            'class'     => $text === '#' ? LineColumn::className() : Column::className(),
            'list'      => $this,
            'attribute' => $matches[0],
            'label'     => isset($matches[1]) ? $matches[1] : null,
            'format'    => isset($matches[2]) ? $matches[2] : 'text',
            'html'      => $this->html,
        ]);
    }

    /**
     * 初始化 列
     * @throws \yii\base\InvalidConfigException
     */
    protected function initColumns()
    {
        if (empty($this->columns)) {
            $this->defaultColumns();
        }
        foreach ($this->columns as $i => $column) {
            if (is_string($column)) {
                $column = $this->createDataColumn($column);
            } else {
                $column = \Yii::createObject(array_merge([
                    'class' => Column::className(),
                    'list'  => $this,
                    'html'  => $this->html,
                ], $column));
            }
            if (!$column->visible) {
                unset($this->columns[$i]);
                continue;
            }
            $this->columns[$i] = $column;
        }
    }

    protected function registerJs()
    {
        //        $id = $this->options['id'];
        //        $options = Json::htmlEncode($this->getClientOptions());
        //        $view = $this->getView();
        //        GridViewAsset::register($view);
        //        $view->registerJs("jQuery('#$id').yiiGridView($options);");
    }


    protected function renderEmpty()
    {
        if ($this->emptyText === false) {
            return '';
        }
        return $this->html->tag('div', $this->emptyText, $this->emptyTextOptions);
    }


    protected function renderTableRow($model, $index)
    {
        $cells = [];
        foreach ($this->columns as $column) {
            /* @var $column Column */
            $column->index = $index;
            $column->value = ArrayHelper::getValue($model, $column->attribute);
            $cells[] = $column->renderDataCell();
        }
        $options['data-key'] = ArrayHelper::getValue($model, $this->id, $index);
        return $this->html->tag('tr', implode('', $cells), array_merge($options, $this->tableTrOption));
    }

    protected function renderTableBody()
    {
        $rows = [];
        foreach ($this->models as $index => $model) {
            $rows[] = $this->renderTableRow($model, $index);
        }

        if (empty($rows) && $this->emptyText !== false) {
            $colspan = count($this->columns);
            return "<tbody>\n<tr><td colspan=\"$colspan\">" . $this->renderEmpty() . "</td></tr>\n</tbody>";
        }

        return "<tbody>\n" . implode("\n", $rows) . "\n</tbody>";

    }

    protected function renderTableHeader()
    {
        $cells = [];
        foreach ($this->columns as $column) {
            /* @var $column Column */
            $cells[] = $column->renderHeaderCell();
        }
        $content = $this->html->tag('tr', implode('', $cells), $this->tableThOption);
        return "<thead>\n" . $content . "\n</thead>";
    }


    protected function renderTable()
    {
        $tableHeader = $this->renderTableHeader();
        $tableBody = $this->renderTableBody();
        $content = array_filter([
            $tableHeader,
            $tableBody,
        ]);
        return $this->html->tag('table', implode("\n", $content), $this->tableOptions);
    }

    protected function renderPage()
    {

    }


    public function run()
    {
        // 注册 资源文件
        $this->registerJs();
        $table = $this->renderTable();
        $page = $this->renderPage();
        $content = array_filter([
            $table,
            $page,
        ]);
        echo $this->html->tag('div', implode("\n", $content), $this->options);
    }

}