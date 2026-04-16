<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Orders Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #c8a951;
            padding-bottom: 15px;
        }
        .header h1 {
            color: #c8a951;
            font-size: 24px;
            margin: 0;
        }
        .header p {
            color: #888;
            margin: 5px 0 0;
        }
        .stats {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }
        .stat-box {
            border: 1px solid #ddd;
            padding: 10px 15px;
            text-align: center;
            flex: 1;
        }
        .stat-box .num {
            font-size: 20px;
            font-weight: bold;
            color: #c8a951;
        }
        .stat-box .label {
            font-size: 10px;
            color: #888;
            text-transform: uppercase;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th {
            background: #c8a951;
            color: #fff;
            padding: 8px 10px;
            text-align: left;
            font-size: 11px;
        }
        td {
            padding: 7px 10px;
            border-bottom: 1px solid #eee;
            font-size: 11px;
        }
        tr:nth-child(even) { background: #f9f9f9; }
        .badge-paid     { color: #198754; font-weight: bold; }
        .badge-unpaid   { color: #fd7e14; font-weight: bold; }
        .badge-served   { color: #198754; }
        .badge-pending  { color: #ffc107; }
        .badge-cooking  { color: #fd7e14; }
        .badge-cancelled{ color: #dc3545; }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #888;
            font-size: 10px;
            border-top: 1px solid #eee;
            padding-top: 10px;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>The Restaurant — Orders Report</h1>
    <p>Generated on {{ now()->format('d M Y, h:i A') }}</p>
    @if(!empty($filters['date_from']) || !empty($filters['date_to']))
    <p>Period:
        {{ $filters['date_from'] ?? 'All' }}
        to
        {{ $filters['date_to'] ?? 'All' }}
    </p>
    @endif
</div>

<!-- Summary Stats -->
<table style="margin-bottom:20px;">
    <tr>
        <td style="border:1px solid #ddd; padding:10px; text-align:center;">
            <div style="font-size:20px; font-weight:bold; color:#c8a951;">
                {{ $orders->count() }}
            </div>
            <div style="font-size:10px; color:#888;">Total Orders</div>
        </td>
        <td style="border:1px solid #ddd; padding:10px; text-align:center;">
            <div style="font-size:20px; font-weight:bold; color:#198754;">
                Rs.{{ number_format($orders->where('payment_status','paid')
                         ->sum('total_amount'), 0) }}
            </div>
            <div style="font-size:10px; color:#888;">Total Revenue</div>
        </td>
        <td style="border:1px solid #ddd; padding:10px; text-align:center;">
            <div style="font-size:20px; font-weight:bold; color:#fd7e14;">
                {{ $orders->where('payment_status','unpaid')->count() }}
            </div>
            <div style="font-size:10px; color:#888;">Unpaid Orders</div>
        </td>
        <td style="border:1px solid #ddd; padding:10px; text-align:center;">
            <div style="font-size:20px; font-weight:bold; color:#dc3545;">
                {{ $orders->where('status','cancelled')->count() }}
            </div>
            <div style="font-size:10px; color:#888;">Cancelled</div>
        </td>
    </tr>
</table>

<!-- Orders Table -->
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Customer</th>
            <th>Table</th>
            <th>Type</th>
            <th>Total</th>
            <th>Payment</th>
            <th>Status</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            <td>#{{ $order->id }}</td>
            <td>{{ $order->user->name ?? 'Guest' }}</td>
            <td>{{ $order->table
                    ? 'T#'.$order->table->table_number
                    : 'Takeaway' }}</td>
            <td>{{ ucfirst(str_replace('_',' ',$order->order_type)) }}</td>
            <td><strong>Rs.{{ number_format($order->total_amount,0) }}</strong></td>
            <td class="badge-{{ $order->payment_status }}">
                {{ ucfirst($order->payment_status) }}
            </td>
            <td class="badge-{{ $order->status }}">
                {{ ucfirst($order->status) }}
            </td>
            <td>{{ $order->created_at->format('d M Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    Restaurant Management System &copy; {{ date('Y') }}
    — Confidential Report
</div>

</body>
</html>