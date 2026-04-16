@extends('layouts.admin')
@section('title', 'Orders')
@section('page-title', 'All Orders')

@section('content')

<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-2">
        <div class="card border-0 shadow-sm text-center py-3">
            <div class="fs-3 fw-bold">{{ $stats['total'] }}</div>
            <div class="text-muted small">Total</div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="card border-0 shadow-sm text-center py-3
                    border-start border-warning border-3">
            <div class="fs-3 fw-bold text-warning">
                {{ $stats['pending'] }}
            </div>
            <div class="text-muted small">Pending</div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="card border-0 shadow-sm text-center py-3
                    border-start border-danger border-3">
            <div class="fs-3 fw-bold text-danger">
                {{ $stats['cooking'] }}
            </div>
            <div class="text-muted small">Cooking</div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="card border-0 shadow-sm text-center py-3
                    border-start border-success border-3">
            <div class="fs-3 fw-bold text-success">
                {{ $stats['ready'] }}
            </div>
            <div class="text-muted small">Ready</div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="card border-0 shadow-sm text-center py-3
                    border-start border-info border-3">
            <div class="fs-3 fw-bold text-info">
                {{ $stats['served'] }}
            </div>
            <div class="text-muted small">Served</div>
        </div>
    </div>
    <div class="col-6 col-md-2">
        <div class="card border-0 shadow-sm text-center py-3
                    border-start border-danger border-3">
            <div class="fs-3 fw-bold text-danger">
                {{ $stats['unpaid'] }}
            </div>
            <div class="text-muted small">Unpaid</div>
        </div>
    </div>
</div>

<!-- Date Filter -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('admin.orders.index') }}"
              class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-semibold">
                    From Date
                </label>
                <input type="date" name="date_from"
                       class="form-control form-control-sm"
                       value="{{ request('date_from') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">
                    To Date
                </label>
                <input type="date" name="date_to"
                       class="form-control form-control-sm"
                       value="{{ request('date_to') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-semibold">
                    Status
                </label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Status</option>
                    @foreach(['pending','cooking','ready','served','cancelled'] as $s)
                    <option value="{{ $s }}"
                        {{ request('status') === $s ? 'selected' : '' }}>
                        {{ ucfirst($s) }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-primary btn-sm">
                    <i class="ti ti-filter me-1"></i>Filter
                </button>
                <a href="{{ route('admin.orders.index') }}"
                   class="btn btn-secondary btn-sm">
                    Clear
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Export Buttons -->
<div class="d-flex gap-2 mb-4">
    <div class="dropdown">
        <button class="btn btn-success btn-sm dropdown-toggle"
                data-bs-toggle="dropdown">
            <i class="ti ti-download me-1"></i>Export Orders
        </button>
        <ul class="dropdown-menu shadow border-0">
            <li>
                <a class="dropdown-item"
                   href="{{ route('admin.export.orders.excel',
                                  request()->all()) }}">
                    <i class="ti ti-file-spreadsheet me-2
                               text-success"></i>
                    Download Excel
                </a>
            </li>
            <li>
                <a class="dropdown-item"
                   href="{{ route('admin.export.orders.pdf',
                                  request()->all()) }}">
                    <i class="ti ti-file-text me-2 text-danger"></i>
                    Download PDF
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- Filter + New Order -->
<div class="d-flex flex-wrap justify-content-between
            align-items-center gap-2 mb-4">

    <!-- Status Filters -->
    <div class="d-flex flex-wrap gap-2">
        <a href="{{ route('admin.orders.index') }}"
           class="btn btn-sm {{
               !request('status') && !request('payment')
               ? 'btn-primary' : 'btn-outline-secondary'
           }}">
            All
        </a>
        @foreach(['pending','cooking','ready','served','cancelled'] as $s)
        <a href="{{ route('admin.orders.index', ['status' => $s]) }}"
           class="btn btn-sm {{
               request('status') === $s
               ? 'btn-dark' : 'btn-outline-secondary'
           }}">
            {{ ucfirst($s) }}
        </a>
        @endforeach
        <a href="{{ route('admin.orders.index', ['payment' => 'unpaid']) }}"
           class="btn btn-sm {{
               request('payment') === 'unpaid'
               ? 'btn-warning' : 'btn-outline-warning'
           }}">
            Unpaid
        </a>
    </div>

    <a href="{{ route('admin.orders.create') }}"
       class="btn btn-success btn-sm">
        <i class="ti ti-plus me-1"></i>New Order
    </a>
</div>

<!-- Orders Table -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#ID</th>
                        <th>Customer</th>
                        <th>Table</th>
                        <th>Type</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Payment</th>
                        <th>Status</th>
                        <th>Time</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr>
                        <td><strong>#{{ $order->id }}</strong></td>
                        <td>{{ $order->user->name ?? 'Guest' }}</td>
                        <td>
                            {{ $order->table
                                ? 'T#'.$order->table->table_number
                                : '—' }}
                        </td>
                        <td>
                            <span class="badge bg-info-subtle
                                         text-info-emphasis">
                                {{ ucfirst(str_replace('_', ' ',
                                   $order->order_type)) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge bg-secondary-subtle
                                         text-secondary-emphasis">
                                {{ $order->orderItems->count() }} items
                            </span>
                        </td>
                        <td>
                            <strong class="text-success">
                                Rs.{{ number_format($order->total_amount, 0) }}
                            </strong>
                        </td>
                        <td>
                            @if($order->payment_status === 'paid')
                            <span class="badge bg-success-subtle
                                         text-success-emphasis">
                                <i class="ti ti-check me-1"></i>Paid
                            </span>
                            @else
                            <span class="badge bg-warning-subtle
                                         text-warning-emphasis">
                                <i class="ti ti-clock me-1"></i>Unpaid
                            </span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-{{ $order->status }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>
                            <small class="text-muted">
                                {{ $order->created_at->format('d M, h:i A') }}
                            </small>
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}"
                               class="btn btn-sm btn-info">
                                <i class="ti ti-eye"></i>
                            </a>
                            <form method="POST"
                                  action="{{ route('admin.orders.destroy',
                                            $order) }}"
                                  class="d-inline"
                                  onsubmit="return confirm(
                                      'Delete Order #{{ $order->id }}?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="ti ti-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10"
                            class="text-center text-muted py-5">
                            <i class="ti ti-shopping-cart
                                      fs-1 d-block mb-2 opacity-25"></i>
                            No orders found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection