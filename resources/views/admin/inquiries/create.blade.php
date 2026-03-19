@extends('layouts.admin')

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <h1 class="h3 mb-2 mb-sm-0">Add inquiry</h1>
        <p class="mb-0 text-body">Record a walk-in or lead inquiry.</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-body p-4">
                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0 list-unstyled small">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif
                <form method="post" action="{{ route('admin.inquiries.store') }}">
                    @csrf
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Name *</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') }}" required maxlength="255">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}" maxlength="50">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}" maxlength="255">
                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="course_interest" class="form-label">Course interest</label>
                            <input type="text" name="course_interest" id="course_interest" class="form-control"
                                value="{{ old('course_interest') }}" list="courses-list" maxlength="255">
                            <datalist id="courses-list">
                                @foreach($courses ?? [] as $c)
                                    <option value="{{ $c }}">
                                @endforeach
                            </datalist>
                        </div>
                        <div class="col-md-6">
                            <label for="branch_id" class="form-label">Branch</label>
                            <select name="branch_id" id="branch_id" class="form-select">
                                <option value="">— No branch —</option>
                                @foreach($branches as $b)
                                    <option value="{{ $b->id }}" {{ (int) old('branch_id') === $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="assigned_to" class="form-label">Assigned to</label>
                        <select name="assigned_to" id="assigned_to" class="form-select">
                            <option value="">— No one —</option>
                            @foreach($staff ?? [] as $s)
                                <option value="{{ $s->id }}" {{ (int) old('assigned_to') === $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea name="notes" id="notes" class="form-control" rows="3" maxlength="1000">{{ old('notes') }}</textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Add inquiry</button>
                        <a href="{{ route('admin.inquiries.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
