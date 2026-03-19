<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up as Student - {{ config('app.name') }}</title>
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
                    <h3>Create your student account.</h3>
                    <p>Sign up to enroll in courses and start learning with us.</p>
                    <img src="{{ asset('images/logo.png') }}" alt="" style="max-height: 120px; opacity: 0.9;">
                </div>
            </div>
            <div class="form-holder">
                <div class="form-content auth-signup">
                    <div class="form-items">
                        <div class="website-logo-inside">
                            <a href="{{ url('/') }}">
                                <div class="logo">
                                    <img class="logo-size" src="{{ asset('images/logo.png') }}" alt="{{ config('app.name') }}">
                                </div>
                            </a>
                        </div>
                        <div class="page-links">
                            <a href="{{ route('login') }}">Login</a>
                            <a href="{{ route('auth.sign-up.student') }}" class="active">Register</a>
                        </div>

                        @if(session('success'))
                            <div class="alert alert-success py-2 small">{{ session('success') }}</div>
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

                        <form method="post" action="{{ route('auth.register.student') }}" enctype="multipart/form-data" class="auth-signup-form">
                            @csrf
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror" placeholder="First name *" value="{{ old('first_name') }}" required>
                                    @error('first_name')<div class="invalid-feedback d-block small">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror" placeholder="Last name *" value="{{ old('last_name') }}" required>
                                    @error('last_name')<div class="invalid-feedback d-block small">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <input type="text" name="father_name" class="form-control @error('father_name') is-invalid @enderror" placeholder="Father name *" value="{{ old('father_name') }}" required>
                                    @error('father_name')<div class="invalid-feedback d-block small">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="cnic" class="form-control @error('cnic') is-invalid @enderror" placeholder="CNIC * (e.g. 42101-1234567-1)" value="{{ old('cnic') }}" required>
                                    @error('cnic')<div class="invalid-feedback d-block small">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                                        <option value="">Gender *</option>
                                        <option value="Male" {{ old('gender') === 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('gender') === 'Female' ? 'selected' : '' }}>Female</option>
                                        <option value="Other" {{ old('gender') === 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('gender')<div class="invalid-feedback d-block small">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="contact_no" class="form-control @error('contact_no') is-invalid @enderror" placeholder="Contact no *" value="{{ old('contact_no') }}" required>
                                    @error('contact_no')<div class="invalid-feedback d-block small">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="whatsapp" class="form-control @error('whatsapp') is-invalid @enderror" placeholder="WhatsApp no" value="{{ old('whatsapp') }}">
                                    @error('whatsapp')<div class="invalid-feedback d-block small">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <input type="text" name="emergency_contact" class="form-control @error('emergency_contact') is-invalid @enderror" placeholder="Emergency contact" value="{{ old('emergency_contact') }}">
                                    @error('emergency_contact')<div class="invalid-feedback d-block small">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <textarea name="current_address" rows="2" class="form-control @error('current_address') is-invalid @enderror" placeholder="Current address *" required>{{ old('current_address') }}</textarea>
                                    @error('current_address')<div class="invalid-feedback d-block small">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email *" value="{{ old('email') }}" required>
                                    @error('email')<div class="invalid-feedback d-block small">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="last_qualification" class="form-control @error('last_qualification') is-invalid @enderror" placeholder="Last qualification *" value="{{ old('last_qualification') }}" required>
                                    @error('last_qualification')<div class="invalid-feedback d-block small">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="text" name="domicile_district" class="form-control @error('domicile_district') is-invalid @enderror" placeholder="Domicile district *" value="{{ old('domicile_district') }}" required>
                                    @error('domicile_district')<div class="invalid-feedback d-block small">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <p class="small text-body-secondary mt-3 mb-2">Documents (JPG/PNG max 2 MB, PDF max 5 MB)</p>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label class="form-label small mb-0">CNIC front *</label>
                                    <input type="file" name="cnic_front" class="form-control form-control-sm @error('cnic_front') is-invalid @enderror" accept="image/jpeg,image/jpg,image/png" required>
                                    @error('cnic_front')<div class="invalid-feedback d-block small">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small mb-0">CNIC back *</label>
                                    <input type="file" name="cnic_back" class="form-control form-control-sm @error('cnic_back') is-invalid @enderror" accept="image/jpeg,image/jpg,image/png" required>
                                    @error('cnic_back')<div class="invalid-feedback d-block small">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small mb-0">Last degree *</label>
                                    <input type="file" name="last_degree" class="form-control form-control-sm @error('last_degree') is-invalid @enderror" accept=".pdf,image/jpeg,image/jpg,image/png" required>
                                    @error('last_degree')<div class="invalid-feedback d-block small">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small mb-0">Domicile / PRC *</label>
                                    <input type="file" name="domicile_prc" class="form-control form-control-sm @error('domicile_prc') is-invalid @enderror" accept=".pdf,image/jpeg,image/jpg,image/png" required>
                                    @error('domicile_prc')<div class="invalid-feedback d-block small">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="mt-3">
                                <select name="course_id" class="form-select @error('course_id') is-invalid @enderror">
                                    <option value="">-- Select course (optional) --</option>
                                    @foreach($courses ?? [] as $course)
                                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                                    @endforeach
                                </select>
                                @error('course_id')<div class="invalid-feedback d-block small">{{ $message }}</div>@enderror
                            </div>

                            <input type="password" name="password" class="form-control mt-3 @error('password') is-invalid @enderror" placeholder="Password *" required>
                            @error('password')<div class="invalid-feedback d-block small">{{ $message }}</div>@enderror
                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password *" required>

                            <div class="form-button mt-3">
                                <button type="submit" class="ibtn btn btn-primary">Sign up as Student</button>
                            </div>
                        </form>

                        <div class="other-links mt-2">
                            <span>Already have an account?</span>
                            <a href="{{ route('login') }}">Sign in</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
