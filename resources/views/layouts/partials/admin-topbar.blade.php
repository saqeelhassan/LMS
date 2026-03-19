<!-- Top bar START -->
<nav class="navbar top-bar navbar-light py-0 py-xl-3">
	<div class="container-fluid p-0">
		<div class="d-flex align-items-center w-100">

			<!-- Logo START -->
			<div class="d-flex align-items-center d-xl-none">
				<a class="navbar-brand" href="{{ route('super-admin.dashboard') }}">
					<img class="light-mode-item navbar-brand-item h-30px" src="{{ asset('images/logo.png') }}" alt="LMS">
					<img class="dark-mode-item navbar-brand-item h-30px" src="{{ asset('images/logo.png') }}" alt="LMS">
				</a>
			</div>
			<!-- Logo END -->

			<!-- Toggler for sidebar START -->
			<div class="navbar-expand-xl sidebar-offcanvas-menu">
				<button class="navbar-toggler me-auto" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSidebar" aria-controls="offcanvasSidebar" aria-expanded="false" aria-label="Toggle navigation" data-bs-auto-close="outside">
					<i class="bi bi-text-right fa-fw h2 lh-0 mb-0 rtl-flip" data-bs-target="#offcanvasMenu"> </i>
				</button>
			</div>
			<!-- Toggler for sidebar END -->

			<!-- Page title - centered -->
			@if(Request::is('super-admin*'))
			<div class="flex-grow-1 d-none d-sm-flex justify-content-center">
				<h1 class="h5 mb-0 text-black" style="font-size: calc(1.25rem + 5px);">Executive Dashboard</h1>
			</div>
			@elseif(Route::is('admin.dashboard'))
			<div class="flex-grow-1 d-none d-sm-flex justify-content-center">
				<h1 class="h5 mb-0 text-black" style="font-size: calc(1.25rem + 10px);">Admin Dashboard</h1>
			</div>
			@endif

			<!-- Top bar right START -->
			<div class="ms-auto">
				<ul class="navbar-nav flex-row align-items-center">

					<!-- Notification dropdown START -->
					<li class="nav-item ms-2 ms-md-3 dropdown">
						<a class="btn btn-light btn-round mb-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside">
							<i class="bi bi-bell fa-fw"></i>
						</a>
						@if(isset($notifications) && count($notifications) > 0)
							<span class="notif-badge animation-blink"></span>
						@endif
						<div class="dropdown-menu dropdown-animation dropdown-menu-end dropdown-menu-size-md p-0 shadow-lg border-0">
							<div class="card bg-transparent">
								<div class="card-header bg-transparent border-bottom py-4 d-flex justify-content-between align-items-center">
									<h6 class="m-0">Notifications
										@if(isset($notifications) && count($notifications) > 0)
											<span class="badge bg-danger bg-opacity-10 text-danger ms-2">{{ count($notifications) }}</span>
										@endif
									</h6>
								</div>
								<div class="card-body p-0">
									<ul class="list-group list-unstyled list-group-flush">
										@forelse($notifications ?? [] as $notif)
											<li>
												<a href="{{ $notif['url'] ?? '#' }}" class="list-group-item-action border-0 border-bottom d-flex p-3">
													<div class="me-3">
														<div class="avatar avatar-md rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center">
															@if(($notif['type'] ?? '') === 'pending_registration')
																<i class="bi bi-person-plus fa-fw"></i>
															@else
																<i class="bi bi-journal-plus fa-fw"></i>
															@endif
														</div>
													</div>
													<div class="flex-grow-1">
														<h6 class="mb-0">{{ $notif['title'] ?? 'Notification' }}</h6>
														<p class="text-body small m-0">{{ $notif['message'] ?? '' }}</p>
														@if(!empty($notif['time']))
															<small class="text-body">{{ $notif['time'] }}</small>
														@endif
													</div>
												</a>
											</li>
										@empty
											<li class="p-4 text-center text-body">No new notifications</li>
										@endforelse
									</ul>
								</div>
								@if(isset($notifications) && count($notifications) > 0)
									<div class="card-footer bg-transparent border-0 py-3 text-center">
										@if(auth()->user()?->role?->name === 'SuperAdmin')
											<a href="{{ route('super-admin.registrations.index') }}" class="stretched-link">View registrations</a>
										@elseif(auth()->user()?->hasAdminPermission('registrations.approve') ?? false)
											<a href="{{ route('admin.registrations.index') }}" class="stretched-link">View registrations</a>
										@else
											<a href="{{ route('courses.index') }}" class="stretched-link">View courses</a>
										@endif
									</div>
								@endif
							</div>
						</div>
					</li>
					<!-- Notification dropdown END -->

					<!-- Profile dropdown START -->
					<li class="nav-item ms-2 ms-md-3 dropdown">
						<!-- Avatar -->
						<a class="avatar avatar-sm p-0" href="#" id="profileDropdown" role="button" data-bs-auto-close="outside" data-bs-display="static" data-bs-toggle="dropdown" aria-expanded="false">
							@if(auth()->user()->avatar_url)
								<img class="avatar-img rounded-circle" src="{{ auth()->user()->avatar_url }}" alt="">
							@elseif(auth()->user()->userDetail ?? null)
								<div class="avatar-img rounded-circle bg-primary text-white d-flex align-items-center justify-content-center text-uppercase fw-bold" style="width:2.5rem;height:2.5rem;font-size:0.9rem;">{{ substr(auth()->user()->userDetail->first_name ?? '', 0, 1) }}{{ substr(auth()->user()->userDetail->last_name ?? '', 0, 1) }}</div>
							@else
								<div class="avatar-img rounded-circle bg-primary text-white d-flex align-items-center justify-content-center text-uppercase fw-bold" style="width:2.5rem;height:2.5rem;font-size:0.9rem;">{{ substr(auth()->user()->email ?? 'U', 0, 1) }}</div>
							@endif
						</a>

						<!-- Profile dropdown START -->
						<ul class="dropdown-menu dropdown-animation dropdown-menu-end shadow pt-3" aria-labelledby="profileDropdown">
							<!-- Profile info -->
							<li class="px-3">
								<div class="d-flex align-items-center">
									<!-- Avatar -->
									<div class="avatar me-3 mb-3">
										@if(auth()->user()->avatar_url)
											<img class="avatar-img rounded-circle shadow" src="{{ auth()->user()->avatar_url }}" alt="">
										@elseif(auth()->user()->userDetail ?? null)
											<div class="avatar-img rounded-circle shadow bg-primary text-white d-flex align-items-center justify-content-center text-uppercase fw-bold" style="width:3rem;height:3rem;font-size:1rem;">{{ substr(auth()->user()->userDetail->first_name ?? '', 0, 1) }}{{ substr(auth()->user()->userDetail->last_name ?? '', 0, 1) }}</div>
										@else
											<div class="avatar-img rounded-circle shadow bg-primary text-white d-flex align-items-center justify-content-center text-uppercase fw-bold" style="width:3rem;height:3rem;font-size:1rem;">{{ substr(auth()->user()->email ?? 'U', 0, 1) }}</div>
										@endif
									</div>
									<div>
										<span class="h6 mt-2 mt-sm-0 d-block">{{ auth()->user()->name }}</span>
										<p class="small m-0">{{ auth()->user()->email }}</p>
									</div>
								</div>
							</li>
							<li>
								<hr class="dropdown-divider">
							</li>
							<!-- Links -->
							<li><a class="dropdown-item" href="{{ route('account.profile.edit') }}"><i class="bi bi-person fa-fw me-2"></i>Edit Profile</a></li>
							<li><a class="dropdown-item" href="{{ route('account.settings') }}"><i class="bi bi-gear fa-fw me-2"></i>Account Settings</a></li>
							<li><a class="dropdown-item" href="{{ route('help') }}"><i class="bi bi-info-circle fa-fw me-2"></i>Help</a></li>
							<li>
								<form method="post" action="{{ route('auth.logout') }}" class="d-inline w-100">
									@csrf
									<button type="submit" class="dropdown-item bg-danger-soft-hover border-0 w-100 text-start"><i class="bi bi-power fa-fw me-2"></i>Sign Out</button>
								</form>
							</li>
							<li>
								<hr class="dropdown-divider">
							</li>

							<!-- Dark mode options START -->
							<li>
								<div class="bg-light dark-mode-switch theme-icon-active d-flex align-items-center p-1 rounded mt-2">
									<!-- <span>Mode:</span> -->
									<button type="button" class="btn btn-sm mb-0" data-bs-theme-value="light">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sun fa-fw mode-switch" viewBox="0 0 16 16">
											<path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6zm0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8zM8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0zm0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13zm8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5zM3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8zm10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0zm-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0zm9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707zM4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708z" />
											<use href="#"></use>
										</svg> Light
									</button>
									<button type="button" class="btn btn-sm mb-0" data-bs-theme-value="dark">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-moon-stars fa-fw mode-switch" viewBox="0 0 16 16">
											<path d="M6 .278a.768.768 0 0 1 .08.858 7.208 7.208 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277.527 0 1.04-.055 1.533-.16a.787.787 0 0 1 .81.316.733.733 0 0 1-.031.893A8.349 8.349 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.752.752 0 0 1 6 .278zM4.858 1.311A7.269 7.269 0 0 0 1.025 7.71c0 4.02 3.279 7.276 7.319 7.276a7.316 7.316 0 0 0 5.205-2.162c-.337.042-.68.063-1.029.063-4.61 0-8.343-3.714-8.343-8.29 0-1.167.242-2.278.681-3.286z" />
											<path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.734 1.734 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.734 1.734 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.734 1.734 0 0 0 1.097-1.097l.387-1.162zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.156 1.156 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.156 1.156 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732L13.863.1z" />
											<use href="#"></use>
										</svg> Dark
									</button>
									<button type="button" class="btn btn-sm mb-0 active" data-bs-theme-value="auto">
										<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-circle-half fa-fw mode-switch" viewBox="0 0 16 16">
											<path d="M8 15A7 7 0 1 0 8 1v14zm0 1A8 8 0 1 1 8 0a8 8 0 0 1 0 16z" />
											<use href="#"></use>
										</svg> Auto
									</button>
								</div>
							</li>
							<!-- Dark mode options END-->
						</ul>
						<!-- Profile dropdown END -->
					</li>
					<!-- Profile dropdown END -->
				</ul>
			</div>
			<!-- Top bar right END -->
		</div>
	</div>
</nav>
<!-- Top bar END -->