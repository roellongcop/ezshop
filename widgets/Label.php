<?php

namespace app\widgets;

class Label extends BaseWidget
{
    public $options;

    /**
     * {@inheritdoc}
     */
    public function run()
    {
        if (!$this->options) {
            return;
        }
        return $this->render('label', [
            'options' => $this->options
        ]);
    }
}
