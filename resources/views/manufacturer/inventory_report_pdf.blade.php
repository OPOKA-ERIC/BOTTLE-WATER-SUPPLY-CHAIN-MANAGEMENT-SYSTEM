<html>
<head>
    <meta charset="utf-8">
    <title>Inventory Report</title>
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
    <h1>Inventory Report</h1>
    <div class="stats">
        <span><strong>Total Items:</strong> {{ $stats['total_items'] }}</span>
        <span><strong>Total Stock:</strong> {{ $stats['total_stock'] }}</span>
        <span><strong>Low Stock Items:</strong> {{ $stats['low_stock_items'] }}</span>
        <span><strong>Out of Stock:</strong> {{ $stats['out_of_stock_items'] }}</span>
        <span><strong>Well Stocked:</strong> {{ $stats['well_stocked_items'] }}</span>
        <span><strong>Avg. Stock Level:</strong> {{ $stats['average_stock_level'] }}</span>
        <span><strong>Stock Utilization:</strong> {{ $stats['stock_utilization'] }}%</span>
    </div>
    <h2>Inventory Items</h2>
    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Current Stock</th>
                <th>Minimum Stock</th>
                <th>Unit</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        @foreach($inventory as $item)
            <tr>
                <td>{{ $item->product->name ?? 'N/A' }}</td>
                <td>{{ $item->current_stock }}</td>
                <td>{{ $item->minimum_stock }}</td>
                <td>{{ $item->unit ?? 'units' }}</td>
                <td>
                    @php
                        $turnover = $item->minimum_stock > 0 ? $item->current_stock / $item->minimum_stock : 0;
                        if ($turnover < 1) $status = 'Critical';
                        elseif ($turnover < 1.5) $status = 'Low';
                        elseif ($turnover < 3) $status = 'Moderate';
                        else $status = 'Good';
                    @endphp
                    {{ $status }}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="summary">
        <h3>Stock Level Breakdown</h3>
        <ul>
            <li>Critical: {{ $stockLevels['critical'] }}</li>
            <li>Low: {{ $stockLevels['low'] }}</li>
            <li>Moderate: {{ $stockLevels['moderate'] }}</li>
            <li>Good: {{ $stockLevels['good'] }}</li>
        </ul>
    </div>
    <div class="summary">
        <h3>Top Products by Stock</h3>
        <ul>
        @foreach($topProducts as $item)
            <li>{{ $item->product->name ?? 'N/A' }}: {{ $item->current_stock }} units</li>
        @endforeach
        </ul>
    </div>
    <div class="summary">
        <h3>Monthly Trends (last 6 months)</h3>
        <ul>
        @foreach($monthlyTrends as $month => $trend)
            <li>{{ $month }}: {{ $trend['total_stock'] }} units, {{ $trend['items_count'] }} items, {{ $trend['low_stock_count'] }} low stock</li>
        @endforeach
        </ul>
    </div>
</body>
</html> 