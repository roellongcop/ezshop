<?php

/**
 * Handles the creation of table `{{%carts}}`.
 */
class m221126_041118_create_carts_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%carts}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'product_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'user_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'color' => $this->string(),
            'size' => $this->string(),
            'quantity' => $this->integer(),
        ]));

        $this->createIndexes($this->tableName(), [
            'product_id' => 'product_id',
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