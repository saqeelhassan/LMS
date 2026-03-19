@extends('layouts.student')

@section('content')
<div>
    <div class="mb-4">
        <h1 class="h3 mb-1">My Certificates</h1>
        <p class="mb-0">Course completion certificates. View or print.</p>
    </div>

    <div class="card border rounded-3">
        <div class="card-body">
            @if($enrollments->isEmpty())
                <p class="mb-0 text-center py-4">No certificates yet. Complete a course to get your certificate.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Course</th>
                                <th>Completed on</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($enrollments as $enrollment)
                            <tr>
                                <td>{{ $enrollment->course->name ?? '—' }}</td>
                                <td>{{ $enrollment->completed_at?->format('M d, Y') ?? '—' }}</td>
                                <td>
                                    <a href="{{ route('student.certificates.show', $enrollment) }}" class="btn btn-sm btn-primary" target="_blank">View / Print</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
