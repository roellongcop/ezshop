<h4 class="mb-10 font-weight-bold text-dark">
	<?= $activeStep['description'] ?>
</h4>

<?= $form->field($model, 'sku')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'quantity')->textInput() ?>

<?= $form->field($model, 'low_stock_threshold')->textInput() ?>

<?= $form->field($model, 'high_stock_threshold')->textInput() ?>



