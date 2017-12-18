<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/12/5
 * Time: 下午4:03
 */

namespace common\core\server;

use common\core\base\InvalidException;
use common\helpers\ConstantHelper;
use yii\base\Component;
use yii\base\Event;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

class BaseServer extends Component
{

    use InvalidException;

    /**
     * 设置事件
     * @param $events
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function setEvents($events)
    {
        // 检测 当前事件是否是 EventInterface 接口实现的
        foreach ($events as $event) {
            $interfaces = class_implements($event);
            if (in_array(TriggerInterface::class, $interfaces)) {
                $object = \Yii::createObject($event);
                $eventName = call_user_func([$object, 'name']);
                $this->on($eventName, [$object, 'run']);
            }
        }
    }

    /**
     * 触发事件
     *
     * @param      $name
     * @param null $params
     *
     * @return BaseEvent|null|Event
     */
    public function triggerServer($name, $params = null)
    {
        if ($params instanceof Event) {
            $event = $params;
        } else {
            $event = new BaseEvent();
            $event->params = $params;
        }
        parent::trigger($name, $event);
        return $event;
    }

    /**
     * 列表的数据转义
     *
     * @param array $data   数据
     * @param array $fields 转义字段
     * @param array $rule   规则 默认为字符串，['xx' => 'html']
     *
     * @return array
     * @author lengbin(lengbin0@gmail.com)
     */
    public function htmlSpecialChars(array $data, array $fields, array $rule = [])
    {
        if (empty($data) || empty($fields)) {
            return $data;
        }
        $result = isset($data['models']) ? $data['models'] : $data;
        foreach ($result as $key => $d) {
            foreach ($fields as $field) {
                if (is_null($d[$field])) {
                    $d[$field] = '';
                }
                $html = (isset($rule[$field]) && $rule[$field] === 'html') ? HtmlPurifier::process($d[$field]) : Html::encode($d[$field]);
                $result[$key][$field] = $html;
            }
        }
        if (isset($data['models'])) {
            $data['models'] = $result;
        } else {
            $data = $result;
        }
        return $data;
    }

    /**
     * 通过id获得数据
     *
     * @param ActiveRecord $model
     * @param int          $id
     * @param bool         $isDelete 是否条件有is_delete
     *
     * @return array|null|\yii\db\ActiveRecord
     * @throws \yii\base\UserException
     */
    public function getById(ActiveRecord $model, $id, $isDelete = true)
    {
        $object = $model->find()->where([
            'id' => $id,
        ]);
        if ($isDelete) {
            $object->andWhere([
                'is_delete' => ConstantHelper::NOT_DELETE,
            ]);
        }
        $data = $object->one();
        if (empty($data)) {
            $this->invalidParamException('id不存在');
        }
        return $data;
    }

    /**
     * 添加 / 更新
     *
     * @param ActiveRecord $model
     * @param array        $params
     * @param bool         $isDelete
     *
     * @return array|ActiveRecord|null|\yii\db\ActiveRecord
     * @throws \yii\base\UserException
     */
    public function updateByParams(ActiveRecord $model, array $params, $isDelete = true)
    {
        if ($this->issetAndEmpty($params, 'id', true)) {
            $object = $this->getById($model, 'id', $isDelete);
        } else {
            $object = $model;
        }
        $object->setAttributes($params);
        $object->save();
        return $object;
    }

    /**
     * 通过id删除数据
     *
     * @param ActiveRecord $model
     * @param int          $id
     * @param bool         $isDelete 是否条件有is_delete
     *
     * @return array|null|\yii\db\ActiveRecord
     * @throws \yii\base\UserException
     */
    public function deleteById(ActiveRecord $model, $id, $isDelete = true)
    {
        $object = $this->getById($model, $id, $isDelete);
        $object->setAttribute('is_delete', 1);
        $object->save();
        return $object;
    }

}