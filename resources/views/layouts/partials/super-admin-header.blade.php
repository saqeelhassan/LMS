<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand w-100">
            <div class="collapse navbar-collapse align-items-center w-100" style="display: flex !important;">
                <div class="header-left d-flex align-items-center">
                    <button type="button" class="btn btn-link text-body d-lg-none p-2 me-2" id="icnavToggle" aria-label="Toggle menu">
                        <i class="bi bi-list fs-4"></i>
                    </button>
                    <a href="{{ route('super-admin.dashboard') }}" class="brand-logo d-flex align-items-center text-decoration-none" aria-label="Digital Sindh">
                        <img class="navbar-brand-item" src="{{ asset('images/logo.png') }}" alt="Digital Sindh" style="max-height: 36px; width: auto; object-fit: contain;">
                    </a>
                </div>
                <div class="header-center d-flex justify-content-center align-items-center">
                    <h1 class="main-title h4 mb-0 fw-semibold">{{ $pageTitle ?? 'Executive Dashboard' }}</h1>
                </div>
                <ul class="navbar-nav header-right d-flex align-items-center gap-1 ms-auto">
                    <li class="nav-item dropdown notification_dropdown ms-lg-2">
                        <div class="dropdown">
                            <a class="nav-link" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Notifications">
                                <i class="bi bi-bell"></i>
                            </a>
                            @if(isset($notifications) && count($notifications) > 0)
                                <span class="badge badge-sm badge-danger rounded-circle position-absolute top-0 start-100 translate-middle">!</span>
                            @endif
                            <div class="dropdown-menu dropdown-menu-end py-0 shadow border-0">
                                <div class="card bg-transparent border-0">
                                    <div class="card-header bg-transparent border-bottom py-3">
                                        <h6 class="mb-0">Notifications
                                            @if(isset($notifications) && count($notifications) > 0)
                                                <span class="badge bg-danger ms-2">{{ count($notifications) }}</span>
                                            @endif
                                        </h6>
                                    </div>
                                    <div class="card-body p-0">
                                        @forelse(($notifications ?? []) as $notif)
                                            <a href="{{ $notif['url'] ?? '#' }}" class="dropdown-item border-bottom py-3">
                                                <h6 class="mb-0 small">{{ $notif['title'] ?? 'Notification' }}</h6>
                                                <small class="text-body">{{ $notif['message'] ?? '' }}</small>
                                            </a>
                                        @empty
                                            <div class="p-4 text-center text-body small">No new notifications</div>
                                        @endforelse
                                    </div>
                                    @if(isset($notifications) && count($notifications) > 0)
                                        <div class="card-footer bg-transparent border-0 py-2 text-center">
                                            <a href="{{ route('super-admin.registrations.index') }}" class="small">View all</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item dropdown header-profile-dropdown ms-2 ms-md-3">
                        <a class="nav-link d-flex align-items-center gap-2 py-2 px-3 rounded" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" id="headerProfileDropdown">
                            <div class="profile-media flex-shrink-0">
                                @if(auth()->user()->avatar_url)
                                    <img src="{{ auth()->user()->avatar_url }}" alt="" class="rounded-circle" style="width:36px;height:36px;object-fit:cover;">
                                @else
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center text-uppercase fw-bold" style="width:36px;height:36px;font-size:0.9rem;">
                                        {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="text-start">
                                <span class="fw-semibold text-body">{{ auth()->user()->name }}</span>
                                <i class="bi bi-chevron-down ms-1 small text-muted"></i>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow py-2 header-profile-dropdown-menu" aria-labelledby="headerProfileDropdown">
                            <li>
                                <div class="py-2 d-flex px-3">
                                    @if(auth()->user()->avatar_url)
                                        <img src="{{ auth()->user()->avatar_url }}" class="rounded-circle me-2" alt="" style="width:40px;height:40px;object-fit:cover;">
                                    @else
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2 text-uppercase fw-bold" style="width:40px;height:40px;font-size:1rem;">{{ substr(auth()->user()->name ?? 'U', 0, 1) }}</div>
                                    @endif
                                    <div>
                                        <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                                        <small class="text-body">{{ auth()->user()->email }}</small>
                                    </div>
                                </div>
                            </li>
                            <li><hr class="dropdown-divider my-2"></li>
                            <li><a class="dropdown-item" href="{{ route('account.profile.edit') }}"><i class="bi bi-person me-2"></i>Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('account.settings') }}"><i class="bi bi-gear me-2"></i>Settings</a></li>
                            <li><hr class="dropdown-divider my-2"></li>
                            <li>
                                <form method="post" action="{{ route('auth.logout') }}" class="d-inline w-100">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger border-0 w-100 text-start bg-transparent"><i class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
    <div class="page-title header-breadcrumb">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('super-admin.dashboard') }}">Dashboard</a></li>
                @yield('breadcrumb')
            </ol>
        </nav>
    </div>
</div>
