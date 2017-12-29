<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/29
 * Time: 下午1:49
 */

namespace common\widgets\nav;


use yii\bootstrap\Html;

class Breadcrumbs extends \yii\widgets\Breadcrumbs
{

    public $itemTemplate = "<li><strong>{link}</strong></li>\n";

    /**
     * 去掉  homeLink， 导航不需要默认的 根导航
     *
     * @return string|void
     * @throws \yii\base\InvalidConfigException
     */
    public function run()
    {
        if (empty($this->links)) {
            return;
        }
        $links = [];
        foreach ($this->links as $link) {
            if (!is_array($link)) {
                $link = ['label' => $link];
            }
            $links[] = $this->renderItem($link, isset($link['url']) ? $this->itemTemplate : $this->activeItemTemplate);
        }
        echo Html::tag($this->tag, implode('', $links), $this->options);
    }

}