<?php

namespace app\models;

use app\widgets\Anchor;
use app\helpers\ArrayHelper;
use Phpml\Classification\NaiveBayes;

/**
 * This is the model class for table "{{%trainings}}".
 *
 * @property int $id
 * @property string $query
 * @property string $intent
 * @property string $response
 * @property string|null $suggestion
 * @property int $record_status
 * @property int $created_by
 * @property int $updated_by
 * @property string $created_at
 * @property string $updated_at
 */
class Training extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%trainings}}';
    }

    public function config()
    {
        return [
            'controllerID' => 'training',
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
            [['query', 'intent', 'response'], 'required'],
            [['suggestion'], 'string'],
            [['query', 'intent'], 'string', 'max' => 255],
            [['query'], 'unique'],
            [['response'], 'safe']
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return $this->setAttributeLabels([
            'id' => 'ID',
            'query' => 'Query',
            'intent' => 'Intent',
            'response' => 'Response',
            'suggestion' => 'Suggestion',
        ]);
    }

    /**
     * {@inheritdoc}
     * @return \app\models\query\TrainingQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \app\models\query\TrainingQuery(get_called_class());
    }
     
    public function gridColumns()
    {
        return [
            'query' => [
                'attribute' => 'query', 
                'format' => 'raw',
                'value' => function($model) {
                    return Anchor::widget([
                        'title' => $model->query,
                        'link' => $model->viewUrl,
                        'text' => true
                    ]);
                }
            ],
            'intent' => ['attribute' => 'intent', 'format' => 'raw'],
            'response' => ['attribute' => 'response', 'format' => 'ul'],
            // 'suggestion' => ['attribute' => 'suggestion', 'format' => 'raw'],
        ];
    }

    public function detailColumns()
    {
        return [
            'query:raw',
            'intent:raw',
            'response:ul',
            // 'suggestion:raw',
        ];
    }

    public function getExplodedQuery()
    {
        return explode(' ', $this->query);
    }

    public static function samples()
    {
        $models = self::find()
            ->active()
            ->orderBy(['LENGTH(query)' => SORT_DESC])
            ->all();

        $models = ArrayHelper::map($models, 'id', 'explodedQuery');

        return $models;
    }

    public function nestedUppercase($value) 
    {
        if (is_array($value)) {
            return array_map([$this, 'nestedUppercase'], $value);
        }
        return strtoupper($value);
    }

    public function predict($query='')
    {
        $query = trim($query);
        $_SAMPLES_ = self::samples();

        $data = array_merge(['dummy' => ['']], self::samples());
        $samples = $this->nestedUppercase(array_values($data));

        $labels = ['dummy'];
        $index = 0;
        foreach ($_SAMPLES_ as $id => $explodedQuery) {
            $labels[$id] = $index;
            $index++;
        }

        $classifier = new NaiveBayes();
        $classifier->train($samples, $labels);
        $predict = $classifier->predict(explode(' ', strtoupper($query)));

        $id = array_search($predict, $labels, true);

        return [
            'predict' => $predict,
            'training' => self::findOne($id),
        ];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['JsonBehavior']['fields'] = [
            'response', 
        ];
        return $behaviors;
    }
}