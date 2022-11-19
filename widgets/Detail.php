<?php

namespace app\widgets;

use yii\widgets\DetailView;
 
class Detail extends BaseWidget
{
    public $model;
    public $attributes;
    public $formatter = ['class' => 'app\components\FormatterComponent'];
    

    public function init() 
    {
        // your logic here
        parent::init(); 
        
        $this->attributes = $this->attributes ?: ($this->model->detailColumns ?? ['id']);
    }
  
    /**
     * {@inheritdoc}
     */
    public function run()
    {
        return DetailView::widget([
            'model' => $this->model,
            'attributes' => $this->attributes,
            'formatter' => $this->formatter,
        ]);
    }
}
