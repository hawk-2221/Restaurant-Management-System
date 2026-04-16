@extends('layouts.admin')
@section('title', 'Order #' . $order->id)
@section('page-title', 'Order Details')

@push('styles')
<style>
@media print {
    #miniSidebar,
    .navbar-glass,
    .btn,
    form,
    .no-print { display: none !important; }
    .card { box-shadow: none !important; border: 1px solid #ddd !important; }
    body { font-size: 12px; }
}
</style>
@endpush

@section('content')

<!-- Top Action Bar -->
<div class="d-flex justify-content-between align-items-center mb-4 no-print">
    <a href="{{ route('admin.orders.index') }}"
       class="btn btn-secondary btn-sm">
        <i class="ti ti-arrow-left me-1"></i>Back to Orders
    </a>
    <button onclick="window.print()"
            class="btn btn-outline-secondary btn-sm">
        <i class="ti ti-printer me-1"></i>Print Receipt
    </button>
</div>

<div class="row g-4">

    <!-- Left: Order Items -->
    <div class="col-lg-8">

        <!-- Receipt Header (visible on print) -->
        <div class="text-center mb-4 d-none d-print-block">
            <h3 class="fw-bold">The Restaurant</h3>
            <p class="mb-0">123 Main Street, Karachi</p>
            <p class="mb-0">Tel: +92 300 1234567</p>
            <hr>
            <h5>ORDER RECEIPT</h5>
        </div>

        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-bottom
                        d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">
                    <i class="ti ti-shopping-cart me-2 text-primary"></i>
                    Order #{{ $order->id }} — Items
                </h6>
                <span class="badge badge-{{ $order->status }}
                             px-3 py-2" style="font-size:13px;">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Item</th>
                                <th>Unit Price</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                                <th class="no-print">Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                            <tr>
                                <td>
                                    <strong>
                                        {{ $item->menuItem->name }}
                                    </strong>
                                    <br>
                                    <small class="text-muted">
                                        {{ $item->menuItem->category->name }}
                                    </small>
                                </td>
                                <td>
                                    Rs.{{ number_format($item->unit_price, 0) }}
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        x{{ $item->quantity }}
                                    </span>
                                </td>
                                <td>
                                    <strong class="text-success">
                                        Rs.{{ number_format($item->subtotal, 0) }}
                                    </strong>
                                </td>
                                <td class="no-print">
                                    <small class="text-muted">
                                        {{ $item->special_instructions ?? '—' }}
                                    </small>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
                            <tr>
                                <th colspan="3" class="text-end">
                                    Total Amount:
                                </th>
                                <th class="text-success" style="font-size:18px;">
                                    Rs.{{ number_format($order->total_amount, 0) }}
                                </th>
                                <th class="no-print"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        @if($order->notes)
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h6 class="fw-bold mb-2">
                    <i class="ti ti-note me-2 text-warning"></i>
                    Order Notes
                </h6>
                <p class="mb-0 text-muted">{{ $order->notes }}</p>
            </div>
        </div>
        @endif

        <!-- Print Footer -->
        <div class="text-center mt-4 d-none d-print-block">
            <hr>
            <p class="mb-1">
                <strong>Payment:</strong>
                {{ ucfirst($order->payment_status) }}
                — {{ ucfirst($order->payment_method) }}
            </p>
            <p class="mb-1">
                <strong>Date:</strong>
                {{ $order->created_at->format('d M Y, h:i A') }}
            </p>
            <p class="mt-3 text-muted" style="font-size:12px;">
                Thank you for dining with us!
            </p>
        </div>

    </div>

    <!-- Right: Info + Actions -->
    <div class="col-lg-4 no-print">

        <!-- Order Info -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-bottom">
                <h6 class="mb-0 fw-bold">
                    <i class="ti ti-info-circle me-2 text-info"></i>
                    Order Info
                </h6>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm table-borderless mb-0 p-2">
                    <tr>
                        <td class="text-muted ps-3">Customer</td>
                        <td>
                            <strong>
                                {{ $order->user->name ?? 'Guest' }}
                            </strong>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted ps-3">Table</td>
                        <td>
                            {{ $order->table
                                ? 'Table #'.$order->table->table_number
                                : 'Takeaway' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted ps-3">Type</td>
                        <td>
                            {{ ucfirst(str_replace('_', ' ',
                               $order->order_type)) }}
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted ps-3">Payment</td>
                        <td>
                            <span class="badge {{
                                $order->payment_status === 'paid'
                                    ? 'bg-success'
                                    : 'bg-warning text-dark'
                            }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-muted ps-3">Method</td>
                        <td>{{ ucfirst($order->payment_method) }}</td>
                    </tr>
                    <tr>
                        <td class="text-muted ps-3">Items</td>
                        <td>{{ $order->orderItems->count() }} items</td>
                    </tr>
                    <tr>
                        <td class="text-muted ps-3">Date</td>
                        <td>
                            <small>
                                {{ $order->created_at->format('d M Y, h:i A') }}
                            </small>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- Update Status -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-bottom">
                <h6 class="mb-0 fw-bold">
                    <i class="ti ti-refresh me-2 text-warning"></i>
                    Update Order Status
                </h6>
            </div>
            <div class="card-body">
                <form method="POST"
                      action="{{ route('admin.orders.status', $order) }}">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <select name="status" class="form-select">
                            @foreach(['pending','cooking','ready',
                                      'served','cancelled'] as $s)
                            <option value="{{ $s }}"
                                {{ $order->status === $s ? 'selected' : '' }}>
                                {{ ucfirst($s) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-warning w-100">
                        <i class="ti ti-refresh me-1"></i>Update Status
                    </button>
                </form>
            </div>
        </div>

        <!-- Update Payment -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-transparent border-bottom">
                <h6 class="mb-0 fw-bold">
                    <i class="ti ti-cash me-2 text-success"></i>
                    Update Payment
                </h6>
            </div>
            <div class="card-body">
                <form method="POST"
                      action="{{ route('admin.orders.payment', $order) }}">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">
                            Payment Status
                        </label>
                        <select name="payment_status" class="form-select">
                            <option value="unpaid"
                                {{ $order->payment_status === 'unpaid'
                                    ? 'selected' : '' }}>
                                Unpaid
                            </option>
                            <option value="paid"
                                {{ $order->payment_status === 'paid'
                                    ? 'selected' : '' }}>
                                Paid
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-semibold">
                            Payment Method
                        </label>
                        <select name="payment_method" class="form-select">
                            @foreach(['cash','card','online'] as $m)
                            <option value="{{ $m }}"
                                {{ $order->payment_method === $m
                                    ? 'selected' : '' }}>
                                {{ ucfirst($m) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="ti ti-check me-1"></i>Update Payment
                    </button>
                </form>
            </div>
        </div>

        <!-- Delete Order -->
        <div class="card border-0 shadow-sm border-danger mb-4">
            <div class="card-body">
                <form method="POST"
                      action="{{ route('admin.orders.destroy', $order) }}"
                      onsubmit="return confirm(
                          'Delete Order #{{ $order->id }}? This cannot be undone!')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="btn btn-outline-danger w-100">
                        <i class="ti ti-trash me-1"></i>Delete Order
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection