<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/27
 * Time: 下午10:00
 */

namespace common\widgets\nav;

use yii\base\InvalidConfigException;
use yii\bootstrap\Html;
use yii\helpers\ArrayHelper;


/**
 * 如果使用的模版是 用bootstrop
 * 这不需要注册js 代码
 *
 * Class Dropdown
 * @package common\widgets
 */
class Dropdown extends \yii\bootstrap\Dropdown
{

    public function init()
    {
        if ($this->submenuOptions === null) {
            $this->submenuOptions = $this->options;
            unset($this->submenuOptions['id']);
        }
    }

    /**
     * 不注册 js 代码
     * @return string
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        return $this->renderItems($this->items, $this->options);
    }

    /**
     * 加一个 下拉图标
     *
     * @return string the rendering result.
     * @throws InvalidConfigException if the label option is not specified in one of the items.
     */
    protected function renderItems($items, $options = [])
    {
        $lines = [];
        foreach ($items as $item) {
            if (is_string($item)) {
                $lines[] = $item;
                continue;
            }
            if (isset($item['visible']) && !$item['visible']) {
                continue;
            }
            if (!array_key_exists('label', $item)) {
                throw new InvalidConfigException("The 'label' option is required.");
            }
            $encodeLabel = isset($item['encode']) ? $item['encode'] : $this->encodeLabels;
            $label = $encodeLabel ? Html::encode($item['label']) : $item['label'];
            $itemOptions = ArrayHelper::getValue($item, 'options', []);
            $linkOptions = ArrayHelper::getValue($item, 'linkOptions', []);
            $linkOptions['tabindex'] = '-1';
            $url = array_key_exists('url', $item) ? $item['url'] : null;
            if (empty($item['items'])) {
                if ($url === null) {
                    $content = $label;
                    Html::addCssClass($itemOptions, ['widget' => 'dropdown-header']);
                } else {
                    $content = Html::a($label, $url, $linkOptions);
                }
            } else {
                $submenuOptions = $this->submenuOptions;
                if (isset($item['submenuOptions'])) {
                    $submenuOptions = array_merge($submenuOptions, $item['submenuOptions']);
                }
                // 加一个 下拉图标
                $dropDownCaret = ArrayHelper::getValue($item, 'dropDownCaret', '<span class="fa arrow"></span>');
                if ($dropDownCaret !== '') {
                    $label .= ' ' . $dropDownCaret;
                }
                $content = Html::a($label, $url === null ? '#' : $url, $linkOptions);
                $content .= $this->renderItems($item['items'], $submenuOptions);
                Html::addCssClass($itemOptions, ['widget' => 'dropdown-submenu']);
            }

            $lines[] = Html::tag('li', $content, $itemOptions);
        }

        return Html::tag('ul', implode("\n", $lines), $options);
    }

}