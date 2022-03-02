<!doctype html>
	<html lang="zxx">
	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link rel="stylesheet" href="<?= base_url() ?>assets/css/vendors.min.css">

		<link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">

		<link rel="stylesheet" href="<?= base_url() ?>assets/css/responsive.css">
		<title>Daftar Pengguna Baru</title>
		<link rel="icon" type="image/png" href="<?= base_url() ?>assets/img/favicon.png">
	</head>
	<body>

		<div class="register-area">
			<div class="d-table">
				<div class="d-table-cell">
					<div class="register-form">
						<div class="logo">
							<a href="dashboard-analytics.html"><img src="<?= base_url() ?>assets/img/logo.png" alt="image" style="max-width: 20%;"></a>
						</div>
						<h2>Register</h2>
						<div class="form">
							<div class="form-group">
								<input type="text" class="form-control" id="nama" placeholder="Nama">
								<span class="label-title"><i class='bx bx-user'></i></span>
							</div>

							<div class="row">
								<div class="col-6">
									<div class="form-group">
										<input type="text" class="form-control" id="email" placeholder="Email">
										<span class="label-title"><i class='bx bx-envelope'></i></span>
									</div>
								</div>
								<div class="col-6">
									<div class="form-group">
										<input type="password" class="form-control" id="password" placeholder="Password">
										<span class="label-title"><i class='bx bx-lock'></i></span>
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<input type="text" class="form-control" id="nomor_telepon" placeholder="Nomor Telepon">
								<span class="label-title"><i class='bx bx-phone'></i></span>
							</div>
							<div class="form-group">
								<textarea class="form-control" id="alamat" placeholder="Alamat lengkap"></textarea>
								<span class="label-title"><i class='bx bx-map'></i></span>
							</div>
							<button type="submit" class="register-btn" onclick="register()">Sign Up</button>
							<p class="mb-0">Already have account? <a href="<?= base_url() ?>">Sign In</a></p>
						</div>
						
					</div>
				</div>
			</div>
		</div>


		<script src="<?= base_url() ?>assets/js/vendors.min.js"></script>

		<script src="<?= base_url() ?>assets/js/apexcharts/apexcharts.min.js"></script>
		<script src="<?= base_url() ?>assets/js/apexcharts/apexcharts-stock-prices.js"></script>
		<script src="<?= base_url() ?>assets/js/apexcharts/apexcharts-irregular-data-series.js"></script>
		<script src="<?= base_url() ?>assets/js/apexcharts/apex-custom-line-chart.js"></script>
		<script src="<?= base_url() ?>assets/js/apexcharts/apex-custom-pie-donut-chart.js"></script>
		<script src="<?= base_url() ?>assets/js/apexcharts/apex-custom-area-charts.js"></script>
		<script src="<?= base_url() ?>assets/js/apexcharts/apex-custom-column-chart.js"></script>
		<script src="<?= base_url() ?>assets/js/apexcharts/apex-custom-bar-charts.js"></script>
		<script src="<?= base_url() ?>assets/js/apexcharts/apex-custom-mixed-charts.js"></script>
		<script src="<?= base_url() ?>assets/js/apexcharts/apex-custom-radialbar-charts.js"></script>
		<script src="<?= base_url() ?>assets/js/apexcharts/apex-custom-radar-chart.js"></script>

		<script src="<?= base_url() ?>assets/js/chartjs/chartjs.min.js"></script>


		<script src="<?= base_url() ?>assets/js/jvectormap-1.2.2.min.js"></script>

		<script src="<?= base_url() ?>assets/js/jvectormap-world-mill-en.js"></script>

		<script src="<?= base_url() ?>assets/js/custom.js"></script>
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
		<script src="<?= base_url() ?>assets/js/notif.js"></script>

		<script type="text/javascript">
			$('#nama').val("");
			$('#email').val("");
			$('#password').val("");
			$('#nomor_telepon').val("");
			$('#alamat').val("");
			function register()
			{
				const data = {
					'nama' : $('#nama').val(),
					'email' : $('#email').val(),
					'password' : $('#password').val(),
					'nomor_telepon' : $('#nomor_telepon').val(),
					'alamat' : $('#alamat').val(),
				}

				$.ajax({
					url: '<?= base_url("Backend/Register") ?>',
					data: { 'data': data },
					type: "POST",
					success: function(dataResponse) {
						var dataJson = dataResponse;

						if(dataJson.status == true)
						{
							notif('success', dataJson.notifikasi);
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
	</body>

	</html>