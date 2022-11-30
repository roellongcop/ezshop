<?php

/**
 * Handles the creation of table `{{%chats}}`.
 */
class m221130_085759_create_chats_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%chats}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'user_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'reply_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'session_id' => $this->string()->notNull(),
            'message' => 'MEDIUMTEXT',
            'status' => $this->tinyInteger(20)->notNull()->defaultValue(0),
            'type' => $this->tinyInteger(20)->notNull()->defaultValue(0),
        ]));

        $this->createIndexes($this->tableName(), [
            'reply_id' => 'reply_id',
            'user_id' => 'user_id',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName());
    }
}