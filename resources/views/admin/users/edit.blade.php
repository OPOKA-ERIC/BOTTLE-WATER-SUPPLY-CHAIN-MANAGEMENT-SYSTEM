@extends('layouts.app', [
    'activePage' => 'user-management',
    'title' => 'Edit User - BWSCMS',
    'navName' => 'User Management'
])

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">Edit User</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('user.update', $user) }}">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password <small>(leave blank to keep current)</small></label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="administrator" @if($user->role == 'administrator') selected @endif>Administrator</option>
                                <option value="manufacturer" @if($user->role == 'manufacturer') selected @endif>Manufacturer</option>
                                <option value="supplier" @if($user->role == 'supplier') selected @endif>Supplier</option>
                                <option value="retailer" @if($user->role == 'retailer') selected @endif>Retailer</option>
                                <option value="vendor" @if($user->role == 'vendor') selected @endif>Vendor</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="active" @if($user->status == 'active') selected @endif>Active</option>
                                <option value="inactive" @if($user->status == 'inactive') selected @endif>Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Update User</button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 