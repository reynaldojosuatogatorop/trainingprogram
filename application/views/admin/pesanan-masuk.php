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
<div class="modal fade" id="modalProses" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="modalTitle">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-6">
						<div class="form-group">
							<label>Nama Pemesan</label>
							<input type="text" id="nama_pelanggan" class="form-control" readonly>
						</div>
					</div>

					<div class="col-6">
						<div class="form-group">
							<label>Jumlah Item</label>
							<input type="text" id="jumlah_item" class="form-control" readonly>
						</div>
					</div>

					<div class="col-12">
						<p>Detail Produk</p>
						<table class="table table-bordered">
							<thead>
								<th>Produk</th>
								<th>Jumlah</th>
								<th>Satauan</th>
								<th>Harga</th>
							</thead>

							<tbody id="live_data"></tbody>
						</table>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label>Total Harga</label>
							<input type="text" id="total_harga" class="form-control" readonly>
						</div>
					</div>

					<div class="col-6">
						<div class="form-group">
							<label>Jumlah Bayar</label>
							<input type="text" id="jumlah_bayar" class="form-control">
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-success" id="simpanData" onclick="simpanData()">Simpan</button>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	var id,jumlahItem, hargaTotal,invoice;
	function checkout(args)
	{
		var dataDecode 	= JSON.parse(window.atob(args));
		jumlahItem 		= dataDecode.jumlah_pesanan;
		hargaTotal 		= dataDecode.sub_total;
		id 				= dataDecode.id;
		invoice 		= dataDecode.invoice;
		$('#nama_pelanggan').val(dataDecode.nama);
		$('#jumlah_item').val(dataDecode.jumlah_pesanan);
		$('#total_harga').val(formatRupiah(dataDecode.sub_total, 'Rp. '));
		$('#modalTitle').html('Selesaikan pembayaran');
		$('#modalProses').modal('show');
		$.ajax({
			url: '<?= base_url("Backend/DataPesananDetail") ?>',
			data: { 'data': dataDecode.invoice },
			type: "POST",
			success: function(dataResponse) {
				$("#live_data").html(dataResponse)

			},
			error: function(e){
				alert("Sorry, looks like there are some errors detected, please try again !");       
			}
		})
	}
</script>

<script type="text/javascript">
	function simpanData()
	{
		const data = {
			'id' 			: id,
			'total_item' 	: jumlahItem,
			'harga_total'	: hargaTotal,
			'jumlah_bayar'	: $('#jumlah_bayar').val(),
			'kembalian'		: $('#jumlah_bayar').val() - hargaTotal,
			'status'		: 'Selesai'
		}

		$.ajax({
			url: '<?= base_url("Backend/PesananSelesai") ?>',
			data: { 'data': data },
			type: "POST",
			success: function(dataResponse) {
				var dataJson = dataResponse;

				if(dataJson.status == true)
				{
					var jenis = "success";
					var pesan = dataJson.notifikasi;
					var dataTitle = "Pembayaran Telah Berhasil";
					Swal.fire(
					{
						title: dataTitle, 
						text:  pesan, 
						icon:  jenis
					}).then((result) => {
						if (jenis=='success'){
							window.location.href = '<?= base_url('home') ?>'+'?menu=invoice&invoice='+invoice;
						}
					});
				}else{
					notif('error', dataJson.notifikasi);
				}

			},
			error: function(e){
				alert("Sorry, looks like there are some errors detected, please try again !");       
			}
		})
	}
</script>