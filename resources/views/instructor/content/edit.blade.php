@extends('layouts.account', ['account' => 'instructor'])

@section('content')
<div class="col-xl-9">
    <div class="mb-4">
        <a href="{{ route('instructor.content.index', $course) }}" class="text-body small d-block mb-1"><i class="bi bi-arrow-left me-1"></i>Back to content</a>
        <h1 class="h3 mb-1">Edit content</h1>
    </div>

    <div class="card border rounded-3">
        <div class="card-body p-4">
            @if($errors->any())
                <div class="alert alert-danger mb-4"><ul class="mb-0 list-unstyled small">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif
            <form method="post" action="{{ route('instructor.content.update', [$course, $content]) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="title" class="form-label">Title *</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $content->title) }}" required maxlength="255">
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label">Type *</label>
                    <select name="type" id="type" class="form-select" required>
                        <option value="video" {{ old('type', $content->type) === 'video' ? 'selected' : '' }}>Video</option>
                        <option value="pdf" {{ old('type', $content->type) === 'pdf' ? 'selected' : '' }}>PDF Notes</option>
                        <option value="code" {{ old('type', $content->type) === 'code' ? 'selected' : '' }}>Source Code</option>
                    </select>
                </div>
                <div class="mb-3" id="url-group">
                    <label for="url" class="form-label">URL (YouTube, Vimeo, or external link)</label>
                    <input type="url" name="url" id="url" class="form-control" value="{{ old('url', $content->url) }}" placeholder="https://...">
                </div>
                <div class="mb-4" id="file-group">
                    <label for="file" class="form-label">Replace file (optional)</label>
                    <input type="file" name="file" id="file" class="form-control" accept=".pdf,.zip,.txt,.py,.js,.html,.css,.java">
                    @if($content->file_path)<small class="text-muted">Current: {{ $content->file_name ?? 'File' }}</small>@endif
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('instructor.content.index', $course) }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
