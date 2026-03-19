<div class="modal fade" id="transferModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" id="transferForm" action="{{ route('admin.enrollments.transfer') }}">
                @csrf
                <input type="hidden" name="enrollment_id" id="transfer_enrollment_id" value="">
                <input type="hidden" name="redirect" id="transfer_redirect" value="">
                <div class="modal-header">
                    <h5 class="modal-title">Transfer / Change Course</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 p-3 bg-light rounded">
                        <p class="mb-2 small text-body-secondary">Current Course</p>
                        <p class="mb-0 fw-medium" id="transferCurrentInfo">—</p>
                    </div>
                    @if(isset($errors) && ($errors->has('new_batch_id') || $errors->has('effective_date')))
                    <div class="alert alert-danger py-2 mb-3">
                        {{ $errors->first('new_batch_id') ?? $errors->first('effective_date') }}
                    </div>
                    @endif
                    <div class="mb-3">
                        <label class="form-label" for="transfer_new_batch_id">New Course & Batch</label>
                        <select name="new_batch_id" id="transfer_new_batch_id" class="form-select {{ isset($errors) && $errors->has('new_batch_id') ? 'is-invalid' : '' }}" required>
                            <option value="">— Select new course & batch —</option>
                            @foreach($batchesForTransfer ?? [] as $courseId => $batches)
                                @php $course = $batches->first()->course; @endphp
                                <optgroup label="{{ $course?->name ?? 'Course' }}">
                                    @foreach($batches as $b)
                                        <option value="{{ $b->id }}" data-fee="{{ number_format($b->monthly_fee ?? 0, 0) }}">
                                            {{ $b->name }} — {{ \App\Models\Setting::get('currency', 'PKR') }} {{ number_format($b->monthly_fee ?? 0, 0) }}/mo
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Effective Date</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="effective_date" id="effective_immediately" value="immediately" required checked>
                            <label class="form-check-label" for="effective_immediately">Immediately</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="effective_date" id="effective_next_month" value="next_month">
                            <label class="form-check-label" for="effective_next_month">Next Month</label>
                        </div>
                        <small class="text-body-secondary d-block mt-1">
                            Immediately: update all unpaid vouchers to new fee. Next month: only update vouchers from next month onward.
                        </small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Transfer</button>
                </div>
            </form>
        </div>
    </div>
</div>
