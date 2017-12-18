<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-api',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                if ($response->data !== null && Yii::$app->controller->module->id !== 'gii') {
                    $data = $response->data;
                    $code = \common\helpers\CodeHelper::SYS_SUCCESS;
                    // message 默认为 系统定义
                    $message = \common\helpers\CodeHelper::getCodeText($code);
                    if( isset($data['message']) && !empty( $data['message'] ) ){
                        $message = \common\helpers\BaseHelper::isJson($data['message']);
                    }
                    $response->data = [
                        'code' => isset($data['code']) ? $data['code'] : $code,
                        'message' => $message,
                    ];
                    if( $response->data['code'] === $code ) {
                        $response->data['data'] = $data;
                    }
                    // http 请求 全部为 200 请求通过。
                    $response->statusCode = 200;
                    $response->format = \yii\web\Response::FORMAT_JSON;
                }
            }
        ],
        'user' => [
            'identityClass' => 'server\user\dao\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
            'loginUrl' => null,
            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'class'=>'common\core\base\ErrorHandler',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
    ],
    'params' => $params,
];
