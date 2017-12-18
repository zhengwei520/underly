<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/4
 * Time: 下午9:17
 */

namespace server\demo\impl;

use common\core\server\BaseServer;
use server\demo\dao\Demo;
use server\demo\DemoInterface;
use server\user\UserInterface;


class DemoImpl extends BaseServer implements DemoInterface
{

    public $demo;
    public $user;

    public function __construct(UserInterface $user, array $config = [])
    {
        $this->demo = new Demo();
        $this->user = $user;
        parent::__construct($config);
    }


    public function getList()
    {
        $data = $this->triggerServer(self::EVENT_DEMO_TEST, ['a' => 1]) ;
        return ['a' => 1];
    }

}