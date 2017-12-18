<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/4
 * Time: 下午9:45
 */


namespace server\demo\trigger;


use common\core\server\BaseEvent;
use common\core\server\BaseTrigger;
use common\core\server\TriggerInterface;
use server\demo\DemoInterface;
use server\user\UserInterface;

class DemoTrigger extends BaseTrigger implements TriggerInterface
{

    public $user;

    public function __construct(UserInterface $user, array $config = [])
    {
        $this->user = $user;
        parent::__construct($config);
    }

    /**
     * 绑定事件名称
     * @return string
     */
    public static function name()
    {
        return DemoInterface::EVENT_DEMO_TEST;
    }

    /**
     * 执行
     *
     * @param BaseEvent $event
     *
     * @return mixed
     */
    public function run(BaseEvent $event)
    {
        $event->params = ['test' => 1];
    }
}