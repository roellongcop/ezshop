<?php
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use app\helpers\Html;
use app\helpers\Url;
use app\helpers\App;
?>
<div class="dropdown text-right mb-2">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Year: <?= $year ?>
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    	<?= App::foreach($years, fn($y) => Html::tag('a', $y['year'], [
    		'class' => 'dropdown-item',
    		'href' => Url::current(['year' => $y['year']])
    	])) ?>
    </div>
</div>
