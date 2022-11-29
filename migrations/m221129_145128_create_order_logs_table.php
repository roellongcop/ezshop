<?php

/**
 * Handles the creation of table `{{%order_logs}}`.
 */
class m221129_145128_create_order_logs_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%order_logs}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'order_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'remarks' => $this->text(),
            'status' => $this->tinyInteger(2)->notNull()->defaultValue(0),
        ]));

        $this->createIndexes($this->tableName(), [
            'order_id' => 'order_id',
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