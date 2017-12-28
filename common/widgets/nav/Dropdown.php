<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/27
 * Time: 下午10:00
 */

namespace common\widgets\nav;


/**
 * 如果使用的模版是 用bootstrop
 * 这不需要注册js 代码
 * 
 * Class Dropdown
 * @package common\widgets
 */
class Dropdown  extends \yii\bootstrap\Dropdown
{
    public function init()
    {
        if ($this->submenuOptions === null) {
            // @todo separate [[submenuOptions]] from [[options]] completely before 2.1 release
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


}