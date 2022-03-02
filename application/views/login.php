<!doctype html>
	<html lang="zxx">
	<head>

		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link rel="stylesheet" href="<?= base_url() ?>assets/css/vendors.min.css">

		<link rel="stylesheet" href="<?= base_url() ?>assets/css/style.css">

		<link rel="stylesheet" href="<?= base_url() ?>assets/css/responsive.css">
		<title>Olaf - Admin Dashboard Template</title>
		<link rel="icon" type="image/png" href="<?= base_url() ?>assets/img/favicon.png">
	</head>
	<body>

		<div class="login-area">
			<div class="d-table">
				<div class="d-table-cell">
					<div class="login-form">
						<div class="logo">
							<a href="dashboard-analytics.html"><img src="<?= base_url() ?>assets/img/logo.png" alt="image"></a>
						</div>
						<h2>Welcome</h2>
						<div class="form">
							<div class="form-group">
								<input type="text" class="form-control" id="email" placeholder="Email">
								<span class="label-title"><i class='bx bx-user'></i></span>
							</div>
							<div class="form-group">
								<input type="password" class="form-control" id="password" placeholder="Password">
								<span class="label-title"><i class='bx bx-lock'></i></span>
							</div>
							<div class="form-group">
								<div class="remember-forgot">
									<label class="checkbox-box">Remember me
										<input type="checkbox">
										<span class="checkmark"></span>
									</label>
									<a href="forgot-password.html" class="forgot-password">Forgot password?</a>
								</div>
							</div>
							<button type="submit" class="login-btn" onclick="login()">Login</button>
							<p class="mb-0">Don’t have an account? <a href="<?= base_url('daftar') ?>">Sign Up</a></p>
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
			function login()
			{
				const data = {
					'email' 	: $('#email').val(),
					'password' 	: $('#password').val(),
				}


				$.ajax({
					url: '<?= base_url("Backend/Proseslogin") ?>',
					data: { 'data': data },
					type: "POST",
					success: function(dataResponse) {
						var dataJson = dataResponse;

						if(dataJson.status == true)
						{
							location.replace("<?= base_url('home') ?>");
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