<?php 
	$daftarProduk = $this->db->get('tbl_produk')->result();
?>
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

<div class="row">
	<div class="col-12">
		<div class="card">
			<div class="card-body">
				<div class="row">
					<?php foreach($daftarProduk as $produk){ ?>
					<div class="col-12 col-md-4">
						<div class="card-deck mb-30">
							<div class="card p-0">
								<img src="<?= $this->picture->GetPictureOriginal($produk->gambar_produk) ?>" class="card-img-top" alt="image" style="max-width: 150px; height: 200px;">
								<div class="card-body p-4">
									<h5 class="card-title font-weight-bold"><?= $produk->produk ?></h5>
									<p class="card-text"><?= $produk->deskripsi_produk ?>.</p>

									<div class="row">
										<div class="col-6">
											<p class="card-text">Kategori <br/><small class="text-info"><?= $produk->jenis_produk ?></small></p>
											
										</div>
										<div class="col-6">
											<p class="card-text">Harga<br/><small class="text-success">Rp. <?= $this->custom->decimal($produk->harga) ?>,-</small></p>
											
										</div>
									</div>

									<div class="row">
										<div class="col-8"><input type="text" id="jumlah_<?= $produk->id ?>" class="form-control" placeholder="Jumlah Pesanan"></div>
											
										<div class="col-4 pt-1"><a href="javascript:pesan(`<?= $produk->id ?>`)" class="btn btn-sm btn-info col-12">Pesan</a></div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php } ?>
				</div>
				
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function pesan(args)
	{
		const data ={
            'tokenID' : args,
            'jumlah'  : $('#jumlah_'+args).val()
        }
        $.ajax({
            url: '<?= base_url("Backend/Keranjang") ?>',
            data: { 'data': data },
            type: "POST",
            success: function(dataResponse) {
                var dataJson = dataResponse;

                if(dataJson.status == true)
                {
                    notif('success', dataJson.notifikasi);
                    $('#jumlah_'+args).val("")
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