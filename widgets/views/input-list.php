<?php

use app\helpers\Html;

$this->registerWidgetJsFile('input-list');
$this->registerJs(<<< JS
	new InputListWidget({
		widgetId: '{$widgetId}',
		name: '{$name}',
		label: '{$label}',
	}).init();
JS);
?>

<div id="<?= $widgetId ?>">
	<div class="input-group">
		<input type="text" name="input" class="form-control" placeholder="Enter a <?= $label ?>">
		<div class="input-group-append">
			<button class="btn btn-success btn-add btn-icon" type="button">
				<i class="fa fa-plus-circle"></i>
			</button>
		</div>
	</div>

	<div class="list-container mt-2">
		<?= Html::foreach($data, function($value) use($name, $label) {
			return <<< HTML
				<div class="input-group mb-2">
					<input placeholder="Enter a {$label}" type="text" class="form-control" name="{$name}" value="{$value}">
					<div class="input-group-append">
						<button class="btn btn-danger btn-icon btn-remove" type="button">
							<i class="fa fa-trash"></i>
						</button>
					</div>
				</div>
			HTML;
		}) ?>
	</div>
</div>
