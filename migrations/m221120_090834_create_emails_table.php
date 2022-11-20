<?php

/**
 * Handles the creation of table `{{%emails}}`.
 */
class m221120_090834_create_emails_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%emails}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'name' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'subject' => $this->string()->notNull(),
            'message' => $this->text()->notNull(),
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