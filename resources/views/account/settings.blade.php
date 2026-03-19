@php $layout = $layout ?? 'layouts.admin'; @endphp
@extends($layout)

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <h1 class="h3 mb-2 mb-sm-0">Account Settings</h1>
        <p class="mb-0 text-body">Change your password.</p>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success mb-4">{{ session('success') }}</div>
@endif

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-body p-4">
                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0 list-unstyled small">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="post" action="{{ route('account.settings.password') }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current password *</label>
                        <input type="password" name="current_password" id="current_password" class="form-control @error('current_password') is-invalid @enderror" required autocomplete="current-password">
                        @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">New password *</label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password">
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <p class="small text-body mb-0">Minimum 8 characters.</p>
                    </div>
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Confirm new password *</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required autocomplete="new-password">
                    </div>
                    <button type="submit" class="btn btn-primary">Change password</button>
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
