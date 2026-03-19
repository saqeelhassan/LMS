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
                        <!-- Title -->
                        <div class="text-center">
                            <h2 class="fw-bold">Welcome to our largest community</h2>
                            <p class="mb-0 h6 fw-light">Let's learn something new today!</p>
                        </div>
                        <!-- SVG Image -->
                        <img src="/images/element/02.svg" class="mt-5" alt="">
                        <!-- Info -->
                        <div class="d-sm-flex mt-5 align-items-center justify-content-center">
                            <ul class="avatar-group mb-2 mb-sm-0">
                                <li class="avatar avatar-sm"><img class="avatar-img rounded-circle"
                                        src="/images/avatar/01.jpg" alt="avatar"></li>
                                <li class="avatar avatar-sm"><img class="avatar-img rounded-circle"
                                        src="/images/avatar/02.jpg" alt="avatar"></li>
                                <li class="avatar avatar-sm"><img class="avatar-img rounded-circle"
                                        src="/images/avatar/03.jpg" alt="avatar"></li>
                                <li class="avatar avatar-sm"><img class="avatar-img rounded-circle"
                                        src="/images/avatar/04.jpg" alt="avatar"></li>
                            </ul>
                            <!-- Content -->
                            <p class="mb-0 h6 fw-light ms-0 ms-sm-3">4k+ Students joined us, now it's your turn.</p>
                        </div>
                    </div>
                </div>
                <!-- Right -->
                <div class="col-12 col-lg-6 d-flex justify-content-center">
                    <div class="row my-5">
                        <div class="col-sm-10 col-xl-12 m-auto">

                            <!-- Title -->
                            <span class="mb-0 fs-1">🤔</span>
                            <h1 class="fs-2">Forgot Password?</h1>
                            <h5 class="fw-light mb-4">Enter your email and we'll send you a link to reset your password.</h5>

                            @if(session('status'))
                                <div class="alert alert-success mb-4">{{ session('status') }}</div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-warning mb-4">{{ session('error') }}</div>
                            @endif
                            @if($errors->any())
                                <div class="alert alert-danger mb-4">
                                    <ul class="mb-0 list-unstyled small">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Form START -->
                            <form method="post" action="{{ route('password.email') }}">
                                @csrf
                                <!-- Email -->
                                <div class="mb-4">
                                    <label for="email" class="form-label">Email address *</label>
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-light rounded-start border-0 text-secondary px-3"><i class="bi bi-envelope-fill"></i></span>
                                        <input type="email" name="email" id="email" class="form-control border-0 bg-light rounded-end ps-1 @error('email') is-invalid @enderror"
                                            placeholder="E-mail" value="{{ old('email') }}" required autofocus>
                                    </div>
                                    @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                </div>
                                <!-- Button -->
                                <div class="align-items-center">
                                    <div class="d-grid">
                                        <button class="btn btn-primary mb-0" type="submit">Send reset link</button>
                                    </div>
                                </div>
                            </form>
                            <!-- Form END -->

                            <div class="mt-4 text-center">
                                <a href="{{ route('login') }}" class="text-primary-hover"><i class="bi bi-arrow-left me-1"></i>Back to login</a>
                            </div>
                        </div>
                    </div> <!-- Row END -->
                </div>
            </div> <!-- Row END -->
        </div>
    </section>
</main>
<!-- **************** MAIN CONTENT END **************** -->
@endsection