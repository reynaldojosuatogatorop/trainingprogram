<!doctype html>
	<html lang="zxx">
	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link rel="stylesheet" href="<?= base_url() ?>assets/css/vendors.min.css">

		<link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">

		<link rel="stylesheet" href="<?= base_url() ?>assets/css/responsive.css">
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
		
		<title>Home</title>
		<link rel="icon" type="image/png" href="<?= base_url() ?>assets/img/favicon.png">
	</head>
	<body>

		<div class="sidemenu-area">
			<div class="sidemenu-header">
				<a href="dashboard-analytics.html" class="navbar-brand d-flex align-items-center">
					<img src="<?= base_url() ?>assets/img/logo.png" alt="image" style="max-width: 80%;">
				</a>
				<div class="burger-menu d-none d-lg-block">
					<span class="top-bar"></span>
					<span class="middle-bar"></span>
					<span class="bottom-bar"></span>
				</div>
				<div class="responsive-burger-menu d-block d-lg-none">
					<span class="top-bar"></span>
					<span class="middle-bar"></span>
					<span class="bottom-bar"></span>
				</div>
			</div>

			<?php 
			if($loginData->data->hak_akses == "Pembeli")
			{
				$this->load->view('menu/pembeli');
			}else{
				$this->load->view('menu/admin');
			}
			?>
		</div>


		<div class="main-content d-flex flex-column">

			<nav class="navbar top-navbar navbar-expand">
				<div class="collapse navbar-collapse" id="navbarSupportContent">
					<div class="responsive-burger-menu d-block d-lg-none">
						<span class="top-bar"></span>
						<span class="middle-bar"></span>
						<span class="bottom-bar"></span>
					</div>

					<form class="nav-search-form d-none ml-auto d-md-block">
						
					</form>
					<ul class="navbar-nav right-nav align-items-center">
						<li class="nav-item">
							<a class="nav-link bx-fullscreen-btn" id="fullscreen-button">
								<i class="bx bx-fullscreen"></i>
							</a>
						</li>
						<li class="nav-item dropdown profile-nav-item">
							<a href="#" class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<div class="menu-profile">
									<span class="name"><?= $loginData->data->nama ?></span>
									<img src="<?= base_url() ?>assets/img/user1.jpg" class="rounded-circle" alt="image">
								</div>
							</a>
							<div class="dropdown-menu">
								<div class="dropdown-header d-flex flex-column align-items-center">
									<div class="figure mb-3">
										<img src="<?= base_url() ?>assets/img/user1.jpg" class="rounded-circle" alt="image">
									</div>
									<div class="info text-center">
										<span class="name"><?= $loginData->data->nama ?></span>
									</div>
								</div>
								<div class="dropdown-body">
									<ul class="profile-nav p-0 pt-3">
										<li class="nav-item">
											<a href="#" class="nav-link">
												<i class='bx bx-user'></i> <span>Profile</span>
											</a>
										</li>
									</ul>
								</div>
								<div class="dropdown-footer">
									<ul class="profile-nav">
										<li class="nav-item">
											<a href="<?= base_url('keluar') ?>" class="nav-link">
												<i class='bx bx-log-out'></i> <span>Logout</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</li>
					</ul>
				</div>
			</nav>

			<?php if($menu == "data-produk")
			{
				$this->load->view('master-data/produk');
			}else if($menu == "daftar-produk")
			{
				$this->load->view('konsumen/produk');
			}else if($menu == "keranjang")
			{
				$this->load->view('konsumen/keranjang');
			}else if($menu == "pesanan")
			{
				$this->load->view('konsumen/pesanan-selesai');
			}else if($menu == "pesanan-masuk")
			{
				$this->load->view('admin/pesanan-masuk');
			}else if($menu == "invoice")
			{
				$this->load->view('admin/invoice');
			}else if($menu == "pesanan-selesai")
			{
				$this->load->view('admin/pesanan-selesai');
			}else{
				$this->load->view('home');
			}
			?>


			<footer class="footer-area">
				<div class="row align-items-center">
					<div class="col-lg-6 col-sm-6 col-md-6">
						<p>Copyright <i class='bx bx-copyright'></i> 2020 <a href="#">Olaf</a>. All rights reserved</p>
					</div>
				</div>
			</footer>

		</div>

		<script src="<?= base_url() ?>assets/js/vendors.min.js"></script>
		<script src="<?= base_url() ?>assets/js/chartjs/chartjs.min.js"></script>
		<script src="<?= base_url() ?>assets/js/resize.js"></script>
		<script src="<?= base_url() ?>assets/js/jvectormap-1.2.2.min.js"></script>
		<script src="<?= base_url() ?>assets/js/jvectormap-world-mill-en.js"></script>
		<script src="<?= base_url() ?>assets/js/custom.js"></script>
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
		<script src="<?= base_url() ?>assets/js/notif.js"></script>
		<script type="text/javascript" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<script type="text/javascript">
			var that;
			var table = "<?= $dataTableHalaman->Tabel ?>";
			$(document).ready( function () {
				$(table).DataTable({
					processing: false,
					serverSide: true,
					responsive: true,
					order: [],
					"ajax": {
						"url": "<?= $dataTableHalaman->ajaxUrl?>",
						"type": "POST"
					},
					columnDefs: [{
						visible: false,
					}],
					responsive: true,
					searching: true,
					responsive: true


				})
				$('#nomor_seri').on( 'change', function () {
					$(table).DataTable().search($('#nomor_seri').val()).draw();
				} );
			} );
		</script>
	</body>
	</html>