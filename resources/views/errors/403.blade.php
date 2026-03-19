@extends('layouts.base')

@section('header')
@include('layouts.partials.navbar', ['ulClass' => 'mx-auto'])
@endsection

@section('content')
<main>
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center py-5">
                    <h1 class="display-1 text-primary fw-bold">403</h1>
                    <h2 class="mb-3">Access denied</h2>
                    <p class="lead text-muted mb-4">{{ isset($exception) ? $exception->getMessage() : 'You do not have permission to access this area.' }}</p>
                    <a href="{{ route('login') }}" class="btn btn-primary">Back to Login</a>
                    @auth
                        <a href="{{ url()->previous() }}" class="btn btn-outline-primary ms-2">Go back</a>
                    @endauth
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
