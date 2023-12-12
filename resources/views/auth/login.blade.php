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
						Welcome back, <br />Please login to your Vivo admin account.
					</div>
					<div class="mb-3">
						<label class="form-label">Username</label>
						<input type="text" class="form-control">
					</div>
					<div class="mb-3">
						<div class="d-flex justify-content-between">
							<label class="form-label">Password</label>
							<a href="forgot-password.html" class="btn-link ml-auto">Forgot password?</a>
						</div>
						<input type="password" class="form-control">
					</div>
					<div class="login-form-actions">
						<button type="submit" class="btn"> <span class="icon"> <i class="bi bi-arrow-right-circle"></i> </span>
							Login</button>
					</div>
					<div class="login-form-footer">
						<div class="additional-link">
							Don't have an account? <a href="signup.html"> Signup</a>
						</div>
					</div>
				</div>
			</div>
		</form>
		<!-- Login box end -->
</div>