<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/5
 * Time: 下午4:28
 */

namespace common\core\base;

use Yii;
use yii\helpers\Json;
use yii\web\Response;

/**
 * yii2 错误 异常抛出
 * Class ErrorHandler
 * @package common\base
 */
class ErrorHandler extends \yii\web\ErrorHandler
{
    /**
     * 重写 yii2 错误 异常抛出，
     * 在app/config/main.php 中修改（每个应用使用不一样，配置也不一样）
     *
     * 当 yii 抛出异常时，errorHandler 会接收异常数据，yii2 会生成 html 代码片段返回在页面上
     * 由于我使用的是api接口，所以将 返回改为 json 数据
     *
     * 返回配置参数
    'response' => [
    'class' => 'yii\web\Response',
    'on beforeSend' => function ($event) {
    $response = $event->sender;
    if ($response->data !== null) {
    $data = $response->data;
    //当抛出异常时，返回数据为string, 数据需要过滤掉
    if( is_array($data) || ( $response->format == 'json' && count( json_decode($data, true) ) == 1 ) ){
    $code = \api\common\helpers\CodeHelper::SYS_SUCCESS;
    // message 默认为 系统定义
    // 当系统存在message 时， 如果数据传输过来是 json字符串，输出是转为json
    $message = \api\common\helpers\CodeHelper::getCodeText($code);
    if( isset($data['message']) && !empty( $data['message'] ) ){
    $message = json_decode($data['message']) == null ? $data['message'] : json_decode($data['message']);
    }
    $response->data = [
    'code' => isset($data['code']) ? $data['code'] : $code,
    'message' => $message,
    ];
    if( $response->data['code'] == 0 ) $response->data['data'] = $data;
    }
    // http 请求 全部为 200 请求通过。
    $response->statusCode = 200;
    // 设置 跨域问题
    $response->headers->add('Access-Control-Allow-Origin',Yii::$app->request->headers->get('Origin'));
    $response->headers->set('Access-Control-Allow-Credentials','true');
    $response->headers->set("Access-Control-Allow-Headers","Content-Type,X-Requested-With,Accept");
    $response->headers->set("Access-Control-Allow-Methods","GET,POST");
    $response->headers->set("Access-Control-Request-Methods","GET,POST");
    }
    }
    ],
     *
     * 错误配置
    'errorHandler' => [
    'class'=>'common\base\ErrorHandler',
    ],
     *
     *
     *
     *
     *
     * @param \Exception $exception
     */
    protected function renderException($exception)
    {
        if (Yii::$app->has('response')) {
            $response = Yii::$app->getResponse();
            $response->isSent = false;
            $response->stream = null;
            $response->data = null;
            $response->content = null;
        } else {
            $response = new Response();
        }

        $data = $this->convertExceptionToArray($exception);
        // 当 code 为 0 的时候 说明是 yii2 自带抛错
        if ($data['code'] === 0) {
            $data['code'] = 500;
        }
        $response->data = $data;
        $response->send();
    }

}