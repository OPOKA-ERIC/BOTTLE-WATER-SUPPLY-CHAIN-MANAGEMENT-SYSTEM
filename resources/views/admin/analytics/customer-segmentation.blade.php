@extends('layouts.app')

@section('content')
<div class="container-fluid" style="margin-top: 90px; min-height: 80vh;">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Customer Segmentation</h4>
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <a href="{{ route('admin.analytics.customer-segmentation.summary') }}" class="btn btn-primary">
                            <i class="nc-icon nc-zoom-split"></i> View Segment Summary
                        </a>
                    </div>
                    @if(isset($segmentsData) && count($segmentsData) > 0)
                        <div class="card mb-4">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="mb-0">Customer Segments Chart</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="segmentsChart" height="80"></canvas>
                            </div>
                        </div>
                        <div class="table-responsive mb-2">
                            <table class="table table-bordered table-hover table-striped align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Customer ID</th>
                                        <th>Quantity</th>
                                        <th>Total Amount</th>
                                        <th>Age</th>
                                        <th>Gender</th>
                                        <th>Segment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($segmentsData as $row)
                                        <tr>
                                            <td>{{ $row['Customer ID'] }}</td>
                                            <td>{{ $row['Quantity'] }}</td>
                                            <td>{{ $row['Total Amount'] }}</td>
                                            <td>{{ $row['Age'] }}</td>
                                            <td>{{ $row['Gender'] }}</td>
                                            <td>{{ $row['Segment'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning mt-5">
                            No segmentation data available. Please generate the customer segments first.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
@if(isset($segmentsData) && count($segmentsData) > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Count customers per segment
        const segments = @json(array_column($segmentsData, 'Segment'));
        const segmentCounts = {};
        segments.forEach(seg => { segmentCounts[seg] = (segmentCounts[seg] || 0) + 1; });
        const labels = Object.keys(segmentCounts).map(s => 'Segment ' + s);
        const data = Object.values(segmentCounts);
        // Map segment keys to profiles
        const segmentProfiles = @json($segmentProfiles);
        const segmentKeys = Object.keys(segmentCounts);
        const ctx = document.getElementById('segmentsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Number of Customers',
                    data: data,
                    backgroundColor: 'rgba(0,123,255,0.7)',
                    borderColor: '#007bff',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                // Get segment key (not label with 'Segment ' prefix)
                                const idx = context.dataIndex;
                                const segmentKey = segmentKeys[idx];
                                const count = context.parsed.y;
                                const profile = segmentProfiles[segmentKey] || '';
                                return [
                                    'Number of Customers: ' + count,
                                    'Profile: ' + profile
                                ];
                            }
                        }
                    }
                },
                scales: {
                    x: { title: { display: true, text: 'Segment' } },
                    y: { title: { display: true, text: 'Number of Customers' }, beginAtZero: true }
                }
            }
        });
    });
</script>
@endif
@endpush 