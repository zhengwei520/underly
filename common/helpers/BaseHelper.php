<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/2
 * Time: 下午4:58
 */

namespace common\helpers;


use yii\base\UserException;

class BaseHelper
{
    /**
     * 无效参数异常
     *
     * @param int    $code
     * @param string $message
     *
     * @throws UserException
     */
    public static function invalidException($code, $message)
    {
        if (is_array($message)) {
            $message = json_encode($message);
        }
        throw new UserException($message, $code);
    }

    /**
     * 是否序列化
     *
     * @param string $string
     *
     * @return bool
     */
    public static function isJson($string)
    {
        $data = json_decode($string, false);
        return (json_last_error() == JSON_ERROR_NONE) ? $data : $string;
    }

    /**
     * 数组json格式化
     *
     * @param array $params
     *
     * @return array
     * @author lengbin(lengbin0@gmail.com)
     */
    public static function formattingDataForJson(array $params)
    {
        $data = [];
        foreach ($params as $id => $text) {
            if (count($params) === 1) {
                $data = [
                    'id'   => $id,
                    'text' => $text,
                ];
            } else {
                $data[] = [
                    'id'   => $id,
                    'text' => $text,
                ];
            }
        }
        return $data;
    }

    /**
     * 获得 性别 类型
     *
     * @param bool $isJson
     *
     * @return array
     * @author lengbin(lengbin0@gmail.com)
     */
    public static function getGenderType($isJson = true)
    {
        $params = [
            ConstantHelper::USER_GENDER_UNDEFINED => '未知',
            ConstantHelper::USER_GENDER_MAN       => '男',
            ConstantHelper::USER_GENDER_WOMAN     => '女',
        ];
        return $isJson ? self::formattingDataForJson($params) : $params;
    }


    /**
     * 时间格式化
     *
     * @param      string /int  $date  时间/时间戳
     * @param bool $isInt 是否为int
     *
     * @return array
     * @author lengbin(lengbin0@gmail.com)
     */
    public static function formattingDay($date, $isInt = true)
    {
        if (is_int($date)) {
            $date = date('Y-m-d', $date);
        }
        $start = $date . ' 00:00:00';
        $end = $date . ' 23:59:59';
        if ($isInt) {
            $start = strtotime($start);
            $end = strtotime($end);
        }
        return [$start, $end];
    }

    /**
     * 时间格式化
     *
     * @param      string /int  $start  时间/时间戳
     * @param      string /int  $end  时间/时间戳
     * @param bool $isInt 是否为int
     *
     * @return array
     * @author lengbin(lengbin0@gmail.com)
     */
    public static function formattingDays($start, $end, $isInt = true)
    {
        if (is_int($start)) {
            $start = date('Y-m-d', $start);
        }
        if (is_int($end)) {
            $end = date('Y-m-d', $end);
        }
        $start = $start . ' 00:00:00';
        $end = $end . ' 23:59:59';
        if ($isInt) {
            $start = strtotime($start);
            $end = strtotime($end);
        }
        return [$start, $end];
    }

    /**
     * 时间格式化
     *
     * @param   int $month 月份
     * @param bool  $isInt 是否为int
     *
     * @return array
     * @author lengbin(lengbin0@gmail.com)
     */
    public static function formattingMonth($month, $isInt = true)
    {
        if (strlen($month) < 3) {
            $month = date("Y-{$month}-d");
        }
        $timestamp = strtotime($month);
        $startTime = date('Y-m-1 00:00:00', $timestamp);
        $mdays = date('t', $timestamp);
        $endTime = date('Y-m-' . $mdays . ' 23:59:59', $timestamp);
        if ($isInt) {
            $startTime = strtotime($startTime);
            $endTime = strtotime($endTime);
        }
        return [$startTime, $endTime];
    }
    
}