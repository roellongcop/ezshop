<?php

use app\widgets\ActiveForm;
use app\helpers\Url;
use app\models\Review;

$this->addJsFile('frontend/js/review-form', ['app\assets\frontend\AppAsset'], [
    'type' => 'module'
]);

$review = new Review();
?>
<?php $form = ActiveForm::begin([
    'id' => 'review-form',
    'action' => Url::toRoute(['site/add-review', 'product_id' => $product->id])
]); ?>
    <div class="rating">
        <label>
            <input type="radio" name="stars" value="1" />
            <span class="icon">★</span>
        </label>
        <label>
        <input type="radio" name="stars" value="2" />
            <span class="icon">★</span>
            <span class="icon">★</span>
        </label>
        <label>
        <input type="radio" name="stars" value="3" />
            <span class="icon">★</span>
            <span class="icon">★</span>
            <span class="icon">★</span>   
        </label>
        <label>
        <input type="radio" name="stars" value="4" />
            <span class="icon">★</span>
            <span class="icon">★</span>
            <span class="icon">★</span>
            <span class="icon">★</span>
        </label>
        <label>
        <input type="radio" name="stars" value="5" />
            <span class="icon">★</span>
            <span class="icon">★</span>
            <span class="icon">★</span>
            <span class="icon">★</span>
            <span class="icon">★</span>
        </label>
        </div>
        <?= $form->field($review, 'review')->textarea(['rows' => 6])->label('Your Review') ?>
        <?= $form->field($review, 'score', ['template' => '{input}'])->hiddenInput()->Label(false) ?>
        <div class="form-group">
        <input type="submit" value="Leave Your Review" class="btn btn-primary px-3">
    </div>
<?php ActiveForm::end(); ?>