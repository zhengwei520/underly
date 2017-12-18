<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/6
 * Time: 下午9:30
 */

namespace common\core\server;



interface TriggerInterface
{

    /**
     * 绑定事件名称
     * @return string
     */
    public static function name();

    /**
     * 执行
     *
     * @param BaseEvent $event
     *
     * @return mixed
     */
    public function run(BaseEvent $event);

}