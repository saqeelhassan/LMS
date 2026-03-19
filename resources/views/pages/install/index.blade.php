@extends('layouts.base')

@section('content')
<main>
    <section class="p-0 d-flex align-items-center position-relative overflow-hidden">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg-6 d-md-flex align-items-center justify-content-center bg-primary bg-opacity-10 vh-lg-100">
                    <div class="p-4 text-center">
                        <a href="{{ url('/') }}" class="d-inline-block">
                            <img src="{{ asset('images/logo.png') }}" alt="DSIMT" class="img-fluid" style="max-height: 200px; width: auto;">
                        </a>
                        <p class="mt-4 mb-0 text-muted small">LMS Digi Sindh – Installation</p>
                    </div>
                </div>

                <div class="col-12 col-lg-6 m-auto">
                    <div class="row my-5">
                        <div class="col-sm-10 col-xl-8 m-auto">
                            <h1 class="fs-2">Install the application</h1>
                            <p class="lead mb-4">Configure the database and create the Super Admin account.</p>

                            @if($errors->any())
                                <div class="alert alert-danger mb-4">
                                    <ul class="mb-0 list-unstyled small">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="post" action="{{ route('install.store') }}" id="install-form">
                                @csrf

                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Database</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="db_connection" class="form-label">Connection</label>
                                            <select name="db_connection" id="db_connection" class="form-select">
                                                <option value="sqlite" {{ old('db_connection', $dbConnection) === 'sqlite' ? 'selected' : '' }}>SQLite</option>
                                                <option value="mysql" {{ old('db_connection', $dbConnection) === 'mysql' ? 'selected' : '' }}>MySQL / MariaDB</option>
                                            </select>
                                        </div>
                                        <div id="mysql-fields" class="{{ old('db_connection', $dbConnection) === 'sqlite' ? 'd-none' : '' }}">
                                            <div class="mb-3">
                                                <label for="db_host" class="form-label">Host</label>
                                                <input type="text" name="db_host" id="db_host" class="form-control" value="{{ old('db_host', $dbHost) }}" placeholder="127.0.0.1">
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="db_port" class="form-label">Port</label>
                                                    <input type="text" name="db_port" id="db_port" class="form-control" value="{{ old('db_port', $dbPort) }}" placeholder="3306">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="db_database" class="form-label">Database name</label>
                                                    <input type="text" name="db_database" id="db_database" class="form-control" value="{{ old('db_database', $dbDatabase) }}" placeholder="lms_digi_sindh">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="db_username" class="form-label">Username</label>
                                                <input type="text" name="db_username" id="db_username" class="form-control" value="{{ old('db_username', $dbUsername) }}" placeholder="root">
                                            </div>
                                            <div class="mb-3">
                                                <label for="db_password" class="form-label">Password</label>
                                                <input type="password" name="db_password" id="db_password" class="form-control" value="{{ old('db_password', $dbPassword) }}" placeholder="Leave blank if none">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Super Admin</h5>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-muted small mb-3">This account will have full access to the system.</p>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="admin_first_name" class="form-label">First name *</label>
                                                <input type="text" name="admin_first_name" id="admin_first_name" class="form-control" value="{{ old('admin_first_name') }}" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="admin_last_name" class="form-label">Last name *</label>
                                                <input type="text" name="admin_last_name" id="admin_last_name" class="form-control" value="{{ old('admin_last_name') }}" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="admin_email" class="form-label">Email *</label>
                                            <input type="email" name="admin_email" id="admin_email" class="form-control" value="{{ old('admin_email') }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="admin_password" class="form-label">Password *</label>
                                            <input type="password" name="admin_password" id="admin_password" class="form-control" required minlength="8">
                                            <div class="form-text">At least 8 characters.</div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="admin_password_confirmation" class="form-label">Confirm password *</label>
                                            <input type="password" name="admin_password_confirmation" id="admin_password_confirmation" class="form-control" required minlength="8">
                                        </div>
                                    </div>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg">Install</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
(function () {
    var conn = document.getElementById('db_connection');
    var mysqlFields = document.getElementById('mysql-fields');
    function toggle() {
        var isMysql = conn.value === 'mysql';
        mysqlFields.classList.toggle('d-none', !isMysql);
        document.getElementById('db_host').required = isMysql;
        document.getElementById('db_database').required = isMysql;
    }
    conn.addEventListener('change', toggle);
    toggle();
})();
</script>
@endsection
