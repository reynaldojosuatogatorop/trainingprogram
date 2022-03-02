<div class="welcome-area">
	<div class="row m-0 align-items-center">
		<div class="col-lg-5 col-md-12 p-0">
			<div class="welcome-content">
				<h1 class="mb-2">Hi, Welcomeback <?= $loginData->data->nama ?>!</h1>
				<p class="mb-0">Silahkan Pilih Produk yang Anda Perlukan</p>
			</div>
		</div>
		<div class="col-lg-7 col-md-12 p-0">
			<div class="welcome-img">
				<img src="assets/img/welcome-img.png" alt="image">
			</div>
		</div>
	</div>
</div>

<div class="card">
	<div class="card-body">

		<table class="table table-bordered" id="datatable" width="100%">
			<thead class="thead-dark">
				<tr>
					<th scope="col">#</th>   
					<th scope="col">Invoice</th>
					<th scope="col">Nama Pembeli</th>
					<th scope="col">Jumlah Item</th>
					<th scope="col">Total Bayar</th>
					<th scope="col">Tanggal Pesanan</th>
					<th scope="col">Aksi</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>