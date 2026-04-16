@extends('layouts.admin')
@section('title', 'Orders')
@section('page-title', 'All Orders')

@push('styles')
<style>
  /* ─── Google Font ─── */
  @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=DM+Mono:wght@400;500&display=swap');

  /* ─── LIGHT THEME (default) ─── */
  .orders-page {
    --bg-card:        #ffffff;
    --bg-card-hover:  #f8fafc;
    --bg-input:       #f1f5f9;
    --border:         rgba(0,0,0,0.08);
    --border-hover:   rgba(0,0,0,0.15);
    --text-primary:   #1a2535;
    --text-secondary: #4a5568;
    --text-muted:     #94a3b8;
    --accent:         #2d6ef5;
    --accent-hover:   #1a57d6;
    --accent-soft:    rgba(45,110,245,0.10);
    --green:          #059669;
    --green-soft:     rgba(5,150,105,0.10);
    --orange:         #d97706;
    --orange-soft:    rgba(217,119,6,0.10);
    --red:            #dc2626;
    --red-soft:       rgba(220,38,38,0.10);
    --pink:           #db2777;
    --pink-soft:      rgba(219,39,119,0.10);
    --teal:           #0891b2;
    --teal-soft:      rgba(8,145,178,0.10);
    --purple:         #7c3aed;
    --purple-soft:    rgba(124,58,237,0.10);
    --shadow-sm:      0 1px 3px rgba(0,0,0,0.07), 0 1px 2px rgba(0,0,0,0.04);
    --shadow-md:      0 4px 14px rgba(0,0,0,0.09);
    --radius-sm:      8px;
    --radius-md:      12px;
    --radius-lg:      16px;
    --font-main:      'DM Sans', sans-serif;
    --font-mono:      'DM Mono', monospace;
    --transition:     0.18s cubic-bezier(0.4,0,0.2,1);
  }

  /* ─── DARK THEME — matches reservations page pattern ─── */
  body.dark-mode .orders-page,
  body.sidebar-dark-primary .orders-page,
  [data-theme="dark"] .orders-page,
  [data-bs-theme="dark"] .orders-page {
    --bg-card:        #1e2733;
    --bg-card-hover:  #243040;
    --bg-input:       #1a2231;
    --border:         rgba(255,255,255,0.07);
    --border-hover:   rgba(255,255,255,0.14);
    --text-primary:   #e4eef8;
    --text-secondary: #7a9ab8;
    --text-muted:     #4a6278;
    --accent:         #4d84ff;
    --accent-hover:   #6694ff;
    --accent-soft:    rgba(77,132,255,0.14);
    --green:          #10d97f;
    --green-soft:     rgba(16,217,127,0.13);
    --orange:         #fbbf24;
    --orange-soft:    rgba(251,191,36,0.13);
    --red:            #f87171;
    --red-soft:       rgba(248,113,113,0.13);
    --pink:           #f472b6;
    --pink-soft:      rgba(244,114,182,0.13);
    --teal:           #22d3ee;
    --teal-soft:      rgba(34,211,238,0.13);
    --purple:         #a78bfa;
    --purple-soft:    rgba(167,139,250,0.13);
    --shadow-sm:      0 1px 3px rgba(0,0,0,0.35);
    --shadow-md:      0 4px 18px rgba(0,0,0,0.4);
  }

  /* ─── Base ─── */
  .orders-page * { box-sizing: border-box; font-family: var(--font-main); }
  .orders-page { background: transparent; padding: 1rem 1.5rem; }

  /* ─── Page Header ─── */
  .page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.75rem;
    flex-wrap: wrap;
    gap: 12px;
  }
  .page-header-left h1 {
    font-size: 22px;
    font-weight: 600;
    color: var(--text-primary);
    letter-spacing: -0.3px;
    line-height: 1.2;
  }
  .page-header-left p {
    font-size: 13px;
    color: var(--text-muted);
    margin-top: 3px;
  }
  .header-actions { display: flex; gap: 10px; align-items: center; }



  /* ─── Live Badge ─── */
  .live-indicator {
    display: inline-flex; align-items: center; gap: 6px;
    background: var(--red-soft);
    color: var(--red);
    font-size: 11px;
    font-weight: 600;
    padding: 4px 10px;
    border-radius: 20px;
    letter-spacing: 0.04em;
    border: 1px solid rgba(239,68,68,0.2);
  }
  .live-dot {
    width: 6px; height: 6px;
    border-radius: 50%;
    background: var(--red);
    animation: livePulse 1.4s infinite;
  }
  @keyframes livePulse {
    0%,100% { opacity:1; transform:scale(1); }
    50%      { opacity:0.4; transform:scale(1.5); }
  }

  /* ─── Stats Grid ─── */
  .stats-grid {
    display: grid;
    grid-template-columns: repeat(6, minmax(0, 1fr));
    gap: 12px;
    margin-bottom: 1.5rem;
  }
  @media (max-width: 1100px) { .stats-grid { grid-template-columns: repeat(3, 1fr); } }
  @media (max-width: 600px)  { .stats-grid { grid-template-columns: repeat(2, 1fr); } }

  .stat-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius-md);
    padding: 1.1rem 1rem;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    transition: all var(--transition);
    box-shadow: var(--shadow-sm);
    animation: statReveal 0.5s ease both;
  }
  .stat-card:nth-child(1) { animation-delay: 0ms; }
  .stat-card:nth-child(2) { animation-delay: 60ms; }
  .stat-card:nth-child(3) { animation-delay: 120ms; }
  .stat-card:nth-child(4) { animation-delay: 180ms; }
  .stat-card:nth-child(5) { animation-delay: 240ms; }
  .stat-card:nth-child(6) { animation-delay: 300ms; }
  @keyframes statReveal {
    from { opacity:0; transform:translateY(10px) scale(0.97); }
    to   { opacity:1; transform:translateY(0) scale(1); }
  }
  .stat-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
    border-color: var(--border-hover);
  }
  .stat-card.active {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-soft), var(--shadow-md);
  }

  .stat-icon {
    width: 34px; height: 34px;
    border-radius: var(--radius-sm);
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 10px;
    font-size: 15px;
  }
  .stat-num {
    font-size: 28px;
    font-weight: 600;
    color: var(--text-primary);
    line-height: 1;
    font-variant-numeric: tabular-nums;
    font-family: var(--font-mono);
  }
  .stat-lbl {
    font-size: 11px;
    color: var(--text-muted);
    margin-top: 5px;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    font-weight: 500;
  }
  .stat-accent-bar {
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    border-radius: var(--radius-md) var(--radius-md) 0 0;
    transform: scaleX(0);
    transform-origin: left;
    transition: transform 0.6s cubic-bezier(0.4,0,0.2,1);
  }
  .stat-card.loaded .stat-accent-bar { transform: scaleX(1); }

  /* Stat color variants */
  .sc-total  .stat-icon { background: var(--accent-soft); color: var(--accent); }
  .sc-total  .stat-accent-bar { background: var(--accent); }
  .sc-total  .stat-num { color: var(--accent); }

  .sc-pending .stat-icon { background: var(--orange-soft); color: var(--orange); }
  .sc-pending .stat-accent-bar { background: var(--orange); }
  .sc-pending .stat-num { color: var(--orange); }

  .sc-cooking .stat-icon { background: var(--red-soft); color: var(--red); }
  .sc-cooking .stat-accent-bar { background: var(--red); }
  .sc-cooking .stat-num { color: var(--red); }

  .sc-ready .stat-icon { background: var(--green-soft); color: var(--green); }
  .sc-ready .stat-accent-bar { background: var(--green); }
  .sc-ready .stat-num { color: var(--green); }

  .sc-served .stat-icon { background: var(--teal-soft); color: var(--teal); }
  .sc-served .stat-accent-bar { background: var(--teal); }
  .sc-served .stat-num { color: var(--teal); }

  .sc-unpaid .stat-icon { background: var(--pink-soft); color: var(--pink); }
  .sc-unpaid .stat-accent-bar { background: var(--pink); }
  .sc-unpaid .stat-num { color: var(--pink); }

  /* ─── Toolbar ─── */
  .toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    margin-bottom: 1rem;
    flex-wrap: wrap;
  }
  .filter-pills { display: flex; gap: 6px; flex-wrap: wrap; align-items: center; }

  .pill {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    border: 1px solid var(--border);
    background: var(--bg-card);
    color: var(--text-secondary);
    transition: all var(--transition);
    box-shadow: var(--shadow-sm);
    white-space: nowrap;
  }
  .pill:hover {
    border-color: var(--border-hover);
    color: var(--text-primary);
    background: var(--bg-card-hover);
    transform: translateY(-1px);
  }
  .pill.active {
    background: var(--accent);
    border-color: var(--accent);
    color: #fff;
    box-shadow: 0 3px 10px rgba(45,110,245,0.35);
  }
  .pill.pill-unpaid.active {
    background: var(--pink);
    border-color: var(--pink);
    box-shadow: 0 3px 10px rgba(236,72,153,0.35);
  }

  .toolbar-right { display: flex; gap: 8px; align-items: center; }

  /* ─── Search Input ─── */
  .search-wrap {
    position: relative;
    display: flex;
    align-items: center;
  }
  .search-wrap svg {
    position: absolute;
    left: 11px;
    color: var(--text-muted);
    pointer-events: none;
  }
  .search-input {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    padding: 8px 12px 8px 34px;
    font-size: 13px;
    color: var(--text-primary);
    outline: none;
    width: 200px;
    transition: all var(--transition);
    box-shadow: var(--shadow-sm);
    font-family: var(--font-main);
  }
  .search-input::placeholder { color: var(--text-muted); }
  .search-input:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px var(--accent-soft);
    width: 240px;
  }

  /* ─── Buttons ─── */
  .btn-primary {
    display: inline-flex; align-items: center; gap: 7px;
    padding: 8px 16px;
    background: var(--accent);
    color: #fff;
    border: none;
    border-radius: var(--radius-sm);
    font-size: 13px;
    font-weight: 500;
    cursor: pointer;
    text-decoration: none;
    transition: all var(--transition);
    box-shadow: 0 3px 10px rgba(45,110,245,0.3);
    white-space: nowrap;
    font-family: var(--font-main);
  }
  .btn-primary:hover {
    background: var(--accent-hover);
    transform: translateY(-1px);
    box-shadow: 0 5px 14px rgba(45,110,245,0.4);
    color: #fff;
    text-decoration: none;
  }

  /* ─── Table Card ─── */
  .table-card {
    background: var(--bg-card);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    animation: cardReveal 0.4s ease 0.1s both;
  }
  @keyframes cardReveal {
    from { opacity:0; transform:translateY(8px); }
    to   { opacity:1; transform:translateY(0); }
  }

  /* ─── Table ─── */
  .orders-table { width: 100%; border-collapse: collapse; }
  .orders-table thead th {
    padding: 11px 16px;
    font-size: 10.5px;
    font-weight: 600;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.07em;
    background: rgba(255,255,255,0.03);
    border-bottom: 1px solid var(--border);
    text-align: left;
    white-space: nowrap;
  }

  .orders-table tbody tr {
    border-bottom: 1px solid var(--border);
    transition: background var(--transition);
    animation: rowIn 0.3s ease both;
  }
  .orders-table tbody tr:last-child { border-bottom: none; }
  .orders-table tbody tr:hover { background: var(--bg-card-hover); }

  @keyframes rowIn {
    from { opacity:0; transform:translateX(-6px); }
    to   { opacity:1; transform:translateX(0); }
  }

  .orders-table td {
    padding: 11px 16px;
    font-size: 13px;
    color: var(--text-primary);
    vertical-align: middle;
  }

  /* ─── Badges ─── */
  .badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
    letter-spacing: 0.02em;
  }
  .bdot { width:6px; height:6px; border-radius:50%; flex-shrink:0; }

  /* Status badges */
  .badge-pending  { background:var(--orange-soft); color:var(--orange); }
  .bdot-pending   { background:var(--orange); }
  .badge-cooking  { background:var(--red-soft); color:var(--red); }
  .bdot-cooking   { background:var(--red); animation:livePulse 1.2s infinite; }
  .badge-ready    { background:var(--green-soft); color:var(--green); }
  .bdot-ready     { background:var(--green); }
  .badge-served   { background:var(--teal-soft); color:var(--teal); }
  .bdot-served    { background:var(--teal); }
  .badge-cancelled{ background:rgba(100,116,139,0.12); color:#64748b; }

  /* Payment badges */
  .badge-paid   { background:var(--green-soft); color:var(--green); }
  .badge-unpaid { background:var(--orange-soft); color:var(--orange); }

  /* Type badges */
  .badge-dine     { background:var(--purple-soft); color:var(--purple); }
  .badge-takeaway { background:var(--accent-soft); color:var(--accent); }
  .badge-delivery { background:var(--teal-soft); color:var(--teal); }

  /* ─── Order ID ─── */
  .order-id {
    font-family: var(--font-mono);
    font-size: 12.5px;
    font-weight: 500;
    color: var(--accent);
    background: var(--accent-soft);
    padding: 3px 9px;
    border-radius: var(--radius-sm);
    letter-spacing: 0.02em;
  }

  /* ─── Amount ─── */
  .amount {
    font-family: var(--font-mono);
    font-weight: 500;
    color: var(--green);
    font-size: 13px;
  }

  /* ─── Action Buttons ─── */
  .btn-action {
    display: inline-flex; align-items: center; justify-content: center;
    width: 30px; height: 30px;
    border-radius: var(--radius-sm);
    border: 1px solid var(--border);
    background: transparent;
    cursor: pointer;
    color: var(--text-secondary);
    transition: all var(--transition);
    text-decoration: none;
  }
  .btn-action:hover { border-color: var(--border-hover); color: var(--text-primary); background: var(--bg-card-hover); }
  .btn-action.view:hover { background:var(--accent-soft); border-color:var(--accent); color:var(--accent); }
  .btn-action.del:hover  { background:var(--red-soft);    border-color:var(--red);    color:var(--red); }

  /* ─── Empty State ─── */
  .empty-state {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--text-muted);
  }
  .empty-icon {
    width: 56px; height: 56px;
    margin: 0 auto 16px;
    background: rgba(255,255,255,0.04);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    border: 1px solid var(--border);
  }
  .empty-state h3 { font-size: 15px; color: var(--text-secondary); font-weight: 500; }
  .empty-state p  { font-size: 13px; margin-top: 5px; }

  /* ─── Table Footer ─── */
  .table-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 16px;
    border-top: 1px solid var(--border);
    background: rgba(255,255,255,0.02);
    font-size: 12px;
    color: var(--text-muted);
    flex-wrap: wrap;
    gap: 8px;
  }

  /* ─── Customer Cell ─── */
  .customer-cell { display: flex; align-items: center; gap: 9px; }
  .avatar {
    width: 30px; height: 30px;
    border-radius: 50%;
    background: var(--accent-soft);
    color: var(--accent);
    display: flex; align-items: center; justify-content: center;
    font-size: 11px;
    font-weight: 600;
    flex-shrink: 0;
    border: 1px solid var(--border);
  }
  .customer-name { font-size: 13px; color: var(--text-primary); font-weight: 500; }

  /* ─── Scroll ─── */
  .table-scroll { overflow-x: auto; }

  /* ─── Responsive ─── */
  @media (max-width: 768px) {
    .orders-page { padding: 1rem; }
    .stats-grid { grid-template-columns: repeat(3, 1fr); }
    .search-input { width: 160px; }
    .search-input:focus { width: 180px; }
  }
</style>
@endpush

@section('content')

{{-- Theme is stored in localStorage and applied on load --}}
<div class="orders-page" id="ordersPage">

  {{-- ─── Page Header ─── --}}
  <div class="page-header">
    <div class="page-header-left">
      <h1>All Orders</h1>
      <p>Manage and track all restaurant orders in real-time</p>
    </div>
    <div class="header-actions">
      <span class="live-indicator"><span class="live-dot"></span>LIVE</span>

      <a href="{{ route('admin.orders.create') }}" class="btn-primary">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
        New Order
      </a>
    </div>
  </div>

  {{-- ─── Stats Cards ─── --}}
  <div class="stats-grid" id="statsGrid">

    <a href="{{ route('admin.orders.index') }}" style="text-decoration:none"
       class="stat-card sc-total {{ !request('status') && !request('payment') ? 'active' : '' }}"
       onclick="setActiveCard(this)">
      <div class="stat-accent-bar"></div>
      <div class="stat-icon">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
      </div>
      <div class="stat-num" data-target="{{ $stats['total'] ?? 0 }}">0</div>
      <div class="stat-lbl">Total Orders</div>
    </a>

    <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" style="text-decoration:none"
       class="stat-card sc-pending {{ request('status') === 'pending' ? 'active' : '' }}"
       onclick="setActiveCard(this)">
      <div class="stat-accent-bar"></div>
      <div class="stat-icon">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
      </div>
      <div class="stat-num" data-target="{{ $stats['pending'] ?? 0 }}">0</div>
      <div class="stat-lbl">Pending</div>
    </a>

    <a href="{{ route('admin.orders.index', ['status' => 'cooking']) }}" style="text-decoration:none"
       class="stat-card sc-cooking {{ request('status') === 'cooking' ? 'active' : '' }}"
       onclick="setActiveCard(this)">
      <div class="stat-accent-bar"></div>
      <div class="stat-icon">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M18 8h1a4 4 0 010 8h-1M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8zM6 1v3M10 1v3M14 1v3"/></svg>
      </div>
      <div class="stat-num" data-target="{{ $stats['cooking'] ?? 0 }}">0</div>
      <div class="stat-lbl">Cooking</div>
    </a>

    <a href="{{ route('admin.orders.index', ['status' => 'ready']) }}" style="text-decoration:none"
       class="stat-card sc-ready {{ request('status') === 'ready' ? 'active' : '' }}"
       onclick="setActiveCard(this)">
      <div class="stat-accent-bar"></div>
      <div class="stat-icon">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M20 6L9 17l-5-5"/></svg>
      </div>
      <div class="stat-num" data-target="{{ $stats['ready'] ?? 0 }}">0</div>
      <div class="stat-lbl">Ready</div>
    </a>

    <a href="{{ route('admin.orders.index', ['status' => 'served']) }}" style="text-decoration:none"
       class="stat-card sc-served {{ request('status') === 'served' ? 'active' : '' }}"
       onclick="setActiveCard(this)">
      <div class="stat-accent-bar"></div>
      <div class="stat-icon">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M3 11l19-9-9 19-2-8-8-2z"/></svg>
      </div>
      <div class="stat-num" data-target="{{ $stats['served'] ?? 0 }}">0</div>
      <div class="stat-lbl">Served</div>
    </a>

    <a href="{{ route('admin.orders.index', ['payment' => 'unpaid']) }}" style="text-decoration:none"
       class="stat-card sc-unpaid {{ request('payment') === 'unpaid' ? 'active' : '' }}"
       onclick="setActiveCard(this)">
      <div class="stat-accent-bar"></div>
      <div class="stat-icon">
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><path d="M1 10h22"/></svg>
      </div>
      <div class="stat-num" data-target="{{ $stats['unpaid'] ?? 0 }}">0</div>
      <div class="stat-lbl">Unpaid</div>
    </a>

  </div>

  {{-- ─── Toolbar ─── --}}
  <div class="toolbar">
    <div class="filter-pills">
      <a href="{{ route('admin.orders.index') }}"
         class="pill {{ !request('status') && !request('payment') ? 'active' : '' }}">All</a>
      @foreach(['pending','cooking','ready','served','cancelled'] as $s)
      <a href="{{ route('admin.orders.index', ['status' => $s]) }}"
         class="pill {{ request('status') === $s ? 'active' : '' }}">{{ ucfirst($s) }}</a>
      @endforeach
      <a href="{{ route('admin.orders.index', ['payment' => 'unpaid']) }}"
         class="pill pill-unpaid {{ request('payment') === 'unpaid' ? 'active' : '' }}">Unpaid</a>
    </div>
    <div class="toolbar-right">
      <div class="search-wrap">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
        <input
          type="text"
          class="search-input"
          placeholder="Search by ID or customer…"
          id="liveSearch"
          value="{{ request('search') }}"
          oninput="liveSearch(this.value)"
        >
      </div>
    </div>
  </div>

  {{-- ─── Table Card ─── --}}
  <div class="table-card">
    <div class="table-scroll">
      <table class="orders-table">
        <thead>
          <tr>
            <th>Order</th>
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
        <tbody id="ordersTableBody">
          @forelse($orders as $i => $order)
          @php
            $initials = $order->user
              ? collect(explode(' ', $order->user->name))->map(fn($w) => strtoupper(substr($w,0,1)))->take(2)->implode('')
              : 'GU';

            $typeMap = [
              'dine_in'  => ['label'=>'Dine In',   'class'=>'badge-dine'],
              'takeaway' => ['label'=>'Takeaway',   'class'=>'badge-takeaway'],
              'delivery' => ['label'=>'Delivery',   'class'=>'badge-delivery'],
            ];
            $typeInfo = $typeMap[$order->order_type ?? 'dine_in'] ?? $typeMap['dine_in'];

            $statusMap = [
              'pending'   => ['label'=>'Pending',   'class'=>'badge-pending',  'dot'=>'bdot-pending'],
              'cooking'   => ['label'=>'Cooking',   'class'=>'badge-cooking',  'dot'=>'bdot-cooking'],
              'ready'     => ['label'=>'Ready',     'class'=>'badge-ready',    'dot'=>'bdot-ready'],
              'served'    => ['label'=>'Served',    'class'=>'badge-served',   'dot'=>'bdot-served'],
              'cancelled' => ['label'=>'Cancelled', 'class'=>'badge-cancelled','dot'=>''],
            ];
            $statusInfo = $statusMap[$order->status] ?? $statusMap['served'];
          @endphp
          <tr style="animation-delay: {{ $i * 35 }}ms"
              data-search="{{ strtolower($order->user->name ?? 'guest') }} {{ $order->id }}">
            <td>
              <span class="order-id">#{{ $order->id }}</span>
            </td>
            <td>
              <div class="customer-cell">
                <div class="avatar">{{ $initials }}</div>
                <span class="customer-name">{{ $order->user->name ?? 'Guest' }}</span>
              </div>
            </td>
            <td>
              <span style="font-size:12px;color:var(--text-muted);font-family:var(--font-mono)">
                {{ $order->table ? 'T#'.$order->table->table_number : '—' }}
              </span>
            </td>
            <td>
              <span class="badge {{ $typeInfo['class'] }}">{{ $typeInfo['label'] }}</span>
            </td>
            <td>
              <span class="badge" style="background:var(--bg-base);color:var(--text-secondary);font-family:var(--font-mono)">
                {{ $order->orderItems->count() }}
              </span>
            </td>
            <td>
              <span class="amount">Rs.{{ number_format($order->total_amount, 0) }}</span>
            </td>
            <td>
              @if($order->payment_status === 'paid')
                <span class="badge badge-paid">
                  <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M20 6L9 17l-5-5"/></svg>
                  Paid
                </span>
              @else
                <span class="badge badge-unpaid">
                  <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/></svg>
                  Unpaid
                </span>
              @endif
            </td>
            <td>
              <span class="badge {{ $statusInfo['class'] }}">
                @if($statusInfo['dot'])
                  <span class="bdot {{ $statusInfo['dot'] }}"></span>
                @endif
                {{ $statusInfo['label'] }}
              </span>
            </td>
            <td>
              <span style="font-size:12px;color:var(--text-muted)">
                {{ $order->created_at->format('d M, h:i A') }}
              </span>
            </td>
            <td>
              <div style="display:flex;gap:5px">
                <a href="{{ route('admin.orders.show', $order) }}"
                   class="btn-action view" title="View Order">
                  <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                </a>
                <form method="POST" action="{{ route('admin.orders.destroy', $order) }}"
                      style="display:inline"
                      onsubmit="return confirm('Delete Order #{{ $order->id }}?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn-action del" title="Delete Order">
                    <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6M10 11v6M14 11v6M9 6V4h6v2"/></svg>
                  </button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="10">
              <div class="empty-state">
                <div class="empty-icon">
                  <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="color:var(--text-muted)">
                    <path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                  </svg>
                </div>
                <h3>No orders found</h3>
                <p>Try changing the filter or create a new order</p>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- ─── Footer with count ─── --}}
    <div class="table-footer">
      <span>Showing <strong>{{ $orders->count() }}</strong> orders</span>
      @if(method_exists($orders, 'links'))
        {{ $orders->links() }}
      @endif
    </div>
  </div>

</div>

@push('scripts')
<script>
  // ─── Stat Counter Animation ───
  function animateCounter(el) {
    const target = parseInt(el.dataset.target) || 0;
    const dur    = 700;
    let start    = null;
    function step(ts) {
      if (!start) start = ts;
      const p = Math.min((ts - start) / dur, 1);
      const ease = 1 - Math.pow(1 - p, 3);
      el.textContent = Math.round(ease * target);
      if (p < 1) requestAnimationFrame(step);
    }
    requestAnimationFrame(step);
  }

  document.querySelectorAll('.stat-num').forEach(el => animateCounter(el));

  // ─── Bar animation on load ───
  setTimeout(() => {
    document.querySelectorAll('.stat-card').forEach(c => c.classList.add('loaded'));
  }, 150);

  // ─── Active stat card ───
  function setActiveCard(card) {
    document.querySelectorAll('.stat-card').forEach(c => c.classList.remove('active'));
    card.classList.add('active');
  }

  // ─── Live Search ───
  function liveSearch(val) {
    const q = val.toLowerCase().trim();
    document.querySelectorAll('#ordersTableBody tr').forEach(row => {
      if (!row.dataset.search) return;
      row.style.display = row.dataset.search.includes(q) ? '' : 'none';
    });
  }
</script>
@endpush

@endsection