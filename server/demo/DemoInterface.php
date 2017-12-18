<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/4
 * Time: 下午9:15
 */

namespace server\demo;


interface DemoInterface
{

    const EVENT_DEMO_TEST = 'demo.event_demo_test';

    public function getList();

}