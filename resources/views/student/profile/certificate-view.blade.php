<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate — {{ $enrollment->course->name ?? 'Course' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f5f5f5; padding: 2rem; }
        .certificate { max-width: 800px; margin: 0 auto; background: #fff; border: 8px solid #1a5f2a; border-radius: 12px; padding: 3rem; box-shadow: 0 4px 20px rgba(0,0,0,0.1); }
        .certificate h1 { font-size: 2rem; color: #1a5f2a; margin-bottom: 0.5rem; }
        .certificate .subtitle { color: #666; margin-bottom: 2rem; }
        .certificate .student-name { font-size: 1.75rem; font-weight: bold; margin: 1.5rem 0; }
        .certificate .course-name { font-size: 1.25rem; color: #333; }
        .certificate .date { margin-top: 2rem; color: #666; }
        @media print { body { background: #fff; padding: 0; } .certificate { box-shadow: none; } .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="no-print text-center mb-3">
        <button onclick="window.print();" class="btn btn-primary">Print Certificate</button>
        <a href="{{ route('student.certificates') }}" class="btn btn-outline-secondary">Back to Certificates</a>
    </div>
    <div class="certificate">
        <h1>Digital Sindh Institute of Management & Technology</h1>
        <p class="subtitle">Certificate of Completion</p>
        <p class="student-name">{{ $enrollment->user->name ?? $enrollment->user->email }}</p>
        <p class="course-name">has successfully completed <strong>{{ $enrollment->course->name ?? 'the course' }}</strong></p>
        <p class="date">Date: {{ $enrollment->completed_at ? $enrollment->completed_at->format('F d, Y') : '' }}</p>
    </div>
</body>
</html>
