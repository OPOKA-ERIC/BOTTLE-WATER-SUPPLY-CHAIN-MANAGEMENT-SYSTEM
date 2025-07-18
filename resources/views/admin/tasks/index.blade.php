@extends('layouts.app', ['activePage' => 'task-scheduling', 'title' => 'Task Scheduling'])

@section('content')
<style>
    @media (min-width: 992px) {
        .task-scheduling-content-fix {
            padding-left: 40px !important;
        }
    }
    @media (max-width: 991px) {
        .task-scheduling-content-fix {
            padding-left: 0 !important;
        }
    }
    .task-scheduling-content-fix {
        margin-top: 70px !important;
        min-height: 100vh;
    }
</style>
<div class="container-fluid py-4 task-scheduling-content-fix">
    <!-- Filter/Search Bar -->
    <div class="row mb-4 align-items-end">
        <div class="col-md-2">
            <label>Status</label>
            <select class="form-control" id="filter-status">
                <option value="">All</option>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>
        <div class="col-md-2">
            <label>Priority</label>
            <select class="form-control" id="filter-priority">
                <option value="">All</option>
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
                <option value="urgent">Urgent</option>
            </select>
        </div>
        <div class="col-md-2">
            <label>Assignee</label>
            <input type="text" class="form-control" id="filter-assignee" placeholder="Assignee name">
        </div>
        <div class="col-md-2">
            <label>Due Date</label>
            <input type="date" class="form-control" id="filter-date">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100" id="filter-btn"><i class="fa fa-filter"></i> Filter</button>
        </div>
        <div class="col-md-2 text-end">
            <a href="{{ route('admin.tasks.create') }}" class="btn btn-success shadow"><i class="fa fa-plus"></i> Create Task</a>
        </div>
    </div>

    <!-- Summary Cards & Chart -->
    <div class="row mb-4 g-3">
        <div class="col-md-2">
            <div class="card shadow h-100 border-0 text-center summary-card bg-gradient-primary text-white">
                <div class="card-body">
                    <i class="fa fa-tasks fa-2x mb-2"></i>
                    <h6>Total</h6>
                    <h3>{{ $tasks->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card shadow h-100 border-0 text-center summary-card bg-gradient-success text-white">
                <div class="card-body">
                    <i class="fa fa-check-circle fa-2x mb-2"></i>
                    <h6>Completed</h6>
                    <h3>{{ $tasks->where('status', 'completed')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card shadow h-100 border-0 text-center summary-card bg-gradient-warning text-white">
                <div class="card-body">
                    <i class="fa fa-spinner fa-2x mb-2"></i>
                    <h6>In Progress</h6>
                    <h3>{{ $tasks->where('status', 'in_progress')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card shadow h-100 border-0 text-center summary-card bg-gradient-danger text-white">
                <div class="card-body">
                    <i class="fa fa-hourglass-half fa-2x mb-2"></i>
                    <h6>Pending</h6>
                    <h3>{{ $tasks->where('status', 'pending')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow h-100 border-0">
                <div class="card-body">
                    <canvas id="taskStatusChart" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Widgets -->
    <!-- Removed all dashboard widgets for a cleaner look -->

    @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    <!-- Task Table -->
    <div class="card shadow-lg mt-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle" id="tasks-table">
                    <thead class="thead-light">
                        <tr>
                            <th>Title</th>
                            <th>Assignee</th>
                            <th>Priority</th>
                            <th>Due Date</th>
                            <th>Status</th>
                            <th>Progress</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                        <tr class="align-middle">
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
                            <td>
                                <span class="badge badge-{{ $task->getPriorityColor() }}" data-toggle="tooltip" title="{{ ucfirst($task->priority) }} priority">
                                    <i class="fa fa-flag"></i> {{ ucfirst($task->priority) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-light border">
                                    <i class="fa fa-calendar"></i> {{ $task->due_date ? $task->due_date->format('Y-m-d') : '-' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $task->getStatusColor() }}" data-toggle="tooltip" title="{{ ucfirst(str_replace('_', ' ', $task->status)) }}">
                                    <i class="fa fa-circle"></i> {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                </span>
                            </td>
                            <td style="min-width:120px;">
                                <div class="progress" style="height: 18px;">
                                    <div class="progress-bar bg-info progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $task->progress_percentage ?? 0 }}%" aria-valuenow="{{ $task->progress_percentage ?? 0 }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ $task->progress_percentage ?? 0 }}%
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('admin.tasks.show', $task) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" title="View Details"><i class="fa fa-eye"></i></a>
                                <a href="{{ route('admin.tasks.edit', $task) }}" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Edit Task"><i class="fa fa-edit"></i></a>
                                <form action="{{ route('admin.tasks.destroy', $task) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')" data-toggle="tooltip" title="Delete Task"><i class="fa fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">No tasks scheduled</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Chart.js Pie Chart for Task Status
const ctx = document.getElementById('taskStatusChart').getContext('2d');
new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Completed', 'Pending', 'In Progress'],
        datasets: [{
            data: [
                {{ $tasks->where('status', 'completed')->count() }},
                {{ $tasks->where('status', 'pending')->count() }},
                {{ $tasks->where('status', 'in_progress')->count() }}
            ],
            backgroundColor: [
                '#28a745', // Completed
                '#ffc107', // Pending
                '#17a2b8', // In Progress
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
// Tooltip
$(function () {
  $('[data-toggle="tooltip"]').tooltip();
});
</script>
@endpush
@endsection 