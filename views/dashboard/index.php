<?php
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use app\helpers\App;
use app\helpers\Html;
use app\helpers\Url;

$this->title = 'Dashboard';
$this->params['searchModel'] = $searchModel; 
$this->params['wrapCard'] = false;

$this->addJsFile('js/dashboard', ['app\themes\keen\sub\demo1\main\assets\AppAsset']);
?>
<div class="dashboard-page" data-year="<?= $year ?>">
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

	<div class="row">
		<div class="col-lg-4">
			<!--begin::Stats Widget 1-->
			<div class="card card-custom card-stretch gutter-b">
				<!--begin::Header-->
				<div class="card-header border-0 pt-6">
					<h3 class="card-title">
						<span class="card-label font-weight-bolder font-size-h4 text-dark-75">Monthly Sales</span>
					</h3>
				</div>
				<!--end::Header-->
				<!--begin::Body-->
				<div class="card-body d-flex align-items-center justify-content-between px-5 flex-wrap">
					<!--begin::label-->
					<span class="font-weight-bolder display5 text-dark-75 py-4 pl-5 pr-5">
					<span class="font-weight-normal font-size-h6 text-muted pr-1">₱</span>
						<?= number_format($totalMontlySales) ?>
					</span>
					<!--end::label-->
					<!--begin::Chart-->
					<div class="progress-vertical w-200px h-125px">
						<?= App::foreach($monthlySales, fn($data) => <<< HTML
							<div class="progress bg-light-primary" data-toggle="tooltip" title="{$data['month']}: {$data['average']}">
							<div class="progress-bar bg-primary" role="progressbar" style="height: {$data['percent']}%"></div>
						</div>
						HTML) ?>
						
					</div>
					<!--end::Chart-->
				</div>
				<!--end::Body-->
			</div>
			<!--end::Stats Widget 1-->
		</div>
		<div class="col-lg-4">
			<!--begin::Stats Widget 2-->
			<div class="card card-custom card-stretch gutter-b">
				<!--begin::Header-->
				<div class="card-header border-0 pt-6">
					<h3 class="card-title">
						<span class="card-label font-weight-bolder font-size-h4 text-dark-75">Best Sellers</span>
					</h3>
				</div>
				<!--end::Header-->
				<!--begin::Body-->
				<div class="card-body d-flex align-items-center justify-content-between px-5 flex-wrap">
					<!--begin::Label-->
					<span class="font-weight-bolder display5 text-dark-75 pl-5 pr-10">
						<?= number_format($totalBestSeller) ?>
					</span>
					<!--end::Label-->
					<!--begin::Visuals-->
					<div class="d-flex align-items-center justify-content-between">
						<!--begin::legends-->
						<div class="d-flex flex-column mr-4">
							<!--begin::legend-->
							<?= App::foreach($bestSeller, function($product, $key) {
								$class = $key == 0 ? 'label-primary': 'label-dark-50';
								return <<< HTML
									<div class="legend d-flex align-items-center py-1">
										<span class="label {$class} label-dot mr-2"></span>
										<span class="font-weight-bolder font-size-lg text-muted">
										{$product['product_name']}
										</span>
									</div>
								HTML;
							}) ?>
						</div>
						<!--end::legends-->
						<!--begin::Chart-->
						<div class="d-flex flex-center position-relative">
							<div class="font-weight-bolder font-size-h5 text-muted position-absolute">8,345</div>
							<canvas id="kt_stats_widget_2_chart" style="height: 110px; width: 110px;"></canvas>
						</div>
						<!--end::Chart-->
					</div>
					<!--end::Visuals-->
				</div>
				<!--end::Body-->
			</div>
			<!--end::Stats Widget 2-->
		</div>
		<div class="col-lg-4">
			<!--begin::Stats Widget 3-->
			<div class="card card-custom card-stretch gutter-b">
				<!--begin::Header-->
				<div class="card-header border-0 pt-6">
					<h3 class="card-title">
						<span class="card-label font-weight-bolder font-size-h4 text-dark-75">Total Orders</span>
					</h3>
				</div>
				<!--end::Header-->
				<!--begin::Body-->
				<div class="card-body d-flex align-items-center justify-content-between px-5 flex-wrap">
					<!--begin::label-->
					<span class="font-weight-bolder display5 text-dark-75 pl-5 pr-10 total-orders"></span>
					<!--end::label-->
					<!--begin::Chart-->
					<div id="kt_stats_widget_3_chart" class="w-200px"></div>
					<!--end::Chart-->
				</div>
				<!--end::Body-->
			</div>
			<!--end::Stats Widget 3-->
		</div>
	</div>
</div>