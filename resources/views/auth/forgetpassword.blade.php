<head>
    <script type="module" crossorigin src="{{asset('assets/js/main.js')}}"></script>
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
    <!-- Animated css -->
    <link rel="stylesheet" href="{{asset('assets/css/animate.css')}}">
    <!-- Bootstrap css -->
	<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <!-- Bootstrap font icons css -->
	<link rel="stylesheet" href="{{asset('assets/fonts/bootstrap/bootstrap-icons.css')}}">
</head>
<div class="login-container">
			<!-- Login box start -->
			<form action="index.html">
				<div class="login-box">
					<div class="login-form">
						<a href="index.html" class="login-logo">
							<img src="{{asset('assets/img')}}/logo.svg" alt="Vico Admin" />
						</a>
						<div class="login-welcome">
							In order to access your Vivo account,<br />please enter the email id you provided during the registration
							process.
						</div>
						<div class="mb-3">
							<label class="form-label">Email</label>
							<input type="email" class="form-control" placeholder="Enter your email">
						</div>
						<div class="login-form-actions">
							<button type="submit" class="btn"> <span class="icon"> <i class="bi bi-arrow-right-circle"></i> </span>
								Submit</button>
						</div>
					</div>
				</div>
			</form>
			<!-- Login box end -->
</div>
