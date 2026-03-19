@php $layout = $layout ?? 'layouts.admin'; @endphp
@extends($layout)

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <h1 class="h3 mb-2 mb-sm-0">Help</h1>
        <p class="mb-0 text-body">Frequently asked questions and support.</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-body p-4">
                <h5 class="mb-3">Getting started</h5>
                <p class="text-body">Use the sidebar to navigate: Dashboard, Users, Courses, and View as (Admin, Instructor, Student) for testing different roles.</p>

                <h5 class="mb-3 mt-4">Edit Profile</h5>
                <p class="text-body">Update your name and mobile from the profile dropdown → Edit Profile.</p>

                <h5 class="mb-3 mt-4">Account Settings</h5>
                <p class="text-body">Change your password from the profile dropdown → Account Settings.</p>

                <h5 class="mb-3 mt-4">Need more help?</h5>
                <p class="text-body mb-0">Contact your system administrator or the platform support team for further assistance.</p>
            </div>
        </div>
    </div>
</div>
@endsection
