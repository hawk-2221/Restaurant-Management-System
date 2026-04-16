<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reservations Report</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 3px solid #c8a951;
            padding-bottom: 12px;
        }
        .header h1 { color: #c8a951; font-size: 22px; margin: 0; }
        .header p  { color: #888; margin: 4px 0 0; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; }
        th {
            background: #c8a951;
            color: #fff;
            padding: 8px;
            text-align: left;
            font-size: 11px;
        }
        td {
            padding: 6px 8px;
            border-bottom: 1px solid #eee;
            font-size: 11px;
        }
        tr:nth-child(even) { background: #f9f9f9; }
        .confirmed { color: #198754; font-weight: bold; }
        .pending   { color: #ffc107; font-weight: bold; }
        .cancelled { color: #dc3545; font-weight: bold; }
        .completed { color: #6c757d; font-weight: bold; }
        .footer {
            margin-top: 25px;
            text-align: center;
            color: #888;
            font-size: 10px;
            border-top: 1px solid #eee;
            padding-top: 8px;
        }
    </style>
</head>
<body>

<div class="header">
    <h1>The Restaurant — Reservations Report</h1>
    <p>Generated on {{ now()->format('d M Y, h:i A') }}</p>
    <p>Total: {{ $reservations->count() }} reservations</p>
</div>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Guest Name</th>
            <th>Phone</th>
            <th>Table</th>
            <th>Date</th>
            <th>Time</th>
            <th>Guests</th>
            <th>Status</th>
            <th>Notes</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reservations as $res)
        <tr>
            <td>#{{ $res->id }}</td>
            <td><strong>{{ $res->guest_name }}</strong></td>
            <td>{{ $res->guest_phone }}</td>
            <td>Table #{{ $res->table->table_number }}</td>
            <td>{{ \Carbon\Carbon::parse($res->reservation_date)->format('d M Y') }}</td>
            <td>{{ $res->reservation_time }}</td>
            <td>{{ $res->guests_count }} persons</td>
            <td class="{{ $res->status }}">{{ ucfirst($res->status) }}</td>
            <td>{{ $res->notes ?? '—' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="footer">
    Restaurant Management System &copy; {{ date('Y') }}
</div>

</body>
</html>