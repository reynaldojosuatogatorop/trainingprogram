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
		<div class="row mb-3">
			<div class="col-12" align="right">
				<button class="btn btn-success btn-sm" onclick="pesan()">Selesaikan Pesanan</button>
			</div>
		</div>
		<table class="table table-bordered" id="datatable" width="100%">
			<thead class="thead-dark">
				<tr>
					<th scope="col">#</th>   
					<th scope="col">Gambar</th>
					<th scope="col">Nama Produk</th>
					<th scope="col">Jenis Produk</th>
					<th scope="col">Harga Satuan</th>
					<th scope="col">Satuan</th>
					<th scope="col">Jumlah Pesanan</th>
					<th scope="col">Sub Total</th>
					<th scope="col">Aksi</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>

<script type="text/javascript">
	function hapusData(args)
	{
		const data ={
			'tokenID' : args,
		}
		$.ajax({
			url: '<?= base_url("Backend/HapusKeranjang") ?>',
			data: { 'data': data },
			type: "POST",
			success: function(dataResponse) {
				var dataJson = dataResponse;

				if(dataJson.status == true)
				{
					notif('success', dataJson.notifikasi);
				}else{
					('error', dataJson.notifikasi);
				}

			},
			error: function(e){
				alert("Sorry, looks like there are some errors detected, please try again !");       
			}
		})
	}

	function pesan()
	{
		$.ajax({
			url: '<?= base_url("Backend/Pesan") ?>',
			type: "POST",
			success: function(dataResponse) {
				var dataJson = dataResponse;

				if(dataJson.status == true)
				{
					notif('success', dataJson.notifikasi);
				}else{
					('error', dataJson.notifikasi);
				}

			},
			error: function(e){
				alert("Sorry, looks like there are some errors detected, please try again !");       
			}
		})
	}
</script>