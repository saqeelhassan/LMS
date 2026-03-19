{{-- Attendance Table - Reusable table for biometric attendance records. Expects $records and $date. --}}

<div class="table-responsive">
    <table class="table header-border table-hover verticle-middle table-bordered">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Check-in</th>
                <th scope="col">Check-out</th>
                <th scope="col">Status</th>
                <th scope="col">Hours</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $record)
            @php $durationMinutes = $record->check_in_time && $record->check_out_time ? (int) $record->check_in_time->diffInMinutes($record->check_out_time) : 0; @endphp
            <tr>
                <th>{{ $loop->iteration }}</th>
                <td>{{ $record->user->name ?? $record->user->email }}</td>
                <td>{{ $record->check_in_time ? $record->check_in_time->format('h:i A') : '—' }}</td>
                <td>{{ $record->check_out_time ? $record->check_out_time->format('h:i A') : '—' }}</td>
                <td>
                    @switch($record->status ?? 'Present')
                        @case('Late')
                            <span class="badge badge-rounded badge-warning">Late</span>
                            @break
                        @case('Invalid')
                            <span class="badge badge-rounded badge-danger">Invalid</span>
                            @break
                        @default
                            <span class="badge badge-rounded badge-success">Present</span>
                    @endswitch
                </td>
                <td>{{ \App\Helpers\DsimtHelper::formatDurationMinutes($durationMinutes) }}</td>
                <td><a href="{{ route('admin.attendance.edit', $record) }}" class="btn btn-sm btn-outline-primary">Edit</a></td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-muted py-4">No biometric attendance for this date. Use <strong>Sync Now with uFace 800</strong> to pull data from the device.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
