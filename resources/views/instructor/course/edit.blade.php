@extends('layouts.super-admin')

@section('title', 'Edit Course')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Edit Course</h4>
                    <p class="card-text mb-0">Update course details</p>
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

                    <form method="post" action="{{ route('instructor.courses.update', $course) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="thumbnail" class="form-label">Thumbnail image (optional)</label>
                            @if($course->thumbnail)
                                <div class="mb-2">
                                    <img src="{{ $course->image_url }}" alt="Course thumbnail" class="rounded border" style="max-height: 120px; width: auto;">
                                    <span class="d-block small text-muted mt-1">Current thumbnail</span>
                                </div>
                            @endif
                            <input type="file" name="thumbnail" id="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" accept="image/jpeg,image/png,image/webp,image/gif">
                            <div class="form-text">Leave empty to keep current. Recommended: 16:9 or 4:3, max 2 MB. JPEG, PNG, WebP or GIF.</div>
                            @error('thumbnail')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Course name *</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name', $course->name) }}" required maxlength="255">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="course_mode_id" class="form-label">Category *</label>
                            <select name="course_mode_id" id="course_mode_id" class="form-select @error('course_mode_id') is-invalid @enderror" required>
                                <option value="">— Select category —</option>
                                @foreach($courseModes as $mode)
                                    <option value="{{ $mode->id }}" {{ (int) old('course_mode_id', $course->course_mode_id) === $mode->id ? 'selected' : '' }}>{{ $mode->name }}</option>
                                @endforeach
                            </select>
                            @error('course_mode_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description (optional)</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4" maxlength="5000">{{ old('description', $course->description) }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="release_date" class="form-label">Release date</label>
                                <input type="date" name="release_date" id="release_date" class="form-control" value="{{ old('release_date', $course->release_date?->format('Y-m-d')) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="total_hours" class="form-label">Total hours</label>
                                <input type="text" name="total_hours" id="total_hours" class="form-control" value="{{ old('total_hours', $course->total_hours) }}" placeholder="e.g. 4h 50m" maxlength="50">
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="skills" class="form-label">Skills level</label>
                                <input type="text" name="skills" id="skills" class="form-control" value="{{ old('skills', $course->skills) }}" placeholder="e.g. All level" maxlength="255">
                            </div>
                            <div class="col-md-6">
                                <label for="total_lectures" class="form-label">Total lectures</label>
                                <input type="number" name="total_lectures" id="total_lectures" class="form-control" value="{{ old('total_lectures', $course->total_lectures) }}" min="0" placeholder="e.g. 30">
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="language" class="form-label">Language</label>
                                <input type="text" name="language" id="language" class="form-control" value="{{ old('language', $course->language) }}" placeholder="e.g. English" maxlength="100">
                            </div>
                            <div class="col-md-6">
                                <label for="live_class_url" class="form-label">Live class URL (Zoom/Meet)</label>
                                <input type="url" name="live_class_url" id="live_class_url" class="form-control" value="{{ old('live_class_url', $course->live_class_url) }}" placeholder="https://zoom.us/j/... or https://meet.google.com/...">
                            </div>
                        </div>
                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" name="certificate" id="certificate" class="form-check-input" value="1" {{ old('certificate', $course->certificate) ? 'checked' : '' }}>
                                <label for="certificate" class="form-check-label">Certificate offered</label>
                            </div>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            <button type="submit" class="btn btn-primary">Update course</button>
                            <a href="{{ route('instructor.content.index', $course) }}" class="btn btn-outline-primary">Content</a>
                            <a href="{{ route('instructor.assignments.index', $course) }}" class="btn btn-outline-secondary">Assignments</a>
                            <a href="{{ route('instructor.exams.index', $course) }}" class="btn btn-outline-info">Exams</a>
                            <a href="{{ route('instructor.attendance.index', $course) }}" class="btn btn-outline-success">Attendance</a>
                            <a href="{{ route('instructor.progress.index', $course) }}" class="btn btn-outline-warning">Progress</a>
                            <a href="{{ route('instructor.manage-course') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
