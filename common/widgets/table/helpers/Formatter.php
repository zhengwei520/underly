<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2018/1/6
 * Time: 下午2:44
 */

namespace common\widgets\table\helpers;


class Formatter extends \yii\i18n\Formatter
{
    public $html = ['class' => '\common\helpers\Html'];

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

}