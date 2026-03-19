@extends('layouts.admin')

@section('content')
<div class="row mb-3">
    <div class="col-12">
        <h1 class="h3 mb-2 mb-sm-0">Timetable — {{ $batch->name }}</h1>
        <p class="mb-0 text-body">Set schedule slots (e.g. Monday 10 AM - Lab 3).</p>
    </div>
</div>

<div class="row">
    <div class="col-lg-10">
        <div class="card shadow">
            <div class="card-body p-4">
                @if(session('success'))
                    <div class="alert alert-success mb-4">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0 list-unstyled small">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                    </div>
                @endif
                <form method="post" action="{{ route('admin.batches.timetable.store', $batch) }}">
                    @csrf
                    <div id="slots-container">
                        @php $slots = $batch->timetableSlots->isEmpty() ? [['day_of_week' => 1, 'start_time' => '10:00', 'end_time' => '12:00', 'room' => '']] : $batch->timetableSlots->toArray(); @endphp
                        @foreach($slots as $idx => $slot)
                            <div class="row g-2 mb-2 slot-row">
                                <div class="col-md-2">
                                    <select name="slots[{{ $idx }}][day_of_week]" class="form-select form-select-sm" required>
                                        @foreach(\App\Models\Batch::dayNames() as $d => $name)
                                            <option value="{{ $d }}" {{ ($slot['day_of_week'] ?? 1) == $d ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="time" name="slots[{{ $idx }}][start_time]" class="form-control form-control-sm"
                                        value="{{ $slot['start_time'] ?? '10:00' }}" required>
                                </div>
                                <div class="col-md-2">
                                    <input type="time" name="slots[{{ $idx }}][end_time]" class="form-control form-control-sm"
                                        value="{{ $slot['end_time'] ?? '12:00' }}" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="slots[{{ $idx }}][room]" class="form-control form-control-sm"
                                        value="{{ $slot['room'] ?? '' }}" placeholder="Room / Lab">
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-sm btn-outline-danger remove-slot">×</button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary mb-3" id="add-slot">+ Add slot</button>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Save timetable</button>
                        <a href="{{ route('admin.batches.edit', $batch) }}" class="btn btn-outline-secondary">Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
document.getElementById('add-slot').addEventListener('click', function() {
    const container = document.getElementById('slots-container');
    const idx = container.querySelectorAll('.slot-row').length;
    const days = @json(\App\Models\Batch::dayNames());
    let opts = '';
    for (let d = 0; d < days.length; d++) opts += '<option value="'+d+'">'+days[d]+'</option>';
    const row = document.createElement('div');
    row.className = 'row g-2 mb-2 slot-row';
    row.innerHTML = `
        <div class="col-md-2">
            <select name="slots[${idx}][day_of_week]" class="form-select form-select-sm" required>`+opts+`</select>
        </div>
        <div class="col-md-2">
            <input type="time" name="slots[${idx}][start_time]" class="form-control form-control-sm" value="10:00" required>
        </div>
        <div class="col-md-2">
            <input type="time" name="slots[${idx}][end_time]" class="form-control form-control-sm" value="12:00" required>
        </div>
        <div class="col-md-3">
            <input type="text" name="slots[${idx}][room]" class="form-control form-control-sm" placeholder="Room / Lab">
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-sm btn-outline-danger remove-slot">×</button>
        </div>
    `;
    container.appendChild(row);
});
document.getElementById('slots-container').addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-slot') && this.querySelectorAll('.slot-row').length > 1) {
        e.target.closest('.slot-row').remove();
    }
});
</script>
@endsection
