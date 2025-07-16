@extends('layouts.app', ['activePage' => 'work-distribution', 'title' => 'Work Distribution'])

@section('content')
<div class="container mt-5 pt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Work Distribution</h2>
        <a href="{{ route('admin.work-distribution.create') }}" class="btn btn-primary">+ Create Work Distribution</a>
    </div>
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">Current Work Distribution</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="thead-light">
                        <tr>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Assigned Task</th>
                            <th>Status</th>
                            <th>Due Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>Opoka Eric</td><td><span class="badge badge-info">Manufacturer</span></td><td>Supervise bottling line A</td><td><span class="badge badge-warning">In Progress</span></td><td>2025-07-05</td><td><a href="#" class="btn btn-sm btn-primary">View</a> <a href="#" class="btn btn-sm btn-secondary">Edit</a></td></tr>
                        <tr><td>Namuganza Isabella</td><td><span class="badge badge-info">Manufacturer</span></td><td>Quality assurance for batch #210</td><td><span class="badge badge-secondary">Pending</span></td><td>2025-07-06</td><td><a href="#" class="btn btn-sm btn-primary">View</a> <a href="#" class="btn btn-sm btn-secondary">Edit</a></td></tr>
                        <tr><td>Nalumasi Joyce</td><td><span class="badge badge-success">Supplier</span></td><td>Deliver raw PET bottles</td><td><span class="badge badge-success">Completed</span></td><td>2025-07-02</td><td><a href="#" class="btn btn-sm btn-primary">View</a> <a href="#" class="btn btn-sm btn-secondary">Edit</a></td></tr>
                        <tr><td>Brian</td><td><span class="badge badge-primary">Retailer</span></td><td>Manage retail order #601</td><td><span class="badge badge-warning">In Progress</span></td><td>2025-07-07</td><td><a href="#" class="btn btn-sm btn-primary">View</a> <a href="#" class="btn btn-sm btn-secondary">Edit</a></td></tr>
                        <tr><td>tukahebwa ritah</td><td><span class="badge badge-dark">Administrator</span></td><td>Oversee daily operations</td><td><span class="badge badge-warning">In Progress</span></td><td>2025-07-05</td><td><a href="#" class="btn btn-sm btn-primary">View</a> <a href="#" class="btn btn-sm btn-secondary">Edit</a></td></tr>
                        <tr><td>Michael Chen</td><td><span class="badge badge-info">Manufacturer</span></td><td>Monitor water purification</td><td><span class="badge badge-secondary">Pending</span></td><td>2025-07-06</td><td><a href="#" class="btn btn-sm btn-primary">View</a> <a href="#" class="btn btn-sm btn-secondary">Edit</a></td></tr>
                        <tr><td>David Thompson</td><td><span class="badge badge-success">Supplier</span></td><td>Coordinate cap delivery</td><td><span class="badge badge-warning">In Progress</span></td><td>2025-07-05</td><td><a href="#" class="btn btn-sm btn-primary">View</a> <a href="#" class="btn btn-sm btn-secondary">Edit</a></td></tr>
                        <tr><td>Lisa Anderson</td><td><span class="badge badge-primary">Retailer</span></td><td>Stock new mineral water batch</td><td><span class="badge badge-secondary">Pending</span></td><td>2025-07-08</td><td><a href="#" class="btn btn-sm btn-primary">View</a> <a href="#" class="btn btn-sm btn-secondary">Edit</a></td></tr>
                        <tr><td>James Wilson</td><td><span class="badge badge-success">Supplier</span></td><td>Transport finished goods to warehouse</td><td><span class="badge badge-warning">In Progress</span></td><td>2025-07-06</td><td><a href="#" class="btn btn-sm btn-primary">View</a> <a href="#" class="btn btn-sm btn-secondary">Edit</a></td></tr>
                        <tr><td>Amanda Foster</td><td><span class="badge badge-primary">Retailer</span></td><td>Customer support for order #601</td><td><span class="badge badge-success">Completed</span></td><td>2025-07-02</td><td><a href="#" class="btn btn-sm btn-primary">View</a> <a href="#" class="btn btn-sm btn-secondary">Edit</a></td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 