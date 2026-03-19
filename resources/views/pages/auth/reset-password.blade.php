@extends('layouts.base')

@section('content')
<!-- **************** MAIN CONTENT START **************** -->
<main>
    <section class="p-0 d-flex align-items-center position-relative overflow-hidden">

        <div class="container-fluid">
            <div class="row">
                <!-- left -->
                <div
                    class="col-12 col-lg-6 d-md-flex align-items-center justify-content-center bg-primary bg-opacity-10 vh-lg-100">
                    <div class="p-3 p-lg-5">
                        <div class="text-center">
                            <h2 class="fw-bold">Welcome back</h2>
                            <p class="mb-0 h6 fw-light">Set a new password for your account.</p>
                        </div>
                        <img src="/images/element/02.svg" class="mt-5" alt="">
                    </div>
                </div>
                <!-- Right -->
                <div class="col-12 col-lg-6 d-flex justify-content-center">
                    <div class="row my-5">
                        <div class="col-sm-10 col-xl-12 m-auto">

                            <span class="mb-0 fs-1">🔐</span>
                            <h1 class="fs-2">Reset password</h1>
                            <p class="fw-light mb-4">Enter your new password below.</p>

                            @if($errors->any())
                                <div class="alert alert-danger mb-4">
                                    <ul class="mb-0 list-unstyled small">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="post" action="{{ route('password.update') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="mb-4">
                                    <label for="email" class="form-label">Email address *</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light rounded-start border-0 text-secondary px-3"><i class="bi bi-envelope-fill"></i></span>
                                        <input type="email" name="email" id="email" class="form-control border-0 bg-light rounded-end ps-1 @error('email') is-invalid @enderror"
                                            placeholder="E-mail" value="{{ old('email', $email) }}" required autofocus>
                                    </div>
                                    @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                                <div class="mb-4">
                                    <label for="password" class="form-label">New password *</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light rounded-start border-0 text-secondary px-3"><i class="fas fa-lock"></i></span>
                                        <input type="password" name="password" id="password" class="form-control border-0 bg-light rounded-end ps-1 @error('password') is-invalid @enderror"
                                            placeholder="*********" required>
                                    </div>
                                    @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    <div class="form-text">At least 8 characters</div>
                                </div>
                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label">Confirm password *</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light rounded-start border-0 text-secondary px-3"><i class="fas fa-lock"></i></span>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control border-0 bg-light rounded-end ps-1"
                                            placeholder="*********" required>
                                    </div>
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-primary mb-0" type="submit">Reset password</button>
                                </div>
                            </form>

                            <div class="mt-4 text-center">
                                <a href="{{ route('login') }}" class="text-primary-hover"><i class="bi bi-arrow-left me-1"></i>Back to login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<!-- **************** MAIN CONTENT END **************** -->
@endsection
