
<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('page-title', 'Dashboard Overview'); ?>

<?php $__env->startSection('content'); ?>
<style>
@import url('https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap');

/* ═══════════════════════════════════════════
   LIGHT THEME  — crisp, airy, well-contrasted
═══════════════════════════════════════════ */
.db-wrap {
    --card:          #ffffff;
    --card-border:   #e2e8f0;
    --card-shadow:   0 1px 3px rgba(0,0,0,0.04), 0 6px 20px rgba(0,0,0,0.05);
    --card-hov-sh:   0 10px 36px rgba(0,0,0,0.11);
    --text-h:        #0f172a;
    --text-b:        #334155;
    --text-s:        #64748b;
    --text-m:        #94a3b8;
    --divider:       #f1f5f9;
    --thead-bg:      #f8fafc;
    --thead-c:       #64748b;
    --row-hov:       #eff6ff;
    --qa-bg:         #f8fafc;
    --font:          'Sora', sans-serif;
    --mono:          'JetBrains Mono', monospace;
    --ease:          0.22s cubic-bezier(.4,0,.2,1);
}

/* ═══════════════════════════════════════════
   DARK THEME — deep navy #141A21
═══════════════════════════════════════════ */
body.dark-mode .db-wrap,
body.sidebar-dark-primary .db-wrap,
[data-theme="dark"] .db-wrap,
[data-bs-theme="dark"] .db-wrap {
    --card:          #1c2535;
    --card-border:   rgba(255,255,255,0.06);
    --card-shadow:   0 1px 4px rgba(0,0,0,0.3), 0 6px 22px rgba(0,0,0,0.22);
    --card-hov-sh:   0 10px 40px rgba(0,0,0,0.5);
    --text-h:        #e2eaf6;
    --text-b:        #94afc8;
    --text-s:        #6b8aaa;
    --text-m:        #3d5570;
    --divider:       rgba(255,255,255,0.05);
    --thead-bg:      #141A21;
    --thead-c:       #4a6278;
    --row-hov:       #1e2d42;
    --qa-bg:         #141A21;
}

/* ── base ── */
.db-wrap * { box-sizing:border-box; font-family:var(--font); }
.db-wrap    { background:transparent; padding:0.2rem 0 1.5rem; }

/* ═══════════════════════════════════════════
   STAT CARDS
═══════════════════════════════════════════ */
.db-stats {
    display: grid;
    grid-template-columns: repeat(6, minmax(0,1fr));
    gap: 14px;
    margin-bottom: 1.6rem;
}
@media(max-width:1200px){ .db-stats { grid-template-columns:repeat(3,1fr); } }
@media(max-width:600px) { .db-stats { grid-template-columns:repeat(2,1fr); } }

.db-sc {
    background:    var(--card);
    border:        1px solid var(--card-border);
    border-radius: 16px;
    padding:       1.2rem 1.1rem 1rem;
    position:      relative;
    overflow:      hidden;
    box-shadow:    var(--card-shadow);
    transition:    transform var(--ease), box-shadow var(--ease), border-color var(--ease);
    animation:     scUp 0.42s ease both;
    cursor:        default;
}
.db-sc:hover {
    transform:    translateY(-5px);
    box-shadow:   var(--card-hov-sh);
    border-color: var(--sc-c);
}

/* left colored border strip */
.db-sc::before {
    content: '';
    position: absolute;
    left:0; top:0; bottom:0; width:4px;
    background: var(--sc-c);
    border-radius: 16px 0 0 16px;
    transition: width var(--ease);
}
.db-sc:hover::before { width:5px; }

/* subtle tinted bg */
.db-sc::after {
    content:'';
    position:absolute; inset:0;
    background: linear-gradient(135deg, color-mix(in srgb, var(--sc-c) 6%, transparent) 0%, transparent 55%);
    pointer-events:none;
}

/* accent colors */
.db-sc.ac-amber   { --sc-c:#f59e0b; }
.db-sc.ac-blue    { --sc-c:#3b82f6; }
.db-sc.ac-cyan    { --sc-c:#06b6d4; }
.db-sc.ac-emerald { --sc-c:#10b981; }
.db-sc.ac-violet  { --sc-c:#8b5cf6; }
.db-sc.ac-rose    { --sc-c:#f43f5e; }

.sc-inner { position:relative; z-index:1; }

.sc-top {
    display:flex; align-items:center;
    justify-content:space-between;
    margin-bottom:0.55rem;
}
.sc-lbl {
    font-size:0.62rem; font-weight:700;
    text-transform:uppercase; letter-spacing:0.09em;
    color:var(--text-s);
}
/* small icon pill — replaces the big box */
.sc-icon-pill {
    width:26px; height:26px; border-radius:7px;
    display:flex; align-items:center; justify-content:center;
    font-size:0.75rem;
    background: color-mix(in srgb, var(--sc-c) 14%, transparent);
    color: var(--sc-c);
    flex-shrink:0;
    transition: transform var(--ease);
}
.db-sc:hover .sc-icon-pill { transform:rotate(-8deg) scale(1.1); }

.sc-val {
    font-size:2.1rem; font-weight:800;
    color:var(--text-h); line-height:1;
    font-family:var(--mono); letter-spacing:-1px;
    margin-bottom:0.35rem;
    transition: color var(--ease);
}
.sc-val.sm { font-size:1.05rem; letter-spacing:0; font-family:var(--font); }
.db-sc:hover .sc-val { color:var(--sc-c); }

.sc-foot {
    display:flex; align-items:center;
    justify-content:space-between;
    margin-top:0.65rem;
}
.sc-sub {
    font-size:0.67rem; font-weight:600;
    color:var(--text-s);
    display:flex; align-items:center; gap:4px;
}
.sc-sub i { font-size:0.52rem; }
.sc-sub.up     { color:#059669; }
.sc-sub.warn   { color:#d97706; }
.sc-sub.info   { color:#0891b2; }
.sc-sub.purple { color:#7c3aed; }
.sc-sub.rose   { color:#e11d48; }

/* dark mode sub labels — brighter */
body.dark-mode .sc-sub.up,   [data-theme="dark"] .sc-sub.up,   [data-bs-theme="dark"] .sc-sub.up    { color:#10d97f; }
body.dark-mode .sc-sub.warn, [data-theme="dark"] .sc-sub.warn, [data-bs-theme="dark"] .sc-sub.warn  { color:#fbbf24; }
body.dark-mode .sc-sub.info, [data-theme="dark"] .sc-sub.info, [data-bs-theme="dark"] .sc-sub.info  { color:#22d3ee; }
body.dark-mode .sc-sub.purple,[data-theme="dark"] .sc-sub.purple,[data-bs-theme="dark"] .sc-sub.purple { color:#a78bfa; }
body.dark-mode .sc-sub.rose, [data-theme="dark"] .sc-sub.rose, [data-bs-theme="dark"] .sc-sub.rose  { color:#fb7185; }

/* progress bar */
.sc-bar-track {
    flex:1; height:3px; margin-left:10px;
    background: color-mix(in srgb, var(--sc-c) 13%, transparent);
    border-radius:99px; overflow:hidden;
}
.sc-bar-fill {
    height:100%; border-radius:99px;
    background:var(--sc-c);
    transform-origin:left; transform:scaleX(0);
    transition: transform 0.75s cubic-bezier(.4,0,.2,1);
}
.db-sc.loaded .sc-bar-fill { transform:scaleX(1); }

/* stagger */
.db-sc:nth-child(1){animation-delay:.03s}
.db-sc:nth-child(2){animation-delay:.08s}
.db-sc:nth-child(3){animation-delay:.13s}
.db-sc:nth-child(4){animation-delay:.18s}
.db-sc:nth-child(5){animation-delay:.23s}
.db-sc:nth-child(6){animation-delay:.28s}

@keyframes scUp {
    from { opacity:0; transform:translateY(16px) scale(.96); }
    to   { opacity:1; transform:translateY(0)    scale(1); }
}

/* ═══════════════════════════════════════════
   SECTION PANELS
═══════════════════════════════════════════ */
.db-panel {
    background: var(--card);
    border: 1px solid var(--card-border);
    border-radius:16px; overflow:hidden;
    box-shadow: var(--card-shadow);
    transition: box-shadow var(--ease);
    animation: scUp 0.46s ease both;
}
.db-panel:hover { box-shadow: var(--card-hov-sh); }

.db-ph {
    padding:13px 18px;
    display:flex; align-items:center; justify-content:space-between;
    position:relative; overflow:hidden;
}
.db-ph::before {
    content:''; position:absolute; inset:0;
    background:linear-gradient(105deg, var(--ph-a) 0%, var(--ph-b) 100%);
}
.db-ph.ph-blue { --ph-a:#1d4ed8; --ph-b:#3b82f6; }
.db-ph.ph-teal { --ph-a:#0e7490; --ph-b:#06b6d4; }
.db-ph > * { position:relative; z-index:1; }
.db-ph h6 {
    margin:0; color:#fff; font-weight:700; font-size:0.84rem;
    display:flex; align-items:center; gap:8px;
}
.db-ph h6 i { opacity:.85; font-size:.76rem; }
.db-view-all {
    background:rgba(255,255,255,0.16); color:#fff;
    border:1px solid rgba(255,255,255,0.26);
    padding:4px 12px; border-radius:20px;
    font-size:0.72rem; font-weight:600; text-decoration:none;
    display:inline-flex; align-items:center; gap:5px;
    transition: background var(--ease), gap var(--ease);
}
.db-view-all:hover { background:rgba(255,255,255,0.28); color:#fff; gap:8px; text-decoration:none; }

/* ═══════════════════════════════════════════
   TABLE
═══════════════════════════════════════════ */
.db-tbl { width:100%; border-collapse:collapse; }
.db-tbl thead th {
    background:var(--thead-bg); color:var(--thead-c);
    font-size:0.63rem; font-weight:700;
    text-transform:uppercase; letter-spacing:0.09em;
    padding:10px 16px; border-bottom:1px solid var(--card-border);
    white-space:nowrap;
}
.db-tbl tbody tr {
    border-bottom:1px solid var(--divider);
    transition:background var(--ease);
    animation:rowIn 0.35s ease both;
}
.db-tbl tbody tr:last-child { border-bottom:none; }
.db-tbl tbody tr:hover { background:var(--row-hov); }
.db-tbl tbody td { padding:10px 16px; vertical-align:middle; font-size:0.825rem; color:var(--text-b); border:none; }
.db-tbl tbody tr:nth-child(1){animation-delay:.04s}
.db-tbl tbody tr:nth-child(2){animation-delay:.09s}
.db-tbl tbody tr:nth-child(3){animation-delay:.14s}
.db-tbl tbody tr:nth-child(4){animation-delay:.19s}
.db-tbl tbody tr:nth-child(5){animation-delay:.24s}
@keyframes rowIn { from{opacity:0;transform:translateX(-8px)} to{opacity:1;transform:translateX(0)} }

/* table elements */
.db-oid {
    background:rgba(59,130,246,0.09); color:#2563eb;
    border:1px solid rgba(59,130,246,0.18);
    padding:2px 8px; border-radius:6px;
    font-size:0.72rem; font-weight:600; font-family:var(--mono);
}
body.dark-mode .db-oid,[data-theme="dark"] .db-oid,[data-bs-theme="dark"] .db-oid { color:#60a5fa; }

.db-avatar {
    width:30px; height:30px; border-radius:8px;
    display:inline-flex; align-items:center; justify-content:center;
    font-weight:700; font-size:0.72rem; color:#fff; flex-shrink:0;
}
.db-cname { font-size:0.825rem; font-weight:600; color:var(--text-h); }

.db-chip {
    padding:3px 9px; border-radius:6px;
    font-size:0.72rem; font-weight:600;
    display:inline-flex; align-items:center; gap:4px;
}
.chip-dine { background:rgba(59,130,246,0.09); color:#2563eb; border:1px solid rgba(59,130,246,0.18); }
.chip-take { background:rgba(245,158,11,0.09); color:#b45309; border:1px solid rgba(245,158,11,0.18); }

body.dark-mode .chip-dine,[data-theme="dark"] .chip-dine,[data-bs-theme="dark"] .chip-dine { color:#60a5fa; }
body.dark-mode .chip-take,[data-theme="dark"] .chip-take,[data-bs-theme="dark"] .chip-take { color:#fbbf24; }

.db-amount { font-weight:700; color:#047857; font-size:0.825rem; font-family:var(--mono); }
body.dark-mode .db-amount,[data-theme="dark"] .db-amount,[data-bs-theme="dark"] .db-amount { color:#10d97f; }

.db-pill {
    padding:3px 10px; border-radius:20px;
    font-size:0.67rem; font-weight:700;
    text-transform:uppercase; letter-spacing:0.05em;
    display:inline-flex; align-items:center; gap:5px; white-space:nowrap;
}
.db-pill .pdot { width:5px; height:5px; border-radius:50%; background:currentColor; flex-shrink:0; }

/* light mode pill — dark enough to read on white */
.pill-pending   { background:rgba(245,158,11,0.12);  color:#92400e; border:1px solid rgba(245,158,11,0.28); }
.pill-confirmed { background:rgba(16,185,129,0.12);  color:#065f46; border:1px solid rgba(16,185,129,0.28); }
.pill-cooking   { background:rgba(239,68,68,0.12);   color:#991b1b; border:1px solid rgba(239,68,68,0.28); }
.pill-served    { background:rgba(6,182,212,0.12);   color:#155e75; border:1px solid rgba(6,182,212,0.28); }
.pill-completed { background:rgba(59,130,246,0.12);  color:#1e40af; border:1px solid rgba(59,130,246,0.28); }
.pill-cancelled { background:rgba(239,68,68,0.12);   color:#991b1b; border:1px solid rgba(239,68,68,0.28); }
.pill-processing{ background:rgba(139,92,246,0.12);  color:#5b21b6; border:1px solid rgba(139,92,246,0.28); }
.pill-ready     { background:rgba(16,185,129,0.12);  color:#065f46; border:1px solid rgba(16,185,129,0.28); }

/* dark mode pill — bright on dark bg */
body.dark-mode .pill-pending,   [data-theme="dark"] .pill-pending,   [data-bs-theme="dark"] .pill-pending   { color:#fbbf24; }
body.dark-mode .pill-confirmed, [data-theme="dark"] .pill-confirmed, [data-bs-theme="dark"] .pill-confirmed { color:#10d97f; }
body.dark-mode .pill-cooking,   [data-theme="dark"] .pill-cooking,   [data-bs-theme="dark"] .pill-cooking   { color:#f87171; }
body.dark-mode .pill-served,    [data-theme="dark"] .pill-served,    [data-bs-theme="dark"] .pill-served    { color:#22d3ee; }
body.dark-mode .pill-completed, [data-theme="dark"] .pill-completed, [data-bs-theme="dark"] .pill-completed { color:#60a5fa; }
body.dark-mode .pill-cancelled, [data-theme="dark"] .pill-cancelled, [data-bs-theme="dark"] .pill-cancelled { color:#f87171; }
body.dark-mode .pill-ready,     [data-theme="dark"] .pill-ready,     [data-bs-theme="dark"] .pill-ready     { color:#10d97f; }
body.dark-mode .pill-processing,[data-theme="dark"] .pill-processing,[data-bs-theme="dark"] .pill-processing{ color:#a78bfa; }

.db-pend-blink { animation:blink 1.3s infinite; }
@keyframes blink { 0%,100%{opacity:1;transform:scale(1)} 50%{opacity:.4;transform:scale(1.6)} }

.db-gname { font-weight:600; font-size:0.825rem; color:var(--text-h); }
.db-gsub  { font-size:0.7rem; color:var(--text-s); display:flex; align-items:center; gap:3px; margin-top:2px; }
.db-dMain { font-weight:600; font-size:0.8rem; color:var(--text-h); display:flex; align-items:center; gap:4px; }
.db-dSub  { font-size:0.7rem; color:var(--text-s); display:flex; align-items:center; gap:3px; margin-top:2px; }

.db-empty { text-align:center; padding:2.5rem 1rem; }
.db-empty i { font-size:1.8rem; color:var(--text-m); opacity:.4; display:block; margin-bottom:8px; }
.db-empty p { margin:0; font-size:0.8rem; color:var(--text-m); }

/* ═══════════════════════════════════════════
   QUICK ACTIONS
═══════════════════════════════════════════ */
.db-qa {
    background:var(--card); border:1px solid var(--card-border);
    border-radius:16px; overflow:hidden;
    box-shadow:var(--card-shadow);
    animation: scUp 0.5s 0.3s ease both;
}
.db-qa-head {
    padding:12px 18px; border-bottom:1px solid var(--divider);
    display:flex; align-items:center; gap:8px;
}
.db-qa-head i  { color:#f59e0b; font-size:0.82rem; }
.db-qa-head h6 { margin:0; font-weight:700; font-size:0.84rem; color:var(--text-h); }

.db-qa-body {
    padding:14px 18px; background:var(--qa-bg);
    display:flex; flex-wrap:wrap; gap:8px;
}
.db-qa-btn {
    display:inline-flex; align-items:center; gap:7px;
    padding:8px 16px; border-radius:9px;
    font-size:0.79rem; font-weight:600;
    text-decoration:none; border:1.5px solid transparent;
    transition:all var(--ease); position:relative; overflow:hidden;
}
.db-qa-btn i { font-size:.74rem; transition:transform var(--ease); }
.db-qa-btn:hover { transform:translateY(-3px); text-decoration:none; box-shadow:0 6px 18px rgba(0,0,0,0.12); color:#fff !important; }
.db-qa-btn:hover i { transform:scale(1.15); }

/* light mode — dark text on soft bg */
.qa-blue    { color:#1d4ed8; background:rgba(59,130,246,0.09);  border-color:rgba(59,130,246,0.22); }
.qa-blue:hover    { background:#3b82f6; border-color:#3b82f6; }
.qa-emerald { color:#065f46; background:rgba(16,185,129,0.09);  border-color:rgba(16,185,129,0.22); }
.qa-emerald:hover { background:#10b981; border-color:#10b981; }
.qa-cyan    { color:#155e75; background:rgba(6,182,212,0.09);   border-color:rgba(6,182,212,0.22); }
.qa-cyan:hover    { background:#06b6d4; border-color:#06b6d4; }
.qa-amber   { color:#92400e; background:rgba(245,158,11,0.09);  border-color:rgba(245,158,11,0.22); }
.qa-amber:hover   { background:#f59e0b; border-color:#f59e0b; }
.qa-rose    { color:#9f1239; background:rgba(244,63,94,0.09);   border-color:rgba(244,63,94,0.22); }
.qa-rose:hover    { background:#f43f5e; border-color:#f43f5e; }

/* dark mode — brighter text */
body.dark-mode .qa-blue,    [data-theme="dark"] .qa-blue,    [data-bs-theme="dark"] .qa-blue    { color:#60a5fa; }
body.dark-mode .qa-emerald, [data-theme="dark"] .qa-emerald, [data-bs-theme="dark"] .qa-emerald { color:#34d399; }
body.dark-mode .qa-cyan,    [data-theme="dark"] .qa-cyan,    [data-bs-theme="dark"] .qa-cyan    { color:#22d3ee; }
body.dark-mode .qa-amber,   [data-theme="dark"] .qa-amber,   [data-bs-theme="dark"] .qa-amber   { color:#fbbf24; }
body.dark-mode .qa-rose,    [data-theme="dark"] .qa-rose,    [data-bs-theme="dark"] .qa-rose    { color:#fb7185; }

.qa-ripple {
    position:absolute; width:6px; height:6px; border-radius:50%;
    background:rgba(255,255,255,0.45); pointer-events:none;
    animation:ripOut .5s ease-out forwards;
}
@keyframes ripOut { to { transform:scale(28); opacity:0; } }

@media(max-width:576px){
    .sc-val { font-size:1.5rem; }
    .sc-val.sm { font-size:0.95rem; }
    .db-qa-btn { width:100%; justify-content:center; }
    .db-tbl thead th, .db-tbl tbody td { padding:8px 10px; }
}
</style>

<div class="db-wrap">


<div class="db-stats mb-4">

    <div class="db-sc ac-amber">
        <div class="sc-inner">
            <div class="sc-top">
                <span class="sc-lbl">Pending Orders</span>
                <span class="sc-icon-pill"><i class="fas fa-hourglass-half"></i></span>
            </div>
            <div class="sc-val db-counter" data-target="<?php echo e($stats['pending_orders']); ?>"><?php echo e($stats['pending_orders']); ?></div>
            <div class="sc-foot">
                <span class="sc-sub warn"><i class="fas fa-circle db-pend-blink"></i> Awaiting</span>
                <div class="sc-bar-track"><div class="sc-bar-fill"></div></div>
            </div>
        </div>
    </div>

    <div class="db-sc ac-blue">
        <div class="sc-inner">
            <div class="sc-top">
                <span class="sc-lbl">Total Orders</span>
                <span class="sc-icon-pill"><i class="fas fa-receipt"></i></span>
            </div>
            <div class="sc-val db-counter" data-target="<?php echo e($stats['total_orders']); ?>"><?php echo e($stats['total_orders']); ?></div>
            <div class="sc-foot">
                <span class="sc-sub up"><i class="fas fa-arrow-up"></i> All time</span>
                <div class="sc-bar-track"><div class="sc-bar-fill"></div></div>
            </div>
        </div>
    </div>

    <div class="db-sc ac-cyan">
        <div class="sc-inner">
            <div class="sc-top">
                <span class="sc-lbl">Reservations</span>
                <span class="sc-icon-pill"><i class="fas fa-calendar-alt"></i></span>
            </div>
            <div class="sc-val db-counter" data-target="<?php echo e($stats['total_reservations']); ?>"><?php echo e($stats['total_reservations']); ?></div>
            <div class="sc-foot">
                <span class="sc-sub info"><i class="fas fa-calendar-check"></i> Booked</span>
                <div class="sc-bar-track"><div class="sc-bar-fill"></div></div>
            </div>
        </div>
    </div>

    <div class="db-sc ac-emerald">
        <div class="sc-inner">
            <div class="sc-top">
                <span class="sc-lbl">Today Revenue</span>
                <span class="sc-icon-pill"><i class="fas fa-rupee-sign"></i></span>
            </div>
            <div class="sc-val sm">Rs.&nbsp;<?php echo e(number_format($stats['today_revenue'], 0)); ?></div>
            <div class="sc-foot">
                <span class="sc-sub up"><i class="fas fa-arrow-up"></i> Today</span>
                <div class="sc-bar-track"><div class="sc-bar-fill"></div></div>
            </div>
        </div>
    </div>

    <div class="db-sc ac-violet">
        <div class="sc-inner">
            <div class="sc-top">
                <span class="sc-lbl">Menu Items</span>
                <span class="sc-icon-pill"><i class="fas fa-utensils"></i></span>
            </div>
            <div class="sc-val db-counter" data-target="<?php echo e($stats['total_menu_items']); ?>"><?php echo e($stats['total_menu_items']); ?></div>
            <div class="sc-foot">
                <span class="sc-sub purple"><i class="fas fa-list"></i> Active</span>
                <div class="sc-bar-track"><div class="sc-bar-fill"></div></div>
            </div>
        </div>
    </div>

    <div class="db-sc ac-rose">
        <div class="sc-inner">
            <div class="sc-top">
                <span class="sc-lbl">Total Users</span>
                <span class="sc-icon-pill"><i class="fas fa-users"></i></span>
            </div>
            <div class="sc-val db-counter" data-target="<?php echo e($stats['total_users']); ?>"><?php echo e($stats['total_users']); ?></div>
            <div class="sc-foot">
                <span class="sc-sub rose"><i class="fas fa-user-plus"></i> Registered</span>
                <div class="sc-bar-track"><div class="sc-bar-fill"></div></div>
            </div>
        </div>
    </div>

</div>


<div class="row mb-4">

    <div class="col-lg-7 mb-3 mb-lg-0">
        <div class="db-panel" style="animation-delay:.16s">
            <div class="db-ph ph-blue">
                <h6><i class="fas fa-receipt"></i> Recent Orders</h6>
                <a href="<?php echo e(route('admin.orders.index')); ?>" class="db-view-all">View All <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="table-responsive">
                <table class="db-tbl">
                    <thead>
                        <tr><th>Order</th><th>Customer</th><th>Type</th><th>Amount</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $h  = abs(crc32($order->user->name ?? 'G')) % 360;
                            $h2 = ($h+50)%360;
                            $pm = ['pending'=>['pill-pending',true],'cooking'=>['pill-cooking',true],'ready'=>['pill-ready',false],'served'=>['pill-served',false],'completed'=>['pill-completed',false],'cancelled'=>['pill-cancelled',false],'processing'=>['pill-processing',false]];
                            [$pc,$bl] = $pm[$order->status] ?? ['pill-pending',false];
                        ?>
                        <tr>
                            <td><span class="db-oid">#<?php echo e($order->id); ?></span></td>
                            <td>
                                <div class="d-flex align-items-center" style="gap:8px">
                                    <span class="db-avatar" style="background:linear-gradient(135deg,hsl(<?php echo e($h); ?>,52%,46%),hsl(<?php echo e($h2); ?>,52%,36%))"><?php echo e(strtoupper(substr($order->user->name ?? 'G',0,1))); ?></span>
                                    <span class="db-cname"><?php echo e($order->user->name ?? 'Guest'); ?></span>
                                </div>
                            </td>
                            <td>
                                <?php if($order->table): ?>
                                    <span class="db-chip chip-dine"><i class="fas fa-chair"></i> T#<?php echo e($order->table->table_number); ?></span>
                                <?php else: ?>
                                    <span class="db-chip chip-take"><i class="fas fa-shopping-bag"></i> Takeaway</span>
                                <?php endif; ?>
                            </td>
                            <td><span class="db-amount">Rs.&nbsp;<?php echo e(number_format($order->total_amount,0)); ?></span></td>
                            <td>
                                <span class="db-pill <?php echo e($pc); ?>">
                                    <span class="pdot <?php echo e($bl ? 'db-pend-blink':''); ?>"></span>
                                    <?php echo e(ucfirst($order->status)); ?>

                                </span>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="5"><div class="db-empty"><i class="fas fa-receipt"></i><p>No orders yet</p></div></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="db-panel" style="animation-delay:.22s">
            <div class="db-ph ph-teal">
                <h6><i class="fas fa-calendar-alt"></i> Recent Reservations</h6>
                <a href="<?php echo e(route('admin.reservations.index')); ?>" class="db-view-all">View All <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="table-responsive">
                <table class="db-tbl">
                    <thead>
                        <tr><th>Guest</th><th>Date &amp; Time</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $recentReservations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $res): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php
                            $gh  = abs(crc32($res->guest_name))%360;
                            $gh2 = ($gh+50)%360;
                            $rm  = ['confirmed'=>['pill-confirmed',false],'pending'=>['pill-pending',true],'cancelled'=>['pill-cancelled',false],'completed'=>['pill-completed',false]];
                            [$rp,$rb] = $rm[$res->status] ?? ['pill-pending',false];
                        ?>
                        <tr>
                            <td>
                                <div class="d-flex align-items-center" style="gap:8px">
                                    <span class="db-avatar" style="background:linear-gradient(135deg,hsl(<?php echo e($gh); ?>,52%,46%),hsl(<?php echo e($gh2); ?>,52%,36%))"><?php echo e(strtoupper(substr($res->guest_name,0,1))); ?></span>
                                    <div>
                                        <div class="db-gname"><?php echo e($res->guest_name); ?></div>
                                        <div class="db-gsub"><i class="fas fa-phone" style="font-size:.55rem"></i> <?php echo e($res->guest_phone); ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="db-dMain"><i class="fas fa-calendar" style="color:#3b82f6;font-size:.65rem"></i> <?php echo e(\Carbon\Carbon::parse($res->reservation_date)->format('d M Y')); ?></div>
                                <div class="db-dSub"><i class="fas fa-clock" style="font-size:.58rem"></i> <?php echo e($res->reservation_time); ?></div>
                            </td>
                            <td>
                                <span class="db-pill <?php echo e($rp); ?>">
                                    <span class="pdot <?php echo e($rb ? 'db-pend-blink':''); ?>"></span>
                                    <?php echo e(ucfirst($res->status)); ?>

                                </span>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr><td colspan="3"><div class="db-empty"><i class="fas fa-calendar-times"></i><p>No reservations yet</p></div></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>


<div class="db-qa">
    <div class="db-qa-head"><i class="fas fa-bolt"></i><h6>Quick Actions</h6></div>
    <div class="db-qa-body">
        <a href="<?php echo e(route('admin.categories.create')); ?>"  class="db-qa-btn qa-blue">    <i class="fas fa-layer-group"></i>    Add Category</a>
        <a href="<?php echo e(route('admin.menu.create')); ?>"        class="db-qa-btn qa-emerald"> <i class="fas fa-utensils"></i>       Add Menu Item</a>
        <a href="<?php echo e(route('admin.tables.create')); ?>"      class="db-qa-btn qa-cyan">    <i class="fas fa-chair"></i>          Add Table</a>
        <a href="<?php echo e(route('admin.orders.index')); ?>"       class="db-qa-btn qa-amber">   <i class="fas fa-receipt"></i>        View Orders</a>
        <a href="<?php echo e(route('admin.reservations.index')); ?>" class="db-qa-btn qa-rose">    <i class="fas fa-calendar-check"></i> View Reservations</a>
    </div>
</div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.db-counter').forEach(el => {
        const target = parseInt(el.dataset.target) || 0;
        if (!target) return;
        const steps = 950/16; let f=0;
        const t = setInterval(() => {
            f++;
            el.textContent = Math.round((1 - Math.pow(1 - f/steps, 3)) * target);
            if (f >= steps) { el.textContent = target; clearInterval(t); }
        }, 16);
    });
    setTimeout(() => {
        document.querySelectorAll('.db-sc').forEach((c,i) => setTimeout(() => c.classList.add('loaded'), i*80));
    }, 250);
    document.querySelectorAll('.db-qa-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            const r = this.getBoundingClientRect();
            const d = document.createElement('span');
            d.className = 'qa-ripple';
            d.style.top  = (e.clientY - r.top  - 3) + 'px';
            d.style.left = (e.clientX - r.left - 3) + 'px';
            this.appendChild(d);
            setTimeout(() => d.remove(), 520);
        });
    });
    const dark = document.body.classList.contains('dark-mode') || document.body.classList.contains('dark') || document.documentElement.getAttribute('data-theme') === 'dark' || document.documentElement.getAttribute('data-bs-theme') === 'dark';
    if (dark) document.documentElement.setAttribute('data-theme','dark');
});
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\RM sytem\rms\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>