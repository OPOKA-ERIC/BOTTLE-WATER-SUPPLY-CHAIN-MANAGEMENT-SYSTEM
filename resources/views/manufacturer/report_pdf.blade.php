<html>
<head>
    <meta charset="utf-8">
    <title>Production Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #222; }
        h1, h2, h3 { color: #1a237e; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #bbb; padding: 8px; text-align: left; }
        th { background: #e3e6f3; }
        .summary { margin-top: 30px; }
        .stats { margin-bottom: 20px; }
        .stats span { display: inline-block; min-width: 180px; }
    </style>
</head>
<body>
    <h1>Production Report</h1>
    <div class="stats">
        <span><strong>Total Batches:</strong> {{ $totalBatches }}</span>
        <span><strong>Completed:</strong> {{ $completedBatches }}</span>
        <span><strong>In Progress:</strong> {{ $inProgressBatches }}</span>
        <span><strong>Pending:</strong> {{ $pendingBatches }}</span>
    </div>
    <div class="stats">
        <span><strong>Total Production:</strong> {{ number_format($totalProduction) }} units</span>
        <span><strong>Total Revenue:</strong> {{ number_format($totalRevenue) }} UGX</span>
        <span><strong>Efficiency:</strong> {{ $efficiency }}%</span>
        <span><strong>Avg. Cycle Time:</strong> {{ $avgCycleTime ? number_format($avgCycleTime, 1) . 'h' : 'N/A' }}</span>
    </div>
    <h2>Batches</h2>
    <table>
        <thead>
            <tr>
                <th>Batch ID</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Start Date</th>
                <th>Completion Date</th>
            </tr>
        </thead>
        <tbody>
        @foreach($batches as $batch)
            <tr>
                <td>#{{ $batch->id }}</td>
                <td>{{ $batch->product->name ?? 'N/A' }}</td>
                <td>{{ number_format($batch->quantity) }}</td>
                <td>{{ ucfirst($batch->status) }}</td>
                <td>{{ $batch->start_date ? \Carbon\Carbon::parse($batch->start_date)->format('M d, Y') : '-' }}</td>
                <td>{{ $batch->estimated_completion ? \Carbon\Carbon::parse($batch->estimated_completion)->format('M d, Y') : '-' }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="summary">
        <h3>Summary</h3>
        <ul>
            <li><strong>Top Products:</strong>
                <ul>
                @foreach($topProducts as $productId => $qty)
                    <li>{{ optional($batches->firstWhere('product_id', $productId))->product->name ?? 'Product #' . $productId }}: {{ number_format($qty) }} units</li>
                @endforeach
                </ul>
            </li>
            <li><strong>Status Breakdown:</strong>
                Completed: {{ $statusBreakdown['completed'] }},
                In Progress: {{ $statusBreakdown['in_progress'] }},
                Pending: {{ $statusBreakdown['pending'] }}
            </li>
        </ul>
    </div>
    <div class="summary">
        <h3>Recent Activity</h3>
        <ul>
        @foreach($recentActivity as $batch)
            <li>Batch #{{ $batch->id }} ({{ $batch->product->name ?? 'N/A' }}) - Status: {{ ucfirst($batch->status) }} - Updated: {{ \Carbon\Carbon::parse($batch->updated_at)->format('M d, Y H:i') }}</li>
        @endforeach
        </ul>
    </div>
</body>
</html> 