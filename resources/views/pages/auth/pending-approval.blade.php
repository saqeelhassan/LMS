@extends('layouts.dsimt-guest')

@section('content')
<div class="row justify-content-center">
    <div class="col-sm-10 col-md-8 col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center p-5">
                <span class="fs-1 mb-3 d-inline-block">⏳</span>
                <h1 class="h3 mb-2">Registration submitted</h1>
                <p class="lead text-body mb-4">
                    Your account is pending approval. A Super Admin will review your registration and activate your account soon. You will then be able to log in.
                </p>
                @if(session('success'))
                    <div class="alert alert-success mb-4">{{ session('success') }}</div>
                @endif
                <a href="{{ route('login') }}" class="btn btn-primary"><i class="fas fa-sign-in-alt me-1"></i> Back to login</a>
            </div>
        </div>
    </div>
</div>
@endsection
