<div class="welcome-area">
	<div class="row m-0 align-items-center">
		<div class="col-lg-5 col-md-12 p-0">
			<div class="welcome-content">
				<h1 class="mb-2">Hi, Welcomeback <?= $loginData->data->nama ?>!</h1>
				<p class="mb-0">Just Do Somethings Better</p>
			</div>
		</div>
		<div class="col-lg-7 col-md-12 p-0">
			<div class="welcome-img">
				<img src="assets/img/welcome-img.png" alt="image">
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12 col-md-12">
		<div class="card recent-orders-box mb-30">
			<div class="card-header d-flex justify-content-between align-items-center">
				<h3>Sisa Stok</h3>
			</div>
			<div class="card-body">
				<div class="table-responsive">
					<table class="table" id="datatable">
						<thead>
							<tr>
								<th>#</th>
								<th>Nama Produk</th>
								<th>Gambar</th>
								<th>Sisa Stok</th>
								<th>Stok Terpakai</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody >
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
