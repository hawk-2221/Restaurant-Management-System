@extends('layouts.admin')
@section('title', 'Menu Items')
@section('page-title', 'Menu Items')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 font-weight-bold text-gray-800">
        <i class="fas fa-hamburger mr-2 text-success"></i>All Menu Items
    </h5>
    <a href="{{ route('admin.menu.create') }}"
       class="btn btn-success btn-sm">
        <i class="fas fa-plus mr-1"></i>Add Menu Item
    </a>
</div>

<div class="card shadow">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Available</th>
                        <th>Featured</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menuItems as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            @if($item->image)
                                <img src="{{ asset('storage/'.$item->image) }}"
                                     style="width:50px;height:50px;
                                            object-fit:cover;border-radius:5px;">
                            @else
                                <div style="width:50px;height:50px;
                                            background:#f0f0f0;border-radius:5px;
                                            display:flex;align-items:center;
                                            justify-content:center;">
                                    <i class="fas fa-utensils text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td><strong>{{ $item->name }}</strong></td>
                        <td>
                            <span class="badge badge-primary">
                                {{ $item->category->name }}
                            </span>
                        </td>
                        <td>
                            <strong class="text-success">
                                Rs.{{ number_format($item->price, 0) }}
                            </strong>
                        </td>
                        <td>
                            @if($item->is_available)
                                <span class="badge badge-success">Yes</span>
                            @else
                                <span class="badge badge-danger">No</span>
                            @endif
                        </td>
                        <td>
                            @if($item->is_featured)
                                <span class="badge badge-warning">
                                    <i class="fas fa-star"></i> Yes
                                </span>
                            @else
                                <span class="badge badge-light">No</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.menu.edit', $item) }}"
                               class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST"
                                  action="{{ route('admin.menu.destroy', $item) }}"
                                  class="d-inline"
                                  onsubmit="return confirm('Delete this item?')">
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
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fas fa-hamburger fa-2x mb-2 d-block"></i>
                            No menu items yet.
                            <a href="{{ route('admin.menu.create') }}">
                                Add one now
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection