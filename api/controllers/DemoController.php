<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/4
 * Time: 下午9:19
 */

namespace api\controllers;


use common\core\base\RestController;
use server\demo\DemoInterface;

class DemoController extends RestController
{

    protected $demo;

    public function __construct($id, $module, DemoInterface $demo, array $config = [])
    {
        $this->demo = $demo;
        parent::__construct($id, $module, $config);
    }

    /**
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->demo->getList();
    }

}