<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Admin Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('admin/assets/img/kaiadmin/favicon.ico') }}" type="image/x-icon">
    
    <!-- Fonts -->
    <script src="{{ asset('admin/assets/js/plugin/webfont/webfont.min.js') }}"></script>
    <script>
        WebFont.load({
            google: { families: ["Public Sans:300,400,500,600,700"] },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["{{ asset('admin/assets/css/fonts.min.css') }}"]
            },
            active: function () {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/plugins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/kaiadmin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css') }}">
    
    <!-- External CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <!-- Custom CSS -->
    <style>
        /* ===== ROOT VARIABLES ===== */
        :root {
            --primary: #3498db;
            --primary-dark: #2980b9;
            --secondary: #2c3e50;
            --success: #2ecc71;
            --success-dark: #27ae60;
            --info: #17a2b8;
            --warning: #f39c12;
            --warning-dark: #e67e22;
            --danger: #e74c3c;
            --danger-dark: #c0392b;
            --light: #ecf0f1;
            --dark: #34495e;
            --gray: #95a5a6;
        }

        /* ===== STATS CARDS ===== */
        .stat-card {
            border-radius: 12px;
            border: none;
            transition: all 0.3s ease;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 1.5rem;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .stat-card .card-body {
            padding: 1.5rem;
            position: relative;
        }

        .stat-icon-container {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            font-size: 24px;
            color: white;
            background: rgba(255, 255, 255, 0.2);
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            color: white;
        }

        .stat-label {
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .stat-trend {
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .trend-up {
            color: rgba(255, 255, 255, 0.9);
        }

        .trend-down {
            color: rgba(255, 255, 255, 0.9);
        }

        /* Stat Card Colors */
        .stat-users { background: linear-gradient(135deg, #3498db, #2980b9); }
        .stat-properties { background: linear-gradient(135deg, #2ecc71, #27ae60); }
        .stat-contacts { background: linear-gradient(135deg, #9b59b6, #8e44ad); }
        .stat-visits { background: linear-gradient(135deg, #f39c12, #e67e22); }

        /* ===== DASHBOARD HEADER ===== */
        .dashboard-header {
            padding: 1.5rem 0;
            margin-bottom: 2rem;
            border-bottom: 1px solid #eee;
        }

        .welcome-text {
            font-size: 1.1rem;
            color: #7f8c8d;
            margin-bottom: 0.5rem;
        }

        .dashboard-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--secondary);
            margin-bottom: 0;
        }

        .date-display {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            padding: 0.75rem 1.25rem;
            border-radius: 10px;
            font-weight: 500;
            color: var(--secondary);
        }

        /* ===== QUICK ACTIONS ===== */
        .quick-actions-card {
            background: linear-gradient(135deg, #2c3e50, #34495e);
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .action-item {
            display: block;
            text-decoration: none;
            color: white;
            padding: 1.25rem;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
            text-align: center;
        }

        .action-item:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-3px);
            color: white;
        }

        .action-icon {
            font-size: 1.75rem;
            margin-bottom: 0.75rem;
            color: white;
        }

        .action-text {
            font-size: 0.9rem;
            font-weight: 500;
            color: white;
        }

        /* ===== RECENT ACTIVITY ===== */
        .activity-timeline {
            position: relative;
            padding-left: 30px;
        }

        .activity-timeline::before {
            content: '';
            position: absolute;
            left: 10px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #eee;
        }

        .activity-item {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .activity-item:last-child {
            margin-bottom: 0;
        }

        .activity-item::before {
            content: '';
            position: absolute;
            left: -30px;
            top: 5px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: var(--primary);
            border: 3px solid white;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.2);
        }

        .activity-time {
            font-size: 0.8rem;
            color: #95a5a6;
            margin-top: 0.25rem;
        }

        /* ===== BUTTON STYLES ===== */
        .header-user-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logout-btn, .profile-btn {
            color: white !important;
            border: none;
            padding: 8px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            height: 40px;
        }

        .logout-btn {
            background: linear-gradient(135deg, #e74c3c, #c0392b);
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.25);
        }

        .logout-btn:hover {
            background: linear-gradient(135deg, #c0392b, #a93226);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(231, 76, 60, 0.35);
        }

        .profile-btn {
            background: linear-gradient(135deg, #3498db, #2980b9);
            box-shadow: 0 4px 12px rgba(52, 152, 219, 0.25);
        }

        .profile-btn:hover {
            background: linear-gradient(135deg, #2980b9, #1f618d);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52, 152, 219, 0.35);
        }

        /* ===== USER INFO ===== */
        .user-info-container {
            display: flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            padding: 6px 15px;
            border-radius: 8px;
            border-left: 4px solid var(--primary);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
        }

        .user-details {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-weight: 600;
            font-size: 14px;
            color: var(--secondary);
        }

        .user-role {
            font-size: 12px;
            color: var(--gray);
        }

        /* ===== CARD STYLES ===== */
        .dashboard-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }

        .dashboard-card .card-header {
            background: white;
            border-bottom: 1px solid #eee;
            padding: 1.25rem 1.5rem;
            border-radius: 12px 12px 0 0;
        }

        .dashboard-card .card-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--secondary);
            margin-bottom: 0;
        }

        .dashboard-card .card-body {
            padding: 1.5rem;
        }

        /* ===== SYSTEM STATUS ===== */
        .status-item {
            margin-bottom: 1rem;
        }

        .status-item:last-child {
            margin-bottom: 0;
        }

        .status-label {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .status-value {
            font-weight: 600;
            color: var(--secondary);
        }

        .progress {
            height: 8px;
            border-radius: 4px;
            background-color: #f1f2f3;
        }

        .progress-bar {
            border-radius: 4px;
        }

        /* ===== RESPONSIVE DESIGN ===== */
        @media (max-width: 992px) {
            .stat-value { font-size: 1.75rem; }
            .dashboard-title { font-size: 1.5rem; }
        }

        @media (max-width: 768px) {
            .header-user-section { gap: 10px; }
            
            .logout-btn span,
            .profile-btn span {
                display: none;
            }
            
            .logout-btn,
            .profile-btn {
                padding: 8px 12px;
                width: 40px;
                justify-content: center;
            }
            
            .user-info-container { display: none; }
            .date-display { font-size: 0.9rem; padding: 0.5rem 1rem; }
        }

        @media (max-width: 576px) {
            .dashboard-header { padding: 1rem 0; }
            .welcome-text { font-size: 1rem; }
            .dashboard-title { font-size: 1.3rem; }
            .stat-card .card-body { padding: 1.25rem; }
            .stat-value { font-size: 1.5rem; }
        }

        /* ===== ANIMATIONS ===== */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.5s ease forwards;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- SIDEBAR -->
        <div class="sidebar" data-background-color="dark">
            <div class="sidebar-logo">
                <div class="logo-header" data-background-color="dark">
                     <a href="{{ route('dashboard') }}" class="logo">
         <h4 class="mb-0 fw-bold" style="background: linear-gradient(45deg, #00c6ff, #0072ff); -webkit-background-clip: text; color: transparent;">
    Real Estate Pro
</h4>

    </a>
                    <div class="nav-toggle">
                        <button class="btn btn-toggle toggle-sidebar">
                            <i class="gg-menu-right"></i>
                        </button>
                        <button class="btn btn-toggle sidenav-toggler">
                            <i class="gg-menu-left"></i>
                        </button>
                    </div>
                    <button class="topbar-toggler more">
                        <i class="gg-more-vertical-alt"></i>
                    </button>
                </div>
            </div>
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <ul class="nav nav-secondary">
                        <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}">
                                <i class="fas fa-home"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Management</h4>
                        </li>
                        
                         
                        
                        <li class="nav-item {{ request()->routeIs('category.*') ? 'active' : '' }}">
                            <a href="{{ route('category.index') }}">
                                <i class="fas fa-th-list"></i>
                                <p>Category</p>
                            </a>
                        </li>

                        <li class="nav-item {{ request()->routeIs('sliders.*') ? 'active' : '' }}">
                            <a href="{{ route('sliders.index') }}">
                                <i class="fas fa-images"></i>
                                <p>Sliders</p>
                            </a>
                        </li>

                        <li class="nav-item {{ request()->routeIs('property.*') ? 'active' : '' }}">
                            <a href="{{ route('property.list') }}">
                                <i class="fas fa-building"></i>
                                <p>Property</p>
                            </a>
                        </li>
                        
                        <li class="nav-item {{ request()->routeIs('visit.*') ? 'active' : '' }}">
                            <a href="{{ route('visit.index') }}">
                                <i class="fas fa-calendar-check"></i>
                                <p>Visits</p>
                            </a>
                        </li>
                        
                        <li class="nav-item {{ request()->routeIs('cities.*') ? 'active' : '' }}">
                            <a href="{{ route('cities.index') }}">
                                <i class="fas fa-city"></i>
                                <p>Cities</p>
                            </a>
                        </li>


                        <li class="nav-item {{ request()->routeIs('notificationPage.*') ? 'active' : '' }}">
                            <a href="asend-notification">
                                <i class="fas fa-envelope"></i>
                                <p>Notification</p>
                            </a>
                        </li>

                        <li class="nav-section mt-4">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-plus-circle"></i>
                            </span>
                            <h4 class="text-section">Quick Add</h4>
                        </li>

                        <li class="nav-item">
                            <a href="categoryform" class="text-success">
                                <i class="fas fa-plus-circle"></i>
                                <p>Add Category</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('property.create') }}" class="text-info">
                                <i class="fas fa-plus-circle"></i>
                                <p>Add Property</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('citiesform') }}" class="text-warning">
                                <i class="fas fa-plus-circle"></i>
                                <p>Add City</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('sliders.create') }}" class="text-primary">
                                <i class="fas fa-plus-circle"></i>
                                <p>Add Slider</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- MAIN PANEL -->
        <div class="main-panel">
            <!-- HEADER -->
            <div class="main-header">
                <div class="main-header-logo">
                    <div class="logo-header" data-background-color="dark">
                        <a href="{{ route('dashboard') }}" class="logo">
                            <img src="{{ asset('admin/assets/img/kaiadmin/logo_light.svg') }}" alt="navbar brand" class="navbar-brand" height="20">
                        </a>
                        <div class="nav-toggle">
                            <button class="btn btn-toggle toggle-sidebar">
                                <i class="gg-menu-right"></i>
                            </button>
                            <button class="btn btn-toggle sidenav-toggler">
                                <i class="gg-menu-left"></i>
                            </button>
                        </div>
                        <button class="topbar-toggler more">
                            <i class="gg-more-vertical-alt"></i>
                        </button>
                    </div>
                </div>
                
                <!-- NAVBAR -->
                <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
                    <div class="container-fluid">
                        <!-- SEARCH BAR -->
                        <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn btn-search pe-1">
                                        <i class="fa fa-search search-icon"></i>
                                    </button>
                                </div>
                                <input type="text" placeholder="Search ..." class="form-control">
                            </div>
                        </nav>

                        <!-- QUICK ACTION BUTTONS -->
                        <div class="d-flex gap-2 ms-3">
                            <a href="categoryform" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i> Category
                            </a>
                            <a href="{{ route('property.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i> Property
                            </a>
                            <a href="{{ route('citiesform') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i> City
                            </a>
                            <a href="{{ route('sliders.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-1"></i> Slider
                            </a>
                        </div>

                        <!-- USER SECTION -->
                        <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                            <!-- MOBILE SEARCH -->
                            <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                                <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">
                                    <i class="fa fa-search"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-search animated fadeIn">
                                    <form class="navbar-left navbar-form nav-search">
                                        <div class="input-group">
                                            <input type="text" placeholder="Search ..." class="form-control">
                                        </div>
                                    </form>
                                </ul>
                            </li>
                            
                            <!-- USER PROFILE AND LOGOUT -->
                            <li class="nav-item">
                                <div class="header-user-section">
                                    <!-- USER INFO -->
                                    <div class="user-info-container">
                                        <div class="user-avatar">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                        <div class="user-details">
                                            <div class="user-name">{{ Auth::user()->name }}</div>
                                            <div class="user-role">Administrator</div>
                                        </div>
                                    </div>
                                    
                                    <!-- PROFILE BUTTON -->
                                    <a href="{{ route('profile.show') }}" class="profile-btn">
                                        <i class="fas fa-user-circle"></i>
                                        <span class="d-none d-md-inline">Profile</span>
                                    </a>
                                    
                                    <!-- LOGOUT BUTTON -->
                                    <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                                        @csrf
                                        <button type="submit" class="logout-btn">
                                            <i class="fas fa-sign-out-alt"></i>
                                            <span class="d-none d-md-inline">Logout</span>
                                        </button>
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>

            <!-- MAIN CONTENT -->
            <div class="container">
                <div class="page-inner">
                    @if(request()->routeIs('dashboard'))
                    <!-- DASHBOARD CONTENT -->
                    <div class="dashboard-header fade-in-up">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <p class="welcome-text">Welcome back, {{ Auth::user()->name }}! 👋</p>
                                <h1 class="dashboard-title">Dashboard Overview</h1>
                            </div>
                            <div class="col-md-6 text-md-end">
                                <div class="date-display">
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    {{ date('l, F j, Y') }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- STATISTICS CARDS -->
                    <div class="row mb-4">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card stat-users fade-in-up" style="animation-delay: 0.1s;">
                                <div class="card-body">
                                    <div class="stat-icon-container">
                                        <i class="fas fa-users"></i>
                                    </div>
                                    <div class="stat-value">{{ $totalUsers ?? 0 }}</div>
                                    <div class="stat-label">Total Users</div>
                                    <div class="stat-trend trend-up">
                                        <i class="fas fa-arrow-up"></i>
                                        <span>12.5% from last month</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card stat-properties fade-in-up" style="animation-delay: 0.2s;">
                                <div class="card-body">
                                    <div class="stat-icon-container">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <div class="stat-value">{{ $totalProperties ?? 0 }}</div>
                                    <div class="stat-label">Total Properties</div>
                                    <div class="stat-trend trend-up">
                                        <i class="fas fa-arrow-up"></i>
                                        <span>8.3% from last month</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card stat-contacts fade-in-up" style="animation-delay: 0.3s;">
                                <div class="card-body">
                                    <div class="stat-icon-container">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div class="stat-value">{{ $totalContacts ?? 0 }}</div>
                                    <div class="stat-label">Total Contacts</div>
                                    <div class="stat-trend trend-up">
                                        <i class="fas fa-arrow-up"></i>
                                        <span>5.7% from last month</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card stat-card stat-visits fade-in-up" style="animation-delay: 0.4s;">
                                <div class="card-body">
                                    <div class="stat-icon-container">
                                        <i class="fas fa-calendar-check"></i>
                                    </div>
                                    <div class="stat-value">{{ $todayVisits ?? 0 }}</div>
                                    <div class="stat-label">Today's Visits</div>
                                    <div class="stat-trend trend-down">
                                        <i class="fas fa-arrow-down"></i>
                                        <span>3.2% from yesterday</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CHARTS AND QUICK ACTIONS -->
                    <div class="row mb-4">
                        <!-- CHART COLUMN -->
                        <div class="col-lg-8 mb-4">
                            <div class="card dashboard-card fade-in-up">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class="fas fa-chart-line me-2"></i>Monthly Performance
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div style="height: 300px; display: flex; align-items: center; justify-content: center; background: #f8f9fa; border-radius: 8px;">
                                        <div class="text-center">
                                            <i class="fas fa-chart-bar fa-4x text-muted mb-3"></i>
                                            <h5 class="text-muted">Performance Chart</h5>
                                            <p class="text-muted mb-0">Chart visualization will appear here</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- QUICK ACTIONS COLUMN -->
                        <div class="col-lg-4 mb-4">
                            <div class="card quick-actions-card fade-in-up">
                                <div class="card-body">
                                    <h5 class="card-title text-white mb-4">
                                        <i class="fas fa-bolt me-2"></i>Quick Actions
                                    </h5>
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <a href="{{ route('property.create') }}" class="action-item">
                                                <div class="action-icon">
                                                    <i class="fas fa-home"></i>
                                                </div>
                                                <div class="action-text">Add Property</div>
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <a href="{{ route('category.index') }}" class="action-item">
                                                <div class="action-icon">
                                                    <i class="fas fa-tags"></i>
                                                </div>
                                                <div class="action-text">Categories</div>
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <a href="{{ route('contacts.index') }}" class="action-item">
                                                <div class="action-icon">
                                                    <i class="fas fa-envelope"></i>
                                                </div>
                                                <div class="action-text">Messages</div>
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <a href="{{ route('sliders.create') }}" class="action-item">
                                                <div class="action-icon">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                                <div class="action-text">Add Slider</div>
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <a href="{{ route('cities.index') }}" class="action-item">
                                                <div class="action-icon">
                                                    <i class="fas fa-city"></i>
                                                </div>
                                                <div class="action-text">Cities</div>
                                            </a>
                                        </div>
                                        <div class="col-6">
                                            <a href="{{ route('visit.index') }}" class="action-item">
                                                <div class="action-icon">
                                                    <i class="fas fa-calendar-check"></i>
                                                </div>
                                                <div class="action-text">Visits</div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- RECENT ACTIVITY AND SYSTEM STATUS -->
                    <div class="row">
                        <!-- RECENT ACTIVITY -->
                        <div class="col-lg-8 mb-4">
                            <div class="card dashboard-card fade-in-up">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-history me-2"></i>Recent Activity
                                    </h5>
                                    <a href="#" class="btn btn-sm btn-light">View All</a>
                                </div>
                                <div class="card-body">
                                    <div class="activity-timeline">
                                        <div class="activity-item">
                                            <h6 class="mb-1">New user registered</h6>
                                            <p class="text-muted mb-1">John Doe has registered as a new user</p>
                                            <div class="activity-time">10 minutes ago</div>
                                        </div>
                                        
                                        <div class="activity-item">
                                            <h6 class="mb-1">New property added</h6>
                                            <p class="text-muted mb-1">"Luxury Villa" has been added to properties</p>
                                            <div class="activity-time">2 hours ago</div>
                                        </div>
                                        
                                        <div class="activity-item">
                                            <h6 class="mb-1">New contact message</h6>
                                            <p class="text-muted mb-1">Sarah Johnson sent a new inquiry</p>
                                            <div class="activity-time">5 hours ago</div>
                                        </div>
                                        
                                        <div class="activity-item">
                                            <h6 class="mb-1">Slider image updated</h6>
                                            <p class="text-muted mb-1">Homepage slider image #3 has been updated</p>
                                            <div class="activity-time">Yesterday, 3:45 PM</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- SYSTEM STATUS -->
                        <div class="col-lg-4 mb-4">
                            <div class="card dashboard-card fade-in-up">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">
                                        <i class="fas fa-server me-2"></i>System Status
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="status-item">
                                        <div class="status-label">
                                            <span>Storage Usage</span>
                                            <span class="status-value">65%</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" style="width: 65%"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="status-item">
                                        <div class="status-label">
                                            <span>Memory Usage</span>
                                            <span class="status-value">42%</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-info" style="width: 42%"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="status-item">
                                        <div class="status-label">
                                            <span>CPU Load</span>
                                            <span class="status-value">28%</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar bg-warning" style="width: 28%"></div>
                                        </div>
                                    </div>
                                    
                                    <div class="mt-4 pt-3 border-top">
                                        <div class="alert alert-success mb-0">
                                            <i class="fas fa-check-circle me-2"></i>
                                            <strong>All systems operational</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @else
                    <!-- OTHER PAGES CONTENT -->
                    @yield('content')
                    @endif
                </div>
            </div>
            
            <!-- FOOTER -->
            <footer class="footer">
                <div class="container-fluid d-flex justify-content-between align-items-center">
                    <nav class="pull-left">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link" href="http://www.themekita.com">ThemeKita</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Help</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Licenses</a>
                            </li>
                        </ul>
                    </nav>
                    <div class="copyright">
                        {{ date('Y') }}, made with <i class="fa fa-heart heart text-danger"></i> by
                        <a href="http://www.themekita.com">ThemeKita</a>
                    </div>
                    <div>
                        <span class="badge bg-primary">v1.0.0</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="{{ asset('admin/assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugin/chart.js/chart.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugin/chart-circle/circles.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugin/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugin/jsvectormap/jsvectormap.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugin/jsvectormap/world.js') }}"></script>
    <script src="{{ asset('admin/assets/js/plugin/sweetalert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/kaiadmin.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/setting-demo.js') }}"></script>
    <script src="{{ asset('admin/assets/js/demo.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- CUSTOM DASHBOARD JS -->
    <script>
        $(document).ready(function() {
            // CSRF Token Setup
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // ===== LOGOUT CONFIRMATION =====
            $('#logoutForm button').on('click', function(e) {
                e.preventDefault();
                
                Swal.fire({
                    title: 'Logout Confirmation',
                    text: "Are you sure you want to logout from the admin panel?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e74c3c',
                    cancelButtonColor: '#3498db',
                    confirmButtonText: 'Yes, Logout!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true,
                    background: '#fff',
                    customClass: {
                        confirmButton: 'btn btn-danger',
                        cancelButton: 'btn btn-secondary'
                    },
                    showClass: {
                        popup: 'animate__animated animate__fadeInDown'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutUp'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Show loading state
                        Swal.fire({
                            title: 'Logging out...',
                            text: 'Please wait while we log you out',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        
                        // Submit form after delay
                        setTimeout(() => {
                            document.getElementById('logoutForm').submit();
                        }, 1000);
                    }
                });
            });
            
            // ===== UPDATE CURRENT TIME =====
            function updateCurrentTime() {
                const now = new Date();
                const options = { 
                    weekday: 'long', 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                };
                const dateString = now.toLocaleDateString('en-US', options);
                $('.date-display').html(`<i class="fas fa-calendar-alt me-2"></i>${dateString}`);
            }
            
            // Update time immediately and every minute
            updateCurrentTime();
            setInterval(updateCurrentTime, 60000);
            
            // ===== ANIMATE STATS CARDS =====
            $('.fade-in-up').each(function(i) {
                $(this).css({
                    'opacity': '0',
                    'transform': 'translateY(20px)'
                });
                
                setTimeout(() => {
                    $(this).animate({
                        opacity: 1,
                        transform: 'translateY(0)'
                    }, 500);
                }, i * 100);
            });
            
            // ===== BUTTON HOVER EFFECTS =====
            $('.logout-btn, .profile-btn').hover(
                function() {
                    $(this).css('transform', 'translateY(-2px)');
                },
                function() {
                    $(this).css('transform', 'translateY(0)');
                }
            );
            
            // ===== MOBILE RESPONSIVE ADJUSTMENTS =====
            function adjustForMobile() {
                if ($(window).width() < 768) {
                    $('.logout-btn span, .profile-btn span').hide();
                    $('.user-info-container').hide();
                } else {
                    $('.logout-btn span, .profile-btn span').show();
                    $('.user-info-container').show();
                }
            }
            
            // Run on load and resize
            adjustForMobile();
            $(window).resize(adjustForMobile);
            
            // ===== ACTIVE MENU HIGHLIGHT =====
            function highlightActiveMenu() {
                const currentPath = window.location.pathname;
                $('.nav-item a').each(function() {
                    const linkPath = $(this).attr('href');
                    if (linkPath && currentPath.includes(linkPath.replace(/^\//, '').split('/')[0])) {
                        $(this).closest('.nav-item').addClass('active');
                    }
                });
            }
            
            highlightActiveMenu();
            
            // ===== TOOLTIPS =====
            $('[data-bs-toggle="tooltip"]').tooltip();
            
            // ===== SEARCH FUNCTIONALITY =====
            $('.btn-search').on('click', function(e) {
                e.preventDefault();
                const searchTerm = $(this).closest('.input-group').find('input').val();
                if (searchTerm.trim() !== '') {
                    Swal.fire({
                        title: 'Search',
                        text: 'Searching for: ' + searchTerm,
                        icon: 'info',
                        timer: 1500
                    });
                    // Implement actual search functionality here
                }
            });
            
            // Press Enter to search
            $('.nav-search input').on('keypress', function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    $(this).closest('.input-group').find('.btn-search').click();
                }
            });
            
            // ===== SIDEBAR TOGGLE =====
            $('.toggle-sidebar').on('click', function() {
                $('.sidebar').toggleClass('active');
            });
            
            // ===== NOTIFICATION EXAMPLE =====
            function showNotification(type, message) {
                $.notify({
                    icon: type === 'success' ? 'fas fa-check' : 'fas fa-exclamation',
                    title: type === 'success' ? 'Success!' : 'Error!',
                    message: message
                },{
                    type: type,
                    timer: 3000,
                    placement: {
                        from: "top",
                        align: "right"
                    }
                });
            }
        });
    </script>
</body>
</html>