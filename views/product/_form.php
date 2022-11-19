<?php

use app\widgets\ActiveForm;
use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Product */
/* @var $form app\widgets\ActiveForm */

$this->registerCssFile(App::publishedUrl('/css/pages/wizard/wizard-2.css'), [
	'depends' => [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ]
]);
?>
<div class="card card-custom">
	<div class="card-body p-0">
		<div class="wizard wizard-2" id="kt_wizard" data-wizard-state="first" data-wizard-clickable="false">
			<div class="wizard-nav flex-lg-shrink-0 w-lg-300px w-xl-375px border-right py-8 px-8 py-lg-20 px-lg-10">
				<div class="wizard-steps">
					<?= Html::foreach($stepForms, function($stepForm) {
						return $this->render('form/side-step', $stepForm);
					}) ?>
				</div>
			</div>
			<div class="wizard-body py-8 px-8 py-lg-20 px-lg-10">
				<?php $form = ActiveForm::begin(['id' => 'product-form']); ?>
					<div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
						<?= $this->render("form/{$activeStep['step']}", [
							'model' => $model,
							'form' => $form,
							'activeStep' => $activeStep,
						]) ?>
					</div>
				
					<div class="d-flex justify-content-between border-top mt-5 pt-10">
						<?= Html::if($activeStep['step'] != 'general', function() use($activeStep, $model) {
							$previousStep = $model->getPreviousStep($activeStep);
							$url = Url::current(['step' => $previousStep['step']]);

							return <<< HTML
								<div class="mr-2">
									<a href="{$url}" class="btn btn-light-primary font-weight-bolder px-10 py-3">
									<span class="svg-icon svg-icon-md mr-3">
										<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
											<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
												<polygon points="0 0 24 0 24 24 0 24"></polygon>
												<rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) scale(-1, 1) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1"></rect>
												<path d="M3.7071045,15.7071045 C3.3165802,16.0976288 2.68341522,16.0976288 2.29289093,15.7071045 C1.90236664,15.3165802 1.90236664,14.6834152 2.29289093,14.2928909 L8.29289093,8.29289093 C8.67146987,7.914312 9.28105631,7.90106637 9.67572234,8.26284357 L15.6757223,13.7628436 C16.0828413,14.136036 16.1103443,14.7686034 15.7371519,15.1757223 C15.3639594,15.5828413 14.7313921,15.6103443 14.3242731,15.2371519 L9.03007346,10.3841355 L3.7071045,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(9.000001, 11.999997) scale(-1, -1) rotate(90.000000) translate(-9.000001, -11.999997)"></path>
											</g>
										</svg>
									</span>Previous</a>
								</div>
							HTML;
						}) ?>
						

						<div>
							<button type="button" class="btn btn-success font-weight-bolder px-10 py-3" data-wizard-type="action-submit">Submit
								<span class="svg-icon svg-icon-md ml-3">
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<polygon points="0 0 24 0 24 24 0 24"></polygon>
											<path d="M6.26193932,17.6476484 C5.90425297,18.0684559 5.27315905,18.1196257 4.85235158,17.7619393 C4.43154411,17.404253 4.38037434,16.773159 4.73806068,16.3523516 L13.2380607,6.35235158 C13.6013618,5.92493855 14.2451015,5.87991302 14.6643638,6.25259068 L19.1643638,10.2525907 C19.5771466,10.6195087 19.6143273,11.2515811 19.2474093,11.6643638 C18.8804913,12.0771466 18.2484189,12.1143273 17.8356362,11.7474093 L14.0997854,8.42665306 L6.26193932,17.6476484 Z" fill="#000000" fill-rule="nonzero" transform="translate(11.999995, 12.000002) rotate(-180.000000) translate(-11.999995, -12.000002)"></path>
										</g>
									</svg>
								</span>
							</button>
							<button type="submit" id="next-step" class="btn btn-primary font-weight-bolder px-10 py-3" data-wizard-type="action-next">Next
								<span class="svg-icon svg-icon-md ml-3">
									<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
										<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
											<polygon points="0 0 24 0 24 24 0 24"></polygon>
											<rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1"></rect>
											<path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)"></path>
										</g>
									</svg>
								</span>
							</button>
						</div>
					</div>
				<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>
</div>