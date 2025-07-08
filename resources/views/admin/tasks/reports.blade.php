@extends('layouts.app', ['activePage' => 'task-scheduling', 'title' => 'Task Reports'])

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Task Reports</h2>
        <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary">Back to Task Scheduling</a>
    </div>
    <div class="row mb-4">
        <div class="col-md-2 mb-2">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Completed</h5>
                    <span class="badge badge-success" style="font-size:1.2rem;">{{ $completed }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-2">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Pending</h5>
                    <span class="badge badge-warning" style="font-size:1.2rem;">{{ $pending }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-2">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">In Progress</h5>
                    <span class="badge badge-info" style="font-size:1.2rem;">{{ $inProgress }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-2">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Overdue</h5>
                    <span class="badge badge-danger" style="font-size:1.2rem;">{{ $overdue }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-2">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Recurring</h5>
                    <span class="badge badge-primary" style="font-size:1.2rem;">{{ $recurring }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-2 mb-2">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Total</h5>
                    <span class="badge badge-dark" style="font-size:1.2rem;">{{ $total }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-primary text-white">All Tasks</div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0 align-middle">
                <thead class="thead-light">
                    <tr>
                        <th>Title</th>
                        <th>Assignee</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Progress</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                    <tr>
                        <td>{{ $task->title }}</td>
                        <td>{{ $task->assignedTo->name ?? '-' }}</td>
                        <td><span class="badge badge-{{ $task->getStatusColor() }}">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span></td>
                        <td>{{ $task->due_date ? $task->due_date->format('Y-m-d') : '-' }}</td>
                        <td style="min-width:120px;">
                            <div class="progress" style="height: 18px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: {{ $task->progress_percentage ?? 0 }}%" aria-valuenow="{{ $task->progress_percentage ?? 0 }}" aria-valuemin="0" aria-valuemax="100">
                                    {{ $task->progress_percentage ?? 0 }}%
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No tasks found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 