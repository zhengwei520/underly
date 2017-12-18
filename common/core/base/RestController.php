<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/7
 * Time: 下午1:41
 */

namespace common\core\base;

use yii\base\Module;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use yii\rest\Controller;
use yii\web\Response;

class RestController extends Controller
{
    use \common\core\base\Controller;
    use InvalidException;

    public function __construct($id, Module $module, array $config = [])
    {
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats'] = ['application/json' => Response::FORMAT_JSON,];
        $behaviors['rateLimiter']['enableRateLimitHeaders'] = false;
        $behaviors = ArrayHelper::merge($behaviors, [
            'jsonp'    => [
                'class' => Cors::className(),
                'cors'  => [
                    'Access-Control-Request-Method'  => ['GET', 'HEAD', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['X-Request-With'],
                ],
            ],
        ]);
        return $behaviors;
    }
    

}