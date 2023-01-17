<?php

/**
 * Handles the creation of table `{{%chat_sessions}}`.
 */
class m230117_130915_create_chat_sessions_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%chat_sessions}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'session_id' => $this->string(40)->notNull(),
            'status' => $this->tinyInteger(2)->notNull()->defaultValue(0),
        ]));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName());
    }
}