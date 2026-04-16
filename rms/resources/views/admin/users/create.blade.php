@extends('layouts.admin')
@section('title', 'Add User')
@section('page-title', 'Add User')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom">
                <h6 class="mb-0 fw-bold">
                    <i class="ti ti-user-plus me-2 text-primary"></i>
                    Create New User
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

                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Full Name *</label>
                        <input type="text" name="name"
                               class="form-control"
                               value="{{ old('name') }}"
                               placeholder="e.g. Ali Hassan"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email *</label>
                        <input type="email" name="email"
                               class="form-control"
                               value="{{ old('email') }}"
                               placeholder="e.g. ali@rms.com"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Phone</label>
                        <input type="text" name="phone"
                               class="form-control"
                               value="{{ old('phone') }}"
                               placeholder="+92 300 1234567">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password *</label>
                        <input type="password" name="password"
                               class="form-control"
                               placeholder="Min 6 characters"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Role *</label>
                        <select name="role" class="form-select" required>
                            <option value="">-- Select Role --</option>
                            <option value="admin"
                                {{ old('role') === 'admin' ? 'selected' : '' }}>
                                Admin
                            </option>
                            <option value="staff"
                                {{ old('role') === 'staff' ? 'selected' : '' }}>
                                Staff / Chef
                            </option>
                            <option value="customer"
                                {{ old('role') === 'customer' ? 'selected' : '' }}>
                                Customer
                            </option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.users.index') }}"
                           class="btn btn-secondary">
                            <i class="ti ti-arrow-left me-1"></i>Back
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i>
                            Create User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection