@extends('layouts.admin')

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <h1 class="h3 mb-2 mb-sm-0">Edit course</h1>
        <p class="mb-0 text-body">Update course details.</p>
    </div>
</div>

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

                <form method="post" action="{{ route('admin.courses.update', $course) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Course image</label>
                        @if($course->thumbnail && \Illuminate\Support\Facades\Storage::disk('public')->exists($course->thumbnail))
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->name }}" class="img-thumbnail" style="max-height: 120px;">
                            </div>
                        @endif
                        <input type="file" name="thumbnail" id="thumbnail" class="form-control @error('thumbnail') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg,image/webp,image/gif">
                        <div class="form-text">JPEG, PNG, WebP or GIF. Max 2 MB. Shown on the website /courses page.</div>
                        @error('thumbnail')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Course name *</label>
                        <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $course->name) }}" required maxlength="255">
                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="course_mode_id" class="form-label">Category (course mode) *</label>
                        <select name="course_mode_id" id="course_mode_id" class="form-select @error('course_mode_id') is-invalid @enderror" required>
                            <option value="">— Select mode —</option>
                            @foreach($courseModes as $mode)
                                <option value="{{ $mode->id }}" {{ (int) old('course_mode_id', $course->course_mode_id) === $mode->id ? 'selected' : '' }}>{{ $mode->name }}</option>
                            @endforeach
                        </select>
                        @error('course_mode_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        @if($courseModes->isEmpty())
                            <p class="small text-muted mt-1 mb-0">No course modes found.</p>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description (optional)</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="4" maxlength="5000">{{ old('description', $course->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="release_date" class="form-label">Release date</label>
                            <input type="date" name="release_date" id="release_date" class="form-control @error('release_date') is-invalid @enderror" value="{{ old('release_date', $course->release_date?->format('Y-m-d')) }}">
                            @error('release_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="total_hours" class="form-label">Total hours</label>
                            <input type="text" name="total_hours" id="total_hours" class="form-control @error('total_hours') is-invalid @enderror" value="{{ old('total_hours', $course->total_hours) }}" placeholder="e.g. 4h 50m" maxlength="50">
                            @error('total_hours')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="skills" class="form-label">Skills level</label>
                            <input type="text" name="skills" id="skills" class="form-control @error('skills') is-invalid @enderror" value="{{ old('skills', $course->skills) }}" placeholder="e.g. All level" maxlength="255">
                            @error('skills')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="total_lectures" class="form-label">Total lectures</label>
                            <input type="number" name="total_lectures" id="total_lectures" class="form-control @error('total_lectures') is-invalid @enderror" value="{{ old('total_lectures', $course->total_lectures) }}" min="0" placeholder="e.g. 30">
                            @error('total_lectures')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="language" class="form-label">Language</label>
                            <input type="text" name="language" id="language" class="form-control @error('language') is-invalid @enderror" value="{{ old('language', $course->language) }}" placeholder="e.g. English" maxlength="100">
                            @error('language')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="instructor_id" class="form-label">Instructor</label>
                            <select name="instructor_id" id="instructor_id" class="form-select @error('instructor_id') is-invalid @enderror">
                                <option value="">— No instructor —</option>
                                @foreach($instructors as $instructor)
                                    <option value="{{ $instructor->id }}" {{ (int) old('instructor_id', $course->instructor_id) === $instructor->id ? 'selected' : '' }}>{{ $instructor->name }}</option>
                                @endforeach
                            </select>
                            @error('instructor_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="form-check">
                            <input type="checkbox" name="certificate" id="certificate" class="form-check-input" value="1" {{ old('certificate', $course->certificate) ? 'checked' : '' }}>
                            <label for="certificate" class="form-check-label">Certificate offered</label>
                        </div>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Update course</button>
                        <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
