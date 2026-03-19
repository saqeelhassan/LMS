@extends('layouts.super-admin')

@section('title', 'My Batches')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">My Batches</h4>
                    <p class="card-text mb-0">Select a batch to mark student attendance (Physical or Online)</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Batch</th>
                                    <th>Course</th>
                                    <th>Branch</th>
                                    <th>Students</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($batches as $b)
                                <tr>
                                    <td>
                                        <strong>{{ $b->name }}</strong>
                                        @if(!$b->is_active)<span class="badge bg-secondary ms-1">Inactive</span>@endif
                                    </td>
                                    <td>{{ $b->course->name ?? '—' }}</td>
                                    <td>{{ $b->branch->name ?? '—' }}</td>
                                    <td>{{ $b->enrollments_count }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('instructor.batches.attendance.index', $b) }}" class="btn btn-sm btn-success"><i class="bi bi-person-check me-1"></i>Attendance</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-body">No batches assigned to you yet.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
