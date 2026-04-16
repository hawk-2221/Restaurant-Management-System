@extends('layouts.admin')
@section('title', 'Coupons')
@section('page-title', 'Coupon Management')

@section('content')

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="mb-0 fw-bold">
        <i class="ti ti-ticket me-2 text-warning"></i>
        Discount Coupons
    </h5>
    <a href="{{ route('admin.coupons.create') }}"
       class="btn btn-warning btn-sm">
        <i class="ti ti-plus me-1"></i>New Coupon
    </a>
</div>

<!-- Stats -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="fs-2 fw-bold text-primary">
                {{ $coupons->count() }}
            </div>
            <div class="text-muted small">Total Coupons</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="fs-2 fw-bold text-success">
                {{ $coupons->where('is_active', true)->count() }}
            </div>
            <div class="text-muted small">Active</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="fs-2 fw-bold text-info">
                {{ $coupons->sum('used_count') }}
            </div>
            <div class="text-muted small">Total Used</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="fs-2 fw-bold text-danger">
                {{ $coupons->where('is_active', false)->count() }}
            </div>
            <div class="text-muted small">Inactive</div>
        </div>
    </div>
</div>

<!-- Coupons Table -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Discount</th>
                        <th>Min Order</th>
                        <th>Usage</th>
                        <th>Expires</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($coupons as $coupon)
                    <tr>
                        <td>
                            <span class="badge bg-dark px-3 py-2
                                         font-monospace fs-6">
                                {{ $coupon->code }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-secondary-subtle
                                         text-secondary-emphasis">
                                {{ ucfirst($coupon->type) }}
                            </span>
                        </td>
                        <td>
                            <span class="fw-bold text-warning">
                                @if($coupon->type === 'percentage')
                                    {{ $coupon->value }}% OFF
                                @else
                                    Rs.{{ number_format($coupon->value, 0) }} OFF
                                @endif
                            </span>
                        </td>
                        <td>
                            Rs.{{ number_format($coupon->min_order, 0) }}
                        </td>
                        <td>
                            <span class="text-muted">
                                {{ $coupon->used_count }}
                                /
                                {{ $coupon->max_uses ?? '∞' }}
                            </span>
                        </td>
                        <td>
                            @if($coupon->expires_at)
                                <span class="{{
                                    $coupon->expires_at->isPast()
                                    ? 'text-danger' : 'text-muted'
                                }} small">
                                    {{ $coupon->expires_at->format('d M Y') }}
                                    @if($coupon->expires_at->isPast())
                                        <br><small>(Expired)</small>
                                    @endif
                                </span>
                            @else
                                <span class="text-muted small">Never</span>
                            @endif
                        </td>
                        <td>
                            @if($coupon->is_active && $coupon->isValid())
                                <span class="badge bg-success-subtle
                                             text-success-emphasis">
                                    <i class="ti ti-check me-1"></i>Active
                                </span>
                            @else
                                <span class="badge bg-danger-subtle
                                             text-danger-emphasis">
                                    <i class="ti ti-x me-1"></i>Inactive
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <!-- Toggle -->
                                <form method="POST"
                                      action="{{ route('admin.coupons.toggle',
                                                      $coupon) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                            class="btn btn-sm {{
                                                $coupon->is_active
                                                ? 'btn-outline-warning'
                                                : 'btn-outline-success'
                                            }}"
                                            title="{{ $coupon->is_active
                                                ? 'Disable' : 'Enable' }}">
                                        <i class="ti ti-{{
                                            $coupon->is_active
                                            ? 'toggle-right'
                                            : 'toggle-left'
                                        }}"></i>
                                    </button>
                                </form>

                                <!-- Edit -->
                                <a href="{{ route('admin.coupons.edit',
                                                  $coupon) }}"
                                   class="btn btn-sm btn-outline-primary">
                                    <i class="ti ti-edit"></i>
                                </a>

                                <!-- Delete -->
                                <form method="POST"
                                      action="{{ route('admin.coupons.destroy',
                                                      $coupon) }}"
                                      onsubmit="return confirm(
                                          'Delete coupon {{ $coupon->code }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-sm btn-outline-danger">
                                        <i class="ti ti-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="ti ti-ticket fs-1 d-block mb-2
                                       opacity-25"></i>
                            <div class="text-muted">No coupons yet.</div>
                            <a href="{{ route('admin.coupons.create') }}"
                               class="btn btn-warning btn-sm mt-2">
                                Create First Coupon
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