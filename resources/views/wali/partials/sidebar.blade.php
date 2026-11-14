<style>
    * { box-sizing: border-box; }
    .wali-sidebar { position: fixed; top:0; left:0; width:260px; height:100vh; display:flex; flex-direction:column; background:#212529; color:#fff; z-index:1040; transition:width .25s ease, transform .25s ease; }
    .wali-sidebar-header { position:relative; height:82px; display:flex; align-items:center; padding:16px; border-bottom:1px solid rgba(255,255,255,.15); flex-shrink:0; }
    .wali-brand-logo,.wali-mobile-brand-logo { display:flex; align-items:center; justify-content:center; background:#fff; color:#212529; border-radius:12px; font-weight:800; flex-shrink:0; }
    .wali-brand-logo { width:48px; height:48px; font-size:16px; }
    .wali-brand-text { margin-left:12px; overflow:hidden; white-space:nowrap; transition:opacity .2s ease, width .2s ease, margin .2s ease; }
    .wali-brand-title { font-size:18px; font-weight:800; line-height:1.2; }
    .wali-brand-subtitle { font-size:11px; color:rgba(255,255,255,.65); }
    .wali-sidebar-toggle { position:absolute; top:28px; right:-14px; width:28px; height:28px; border:none; border-radius:50%; background:#fff; color:#212529; display:flex; align-items:center; justify-content:center; box-shadow:0 2px 8px rgba(0,0,0,.25); cursor:pointer; z-index:3; transition:transform .25s ease; }
    .wali-sidebar-menu { flex:1; min-height:0; overflow-y:auto; overflow-x:hidden; padding:14px 10px; scrollbar-width:thin; }
    .wali-sidebar-menu::-webkit-scrollbar { width:6px; }
    .wali-sidebar-menu::-webkit-scrollbar-thumb { background:rgba(255,255,255,.25); border-radius:10px; }
    .wali-sidebar-menu::-webkit-scrollbar-track { background:transparent; }
    .wali-menu-link { display:flex; align-items:center; min-height:44px; padding:9px 12px; margin-bottom:4px; color:rgba(255,255,255,.86); text-decoration:none; border-radius:8px; white-space:nowrap; transition:background .2s ease, color .2s ease; }
    .wali-menu-link i { width:24px; font-size:18px; text-align:center; flex-shrink:0; }
    .wali-menu-text { margin-left:10px; overflow:hidden; transition:opacity .2s ease, width .2s ease, margin .2s ease; }
    .wali-menu-link:hover { background:rgba(255,255,255,.1); color:#fff; }
    .wali-menu-link.active { background:rgba(255,255,255,.16); color:#fff; font-weight:600; }
    .wali-sidebar-footer { flex-shrink:0; padding:14px 16px; border-top:1px solid rgba(255,255,255,.15); }
    .wali-login-label { font-size:11px; color:rgba(255,255,255,.6); margin-bottom:4px; white-space:nowrap; }
    .wali-login-name { font-size:14px; font-weight:700; margin-bottom:12px; white-space:nowrap; overflow:hidden; }
    .wali-logout { width:100%; min-height:42px; border:none; border-radius:8px; padding:9px 12px; background:#dc3545; color:#fff; display:flex; align-items:center; justify-content:center; gap:8px; cursor:pointer; }
    .wali-logout:hover { background:#bb2d3b; }
    body.wali-sidebar-collapsed .wali-sidebar { width:78px; }
    body.wali-sidebar-collapsed .wali-brand-text, body.wali-sidebar-collapsed .wali-menu-text, body.wali-sidebar-collapsed .wali-login-label, body.wali-sidebar-collapsed .wali-login-name { opacity:0; width:0; margin-left:0; }
    body.wali-sidebar-collapsed .wali-sidebar-header { justify-content:center; padding:16px 10px; }
    body.wali-sidebar-collapsed .wali-menu-link { justify-content:center; padding-left:0; padding-right:0; }
    body.wali-sidebar-collapsed .wali-menu-link i { margin:0; }
    body.wali-sidebar-collapsed .wali-sidebar-footer { padding:14px 10px; }
    body.wali-sidebar-collapsed .wali-logout { padding:10px; }
    body.wali-sidebar-collapsed .wali-logout span { display:none; }
    body.wali-sidebar-collapsed .wali-sidebar-toggle { transform:rotate(180deg); }
    html,body { margin:0; padding:0; }
    body { padding-left:260px; background:#f8f9fa; transition:padding-left .25s ease; }
    body.wali-sidebar-collapsed { padding-left:78px; }
    body > .d-flex { min-height:100vh; }
    .flex-grow-1 { min-width:0; }
    .wali-mobile-topbar,.wali-mobile-overlay { display:none; }

    @media (max-width:991px) and (min-width:768px) {
        .wali-sidebar { width:78px; }
        body { padding-left:78px; }
        .wali-brand-text,.wali-menu-text,.wali-login-label,.wali-login-name { opacity:0; width:0; margin-left:0; }
        .wali-sidebar-header { justify-content:center; padding:16px 10px; }
        .wali-menu-link { justify-content:center; padding-left:0; padding-right:0; }
        .wali-sidebar-footer { padding:14px 10px; }
        .wali-logout { padding:10px; }
        .wali-logout span { display:none; }
        .wali-sidebar-toggle { transform:rotate(180deg); }
    }

    @media (max-width:767px) {
        body,body.wali-sidebar-collapsed { padding-left:0 !important; padding-top:62px !important; }
        .wali-mobile-topbar { position:fixed; top:0; left:0; right:0; height:62px; display:flex; align-items:center; gap:11px; padding:8px 12px; background:#212529; border-bottom:1px solid rgba(255,255,255,.12); box-shadow:0 3px 14px rgba(0,0,0,.16); z-index:1035; }
        .wali-mobile-brand-logo { width:42px; height:42px; border-radius:10px; font-size:13px; }
        .wali-mobile-title { min-width:0; flex:1; color:#fff; }
        .wali-mobile-title strong { display:block; font-size:14px; line-height:1.1; }
        .wali-mobile-title span { display:block; margin-top:2px; color:rgba(255,255,255,.62); font-size:10px; }
        .wali-mobile-trigger { width:42px; height:42px; display:inline-flex; align-items:center; justify-content:center; border:0; border-radius:10px; background:rgba(255,255,255,.1); color:#fff; cursor:pointer; font-size:18px; }
        .wali-mobile-trigger:hover { background:rgba(255,255,255,.18); }
        .wali-sidebar { width:min(290px,calc(100vw - 40px)); transform:translateX(-105%); box-shadow:10px 0 30px rgba(0,0,0,.2); }
        body.wali-sidebar-mobile-open .wali-sidebar { transform:translateX(0); }
        .wali-mobile-overlay { position:fixed; inset:0; display:block; background:rgba(15,23,42,.46); opacity:0; pointer-events:none; transition:opacity .2s ease; z-index:1039; }
        body.wali-sidebar-mobile-open .wali-mobile-overlay { opacity:1; pointer-events:auto; }
        .wali-sidebar-header { height:74px; padding:13px 16px; }
        .wali-brand-text,.wali-menu-text,.wali-login-label,.wali-login-name { opacity:1; width:auto; margin-left:initial; }
        .wali-brand-text { margin-left:12px; }
        .wali-menu-text { margin-left:10px; }
        .wali-menu-link { justify-content:flex-start; padding:10px 12px; min-height:46px; }
        .wali-sidebar-footer { padding:13px 16px; }
        .wali-logout span { display:inline; }
        .wali-sidebar-toggle { top:23px; right:12px; width:30px; height:30px; transform:none !important; background:rgba(255,255,255,.12); color:#fff; box-shadow:none; }
    }

    /* =====================================
       RESPONSIVE TABLE & PAGINATION
       ===================================== */
    .table-responsive {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
        -webkit-overflow-scrolling: touch;
    }

    .table-responsive > table {
        width: max-content;
        min-width: 100%;
    }

    .table-responsive > table th,
    .table-responsive > table td {
        white-space: nowrap;
        vertical-align: middle;
    }

    .pagination {
        flex-wrap: wrap;
        gap: 4px;
        margin-bottom: 0;
    }

    .pagination .page-link,
    .pagination > * {
        min-width: 38px;
        min-height: 38px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .pagination svg,
    nav[role="navigation"] svg {
        width: 16px !important;
        height: 16px !important;
        max-width: 16px !important;
        max-height: 16px !important;
    }

    nav[role="navigation"] {
        overflow-x: auto;
        max-width: 100%;
        padding-bottom: 2px;
    }

    /* =====================================
       DARK / LIGHT MODE
       ===================================== */
    body.dark-mode {
        background: #111827 !important;
        color: #e5e7eb;
    }

    body.dark-mode .wali-mobile-topbar,
    body.dark-mode .wali-sidebar {
        background: #172033;
    }

    body.dark-mode .wali-brand-logo,
    body.dark-mode .mobile-brand-logo {
        background: #f9fafb;
        color: #111827;
    }

    body.dark-mode .wali-sidebar,
    body.dark-mode .wali-mobile-topbar {
        box-shadow: 0 3px 18px rgba(0,0,0,.28);
    }

    body.dark-mode .wali-sidebar .wali-menu-link {
        color: rgba(255,255,255,.82);
    }

    body.dark-mode .wali-sidebar .wali-menu-link:hover,
    body.dark-mode .wali-sidebar .wali-menu-link.active {
        background: rgba(255,255,255,.10);
    }

    body.dark-mode .dark-target,
    body.dark-mode .card,
    body.dark-mode .modal-content,
    body.dark-mode .dropdown-menu {
        background-color: #1f2937 !important;
        color: #e5e7eb !important;
        border-color: #374151 !important;
    }

    body.dark-mode .text-muted,
    body.dark-mode small,
    body.dark-mode .form-text {
        color: #9ca3af !important;
    }

    body.dark-mode .table,
    body.dark-mode .table > :not(caption) > * > * {
        color: #e5e7eb !important;
        border-color: #374151 !important;
    }

    body.dark-mode .table-light,
    body.dark-mode .table-light > th,
    body.dark-mode .table-light > td,
    body.dark-mode thead.table-light th {
        background-color: #273449 !important;
        color: #f3f4f6 !important;
    }

    body.dark-mode .form-control,
    body.dark-mode .form-select,
    body.dark-mode input,
    body.dark-mode textarea,
    body.dark-mode select {
        background-color: #111827 !important;
        color: #f3f4f6 !important;
        border-color: #4b5563 !important;
    }

    body.dark-mode .form-control::placeholder,
    body.dark-mode input::placeholder,
    body.dark-mode textarea::placeholder {
        color: #9ca3af !important;
    }

    body.dark-mode .btn-light,
    body.dark-mode .btn-outline-secondary {
        color: #e5e7eb;
        border-color: #4b5563;
        background: #1f2937;
    }

    body.dark-mode .alert {
        border-color: #374151;
    }

    body.dark-mode a:not(.wali-menu-link) {
        color: #7dd3a8;
    }

    .theme-toggle {
        width: 100%;
        min-height: 42px;
        margin-bottom: 8px;
        padding: 9px 12px;
        border: 1px solid rgba(255,255,255,.14);
        border-radius: 8px;
        background: rgba(255,255,255,.06);
        color: rgba(255,255,255,.90);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: pointer;
        transition: background .2s ease;
    }

    .theme-toggle:hover {
        background: rgba(255,255,255,.12);
    }

    body.wali-sidebar-collapsed .theme-toggle span {
        display: none;
    }

    body.wali-sidebar-collapsed .theme-toggle {
        padding: 10px;
    }

    @media (max-width: 767px) {
        .table-responsive {
            margin-right: -2px;
        }

        .table-responsive > table th,
        .table-responsive > table td {
            white-space: nowrap;
        }

        nav[role="navigation"] {
            scrollbar-width: thin;
        }
    }


    .wali-mobile-theme {
        width: 42px;
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 0;
        border-radius: 10px;
        background: rgba(255,255,255,.1);
        color: #fff;
        cursor: pointer;
        font-size: 16px;
    }
    .wali-mobile-theme:hover { background: rgba(255,255,255,.18); }
    @media (min-width: 768px) { .wali-mobile-theme { display:none; } }



    /* ==========================================================
       PAKET 5D - FINISHING UX
       ========================================================== */

    /* TABEL: jangan pernah memecah kata menjadi satu huruf */
    .table-responsive > table {
        width: max-content !important;
        min-width: 100% !important;
        table-layout: auto !important;
    }

    .table-responsive > table th,
    .table-responsive > table td {
        white-space: nowrap !important;
        word-break: normal !important;
        overflow-wrap: normal !important;
        word-wrap: normal !important;
        hyphens: none !important;
    }

    @media (max-width: 767px) {
        .table-responsive {
            width: 100% !important;
            max-width: 100% !important;
            overflow-x: auto !important;
            overflow-y: hidden !important;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
        }

        /* Lebar minimum membuat tabel tetap terbaca dan digeser,
           bukan dipaksa menyempit sampai huruf terpecah. */
        .table-responsive > table {
            min-width: 760px !important;
        }

        .table-responsive > table th,
        .table-responsive > table td {
            white-space: nowrap !important;
        }

        .table-responsive::-webkit-scrollbar {
            height: 7px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: rgba(100,116,139,.55);
            border-radius: 999px;
        }
    }

    /* PAGINATION: cegah icon Previous/Next membesar */
    nav[role="navigation"] svg,
    nav[aria-label*="Pagination"] svg,
    .pagination svg {
        display: block !important;
        width: 16px !important;
        height: 16px !important;
        min-width: 16px !important;
        min-height: 16px !important;
        max-width: 16px !important;
        max-height: 16px !important;
    }

    nav[role="navigation"] a,
    nav[role="navigation"] button,
    nav[role="navigation"] span {
        line-height: 1.2;
    }

    @media (max-width: 767px) {
        nav[role="navigation"] {
            max-width: 100% !important;
            overflow-x: auto !important;
            padding-bottom: 3px;
            scrollbar-width: thin;
        }

        nav[role="navigation"] svg,
        nav[aria-label*="Pagination"] svg,
        .pagination svg {
            width: 14px !important;
            height: 14px !important;
            min-width: 14px !important;
            min-height: 14px !important;
            max-width: 14px !important;
            max-height: 14px !important;
        }
    }

    /* DARK MODE - palet navy lembut seperti referensi screenshot */
    body.dark-mode {
        --app-bg: #0f172a;
        --app-surface: #111827;
        --app-card: #1e293b;
        --app-card-alt: #172033;
        --app-border: #334155;
        --app-text: #f1f5f9;
        --app-muted: #94a3b8;

        background-color: var(--app-bg) !important;
        color: var(--app-text) !important;
        color-scheme: dark;
    }

    body.dark-mode main,
    body.dark-mode .main-content,
    body.dark-mode .flex-grow-1,
    body.dark-mode .container-fluid {
        color: var(--app-text);
    }

    body.dark-mode .card,
    body.dark-mode .card-header,
    body.dark-mode .card-footer,
    body.dark-mode .modal-content,
    body.dark-mode .dropdown-menu,
    body.dark-mode .list-group-item,
    body.dark-mode .accordion-item {
        background-color: var(--app-card) !important;
        color: var(--app-text) !important;
        border-color: var(--app-border) !important;
    }

    body.dark-mode .card-body {
        color: var(--app-text);
    }

    body.dark-mode h1,
    body.dark-mode h2,
    body.dark-mode h3,
    body.dark-mode h4,
    body.dark-mode h5,
    body.dark-mode h6,
    body.dark-mode .h1,
    body.dark-mode .h2,
    body.dark-mode .h3,
    body.dark-mode .h4,
    body.dark-mode .h5,
    body.dark-mode .h6,
    body.dark-mode .fw-bold,
    body.dark-mode strong {
        color: var(--app-text) !important;
    }

    body.dark-mode p,
    body.dark-mode label,
    body.dark-mode .form-label,
    body.dark-mode .form-check-label,
    body.dark-mode th,
    body.dark-mode td,
    body.dark-mode .form-text {
        color: #dbe4ee !important;
    }

    body.dark-mode .text-muted,
    body.dark-mode small,
    body.dark-mode .small {
        color: var(--app-muted) !important;
    }

    /* Tabel tetap kontras, tetapi tidak terlalu putih */
    body.dark-mode .table,
    body.dark-mode .table > :not(caption) > * > * {
        background-color: transparent !important;
        color: #e5edf5 !important;
        border-color: var(--app-border) !important;
    }

    body.dark-mode .table-light,
    body.dark-mode .table-light > th,
    body.dark-mode .table-light > td,
    body.dark-mode thead.table-light,
    body.dark-mode thead.table-light th,
    body.dark-mode thead.table-light td {
        background-color: #273449 !important;
        color: #f8fafc !important;
        border-color: #3b4b63 !important;
    }

    body.dark-mode .table-hover > tbody > tr:hover > * {
        background-color: rgba(255,255,255,.045) !important;
        color: #f8fafc !important;
    }

    body.dark-mode .border,
    body.dark-mode .border-top,
    body.dark-mode .border-end,
    body.dark-mode .border-bottom,
    body.dark-mode .border-start {
        border-color: var(--app-border) !important;
    }

    /* Form */
    body.dark-mode .form-control,
    body.dark-mode .form-select,
    body.dark-mode input,
    body.dark-mode textarea,
    body.dark-mode select {
        background-color: #111827 !important;
        color: #f8fafc !important;
        border-color: #475569 !important;
    }

    body.dark-mode input::placeholder,
    body.dark-mode textarea::placeholder,
    body.dark-mode .form-control::placeholder {
        color: #94a3b8 !important;
        opacity: 1;
    }

    body.dark-mode .form-control:focus,
    body.dark-mode .form-select:focus,
    body.dark-mode input:focus,
    body.dark-mode textarea:focus,
    body.dark-mode select:focus {
        border-color: #34d399 !important;
        box-shadow: 0 0 0 3px rgba(52,211,153,.14) !important;
    }

    body.dark-mode option {
        background: #111827;
        color: #f8fafc;
    }

    /* Elemen bootstrap yang sering masih putih */
    body.dark-mode .bg-white,
    body.dark-mode .bg-light {
        background-color: var(--app-card) !important;
        color: var(--app-text) !important;
    }

    body.dark-mode .alert {
        color: #e5edf5 !important;
        border-color: var(--app-border) !important;
    }

    body.dark-mode .btn-light {
        background-color: #334155 !important;
        color: #f8fafc !important;
        border-color: #475569 !important;
    }

    body.dark-mode .btn-outline-secondary {
        color: #cbd5e1 !important;
        border-color: #64748b !important;
    }

    body.dark-mode .btn-outline-secondary:hover {
        background-color: #334155 !important;
        color: #fff !important;
    }

    /* Pagination */
    body.dark-mode nav[role="navigation"] a,
    body.dark-mode nav[role="navigation"] span,
    body.dark-mode .pagination .page-link {
        background-color: #1e293b !important;
        color: #dbe4ee !important;
        border-color: #475569 !important;
    }

    body.dark-mode nav[role="navigation"] a:hover,
    body.dark-mode .pagination .page-link:hover {
        background-color: #334155 !important;
        color: #fff !important;
    }

    body.dark-mode .pagination .active .page-link,
    body.dark-mode nav[role="navigation"] [aria-current="page"] {
        background-color: #198754 !important;
        color: #fff !important;
        border-color: #198754 !important;
    }

    /* Link biasa */
    body.dark-mode a:not(.wali-menu-link) {
        color: #86efac;
    }

    /* Search / input group */
    body.dark-mode .input-group-text {
        background-color: #273449 !important;
        color: #dbe4ee !important;
        border-color: #475569 !important;
    }

    /* Shadow dibuat lebih halus pada tema gelap */
    body.dark-mode .shadow,
    body.dark-mode .shadow-sm,
    body.dark-mode .shadow-lg {
        box-shadow: 0 .5rem 1.25rem rgba(0,0,0,.24) !important;
    }

    @media (prefers-reduced-motion: reduce) {
        .wali-sidebar,
        .wali-mobile-overlay,
        .wali-mobile-trigger,
        .theme-toggle {
            transition: none !important;
        }
    }

</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

<div class="wali-mobile-topbar">
    <button type="button" class="wali-mobile-theme" id="waliMobileTheme" title="Ganti mode tampilan" aria-label="Ganti mode tampilan"><i class="bi bi-moon-stars-fill"></i></button>
    <div class="wali-mobile-brand-logo">AA</div>
    <div class="wali-mobile-title">
        <strong>AL ASROR</strong>
        <span>Portal Wali Santri</span>
    </div>
    <button type="button" class="wali-mobile-trigger" id="waliMobileTrigger" aria-label="Buka menu" aria-expanded="false">
        <i class="bi bi-list"></i>
    </button>
</div>

<div class="wali-mobile-overlay" id="waliMobileOverlay"></div>

<div class="wali-sidebar">
    <div class="wali-sidebar-header">
        <div class="wali-brand-logo">AA</div>
        <div class="wali-brand-text">
            <div class="wali-brand-title">AL ASROR</div>
            <div class="wali-brand-subtitle">Portal Wali Santri</div>
        </div>
        <button type="button" class="wali-sidebar-toggle" id="waliSidebarToggle" title="Buka/Tutup Sidebar" aria-label="Buka/Tutup Sidebar">
            <i class="bi bi-chevron-left"></i>
        </button>
    </div>

    <div class="wali-sidebar-menu">
        <a href="{{ route('wali.dashboard') }}" class="wali-menu-link {{ request()->routeIs('wali.dashboard') ? 'active' : '' }}" title="Dashboard">
            <i class="bi bi-speedometer2"></i><span class="wali-menu-text">Dashboard</span>
        </a>
        <a href="{{ route('wali.tagihan.index') }}" class="wali-menu-link {{ request()->routeIs('wali.tagihan.*') ? 'active' : '' }}" title="Tagihan">
            <i class="bi bi-receipt-cutoff"></i><span class="wali-menu-text">Tagihan</span>
        </a>
        <a href="{{ route('akun.index') }}" class="wali-menu-link {{ request()->routeIs('akun.index') ? 'active' : '' }}" title="Profil Akun">
            <i class="bi bi-person-circle"></i><span class="wali-menu-text">Profil Akun</span>
        </a>
        <a href="{{ route('akun.password.edit') }}" class="wali-menu-link {{ request()->routeIs('akun.password.*') ? 'active' : '' }}" title="Ganti Password">
            <i class="bi bi-shield-lock-fill"></i><span class="wali-menu-text">Ganti Password</span>
        </a>
        <a href="{{ route('wali.pembayaran.riwayat') }}" class="wali-menu-link {{ request()->routeIs('wali.pembayaran.riwayat') ? 'active' : '' }}" title="Riwayat Pembayaran">
            <i class="bi bi-clock-history"></i><span class="wali-menu-text">Riwayat Pembayaran</span>
        </a>
    </div>

    <div class="wali-sidebar-footer">
<button type="button" class="theme-toggle wali-theme-toggle" id="waliThemeToggle" title="Ganti mode tampilan" aria-label="Ganti mode tampilan">
        <i class="bi bi-moon-stars-fill"></i><span>Mode Gelap</span>
    </button>

        <div class="wali-login-label">Login sebagai:</div>
        <div class="wali-login-name">{{ auth()->user()->name ?? 'Wali Santri' }}</div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="wali-logout" title="Logout">
                <i class="bi bi-box-arrow-right"></i><span>Logout</span>
            </button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const themeButtons = [
        document.getElementById('waliThemeToggle'),
        document.getElementById('waliMobileTheme')
    ].filter(Boolean);

    function applyTheme(dark) {
        document.body.classList.toggle('dark-mode', dark);
        localStorage.setItem('alAsrorTheme', dark ? 'dark' : 'light');
        document.querySelectorAll('.wali-theme-toggle i, #waliMobileTheme i').forEach(function (icon) {
            icon.classList.toggle('bi-sun-fill', dark);
            icon.classList.toggle('bi-moon-stars-fill', !dark);
        });
        const label = document.querySelector('.wali-theme-toggle span');
        if (label) label.textContent = dark ? 'Mode Terang' : 'Mode Gelap';
    }

    themeButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            applyTheme(!document.body.classList.contains('dark-mode'));
        });
    });

    applyTheme(localStorage.getItem('alAsrorTheme') === 'dark');


    const desktopToggle = document.getElementById('waliSidebarToggle');
    const mobileTrigger = document.getElementById('waliMobileTrigger');
    const mobileOverlay = document.getElementById('waliMobileOverlay');
    const body = document.body;

    function isMobile() { return window.innerWidth <= 767; }

    function closeMobileSidebar() {
        body.classList.remove('wali-sidebar-mobile-open');
        if (mobileTrigger) mobileTrigger.setAttribute('aria-expanded', 'false');
    }

    if (desktopToggle) {
        desktopToggle.addEventListener('click', function () {
            if (isMobile()) {
                closeMobileSidebar();
                return;
            }
            body.classList.toggle('wali-sidebar-collapsed');
            localStorage.setItem('waliSidebarCollapsed', body.classList.contains('wali-sidebar-collapsed'));
        });
    }

    if (mobileTrigger) {
        mobileTrigger.addEventListener('click', function () {
            const open = body.classList.toggle('wali-sidebar-mobile-open');
            mobileTrigger.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
    }

    if (mobileOverlay) mobileOverlay.addEventListener('click', closeMobileSidebar);

    document.querySelectorAll('.wali-menu-link').forEach(function (link) {
        link.addEventListener('click', function () {
            if (isMobile()) closeMobileSidebar();
        });
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && isMobile()) closeMobileSidebar();
    });

    function syncResponsiveState() {
        if (isMobile()) {
            body.classList.remove('wali-sidebar-collapsed');
        } else {
            closeMobileSidebar();
            if (localStorage.getItem('waliSidebarCollapsed') === 'true') {
                body.classList.add('wali-sidebar-collapsed');
            }
        }
    }

    syncResponsiveState();
    window.addEventListener('resize', syncResponsiveState);
});
</script>