@extends('layouts.app', ['activePage' => 'task-scheduling', 'title' => 'Edit Task'])

@section('content')
<div class="container mt-4">
    <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary mb-3">&larr; Back to Task Scheduling</a>
    <div class="card">
        <div class="card-header bg-primary text-white">Edit Task</div>
        <div class="card-body">
            <form action="{{ route('admin.tasks.update', $task) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" class="form-control" value="{{ $task->title }}" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="3" required>{{ $task->description }}</textarea>
                </div>
                <div class="form-group">
                    <label for="assigned_to">Assignee</label>
                    <select name="assigned_to" id="assigned_to" class="form-control" required>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" @if($task->assigned_to == $user->id) selected @endif>{{ $user->name }} ({{ ucfirst($user->role) }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="priority">Priority</label>
                    <select name="priority" id="priority" class="form-control" required>
                        @foreach($priorities as $priority)
                            <option value="{{ $priority }}" @if($task->priority == $priority) selected @endif>{{ ucfirst($priority) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category" id="category" class="form-control" required>
                        @foreach($categories as $category)
                            <option value="{{ $category }}" @if($task->category == $category) selected @endif>{{ ucfirst(str_replace('_', ' ', $category)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" @if($task->status == $status) selected @endif>{{ ucfirst(str_replace('_', ' ', $status)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="due_date">Due Date</label>
                    <input type="date" name="due_date" id="due_date" class="form-control" value="{{ $task->due_date ? $task->due_date->format('Y-m-d') : '' }}">
                </div>
                <div class="form-group">
                    <label for="estimated_hours">Estimated Hours</label>
                    <input type="number" name="estimated_hours" id="estimated_hours" class="form-control" min="1" value="{{ $task->estimated_hours }}">
                </div>
                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" name="location" id="location" class="form-control" value="{{ $task->location }}">
                </div>
                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea name="notes" id="notes" class="form-control" rows="2">{{ $task->notes }}</textarea>
                </div>
                <div class="form-group">
                    <label for="progress_percentage">Progress (%)</label>
                    <input type="number" name="progress_percentage" id="progress_percentage" class="form-control" min="0" max="100" value="{{ $task->progress_percentage ?? 0 }}">
                </div>
                <button type="submit" class="btn btn-primary">Update Task</button>
            </form>
        </div>
    </div>
</div>
@endsection 