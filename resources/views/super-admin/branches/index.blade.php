@extends('layouts.super-admin')

@section('content')
<div class="row mb-3">
    <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div>
            <h1 class="h3 mb-2 mb-sm-0">Branch Management</h1>
            <p class="mb-0 text-body">Add/remove physical campus locations.</p>
        </div>
        <a href="{{ route('super-admin.branches.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg me-1"></i>Add Branch</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Code</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($branches as $b)
                    <tr>
                        <td>{{ $b->name }}</td>
                        <td>{{ $b->code ?? '-' }}</td>
                        <td>{{ Str::limit($b->address ?? '-', 40) }}</td>
                        <td>{{ $b->phone ?? '-' }}</td>
                        <td><span class="badge bg-{{ $b->is_active ? 'success' : 'secondary' }}">{{ $b->is_active ? 'Active' : 'Inactive' }}</span></td>
                        <td class="text-end">
                            <a href="{{ route('super-admin.branches.edit', $b) }}" class="btn btn-sm btn-outline-primary me-1">Edit</a>
                            <form method="post" action="{{ route('super-admin.branches.destroy', $b) }}" class="d-inline" onsubmit="return confirm('Remove this branch?');">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger">Remove</button></form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-body">No branches yet. <a href="{{ route('super-admin.branches.create') }}">Add one</a>.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($branches->hasPages())
        <div class="card-footer">{{ $branches->links() }}</div>
    @endif
</div>
@endsection
