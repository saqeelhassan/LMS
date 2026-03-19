@extends('layouts.admin')

@section('content')
<div class="row page-titles mx-0 mb-3">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Staff Profile</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex align-items-center">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.staff.index') }}">Staff</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0);">Staff Profile</a></li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-xxl-4 col-lg-4">
        <div class="row">
            <div class="col-lg-12">
                <div class="card overflow-hidden">
                    <div class="text-center p-3 overlay-box" style="background-image: url({{ asset('Dsimt-lms-assets/images/big/img1.jpg') }}); background-color: var(--bs-primary, #0d6efd);">
                        <div class="profile-photo">
                            @if($staff->avatar_url)
                                <img src="{{ $staff->avatar_url }}" width="100" class="img-fluid rounded-circle" alt="">
                            @else
                                <span class="rounded-circle bg-white text-primary d-inline-flex align-items-center justify-content-center fw-bold" style="width:100px;height:100px;font-size:2.5rem;">{{ strtoupper(substr($staff->name ?? $staff->email ?? 'S', 0, 1)) }}</span>
                            @endif
                        </div>
                        <h3 class="mt-3 mb-1 text-white">{{ $staff->name }}</h3>
                        <p class="text-white mb-0">{{ $staff->userDetail?->designation ?? $staff->role?->name ?? 'Staff' }}</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Mobile</span> <strong class="text-muted">{{ $staff->userDetail?->mobile ?? '—' }}</strong></li>
                        <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Email</span> <strong class="text-muted text-break">{{ Str::limit($staff->email, 20) }}</strong></li>
                        <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Joined</span> <strong class="text-muted">{{ $staff->created_at?->format('d M Y') ?? '—' }}</strong></li>
                    </ul>
                    <div class="card-footer text-center border-0 mt-0">
                        <a href="{{ route('admin.staff.edit', $staff) }}" class="btn btn-primary px-4">Edit</a>
                        <a href="{{ route('admin.staff.index') }}" class="btn btn-warning px-4">Back to List</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="card overflow-hidden">
                    <div class="card-header">
                        <h2 class="card-title">About Me</h2>
                    </div>
                    <div class="card-body pb-0">
                        <p class="text-muted mb-3">{{ $staff->userDetail?->address ? Str::limit($staff->userDetail->address, 80) : 'No description added yet.' }}</p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex px-0 justify-content-between">
                                <strong>Gender</strong>
                                <span class="mb-0">{{ $staff->userDetail?->gender ?? '—' }}</span>
                            </li>
                            <li class="list-group-item d-flex px-0 justify-content-between">
                                <strong>Education</strong>
                                <span class="mb-0">{{ $staff->userDetail?->last_qualification ?? '—' }}</span>
                            </li>
                            <li class="list-group-item d-flex px-0 justify-content-between">
<strong>Designation</strong>
                                                <span class="mb-0">{{ $staff->userDetail?->designation ?? $staff->role?->name ?? 'Staff' }}</span>
                            </li>
                            <li class="list-group-item d-flex px-0 justify-content-between">
                                <strong>Joined</strong>
                                <span class="mb-0">{{ $staff->created_at?->format('d M Y') ?? '—' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @if($staff->userDetail?->address)
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header d-block">
                        <h4 class="card-title">Address</h4>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $staff->userDetail->address }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <div class="col-xl-9 col-xxl-8 col-lg-8">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="profile-tab">
                            <div class="custom-tab-1">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item"><a href="#about-me" data-bs-toggle="tab" class="nav-link active show">About Me</a></li>
                                </ul>
                                <div class="tab-content">
                                    <div id="about-me" class="tab-pane fade active show">
                                        <div class="profile-personal-info pt-4">
                                            <h4 class="text-primary mb-4">Personal Information</h4>
                                            <div class="row mb-4">
                                                <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                                    <h5 class="f-w-500">Name <span class="pull-right">:</span></h5>
                                                </div>
                                                <div class="col-lg-9 col-md-8 col-sm-6 col-6"><span>{{ $staff->name }}</span></div>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                                    <h5 class="f-w-500">Email <span class="pull-right">:</span></h5>
                                                </div>
                                                <div class="col-lg-9 col-md-8 col-sm-6 col-6"><span><a href="mailto:{{ $staff->email }}">{{ $staff->email }}</a></span></div>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                                    <h5 class="f-w-500">Mobile <span class="pull-right">:</span></h5>
                                                </div>
                                                <div class="col-lg-9 col-md-8 col-sm-6 col-6"><span>{{ $staff->userDetail?->mobile ?? '—' }}</span></div>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                                    <h5 class="f-w-500">Designation <span class="pull-right">:</span></h5>
                                                </div>
                                                <div class="col-lg-9 col-md-8 col-sm-6 col-6"><span>{{ $staff->userDetail?->designation ?? $staff->role?->name ?? 'Staff' }}</span></div>
                                            </div>
                                            <div class="row mb-4">
                                                <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                                    <h5 class="f-w-500">Joined <span class="pull-right">:</span></h5>
                                                </div>
                                                <div class="col-lg-9 col-md-8 col-sm-6 col-6"><span>{{ $staff->created_at?->format('d F Y, H:i') ?? '—' }}</span></div>
                                            </div>
                                            @if($staff->userDetail?->address)
                                            <div class="row mb-4">
                                                <div class="col-lg-3 col-md-4 col-sm-6 col-6">
                                                    <h5 class="f-w-500">Address <span class="pull-right">:</span></h5>
                                                </div>
                                                <div class="col-lg-9 col-md-8 col-sm-6 col-6"><span>{{ $staff->userDetail->address }}</span></div>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
