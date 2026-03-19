@extends('layouts.admin')

@section('content')
<div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Broadcasts</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0);">Broadcasts</a></li>
        </ol>
        <a href="{{ route('admin.broadcasts.create') }}" class="btn btn-sm btn-primary ms-3">Send broadcast</a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success mb-3 rounded">{{ session('success') }}</div>
@endif

<div class="row">
    <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Broadcast list</h5>
            </div>
            <div class="card-body">
                <p class="text-body mb-4">SMS/WhatsApp broadcasts. API integration is required for actual delivery; currently broadcasts are stored only.</p>
                <div class="table-responsive">
                    <table class="table header-border table-hover verticle-middle">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Message</th>
                                <th scope="col">Channel</th>
                                <th scope="col">Target</th>
                                <th scope="col">Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($broadcasts as $b)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $b->title ?? '—' }}</td>
                                    <td class="text-truncate" style="max-width:200px">{{ Str::limit($b->message, 50) }}</td>
                                    <td><span class="badge badge-rounded badge-secondary">{{ ucfirst($b->channel) }}</span></td>
                                    <td>{{ ucfirst(str_replace('_', ' ', $b->target)) }}</td>
                                    <td>{{ $b->created_at?->format('M j, Y H:i') ?? '—' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="text-center text-muted py-4">No broadcasts yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($broadcasts->hasPages())
                    <div class="d-flex justify-content-center mt-3">{{ $broadcasts->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
