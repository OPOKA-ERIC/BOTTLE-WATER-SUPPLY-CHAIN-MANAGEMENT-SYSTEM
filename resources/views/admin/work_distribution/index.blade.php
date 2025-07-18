@extends('layouts.app', ['activePage' => 'work-distribution', 'title' => 'Work Distribution'])

@section('content')
<div class="container-fluid py-4">
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
            <label>Category</label>
            <input type="text" class="form-control" id="filter-category" placeholder="Category">
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
            <a href="{{ route('admin.work-distribution.create') }}" class="btn btn-success shadow"><i class="fa fa-plus"></i> Create Work Distribution</a>
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
                    <canvas id="assignmentChart" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Widgets -->
    <!-- Removed all dashboard widgets for a cleaner look -->

    <!-- Assignment Table -->
    <div class="card shadow-lg mt-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle" id="work-distribution-table">
                    <thead class="thead-light">
                        <tr>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Assigned Task</th>
                            <th>Status</th>
                            <th>Due Date</th>
                            <th>Assignment Method</th>
                            <th>Assignment Reason</th>
                            <th>History</th>
                            <th>Acknowledged</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tasks as $task)
                        <tr class="align-middle">
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
                                @if($task->assignedTo)
                                    <span class="badge badge-info">{{ ucfirst($task->assignedTo->role) }}</span>
                                @else
                                    <span class="badge badge-secondary">N/A</span>
                                @endif
                            </td>
                            <td>
                                <span class="fw-bold">{{ $task->title }}</span>
                                <br>
                                <small class="text-muted">{{ Str::limit($task->description, 40) }}</small>
                            </td>
                            <td>
                                <span class="badge badge-{{ $task->getStatusColor() }}" data-toggle="tooltip" title="{{ ucfirst($task->status) }}">
                                    <i class="fa fa-circle"></i> {{ ucfirst($task->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-light border">
                                    <i class="fa fa-calendar"></i> {{ $task->due_date ? $task->due_date->format('Y-m-d') : 'N/A' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-info" data-toggle="tooltip" title="Auto-assigned by system using workload, role, and availability">{{ ucfirst($task->assignment_method ?? 'auto') }}</span>
                            </td>
                            <td>
                                <small>{{ $task->assignment_reason }}</small>
                            </td>
                            <td>
                                <small>
                                    <strong>Assigned:</strong> {{ $task->created_at->format('Y-m-d H:i') }}<br>
                                    <strong>By:</strong> System (Auto)<br>
                                    <strong>Method:</strong> {{ ucfirst($task->assignment_method ?? 'auto') }}<br>
                                    <strong>Reason:</strong> {{ $task->assignment_reason }}
                                </small>
                            </td>
                            <td>
                                @if($task->is_read)
                                    <span class="badge badge-success">Yes</span>
                                @elseif(auth()->id() === $task->assigned_to)
                                    <form method="POST" action="{{ route('admin.work-distribution.acknowledge', $task->id) }}" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">Acknowledge</button>
                                    </form>
                                @else
                                    <span class="badge badge-secondary">No</span>
                                @endif
                            </td>
                            <td>
                                @if($task->assignedTo)
                                    <small class="text-muted">{{ $task->assignedTo->getActiveTasksCount() }} active tasks</small>
                                @endif
                                <br>
                                <a href="{{ route('admin.work-distribution.history', $task->id) }}" class="btn btn-sm btn-info" data-toggle="tooltip" title="View Assignment History"><i class="fa fa-history"></i></a>
                                <a href="#" class="btn btn-sm btn-primary" data-toggle="tooltip" title="View Task"><i class="fa fa-eye"></i></a>
                                <a href="#" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Edit Task"><i class="fa fa-edit"></i></a>
                                <!-- Status Change Form -->
                                <form method="POST" action="{{ route('admin.work-distribution.updateStatus', $task->id) }}" style="display:inline;">
                                    @csrf
                                    <select name="new_status" class="form-control form-control-sm d-inline w-auto" style="min-width:120px;display:inline-block;" onchange="if(confirm('Change status?')) this.form.submit();">
                                        <option value="pending" @if($task->status=='pending') selected @endif>Pending</option>
                                        <option value="in_progress" @if($task->status=='in_progress') selected @endif>In Progress</option>
                                        <option value="completed" @if($task->status=='completed') selected @endif>Completed</option>
                                        <option value="cancelled" @if($task->status=='cancelled') selected @endif>Cancelled</option>
                                    </select>
                                    <input type="text" name="reason" class="form-control form-control-sm d-inline w-auto" style="min-width:120px;display:inline-block;" placeholder="Reason (optional)">
                                </form>
                                <form method="POST" action="{{ route('admin.work-distribution.destroy', $task->id) }}" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Delete Task"><i class="fa fa-trash"></i></button>
                                </form>
                                <!-- Reassign Button -->
                                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#reassignModal-{{ $task->id }}" data-toggle="tooltip" title="Reassign Task"><i class="fa fa-exchange"></i></button>
                                <!-- Reassign Modal -->
                                <div class="modal fade" id="reassignModal-{{ $task->id }}" tabindex="-1" role="dialog" aria-labelledby="reassignModalLabel-{{ $task->id }}" aria-hidden="true">
                                  <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                      <form method="POST" action="{{ route('admin.work-distribution.reassign', $task->id) }}">
                                        @csrf
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="reassignModalLabel-{{ $task->id }}">Reassign Task: {{ $task->title }}</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          <div class="form-group">
                                            <label for="new_assigned_to_{{ $task->id }}">Select New Assignee</label>
                                            <select class="form-control" id="new_assigned_to_{{ $task->id }}" name="new_assigned_to" required>
                                              <option value="">Select User</option>
                                              @foreach(\App\Models\User::where('role', '!=', 'administrator')->where('status', 'active')->get() as $user)
                                                <option value="{{ $user->id }}" @if($user->id == $task->assigned_to) disabled @endif>{{ $user->name }} ({{ ucfirst($user->role) }})</option>
                                              @endforeach
                                            </select>
                                          </div>
                                          <div class="form-group">
                                            <label for="reason_{{ $task->id }}">Reason (optional)</label>
                                            <input type="text" class="form-control" id="reason_{{ $task->id }}" name="reason" maxlength="255">
                                          </div>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                          <button type="submit" class="btn btn-warning">Reassign</button>
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">No tasks found.</td>
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
// Chart.js Bar Chart for Assignments by Role
const ctx = document.getElementById('assignmentChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [
            @foreach($tasks->groupBy(fn($t) => $t->assignedTo->role ?? 'Unassigned') as $role => $group)
                '{{ ucfirst($role) }}',
            @endforeach
        ],
        datasets: [{
            label: 'Assignments',
            data: [
                @foreach($tasks->groupBy(fn($t) => $t->assignedTo->role ?? 'Unassigned') as $role => $group)
                    {{ $group->count() }},
                @endforeach
            ],
            backgroundColor: [
                '#007bff', '#28a745', '#ffc107', '#17a2b8', '#dc3545', '#6c757d', '#6610f2', '#fd7e14'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                enabled: true
            }
        },
        scales: {
            y: {
                beginAtZero: true
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