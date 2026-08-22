<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle ?? 'Admin' }} - {{ gs('site_name') }}</title>
    @if(gs('site_icon_url'))<link rel="icon" href="{{ gs('site_icon_url') }}">@endif
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/line-awesome@1.3.0/dist/line-awesome/css/line-awesome.min.css">
    <style>
        :root {
            --base: #10b981;
            --base-dark: #059669;
            --secondary: #3b82f6;
            --dark: #0f172a;
            --sidebar: #1e293b;
            --sidebar-hover: #334155;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f1f5f9;
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 260px;
            background: var(--sidebar);
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s;
        }
        .sidebar-logo {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .sidebar-logo h3 { color: #fff; font-weight: 700; margin: 0; }
        .sidebar-logo span { color: var(--base); }
        .sidebar-menu { padding: 15px 0; }
        .sidebar-menu .menu-label {
            padding: 10px 20px 5px;
            font-size: 11px;
            text-transform: uppercase;
            color: rgba(255,255,255,0.4);
            letter-spacing: 1px;
        }
        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.2s;
            gap: 12px;
            font-size: 14px;
        }
        .sidebar-menu a:hover, .sidebar-menu a.active {
            background: var(--sidebar-hover);
            color: #fff;
        }
        .sidebar-menu a i { width: 20px; text-align: center; font-size: 16px; }
        .main-content {
            margin-left: 260px;
            flex: 1;
            padding: 0;
            min-height: 100vh;
        }
        .topbar {
            background: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .topbar-left { display: flex; align-items: center; gap: 15px; }
        .topbar-right { display: flex; align-items: center; gap: 20px; }
        .page-content { padding: 30px; }
        .page-title { margin-bottom: 25px; }
        .page-title h4 { font-weight: 700; color: var(--dark); }
        .breadcrumb { background: transparent; padding: 0; margin: 5px 0 0; }
        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }
        .stat-card:hover { transform: translateY(-2px); }
        .stat-card .icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 15px;
        }
        .stat-card .label { color: #64748b; font-size: 13px; margin-bottom: 5px; }
        .stat-card .value { font-size: 24px; font-weight: 700; color: var(--dark); }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
        .card-header {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 18px 24px;
            font-weight: 600;
        }
        .card-body { padding: 24px; }
        .table { margin-bottom: 0; }
        .table th {
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            border-bottom: 2px solid #e2e8f0;
        }
        .table td { vertical-align: middle; }
        .btn { border-radius: 8px; font-weight: 500; font-size: 14px; padding: 8px 16px; }
        .btn-primary { background: var(--base); border-color: var(--base); }
        .btn-primary:hover { background: var(--base-dark); border-color: var(--base-dark); }
        .btn-outline-primary { border-color: var(--base); color: var(--base); }
        .btn-outline-primary:hover { background: var(--base); color: #fff; }
        .btn-danger { background: #ef4444; border-color: #ef4444; }
        .btn-success { background: var(--base); border-color: var(--base); }
        .btn-warning { background: #f59e0b; border-color: #f59e0b; color: #fff; }
        .btn-sm { padding: 5px 12px; font-size: 12px; }
        .badge { padding: 4px 10px; border-radius: 6px; font-weight: 500; font-size: 11px; }
        .bg-soft-success { background: #d1fae5; color: #065f46; }
        .bg-soft-danger { background: #fee2e2; color: #991b1b; }
        .bg-soft-warning { background: #fef3c7; color: #92400e; }
        .bg-soft-info { background: #dbeafe; color: #1e40af; }
        .form-control { border-radius: 8px; border: 1.5px solid #e2e8f0; padding: 10px 14px; font-size: 14px; }
        .form-control:focus { border-color: var(--base); box-shadow: 0 0 0 3px rgba(16,185,129,0.15); }
        .form-label { font-weight: 500; font-size: 13px; color: #475569; margin-bottom: 6px; }
        .alert { border-radius: 10px; border: none; }
        .alert-success { background: #d1fae5; color: #065f46; }
        .alert-danger { background: #fee2e2; color: #991b1b; }
        .alert-warning { background: #fef3c7; color: #92400e; }
        .pagination { margin-bottom: 0; }
        .page-link { border-radius: 8px !important; margin: 0 2px; color: var(--dark); }
        .page-item.active .page-link { background: var(--base); border-color: var(--base); }
        .modal-content { border: none; border-radius: 16px; }
        .modal-header { border-bottom: 1px solid #e2e8f0; padding: 20px 24px; }
        .modal-body { padding: 24px; }
        .modal-footer { border-top: 1px solid #e2e8f0; padding: 16px 24px; }
        .table-responsive { border-radius: 8px; }
        @media (max-width: 768px) {
            .sidebar { width: 0; overflow: hidden; }
            .sidebar.show { width: 260px; }
            .main-content { margin-left: 0; }
        }
    </style>
    @stack('style')
</head>
<body>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            @if(gs('site_logo_url'))
                <img src="{{ gs('site_logo_url') }}" alt="{{ gs('site_name') }}" style="max-height: 40px;" class="img-fluid">
            @else
                <h3><span>{{ substr(gs('site_name'), 0, 4) }}</span>{{ substr(gs('site_name'), 4) }}</h3>
            @endif
        </div>
        <div class="sidebar-menu">
            <div class="menu-label">Main</div>
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-pie"></i> Dashboard
            </a>

            <div class="menu-label">Management</div>
            <a href="{{ route('admin.users.all') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="fas fa-users"></i> Users
            </a>
            <a href="{{ route('admin.category.index') }}" class="{{ request()->routeIs('admin.category.*') ? 'active' : '' }}">
                <i class="fas fa-th-list"></i> Categories
            </a>
            <a href="{{ route('admin.tasks.index') }}" class="{{ request()->routeIs('admin.tasks.*') && !request()->routeIs('admin.tasks.submissions*') ? 'active' : '' }}">
                <i class="fas fa-tasks"></i> Tasks
            </a>
            <a href="{{ route('admin.tasks.submissions') }}" class="{{ request()->routeIs('admin.tasks.submissions*') ? 'active' : '' }}">
                <i class="fas fa-clipboard-check"></i> Submissions
            </a>

            <div class="menu-label">Finance</div>
            <a href="{{ route('admin.deposits.all') }}" class="{{ request()->routeIs('admin.deposits.*') && !request()->routeIs('admin.deposits.activation*') && !request()->routeIs('admin.deposits.methods*') ? 'active' : '' }}">
                <i class="fas fa-wallet"></i> Deposits
            </a>
            <a href="{{ route('admin.deposits.methods') }}" class="{{ request()->routeIs('admin.deposits.methods*') ? 'active' : '' }}">
                <i class="fas fa-cog"></i> Deposit Methods
            </a>
            <a href="{{ route('admin.deposits.activation') }}" class="{{ request()->routeIs('admin.deposits.activation') && !request()->routeIs('admin.deposits.activation.settings') ? 'active' : '' }}">
                <i class="fas fa-user-check"></i> Activation Deposits
            </a>
            <a href="{{ route('admin.deposits.activation.settings') }}" class="{{ request()->routeIs('admin.deposits.activation.settings*') ? 'active' : '' }}">
                <i class="fas fa-cog"></i> Activation Settings
            </a>
            <a href="{{ route('admin.withdrawals.all') }}" class="{{ request()->routeIs('admin.withdrawals.*') && !request()->routeIs('admin.withdrawals.methods*') ? 'active' : '' }}">
                <i class="fas fa-credit-card"></i> Withdrawals
            </a>
            <a href="{{ route('admin.withdrawals.methods') }}" class="{{ request()->routeIs('admin.withdrawals.methods*') ? 'active' : '' }}">
                <i class="fas fa-cog"></i> Withdraw Methods
            </a>

            <div class="menu-label">Support</div>
            <a href="{{ route('admin.ticket.index') }}" class="{{ request()->routeIs('admin.ticket.*') ? 'active' : '' }}">
                <i class="fas fa-headset"></i> Tickets
            </a>

            <div class="menu-label">Settings</div>
            <a href="{{ route('admin.setting.general') }}" class="{{ request()->routeIs('admin.setting.general') ? 'active' : '' }}">
                <i class="fas fa-sliders-h"></i> General Settings
            </a>
            <a href="{{ route('admin.setting.smtp') }}" class="{{ request()->routeIs('admin.setting.smtp*') ? 'active' : '' }}">
                <i class="fas fa-envelope"></i> Email / SMTP
            </a>
            <a href="{{ route('admin.setting.logo.icon') }}" class="{{ request()->routeIs('admin.setting.logo.icon') ? 'active' : '' }}">
                <i class="fas fa-image"></i> Logo & Icon
            </a>

            <div class="menu-label">Pages</div>
            <a href="{{ route('admin.frontend.sections', 'about_us') }}" class="{{ request()->routeIs('admin.pages.about') ? 'active' : '' }}">
                <i class="fas fa-info-circle"></i> About Us
            </a>
            <a href="{{ route('admin.frontend.sections', 'contact_us') }}" class="{{ request()->routeIs('admin.pages.contact') ? 'active' : '' }}">
                <i class="fas fa-envelope"></i> Contact Us
            </a>
            <a href="{{ route('admin.frontend.sections', 'support') }}" class="{{ request()->routeIs('admin.pages.support') ? 'active' : '' }}">
                <i class="fas fa-headset"></i> Support
            </a>
            <a href="{{ route('admin.frontend.sections', 'terms_conditions') }}" class="{{ request()->routeIs('admin.pages.terms') ? 'active' : '' }}">
                <i class="fas fa-file-contract"></i> Terms & Conditions
            </a>
            <a href="{{ route('admin.frontend.sections', 'privacy_policy') }}" class="{{ request()->routeIs('admin.pages.privacy') ? 'active' : '' }}">
                <i class="fas fa-shield-alt"></i> Privacy Policy
            </a>

            <div class="menu-label">Reports</div>
            <a href="{{ route('admin.reports.transaction') }}" class="{{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <i class="fas fa-file-alt"></i> Reports
            </a>

            <div class="menu-label">Account</div>
            <a href="{{ route('admin.profile') }}" class="{{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                <i class="fas fa-user"></i> Profile
            </a>
            <a href="{{ route('admin.logout') }}">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </div>

    <div class="main-content">
        <div class="topbar">
            <div class="topbar-left">
                <button class="btn btn-sm btn-outline-secondary d-md-none" onclick="document.getElementById('sidebar').classList.toggle('show')">
                    <i class="fas fa-bars"></i>
                </button>
                <h5 class="mb-0 fw-bold">{{ $pageTitle ?? 'Dashboard' }}</h5>
            </div>
            <div class="topbar-right">
                <span class="text-muted small">{{ auth()->guard('admin')->user()->name ?? 'Admin' }}</span>
                <a href="{{ route('admin.logout') }}" class="btn btn-sm btn-outline-danger">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </div>
        <div class="page-content">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @stack('script')
</body>
</html>
