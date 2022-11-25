<?php

/**
 * Handles the creation of table `{{%reviews}}`.
 */
class m221124_115350_create_reviews_table extends \app\migrations\Migration
{
    public function tableName()
    {
        return '{{%reviews}}';
    }

    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable($this->tableName(), $this->attributes([
            'product_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'user_id' => $this->bigInteger(20)->notNull()->defaultValue(0),
            'score' => $this->tinyInteger(2)->notNull()->defaultValue(1),
            'name' => $this->string()->notNull(),
            'email' => $this->string()->notNull(),
            'review' => $this->text()->notNull(),
            'status' => $this->tinyInteger(2)->notNull()->defaultValue(0),
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