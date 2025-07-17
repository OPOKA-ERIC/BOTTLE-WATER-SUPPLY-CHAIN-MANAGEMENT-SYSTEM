@extends('layouts.app', ['activePage' => 'assigned-tasks', 'title' => 'Assigned Tasks'])

@section('content')
<div class="container mt-5 pt-4">
    <div class="row justify-content-center">
        <div class="col-lg-10 col-md-12">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white d-flex align-items-center justify-content-between">
                    <h4 class="mb-0">Assigned Tasks</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Due Date</th>
                                    <th>Update Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tasks as $task)
                                <tr>
                                    <td>{{ $task->title }}</td>
                                    <td>{{ ucfirst($task->status) }}</td>
                                    <td>{{ $task->due_date ? $task->due_date->format('Y-m-d') : '-' }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('manufacturer.tasks.updateStatus', $task) }}" class="d-flex align-items-center gap-2">
                                            @csrf
                                            <select name="status" class="form-control form-select w-auto">
                                                <option value="pending" @selected($task->status == 'pending')>Pending</option>
                                                <option value="in_progress" @selected($task->status == 'in_progress')>In Progress</option>
                                                <option value="completed" @selected($task->status == 'completed')>Completed</option>
                                                <option value="cancelled" @selected($task->status == 'cancelled')>Cancelled</option>
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center">No assigned tasks found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 