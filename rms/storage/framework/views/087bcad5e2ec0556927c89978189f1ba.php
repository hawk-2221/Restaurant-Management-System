<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Orders - Admin Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet">
    
    <style>
        /* ─── CSS VARIABLES & THEMING ─── */
        :root {
            /* LIGHT THEME (default) */
            --bg-card:        #ffffff;
            --bg-card-hover:  #f8fafc;
            --bg-input:       #f1f5f9;
            --bg-body:        #f3f4f6;
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

        /* DARK THEME */
        [data-theme="dark"] {
            --bg-card:        #1e2733;
            --bg-card-hover:  #243040;
            --bg-input:       #1a2231;
            --bg-body:        #0f131a;
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

        /* ─── RESET & BASE ─── */
        * { box-sizing: border-box; font-family: var(--font-main); margin: 0; padding: 0; outline: none; }
        body { background: var(--bg-body); color: var(--text-primary); min-height: 100vh; padding: 1.5rem; }
        a { text-decoration: none; color: inherit; }
        button { border: none; background: none; cursor: pointer; font-family: inherit; }

        /* ─── PAGE CONTAINER ─── */
        .orders-page { max-width: 1400px; margin: 0 auto; }

        /* ─── Page Header ─── */
        .page-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.75rem; flex-wrap: wrap; gap: 12px; }
        .page-header-left h1 { font-size: 22px; font-weight: 600; letter-spacing: -0.3px; line-height: 1.2; }
        .page-header-left p { font-size: 13px; color: var(--text-muted); margin-top: 3px; }
        .header-actions { display: flex; gap: 10px; align-items: center; }

        /* ─── Theme Toggle ─── */
        .theme-toggle {
            width: 40px; height: 40px;
            border-radius: var(--radius-sm);
            background: var(--bg-card);
            border: 1px solid var(--border);
            color: var(--text-secondary);
            display: flex; align-items: center; justify-content: center;
            transition: var(--transition);
        }
        .theme-toggle:hover { border-color: var(--border-hover); color: var(--text-primary); }

        /* ─── Live Badge ─── */
        .live-indicator { display: inline-flex; align-items: center; gap: 6px; background: var(--red-soft); color: var(--red); font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 20px; letter-spacing: 0.04em; border: 1px solid rgba(239,68,68,0.2); }
        .live-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--red); animation: livePulse 1.4s infinite; }
        @keyframes livePulse { 0%,100% { opacity:1; transform:scale(1); } 50% { opacity:0.4; transform:scale(1.5); } }

        /* ─── Stats Grid ─── */
        .stats-grid { display: grid; grid-template-columns: repeat(6, minmax(0, 1fr)); gap: 12px; margin-bottom: 1.5rem; }
        @media (max-width: 1100px) { .stats-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 600px)  { .stats-grid { grid-template-columns: repeat(2, 1fr); } }

        .stat-card {
            background: var(--bg-card); border: 1px solid var(--border);
            border-radius: var(--radius-md); padding: 1.1rem 1rem;
            cursor: pointer; position: relative; overflow: hidden;
            transition: all var(--transition); box-shadow: var(--shadow-sm);
            animation: statReveal 0.5s ease both;
            color: var(--text-primary); /* Ensures text color doesn't inherit active link color */
        }
        .stat-card:nth-child(1) { animation-delay: 0ms; } .stat-card:nth-child(2) { animation-delay: 60ms; }
        .stat-card:nth-child(3) { animation-delay: 120ms; } .stat-card:nth-child(4) { animation-delay: 180ms; }
        .stat-card:nth-child(5) { animation-delay: 240ms; } .stat-card:nth-child(6) { animation-delay: 300ms; }
        @keyframes statReveal { from { opacity:0; transform:translateY(10px) scale(0.97); } to { opacity:1; transform:translateY(0) scale(1); } }

        .stat-card:hover { transform: translateY(-3px); box-shadow: var(--shadow-md); border-color: var(--border-hover); }
        .stat-card.active { border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-soft), var(--shadow-md); }
        .stat-card.active .stat-num { color: inherit; } /* Keep the stat card specific color */

        .stat-icon { width: 34px; height: 34px; border-radius: var(--radius-sm); display: flex; align-items: center; justify-content: center; margin-bottom: 10px; font-size: 15px; }
        .stat-num { font-size: 28px; font-weight: 600; line-height: 1; font-variant-numeric: tabular-nums; font-family: var(--font-mono); }
        .stat-lbl { font-size: 11px; color: var(--text-muted); margin-top: 5px; text-transform: uppercase; letter-spacing: 0.06em; font-weight: 500; }
        .stat-accent-bar { position: absolute; top: 0; left: 0; right: 0; height: 3px; border-radius: var(--radius-md) var(--radius-md) 0 0; transform: scaleX(0); transform-origin: left; transition: transform 0.6s cubic-bezier(0.4,0,0.2,1); }
        .stat-card.loaded .stat-accent-bar { transform: scaleX(1); }

        /* Stat color variants */
        .sc-total  .stat-icon { background: var(--accent-soft); color: var(--accent); }
        .sc-total  .stat-accent-bar { background: var(--accent); } .sc-total  .stat-num { color: var(--accent); }
        
        .sc-pending .stat-icon { background: var(--orange-soft); color: var(--orange); }
        .sc-pending .stat-accent-bar { background: var(--orange); } .sc-pending .stat-num { color: var(--orange); }
        
        .sc-cooking .stat-icon { background: var(--red-soft); color: var(--red); }
        .sc-cooking .stat-accent-bar { background: var(--red); } .sc-cooking .stat-num { color: var(--red); }
        
        .sc-ready .stat-icon { background: var(--green-soft); color: var(--green); }
        .sc-ready .stat-accent-bar { background: var(--green); } .sc-ready .stat-num { color: var(--green); }
        
        .sc-served .stat-icon { background: var(--teal-soft); color: var(--teal); }
        .sc-served .stat-accent-bar { background: var(--teal); } .sc-served .stat-num { color: var(--teal); }
        
        .sc-unpaid .stat-icon { background: var(--pink-soft); color: var(--pink); }
        .sc-unpaid .stat-accent-bar { background: var(--pink); } .sc-unpaid .stat-num { color: var(--pink); }

        /* ─── Toolbar ─── */
        .toolbar { display: flex; justify-content: space-between; align-items: center; gap: 12px; margin-bottom: 1rem; flex-wrap: wrap; }
        .filter-pills { display: flex; gap: 6px; flex-wrap: wrap; align-items: center; }

        .pill { padding: 6px 14px; border-radius: 20px; font-size: 12px; font-weight: 500; cursor: pointer; border: 1px solid var(--border); background: var(--bg-card); color: var(--text-secondary); transition: all var(--transition); box-shadow: var(--shadow-sm); white-space: nowrap; }
        .pill:hover { border-color: var(--border-hover); color: var(--text-primary); background: var(--bg-card-hover); transform: translateY(-1px); }
        .pill.active { background: var(--accent); border-color: var(--accent); color: #fff; box-shadow: 0 3px 10px rgba(45,110,245,0.35); }
        .pill.pill-unpaid.active { background: var(--pink); border-color: var(--pink); box-shadow: 0 3px 10px rgba(236,72,153,0.35); }

        .toolbar-right { display: flex; gap: 8px; align-items: center; }

        /* ─── Search Input ─── */
        .search-wrap { position: relative; display: flex; align-items: center; }
        .search-wrap svg { position: absolute; left: 11px; color: var(--text-muted); pointer-events: none; }
        .search-input { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 8px 12px 8px 34px; font-size: 13px; color: var(--text-primary); outline: none; width: 200px; transition: all var(--transition); box-shadow: var(--shadow-sm); }
        .search-input::placeholder { color: var(--text-muted); }
        .search-input:focus { border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-soft); width: 240px; }

        /* ─── Buttons ─── */
        .btn-primary { display: inline-flex; align-items: center; gap: 7px; padding: 8px 16px; background: var(--accent); color: #fff; border-radius: var(--radius-sm); font-size: 13px; font-weight: 500; cursor: pointer; transition: all var(--transition); box-shadow: 0 3px 10px rgba(45,110,245,0.3); white-space: nowrap; }
        .btn-primary:hover { background: var(--accent-hover); transform: translateY(-1px); box-shadow: 0 5px 14px rgba(45,110,245,0.4); }

        /* ─── Table Card ─── */
        .table-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: var(--radius-lg); overflow: hidden; box-shadow: var(--shadow-sm); animation: cardReveal 0.4s ease 0.1s both; }
        @keyframes cardReveal { from { opacity:0; transform:translateY(8px); } to { opacity:1; transform:translateY(0); } }

        /* ─── Table ─── */
        .orders-table { width: 100%; border-collapse: collapse; }
        .orders-table thead th { padding: 11px 16px; font-size: 10.5px; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.07em; background: rgba(255,255,255,0.03); border-bottom: 1px solid var(--border); text-align: left; white-space: nowrap; }
        .orders-table tbody tr { border-bottom: 1px solid var(--border); transition: background var(--transition); animation: rowIn 0.3s ease both; }
        .orders-table tbody tr:last-child { border-bottom: none; }
        .orders-table tbody tr:hover { background: var(--bg-card-hover); }
        @keyframes rowIn { from { opacity:0; transform:translateX(-6px); } to { opacity:1; transform:translateX(0); } }
        .orders-table td { padding: 11px 16px; font-size: 13px; color: var(--text-primary); vertical-align: middle; }

        /* ─── Badges ─── */
        .badge { display: inline-flex; align-items: center; gap: 5px; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; white-space: nowrap; letter-spacing: 0.02em; }
        .bdot { width:6px; height:6px; border-radius:50%; flex-shrink:0; }

        .badge-pending  { background:var(--orange-soft); color:var(--orange); }
        .bdot-pending   { background:var(--orange); }
        .badge-cooking  { background:var(--red-soft); color:var(--red); }
        .bdot-cooking   { background:var(--red); animation:livePulse 1.2s infinite; }
        .badge-ready    { background:var(--green-soft); color:var(--green); }
        .bdot-ready     { background:var(--green); }
        .badge-served   { background:var(--teal-soft); color:var(--teal); }
        .bdot-served    { background:var(--teal); }
        .badge-cancelled{ background:rgba(100,116,139,0.12); color:#64748b; }
        .badge-paid   { background:var(--green-soft); color:var(--green); }
        .badge-unpaid { background:var(--orange-soft); color:var(--orange); }
        .badge-dine     { background:var(--purple-soft); color:var(--purple); }
        .badge-takeaway { background:var(--accent-soft); color:var(--accent); }
        .badge-delivery { background:var(--teal-soft); color:var(--teal); }

        .order-id { font-family: var(--font-mono); font-size: 12.5px; font-weight: 500; color: var(--accent); background: var(--accent-soft); padding: 3px 9px; border-radius: var(--radius-sm); letter-spacing: 0.02em; }
        .amount { font-family: var(--font-mono); font-weight: 500; color: var(--green); font-size: 13px; }

        .btn-action { display: inline-flex; align-items: center; justify-content: center; width: 30px; height: 30px; border-radius: var(--radius-sm); border: 1px solid var(--border); background: transparent; cursor: pointer; color: var(--text-secondary); transition: all var(--transition); }
        .btn-action:hover { border-color: var(--border-hover); color: var(--text-primary); background: var(--bg-card-hover); }
        .btn-action.view:hover { background:var(--accent-soft); border-color:var(--accent); color:var(--accent); }
        .btn-action.del:hover  { background:var(--red-soft); border-color:var(--red); color:var(--red); }

        /* ─── Empty State ─── */
        .empty-state { text-align: center; padding: 4rem 2rem; color: var(--text-muted); }
        .empty-icon { width: 56px; height: 56px; margin: 0 auto 16px; background: rgba(255,255,255,0.04); border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 1px solid var(--border); }
        .empty-state h3 { font-size: 15px; color: var(--text-secondary); font-weight: 500; }
        .empty-state p  { font-size: 13px; margin-top: 5px; }

        /* ─── Table Footer ─── */
        .table-footer { display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; border-top: 1px solid var(--border); background: rgba(255,255,255,0.02); font-size: 12px; color: var(--text-muted); }

        /* ─── Customer Cell ─── */
        .customer-cell { display: flex; align-items: center; gap: 9px; }
        .avatar { width: 30px; height: 30px; border-radius: 50%; background: var(--accent-soft); color: var(--accent); display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 600; flex-shrink: 0; border: 1px solid var(--border); }
        .customer-name { font-size: 13px; color: var(--text-primary); font-weight: 500; }

        /* ─── MODAL (New Addition) ─── */
        .modal-overlay {
            position: fixed; top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.5); z-index: 1000;
            display: none; align-items: center; justify-content: center;
            backdrop-filter: blur(2px);
        }
        .modal-overlay.open { display: flex; animation: fadeIn 0.2s ease-out; }
        .modal-card {
            background: var(--bg-card); width: 100%; max-width: 450px;
            border-radius: var(--radius-lg); padding: 24px;
            box-shadow: var(--shadow-md); border: 1px solid var(--border);
            animation: slideUp 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
        @keyframes slideUp { from { transform: translateY(20px) scale(0.98); opacity: 0; } to { transform: translateY(0) scale(1); opacity: 1; } }

        .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .modal-title { font-size: 18px; font-weight: 600; color: var(--text-primary); }
        .close-modal { color: var(--text-muted); font-size: 20px; transition: 0.2s; }
        .close-modal:hover { color: var(--text-primary); transform: rotate(90deg); }

        .form-group { margin-bottom: 16px; }
        .form-label { display: block; font-size: 12px; font-weight: 500; color: var(--text-secondary); margin-bottom: 6px; }
        .form-input, .form-select {
            width: 100%; padding: 10px; background: var(--bg-input); border: 1px solid var(--border);
            border-radius: var(--radius-sm); color: var(--text-primary); font-size: 14px;
            transition: var(--transition);
        }
        .form-input:focus, .form-select:focus { border-color: var(--accent); box-shadow: 0 0 0 3px var(--accent-soft); }
        .modal-footer { display: flex; justify-content: flex-end; gap: 10px; margin-top: 24px; }

        .btn-cancel { padding: 8px 16px; border-radius: var(--radius-sm); font-size: 13px; font-weight: 500; color: var(--text-secondary); background: var(--bg-input); transition: var(--transition); }
        .btn-cancel:hover { background: var(--border); color: var(--text-primary); }

        .detail-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 13px; }
        .detail-label { color: var(--text-muted); }
        .detail-value { font-weight: 500; color: var(--text-primary); }
        
        /* ─── Toast Notification ─── */
        .toast {
            position: fixed; bottom: 20px; right: 20px;
            background: var(--bg-card); color: var(--text-primary);
            padding: 12px 16px; border-radius: var(--radius-md);
            box-shadow: var(--shadow-md); border: 1px solid var(--border);
            display: flex; align-items: center; gap: 10px;
            transform: translateY(100px); opacity: 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 2000;
        }
        .toast.show { transform: translateY(0); opacity: 1; }
        .toast-icon { width: 20px; height: 20px; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 12px; }
        .toast-success .toast-icon { background: var(--green); }
        .toast-error .toast-icon { background: var(--red); }

        /* Responsive */
        @media (max-width: 768px) {
            .orders-page { padding: 0; }
            .stats-grid { grid-template-columns: repeat(3, 1fr); }
            .search-input { width: 160px; }
            .search-input:focus { width: 180px; }
            .table-scroll { overflow-x: auto; }
            .page-header { flex-direction: column; align-items: flex-start; }
            .header-actions { width: 100%; justify-content: space-between; margin-top: 10px; }
        }
    </style>
</head>
<body>

<div class="orders-page">
    <!-- ─── Page Header ─── -->
    <div class="page-header">
        <div class="page-header-left">
            <h1>All Orders</h1>
            <p>Manage and track all restaurant orders in real-time</p>
        </div>
        <div class="header-actions">
            <span class="live-indicator"><span class="live-dot"></span>LIVE</span>
            
            <!-- Theme Toggle -->
            <button class="theme-toggle" id="themeToggle" title="Toggle Theme">
                <!-- Sun Icon -->
                <svg id="iconSun" style="display:none" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <!-- Moon Icon -->
                <svg id="iconMoon" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M20.354 24.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
            </button>

            <button class="btn-primary" onclick="openModal('modalCreate')">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                New Order
            </button>
        </div>
    </div>

    <!-- ─── Stats Cards ─── -->
    <div class="stats-grid" id="statsGrid">
        <!-- Injected via JS -->
    </div>

    <!-- ─── Toolbar ─── -->
    <div class="toolbar">
        <div class="filter-pills" id="filterPills">
            <!-- Injected via JS -->
        </div>
        <div class="toolbar-right">
            <div class="search-wrap">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <input type="text" class="search-input" placeholder="Search by ID or customer…" id="liveSearch">
            </div>
        </div>
    </div>

    <!-- ─── Table Card ─── -->
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
                    <!-- Injected via JS -->
                </tbody>
            </table>
        </div>
        <div class="table-footer">
            <span id="showingCount">Showing <strong>0</strong> orders</span>
        </div>
    </div>
</div>

<!-- ─── CREATE ORDER MODAL ─── -->
<div class="modal-overlay" id="modalCreate">
    <div class="modal-card">
        <div class="modal-header">
            <h3 class="modal-title">Create New Order</h3>
            <button class="close-modal" onclick="closeModal('modalCreate')">&times;</button>
        </div>
        <form id="createOrderForm">
            <div class="form-group">
                <label class="form-label">Customer Name</label>
                <input type="text" class="form-input" name="customer" required placeholder="e.g. John Doe">
            </div>
            <div class="form-group" style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
                <div>
                    <label class="form-label">Table Number</label>
                    <input type="number" class="form-input" name="table" required placeholder="5">
                </div>
                <div>
                    <label class="form-label">Order Type</label>
                    <select class="form-select" name="type">
                        <option value="dine_in">Dine In</option>
                        <option value="takeaway">Takeaway</option>
                        <option value="delivery">Delivery</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="form-label">Total Amount (Rs)</label>
                <input type="number" class="form-input" name="amount" required placeholder="0.00">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('modalCreate')">Cancel</button>
                <button type="submit" class="btn-primary">Create Order</button>
            </div>
        </form>
    </div>
</div>

<!-- ─── VIEW ORDER MODAL ─── -->
<div class="modal-overlay" id="modalView">
    <div class="modal-card">
        <div class="modal-header">
            <h3 class="modal-title">Order Details</h3>
            <button class="close-modal" onclick="closeModal('modalView')">&times;</button>
        </div>
        <div id="viewOrderContent">
            <!-- Content injected via JS -->
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-primary" onclick="closeModal('modalView')">Close</button>
        </div>
    </div>
</div>

<!-- ─── TOAST NOTIFICATION ─── -->
<div class="toast" id="toast">
    <div class="toast-icon" id="toastIcon">✓</div>
    <span id="toastMessage">Operation successful</span>
</div>

<script>
    // ─── STATE MANAGEMENT ───
    const state = {
        filter: 'all', // all, pending, cooking, ready, served, cancelled, unpaid
        search: '',
        orders: [
            { id: 1042, customer: 'Sarah Connor', table: 12, type: 'dine_in', items: 3, total: 1500, status: 'ready', payment: 'paid', time: 'Oct 24, 10:30 AM' },
            { id: 1041, customer: 'John Wick', table: 5, type: 'dine_in', items: 1, total: 450, status: 'cooking', payment: 'paid', time: 'Oct 24, 10:15 AM' },
            { id: 1040, customer: 'Tony Stark', table: null, type: 'delivery', items: 5, total: 3200, status: 'pending', payment: 'unpaid', time: 'Oct 24, 10:00 AM' },
            { id: 1039, customer: 'Bruce Wayne', table: 8, type: 'dine_in', items: 2, total: 1200, status: 'served', payment: 'paid', time: 'Oct 24, 09:45 AM' },
            { id: 1038, customer: 'Peter Parker', table: null, type: 'takeaway', items: 4, total: 950, status: 'ready', payment: 'paid', time: 'Oct 24, 09:30 AM' },
            { id: 1037, customer: 'Clark Kent', table: 3, type: 'dine_in', items: 3, total: 1800, status: 'cancelled', payment: 'unpaid', time: 'Oct 24, 09:15 AM' },
        ]
    };

    // ─── CONFIG & MAPPINGS ───
    const statusMap = {
        'pending'   : { label:'Pending',   class:'badge-pending',  dot:'bdot-pending' },
        'cooking'   : { label:'Cooking',   class:'badge-cooking',  dot:'bdot-cooking' },
        'ready'     : { label:'Ready',     class:'badge-ready',    dot:'bdot-ready' },
        'served'    : { label:'Served',    class:'badge-served',   dot:'bdot-served' },
        'cancelled' : { label:'Cancelled', class:'badge-cancelled',dot:'' },
    };
    const typeMap = {
        'dine_in'  : { label:'Dine In',   class:'badge-dine' },
        'takeaway' : { label:'Takeaway',  class:'badge-takeaway' },
        'delivery' : { label:'Delivery',  class:'badge-delivery' },
    };

    // ─── DOM ELEMENTS ───
    const els = {
        statsGrid: document.getElementById('statsGrid'),
        filterPills: document.getElementById('filterPills'),
        tableBody: document.getElementById('ordersTableBody'),
        showingCount: document.getElementById('showingCount'),
        searchInput: document.getElementById('liveSearch'),
        themeToggle: document.getElementById('themeToggle'),
    };

    // ─── INITIALIZATION ───
    function init() {
        renderStats();
        renderPills();
        renderTable();
        setupEvents();
        animateCounters();
        
        // Load theme
        if(localStorage.getItem('theme') === 'dark') {
            document.documentElement.setAttribute('data-theme', 'dark');
            updateThemeIcons(true);
        }
    }

    // ─── RENDERING ───
    function renderStats() {
        const stats = {
            total: state.orders.length,
            pending: state.orders.filter(o => o.status === 'pending').length,
            cooking: state.orders.filter(o => o.status === 'cooking').length,
            ready: state.orders.filter(o => o.status === 'ready').length,
            served: state.orders.filter(o => o.status === 'served').length,
            unpaid: state.orders.filter(o => o.payment === 'unpaid').length,
        };

        const config = [
            { key: 'total', label: 'Total Orders', cls: 'sc-total', icon: '<rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/>' },
            { key: 'pending', label: 'Pending', cls: 'sc-pending', icon: '<circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/>' },
            { key: 'cooking', label: 'Cooking', cls: 'sc-cooking', icon: '<path d="M18 8h1a4 4 0 010 8h-1M2 8h16v9a4 4 0 01-4 4H6a4 4 0 01-4-4V8zM6 1v3M10 1v3M14 1v3"/>' },
            { key: 'ready', label: 'Ready', cls: 'sc-ready', icon: '<path d="M20 6L9 17l-5-5"/>' },
            { key: 'served', label: 'Served', cls: 'sc-served', icon: '<path d="M3 11l19-9-9 19-2-8-8-2z"/>' },
            { key: 'unpaid', label: 'Unpaid', cls: 'sc-unpaid', icon: '<rect x="1" y="4" width="22" height="16" rx="2"/><path d="M1 10h22"/>' },
        ];

        els.statsGrid.innerHTML = config.map(c => `
            <div class="stat-card ${c.cls} ${state.filter === c.key ? 'active' : ''}" onclick="setFilter('${c.key}')">
                <div class="stat-accent-bar"></div>
                <div class="stat-icon"><svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">${c.icon}</svg></div>
                <div class="stat-num" data-target="${stats[c.key]}">${stats[c.key]}</div>
                <div class="stat-lbl">${c.label}</div>
            </div>
        `).join('');
    }

    function renderPills() {
        const pills = ['All', 'Pending', 'Cooking', 'Ready', 'Served', 'Cancelled'];
        // Map names to keys
        const keyMap = { 'All': 'all', 'Pending': 'pending', 'Cooking': 'cooking', 'Ready': 'ready', 'Served': 'served', 'Cancelled': 'cancelled' };
        
        els.filterPills.innerHTML = pills.map(p => {
            const key = keyMap[p];
            const active = state.filter === key ? 'active' : '';
            const unpaidClass = p === 'Unpaid' ? 'pill-unpaid' : '';
            // Note: Unpaid is not in the loop above, handle separately if needed, or add to loop. 
            // Adding Unpaid manually for now to match original design exactly.
            return `<a class="pill ${active}" onclick="setFilter('${key}')">${p}</a>`;
        }).join('') + `
            <a class="pill pill-unpaid ${state.filter === 'unpaid' ? 'active' : ''}" onclick="setFilter('unpaid')">Unpaid</a>
        `;
    }

    function renderTable() {
        // Filter Logic
        let filtered = state.orders.filter(o => {
            // Status Filter
            if (state.filter !== 'all' && state.filter !== 'unpaid') {
                if (o.status !== state.filter) return false;
            }
            // Unpaid Filter
            if (state.filter === 'unpaid') {
                if (o.payment !== 'unpaid') return false;
            }
            // Search Filter
            if (state.search) {
                const q = state.search.toLowerCase();
                const searchStr = `${o.id} ${o.customer} ${o.table || ''}`.toLowerCase();
                if (!searchStr.includes(q)) return false;
            }
            return true;
        });

        els.showingCount.innerHTML = `Showing <strong>${filtered.length}</strong> orders`;

        if (filtered.length === 0) {
            els.tableBody.innerHTML = `
                <tr>
                    <td colspan="10">
                        <div class="empty-state">
                            <div class="empty-icon">
                                <svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="color:var(--text-muted)"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            </div>
                            <h3>No orders found</h3>
                            <p>Try changing the filter or create a new order</p>
                        </div>
                    </td>
                </tr>`;
            return;
        }

        els.tableBody.innerHTML = filtered.map((o, i) => {
            const initials = o.customer.split(' ').map(n=>n[0]).join('').substring(0,2).toUpperCase();
            const statusInfo = statusMap[o.status] || statusMap['served'];
            const typeInfo = typeMap[o.type] || typeMap['dine_in'];
            const isPaid = o.payment === 'paid';

            return `
            <tr style="animation-delay: ${i * 35}ms">
                <td><span class="order-id">#${o.id}</span></td>
                <td>
                    <div class="customer-cell">
                        <div class="avatar">${initials}</div>
                        <span class="customer-name">${o.customer}</span>
                    </div>
                </td>
                <td><span style="font-size:12px;color:var(--text-muted);font-family:var(--font-mono)">${o.table ? 'T#'+o.table : '—'}</span></td>
                <td><span class="badge ${typeInfo.class}">${typeInfo.label}</span></td>
                <td><span class="badge" style="background:rgba(0,0,0,0.03);color:var(--text-secondary);font-family:var(--font-mono)">${o.items}</span></td>
                <td><span class="amount">Rs.${o.total.toLocaleString()}</span></td>
                <td>
                    <span class="badge ${isPaid ? 'badge-paid' : 'badge-unpaid'}">
                        <svg width="10" height="10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                            ${isPaid ? '<path d="M20 6L9 17l-5-5"/>' : '<circle cx="12" cy="12" r="10"/><path d="M12 8v4M12 16h.01"/>'}
                        </svg>
                        ${isPaid ? 'Paid' : 'Unpaid'}
                    </span>
                </td>
                <td>
                    <span class="badge ${statusInfo.class}">
                        ${statusInfo.dot ? `<span class="bdot ${statusInfo.dot}"></span>` : ''}
                        ${statusInfo.label}
                    </span>
                </td>
                <td><span style="font-size:12px;color:var(--text-muted)">${o.time}</span></td>
                <td>
                    <div style="display:flex;gap:5px">
                        <button class="btn-action view" onclick="viewOrder(${o.id})" title="View Order">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                        <button class="btn-action del" onclick="deleteOrder(${o.id})" title="Delete Order">
                            <svg width="13" height="13" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6M10 11v6M14 11v6M9 6V4h6v2"/></svg>
                        </button>
                    </div>
                </td>
            </tr>
            `;
        }).join('');
    }

    // ─── ACTIONS ───
    function setFilter(filterKey) {
        state.filter = filterKey;
        renderStats(); // Updates active class and counts
        renderPills();  // Updates active pills
        renderTable();
    }

    window.deleteOrder = function(id) {
        if(confirm('Delete Order #'+id+'?')) {
            state.orders = state.orders.filter(o => o.id !== id);
            refreshUI();
            showToast('Order deleted successfully', 'success');
        }
    };

    window.viewOrder = function(id) {
        const order = state.orders.find(o => o.id === id);
        if(!order) return;

        const statusInfo = statusMap[order.status];
        const typeInfo = typeMap[order.type];
        
        const html = `
            <div class="detail-row"><span class="detail-label">Order ID</span> <span class="detail-value">#${order.id}</span></div>
            <div class="detail-row"><span class="detail-label">Customer</span> <span class="detail-value">${order.customer}</span></div>
            <div class="detail-row"><span class="detail-label">Table</span> <span class="detail-value">${order.table ? 'Table '+order.table : 'N/A'}</span></div>
            <div class="detail-row"><span class="detail-label">Type</span> <span class="detail-value">${typeInfo.label}</span></div>
            <hr style="border:0; border-top:1px solid var(--border); margin: 10px 0;">
            <div class="detail-row"><span class="detail-label">Status</span> <span class="badge ${statusInfo.class}">${statusInfo.label}</span></div>
            <div class="detail-row"><span class="detail-label">Payment</span> <span class="detail-value" style="color:${order.payment==='paid'?'var(--green)':'var(--orange)'}">${order.payment.toUpperCase()}</span></div>
            <div class="detail-row"><span class="detail-label">Total</span> <span class="detail-value">Rs.${order.total.toLocaleString()}</span></div>
            <div class="detail-row"><span class="detail-label">Time</span> <span class="detail-value">${order.time}</span></div>
        `;
        document.getElementById('viewOrderContent').innerHTML = html;
        openModal('modalView');
    };

    // ─── CREATE ORDER FORM ───
    document.getElementById('createOrderForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(e.target);
        
        const newOrder = {
            id: 1000 + state.orders.length + 1 + Math.floor(Math.random() * 100),
            customer: formData.get('customer'),
            table: formData.get('table') ? parseInt(formData.get('table')) : null,
            type: formData.get('type'),
            items: 1, // default for mock
            total: parseFloat(formData.get('amount')),
            status: 'pending',
            payment: 'unpaid',
            time: new Date().toLocaleString('en-US', { month: 'short', day: 'numeric', hour: 'numeric', minute: '2-digit', hour12: true })
        };

        state.orders.unshift(newOrder); // Add to top
        refreshUI();
        closeModal('modalCreate');
        e.target.reset();
        showToast('New order created successfully', 'success');
    });

    // ─── HELPERS ───
    function refreshUI() {
        renderStats();
        renderTable();
    }

    function setupEvents() {
        els.searchInput.addEventListener('input', (e) => {
            state.search = e.target.value;
            renderTable();
        });

        els.themeToggle.addEventListener('click', () => {
            const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
            const newTheme = isDark ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcons(!isDark);
        });
    }

    function updateThemeIcons(isDark) {
        document.getElementById('iconSun').style.display = isDark ? 'block' : 'none';
        document.getElementById('iconMoon').style.display = isDark ? 'none' : 'block';
    }

    function animateCounters() {
        document.querySelectorAll('.stat-num').forEach(el => {
            const target = parseInt(el.dataset.target) || 0;
            const start = 0;
            const duration = 700;
            const startTime = performance.now();

            function update(currentTime) {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const ease = 1 - Math.pow(1 - progress, 3); // Cubic ease out
                const current = Math.floor(start + (target - start) * ease);
                el.textContent = current;
                if (progress < 1) requestAnimationFrame(update);
            }
            requestAnimationFrame(update);
        });

        // Trigger bar animation
        setTimeout(() => document.querySelectorAll('.stat-card').forEach(c => c.classList.add('loaded')), 150);
    }

    // Modal Logic
    window.openModal = function(id) {
        const modal = document.getElementById(id);
        modal.classList.add('open');
        if(id === 'modalCreate') modal.querySelector('input').focus();
    };
    window.closeModal = function(id) {
        document.getElementById(id).classList.remove('open');
    };

    // Close modal on outside click
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) overlay.classList.remove('open');
        });
    });

    // Toast Logic
    function showToast(msg, type) {
        const toast = document.getElementById('toast');
        const icon = document.getElementById('toastIcon');
        const txt = document.getElementById('toastMessage');
        
        toast.className = `toast toast-${type} show`;
        icon.textContent = type === 'success' ? '✓' : '!';
        txt.textContent = msg;

        setTimeout(() => {
            toast.classList.remove('show');
        }, 3000);
    }

    // Run
    init();
</script>

</body>
</html><?php /**PATH D:\RM sytem\rms\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>