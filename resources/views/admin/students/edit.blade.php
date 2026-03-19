@extends('layouts.admin')

@section('content')
<div class="row page-titles mx-0 mb-3">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Edit Student</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.students.index') }}">Students</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0);">Edit Student</a></li>
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

                <form method="post" action="{{ route('admin.students.update', $student) }}" id="editStudentForm" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="first_name">First Name</label>
                                <input id="first_name" name="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror"
                                    value="{{ old('first_name', $student->userDetail?->first_name) }}" required>
                                @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="last_name">Last Name</label>
                                <input id="last_name" name="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror"
                                    value="{{ old('last_name', $student->userDetail?->last_name) }}" required>
                                @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="email_display">Email</label>
                                <input id="email_display" type="email" class="form-control bg-light" value="{{ $student->email }}" readonly>
                                <small class="text-muted">Email cannot be changed here.</small>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="registration_date">Registration Date</label>
                                <div class="input-hasicon mb-xl-0 mb-3">
                                    <input id="registration_date" type="text" class="form-control bg-light" value="{{ $student->created_at?->format('d F, Y') ?? '—' }}" readonly>
                                    <div class="icon"><i class="far fa-calendar"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                                    <option value="">Select Gender</option>
                                    <option value="Male" {{ old('gender', $student->userDetail?->gender) === 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $student->userDetail?->gender) === 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ old('gender', $student->userDetail?->gender) === 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="mobile">Mobile Number</label>
                                <input id="mobile" name="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror"
                                    value="{{ old('mobile', $student->userDetail?->mobile) }}" maxlength="20" placeholder="Mobile Number">
                                @error('mobile')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="father_name">Parents Name</label>
                                <input id="father_name" name="father_name" type="text" class="form-control @error('father_name') is-invalid @enderror"
                                    value="{{ old('father_name', $student->userDetail?->father_name) }}" placeholder="Parents Name">
                                @error('father_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="emergency_contact">Parents Mobile Number</label>
                                <input id="emergency_contact" name="emergency_contact" type="text" class="form-control @error('emergency_contact') is-invalid @enderror"
                                    value="{{ old('emergency_contact', $student->userDetail?->emergency_contact) }}" maxlength="20" placeholder="Parents Mobile Number">
                                @error('emergency_contact')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="password">Password</label>
                                <input placeholder="Leave blank to keep current" name="password" id="password" type="password" class="form-control @error('password') is-invalid @enderror" minlength="8">
                                @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="password_confirmation">Confirm Password</label>
                                <input placeholder="Confirm new password" name="password_confirmation" id="password_confirmation" type="password" class="form-control" minlength="8">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="address">Address</label>
                                <textarea id="address" name="address" class="form-control @error('address') is-invalid @enderror" rows="5" placeholder="Address">{{ old('address', $student->userDetail?->address) }}</textarea>
                                @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6">
                            <div class="form-group fallback w-100">
                                <label class="form-label d-block">Profile Picture</label>
                                <input type="file" name="profile_picture" class="form-control" accept="image/*">
                                @if($student->userDetail?->profile_picture)
                                    <small class="text-muted d-block mt-1">Current: {{ basename($student->userDetail->profile_picture) }}</small>
                                @endif
                                @error('profile_picture')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('admin.students.index') }}" class="btn btn-light">Cancel</a>
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
document.getElementById('editStudentForm')?.addEventListener('submit', function(e) {
    var pwd = document.getElementById('password').value;
    var conf = document.getElementById('password_confirmation').value;
    if (pwd !== '' && pwd !== conf) {
        e.preventDefault();
        document.getElementById('password_confirmation').classList.add('is-invalid');
    }
});
</script>
@endsection
