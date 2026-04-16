@extends('layouts.admin')
@section('title', 'Categories')
@section('page-title', 'Menu Categories')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 font-weight-bold text-gray-800">
        <i class="fas fa-list mr-2 text-primary"></i>All Categories
    </h5>
    <a href="{{ route('admin.categories.create') }}"
       class="btn btn-primary btn-sm">
        <i class="fas fa-plus mr-1"></i> Add Category
    </a>
</div>

<div class="card shadow">
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Items Count</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <strong>{{ $category->name }}</strong>
                    </td>
                    <td>
                        <span class="badge badge-info">
                            {{ $category->menu_items_count }} items
                        </span>
                    </td>
                    <td>
                        @if($category->is_active)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-secondary">Inactive</span>
                        @endif
                    </td>
                    <td>{{ $category->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('admin.categories.edit', $category) }}"
                           class="btn btn-sm btn-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST"
                              action="{{ route('admin.categories.destroy', $category) }}"
                              class="d-inline"
                              onsubmit="return confirm('Delete this category?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        <i class="fas fa-list fa-2x mb-2 d-block"></i>
                        No categories yet.
                        <a href="{{ route('admin.categories.create') }}">
                            Add one now
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection