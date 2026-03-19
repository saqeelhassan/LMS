@extends('layouts.account', ['account' => 'instructor'])

@section('content')
<div class="col-xl-9">
    <div class="mb-4">
        <a href="{{ route('instructor.content.index', $course) }}" class="text-body small d-block mb-1"><i class="bi bi-arrow-left me-1"></i>Back to content</a>
        <h1 class="h3 mb-1">Add content</h1>
        <p class="mb-0 text-body">Video, PDF, or source code.</p>
    </div>

    <div class="card border rounded-3">
        <div class="card-body p-4">
            @if($errors->any())
                <div class="alert alert-danger mb-4"><ul class="mb-0 list-unstyled small">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif
            <form method="post" action="{{ route('instructor.content.store', $course) }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title *</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required maxlength="255">
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label">Type *</label>
                    <select name="type" id="type" class="form-select" required>
                        <option value="video" {{ old('type') === 'video' ? 'selected' : '' }}>Video</option>
                        <option value="pdf" {{ old('type') === 'pdf' ? 'selected' : '' }}>PDF Notes</option>
                        <option value="code" {{ old('type') === 'code' ? 'selected' : '' }}>Source Code</option>
                    </select>
                </div>
                <div class="mb-3" id="url-group">
                    <label for="url" class="form-label">URL (YouTube, Vimeo, or external link)</label>
                    <input type="url" name="url" id="url" class="form-control" value="{{ old('url') }}" placeholder="https://...">
                </div>
                <div class="mb-4" id="file-group">
                    <label for="file" class="form-label">Or upload file</label>
                    <input type="file" name="file" id="file" class="form-control" accept=".pdf,.zip,.txt,.py,.js,.html,.css,.java">
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Add content</button>
                    <a href="{{ route('instructor.content.index', $course) }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
