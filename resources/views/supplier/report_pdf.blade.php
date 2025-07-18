<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; }
        h2 { color: #1a237e; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px 8px; text-align: left; }
        th { background: #f0f0f0; }
        .section-title { margin-top: 30px; font-size: 1.1em; color: #1a237e; }
    </style>
</head>
<body>
    <h2>Supplier Activity Report</h2>
    <p><strong>Name:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Date:</strong> {{ now()->format('Y-m-d H:i') }}</p>
    <div class="section-title">Summary</div>
    <ul>
        <li><strong>Total Sales:</strong> UGX {{ number_format($stats['total_sales'], 0) }}/=</li>
        <li><strong>Pending Orders:</strong> {{ $stats['pending_orders'] }}</li>
        <li><strong>Completed Orders:</strong> {{ $stats['completed_orders'] }}</li>
        <li><strong>Total Materials:</strong> {{ $stats['total_materials'] }}</li>
    </ul>
    <div class="section-title">Orders</div>
    <table>
        <thead>
            <tr>
                <th>Order #</th>
                <th>Manufacturer</th>
                <th>Status</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->order_number }}</td>
                <td>{{ $order->manufacturer->name ?? '-' }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>UGX {{ number_format($order->total_amount, 0) }}/=</td>
                <td>{{ $order->created_at->format('Y-m-d') }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="section-title">Materials</div>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
        @foreach($materials as $material)
            <tr>
                <td>{{ $material->name }}</td>
                <td>{{ $material->quantity_available }}</td>
                <td>UGX {{ number_format($material->price, 0) }}/=</td>
                <td>UGX {{ number_format($material->quantity_available * $material->price, 0) }}/=</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</body>
</html> 