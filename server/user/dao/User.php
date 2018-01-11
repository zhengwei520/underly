<?php

namespace server\user\dao;

use common\core\validators\MobileValidator;
use common\helpers\BaseHelper;
use common\helpers\CodeHelper;
use common\helpers\ConstantHelper;
use Yii;
use yii\db\Query;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string  $account
 * @property string  $username
 * @property string  $auth_key
 * @property string  $password
 * @property string  $mobile
 * @property integer $gender
 * @property string  $email
 * @property string  $face
 * @property string  $address
 * @property integer $is_delete
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends \common\core\server\ActiveRecord implements IdentityInterface
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['account', 'password'], 'required'],
            [['gender', 'is_delete', 'created_at', 'updated_at'], 'integer'],
            [['address'], 'string'],
            [['account', 'username', 'auth_key'], 'string', 'max' => 32],
            [['password'], 'string', 'max' => 60, 'min' => 6],
            [['mobile'], 'string', 'max' => 15],
            [['email', 'face'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['mobile'], MobileValidator::className()],
            [['account', 'mobile', 'email'], 'unique', 'on' => 'register'],
            [['password'], 'validatePasswordRole', 'on' => 'login']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'account'    => '账号',
            'username'   => '昵称',
            'auth_key'   => 'Auth Key',
            'password'   => '密码',
            'mobile'     => '手机号',
            'gender'     => '性别',
            'email'      => '邮箱',
            'face'       => '头像',
            'address'    => '地址',
            'is_delete'  => '是否删除',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array  $params    the additional name-value pairs given in the rule
     */
    public function validatePasswordRole($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUserOne(['account' => $this->account]);
            if (!$user || !$user->validatePassword($this->password, $user->password)) {
                $this->addError($attribute, '无效账号或密码.');
            }
        }
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     *
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password, $hash)
    {
        return Yii::$app->security->validatePassword($password . Yii::$app->params['user.password_hash'], $hash);
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param int|string $id
     *
     * @return array|null|\yii\db\ActiveRecord|IdentityInterface
     * the ID to be looked for the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return self::find()->where([
            'id'        => $id,
            'is_delete' => ConstantHelper::NOT_DELETE,
        ])->one();
    }

    /**
     * Finds an identity by the given token.
     *
     * @param mixed $token the token to be looked for
     * @param mixed $type  the type of the token. The value of this parameter depends on the implementation.
     *                     For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     *
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     *
     * @throws \yii\base\UserException
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        self::$isApi = true;
        $userToken = (new UserToken())->getUserToken([
            'token'  => $token,
            'app_id' => Yii::$app->id,
        ]);
        // 是否有效
        if (empty($userToken)) {
            BaseHelper::invalidException(CodeHelper::TOKEN_INVALID, CodeHelper::getCodeText(CodeHelper::TOKEN_INVALID));
        }
        // 是否 过期
        if ($userToken->expires_in < time()) {
            BaseHelper::invalidException(CodeHelper::TOKEN_EXPIRES, CodeHelper::getCodeText(CodeHelper::TOKEN_EXPIRES));
        }
        // 是否其他地方登录
        if ($userToken->forced_offline == 1) {
            BaseHelper::invalidException(CodeHelper::TOKEN_OFFLINE, CodeHelper::getCodeText(CodeHelper::TOKEN_OFFLINE));
        }
        return self::findIdentity($userToken->user_id);
    }

    /**
     * Returns an ID that can uniquely identify a user identity.
     * @return string|int an ID that uniquely identifies a user identity.
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     *
     * @param string $authKey the given auth key
     *
     * @return bool whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * 用户查询条件
     *
     * @param Query $model
     * @param array $params
     *
     * @return mixed
     */
    private function getUserWhere(Query $model, array $params)
    {
        if ($this->issetAndEmpty($params, 'id')) {
            $model->andWhere(['id' => $params['id']]);
        }

        if ($this->issetAndEmpty($params, 'account')) {
            $model->andWhere(['account' => $params['account']]);
        }

        if ($this->issetAndEmpty($params, 'username')) {
            $model->andWhere(['like', 'username', $params['username']]);
        }

        if ($this->issetAndEmpty($params, 'mobile')) {
            $model->andWhere(['mobile' => $params['mobile']]);
        }

        if ($this->issetAndEmpty($params, 'email')) {
            $model->andWhere(['email' => $params['email']]);
        }

        return $model;
    }


    /**
     * 获得用户数据
     *
     * @param array $params
     * @param bool  $isAll
     *
     * @return array
     */
    public function getUser(array $params, $isAll = false)
    {
        $model = new Query();
        $model->from($this->tableName());
        $model = $this->getUserWhere($model, $params);
        $this->order($model);
        return $isAll ? $model->all() : $this->page($model);
    }

    /**
     * 获得 一个 用户数据
     *
     * @param array $params
     *
     * @return mixed
     */
    public function getUserOne(array $params)
    {
        $model = $this->find()->where(['is_delete' => ConstantHelper::NOT_DELETE]);
        return $this->getUserWhere($model, $params)->one();
    }

    /**
     * 注册
     *
     * @param array $params [
     *                      'account',
     *                      'username',
     *                      'password',
     *                      'mobile',
     *                      'gender',
     *                      'email',
     *                      'face',
     *                      ]
     *
     * @param bool  $isApi  是否api
     *
     * @return array|mixed
     * @throws \yii\base\Exception
     */
    public function register(array $params, $isApi = false)
    {
        self::$isApi = $isApi;
        if ($this->issetAndEmpty($params, 'id')) {
            $user = $this->getUserOne(['id' => $params['id']]);
            if (empty($user)) {
                $this->invalidParamException('用户不存在');
            }
        } else {
            $user = new User();
            $user->auth_key = \Yii::$app->security->generateRandomString();
        }
        $user->scenario = 'register';
        $user->setAttributes($params);
        $user->save();
        if ($this->issetAndEmpty($params, 'password')) {
            $password = $params['password'] . Yii::$app->params['user.password_hash'];
            $user->password = \Yii::$app->security->generatePasswordHash($password);
            $user->save();
        }
        return $user;
    }
}
