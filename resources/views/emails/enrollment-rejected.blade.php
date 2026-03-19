{{--
    Email sent when a student's enrollment application is rejected.
    Edit the text and HTML below to customize the message on the server.
--}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Enrollment application not approved') }}</title>
</head>
<body style="font-family: sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <h1 style="font-size: 1.25rem;">{{ __('Enrollment application not approved') }}</h1>

    <p>{{ __('Hello :name,', ['name' => $notifiable->name ?? 'there']) }}</p>

    <p>{{ __('Your application for the course :course was not approved.', ['course' => $courseName]) }}</p>

    @if($rejectionReason)
    <p><strong>{{ __('Reason') }}:</strong> {{ $rejectionReason }}</p>
    @endif

    <p>{{ __('You can submit a new application using the link below.') }}</p>

    <p>
        <a href="{{ $reapplyUrl }}" style="display: inline-block; padding: 10px 20px; background: #0d6efd; color: #fff; text-decoration: none; border-radius: 6px;">{{ __('Apply again') }}</a>
    </p>

    <p>{{ __('Thank you.') }}</p>
</body>
</html>
