<?php

use yii\db\Migration;

class m180116_031833_queue extends Migration
{
    public $tableName = '{{%queue}}';

    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

        $this->createTable($this->tableName, [
            'id'          => $this->primaryKey(),
            'channel'     => $this->string()->notNull(),
            'job'         => $this->binary()->notNull(),
            'pushed_at'   => $this->integer(),
            'ttr'         => $this->integer(),
            'delay'       => $this->integer()->defaultValue(0),
            'priority'    => $this->integer()->unsigned()->notNull()->defaultValue(1024),
            'reserved_at' => $this->integer(),
            'attempt'     => $this->integer(),
            'done_at'     => $this->integer(),
        ], $tableOptions . ' comment \'消息队列\'');
        $this->createIndex('channel', $this->tableName, 'channel');
        $this->createIndex('reserved_at', $this->tableName, 'reserved_at');
        $this->createIndex('priority', $this->tableName, 'priority');
    }

    public function down()
    {
        $this->dropTable($this->tableName);
    }
    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
