@extends('layouts.super-admin')

@section('title', 'Create Course')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Create New Course</h4>
                    <p class="card-text mb-0">Add a new course to the LMS</p>
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

                    <form method="post" action="{{ route('instructor.courses.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="thumbnail" class="form-label">Thumbnail image (optional)</label>
                            <input type="file" name="thumbnail" id="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" accept="image/jpeg,image/png,image/webp,image/gif">
                            <div class="form-text">Recommended: 16:9 or 4:3, max 2 MB. JPEG, PNG, WebP or GIF.</div>
                            @error('thumbnail')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Course name *</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" required maxlength="255" placeholder="Enter course title">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="course_mode_id" class="form-label">Category *</label>
                            <select name="course_mode_id" id="course_mode_id" class="form-select @error('course_mode_id') is-invalid @enderror" required>
                                <option value="">— Select category —</option>
                                @foreach($courseModes as $mode)
                                    <option value="{{ $mode->id }}" {{ (int) old('course_mode_id') === $mode->id ? 'selected' : '' }}>{{ $mode->name }}</option>
                                @endforeach
                            </select>
                            @error('course_mode_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            @if($courseModes->isEmpty())
                                <p class="small text-muted mt-1 mb-0">No categories available. Contact admin to add course categories.</p>
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description (optional)</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4" maxlength="5000">{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="release_date" class="form-label">Release date</label>
                                <input type="date" name="release_date" id="release_date" class="form-control" value="{{ old('release_date') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="total_hours" class="form-label">Total hours</label>
                                <input type="text" name="total_hours" id="total_hours" class="form-control" value="{{ old('total_hours') }}" placeholder="e.g. 4h 50m" maxlength="50">
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="skills" class="form-label">Skills level</label>
                                <input type="text" name="skills" id="skills" class="form-control" value="{{ old('skills') }}" placeholder="e.g. All level" maxlength="255">
                            </div>
                            <div class="col-md-6">
                                <label for="total_lectures" class="form-label">Total lectures</label>
                                <input type="number" name="total_lectures" id="total_lectures" class="form-control" value="{{ old('total_lectures') }}" min="0" placeholder="e.g. 30">
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="language" class="form-label">Language</label>
                                <input type="text" name="language" id="language" class="form-control" value="{{ old('language') }}" placeholder="e.g. English" maxlength="100">
                            </div>
                            <div class="col-md-6">
                                <label for="live_class_url" class="form-label">Live class URL (Zoom/Meet)</label>
                                <input type="url" name="live_class_url" id="live_class_url" class="form-control" value="{{ old('live_class_url') }}" placeholder="https://zoom.us/j/... or https://meet.google.com/...">
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" name="certificate" id="certificate" class="form-check-input" value="1" {{ old('certificate', true) ? 'checked' : '' }}>
                                <label for="certificate" class="form-check-label">Certificate offered</label>
                            </div>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">Create course</button>
                            <a href="{{ route('instructor.manage-course') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
