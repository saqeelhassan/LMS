@extends('layouts.admin')

@section('content')
<div class="row page-titles mx-0 mb-3">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>All Students</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('admin.students.index') }}">Students</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">All Students</a></li>
            </ol>
        </nav>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success mb-3">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
        <h4 class="card-title mb-0">All Students List</h4>
        <a href="{{ route('admin.students.create') }}" class="btn btn-primary">+ Add new</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover verticle-middle text-nowrap">
                <thead>
                    <tr>
                        <th>Profile</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Admission Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $s)
                    <tr>
                        <td>
                            @if($s->avatar_url)
                                <img class="rounded-circle" width="35" height="35" src="{{ $s->avatar_url }}" alt="" style="object-fit:cover;">
                            @else
                                <span class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center fw-bold" style="width:35px;height:35px;font-size:0.9rem;">{{ substr($s->name ?? $s->email, 0, 1) }}</span>
                            @endif
                        </td>
                        <td>{{ $s->name }}</td>
                        <td>{{ $s->userDetail?->mobile ?? '—' }}</td>
                        <td><a href="mailto:{{ $s->email }}"><strong>{{ $s->email }}</strong></a></td>
                        <td>{{ $s->created_at?->format('Y/m/d') ?? '—' }}</td>
                        <td>
                            <a href="{{ route('admin.students.show', $s) }}" class="btn btn-xs sharp btn-info" title="About"><i class="fa fa-user"></i></a>
                            <a href="{{ route('admin.students.edit', $s) }}" class="btn btn-xs sharp btn-primary" title="Edit"><i class="fa fa-pencil"></i></a>
                            <form action="{{ route('admin.students.destroy', $s) }}" method="post" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this student?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs sharp btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">No students yet. <a href="{{ route('admin.students.create') }}">Add one</a>.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($students->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $students->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
