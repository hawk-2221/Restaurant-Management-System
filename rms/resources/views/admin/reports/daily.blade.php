@extends('layouts.admin')
@section('title', 'Daily Report')
@section('page-title', 'Daily Summary Report')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')

<!-- Date Picker -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body py-3">
        <form method="GET" action="{{ route('admin.reports.daily') }}"
              class="d-flex align-items-center gap-3">
            <label class="fw-semibold mb-0">Select Date:</label>
            <input type="date" name="date"
                   class="form-control" style="max-width:200px;"
                   value="{{ $summary['date'] }}"
                   max="{{ today()->toDateString() }}">
            <button type="submit" class="btn btn-primary btn-sm">
                <i class="ti ti-search me-1"></i>View Report
            </button>
            <a href="{{ route('admin.reports.daily') }}"
               class="btn btn-secondary btn-sm">Today</a>
        </form>
    </div>
</div>

<!-- Date Header -->
<div class="d-flex align-items-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-0">
            {{ \Carbon\Carbon::parse($summary['date'])->format('l, d F Y') }}
        </h4>
        <small class="text-muted">Daily Summary Report</small>
    </div>
    <div class="ms-auto">
        <span class="badge bg-{{ $summary['total_orders'] > 0 ? 'success' : 'secondary' }}
                     fs-6 px-3 py-2">
            {{ $summary['total_orders'] }} Orders
        </span>
    </div>
</div>

<!-- Stats -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center py-4"
             style="border-left:4px solid #198754 !important;">
            <div class="fs-1 fw-bold text-success">
                Rs.{{ number_format($summary['total_revenue'], 0) }}
            </div>
            <div class="text-muted">Today's Revenue</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center py-4"
             style="border-left:4px solid #0d6efd !important;">
            <div class="fs-1 fw-bold text-primary">
                {{ $summary['total_orders'] }}
            </div>
            <div class="text-muted">Total Orders</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center py-4"
             style="border-left:4px solid #198754 !important;">
            <div class="fs-1 fw-bold text-success">
                {{ $summary['paid_orders'] }}
            </div>
            <div class="text-muted">Paid Orders</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm text-center py-4"
             style="border-left:4px solid #ffc107 !important;">
            <div class="fs-1 fw-bold text-warning">
                {{ $summary['unpaid_orders'] }}
            </div>
            <div class="text-muted">Unpaid Orders</div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">

    <!-- Hourly Chart -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom">
                <h6 class="mb-0 fw-bold">
                    <i class="ti ti-chart-bar me-2 text-primary"></i>
                    Orders by Hour
                </h6>
            </div>
            <div class="card-body">
                <canvas id="hourlyChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Order Type Breakdown -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom">
                <h6 class="mb-0 fw-bold">
                    <i class="ti ti-chart-pie me-2 text-warning"></i>
                    Order Types
                </h6>
            </div>
            <div class="card-body">
                <canvas id="typeChart" height="200"></canvas>
                <div class="mt-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span><i class="ti ti-chair me-2 text-primary"></i>Dine In</span>
                        <strong>{{ $summary['dine_in'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span><i class="ti ti-shopping-bag me-2 text-success"></i>Takeaway</span>
                        <strong>{{ $summary['takeaway'] }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span><i class="ti ti-truck me-2 text-warning"></i>Delivery</span>
                        <strong>{{ $summary['delivery'] }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div class="row g-4">

    <!-- Top Items -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom">
                <h6 class="mb-0 fw-bold">
                    <i class="ti ti-trophy me-2 text-warning"></i>
                    Top Items Today
                </h6>
            </div>
            <div class="card-body p-0">
                @forelse($topItems as $i => $item)
                <div class="d-flex align-items-center gap-3 p-3 border-bottom">
                    <div class="fw-bold text-muted"
                         style="width:24px;">
                        #{{ $i+1 }}
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-semibold">
                            {{ $item->menuItem->name ?? '—' }}
                        </div>
                        <div class="progress mt-1" style="height:4px;">
                            <div class="progress-bar bg-warning"
                                 style="width:{{
                                     $topItems->max('total_qty') > 0
                                     ? ($item->total_qty / $topItems->max('total_qty')) * 100
                                     : 0
                                 }}%">
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold text-success small">
                            Rs.{{ number_format($item->total_revenue,0) }}
                        </div>
                        <small class="text-muted">
                            {{ $item->total_qty }} sold
                        </small>
                    </div>
                </div>
                @empty
                <div class="p-4 text-center text-muted">
                    No orders today
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Today's Orders List -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom">
                <h6 class="mb-0 fw-bold">
                    <i class="ti ti-list me-2 text-info"></i>
                    Today's Orders
                </h6>
            </div>
            <div class="card-body p-0" style="max-height:400px;overflow-y:auto;">
                <table class="table table-hover mb-0">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th>#</th>
                            <th>Customer</th>
                            <th>Total</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->user->name ?? 'Guest' }}</td>
                            <td>
                                <strong class="text-success">
                                    Rs.{{ number_format($order->total_amount,0) }}
                                </strong>
                            </td>
                            <td>
                                <span class="badge bg-{{
                                    $order->payment_status === 'paid'
                                    ? 'success' : 'warning text-dark' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge badge-{{ $order->status }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <small class="text-muted">
                                    {{ $order->created_at->format('h:i A') }}
                                </small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6"
                                class="text-center text-muted py-4">
                                No orders for this date
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
// Hourly chart
new Chart(document.getElementById('hourlyChart'), {
    type: 'bar',
    data: {
        labels: Array.from({length:24}, (_,i) =>
            i === 0 ? '12am' : i < 12 ? i+'am' :
            i === 12 ? '12pm' : (i-12)+'pm'),
        datasets: [{
            label: 'Orders',
            data: @json(array_values($hourly)),
            backgroundColor: 'rgba(13,110,253,0.7)',
            borderRadius: 4,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display:false } },
        scales: {
            y: { beginAtZero:true, ticks:{ stepSize:1 } }
        }
    }
});

// Type pie chart
new Chart(document.getElementById('typeChart'), {
    type: 'doughnut',
    data: {
        labels: ['Dine In', 'Takeaway', 'Delivery'],
        datasets: [{
            data: [
                {{ $summary['dine_in'] }},
                {{ $summary['takeaway'] }},
                {{ $summary['delivery'] }},
            ],
            backgroundColor: ['#0d6efd','#198754','#ffc107'],
            borderWidth: 0,
        }]
    },
    options: {
        cutout: '65%',
        plugins: { legend: { display:false } }
    }
});
</script>
@endpush