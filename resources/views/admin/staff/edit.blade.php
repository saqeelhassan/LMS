@extends('layouts.admin')

@section('content')
<div class="row page-titles mx-0 mb-3">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Edit Staff</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.staff.index') }}">Staff</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0);">Edit Staff</a></li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Basic Info</h5>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0 list-unstyled small">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="post" action="{{ route('admin.staff.update', $staff) }}" id="editStaffForm">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="first_name">First Name</label>
                                <input id="first_name" name="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror"
                                    value="{{ old('first_name', $staff->userDetail?->first_name) }}" required>
                                @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="last_name">Last Name</label>
                                <input id="last_name" name="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror"
                                    value="{{ old('last_name', $staff->userDetail?->last_name) }}" required>
                                @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="email_display">Email Here</label>
                                <input id="email_display" type="email" class="form-control bg-light" value="{{ $staff->email }}" readonly>
                                <small class="text-muted">Email cannot be changed.</small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Joining Date</label>
                                <div class="input-hasicon mb-xl-0 mb-3">
                                    <input type="text" class="form-control bg-light" value="{{ $staff->created_at?->format('d F, Y') ?? '—' }}" readonly>
                                    <div class="icon"><i class="far fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group pass-group">
                                    <input placeholder="Leave blank to keep current" name="password" id="password" type="password"
                                        class="form-control pass-input @error('password') is-invalid @enderror" minlength="8">
                                    <span class="input-group-text pass-handle">
                                        <i class="fa fa-eye-slash"></i>
                                        <i class="fa fa-eye d-none"></i>
                                    </span>
                                </div>
                                @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="password_confirmation">Confirm Password</label>
                                <div class="input-group pass-group">
                                    <input placeholder="Confirm new password" name="password_confirmation" id="password_confirmation" type="password" class="form-control pass-input" minlength="8">
                                    <span class="input-group-text pass-handle">
                                        <i class="fa fa-eye-slash"></i>
                                        <i class="fa fa-eye d-none"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="mobile">Mobile Number</label>
                                <input id="mobile" name="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror"
                                    value="{{ old('mobile', $staff->userDetail?->mobile) }}" maxlength="20">
                                @error('mobile')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="gender">Gender</label>
                                <select name="gender" id="gender" class="form-control">
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender', $staff->userDetail?->gender) === 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $staff->userDetail?->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender', $staff->userDetail?->gender) === 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="designation">Designation</label>
                                <input id="designation" name="designation" type="text" class="form-control @error('designation') is-invalid @enderror"
                                    placeholder="e.g. Clerk, Receptionist" value="{{ old('designation', $staff->userDetail?->designation) }}" maxlength="100">
                                @error('designation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="last_qualification">Education</label>
                                <input id="last_qualification" name="last_qualification" type="text" class="form-control @error('last_qualification') is-invalid @enderror"
                                    value="{{ old('last_qualification', $staff->userDetail?->last_qualification) }}" placeholder="e.g. B.COM, M.COM">
                                @error('last_qualification')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="address">Address</label>
                                <textarea id="address" name="address" class="form-control @error('address') is-invalid @enderror" rows="5" maxlength="500">{{ old('address', $staff->userDetail?->address) }}</textarea>
                                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('admin.staff.index') }}" class="btn btn-danger light">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('editStaffForm')?.addEventListener('submit', function(e) {
    var pwd = document.getElementById('password').value;
    var conf = document.getElementById('password_confirmation').value;
    if (pwd !== '' && pwd !== conf) {
        e.preventDefault();
        document.getElementById('password_confirmation').classList.add('is-invalid');
    }
});
// Password visibility toggle (pass-handle)
document.querySelectorAll('.pass-group').forEach(function(group) {
    var handle = group.querySelector('.pass-handle');
    var input = group.querySelector('.pass-input');
    if (!handle || !input) return;
    handle.addEventListener('click', function() {
        var eyeSlash = handle.querySelector('.fa-eye-slash');
        var eye = handle.querySelector('.fa-eye');
        if (input.type === 'password') {
            input.type = 'text';
            if (eyeSlash) eyeSlash.classList.add('d-none');
            if (eye) eye.classList.remove('d-none');
        } else {
            input.type = 'password';
            if (eyeSlash) eyeSlash.classList.remove('d-none');
            if (eye) eye.classList.add('d-none');
        }
    });
});
</script>
@endsection
