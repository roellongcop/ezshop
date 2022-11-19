<?php

/**
 * Handles the creation of table `{{%products}}`.
 */
class m221114_133340_create_products_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%products}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'name' => $this->string()->notNull()->unique(),
            'categories' => $this->text(),
            'description' => $this->text(),
            'tags' => $this->text(),
            'image' => $this->string(),
            'gallery' => $this->text(),
            'regular_price' => $this->decimal(11, 2)->notNull()->defaultValue(0),
            'sale_price' => $this->decimal(11, 2)->notNull()->defaultValue(0),
            'sku' => $this->string(),
            'token' => $this->string()->notNull()->unique(),
            'slug' => $this->string()->notNull(),
            'quantity' => $this->integer()->defaultValue(0),
            'low_stock_threshold' => $this->integer()->defaultValue(0),
            'high_stock_threshold' => $this->integer()->defaultValue(0),
            'stock_threshold_status' => $this->tinyInteger(2)->defaultValue(0),
            'added_shipping_fee' => $this->decimal(11, 2)->defaultValue(0)
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