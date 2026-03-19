{{-- Student header (same UI as super-admin: search, theme, notifications, profile) --}}
@php
    $notifications = auth()->user()->unreadNotifications()->take(10)->get()->map(fn ($n) => [
        'title' => $n->data['title'] ?? 'Notification',
        'message' => $n->data['message'] ?? '',
        'url' => $n->data['reapply_url'] ?? route('student.courses'),
    ])->toArray();
@endphp
<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    <div class="search_bar dropdown">
                        <span class="search_icon p-3 c-pointer" data-bs-toggle="dropdown"><i class="mdi mdi-magnify"></i></span>
                        <div class="dropdown-menu p-0 m-0">
                            <form><input class="form-control" type="search" placeholder="Search" aria-label="Search"></form>
                        </div>
                    </div>
                </div>
                <ul class="navbar-nav header-right">
                    <li class="nav-item dropdown">
                        <a class="nav-link bell dlab-theme-mode p-0" href="javascript:void(0);"><i id="icon-light" class="fas fa-sun"></i><i id="icon-dark" class="fas fa-moon"></i></a>
                    </li>
                    <li class="nav-item dropdown notification_dropdown">
                        <a class="nav-link bell ai-icon" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-bell"></i>
                            @if(count($notifications) > 0)
                                <span class="badge badge-sm badge-danger rounded-circle pulse-css">{{ count($notifications) > 99 ? '99+' : count($notifications) }}</span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <ul class="list-unstyled py-2">
                                @forelse($notifications as $notif)
                                    <li class="media dropdown-item align-items-center gap-3">
                                        <span class="success"><i class="ti-user"></i></span>
                                        <div class="media-body">
                                            <a href="{{ $notif['url'] ?? '#' }}"><p class="mb-0"><strong>{{ $notif['title'] }}</strong> {{ $notif['message'] }}</p></a>
                                        </div>
                                    </li>
                                @empty
                                    <li class="dropdown-item text-muted">No new notifications</li>
                                @endforelse
                            </ul>
                            @if(count($notifications) > 0)
                                <a class="all-notification d-block text-center py-2" href="{{ route('student.courses') }}">See all <i class="ti-arrow-right"></i></a>
                            @endif
                        </div>
                    </li>
                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                            @if(auth()->user()->avatar_url)
                                <img src="{{ auth()->user()->avatar_url }}" width="40" height="40" class="rounded-circle" alt=""/>
                            @else
                                <span class="rounded-circle bg-primary text-white d-inline-flex align-items-center justify-content-center" style="width:40px;height:40px;font-size:1rem;">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</span>
                            @endif
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="{{ route('account.profile.edit') }}" class="dropdown-item ai-icon"><i class="fas fa-user me-2"></i><span>Profile</span></a>
                            <a href="{{ route('account.settings') }}" class="dropdown-item ai-icon"><i class="fas fa-cog me-2"></i><span>Settings</span></a>
                            <div class="dropdown-divider"></div>
                            <form method="post" action="{{ route('auth.logout') }}">@csrf<button type="submit" class="dropdown-item ai-icon border-0 bg-transparent w-100 text-start"><i class="fas fa-sign-out-alt me-2"></i><span>Logout</span></button></form>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
