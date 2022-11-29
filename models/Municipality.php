<?php

namespace app\models;

use app\widgets\Anchor;

/**
 * This is the model class for table "{{%municipalities}}".
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $province_no
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Municipality extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%municipalities}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'municipality',
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
            [['province_no'], 'integer'],
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
            'province_no' => 'Province No',
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\MunicipalityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\MunicipalityQuery(get_called_class());
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
            'province_no' => ['attribute' => 'province_no', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'name:raw',
            'province_no:raw',
        ];
    }
}