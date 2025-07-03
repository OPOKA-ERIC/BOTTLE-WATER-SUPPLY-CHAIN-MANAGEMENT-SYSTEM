@extends('layouts.app', ['activePage' => 'task-scheduling', 'title' => 'Task Details'])

@section('content')
<div class="container mt-4">
    <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary mb-3">&larr; Back to Task Scheduling</a>
    <div class="card">
        <div class="card-header bg-primary text-white">Task Details</div>
        <div class="card-body">
            <h4>{{ $task->title }}</h4>
            <p><strong>Description:</strong> {{ $task->description }}</p>
            <p><strong>Assignee:</strong> {{ $task->assignedTo->name ?? '-' }} ({{ ucfirst($task->assignedTo->role ?? '-') }})</p>
            <p><strong>Priority:</strong> <span class="badge badge-{{ $task->getPriorityColor() }}">{{ ucfirst($task->priority) }}</span></p>
            <p><strong>Status:</strong> <span class="badge badge-{{ $task->getStatusColor() }}">{{ ucfirst(str_replace('_', ' ', $task->status)) }}</span></p>
            <p><strong>Category:</strong> {{ ucfirst(str_replace('_', ' ', $task->category)) }}</p>
            <p><strong>Due Date:</strong> {{ $task->due_date ? $task->due_date->format('Y-m-d') : '-' }}</p>
            <p><strong>Estimated Hours:</strong> {{ $task->estimated_hours ?? '-' }}</p>
            <p><strong>Location:</strong> {{ $task->location ?? '-' }}</p>
            <p><strong>Notes:</strong> {{ $task->notes ?? '-' }}</p>
            <p><strong>Progress:</strong></p>
            <div class="progress mb-3" style="height: 24px;">
                <div class="progress-bar bg-info" role="progressbar" style="width: {{ $task->progress_percentage ?? 0 }}%" aria-valuenow="{{ $task->progress_percentage ?? 0 }}" aria-valuemin="0" aria-valuemax="100">
                    {{ $task->progress_percentage ?? 0 }}%
                </div>
            </div>
            <div class="mt-3">
                <a href="{{ route('admin.tasks.edit', $task) }}" class="btn btn-secondary">Edit Task</a>
            </div>
        </div>
    </div>
</div>
@endsection 