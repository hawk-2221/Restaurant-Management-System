@extends('layouts.admin')
@section('title', 'Create Coupon')
@section('page-title', 'Create Coupon')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h6 class="mb-0 fw-bold">
                    <i class="ti ti-ticket me-2"></i>New Discount Coupon
                </h6>
            </div>
            <div class="card-body">

                @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $e)
                    <div>{{ $e }}</div>
                    @endforeach
                </div>
                @endif

                <form method="POST"
                      action="{{ route('admin.coupons.store') }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Coupon Code *
                            </label>
                            <div class="input-group">
                                <input type="text" name="code"
                                       class="form-control text-uppercase fw-bold"
                                       value="{{ old('code') }}"
                                       placeholder="e.g. SAVE20"
                                       maxlength="20"
                                       style="letter-spacing:2px;"
                                       required>
                                <button type="button"
                                        class="btn btn-outline-secondary"
                                        onclick="generateCode()">
                                    <i class="ti ti-refresh"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Discount Type *
                            </label>
                            <select name="type" class="form-select"
                                    id="typeSelect"
                                    onchange="updateLabel()">
                                <option value="percentage"
                                    {{ old('type') === 'percentage'
                                        ? 'selected' : '' }}>
                                    Percentage (%)
                                </option>
                                <option value="fixed"
                                    {{ old('type') === 'fixed'
                                        ? 'selected' : '' }}>
                                    Fixed Amount (Rs.)
                                </option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold"
                                   id="valueLabel">
                                Discount Value (%) *
                            </label>
                            <input type="number" name="value"
                                   class="form-control"
                                   value="{{ old('value') }}"
                                   placeholder="e.g. 20"
                                   min="1" step="0.01" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Minimum Order (Rs.)
                            </label>
                            <input type="number" name="min_order"
                                   class="form-control"
                                   value="{{ old('min_order', 0) }}"
                                   placeholder="0 = no minimum"
                                   min="0">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Max Uses
                            </label>
                            <input type="number" name="max_uses"
                                   class="form-control"
                                   value="{{ old('max_uses') }}"
                                   placeholder="Leave empty = unlimited"
                                   min="1">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Expires At
                            </label>
                            <input type="date" name="expires_at"
                                   class="form-control"
                                   value="{{ old('expires_at') }}"
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                Description
                            </label>
                            <input type="text" name="description"
                                   class="form-control"
                                   value="{{ old('description') }}"
                                   placeholder="e.g. 20% off on weekends">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.coupons.index') }}"
                           class="btn btn-secondary">
                            <i class="ti ti-arrow-left me-1"></i>Back
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="ti ti-device-floppy me-1"></i>
                            Create Coupon
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function generateCode() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    let code = '';
    for(let i = 0; i < 8; i++) {
        code += chars.charAt(Math.floor(Math.random() * chars.length));
    }
    document.querySelector('[name="code"]').value = code;
}

function updateLabel() {
    const type = document.getElementById('typeSelect').value;
    document.getElementById('valueLabel').textContent =
        type === 'percentage'
        ? 'Discount Value (%) *'
        : 'Discount Value (Rs.) *';
}
</script>
@endpush