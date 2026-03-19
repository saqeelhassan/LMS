@php $layout = $layout ?? 'layouts.admin'; @endphp
@extends($layout)

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <h1 class="h3 mb-2 mb-sm-0">Edit Profile</h1>
        <p class="mb-0 text-body">Update your name and contact details.</p>
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

                <form method="post" action="{{ route('account.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label class="form-label">Profile picture</label>
                        <div class="d-flex align-items-center gap-3 flex-wrap">
                            <div class="avatar avatar-xxl" id="profile-picture-preview-wrap">
                                @if($user->avatar_url)
                                    <img class="avatar-img rounded-circle border shadow" id="profile-picture-preview" src="{{ $user->avatar_url }}" alt="Profile" style="width:5rem;height:5rem;object-fit:cover;">
                                @else
                                    @php $initials = trim(substr($user->userDetail?->first_name ?? '', 0, 1) . substr($user->userDetail?->last_name ?? '', 0, 1)); if (!$initials) { $initials = substr($user->email ?? 'U', 0, 1); } @endphp
                                    <div class="avatar-img rounded-circle border shadow bg-primary text-white d-flex align-items-center justify-content-center text-uppercase fw-bold" id="profile-picture-initials" style="width:5rem;height:5rem;font-size:1.5rem;">{{ $initials }}</div>
                                    <img class="avatar-img rounded-circle border shadow d-none" id="profile-picture-preview-new" src="" alt="Profile" style="width:5rem;height:5rem;object-fit:cover;">
                                @endif
                            </div>
                            <div>
                                <input type="file" name="profile_picture" id="profile_picture" class="form-control form-control-sm @error('profile_picture') is-invalid @enderror" accept="image/jpeg,image/png,image/gif,image/webp">
                                <p class="small text-body mb-0 mt-1">JPG, PNG, GIF or WebP. Max 2 MB.</p>
                                @error('profile_picture')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <script>
                    document.getElementById('profile_picture')?.addEventListener('change', function(e) {
                        var wrap = document.getElementById('profile-picture-preview-wrap');
                        var img = wrap?.querySelector('#profile-picture-preview, #profile-picture-preview-new');
                        var initials = document.getElementById('profile-picture-initials');
                        var file = e.target.files[0];
                        if (!file || !file.type.startsWith('image/')) return;
                        var reader = new FileReader();
                        reader.onload = function() {
                            if (img) {
                                img.src = reader.result;
                                img.classList.remove('d-none');
                                img.style.width = img.style.height = '5rem';
                            }
                            if (initials) initials.classList.add('d-none');
                        };
                        reader.readAsDataURL(file);
                    });
                    </script>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">First name *</label>
                            <input type="text" name="first_name" id="first_name" class="form-control @error('first_name') is-invalid @enderror"
                                value="{{ old('first_name', $user->userDetail?->first_name) }}" required maxlength="100">
                            @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Last name *</label>
                            <input type="text" name="last_name" id="last_name" class="form-control @error('last_name') is-invalid @enderror"
                                value="{{ old('last_name', $user->userDetail?->last_name) }}" required maxlength="100">
                            @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" value="{{ $user->email }}" disabled>
                        <p class="small text-body mb-0">Email cannot be changed here.</p>
                    </div>
                    <div class="mb-4">
                        <label for="mobile" class="form-label">Mobile (optional)</label>
                        <input type="text" name="mobile" id="mobile" class="form-control @error('mobile') is-invalid @enderror"
                            value="{{ old('mobile', $user->userDetail?->mobile) }}" maxlength="20">
                        @error('mobile')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
