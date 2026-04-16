@extends('layouts.admin')
@section('title', 'Edit Category')
@section('page-title', 'Edit Category')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-warning">
                    <i class="fas fa-edit mr-2"></i>Edit Category
                </h6>
            </div>
            <div class="card-body">

                @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
                @endif

                <form method="POST"
                      action="{{ route('admin.categories.update', $category) }}"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label class="font-weight-bold">
                            Category Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name"
                               class="form-control"
                               value="{{ old('name', $category->name) }}"
                               required>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Image</label>
                        @if($category->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/'.$category->image) }}"
                                     style="height:80px; object-fit:cover;"
                                     class="img-thumbnail">
                            </div>
                        @endif
                        <input type="file" name="image"
                               class="form-control-file"
                               accept="image/*">
                        <small class="text-muted">
                            Leave empty to keep current image.
                        </small>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="is_active"
                                   class="custom-control-input"
                                   id="is_active" value="1"
                                   {{ $category->is_active ? 'checked' : '' }}>
                            <label class="custom-control-label"
                                   for="is_active">Active</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.categories.index') }}"
                           class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i>Back
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save mr-1"></i>Update Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection