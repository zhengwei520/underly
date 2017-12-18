<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/6
 * Time: 下午3:25
 */

namespace common\core\server;

use common\core\base\InvalidException;
use yii\base\Event;

class BaseEvent extends Event
{

    use InvalidException;

    public $params;
    
}