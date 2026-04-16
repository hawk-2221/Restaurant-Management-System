@extends('layouts.admin')
@section('title', 'Edit Coupon')
@section('page-title', 'Edit Coupon')

@section('content')

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h6 class="mb-0 fw-bold">
                    <i class="ti ti-edit me-2"></i>
                    Edit Coupon: {{ $coupon->code }}
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
                      action="{{ route('admin.coupons.update', $coupon) }}">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Coupon Code *
                            </label>
                            <input type="text" name="code"
                                   class="form-control text-uppercase fw-bold"
                                   value="{{ old('code', $coupon->code) }}"
                                   style="letter-spacing:2px;"
                                   maxlength="20" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Discount Type *
                            </label>
                            <select name="type" class="form-select"
                                    id="typeSelect"
                                    onchange="updateLabel()">
                                <option value="percentage"
                                    {{ $coupon->type === 'percentage'
                                        ? 'selected' : '' }}>
                                    Percentage (%)
                                </option>
                                <option value="fixed"
                                    {{ $coupon->type === 'fixed'
                                        ? 'selected' : '' }}>
                                    Fixed Amount (Rs.)
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold"
                                   id="valueLabel">
                                Discount Value *
                            </label>
                            <input type="number" name="value"
                                   class="form-control"
                                   value="{{ old('value', $coupon->value) }}"
                                   min="1" step="0.01" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Minimum Order (Rs.)
                            </label>
                            <input type="number" name="min_order"
                                   class="form-control"
                                   value="{{ old('min_order', $coupon->min_order) }}"
                                   min="0">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Max Uses
                            </label>
                            <input type="number" name="max_uses"
                                   class="form-control"
                                   value="{{ old('max_uses', $coupon->max_uses) }}"
                                   min="1"
                                   placeholder="Leave empty = unlimited">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Expires At
                            </label>
                            <input type="date" name="expires_at"
                                   class="form-control"
                                   value="{{ old('expires_at',
                                       $coupon->expires_at
                                           ? $coupon->expires_at->format('Y-m-d')
                                           : '') }}">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                Description
                            </label>
                            <input type="text" name="description"
                                   class="form-control"
                                   value="{{ old('description',
                                               $coupon->description) }}"
                                   placeholder="e.g. Weekend discount">
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.coupons.index') }}"
                           class="btn btn-secondary">
                            <i class="ti ti-arrow-left me-1"></i>Back
                        </a>
                        <button type="submit" class="btn btn-warning">
                            <i class="ti ti-device-floppy me-1"></i>
                            Update Coupon
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
function updateLabel() {
    const type = document.getElementById('typeSelect').value;
    document.getElementById('valueLabel').textContent =
        type === 'percentage'
        ? 'Discount Value (%) *'
        : 'Discount Value (Rs.) *';
}
updateLabel();
</script>
@endpush