<div id="base">

	<div id="content">
		<section>
			<div class="section-body">
				<div class="row">
					<div class="col-md-3 col-sm-6">
						<div class="card">
							<div class="card-body no-padding">
								<div class="alert alert-callout alert-info no-margin">
									<strong class="pull-right text-success text-lg"> <i class="fa fa-bar-chart"></i></strong>
									<strong class="text-xl">Rp <?= number_format($penjualan_tot, 2); ?></strong><br />
									<span class="opacity-50">Total Penjualan</span>
									<div class="stick-bottom-left-right">
										<div class="height-2 sparkline-revenue" data-line-color="#bdc1c1"></div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-3 col-sm-6">
						<div class="card">
							<div class="card-body no-padding">
								<div class="alert alert-callout alert-warning no-margin">
									<strong class="pull-right text-warning text-lg"> <i class="fa fa-line-chart"></i></strong>
									<strong class="text-xl">Rp <?= number_format($penjualan_now, 2); ?></strong><br />
									<span class="opacity-50">Total Penjualan Bulan Ini</span>
									<div class="stick-bottom-right">
										<div class="height-1 sparkline-visits" data-bar-color="#e5e6e6"></div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-3 col-sm-6">
						<div class="card">
							<div class="card-body no-padding">
								<div class="alert alert-callout alert-danger no-margin">
									<strong class="pull-right text-danger text-lg"> <i class="fa fa-cubes"></i></strong>
									<strong class="text-xl"><?= $porsi_tot; ?></strong><br />
									<span class="opacity-50">Total Porsi Terjual</span>
									<div class="stick-bottom-right">
										<div class="height-1 sparkline-visits" data-bar-color="#e5e6e6"></div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-3 col-sm-6">
						<div class="card">
							<div class="card-body no-padding">
								<div class="alert alert-callout alert-success no-margin">
									<strong class="pull-right text-success"> <i class="fa fa-credit-card"></i></strong>
									<strong class="text-xl"><?= $porsi_now; ?></strong><br />
									<span class="opacity-50">Total Porsi Terjual Bulan Ini</span>
									<div class="stick-bottom-right">
										<div class="height-1 sparkline-visits" data-bar-color="#e5e6e6"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</div>