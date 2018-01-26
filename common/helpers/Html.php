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
     * @param string $name
     * @param string/array $url
     * @param array  $options
     *
     * @return string
     */
    public static function cancelButton($name = 'Cancel', $url, $options = [])
    {
        if (empty($url)) {
            $options['onclick'] = 'window.history.back()';
        }

        return (empty($url)) ? static::button($name, $options) : self::a($name, $url, $options);
    }


    /**
     * 表单 所需按钮
     *
     * @param string $url
     *
     * @return string
     */
    public static function formButton($url = '')
    {
        $buttons = [
            self::submitButton('保存', ['class' => 'btn btn-primary m-r-md']),
            self::cancelButton('取消', $url, ['class' => 'btn btn-white']),
        ];
        return self::tag('div', implode("\n", $buttons));
    }

}