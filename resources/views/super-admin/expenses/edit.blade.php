@extends('layouts.super-admin')

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <a href="{{ route('super-admin.expenses.index') }}" class="text-body small d-block mb-1"><i class="bi bi-arrow-left me-1"></i>Back to expenses</a>
        <h1 class="h3 mb-2 mb-sm-0">Edit Expense</h1>
    </div>
</div>

<div class="card shadow">
    <div class="card-body p-4">
        <form method="post" action="{{ route('super-admin.expenses.update', $expense) }}" id="expenseForm">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="type" class="form-label">Type *</label>
                <select name="type" id="type" class="form-select" required>
                    <option value="">— Select —</option>
                    <option value="salary" {{ old('type', $expense->type) === 'salary' ? 'selected' : '' }}>Salary</option>
                    <option value="lab_maintenance" {{ old('type', $expense->type) === 'lab_maintenance' ? 'selected' : '' }}>Lab Maintenance</option>
                    <option value="server" {{ old('type', $expense->type) === 'server' ? 'selected' : '' }}>Server</option>
                    <option value="other" {{ old('type', $expense->type) === 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

            <div class="mb-3" id="payeeSection" style="display: none;">
                <label class="form-label">Payee (Instructor / Admin) *</label>
                <input type="hidden" name="payee_user_id" id="payee_user_id" value="{{ old('payee_user_id', $expense->payee_user_id) }}">
                <button type="button" class="btn btn-outline-primary mb-2" id="openPayeeModalBtn">
                    <i class="bi bi-person-plus me-1"></i>Select user
                </button>
                <div id="payeeFields" class="border rounded p-3 bg-light bg-opacity-50" style="display: none;">
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label small text-muted mb-0">Name</label>
                            <div class="form-control bg-white" id="payeeNameDisplay" readonly>—</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small text-muted mb-0">Phone number</label>
                            <div class="form-control bg-white" id="payeePhoneDisplay" readonly>—</div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary mt-2" id="changePayeeBtn">Change</button>
                </div>
                <div class="invalid-feedback" id="payeeError">Please select a payee.</div>
            </div>

            <div class="mb-3" id="payeeNameField" style="display: none;">
                <label for="payee_name" class="form-label">Name *</label>
                <input type="text" name="payee_name" id="payee_name" class="form-control @error('payee_name') is-invalid @enderror" value="{{ old('payee_name', $expense->payee_name) }}" maxlength="255" placeholder="Salary payee name">
                @error('payee_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <input type="text" name="description" id="description" class="form-control" value="{{ old('description', $expense->description) }}" maxlength="500">
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="amount" class="form-label">Amount *</label>
                    <input type="number" name="amount" id="amount" class="form-control" value="{{ old('amount', $expense->amount) }}" step="0.01" min="0" required>
                </div>
                <div class="col-md-6">
                    <label for="expense_date" class="form-label">Date *</label>
                    <input type="date" name="expense_date" id="expense_date" class="form-control" value="{{ old('expense_date', $expense->expense_date?->format('Y-m-d')) }}" required>
                </div>
            </div>
            <div class="mb-4 mt-3">
                <label for="branch_id" class="form-label">Branch (optional)</label>
                <select name="branch_id" id="branch_id" class="form-select">
                    <option value="">— None —</option>
                    @foreach($branches as $b)
                        <option value="{{ $b->id }}" {{ old('branch_id', $expense->branch_id) == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Expense</button>
            <a href="{{ route('super-admin.expenses.index') }}" class="btn btn-outline-secondary">Cancel</a>
        </form>
    </div>
</div>

{{-- Modal: Select Instructor or Admin --}}
<div class="modal fade" id="payeeModal" tabindex="-1" aria-labelledby="payeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="payeeModalLabel">Select payee (Instructor or Admin)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-tabs mb-3" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#instructors-pane" type="button">Instructors</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#admins-pane" type="button">Admins</button>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="instructors-pane" role="tabpanel">
                        <div class="list-group list-group-flush">
                            @forelse($instructors as $u)
                                @php $phone = $u->userDetail->mobile ?? $u->userDetail->contact_no ?? '—'; @endphp
                                <button type="button" class="list-group-item list-group-item-action payee-option text-start" data-id="{{ $u->id }}" data-name="{{ $u->name }}" data-phone="{{ $phone }}">
                                    <strong>{{ $u->name }}</strong>
                                    <span class="d-block small text-muted">{{ $phone }}</span>
                                </button>
                            @empty
                                <p class="text-muted mb-0">No instructors found.</p>
                            @endforelse
                        </div>
                    </div>
                    <div class="tab-pane fade" id="admins-pane" role="tabpanel">
                        <div class="list-group list-group-flush">
                            @forelse($admins as $u)
                                @php $phone = $u->userDetail->mobile ?? $u->userDetail->contact_no ?? '—'; @endphp
                                <button type="button" class="list-group-item list-group-item-action payee-option text-start" data-id="{{ $u->id }}" data-name="{{ $u->name }}" data-phone="{{ $phone }}">
                                    <strong>{{ $u->name }}</strong>
                                    <span class="d-block small text-muted">{{ $phone }}</span>
                                </button>
                            @empty
                                <p class="text-muted mb-0">No admins found.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var typeSelect = document.getElementById('type');
    var payeeSection = document.getElementById('payeeSection');
    var payeeUserId = document.getElementById('payee_user_id');
    var payeeFields = document.getElementById('payeeFields');
    var payeeNameDisplay = document.getElementById('payeeNameDisplay');
    var payeePhoneDisplay = document.getElementById('payeePhoneDisplay');
    var openPayeeModalBtn = document.getElementById('openPayeeModalBtn');
    var changePayeeBtn = document.getElementById('changePayeeBtn');
    var payeeError = document.getElementById('payeeError');
    var payeeModal = document.getElementById('payeeModal');
    var expenseForm = document.getElementById('expenseForm');
    var payeeNameField = document.getElementById('payeeNameField');
    var payeeNameInput = document.getElementById('payee_name');

    function showPayeeSection(show) {
        payeeSection.style.display = show ? 'block' : 'none';
        payeeNameField.style.display = show ? 'block' : 'none';
        if (!show) {
            payeeUserId.value = '';
            payeeNameInput.value = '';
            payeeFields.style.display = 'none';
            openPayeeModalBtn.style.display = 'inline-block';
            payeeNameDisplay.textContent = '—';
            payeePhoneDisplay.textContent = '—';
        }
        payeeError.style.display = 'none';
    }

    typeSelect.addEventListener('change', function() {
        var isSalary = this.value === 'salary';
        showPayeeSection(isSalary);
        if (isSalary && payeeUserId.value) {
            payeeFields.style.display = 'block';
            openPayeeModalBtn.style.display = 'none';
            payeeNameDisplay.textContent = payeeNameInput.value || '—';
            if (payeePhoneDisplay.dataset.phone) payeePhoneDisplay.textContent = payeePhoneDisplay.dataset.phone;
        }
    });

    openPayeeModalBtn.addEventListener('click', function() {
        new bootstrap.Modal(payeeModal).show();
    });

    changePayeeBtn.addEventListener('click', function() {
        payeeUserId.value = '';
        payeeNameInput.value = '';
        payeeNameDisplay.textContent = '—';
        payeePhoneDisplay.textContent = '—';
        payeePhoneDisplay.removeAttribute('data-phone');
        payeeFields.style.display = 'none';
        openPayeeModalBtn.style.display = 'inline-block';
        new bootstrap.Modal(payeeModal).show();
    });

    document.querySelectorAll('.payee-option').forEach(function(btn) {
        btn.addEventListener('click', function() {
            var name = this.getAttribute('data-name') || '';
            payeeUserId.value = this.getAttribute('data-id');
            payeeNameInput.value = name;
            payeeNameDisplay.textContent = name || '—';
            payeePhoneDisplay.textContent = this.getAttribute('data-phone') || '—';
            payeeFields.style.display = 'block';
            openPayeeModalBtn.style.display = 'none';
            payeeError.style.display = 'none';
            bootstrap.Modal.getInstance(payeeModal).hide();
        });
    });

    expenseForm.addEventListener('submit', function(e) {
        if (typeSelect.value === 'salary' && !payeeUserId.value) {
            e.preventDefault();
            payeeError.style.display = 'block';
            payeeSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
            return false;
        }
    });

    if (typeSelect.value === 'salary') {
        payeeSection.style.display = 'block';
        payeeNameField.style.display = 'block';
        if (payeeUserId.value) {
            payeeFields.style.display = 'block';
            openPayeeModalBtn.style.display = 'none';
            payeeNameDisplay.textContent = payeeNameInput.value || '—';
            @if($expense->payee)
            payeePhoneDisplay.textContent = {!! json_encode($expense->payee->userDetail->mobile ?? $expense->payee->userDetail->contact_no ?? '—') !!};
            @else
            payeePhoneDisplay.textContent = '—';
            @endif
        }
    }
});
</script>
@endsection
@endsection
