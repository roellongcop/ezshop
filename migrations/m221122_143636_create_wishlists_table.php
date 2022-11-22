<?php

/**
 * Handles the creation of table `{{%wishlists}}`.
 */
class m221122_143636_create_wishlists_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%wishlists}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'user_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'product_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
        ]));

        $this->createIndexes($this->tableName(), [
            'user_id' => 'user_id',
            'product_id' => 'product_id',
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