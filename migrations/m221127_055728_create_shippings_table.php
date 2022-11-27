<?php

/**
 * Handles the creation of table `{{%shippings}}`.
 */
class m221127_055728_create_shippings_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%shippings}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'province_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'municipality_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'rate' => $this->decimal(11, 2)->notNull()->defaultValue(0),
        ]));

        $this->createIndexes($this->tableName(), [
            'province_id' => 'province_id',
            'municipality_id' => 'municipality_id',
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