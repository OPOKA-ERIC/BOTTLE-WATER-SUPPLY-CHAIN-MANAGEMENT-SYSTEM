<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #222; background: #fff; }
        h2 { color: #1a237e; margin-bottom: 0.5em; }
        h4 { color: #1a237e; margin-top: 1.5em; margin-bottom: 0.5em; }
        ul { margin: 0 0 1em 1.5em; padding: 0; }
        li { margin-bottom: 0.3em; }
        .section { margin-bottom: 1.5em; }
        .header { background: #1976d2; color: #fff; padding: 1em 1.5em; border-radius: 8px 8px 0 0; }
        .stats-table { width: 100%; border-collapse: collapse; margin-bottom: 1.5em; }
        .stats-table th, .stats-table td { border: 1px solid #e3e6f3; padding: 8px 12px; }
        .stats-table th { background: #f4f6fa; color: #1a237e; }
        .stats-table td { background: #fff; }
        .activities-table { width: 100%; border-collapse: collapse; margin-bottom: 1em; }
        .activities-table th, .activities-table td { border: 1px solid #e3e6f3; padding: 6px 10px; font-size: 0.95em; }
        .activities-table th { background: #f4f6fa; color: #1a237e; }
        .activities-table td { background: #fff; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Admin Activity Report</h2>
        <p><strong>Name:</strong> {{ $user->name }}<br>
        <strong>Email:</strong> {{ $user->email }}<br>
        <strong>Date:</strong> {{ now()->format('Y-m-d H:i') }}</p>
    </div>
    <div class="section">
        <h4>System Statistics</h4>
        <table class="stats-table">
            <tr><th>Total Users</th><td>{{ $stats['total_users'] }}</td></tr>
            <tr><th>Total Orders</th><td>{{ $stats['total_orders'] }}</td></tr>
            <tr><th>Total Inventory</th><td>{{ $stats['total_inventory'] }}</td></tr>
            <tr><th>Total Vendor Applications</th><td>{{ $stats['total_vendor_applications'] }}</td></tr>
            <tr><th>Total Tasks</th><td>{{ $stats['total_tasks'] }}</td></tr>
            <tr><th>Completed Tasks</th><td>{{ $stats['completed_tasks'] }}</td></tr>
            <tr><th>Pending Tasks</th><td>{{ $stats['pending_tasks'] }}</td></tr>
            <tr><th>In Progress Tasks</th><td>{{ $stats['in_progress_tasks'] }}</td></tr>
        </table>
    </div>
    <div class="section">
        <h4>Recent Orders</h4>
        <table class="activities-table">
            <tr><th>ID</th><th>Status</th><th>Date</th></tr>
            @foreach($recentActivities['orders'] as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </table>
        <h4>Recent Vendor Applications</h4>
        <table class="activities-table">
            <tr><th>Business Name</th><th>Status</th><th>Date</th></tr>
            @foreach($recentActivities['vendor_applications'] as $app)
                <tr>
                    <td>{{ $app->business_name ?? 'N/A' }}</td>
                    <td>{{ $app->status }}</td>
                    <td>{{ $app->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </table>
        <h4>Recent Tasks</h4>
        <table class="activities-table">
            <tr><th>Title</th><th>Status</th><th>Date</th></tr>
            @foreach($recentActivities['tasks'] as $task)
                <tr>
                    <td>{{ $task->title ?? 'Task' }}</td>
                    <td>{{ $task->status }}</td>
                    <td>{{ $task->created_at->format('Y-m-d') }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</body>
</html> 