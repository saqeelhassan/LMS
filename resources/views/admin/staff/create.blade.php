@extends('layouts.admin')

@section('content')
<div class="row page-titles mx-0 mb-3">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Add Staff</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.staff.index') }}">Staff</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Add Staff</a></li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Staff Registration (same as public sign-up)</h5>
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
                @if(session('success'))
                    <div class="alert alert-success mb-4">{{ session('success') }}</div>
                @endif

                <form method="post" action="{{ route('admin.staff.store') }}" enctype="multipart/form-data" id="addStaffForm">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">First Name *</label>
                            <input type="text" name="first_name" id="first_name" class="form-control @error('first_name') is-invalid @enderror"
                                placeholder="First name" value="{{ old('first_name') }}" required>
                            @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Last Name *</label>
                            <input type="text" name="last_name" id="last_name" class="form-control @error('last_name') is-invalid @enderror"
                                placeholder="Last name" value="{{ old('last_name') }}" required>
                            @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label for="father_name" class="form-label">Father Name *</label>
                            <input type="text" name="father_name" id="father_name" class="form-control @error('father_name') is-invalid @enderror"
                                placeholder="Father's full name" value="{{ old('father_name') }}" required>
                            @error('father_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="cnic" class="form-label">CNIC *</label>
                            <input type="text" name="cnic" id="cnic" class="form-control @error('cnic') is-invalid @enderror"
                                placeholder="e.g. 42101-1234567-1" value="{{ old('cnic') }}" required>
                            @error('cnic')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="gender" class="form-label">Gender *</label>
                            <select name="gender" id="gender" class="form-select @error('gender') is-invalid @enderror" required>
                                <option value="">Select</option>
                                <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Other" {{ old('gender') === 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="contact_no" class="form-label">Contact No *</label>
                            <input type="text" name="contact_no" id="contact_no" class="form-control @error('contact_no') is-invalid @enderror"
                                placeholder="Contact number" value="{{ old('contact_no') }}" required>
                            @error('contact_no')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="whatsapp" class="form-label">WhatsApp No</label>
                            <input type="text" name="whatsapp" id="whatsapp" class="form-control @error('whatsapp') is-invalid @enderror"
                                placeholder="WhatsApp number" value="{{ old('whatsapp') }}">
                            @error('whatsapp')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label for="emergency_contact" class="form-label">Emergency Contact</label>
                            <input type="text" name="emergency_contact" id="emergency_contact" class="form-control @error('emergency_contact') is-invalid @enderror"
                                placeholder="Emergency contact number" value="{{ old('emergency_contact') }}">
                            @error('emergency_contact')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label for="current_address" class="form-label">Current Address *</label>
                            <textarea name="current_address" id="current_address" rows="2" class="form-control @error('current_address') is-invalid @enderror"
                                placeholder="Full current address" required>{{ old('current_address') }}</textarea>
                            @error('current_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="E-mail" value="{{ old('email') }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="last_qualification" class="form-label">Last Qualification *</label>
                            <input type="text" name="last_qualification" id="last_qualification" class="form-control @error('last_qualification') is-invalid @enderror"
                                placeholder="e.g. Matric, Intermediate, Bachelor" value="{{ old('last_qualification') }}" required>
                            @error('last_qualification')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="domicile_district" class="form-label">Domicile District *</label>
                            <input type="text" name="domicile_district" id="domicile_district" class="form-control @error('domicile_district') is-invalid @enderror"
                                placeholder="District of domicile" value="{{ old('domicile_district') }}" required>
                            @error('domicile_district')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <h6 class="mt-4 mb-2">Documents Upload *</h6>
                    <p class="small text-body-secondary mb-3">Images: JPG/PNG max 2 MB. PDFs max 5 MB.</p>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="cnic_front" class="form-label">CNIC Front Image *</label>
                            <input type="file" name="cnic_front" id="cnic_front" class="form-control @error('cnic_front') is-invalid @enderror"
                                accept="image/jpeg,image/jpg,image/png" required>
                            @error('cnic_front')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="cnic_back" class="form-label">CNIC Back Image *</label>
                            <input type="file" name="cnic_back" id="cnic_back" class="form-control @error('cnic_back') is-invalid @enderror"
                                accept="image/jpeg,image/jpg,image/png" required>
                            @error('cnic_back')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="last_degree" class="form-label">Last Degree Upload *</label>
                            <input type="file" name="last_degree" id="last_degree" class="form-control @error('last_degree') is-invalid @enderror"
                                accept=".pdf,image/jpeg,image/jpg,image/png" required>
                            @error('last_degree')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="domicile_prc" class="form-label">Domicile / PRC *</label>
                            <input type="file" name="domicile_prc" id="domicile_prc" class="form-control @error('domicile_prc') is-invalid @enderror"
                                accept=".pdf,image/jpeg,image/jpg,image/png" required>
                            @error('domicile_prc')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password *</label>
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                                placeholder="At least 8 characters" required minlength="8">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label">Confirm Password *</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                                placeholder="Confirm password" required minlength="8">
                        </div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Add Staff</button>
                        <a href="{{ route('admin.staff.index') }}" class="btn btn-danger light">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('addStaffForm')?.addEventListener('submit', function(e) {
    var pwd = document.getElementById('password').value;
    var conf = document.getElementById('password_confirmation').value;
    if (pwd !== conf) {
        e.preventDefault();
        document.getElementById('password_confirmation').classList.add('is-invalid');
    }
});
</script>
@endsection
