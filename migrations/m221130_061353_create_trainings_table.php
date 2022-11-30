<?php

/**
 * Handles the creation of table `{{%trainings}}`.
 */
class m221130_061353_create_trainings_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%trainings}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'query' => $this->string()->notNull()->unique(),
            'intent' => $this->string()->notNull(),
            'response' => $this->string()->notNull(),
            'suggestion' => $this->text(),
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