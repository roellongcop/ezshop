<?php

namespace app\models;

use app\widgets\Anchor;

/**
 * This is the model class for table "{{%provinces}}".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $no
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Province extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%provinces}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'province',
            'mainAttribute' => 'id',
            'paramName' => 'id',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return $this->setRules([
            [['no'], 'integer'],
            [['name'], 'string', 'max' => 50],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'name' => 'Name',
            'no' => 'No',
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\ProvinceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ProvinceQuery(get_called_class());
    }
     
    public function gridColumns()
    {
        return [
            'name' => [
                'attribute' => 'name', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->name,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'no' => ['attribute' => 'no', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'name:raw',
            'no:raw',
        ];
    }
}