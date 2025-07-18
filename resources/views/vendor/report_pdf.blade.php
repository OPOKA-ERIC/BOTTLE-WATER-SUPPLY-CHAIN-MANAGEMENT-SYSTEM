<html>
<head>
    <meta charset="utf-8">
    <title>Vendor Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #222; }
        h1, h2 { color: #1a237e; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #bbb; padding: 8px; text-align: left; }
        th { background: #e3e6f3; }
        .summary { margin-top: 30px; }
    </style>
</head>
<body>
    <h1>Vendor Activity Report</h1>
    <p><strong>Name:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Date:</strong> {{ now()->format('Y-m-d H:i') }}</p>

    <h2>Applications</h2>
    @if($applications->count())
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Business Name</th>
                <th>Status</th>
                <th>Submitted</th>
                <th>Scores (F/R/C/O)</th>
                <th>Rejection Reason</th>
            </tr>
        </thead>
        <tbody>
        @foreach($applications as $app)
            <tr>
                <td>{{ $app->id }}</td>
                <td>{{ $app->business_name }}</td>
                <td>{{ ucfirst($app->status) }}</td>
                <td>{{ $app->submitted_at ? $app->submitted_at->format('Y-m-d') : '-' }}</td>
                <td>{{ (int) $app->financial_score }}/{{ (int) $app->reputation_score }}/{{ (int) $app->compliance_score }}/{{ (int) $app->overall_score }}</td>
                <td>@if($app->status === 'rejected'){{ $app->rejection_reason ?? '-' }}@else - @endif</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="summary">
        <h2>Summary</h2>
        <ul>
            <li>Total Applications: {{ $applications->count() }}</li>
            <li>Approved: {{ $applications->where('status', 'approved')->count() }}</li>
            <li>Rejected: {{ $applications->where('status', 'rejected')->count() }}</li>
        </ul>
    </div>
    @else
        <div style="margin-top: 2em; color: #555;">
            You have no approved or rejected vendor applications yet. Once your application is reviewed, it will appear here.
        </div>
    @endif
</body>
</html> 