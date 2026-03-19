<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('images/favicon.png') }}" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/auth-iofrm.css') }}">
</head>
<body>
    <div class="form-body">
        <div class="iofrm-layout">
            <div class="img-holder">
                <div class="bg"></div>
                <div class="info-holder">
                    <h3>Get more things done with Login platform.</h3>
                    <p>Access to the most powerful tool in the entire design and web industry.</p>
                    <img src="{{ asset('images/logo.png') }}" alt="" style="max-height: 120px; opacity: 0.9;">
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <div class="website-logo-inside">
                            <a href="{{ url('/') }}">
                                <div class="logo">
                                    <img class="logo-size" src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}">
                                </div>
                            </a>
                        </div>
                        @if(session('success'))
                            <div class="alert alert-success py-2 small">{{ session('success') }}</div>
                        @endif
                        @if(session('info'))
                            <div class="alert alert-info py-2 small">{{ session('info') }}</div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-warning py-2 small">{{ session('error') }}</div>
                        @endif
                        @if($errors->any())
                            <div class="alert alert-danger py-2 small">
                                <ul class="mb-0 list-unstyled small">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="post" action="{{ route('auth.login') }}">
                            @csrf
                            @if(request('intended'))
                                <input type="hidden" name="intended" value="{{ request('intended') }}">
                            @endif
                            @if(request('enroll_course'))
                                <input type="hidden" name="enroll_course" value="{{ request('enroll_course') }}">
                            @endif
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="E-mail Address" value="{{ old('email') }}" required autofocus>
                            @error('email')<div class="invalid-feedback d-block small">{{ $message }}</div>@enderror
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                            @error('password')<div class="invalid-feedback d-block small">{{ $message }}</div>@enderror
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="form-check">
                                    <input type="checkbox" name="remember" value="1" class="form-check-input" id="remember">
                                    <label class="form-check-label small" for="remember">Remember me</label>
                                </div>
                                <a href="{{ route('password.request') }}" class="small">Forget password?</a>
                            </div>
                            <div class="form-button">
                                <button type="submit" class="ibtn btn btn-primary">Sign in</button>
                            </div>
                        </form>
                        <div class="other-links mt-2">
                            <span>Don't have an account? </span>
                            <a href="{{ route('auth.sign-up.student') }}">Student</a> · <a href="{{ route('auth.sign-up.staff') }}">Staff</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
