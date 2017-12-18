<?php

namespace server\demo\dao;

use Yii;

/**
 * This is the model class for table "{{%demo}}".
 *
 * @property integer $id
 * @property string  $name
 * @property integer $created_at
 * @property integer $updated_at
 */
class Demo extends \common\core\server\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%demo}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'created_at', 'updated_at'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['name'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'name'       => '名称',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }
}
