<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2018/1/16
 * Time: 下午1:56
 */

namespace common\queue;

use yii\base\BaseObject;
use yii\queue\JobInterface;
use yii\queue\Queue;

/**
 *
 *  'bootstrap'  => [
 *      'queue', // 把这个组件注册到控制台
 *  ],
 *
 * components [
 *
 *  'queue'       => [
 *      'class'     => \yii\queue\db\Queue::class,
 *          'as log'    => \yii\queue\LogBehavior::class,
 *          'db'        => 'db',
 *          'tableName' => '{{%queue}}', // 表名
 *          'channel'   => 'default', // Queue channel key
 *          'mutex'     => \yii\mutex\MysqlMutex::class, // Mutex that used to sync queries
 *          'ttr'       => 2 * 60, // Max time for anything job handling
 *          'attempts'  => 3, // Max number of attempts
 *  ],
 * ]
 *
 *
 * $file = \Yii::getAlias('@api') . '/web/image.jpg';
 * \Yii::$app->queue->push(new DownloadJob([
 *      'url' => 'https://www.baidu.com/img/bd_logo1.png',
 *      'file' => $file,
 * ]));
 * Class DownloadJob
 * @package common\queue
 */
class DownloadJob extends BaseObject implements JobInterface
{

    public $url;
    public $file;

    /**
     * @param Queue $queue which pushed and is handling the job
     */
    public function execute($queue)
    {
        file_put_contents($this->file, file_get_contents($this->url));
    }
}