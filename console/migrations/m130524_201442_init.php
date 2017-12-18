<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%demo}}', [
            'id'         => $this->primaryKey(),
            'name'       => $this->string(32)->notNull()->comment('名称'),
            'created_at' => $this->integer()->notNull()->comment('创建时间'),
            'updated_at' => $this->integer()->notNull()->comment('更新时间'),
        ], $tableOptions . ' comment \'demo\'');
        

        $this->createTable('{{%user}}', [
            'id'         => $this->primaryKey(),
            'account'    => $this->string(32)->comment('账号'),
            'username'   => $this->string(32)->notNull()->comment('昵称'),
            'auth_key'   => $this->string(32)->notNull(),
            'password'   => $this->char(60)->notNull()->comment('密码'),
            'mobile'     => $this->string(15)->comment('手机号'),
            'gender'     => $this->smallInteger(1)->defaultValue(0)->comment('性别'),
            'email'      => $this->string()->comment('邮箱'),
            'face'       => $this->string()->comment('头像'),
            'address'    => $this->text()->comment('地址'),
            'is_delete'  => $this->smallInteger(1)->notNull()->defaultValue(0)->comment('是否删除'),
            'created_at' => $this->integer()->comment('创建时间'),
            'updated_at' => $this->integer()->comment('更新时间'),
        ], $tableOptions . ' comment \'用户表\'');

        $this->createTable('{{%user_token}}', [
            'token'          => $this->string()->notNull(),
            'user_id'        => $this->integer()->notNull(),
            'app_id'         => $this->string()->notNull()->comment('app_id'),
            'expires_in'     => $this->integer()->notNull()->comment('过期时间，单位秒'),
            'forced_offline' => $this->smallInteger(1)->defaultValue(0)->notNull()->comment('挤下线，0未1是'),
            'refresh_token'  => $this->string()->notNull(),
            'data'           => $this->binary(),
        ], $tableOptions . ' comment \'token\'');
        $this->addPrimaryKey('user_token_PK', '{{%user_token}}', ['token']);
        
    }

    public function down()
    {
        $this->dropTable('{{%demo}}');
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%user_token}}');
    }
}
