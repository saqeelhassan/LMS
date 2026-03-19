<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Biometric Attendance - {{ $date }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; padding: 20px; }
        h1 { font-size: 18px; margin-bottom: 5px; }
        .meta { color: #666; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #f5f5f5; }
        .badge { padding: 2px 6px; border-radius: 3px; font-size: 10px; }
        .badge-success { background: #d4edda; color: #155724; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-danger { background: #f8d7da; color: #721c24; }
        @media print { body { padding: 0; } }
    </style>
</head>
<body>
    <h1>@if(!empty($programName)){{ $programName }} — @endif Biometric Attendance Report</h1>
    <p class="meta">Date: {{ $dateLabel ?? \Carbon\Carbon::parse($date)->format('l, F j, Y') }} | Generated: {{ now()->format('M j, Y g:i A') }}</p>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Name</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Status</th>
                <th>Hours</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $i => $r)
            @php $mins = $r->check_in_time && $r->check_out_time ? (int) $r->check_in_time->diffInMinutes($r->check_out_time) : 0; @endphp
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $r->date ? \Carbon\Carbon::parse($r->date)->format('M j, Y') : '—' }}</td>
                <td>{{ $r->user->name ?? $r->user->email }}</td>
                <td>{{ $r->check_in_time ? $r->check_in_time->format('h:i A') : '—' }}</td>
                <td>{{ $r->check_out_time ? $r->check_out_time->format('h:i A') : '—' }}</td>
                <td><span class="badge badge-{{ $r->status === 'Late' ? 'warning' : ($r->status === 'Invalid' ? 'danger' : 'success') }}">{{ $r->status ?? 'Present' }}</span></td>
                <td>{{ $mins ? floor($mins / 60) . 'h ' . ($mins % 60) . 'm' : '—' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @if($records->isEmpty())
        <p>No biometric attendance recorded for this date.</p>
    @endif
    <script>window.onload = function() { window.print(); }</script>
</body>
</html>
