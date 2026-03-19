@extends('layouts.admin')

@section('content')
<div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Blogs</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0);">Blogs</a></li>
        </ol>
        <a href="{{ route('admin.blogs.create') }}" class="btn btn-sm btn-primary ms-3">Add blog</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success mb-3 rounded">{{ session('success') }}</div>
@endif

<div class="row">
    <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Blog list</h5>
            </div>
            <div class="card-body">
                <form method="get" action="{{ route('admin.blogs.index') }}" class="row g-2 align-items-end mb-4">
                    <div class="col-md-4">
                        <label for="status" class="form-label small mb-0">Filter by status</label>
                        <select name="status" id="status" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">All statuses</option>
                            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table header-border table-hover verticle-middle">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Author</th>
                                <th scope="col">Status</th>
                                <th scope="col">Updated</th>
                                <th scope="col" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($blogs as $blog)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>
                                        <strong>{{ $blog->title }}</strong>
                                        <br><small class="text-muted">{{ $blog->slug }}</small>
                                    </td>
                                    <td>{{ $blog->author->name ?? '—' }}</td>
                                    <td>
                                        @if($blog->status === 'published')
                                            <span class="badge badge-rounded badge-success">Published</span>
                                        @else
                                            <span class="badge badge-rounded badge-secondary">Draft</span>
                                        @endif
                                    </td>
                                    <td>{{ $blog->updated_at->format('M d, Y') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form method="post" action="{{ route('admin.blogs.destroy', $blog) }}" class="d-inline" onsubmit="return confirm('Delete this blog?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted py-4">No blogs yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($blogs->hasPages())
                    <div class="d-flex justify-content-center mt-3">{{ $blogs->withQueryString()->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
