<?php

namespace app\models;

use app\widgets\Anchor;

/**
 * This is the model class for table "{{%provinces}}".
 *
 * @property int $id
 * @property string $provID
 * @property string|null $Province
 * @property string|null $provPath
 * @property int|null $regn
 * @property int|null $prov
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
            [['provID'], 'required'],
            [['regn', 'prov'], 'integer'],
            [['provID'], 'string', 'max' => 9],
            [['Province'], 'string', 'max' => 50],
            [['provPath'], 'string', 'max' => 33],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'provID' => 'Prov ID',
            'Province' => 'Province',
            'provPath' => 'Prov Path',
            'regn' => 'Regn',
            'prov' => 'Prov',
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
            'provID' => [
                'attribute' => 'provID', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->provID,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'Province' => ['attribute' => 'Province', 'format' => 'raw'],
            'provPath' => ['attribute' => 'provPath', 'format' => 'raw'],
            'regn' => ['attribute' => 'regn', 'format' => 'raw'],
            'prov' => ['attribute' => 'prov', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'provID:raw',
            'Province:raw',
            'provPath:raw',
            'regn:raw',
            'prov:raw',
        ];
    }
}