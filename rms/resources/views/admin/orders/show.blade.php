@extends('layouts.admin')
@section('title', 'Order Details')
@section('page-title', 'Order Details')

@section('content')

<div class="mb-3 d-flex gap-2">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-secondary">
        <i class="ti ti-arrow-left me-1"></i>Back to Orders
    </a>
    
    <a href="{{ route('admin.orders.invoice', $order) }}"
       target="_blank"
       class="btn btn-sm btn-success">
        <i class="ti ti-receipt me-1"></i>View Invoice
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted small text-uppercase mb-2">Customer</h6>
                <strong>{{ $order->user->name ?? 'Guest' }}</strong><br>
                <small class="text-muted">{{ $order->user->email ?? '' }}</small>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted small text-uppercase mb-2">Table & Type</h6>
                <strong>{{ $order->table ? 'Table #' . $order->table->table_number : 'No Table' }}</strong><br>
                <span class="badge bg-info-subtle text-info-emphasis">{{ ucfirst(str_replace('_', ' ', $order->order_type ?? 'dine_in')) }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted small text-uppercase mb-2">Date & Time</h6>
                <strong>{{ $order->created_at->format('d M Y') }}</strong><br>
                <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
            </div>
        </div>
    </div>
</div>

<!-- Updated Row: Changed to col-md-4 to fit 3 cards -->
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted small text-uppercase mb-3">Order Status</h6>
                <form method="POST" action="{{ route('admin.orders.status', $order) }}">
                    @csrf @method('PATCH')
                    <div class="d-flex gap-2 align-items-center">
                        <select name="status" class="form-select form-select-sm" style="max-width:200px;">
                            @foreach(['pending','confirmed','cooking','ready','served','cancelled'] as $s)
                            <option value="{{ $s }}" {{ $order->status === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary"><i class="ti ti-check"></i> Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h6 class="text-muted small text-uppercase mb-3">Payment</h6>
                <form method="POST" action="{{ route('admin.orders.payment', $order) }}">
                    @csrf @method('PATCH')
                    <div class="d-flex gap-2 align-items-center flex-wrap">
                        <select name="payment_status" class="form-select form-select-sm" style="max-width:150px;">
                            <option value="unpaid" {{ $order->payment_status === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                        </select>
                        <select name="payment_method" class="form-select form-select-sm" style="max-width:150px;">
                            <option value="cash" {{ $order->payment_method === 'cash' ? 'selected' : '' }}>Cash</option>
                            <option value="card" {{ $order->payment_method === 'card' ? 'selected' : '' }}>Card</option>
                            <option value="online" {{ $order->payment_method === 'online' ? 'selected' : '' }}>Online</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-success"><i class="ti ti-check"></i> Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- NEW: Assign Waiter Card -->
    <div class="col-md-4">
        <div class="card shadow-sm h-100">
            <div class="card-body">
                <h6 class="text-muted small text-uppercase mb-3">Assign Waiter</h6>
                <form method="POST"
                      action="{{ route('admin.orders.waiter', $order) }}">
                    @csrf
                    @method('PATCH')
                    @php
                        $staff = \App\Models\User::whereIn('role', ['staff','admin'])->get();
                    @endphp
                    <select name="waiter_id" class="form-select form-select-sm mb-2">
                        <option value="">-- Select Waiter --</option>
                        @foreach($staff as $s)
                        <option value="{{ $s->id }}"
                            {{ $order->waiter_id == $s->id ? 'selected' : '' }}>
                            {{ $s->name }} ({{ ucfirst($s->role) }})
                        </option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-sm btn-info w-100">
                        <i class="ti ti-user-check me-1"></i> Assign Waiter
                    </button>
                </form>
            </div>
        </div>
    </div>
    <!-- End New Card -->

</div>

<div class="card shadow-sm mb-4">
    <div class="card-header bg-white">
        <h6 class="mb-0"><i class="ti ti-list-details me-1"></i>Order Items</h6>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Item</th>
                    <th class="text-center">Qty</th>
                    <th class="text-end">Price</th>
                    <th class="text-end">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($order->orderItems as $item)
                <tr>
                    <td>
                        <strong>{{ $item->menuItem->name ?? 'Item' }}</strong>
                        @if($item->special_instructions)
                        <br><small class="text-muted">{{ $item->special_instructions }}</small>
                        @endif
                    </td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-end">Rs.{{ number_format($item->unit_price ?? $item->price, 0) }}</td>
                    <td class="text-end fw-bold">Rs.{{ number_format($item->subtotal ?? ($item->quantity * ($item->unit_price ?? $item->price)), 0) }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted py-4">No items.</td></tr>
                @endforelse
            </tbody>
            <tfoot class="table-light">
                <tr>
                    <th colspan="3" class="text-end">Total:</th>
                    <th class="text-end text-success fs-5">Rs.{{ number_format($order->total_amount, 0) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@if($order->notes)
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <h6 class="text-muted small text-uppercase mb-1">Notes</h6>
        <p class="mb-0">{{ $order->notes }}</p>
    </div>
</div>
@endif

@endsection