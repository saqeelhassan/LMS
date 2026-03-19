@extends('layouts.admin')

@section('content')
<div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Contact messages</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0);">Contact messages</a></li>
        </ol>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success mb-3 rounded">{{ session('success') }}</div>
@endif

<div class="row">
    <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Contact form messages</h5>
            </div>
            <div class="card-body">
                <p class="text-body mb-4">Messages sent from the website contact form. You can delete them here.</p>
                <div class="table-responsive">
                    <table class="table header-border table-hover verticle-middle">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Message</th>
                                <th scope="col">Date</th>
                                <th scope="col" class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($messages as $msg)
                                <tr>
                                    <th>{{ $loop->iteration }}</th>
                                    <td>{{ $msg->name }}</td>
                                    <td><a href="mailto:{{ $msg->email }}">{{ $msg->email }}</a></td>
                                    <td>{{ $msg->phone ?? '—' }}</td>
                                    <td>{{ Str::limit($msg->message, 60) }}</td>
                                    <td>{{ $msg->created_at->format('M d, Y H:i') }}</td>
                                    <td class="text-end">
                                        <form method="post" action="{{ route('admin.contact-messages.destroy', $msg) }}" class="d-inline" onsubmit="return confirm('Delete this message?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="text-center text-muted py-4">No contact messages yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($messages->hasPages())
                    <div class="d-flex justify-content-center mt-3">{{ $messages->links() }}</div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
