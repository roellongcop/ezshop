<?php

/**
 * Handles the creation of table `{{%orders}}`.
 */
class m221127_115236_create_orders_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%orders}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'name' => $this->string()->notNull()->unique(),
            'description' => $this->text(),
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