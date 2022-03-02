<?php 
	$invoice = $this->input->get('invoice');
	$getData = $this->db->where('invoice', $invoice)->get('v_data_pesanan_selesai')->row();
	$getDataProduk = $this->db->where('invoice', $invoice)->get('v_data_pesanan_keranjang')->result();
?>
<div class="breadcrumb-area">
	<h1>Dashboard</h1>
	<ol class="breadcrumb">
		<li class="item"><a href="dashboard-analytics.html"><i class='bx bx-home-alt'></i></a></li>
		<li class="item">Dashboard</li>
		<li class="item">Invoice</li>
	</ol>
</div>

<div class="invoice-area mb-30">
	<div class="invoice-header mb-30 d-flex justify-content-between">
		<div class="invoice-left-text">
			<h3 class="mb-0"><?= $getData->nama ?></h3>
		</div>
		<div class="invoice-right-text">
			<h3 class="mb-0 text-uppercase">Invoice</h3>
		</div>
	</div>
	<div class="invoice-middle mb-30">
		<div class="row justify-content-center">
			<div class="col-lg-9 ">
				<div class="text text-right">
					<h5>Invoice # <sub><?= $getData->invoice ?></sub></h5>
					<h5>Invoice Date # <sub><?= date_format(date_create($getData->tanggal_pesan), 'Y-m-d') ?></sub></h5>
					<h5>Jam # <sub><?= date_format(date_create($getData->tanggal_pesan), 'H:m:i') ?></sub></h5>
				</div>
			</div>
		</div>
	</div>
	<div class="invoice-table table-responsive mb-30">
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>#</th>
					<th>Produk</th>
					<th>Jumlah</th>
					<th>Harga Satuan</th>
					<th>Harga Total</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=1; foreach($getDataProduk as $produk){ ?>
				<tr>
					<td><?= $no++; ?></td>
					<td><?= $produk->produk ?></td>
					<td class="text-right"><?= $produk->jumlah_pesanan ?></td>
					<td class="text-right">Rp.<?= $this->custom->decimal($produk->harga) ?></td>
					<td class="text-right">Rp. <?= $this->custom->decimal($produk->harga *$produk->jumlah_pesanan) ?></td>
				</tr>
				<?php } ?>
				<tr>
					<td class="text-right" colspan="4"><strong>Subtotal</strong></td>
					<td class="text-right">Rp. <?= $this->custom->decimal($getData->harga_total) ?></td>
				</tr>
				<tr>
					<td class="text-right" colspan="4"><strong>Dibayar</strong></td>
					<td class="text-right">Rp. <?= $this->custom->decimal($getData->total_bayar) ?></td>
				</tr>
				<tr>
					<td class="text-right total" colspan="4"><strong>Kembalian</strong></td>
					<td class="text-right total-price"><strong>Rp. <?= $this->custom->decimal($getData->kembalian) ?></strong></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="invoice-btn-box text-right">
		<a href="#" class="default-btn"><i class='bx bx-printer'></i> Print</a>
	</div>
</div>