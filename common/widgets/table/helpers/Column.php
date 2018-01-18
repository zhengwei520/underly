<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2018/1/6
 * Time: 下午2:22
 */

namespace common\widgets\table\helpers;


use yii\base\BaseObject;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

/**
 * table 列生成类
 *
 * Class Column
 * @package common\helpers
 */
class Column extends BaseObject
{

    public $html = ['class' => '\yii\helpers\Html'];

    public $list;

    public $attribute;

    public $header;

    public $label;

    public $format;

    public $value;

    public $index;

    public $visible = true;

    public $thOption = [];

    public $tdOption = [];


    public $emptyContent = '';

    /**
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        if (is_array($this->html)) {
            $this->html = \Yii::createObject($this->html);
        }
    }

    /**
     * create sort link
     *
     * @param string $attribute
     * @param array  $options
     *
     * @return mixed
     */
    protected function sortLink($attribute, $options = [])
    {
        $params = \Yii::$app->request->getQueryParams();
        $class = '';
        if (isset($params[$this->list->orderParam]) && !empty($params[$this->list->orderParam])) {
            if (strncmp($params[$this->list->orderParam], '-', 1) === 0) {
                $orderBy = substr($params[$this->list->orderParam], 1);
                if ($attribute === $orderBy) {
                    $class = 'desc';
                    $attribute = $orderBy;
                }
            } else {
                if ($attribute === $params[$this->list->orderParam]) {
                    $class = 'asc';
                    $attribute = '-' . $params[$this->list->orderParam];
                }
            }
            if (!empty($class)) {
                if (isset($options['class'])) {
                    $options['class'] .= ' ' . $class;
                } else {
                    $options['class'] = $class;
                }
            }
        }

        $params[$this->list->orderParam] = $attribute;
        $params[0] = \Yii::$app->controller->getRoute();
        $url = \Yii::$app->getUrlManager()->createUrl($params);

        if (isset($options['label'])) {
            $label = $options['label'];
            unset($options['label']);
        } else {
            $label = Inflector::camel2words($attribute);
        }

        return $this->html->a($label, $url, $options);
    }

    /**
     * get th content
     * @return mixed|string
     */
    protected function getHeaderCellContent()
    {
        if ($this->header !== null || $this->label === null && $this->attribute === null) {
            return $this->emptyContent;
        }

        $label = $this->html->encode($this->label ? $this->label : $this->attribute);

        // sort link
        if ($this->attribute !== null && in_array($this->attribute, $this->list->order)) {
            return $this->sortLink($this->attribute, array_merge($this->list->sortOption, ['label' => $label]));
        }

        return $label;

    }

    /**
     * create th content
     *
     * @return mixed|string
     */
    protected function renderHeaderCellContent()
    {
        return trim($this->header) !== '' ? $this->header : $this->getHeaderCellContent();
    }

    /**
     * create th
     *
     * @return mixed
     */
    public function renderHeaderCell()
    {
        return $this->html->tag('th', $this->renderHeaderCellContent(), $this->thOption);
    }

    protected function getDataCellContent()
    {
        $model = $this->list->models[$this->index];
        if ($this->value !== null) {
            if ($this->value instanceof \Closure) {
                return call_user_func($this->value, $model, $this);
            }
            return $this->value;
        } elseif ($this->attribute !== null) {
            return ArrayHelper::getValue($model, $this->attribute);
        }

        return $this->emptyContent;
    }

    /**
     *  td  content
     * @return mixed
     */
    protected function renderDataCellContent()
    {
        $value = $this->getDataCellContent();
        if ($value === null) {
            $value = $this->emptyContent;
        }
        return $this->list->formatter->format($value, explode(',', $this->format));
    }

    /**
     * create td
     * @return mixed
     */
    public function renderDataCell()
    {
        return $this->html->tag('td', $this->renderDataCellContent(), $this->tdOption);
    }
}