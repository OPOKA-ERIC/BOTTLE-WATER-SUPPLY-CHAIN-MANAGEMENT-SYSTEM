@extends('layouts.app', ['activePage' => 'task-scheduling', 'title' => 'Create Task'])

@section('content')
<div class="container mt-4">
    <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary mb-3">&larr; Back to Task Scheduling</a>
    <div class="card">
        <div class="card-header bg-primary text-white">Create New Task</div>
        <div class="card-body">
            <form action="{{ route('admin.tasks.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="form-control">
                        <option value="">Select Role</option>
                        <option value="administrator">Administrator</option>
                        <option value="supplier">Supplier</option>
                        <option value="distributor">Distributor</option>
                        <option value="delivery_agent">Delivery Agent</option>
                        <option value="retailer">Retailer</option>
                        <option value="manufacturer">Manufacturer</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="assigned_to">Assignee</label>
                    <select name="assigned_to" id="assigned_to" class="form-control">
                        <option value="auto" selected>Auto-assign (best match)</option>
                        <option value="">Select User</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" data-role="{{ $user->role }}">{{ $user->name }} ({{ ucfirst($user->role) }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="priority">Priority</label>
                    <select name="priority" id="priority" class="form-control" required>
                        @foreach($priorities as $priority)
                            <option value="{{ $priority }}">{{ ucfirst($priority) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="category" id="category" class="form-control" required>
                        @foreach($categories as $category)
                            <option value="{{ $category }}">{{ ucfirst(str_replace('_', ' ', $category)) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="due_date">Due Date</label>
                    <input type="date" name="due_date" id="due_date" class="form-control">
                </div>
                <div class="form-group">
                    <label for="estimated_hours">Estimated Hours</label>
                    <input type="number" name="estimated_hours" id="estimated_hours" class="form-control" min="1">
                </div>
                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" name="location" id="location" class="form-control">
                </div>
                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea name="notes" id="notes" class="form-control" rows="2"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Create Task</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const roleSelect = document.getElementById('role');
        const assigneeSelect = document.getElementById('assigned_to');
        if (roleSelect && assigneeSelect) {
            roleSelect.addEventListener('change', function() {
                const selectedRole = this.value;
                Array.from(assigneeSelect.options).forEach(option => {
                    if (!option.value) return option.style.display = '';
                    option.style.display = (selectedRole === '' || option.getAttribute('data-role') === selectedRole) ? '' : 'none';
                });
                assigneeSelect.value = '';
            });
        }
    });
</script>
@endpush 