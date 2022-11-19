<?php

use app\helpers\Html;
$title = $title ?? '';
?>
<div class="card card-custom gutter-b card-stretch">
	<?= Html::if($title, <<< HTML
		<div class="card-header">
			<div class="card-title">
				<h3 class="card-label">{$title}</h3>
			</div>
		</div>
	HTML) ?>
    <div class="card-body">
		<?= $content ?> 
	</div>
</div>