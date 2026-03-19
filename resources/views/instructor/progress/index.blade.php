@extends('layouts.account', ['account' => 'instructor'])

@section('content')
<div class="col-xl-9">
    <div class="mb-4">
        <a href="{{ route('instructor.manage-course') }}" class="text-body small d-block mb-1">Back to courses</a>
        <h1 class="h3 mb-1">Student progress: {{ $course->name }}</h1>
        <p class="mb-0 text-body">View performance (exams, assignments, attendance).</p>
    </div>

    @if($students->isNotEmpty())
    <div class="card border rounded-3 mb-4">
        <div class="card-header bg-light">
            <h5 class="mb-0">Overall performance</h5>
        </div>
        <div class="card-body">
            <div id="progressChart" style="min-height:300px"></div>
        </div>
    </div>
    @endif

    <div class="card border rounded-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Exams %</th>
                            <th>Assignments %</th>
                            <th>Attendance %</th>
                            <th>Overall %</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $s)
                        <tr>
                            <td>
                                <h6 class="mb-0">{{ $s->user->name ?? $s->user->email }}</h6>
                                <small class="text-body">{{ $s->user->email }}</small>
                            </td>
                            <td>{{ $s->exam_percent }}%</td>
                            <td>{{ $s->assign_percent }}%</td>
                            <td>{{ $s->attendance_percent }}%</td>
                            <td><strong>{{ $s->overall_percent }}%</strong></td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-4">No enrolled students.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@if($students->isNotEmpty())
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var options = {
        chart: { type: 'bar', height: 300 },
        series: [{ name: 'Overall %', data: @json($chartData) }],
        xaxis: { categories: @json($chartLabels) },
        plotOptions: { bar: { horizontal: true, dataLabels: { position: 'bottom' } } },
        dataLabels: { enabled: true, formatter: function(v) { return v + '%'; } }
    };
    new ApexCharts(document.querySelector('#progressChart'), options).render();
});
</script>
@endif
@endsection
