@extends('layouts.app')

@section('content')
<div class="container-fluid" style="margin-top: 90px; min-height: 80vh;">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Demand Forecast</h4>
                </div>
                <div class="card-body">
                    @if(isset($forecastData) && count($forecastData) > 0)
                        <div class="card mb-4">
                            <div class="card-header bg-secondary text-white">
                                <h5 class="mb-0">Forecast Chart</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="forecastChart" height="100"></canvas>
                            </div>
                        </div>
                        <div class="table-responsive mb-2">
                            <table class="table table-bordered table-hover table-striped align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Date</th>
                                        <th>Forecasted Sales</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($forecastData as $row)
                                        <tr>
                                            <td>{{ $row['Date'] }}</td>
                                            <td>{{ $row['Forecasted_Sales'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning mt-5">
                            No forecast data available. Please generate the forecast first.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@if(isset($forecastData) && count($forecastData) > 0)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const labels = @json(array_column($forecastData, 'Date'));
        const data = @json(array_map('intval', array_column($forecastData, 'Forecasted_Sales')));
        const ctx = document.getElementById('forecastChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Forecasted Sales',
                    data: data,
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0,123,255,0.1)',
                    fill: true,
                    tension: 0.3,
                    pointRadius: 3,
                    pointBackgroundColor: '#007bff',
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: true },
                    title: { display: false }
                },
                scales: {
                    x: { title: { display: true, text: 'Date' } },
                    y: { title: { display: true, text: 'Forecasted Sales' }, beginAtZero: true }
                }
            }
        });
    });
</script>
@endif
@endpush 