@extends('layouts.app', ['activePage' => 'work-distribution', 'title' => 'Work Distribution Report'])

@section('content')
<div class="container mt-5 pt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><i class="nc-icon nc-chart-bar-32 text-primary"></i> Work Distribution Report</h2>
        <a href="{{ route('admin.work-distribution.index') }}" class="btn btn-secondary">Back to Work Distribution</a>
    </div>
    <!-- Summary Bar -->
    <div class="row mb-4">
        <div class="col-md-2 mb-2">
            <div class="card text-center bg-primary text-white shadow">
                <div class="card-body">
                    <h5 class="card-title">Total</h5>
                    <span class="badge badge-light" style="font-size:1.2rem;">{{ $stats['total'] }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-2">
            <div class="card text-center bg-success text-white shadow">
                <div class="card-body">
                    <h5 class="card-title">Completed</h5>
                    <span class="badge badge-light" style="font-size:1.2rem;">{{ $stats['completed'] }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-2">
            <div class="card text-center bg-warning text-white shadow">
                <div class="card-body">
                    <h5 class="card-title">In Progress</h5>
                    <span class="badge badge-light" style="font-size:1.2rem;">{{ $stats['in_progress'] }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-2">
            <div class="card text-center bg-danger text-white shadow">
                <div class="card-body">
                    <h5 class="card-title">Overdue</h5>
                    <span class="badge badge-light" style="font-size:1.2rem;">{{ $stats['overdue'] }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-2">
            <div class="card text-center bg-secondary text-white shadow">
                <div class="card-body">
                    <h5 class="card-title">Pending</h5>
                    <span class="badge badge-light" style="font-size:1.2rem;">{{ $stats['pending'] }}</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Pie Chart for Status Distribution -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-info text-white">Task Status Distribution</div>
                <div class="card-body text-center">
                    <div style="display:inline-block;width:50%;max-width:200px;">
                        <canvas id="taskStatusChart" width="150" height="40"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Table of All Tasks -->
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">All Tasks</div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead class="thead-light">
                    <tr>
                        <th>Title</th>
                        <th>Assignee</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Category</th>
                        <th>Progress</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                    <tr>
                        <td>
                            <span class="fw-bold">{{ $task->title }}</span>
                            <br>
                            <small class="text-muted">{{ Str::limit($task->description, 40) }}</small>
                        </td>
                        <td>
                            @if($task->assignedTo)
                                <div class="d-flex align-items-center gap-2">
                                    <div class="avatar bg-info text-white rounded-circle text-center" style="width:32px;height:32px;line-height:32px;font-weight:bold;">
                                        {{ strtoupper(substr($task->assignedTo->name,0,1)) }}
                                    </div>
                                    <span>{{ $task->assignedTo->name }}</span>
                                </div>
                            @else
                                <span class="badge badge-secondary">Unassigned</span>
                            @endif
                        </td>
                        <td><span class="badge badge-{{ $task->getStatusColor() }}" data-toggle="tooltip" title="{{ ucfirst(str_replace('_', ' ', $task->status)) }}">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span></td>
                        <td><span class="badge badge-light border"><i class="fa fa-calendar"></i> {{ $task->due_date ? $task->due_date->format('Y-m-d') : '-' }}</span></td>
                        <td>{{ $task->category }}</td>
                        <td style="min-width:120px;">
                            <div class="progress" style="height: 18px;">
                                <div class="progress-bar bg-info progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $task->progress_percentage ?? 0 }}%" aria-valuenow="{{ $task->progress_percentage ?? 0 }}" aria-valuemin="0" aria-valuemax="100">
                                    {{ $task->progress_percentage ?? 0 }}%
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No tasks found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('taskStatusChart').getContext('2d');
    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Completed', 'Pending', 'In Progress', 'Overdue'],
            datasets: [{
                data: [{{ $stats['completed'] }}, {{ $stats['pending'] }}, {{ $stats['in_progress'] }}, {{ $stats['overdue'] }}],
                backgroundColor: [
                    '#28a745', // Completed
                    '#ffc107', // Pending
                    '#17a2b8', // In Progress
                    '#dc3545', // Overdue
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                },
                tooltip: {
                    enabled: true
                }
            }
        }
    });
    $(function () {
      $('[data-toggle="tooltip"]').tooltip();
    });
</script>
@endpush
@endsection 