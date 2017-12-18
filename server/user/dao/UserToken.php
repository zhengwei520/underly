<?php

namespace server\user\dao;

use Yii;

/**
 * This is the model class for table "{{%user_token}}".
 *
 * @property string   $token
 * @property integer  $user_id
 * @property string   $app_id
 * @property integer  $expires_in
 * @property integer  $forced_offline
 * @property string   $refresh_token
 * @property resource $data
 */
class UserToken extends \common\core\server\ActiveRecord
{

    public $created_at;
    public $updated_at;
    public $is_delete;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_token}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['token', 'user_id', 'app_id', 'expires_in', 'refresh_token'], 'required'],
            [['user_id', 'expires_in', 'forced_offline'], 'integer'],
            [['data'], 'string'],
            [['token', 'app_id', 'refresh_token'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'token'          => 'Token',
            'user_id'        => 'User ID',
            'app_id'         => 'app_id',
            'expires_in'     => '过期时间，单位秒',
            'forced_offline' => '挤下线，0未1是',
            'refresh_token'  => 'Refresh Token',
            'data'           => 'Data',
        ];
    }

    /**
     * 获得token 信息
     *
     * @param array $params
     * @param bool  $isAll
     *
     * @return array|null|\yii\db\ActiveRecord
     * @author lengbin(lengbin0@gmail.com)
     */
    public function getUserToken(array $params, $isAll = false)
    {
        $model = $this->find();

        if ($this->issetAndEmpty($params, 'token')) {
            $model->andWhere([
                'token' => $params['token'],
            ]);
        }
        if ($this->issetAndEmpty($params, 'app_id')) {
            $model->andWhere([
                'app_id' => $params['app_id'],
            ]);
        }
        if ($this->issetAndEmpty($params, 'user_id')) {
            $model->andWhere([
                'user_id' => $params['user_id'],
            ]);
        }

        if ($this->issetAndEmpty($params, 'expiresIn')) {
            $model->andFilterCompare('expires_in', time(), '>');
        }

        if ($this->issetAndEmpty($params, 'indexBy')) {
            $model->indexBy($params['indexBy']);
        }

        return $isAll ? $model->all() : $model->one();
    }

    /**
     * 生成token
     *
     * @param User   $user
     * @param string $appId
     *
     * @return array
     * @throws \yii\base\Exception
     */
    public function makeToken(User $user, $appId = '')
    {
        $params = [
            'user_id'        => $user->id,
            'data'           => serialize($user->getAttributes()),
            'token'          => \Yii::$app->security->generateRandomString(),
            'app_id'         => $appId ? $appId: Yii::$app->id,
            'forced_offline' => 0,
            'refresh_token'  => \Yii::$app->security->generateRandomString(),
            'expires_in'     => time() + \Yii::$app->params['user.expires_in'],
        ];
        //挤下线
        $this->forcedOffline($user->id, $appId);
        $userToken = new UserToken();
        $userToken->setAttributes($params);
        $userToken->save();
        return [
            'access_token'  => $userToken->token,
            'refresh_token' => $userToken->refresh_token,
            'expires_in'    => $userToken->expires_in,
        ];
    }

    /**
     * 当前应用 挤下线
     *
     * @param int    $userId
     * @param string $appId
     *
     * @return array|null|\yii\db\ActiveRecord
     * @author lengbin(lengbin0@gmail.com)
     */
    public function forcedOffline($userId, $appId)
    {
        $userToken = $this->getUserToken([
            'user_id'   => $userId,
            'expiresIn' => 1,
            'app_id'    => $appId,
        ]);
        if (!empty($userToken)) {
            $userToken->forced_offline = 1;
            $userToken->save();
        }
        return $userToken;
    }

    /**
     * 除了当前登录应用，其他应用 全部挤下线
     *
     * @param int $userId
     *
     * @return int
     */
    public function forcedOfflineAll($userId)
    {
        $tokens = $this->getUserToken([
            'user_id' => $userId,
            'indexBy' => 'id',
        ], true);
        $ids = array_keys($tokens);
        if (empty($ids)) {
            return 0;
        }
        return UserToken::updateAll(['forced_offline' => 1], ['id' => $ids]);
    }

}
