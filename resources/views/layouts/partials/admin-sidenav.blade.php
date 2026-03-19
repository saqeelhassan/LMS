<!-- Sidebar START -->
<nav class="navbar sidebar sidebar-light navbar-expand-xl navbar-light">

	<!-- Navbar brand for xl START -->
	<div class="d-flex align-items-center">
		<a class="navbar-brand" href="{{ route('admin.dashboard') }}">
			<img class="navbar-brand-item" src="{{ asset('images/logo.png') }}" alt="LMS">
		</a>
	</div>
	<!-- Navbar brand for xl END -->

	<div class="offcanvas offcanvas-start flex-row custom-scrollbar h-100" data-bs-backdrop="true" tabindex="-1" id="offcanvasSidebar">
		<div class="offcanvas-body sidebar-content d-flex flex-column">

			<!-- Sidebar menu START -->
			<ul class="navbar-nav flex-column" id="navbar-sidebar">

				@if(auth()->user()->role?->name === 'SuperAdmin')
				<!-- Super Admin: Full Control Panel -->
				<li class="nav-item">
					<a href="{{ route('super-admin.dashboard') }}" class="nav-link {{ Request::is('super-admin*') ? 'active' : '' }} text-primary fw-bold">
						<i class="bi bi-shield-lock-fill fa-fw me-2"></i>Super Admin Panel
					</a>
				</li>
				<li class="nav-item"><hr class="dropdown-divider my-2"></li>
				@endif

				<!-- Menu item 1 -->
				<li class="nav-item"><a href="{{ route('admin.dashboard') }}" class="nav-link sidebar-dashboard-link {{ Request::is('admin') && !Request::is('admin/courses*') && !Request::is('admin/registrations*') ? 'active' : '' }}"><i class="bi bi-house fa-fw me-2"></i>Dashboard</a></li>

				@if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->role?->name === 'Staff' || auth()->user()->hasAdminPermission('courses.manage'))
				<!-- Menu item 2 Courses (same as super admin) -->
				<li class="nav-item">
					<a class="nav-link" data-bs-toggle="collapse" href="#collapsepage" role="button" aria-expanded="false" aria-controls="collapsepage">
						<i class="bi bi-basket fa-fw me-2"></i>Courses
					</a>
					<ul class="nav collapse flex-column" id="collapsepage" data-bs-parent="#navbar-sidebar">
						<li class="nav-item"><a class="nav-link {{ Request::is('admin/courses') && !Request::is('admin/courses/category') && !Request::is('admin/courses/create') && !Request::is('admin/courses/*') ? 'active' : '' }}" href="{{ route('admin.courses.index') }}">All Courses</a></li>
						@if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->role?->name === 'Staff' || auth()->user()->hasAdminPermission('courses.create'))
						<li class="nav-item"><a class="nav-link {{ Request::is('admin/courses/create') ? 'active' : '' }}" href="{{ route('admin.courses.create') }}">Add course</a></li>
						@endif
					</ul>
				</li>
				@endif

				@if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->role?->name === 'Staff' || auth()->user()->hasAdminPermission('enrollments.view'))
				<li class="nav-item">
					<a href="{{ route('admin.enrollments.index') }}" class="nav-link {{ Request::is('admin/enrollments*') ? 'active' : '' }}">
						<i class="bi bi-journal-check fa-fw me-2"></i>Enrollments
					</a>
				</li>
				@endif

				@if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->role?->name === 'Staff' || auth()->user()->hasAdminPermission('registrations.approve'))
				<!-- Pending registrations -->
				<li class="nav-item">
					<a href="{{ route('admin.registrations.index') }}" class="nav-link {{ Request::is('admin/registrations*') ? 'active' : '' }}">
						<i class="bi bi-person-check fa-fw me-2"></i>Pending registrations
					</a>
				</li>
				@endif

				@if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->role?->name === 'Staff' || auth()->user()->hasAdminPermission('batches.manage'))
				<!-- Batches -->
				<li class="nav-item">
					<a class="nav-link" data-bs-toggle="collapse" href="#collapseBatches" role="button" aria-expanded="false" aria-controls="collapseBatches">
						<i class="bi bi-calendar-week fa-fw me-2"></i>Batches
					</a>
					<ul class="nav collapse flex-column" id="collapseBatches" data-bs-parent="#navbar-sidebar">
						<li class="nav-item"><a class="nav-link {{ Request::is('admin/batches') && !Request::is('admin/batches/create') && !Request::is('admin/batches/*/edit') && !Request::is('admin/batches/*/timetable') ? 'active' : '' }}" href="{{ route('admin.batches.index') }}">All Batches</a></li>
						<li class="nav-item"><a class="nav-link {{ Request::is('admin/batches/create') ? 'active' : '' }}" href="{{ route('admin.batches.create') }}">Add Batch</a></li>
						<li class="nav-item"><a class="nav-link {{ Request::is('admin/batch-management*') ? 'active' : '' }}" href="{{ route('admin.batch-management.index') }}">Batch Management Console</a></li>
						<li class="nav-item"><a class="nav-link {{ Request::is('admin/attendance*') ? 'active' : '' }}" href="{{ route('admin.attendance.index') }}">Attendance & Payroll</a></li>
					</ul>
				</li>
				@endif

				@if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->role?->name === 'Staff' || auth()->user()->hasAdminPermission('fees.manage'))
				<!-- Fee & Finance -->
				<li class="nav-item">
					<a class="nav-link" data-bs-toggle="collapse" href="#collapseFees" role="button" aria-expanded="false" aria-controls="collapseFees">
						<i class="bi bi-currency-dollar fa-fw me-2"></i>Fee & Finance
					</a>
					<ul class="nav collapse flex-column" id="collapseFees" data-bs-parent="#navbar-sidebar">
						<li class="nav-item">
							<a class="nav-link {{ Request::is('admin/fee-management') && !Request::is('admin/fee-management/ledger') ? 'active' : '' }}" href="{{ route('admin.fee-management.index') }}">
								Fee Management
								@php $pendingPayments = \App\Models\Payment::where('status', 'pending_approval')->count(); @endphp
								@if($pendingPayments > 0)<span class="badge bg-warning text-dark ms-1">{{ $pendingPayments }}</span>@endif
							</a>
						</li>
						<li class="nav-item"><a class="nav-link {{ Request::is('admin/fee-management/ledger') ? 'active' : '' }}" href="{{ route('admin.fee-management.ledger') }}">Student Ledger</a></li>
						<li class="nav-item"><a class="nav-link {{ Request::is('admin/invoices*') ? 'active' : '' }}" href="{{ route('admin.invoices.index') }}">Invoices</a></li>
						<li class="nav-item"><a class="nav-link {{ Request::is('admin/defaulters*') ? 'active' : '' }}" href="{{ route('admin.defaulters.index') }}">Defaulter List</a></li>
					</ul>
				</li>
				@endif

				@if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->role?->name === 'Staff' || auth()->user()->hasAdminPermission('batches.manage'))
				<!-- Pay Management -->
				<li class="nav-item">
					<a href="{{ route('admin.attendance.index') }}" class="nav-link {{ Request::is('admin/attendance*') ? 'active' : '' }}">
						<i class="bi bi-cash-stack fa-fw me-2"></i>Pay Management
					</a>
				</li>
				@endif

				@if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->role?->name === 'Staff' || auth()->user()->hasAdminPermission('inquiries.manage'))
				<!-- Inquiries -->
				<li class="nav-item">
					<a href="{{ route('admin.inquiries.index') }}" class="nav-link {{ Request::is('admin/inquiries*') ? 'active' : '' }}">
						<i class="bi bi-telephone-inbound fa-fw me-2"></i>Inquiries
					</a>
				</li>
				@endif

				@if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->role?->name === 'Staff' || auth()->user()->hasAdminPermission('notifications.manage'))
				<!-- Notification Center -->
				<li class="nav-item">
					<a href="{{ route('admin.broadcasts.index') }}" class="nav-link {{ Request::is('admin/broadcasts*') ? 'active' : '' }}">
						<i class="bi bi-megaphone fa-fw me-2"></i>Broadcasts
					</a>
				</li>
				@endif

				@if(auth()->user()->role?->name === 'SuperAdmin' || auth()->user()->role?->name === 'Admin' || auth()->user()->role?->name === 'Staff' || auth()->user()->hasAdminPermission('inquiries.manage'))
				<!-- Website Operations -->
				<li class="nav-item">
					<a class="nav-link" data-bs-toggle="collapse" href="#collapseWebsiteOps" role="button" aria-expanded="false" aria-controls="collapseWebsiteOps">
						<i class="bi bi-globe2 fa-fw me-2"></i>Website Operations
					</a>
					<ul class="nav collapse flex-column" id="collapseWebsiteOps" data-bs-parent="#navbar-sidebar">
						<li class="nav-item"><a class="nav-link {{ Request::is('admin/blogs*') ? 'active' : '' }}" href="{{ route('admin.blogs.index') }}">Blogs</a></li>
						<li class="nav-item"><a class="nav-link {{ Request::is('admin/contact-messages*') ? 'active' : '' }}" href="{{ route('admin.contact-messages.index') }}">Contact Messages</a></li>
						<li class="nav-item"><a class="nav-link {{ Request::is('admin/career-applications*') ? 'active' : '' }}" href="{{ route('admin.career-applications.index') }}">Career Applications</a></li>
					</ul>
				</li>
				@endif

			</ul>
			<!-- Sidebar menu end -->

			<!-- Sidebar footer START -->
			<div class="px-3 mt-auto pt-3">
				<div class="d-flex align-items-center justify-content-between text-primary-hover">
					<a class="h5 mb-0 text-body" href="{{ route('admin.dashboard') }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Dashboard">
						<i class="bi bi-gear-fill"></i>
					</a>
					<a class="h5 mb-0 text-body" href="{{ route('index' ) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Home">
						<i class="bi bi-globe"></i>
					</a>
					<form method="post" action="{{ route('auth.logout') }}" class="d-inline">@csrf<button type="submit" class="btn btn-link p-0 h5 mb-0 text-body border-0" data-bs-toggle="tooltip" data-bs-placement="top" title="Sign out"><i class="bi bi-power"></i></button></form>
				</div>
			</div>
			<!-- Sidebar footer END -->

		</div>
	</div>
</nav>
<!-- Sidebar END -->