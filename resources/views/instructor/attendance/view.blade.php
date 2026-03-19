@extends('layouts.account', ['account' => 'instructor'])

@section('content')
<div class="col-xl-9">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('instructor.attendance.index', $course) }}" class="text-body small d-block mb-1"><i class="bi bi-arrow-left me-1"></i>Back to attendance</a>
            <h1 class="h3 mb-1">Attendance</h1>
            <p class="mb-0 text-body">{{ $course->name }} — {{ $sessionDate->format('l, M d, Y') }}</p>
        </div>
        <a href="{{ route('instructor.attendance.take-date', [$course, $sessionDate->format('Y-m-d')]) }}" class="btn btn-outline-primary">Edit</a>
    </div>

    <div class="card border rounded-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $att)
                        <tr>
                            <td>
                                <div>
                                    <h6 class="mb-0">{{ $att->user->name ?? $att->user->email }}</h6>
                                    <small class="text-body">{{ $att->user->email }}</small>
                                </div>
                            </td>
                            <td>
                                @if($att->status === 'present')
                                    <span class="badge bg-success">Present</span>
                                @elseif($att->status === 'absent')
                                    <span class="badge bg-danger">Absent</span>
                                @elseif($att->status === 'late')
                                    <span class="badge bg-warning text-dark">Late</span>
                                @else
                                    <span class="badge bg-secondary">Excused</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="text-center py-4 text-body">No attendance recorded for this date.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
