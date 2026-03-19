@extends('layouts.admin')

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <h1 class="h3 mb-2 mb-sm-0">Send broadcast</h1>
        <p class="mb-0 text-body">Send SMS/WhatsApp to all students (e.g. Institute closed tomorrow).</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-body p-4">
                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0 list-unstyled small">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif
                <form method="post" action="{{ route('admin.broadcasts.store') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="title" class="form-label">Title (optional)</label>
                        <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" maxlength="255" placeholder="e.g. Institute closed tomorrow">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Message *</label>
                        <textarea name="message" id="message" class="form-control @error('message') is-invalid @enderror" rows="4" maxlength="1000" required placeholder="Type your message here...">{{ old('message') }}</textarea>
                        @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <small class="text-muted">Max 1000 characters</small>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="channel" class="form-label">Channel *</label>
                            <select name="channel" id="channel" class="form-select @error('channel') is-invalid @enderror" required>
                                <option value="sms" {{ old('channel') === 'sms' ? 'selected' : '' }}>SMS</option>
                                <option value="whatsapp" {{ old('channel') === 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                            </select>
                            @error('channel')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="target" class="form-label">Target *</label>
                            <select name="target" id="target" class="form-select @error('target') is-invalid @enderror" required>
                                <option value="all_students" {{ old('target', 'all_students') === 'all_students' ? 'selected' : '' }}>All students</option>
                            </select>
                            @error('target')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Send broadcast</button>
                        <a href="{{ route('admin.broadcasts.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
        <p class="small text-muted mt-3">SMS/WhatsApp API integration required for actual delivery. Configure your provider in the application settings.</p>
    </div>
</div>
@endsection
