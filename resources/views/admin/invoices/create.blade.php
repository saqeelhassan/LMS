@extends('layouts.admin')

@section('content')
<div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <h4>Add Fees</h4>
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('admin.fee-management.index') }}">Fees</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0);">Add Fees</a></li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xl-12 col-xxl-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Add Fees</h5>
            </div>
            <div class="card-body">
                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0 list-unstyled small">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('admin.invoices.store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="user_id">Student *</label>
                                <select name="user_id" id="user_id" class="form-control form-select @error('user_id') is-invalid @enderror" required>
                                    <option value="">Select Student</option>
                                    @foreach($students as $s)
                                        <option value="{{ $s->id }}" {{ (int) old('user_id') === $s->id ? 'selected' : '' }}>{{ $s->name }} ({{ $s->email }})</option>
                                    @endforeach
                                </select>
                                @error('user_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="enrollment_id">Enrollment (optional)</label>
                                <select name="enrollment_id" id="enrollment_id" class="form-control form-select @error('enrollment_id') is-invalid @enderror">
                                    <option value="">No enrollment</option>
                                    @foreach($enrollments as $e)
                                        <option value="{{ $e->id }}" {{ (int) old('enrollment_id') === $e->id ? 'selected' : '' }}>{{ $e->user?->name ?? '-' }} - {{ $e->course?->name ?? '-' }}</option>
                                    @endforeach
                                </select>
                                @error('enrollment_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="fee_type">Fee Type</label>
                                <select name="fee_type" id="fee_type" class="form-control">
                                    <option value="">Select type</option>
                                    <option value="Monthly" {{ old('fee_type', 'Monthly') === 'Monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="Exam" {{ old('fee_type') === 'Exam' ? 'selected' : '' }}>Exam</option>
                                    <option value="Other" {{ old('fee_type') === 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="amount">Amount (Rs) *</label>
                                <input type="number" name="amount" id="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}" min="0" step="0.01" placeholder="Amount" required>
                                @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="due_date">Collection / Due Date *</label>
                                <input type="date" name="due_date" id="due_date" class="form-control @error('due_date') is-invalid @enderror" value="{{ old('due_date') }}" required>
                                @error('due_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group mb-4">
                                <label class="form-label" for="payment_type">Payment Type</label>
                                <select name="payment_type" id="payment_type" class="form-control">
                                    <option value="">Select</option>
                                    <option value="Cash" {{ old('payment_type') === 'Cash' ? 'selected' : '' }}>Cash</option>
                                    <option value="Cheque" {{ old('payment_type') === 'Cheque' ? 'selected' : '' }}>Cheque</option>
                                    <option value="Other" {{ old('payment_type') === 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="form-label" for="payment_reference">Payment Reference Number</label>
                                <input type="text" name="payment_reference" id="payment_reference" class="form-control" value="{{ old('payment_reference') }}" placeholder="Payment Reference Number">
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group">
                                <label class="form-label" for="description">Payment Details / Description</label>
                                <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="5" placeholder="Payment Details">{{ old('description') }}</textarea>
                                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('admin.invoices.index') }}" class="btn btn-danger light">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
