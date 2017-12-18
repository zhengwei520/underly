<?php

namespace common\helpers;

/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/2
 * Time: 下午4:57
 */
class CodeHelper
{

    // code 字典
    public static $codes;

    /**
     * 错误信息
     *
     * @param string $code code
     *
     * @return string
     *
     * @auth ice.leng(lengbin@geridge.com)
     * @issue
     */
    public static function getCodeText($code)
    {
        if (is_null(self::$codes)) {
            self::$codes = self::init();
        }
        return self::$codes[$code];
    }

    /**--------------code 常量-------------------**/
    /*
     *  code  编码分类 code 长度为 6位
     *
     *  0开头  为 系统
     *  1开头  为 项目
     *
     *
     *  以此为例,仅供参考,待补充
     */
    /** 系统 保留 http code **/
    CONST SYS_SUCCESS = 0;
    CONST SYS_PARAMS_ERROR = 1;
    CONST SYS_FORM_ERROR = 2;
    CONST SYS_OTHER_ERROR = 3;
    CONST SYS_REQUEST_ERROR = 4;
    /** 系统 **/

    const TOKEN_INVALID = 10;
    const TOKEN_EXPIRES = 11;
    const TOKEN_OFFLINE = 12;
    const TOKEN_SIGN_ERROR = 13;
    const TOKEN_PERMISSION_ERROR = 14;
    /**--------------code 常量-------------------**/


    /**
     * 字典
     * @return array
     *
     * @auth ice.leng(lengbin@geridge.com)
     * @issue
     */
    public static function init()
    {
        /*
         *  code  编码分类 code 长度为 6位
         *  0开头  为 系统
         *  1开头  为 项目
         *
         *
         *  以此为例,仅供参考,待补充
         */
        return [
            /** 系统 **/
            self::SYS_SUCCESS            => 'Success',
            self::SYS_PARAMS_ERROR       => '请求参数错误',
            self::SYS_FORM_ERROR         => '请求表单参数错误',
            self::SYS_REQUEST_ERROR      => '请求错误',
            /** 系统 **/
            /** 登录 **/
            self::TOKEN_INVALID          => '无效token, 请联系管理员',
            self::TOKEN_EXPIRES          => 'token已到期，请重新登录',
            self::TOKEN_OFFLINE          => '当前账号在其他地方登录，请重新登录',
            self::TOKEN_SIGN_ERROR       => '签名错误',
            self::TOKEN_PERMISSION_ERROR => '当前账号没有权限访问',
            /** 登录 **/
        ];
    }

}