<?php

use app\helpers\App;
use app\helpers\Html;

$this->registerWidgetJsFile('input-list');
$this->addJsFile('sortable/Sortable.min');

$this->registerJs(<<< JS
	new InputListWidget({
		widgetId: '{$widgetId}',
		name: '{$name}',
		label: '{$label}',
		type: '{$type}',
	}).init();


	new Sortable(document.getElementById('{$widgetId}-container'), {
        handle: '.handle-sortable', // handle's class
        animation: 150,
        ghostClass: 'bg-light-primary'
    });
JS);
?>

<div id="<?= $widgetId ?>">
	<div class="input-group">
		<?= App::ifElse(
			$type == 'input', 
			fn() => Html::tag('input', '', [
				'type' => 'text', 
				'name' => 'input',
				'class' => 'form-control',
				'placeholder' => "Enter a {$label}",
			]),
			fn () => Html::tag('textarea', '', [
				'type' => 'text', 
				'name' => 'input',
				'class' => 'form-control',
				'placeholder' => "Enter a {$label}",
			])
		) ?>
		<div class="input-group-append">
			<button class="btn btn-success btn-add" type="button">
				<i class="fa fa-plus-circle"></i>
			</button>
		</div>
	</div>

	<div class="list-container mt-2" id="<?= $widgetId ?>-container">
		<?= App::foreach($data, function($value) use($name, $label, $type) {
			$input = $type == 'input' ? Html::tag('input', '', [
				'type' => 'text', 
				'name' => $name,
				'class' => 'form-control',
				'value' => $value,
				'placeholder' => "Enter a {$label}",
			]): Html::tag('textarea', $value, [
				'type' => 'text', 
				'name' => $name,
				'class' => 'form-control',
				'value' => $value,
				'placeholder' => "Enter a {$label}",
			]);
			return <<< HTML
				<div class="input-group mb-2">
					<div class="input-group-prepend">
						<button class="btn btn-secondary handle-sortable" type="button">
							<i class="fas fa-arrows-alt"></i>
						</button>
					</div>
					{$input}
					<div class="input-group-append">
						<button class="btn btn-danger btn-remove" type="button">
							<i class="fa fa-trash"></i>
						</button>
					</div>
				</div>
			HTML;
		}) ?>
	</div>
</div>
