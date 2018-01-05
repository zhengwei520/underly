<?php
/**
 * Created by PhpStorm.
 * User: lengbin
 * Date: 2018/1/4
 * Time: 下午4:59
 */

namespace common\core\models;

class Role extends \common\core\server\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description'], 'required'],
            [['name'], 'string', 'max' => 64],
            [['children'], 'each', 'rule' => ['string', 'max' => '64']],
            [['description', 'rule'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name'        => '名称',
            'description' => '描述',
            'children'    => '子级',
            'rule'        => '规则',
        ];
    }
}