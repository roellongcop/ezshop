<?php

use app\helpers\Html;
use app\widgets\ImageGallery;
use app\widgets\Dropzone;
use app\models\File;
?>

<h4 class="mb-10 font-weight-bold text-dark">
	<?= $activeStep['description'] ?>
</h4>


<?= Html::image($model->image, ['w' => 200], [
    'class' => 'img-thumbnail user-photo',
    'loading' => 'lazy',
] ) ?>
<div class="my-2"></div>

<?= ImageGallery::widget([
    'tag' => 'Product',
    'buttonTitle' => 'Choose Main Image',
    'model' => $model,
    'attribute' => 'image',
    'ajaxSuccess' => "
        if(s.status == 'success') {
            $('.user-photo').attr('src', s.src);
        }
    ",
]) ?> 


<div class="my-10"></div>
<p class="lead font-weight-bold uppercase">ADD GALLERY PHOTOS HERE</p>
<?= Dropzone::widget([
    'tag' => 'Product',
    'files' => $model->imageFiles,
    'model' => $model,
    'attribute' => 'gallery',
    'acceptedFiles' => array_map(
        function($val) { 
            return ".{$val}"; 
        }, File::EXTENSIONS['image']
    )
]) ?>
