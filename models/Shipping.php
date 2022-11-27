<?php

namespace app\models;

use app\widgets\Anchor;

/**
 * This is the model class for table "{{%shippings}}".
 *
 * @property int $id
 * @property int $province_id
 * @property int $municipality_id
 * @property float $rate
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Shipping extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%shippings}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'shipping',
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
            [['province_id', 'municipality_id', 'rate'], 'required'],
            [['province_id', 'municipality_id'], 'integer'],
            [['rate'], 'number'],
            ['province_id', 'exist', 'targetRelation' => 'province'],
            ['municipality_id', 'exist', 'targetRelation' => 'municipality'],
            [['municipality_id', 'province_id'], 'validateExistense'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'province_id' => 'Province ID',
            'municipality_id' => 'Municipality ID',
            'rate' => 'Rate',
        ]);
    }

    public function validateExistense($attribute, $params)
    {
        if ($this->isNewRecord) {
            $shipping = self::findOne([
                'province_id' => $this->province_id,
                'municipality_id' => $this->municipality_id,
            ]);
        }
        else {
            $shipping = self::find()
                ->where([
                    'province_id' => $this->province_id,
                    'municipality_id' => $this->municipality_id,
                ])
                ->andWhere(['<>', 'id', $this->id])
                ->one();
        }


        if ($shipping) {
            $this->addError($attribute, 'Shipping already exist');
        }
    }

    public function getProvince()
    {
        return $this->hasOne(Province::class, ['id' => 'province_id']);
    }

    public function getMunicipality()
    {
        return $this->hasOne(Municipality::class, ['id' => 'municipality_id']);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\ShippingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\ShippingQuery(get_called_class());
    }
     
    public function gridColumns()
    {
        return [
            'province_id' => [
                'attribute' => 'province_id', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->province_id,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'municipality_id' => ['attribute' => 'municipality_id', 'format' => 'raw'],
            'rate' => ['attribute' => 'rate', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'province_id:raw',
            'municipality_id:raw',
            'rate:raw',
        ];
    }
}