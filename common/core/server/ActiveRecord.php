<?php

/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2017/2/6
 * Time: 下午3:17
 */

namespace common\core\server;

use common\core\base\InvalidException;
use yii\base\InvalidConfigException;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\data\Pagination;
use yii\data\Sort;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\validators\Validator;

class ActiveRecord extends \yii\db\ActiveRecord
{

    use InvalidException;

    public static $isApi = false;

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors = ArrayHelper::merge($behaviors, [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
            'isDelete'  => [
                'class'      => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'is_delete',
                ],
                'value'      => function ($event) {
                    return 0;
                },
            ],
        ]);
        return $behaviors;
    }

    /**
     * 分页
     *
     * @param Query $query
     * @param int   $pageSize
     *
     * @return array
     *
     * @auth ice.leng(lengbin@geridge.com)
     * @issue
     */
    public function page(Query $query, $pageSize = 10)
    {
        $count = $query->count();
        $pageSize = ArrayHelper::getValue(\Yii::$app->request->getQueryParams(), 'per-page', $pageSize);
        $pages = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);
        $models = $query->offset($pages->offset)->limit($pages->limit)->all();
        return [
            'models' => $models,
            'pages'  => $pages,
        ];
    }

    public function order(Query &$query, $defaultOrder = null)
    {
        $model = get_called_class();
        $attributeLabels = $model::attributeLabels();
        $attributes = array_keys($attributeLabels);
        $order = new Sort([
            'attributes' => $attributes,
        ]);
        $query->orderBy($order->orders);
        if ($defaultOrder) {
            $query->addOrderBy($defaultOrder);
        }
        return $query;
    }


    /**
     * debug
     *
     * @param Query $query
     */
    public function debugForQuery(Query $query)
    {
        echo $query->createCommand()->sql;
        var_dump($query->createCommand()->params);
        die;
    }

    /**
     * 重构 save 方法，如果保存有错误，跑出错误
     *
     * @param bool $runValidation
     * @param null $attributeNames
     *
     * @return bool
     * @throws
     */
    public function save($runValidation = true, $attributeNames = null)
    {
        $row = parent::save($runValidation, $attributeNames);
        if (!$this->validate() && self::$isApi) {
            $this->invalidFormException($this->getFirstErrors());
        }
        return $row;
    }

    /**
     * 重构  setAttributes 方法，去掉 为空的数据
     *
     * @param array $values
     * @param bool  $safeOnly
     */
    public function setAttributes($values, $safeOnly = true)
    {
        foreach ($values as $key => $value) {
            if (is_null($value)) {
                unset($values[$key]);
            }
        }
        parent::setAttributes($values, $safeOnly);
    }

    /**
     * 重构 创建规则规则
     *
     * 添加 字段 trim
     *
     * @return \ArrayObject
     * @throws InvalidConfigException
     */
    public function createValidators()
    {
        $rules = $this->rules();
        $key = array_keys($this->attributeLabels());
        $rules[] = [$key, 'trim'];
        $validators = new \ArrayObject();
        foreach ($rules as $rule) {
            if ($rule instanceof Validator) {
                $validators->append($rule);
            } elseif (is_array($rule) && isset($rule[0], $rule[1])) { // attributes, validator type
                $validator = Validator::createValidator($rule[1], $this, (array)$rule[0], array_slice($rule, 2));
                $validators->append($validator);
            } else {
                throw new InvalidConfigException('Invalid validation rule: a rule must specify both attribute names and validator type.');
            }
        }
        return $validators;
    }
}