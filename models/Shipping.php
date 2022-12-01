<?php

namespace app\models;

use app\helpers\App;
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
            'province_id' => 'Province',
            'municipality_id' => 'Municipality',
            'provinceName' => 'Province',
            'municipalityName' => 'Municipality',
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

    public function getProvinceName()
    {
        return App::if($this->province, fn($province) => $province->name);
    }

    public function getMunicipality()
    {
        return $this->hasOne(Municipality::class, ['id' => 'municipality_id']);
    }

    public function getMunicipalityName()
    {
        return App::if($this->municipality, fn($municipality) => $municipality->name);
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
            'province' => [
                'attribute' => 'provinceName', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->provinceName,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'municipality' => ['attribute' => 'municipalityName', 'format' => 'raw'],
            'rate' => ['attribute' => 'rate', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'provinceName:raw',
            'municipalityName:raw',
            'rate:raw',
        ];
    }

    public function getProvinceNo()
    {
        return App::if($this->province, fn($province) => $province->no);
    }

    public static function findByKeywords($keywords='', $attributes='', $limit=10, $andFilterWhere=[])
    {
        return parent::findByKeywordsData($attributes, function($attribute) use($keywords, $limit, $andFilterWhere) {
            return self::find()
                ->select("{$attribute} AS data")
                ->alias('s')
                ->joinWith(['province p', 'municipality m'])
                ->groupBy($attribute)
                ->where(['LIKE', $attribute, $keywords])
                ->andFilterWhere($andFilterWhere)
                ->limit($limit)
                ->asArray()
                ->all();
        });
    }
}