@extends('layouts.super-admin')

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <a href="{{ route('super-admin.branches.index') }}" class="text-body small d-block mb-1"><i class="bi bi-arrow-left me-1"></i>Back to branches</a>
        <h1 class="h3 mb-2 mb-sm-0">Edit Branch</h1>
    </div>
</div>

<div class="card shadow">
    <div class="card-body p-4">
        <form method="post" action="{{ route('super-admin.branches.update', $branch) }}">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">Name *</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $branch->name) }}" required maxlength="255">
                @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="code" class="form-label">Code (optional)</label>
                <input type="text" name="code" id="code" class="form-control" value="{{ old('code', $branch->code) }}" maxlength="50">
                @error('code')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <textarea name="address" id="address" class="form-control" rows="2" maxlength="500">{{ old('address', $branch->address) }}</textarea>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $branch->phone) }}" maxlength="50">
            </div>
            <div class="mb-4">
                <div class="form-check">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active', $branch->is_active) ? 'checked' : '' }}>
                    <label for="is_active" class="form-check-label">Active</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update Branch</button>
            <a href="{{ route('super-admin.branches.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
