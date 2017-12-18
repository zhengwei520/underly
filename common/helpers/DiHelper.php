<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/13
 * Time: 上午11:11
 */

namespace common\helpers;

class DiHelper
{

    protected static function getTargetFile(array $name)
    {
        $root = \Yii::getAlias('@server');
        $reader = new \lengbin\helper\directory\ReadDirHelper($root);
        $reader->setIsNamespace(true);
        $reader->setTargetDir($name);
        return $reader->getFileNames();
    }

    protected static function getConstants($class)
    {
        $reflect = new \ReflectionClass($class);
        $constants = $reflect->getConstants();
        return array_values($constants);
    }

    protected static function getDi()
    {
        $di = [];
        $events = [];
        $impls = self::getTargetFile(['impl']);
        $triggers = self::getTargetFile(['trigger']);
        foreach ($triggers as $trigger) {
            $name = $trigger::name();
            $events[$name] = $trigger;
        }
        foreach ($impls as $impl) {
            $event = [];
            $interfaces = class_implements($impl);
            $interface = array_pop($interfaces);
            $constants = self::getConstants($interface);
            foreach ($constants as $constant) {
                if (isset($events[$constant])) {
                    $event[] = $events[$constant];
                }
            }
            $di[$interface] = [
                'class'  => $impl,
                'events' => $event,
            ];
        }
        return $di;
    }

    protected static function getCacheDi()
    {
        $key = 'common.config_container_singletons';
        $cache = \Yii::$app->commonCache;
        $di = $cache->get($key);
        $di = $di ? $di : [];
        if (empty($di)) {
            $di = self::getDi();
            $cache->set($key, $di);
        }
        return $di;
    }

    public static function di()
    {
        return YII_ENV === 'prod' ? self:: getCacheDi() : self::getDi();
    }


}