@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">User Management</h4>
                    <p class="card-category">Manage all system users</p>
                </div>
                <div class="card-body">
                    @if($users->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-primary rounded-circle d-flex align-items-center justify-content-center me-3">
                                                        <span class="text-white font-weight-bold">
                                                            {{ substr($user->name, 0, 1) }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">{{ $user->name }}</h6>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <span class="badge badge-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'manufacturer' ? 'info' : ($user->role === 'supplier' ? 'warning' : ($user->role === 'retailer' ? 'success' : 'secondary'))) }}">
                                                    {{ ucfirst($user->role) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-{{ $user->status === 'active' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($user->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#viewUserModal{{ $user->id }}">
                                                        <i class="nc-icon nc-zoom-split"></i> View
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editUserModal{{ $user->id }}">
                                                        <i class="nc-icon nc-settings-gear-65"></i> Edit
                                                    </button>
                                                    @if($user->status === 'active')
                                                        <button type="button" class="btn btn-sm btn-danger" onclick="deactivateUser({{ $user->id }})">
                                                            <i class="nc-icon nc-simple-remove"></i> Deactivate
                                                        </button>
                                                    @else
                                                        <button type="button" class="btn btn-sm btn-success" onclick="activateUser({{ $user->id }})">
                                                            <i class="nc-icon nc-check-2"></i> Activate
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-3">
                            @if($users->hasPages())
                                <nav aria-label="User management pagination">
                                    <ul class="pagination pagination-sm mb-0">
                                        {{-- Previous Page Link --}}
                                        @if ($users->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">‹</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $users->previousPageUrl() }}">‹</a>
                                            </li>
                                        @endif
                                        {{-- Pagination Elements --}}
                                        @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                                            @if ($page == $users->currentPage())
                                                <li class="page-item active">
                                                    <span class="page-link">{{ $page }}</span>
                                                </li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                                </li>
                                            @endif
                                        @endforeach
                                        {{-- Next Page Link --}}
                                        @if ($users->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $users->nextPageUrl() }}">›</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link">›</span>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-4">
                            <h4>No Users Found</h4>
                            <p class="text-muted">No users have been registered yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- User View Modals -->
@foreach($users as $user)
<div class="modal fade" id="viewUserModal{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="viewUserModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewUserModalLabel{{ $user->id }}">User Details - {{ $user->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Basic Information</h6>
                        <p><strong>Name:</strong> {{ $user->name }}</p>
                        <p><strong>Email:</strong> {{ $user->email }}</p>
                        <p><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
                        <p><strong>Status:</strong> {{ ucfirst($user->status) }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Account Information</h6>
                        <p><strong>Created:</strong> {{ $user->created_at->format('M d, Y H:i') }}</p>
                        <p><strong>Last Updated:</strong> {{ $user->updated_at->format('M d, Y H:i') }}</p>
                        <p><strong>Email Verified:</strong> {{ $user->email_verified_at ? 'Yes' : 'No' }}</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

@push('css')
<style>
.avatar-sm {
    width: 40px;
    height: 40px;
    font-size: 16px;
}
/* Match pagination arrow size to vendor applications page */
.pagination .page-link {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
}
</style>
@endpush

@push('js')
<script>
function deactivateUser(userId) {
    if (confirm('Are you sure you want to deactivate this user?')) {
        // Add AJAX call to deactivate user
        console.log('Deactivating user:', userId);
    }
}

function activateUser(userId) {
    if (confirm('Are you sure you want to activate this user?')) {
        // Add AJAX call to activate user
        console.log('Activating user:', userId);
    }
}
</script>
@endpush 