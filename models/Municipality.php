<?php

namespace app\models;

use Yii;
use app\helpers\App;
use app\widgets\Anchor;

/**
 * This is the model class for table "{{%municipalities}}".
 *
 * @property int $id
 * @property string $munID
 * @property string|null $Municipality
 * @property int|null $urb
 * @property string|null $munPath
 * @property int|null $regn
 * @property int|null $prov
 * @property int|null $mun
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
            [['munID'], 'required'],
            [['urb', 'regn', 'prov', 'mun'], 'integer'],
            [['munID'], 'string', 'max' => 9],
            [['Municipality'], 'string', 'max' => 50],
            [['munPath'], 'string', 'max' => 36],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'munID' => 'Mun ID',
            'Municipality' => 'Municipality',
            'urb' => 'Urb',
            'munPath' => 'Mun Path',
            'regn' => 'Regn',
            'prov' => 'Prov',
            'mun' => 'Mun',
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
            'munID' => [
                'attribute' => 'munID', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->munID,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'Municipality' => ['attribute' => 'Municipality', 'format' => 'raw'],
            'urb' => ['attribute' => 'urb', 'format' => 'raw'],
            'munPath' => ['attribute' => 'munPath', 'format' => 'raw'],
            'regn' => ['attribute' => 'regn', 'format' => 'raw'],
            'prov' => ['attribute' => 'prov', 'format' => 'raw'],
            'mun' => ['attribute' => 'mun', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'munID:raw',
            'Municipality:raw',
            'urb:raw',
            'munPath:raw',
            'regn:raw',
            'prov:raw',
            'mun:raw',
        ];
    }
}