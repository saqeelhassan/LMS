@extends('layouts.admin')

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <h1 class="h3 mb-2 mb-sm-0">Convert inquiry</h1>
        <p class="mb-0 text-body">Link this inquiry to an existing student.</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-body p-4">
                <p class="mb-4"><strong>{{ $inquiry->name }}</strong> ({{ $inquiry->email ?? $inquiry->phone ?? '—' }}) — {{ $inquiry->course_interest ?? '—' }}</p>
                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0 list-unstyled small">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif
                <form method="post" action="{{ route('admin.inquiries.convert.store', $inquiry) }}">
                    @csrf
                    <div class="mb-4">
                        <label for="user_id" class="form-label">Select student *</label>
                        <select name="user_id" id="user_id" class="form-select @error('user_id') is-invalid @enderror" required>
                            <option value="">— Select student —</option>
                            @foreach($students as $s)
                                <option value="{{ $s->id }}" {{ (int) old('user_id') === $s->id ? 'selected' : '' }}>{{ $s->name }} ({{ $s->email }})</option>
                            @endforeach
                        </select>
                        @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        @if($students->isEmpty())
                            <p class="small text-muted mt-1 mb-0">No students found. Create a student account first.</p>
                        @endif
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">Convert to student</button>
                        <a href="{{ route('admin.inquiries.edit', $inquiry) }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
