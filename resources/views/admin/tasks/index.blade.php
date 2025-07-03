@extends('layouts.app', ['activePage' => 'task-scheduling', 'title' => 'Task Scheduling'])

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Task Scheduling</h2>
        <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary">+ Create Task</a>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
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
                        <tr>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->assignedTo->name ?? '-' }}</td>
                            <td><span class="badge badge-{{ $task->getPriorityColor() }}">{{ ucfirst($task->priority) }}</span></td>
                            <td>{{ $task->due_date ? $task->due_date->format('Y-m-d') : '-' }}</td>
                            <td><span class="badge badge-{{ $task->getStatusColor() }}">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span></td>
                            <td style="min-width:120px;">
                                <div class="progress" style="height: 18px;">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: {{ $task->progress_percentage ?? 0 }}%" aria-valuenow="{{ $task->progress_percentage ?? 0 }}" aria-valuemin="0" aria-valuemax="100">
                                        {{ $task->progress_percentage ?? 0 }}%
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="{{ route('admin.tasks.show', $task) }}" class="btn btn-sm btn-primary">View</a>
                                <a href="{{ route('admin.tasks.edit', $task) }}" class="btn btn-sm btn-secondary">Edit</a>
                                <form action="{{ route('admin.tasks.destroy', $task) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No tasks scheduled</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 