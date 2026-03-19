@extends('layouts.account', ['account' => 'instructor'])

@section('content')
<div class="col-xl-9">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('instructor.manage-course') }}" class="text-body small d-block mb-1">Back to courses</a>
            <h1 class="h3 mb-1">Content: {{ $course->name }}</h1>
            <p class="mb-0 text-body">Videos, PDFs, source code.</p>
        </div>
        <div class="d-flex gap-2">
            @if(in_array($course->publication_status ?? 'approved', ['draft', 'rejected']))
                <form method="post" action="{{ route('instructor.content.submit-for-approval', $course) }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-warning">Submit for Approval</button>
                </form>
            @endif
            <a href="{{ route('instructor.content.create', $course) }}" class="btn btn-primary">Add content</a>
        </div>
    </div>
    @if(($course->publication_status ?? 'approved') === 'pending_approval')
        <div class="alert alert-info mb-4">This course outline is pending Super Admin approval. It will appear on the website after approval.</div>
    @elseif(($course->publication_status ?? 'approved') === 'rejected')
        <div class="alert alert-warning mb-4">This course was rejected. You may resubmit after making changes.</div>
    @endif
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <div class="card border rounded-3">
        <div class="card-body">
            <table class="table table-hover align-middle mb-0">
                <thead><tr><th>Title</th><th>Type</th><th>Link/File</th><th>Actions</th></tr></thead>
                <tbody>
                    @forelse($contents as $c)
                    <tr>
                        <td>{{ $c->title }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst($c->type) }}</span></td>
                        <td>
                            @if($c->url)<a href="{{ $c->url }}" target="_blank">URL</a>
                            @elseif($c->file_path)<a href="{{ asset('storage/' . $c->file_path) }}" target="_blank">{{ $c->file_name ?? 'File' }}</a>
                            @else -
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('instructor.content.edit', [$course, $c]) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form method="post" action="{{ route('instructor.content.destroy', [$course, $c]) }}" class="d-inline" onsubmit="return confirm('Delete?');">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button></form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-4">No content. <a href="{{ route('instructor.content.create', $course) }}">Add content</a>.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
