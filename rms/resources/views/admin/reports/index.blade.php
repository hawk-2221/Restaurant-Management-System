@extends('layouts.admin')
@section('title', 'Reports')
@section('page-title', 'Analytics & Reports')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

@section('content')

<!-- Summary Stats -->
<div class="row g-4 mb-4">

    <div class="col-xl-2 col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="fs-1 fw-bold text-success">
                    Rs.{{ number_format($stats['today_revenue'], 0) }}
                </div>
                <div class="text-muted small mt-1">Today Revenue</div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="fs-1 fw-bold text-primary">
                    Rs.{{ number_format($stats['month_revenue'], 0) }}
                </div>
                <div class="text-muted small mt-1">This Month</div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="fs-1 fw-bold text-warning">
                    Rs.{{ number_format($stats['total_revenue'], 0) }}
                </div>
                <div class="text-muted small mt-1">Total Revenue</div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="fs-1 fw-bold text-info">
                    {{ $stats['total_orders'] }}
                </div>
                <div class="text-muted small mt-1">Total Orders</div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="fs-1 fw-bold text-danger">
                    {{ $stats['total_customers'] }}
                </div>
                <div class="text-muted small mt-1">Customers</div>
            </div>
        </div>
    </div>

    <div class="col-xl-2 col-md-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body text-center">
                <div class="fs-1 fw-bold text-secondary">
                    Rs.{{ number_format($stats['avg_order'], 0) }}
                </div>
                <div class="text-muted small mt-1">Avg Order Value</div>
            </div>
        </div>
    </div>

</div>

<!-- Charts Row -->
<div class="row g-4 mb-4">

    <!-- Daily Revenue Chart -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom">
                <h6 class="mb-0 fw-bold">
                    <i class="ti ti-chart-line me-2 text-primary"></i>
                    Revenue — Last 7 Days
                </h6>
            </div>
            <div class="card-body">
                <canvas id="dailyChart" height="100"></canvas>
            </div>
        </div>
    </div>

    <!-- Order Status Pie -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom">
                <h6 class="mb-0 fw-bold">
                    <i class="ti ti-chart-pie me-2 text-warning"></i>
                    Order Status
                </h6>
            </div>
            <div class="card-body d-flex align-items-center
                        justify-content-center">
                <canvas id="statusChart" height="200"></canvas>
            </div>
        </div>
    </div>

</div>

<!-- Monthly Revenue + Top Items -->
<div class="row g-4">

    <!-- Monthly Revenue -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom">
                <h6 class="mb-0 fw-bold">
                    <i class="ti ti-chart-bar me-2 text-success"></i>
                    Monthly Revenue — Last 6 Months
                </h6>
            </div>
            <div class="card-body">
                <canvas id="monthlyChart" height="120"></canvas>
            </div>
        </div>
    </div>

    <!-- Top Selling Items -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-transparent border-bottom">
                <h6 class="mb-0 fw-bold">
                    <i class="ti ti-trophy me-2 text-warning"></i>
                    Top Selling Items
                </h6>
            </div>
            <div class="card-body p-0">
                @forelse($topItems as $i => $item)
                <div class="d-flex align-items-center gap-3 p-3 border-bottom">
                    <div class="fw-bold text-muted" style="width:24px;">
                        #{{ $i + 1 }}
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-semibold">
                            {{ $item->menuItem->name ?? 'Unknown' }}
                        </div>
                        <div class="progress mt-1" style="height:4px;">
                            <div class="progress-bar bg-success"
                                 style="width:{{
                                     $topItems->max('total_qty') > 0
                                     ? ($item->total_qty / $topItems->max('total_qty')) * 100
                                     : 0
                                 }}%">
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <div class="fw-bold text-success">
                            Rs.{{ number_format($item->total_revenue, 0) }}
                        </div>
                        <small class="text-muted">
                            {{ $item->total_qty }} sold
                        </small>
                    </div>
                </div>
                @empty
                <div class="p-4 text-center text-muted">
                    No orders data yet.
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
// Daily Revenue Chart
const dailyCtx = document.getElementById('dailyChart').getContext('2d');
new Chart(dailyCtx, {
    type: 'line',
    data: {
        labels: @json($dailyLabels),
        datasets: [{
            label: 'Revenue (Rs.)',
            data: @json($dailyRevenue),
            borderColor: '#0d6efd',
            backgroundColor: 'rgba(13,110,253,0.1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#0d6efd',
            pointRadius: 5,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: val => 'Rs.' + val.toLocaleString()
                }
            }
        }
    }
});

// Monthly Revenue Chart
const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
new Chart(monthlyCtx, {
    type: 'bar',
    data: {
        labels: @json($monthlyLabels),
        datasets: [{
            label: 'Revenue (Rs.)',
            data: @json($monthlyRevenue),
            backgroundColor: [
                'rgba(13,110,253,0.7)',
                'rgba(25,135,84,0.7)',
                'rgba(255,193,7,0.7)',
                'rgba(220,53,69,0.7)',
                'rgba(13,202,240,0.7)',
                'rgba(108,117,125,0.7)',
            ],
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: val => 'Rs.' + val.toLocaleString()
                }
            }
        }
    }
});

// Status Pie Chart
const statusCtx = document.getElementById('statusChart').getContext('2d');
new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: ['Pending', 'Cooking', 'Ready', 'Served', 'Cancelled'],
        datasets: [{
            data: [
                {{ $statusBreakdown['pending'] }},
                {{ $statusBreakdown['cooking'] }},
                {{ $statusBreakdown['ready'] }},
                {{ $statusBreakdown['served'] }},
                {{ $statusBreakdown['cancelled'] }},
            ],
            backgroundColor: [
                '#ffc107',
                '#fd7e14',
                '#198754',
                '#6c757d',
                '#dc3545',
            ],
            borderWidth: 0,
        }]
    },
    options: {
        responsive: true,
        cutout: '65%',
        plugins: {
            legend: {
                position: 'bottom',
                labels: { padding: 15 }
            }
        }
    }
});
</script>
@endpush