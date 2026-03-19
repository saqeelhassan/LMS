@extends('layouts.admin')

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <h4 class="card-title mb-1">Add Professor</h4>
        <p class="mb-0 text-muted small">Create a new instructor (professor) account.</p>
    </div>
</div>

<div class="card">
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

        <form method="post" action="{{ route('admin.professors.store') }}">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                    <input type="text" name="first_name" id="first_name" class="form-control @error('first_name') is-invalid @enderror"
                        placeholder="Enter First Name" value="{{ old('first_name') }}" required>
                    @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                    <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                    <input type="text" name="last_name" id="last_name" class="form-control @error('last_name') is-invalid @enderror"
                        placeholder="Enter Last Name" value="{{ old('last_name') }}" required>
                    @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
            </div>
            <div class="mt-3">
                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                    placeholder="Email Here" value="{{ old('email') }}" required>
                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mt-3">
                <label for="mobile" class="form-label">Mobile Number</label>
                <input type="text" name="mobile" id="mobile" class="form-control @error('mobile') is-invalid @enderror"
                    placeholder="Mobile Number" value="{{ old('mobile') }}" maxlength="20">
                @error('mobile')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mt-3">
                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                    placeholder="Password" required minlength="8">
                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mt-3">
                <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                    placeholder="Confirm Password" required minlength="8">
            </div>
            <div class="mt-4 d-flex gap-2">
                <button type="submit" class="btn btn-primary">Add Professor</button>
                <a href="{{ route('admin.professors.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
