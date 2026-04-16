@extends('layouts.admin')
@section('title', 'Users')
@section('page-title', 'Manage Users')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold">
        <i class="ti ti-users me-2 text-primary"></i>All Users
    </h5>
    <a href="{{ route('admin.users.create') }}"
       class="btn btn-primary btn-sm">
        <i class="ti ti-plus me-1"></i>Add User
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="avatar avatar-sm rounded-circle
                                            bg-primary-subtle text-primary
                                            d-flex align-items-center
                                            justify-content-center fw-bold"
                                     style="width:36px;height:36px;font-size:14px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <strong>{{ $user->name }}</strong>
                                @if($user->id === auth()->id())
                                <span class="badge bg-success-subtle
                                             text-success-emphasis">You</span>
                                @endif
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? '—' }}</td>
                        <td>
                            <span class="badge
                                {{ $user->role === 'admin'    ? 'bg-danger-subtle text-danger-emphasis'   :
                                  ($user->role === 'staff'    ? 'bg-warning-subtle text-warning-emphasis' :
                                   'bg-info-subtle text-info-emphasis') }}">
                                <i class="ti ti-{{
                                    $user->role === 'admin' ? 'shield' :
                                    ($user->role === 'staff' ? 'chef-hat' : 'user')
                                }} me-1"></i>
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td>
                            <small class="text-muted">
                                {{ $user->created_at->format('d M Y') }}
                            </small>
                        </td>
                        <td>
                            <a href="{{ route('admin.users.edit', $user) }}"
                               class="btn btn-sm btn-warning">
                                <i class="ti ti-edit"></i>
                            </a>
                            @if($user->id !== auth()->id())
                            <form method="POST"
                                  action="{{ route('admin.users.destroy', $user) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('Delete {{ $user->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            No users found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection