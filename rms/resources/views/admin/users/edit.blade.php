@extends('layouts.admin')
@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom">
                <h6 class="mb-0 fw-bold">
                    <i class="ti ti-user-edit me-2 text-warning"></i>
                    Edit: {{ $user->name }}
                </h6>
            </div>
            <div class="card-body">

                @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $e)
                    <div><i class="ti ti-alert-circle me-1"></i>{{ $e }}</div>
                    @endforeach
                </div>
                @endif

                <form method="POST"
                      action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Full Name *</label>
                        <input type="text" name="name"
                               class="form-control"
                               value="{{ old('name', $user->name) }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email *</label>
                        <input type="email" name="email"
                               class="form-control"
                               value="{{ old('email', $user->email) }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Phone</label>
                        <input type="text" name="phone"
                               class="form-control"
                               value="{{ old('phone', $user->phone) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            New Password
                            <small class="text-muted fw-normal">
                                (leave empty to keep current)
                            </small>
                        </label>
                        <input type="password" name="password"
                               class="form-control"
                               placeholder="Enter new password">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Role *</label>
                        <select name="role" class="form-select" required>
                            <option value="admin"
                                {{ $user->role === 'admin' ? 'selected' : '' }}>
                                Admin
                            </option>
                            <option value="staff"
                                {{ $user->role === 'staff' ? 'selected' : '' }}>
                                Staff / Chef
                            </option>
                            <option value="customer"
                                {{ $user->role === 'customer' ? 'selected' : '' }}>
                                Customer
                            </option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.users.index') }}"
                           class="btn btn-secondary">
                            <i class="ti ti-arrow-left me-1"></i>Back
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="ti ti-device-floppy me-1"></i>
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection