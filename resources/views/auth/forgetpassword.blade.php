<head>
    <script type="module" crossorigin src="{{ asset('assets/js/main.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <!-- Animated css -->
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <!-- Bootstrap css -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <!-- Bootstrap font icons css -->
    <link rel="stylesheet" href="{{ asset('assets/fonts/bootstrap/bootstrap-icons.css') }}">
</head>
<div class="login-container">
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="login-box">
            <div class="login-form">
                <div class="login-welcome">
                    In order to access your account,<br />please enter the email id you provided during the
                    registration
                    process.
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email Address') }}</label>

                    <div class="">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="mb-0">
                    <div class="login-form-actions">
                        <button type="submit" class="btn">
                            <span class="icon"> <i
                                class="bi bi-arrow-right-circle"></i> </span>
                            {{ __('Submit') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Login box end -->
</div>
