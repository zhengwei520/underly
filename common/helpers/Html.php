<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2018/1/24
 * Time: 上午12:06
 */

namespace common\helpers;


class Html extends \yii\helpers\Html
{

    /**
     * 取消按钮
     *
     * @param string $content
     * @param array  $options
     *
     * @return string
     */
    public static function cancelButton($content = 'Cancel', $options = [])
    {
        $options['onclick'] = 'window.history.back()';
        return static::button($content, $options);
    }

    /**
     * 表单 所需按钮
     * @return string
     */
    public static function formButton()
    {
        $buttons = [
            self::submitButton('保存', ['class' => 'btn btn-primary m-r-md']),
            self::cancelButton('取消', ['class' => 'btn btn-white']),
        ];
        return self::tag('div', implode("\n", $buttons));
    }

}