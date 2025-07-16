@extends('layouts.app')

@section('content')
<div class="container-fluid" style="margin-top: 90px; min-height: 80vh;">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Customer Segment Summary</h4>
                </div>
                <div class="card-body">
                    @if(isset($summary) && count($summary) > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Segment</th>
                                        <th>Avg Quantity</th>
                                        <th>Avg Total Amount</th>
                                        <th>Avg Age</th>
                                        <th>Most Common Gender</th>
                                        <th>Num Customers</th>
                                        <th>Segment Profile</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($summary as $segment => $data)
                                        <tr>
                                            <td>{{ $segment }}</td>
                                            <td>{{ number_format($data['avg_quantity'], 2) }}</td>
                                            <td>{{ number_format($data['avg_amount'], 2) }}</td>
                                            <td>{{ number_format($data['avg_age'], 1) }}</td>
                                            <td>{{ $data['most_common_gender'] }}</td>
                                            <td>{{ $data['count'] }}</td>
                                            <td>
                                                @php
                                                    $profile = '';
                                                    if ($data['avg_amount'] > 1000) {
                                                        $profile = 'High spenders, moderate quantity, mostly ' . strtolower($data['most_common_gender']);
                                                    } elseif ($data['avg_amount'] > 200 && $data['avg_age'] > 50) {
                                                        $profile = 'Older, high spend, low quantity, mostly ' . strtolower($data['most_common_gender']);
                                                    } elseif ($data['avg_amount'] > 200 && $data['avg_age'] < 35) {
                                                        $profile = 'Young, low quantity, higher spend, mostly ' . strtolower($data['most_common_gender']);
                                                    } else {
                                                        $profile = 'Moderate buyers, middle-aged, mostly ' . strtolower($data['most_common_gender']);
                                                    }
                                                @endphp
                                                {{ $profile }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning mt-5">
                            No segment summary data available.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 