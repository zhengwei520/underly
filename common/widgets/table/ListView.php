<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2018/1/5
 * Time: 下午4:46
 */

namespace common\widgets\table;

use common\assets\UtilAsset;
use common\helpers\BaseHelper;
use common\helpers\CodeHelper;
use common\widgets\table\helpers\Action;
use common\widgets\table\helpers\Column;
use common\widgets\table\helpers\Formatter;
use common\widgets\table\helpers\LineColumn;
use common\widgets\table\helpers\SearchColumn;
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
 * 'search' => [
 *          'id',
 *          [
 *              'name' => 'account',
 *              'type' => 'select',
 *              'data' => ['a' => 'a', 'b' => 'b'],
 *          ],
 *   ],
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
 *         'a|呵呵',
 *         'b|呵呵2',
 *         'c|呵呵5',
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
 *
 *
 * @package common\widgets\table
 */
class ListView extends Widget
{
    // html 帮助类
    public $html = ['class' => '\common\helpers\Html'];
    // 动作
    public $actions = [];
    // 展示数据  ['models' => [], 'pages' => []]  or []
    public $data = [];
    // 展示列
    public $columns = [];
    // 搜索
    public $search = [];
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

        $this->initActions();
        $this->initColumns();
        $this->initSearchColumns();
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
        $matches = explode('|', $text);

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

    protected function registerClientScript()
    {
        $params = \Yii::$app->request->getQueryParams();
        $params[0] = \Yii::$app->controller->getRoute();
        $url = \Yii::$app->getUrlManager()->createUrl($params);
        $id = $this->options['id'];
        $view = $this->getView();
        UtilAsset::register($view);
        $js = <<<js
            $("#$id .list_table_search").change(function(){window.location.href=Util.changeURLArg("{$url}", $(this).attr('name'), $(this).val());});
js;
        $view->registerJs($js);
    }

    /**
     * 初始化 search
     * @throws \yii\base\InvalidConfigException
     */
    protected function initSearchColumns()
    {
        $search = [];
        foreach ($this->search as $s => $column) {
            if (is_string($column)) {
                $column = ['name' => $column, 'type' => 'text'];
            }
            $column = \Yii::createObject(array_merge([
                'class' => SearchColumn::className(),
                'html'  => $this->html,
            ], $column));
            $search[$column->name] = $column;
        }
        $this->search = $search;
        if (!empty($search)) {
            $this->registerClientScript();
        }
    }

    /**
     * 初始化 action
     * @throws \yii\base\InvalidConfigException
     */
    protected function initActions()
    {
        $operation = [];
        foreach ($this->actions as $action) {
            $operation[] = \Yii::createObject([
                'class'  => Action::className(),
                'html'   => $this->html,
                'action' => $action,
                'list'  => $this,
            ]);
        }
        if (empty($operation)) {
            $operation[] = \Yii::createObject([
                'class' => Action::className(),
                'html'  => $this->html,
                'list'  => $this,
            ]);
        }
        $this->actions = $operation;
    }

    protected function renderEmpty()
    {
        if ($this->emptyText === false) {
            return '';
        }
        return $this->html->tag('div', $this->emptyText, $this->emptyTextOptions);
    }


    protected function renderTableDataRow($model, $index)
    {
        $cells = [];
        foreach ($this->columns as $column) {
            /* @var $column Column */
            $column->index = $index;
            $cells[] = $column->renderDataCell();
        }
        $options['data-key'] = ArrayHelper::getValue($model, $this->id, $index);
        return $this->html->tag('tr', implode('', $cells), array_merge($options, $this->tableTrOption));
    }

    protected function renderTableData()
    {
        $rows = [];
        foreach ($this->models as $index => $model) {
            $rows[] = $this->renderTableDataRow($model, $index);
        }
        return $rows;
    }

    protected function renderTableSearch()
    {
        $cells = [];
        if (empty($this->search)) {
            return $cells;
        }
        $rows = [];
        foreach ($this->columns as $column) {
            /* @var $column Column */
            $rows[] = $column->renderSearchCell();
        }
        $cells[] = $this->html->tag('tr', implode('', $rows), $this->tableTrOption);
        return $cells;
    }

    protected function renderTableBody()
    {
        $rows = ArrayHelper::merge($this->renderTableSearch(), $this->renderTableData());

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

    /**
     * @return string|false
     * @throws \Exception
     */
    protected function renderPage()
    {
        if (!$this->pages) {
            return false;
        }

        return LinkPager::widget([
            'pagination'    => $this->pages,
            'prevPageLabel' => '上一页',
            'nextPageLabel' => '下一页',
        ]);
    }

    protected function renderActionRight()
    {
        $operation = [];
        foreach ($this->actions as $action){
            /* @var $action Action */
            $operation[] = $action->renderAction();
        }
        return $this->html->tag('div', implode("\n", $operation), ['class' => 'pull-right']);
    }

    protected function renderAction()
    {
        $content = array_filter([
            $this->renderActionRight(),
        ]);
        return $this->html->tag('div', implode("\n", $content), ['class' => 'clearfix m-b-sm']);
    }

    /**
     * @return string|void
     * @throws \Exception
     */
    public function run()
    {
        $action = $this->renderAction();
        $table = $this->renderTable();
        $page = $this->renderPage();
        $content = array_filter([
            $action,
            $table,
            $page,
        ]);
        echo $this->html->tag('div', implode("\n", $content), $this->options);
    }

}