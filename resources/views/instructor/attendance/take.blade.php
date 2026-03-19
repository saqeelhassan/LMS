@extends('layouts.account', ['account' => 'instructor'])

@section('content')
<div class="col-xl-9">
    <div class="mb-4">
        <a href="{{ route('instructor.attendance.index', $course) }}" class="text-body small d-block mb-1"><i class="bi bi-arrow-left me-1"></i>Back to attendance</a>
        <h1 class="h3 mb-1">Take attendance</h1>
        <p class="mb-0 text-body">{{ $course->name }} — {{ $sessionDate->format('l, M d, Y') }}</p>
    </div>

    @if($enrolledStudents->isEmpty())
        <div class="alert alert-info">No students enrolled in this course yet.</div>
    @else
        <div class="card border rounded-3">
            <div class="card-body p-4">
                <form method="post" action="{{ route('instructor.attendance.store', $course) }}">
                    @csrf
                    <input type="hidden" name="session_date" value="{{ $sessionDate->format('Y-m-d') }}">
                    <div class="mb-3">
                        <label class="form-label">Session type</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input type="radio" name="session_type" id="session_offline" value="offline" class="form-check-input" {{ ($existing->first()?->session_type ?? 'offline') === 'offline' ? 'checked' : '' }}>
                                <label for="session_offline" class="form-check-label">Offline (Physical lab)</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="session_type" id="session_online" value="online" class="form-check-input" {{ ($existing->first()?->session_type ?? '') === 'online' ? 'checked' : '' }}>
                                <label for="session_online" class="form-check-label">Online (Live session)</label>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Student</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($enrolledStudents as $student)
                                @php $rec = $existing->get($student->id); @endphp
                                <tr>
                                    <td>
                                        <div>
                                            <h6 class="mb-0">{{ $student->name ?? $student->email }}</h6>
                                            <small class="text-body">{{ $student->email }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <select name="attendance[{{ $student->id }}]" class="form-select form-select-sm" style="width:auto">
                                            <option value="present" {{ ($rec?->status ?? 'present') === 'present' ? 'selected' : '' }}>Present</option>
                                            <option value="absent" {{ ($rec?->status ?? '') === 'absent' ? 'selected' : '' }}>Absent</option>
                                            <option value="late" {{ ($rec?->status ?? '') === 'late' ? 'selected' : '' }}>Late</option>
                                            <option value="excused" {{ ($rec?->status ?? '') === 'excused' ? 'selected' : '' }}>Excused</option>
                                        </select>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">Save attendance</button>
                        <a href="{{ route('instructor.attendance.index', $course) }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
@endsection
