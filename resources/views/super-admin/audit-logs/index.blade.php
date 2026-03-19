@extends('layouts.super-admin')

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <h1 class="h3 mb-2 mb-sm-0">Audit Logs</h1>
        <p class="mb-0 text-body">Track Admin and Instructor actions.</p>
    </div>
</div>

<div class="card shadow">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Time</th>
                        <th>User</th>
                        <th>Action</th>
                        <th>Details</th>
                        <th>IP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td class="text-nowrap">{{ $log->created_at->format('M d, Y H:i') }}</td>
                        <td>{{ $log->user?->name ?? $log->user?->email ?? '—' }}</td>
                        <td><span class="badge bg-secondary">{{ $log->action }}</span></td>
                        <td>{{ Str::limit($log->details ?? '—', 80) }}</td>
                        <td class="small text-body">{{ $log->ip_address ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-4 text-body">No audit logs yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($logs->hasPages())
        <div class="card-footer">{{ $logs->links() }}</div>
    @endif
</div>
@endsection
