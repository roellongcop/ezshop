<?php
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use app\helpers\App;
use app\helpers\Url;

$this->title = 'Dashboard';
$this->params['searchModel'] = $searchModel; 
$this->params['wrapCard'] = false;

$this->addJsFile('js/dashboard', ['app\themes\keen\sub\demo1\main\assets\AppAsset']);

$this->params['headerButtons'] = $this->render('_dropdown-year', [
	'year' => $year,
	'years' => $years,
]);
?>
<div class="dashboard-page" data-year="<?= $year ?>">

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
					<span class="font-weight-bolder display5 text-dark-75 pl-5 pr-10" title="<?= number_format($totalBestSeller) ?> Individual Orders" data-toggle="tooltip">
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
							<div class="font-weight-bolder font-size-h5 text-muted position-absolute" title="<?= number_format($totalQuantityBestSeller) ?> Quantity Orders" data-toggle="tooltip">
								<?= number_format($totalQuantityBestSeller) ?>
							</div>
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

	<div class="row">
		<div class="col-lg-4">
			<div class="card card-custom card-stretch gutter-b">
				<!--begin::Header-->
				<div class="card-header border-0 pt-6">
					<h3 class="card-title align-items-start flex-column">
						<span class="card-label font-weight-bolder font-size-h4 text-dark-75">Top Chat Queries</span>
						<span class="text-muted mt-3 font-weight-bold font-size-lg">
							Top 5 most ask questions
						</span>
					</h3>
				</div>
				<!--end::Header-->
				<!--begin::Body-->
				<div class="card-body pt-7">

					<?= App::foreach($mostChat, function($chat)  {
						$url = Url::toRoute(['chat/index', 'message' => $chat['message']]);
						return <<< HTML
							<div class="d-flex align-items-center mb-6">
								<div class="symbol symbol-35 symbol-light-info flex-shrink-0 mr-3">
									<span class="symbol-label font-weight-bolder font-size-lg">
										<a href="{$url}">
											<i class="fa fa-eye"></i>
										</a>
									</span>
								</div>
								<div class="d-flex align-items-center flex-wrap flex-row-fluid">
									<div class="d-flex flex-column pr-5 flex-grow-1">
										<a href="{$url}" class="text-dark text-hover-primary mb-1 font-weight-bolder font-size-lg">
											{$chat['message']}
										</a>
										<span class="text-muted font-weight-bold">
											{$chat['date']}
										</span>
									</div>
									<span class="text-dark-50 font-weight-bold font-size-lg py-2">
										{$chat['total']}
									</span>
								</div>
							</div>
						HTML;
					}) ?>
					
				</div>
			</div>
		</div>
		<div class="col-md-8">
			<div class="card card-custom gutter-b">
				<div class="card-header">
					<div class="card-title">
						<h3 class="card-label">Chat Frequency</h3>
					</div>
				</div>
				<div class="card-body">
					<!--begin::Chart-->
					<div id="chart_2"></div>
					<!--end::Chart-->
				</div>
			</div>
		</div>
	</div>
</div>