<?php
/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\frontend\AppAsset;
use app\helpers\App;
use app\helpers\Url;
use app\helpers\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="<?= Url::image(App::setting('image')->favicon, ['w' => 16]) ?>" type="image/x-icon" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

    <?= $this->render('frontend/topbar') ?>
    <?= $this->render('frontend/navbar') ?>
    <?= $content ?>


    <?= $this->render('frontend/footer') ?>

    <!-- Back to Top -->
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>