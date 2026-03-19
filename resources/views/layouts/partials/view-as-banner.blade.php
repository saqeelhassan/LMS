@if(auth()->check() && auth()->user()->role?->name === 'SuperAdmin' && session('view_as_user_id'))
    @php $viewAsUser = \App\Models\User::with('userDetail')->find(session('view_as_user_id')); @endphp
    @if($viewAsUser)
        <div class="alert alert-warning alert-dismissible fade show mb-0 rounded-0 border-0 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2" role="alert">
            <span><strong>Viewing as:</strong> {{ $viewAsUser->name }} ({{ $viewAsUser->email }})</span>
            <a href="{{ route('super-admin.view-as.destroy') }}" class="btn btn-sm btn-outline-dark">Back to Super Admin</a>
        </div>
    @endif
@endif
