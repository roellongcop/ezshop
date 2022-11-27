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
            'order_no' => $this->string()->notNull()->unique(),

            'billing_firstname' => $this->string()->notNull(),
            'billing_lastname' => $this->string()->notNull(),
            'billing_email' => $this->string()->notNull(),
            'billing_mobile' => $this->string()->notNull(),
            'billing_address1' => $this->string()->notNull(),
            'billing_address2' => $this->string(),
            'billing_province_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'billing_municipality_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'billing_zip' => $this->string()->notNull(),

            'shipping_firstname' => $this->string()->notNull(),
            'shipping_lastname' => $this->string()->notNull(),
            'shipping_email' => $this->string()->notNull(),
            'shipping_mobile' => $this->string()->notNull(),
            'shipping_address1' => $this->string()->notNull(),
            'shipping_address2' => $this->string(),
            'shipping_province_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'shipping_municipality_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'shipping_zip' => $this->string()->notNull(),

            'products' => $this->text()->notNull(),
            'subtotal' => $this->decimal(11, 2)->notNull(),
            'shipping' => $this->decimal(11, 2)->notNull(),
            'total' => $this->decimal(11, 2)->notNull(),

            'payment_mode' => $this->tinyInteger(2)->notNull()->defaultValue(0),
        ]));

        $this->createIndexes($this->tableName(), [
            'billing_province_id' => 'billing_province_id',
            'billing_municipality_id' => 'billing_municipality_id',
            'shipping_province_id' => 'shipping_province_id',
            'shipping_municipality_id' => 'shipping_municipality_id',
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