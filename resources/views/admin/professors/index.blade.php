@extends('layouts.admin')

@section('content')
<div class="row mb-3">
    <div class="col-12 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <h4 class="card-title mb-0">All Professors</h4>
        <a href="{{ route('admin.professors.create') }}" class="btn btn-primary">+ Add new</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success mb-3">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover verticle-middle text-nowrap">
                <thead>
                    <tr>
                        <th>Profile</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Joined</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($professors as $p)
                    <tr>
                        <td>
                            @if($p->avatar_url)
                                <img class="rounded-circle" width="35" height="35" src="{{ $p->avatar_url }}" alt="" style="object-fit:cover;">
                            @else
                                <span class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center fw-bold" style="width:35px;height:35px;font-size:0.9rem;">{{ substr($p->name ?? $p->email, 0, 1) }}</span>
                            @endif
                        </td>
                        <td>{{ $p->name }}</td>
                        <td>{{ $p->userDetail?->mobile ?? '—' }}</td>
                        <td><a href="mailto:{{ $p->email }}"><strong>{{ $p->email }}</strong></a></td>
                        <td>{{ $p->created_at?->format('Y/m/d') ?? '—' }}</td>
                        <td>
                            <a href="{{ route('admin.professors.show', $p) }}" class="btn btn-xs sharp btn-info" title="Profile"><i class="fa fa-user"></i></a>
                            <a href="{{ route('admin.professors.edit', $p) }}" class="btn btn-xs sharp btn-primary" title="Edit"><i class="fa fa-pencil"></i></a>
                            <form action="{{ route('admin.professors.destroy', $p) }}" method="post" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this professor?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-xs sharp btn-danger" title="Delete"><i class="fa fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">No professors yet. <a href="{{ route('admin.professors.create') }}">Add one</a>.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($professors->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $professors->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
