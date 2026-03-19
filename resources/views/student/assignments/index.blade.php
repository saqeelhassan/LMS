@extends('layouts.student')

@section('content')
<div>
    <div class="mb-4">
        <h1 class="h3 mb-1">My assignments</h1>
        <p class="mb-0">Assignments for your enrolled courses.</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border rounded-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Assignment</th>
                            <th>Course / Batch</th>
                            <th>Total marks</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assignments as $assignment)
                        @php $mySub = $submissionMap->get($assignment->id); @endphp
                        <tr>
                            <td>
                                <h6 class="mb-0">{{ $assignment->title }}</h6>
                                @if($assignment->description)<small>{{ Str::limit($assignment->description, 50) }}</small>@endif
                            </td>
                            <td>{{ $assignment->course->name ?? '-' }}@if($assignment->batch) <span class="text-muted">({{ $assignment->batch->name }})</span>@endif</td>
                            <td>{{ $assignment->total_marks }}</td>
                            <td>{{ $assignment->due_date ? $assignment->due_date->format('M d, Y') : '-' }}</td>
                            <td>
                                @if($mySub && $mySub->status === 'graded')
                                    <span class="badge bg-success">Graded ({{ $mySub->marks_obtained }}/{{ $assignment->total_marks }})</span>
                                @elseif($mySub && $mySub->status === 'submitted')
                                    <span class="badge bg-info">Pending</span>
                                @else
                                    <span class="badge bg-secondary">Not submitted</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('student.assignments.submit-form', $assignment) }}" class="btn btn-sm btn-outline-primary">{{ $mySub && $mySub->file_path ? ($mySub->status === 'graded' ? 'View result' : 'Resubmit') : 'Submit' }}</a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center py-4">No assignments yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($assignments->hasPages())
                <div class="d-flex justify-content-center mt-3">{{ $assignments->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
