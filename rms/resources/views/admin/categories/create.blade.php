@extends('layouts.admin')
@section('title', 'Add Category')
@section('page-title', 'Add Category')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card shadow">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">
                    <i class="fas fa-plus mr-2"></i>New Category
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
                      action="{{ route('admin.categories.store') }}"
                      enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label class="font-weight-bold">
                            Category Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name"
                               class="form-control"
                               value="{{ old('name') }}"
                               placeholder="e.g. Starters, Main Course"
                               required>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Image</label>
                        <input type="file" name="image"
                               class="form-control-file"
                               accept="image/*">
                        <small class="text-muted">Optional. JPG, PNG.</small>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" name="is_active"
                                   class="custom-control-input"
                                   id="is_active"
                                   value="1" checked>
                            <label class="custom-control-label"
                                   for="is_active">Active</label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.categories.index') }}"
                           class="btn btn-secondary">
                            <i class="fas fa-arrow-left mr-1"></i>Back
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i>Save Category
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection