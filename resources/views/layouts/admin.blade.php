<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <title>@yield('title') - لوحة التحكم</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Arabic:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #10b981;
            --primary-dark: #059669;
            --primary-light: #d1fae5;
            --secondary: #6366f1;
            --accent: #f59e0b;
            --danger: #ef4444;
            --success: #10b981;
            --warning: #f59e0b;
            --info: #3b82f6;
            --dark: #0f172a;
            --sidebar-bg: #ffffff;
            --sidebar-active: #f0fdf4;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --sidebar-width: 260px;
            --topbar-height: 70px;
        }

        body {
            font-family: 'IBM Plex Sans Arabic', sans-serif;
            background: #f8fafc;
            color: var(--dark);
            line-height: 1.6;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            right: 0;
            top: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            border-left: 1px solid var(--gray-200);
            overflow-y: auto;
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: var(--gray-300);
            border-radius: 4px;
        }

        .sidebar-logo {
            padding: 1.5rem;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.25rem;
            font-weight: 700;
        }

        .logo-text {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--dark);
        }

        .sidebar-menu {
            padding: 1rem 0.5rem;
        }

        .menu-section {
            margin-bottom: 1.5rem;
        }

        .menu-section-title {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--gray-400);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 0.5rem 1rem;
            margin-bottom: 0.25rem;
        }

        .menu-item {
            margin-bottom: 0.25rem;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            color: var(--gray-700);
            text-decoration: none;
            border-radius: 10px;
            transition: all 0.2s ease;
            font-weight: 500;
            font-size: 0.9375rem;
            position: relative;
        }

        .menu-link:hover {
            background: var(--gray-50);
            color: var(--primary);
        }

        .menu-link.active {
            background: var(--sidebar-active);
            color: var(--primary);
            font-weight: 600;
        }

        .menu-link.active::before {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            width: 3px;
            height: 20px;
            background: var(--primary);
            border-radius: 10px;
        }

        .menu-icon {
            font-size: 1.125rem;
            width: 20px;
            text-align: center;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.125rem 0.5rem;
            background: var(--primary);
            color: white;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-right: auto;
        }

        /* Main Content */
        .main-content {
            margin-right: var(--sidebar-width);
            min-height: 100vh;
        }

        /* Topbar */
        .topbar {
            position: sticky;
            top: 0;
            height: var(--topbar-height);
            background: white;
            border-bottom: 1px solid var(--gray-200);
            padding: 0 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 100;
        }

        /* Hide sidebar toggle on desktop */
        .sidebar-toggle {
            display: none;
        }

        /* Show sidebar toggle only on mobile */
        @media (max-width: 768px) {
            .sidebar-toggle {
                display: flex;
                margin-right: 1rem;
            }

            .topbar {
                padding: 1rem;
            }
        }

        .search-container {
            flex: 1;
            max-width: 500px;
            position: relative;
        }

        .search-input {
            width: 100%;
            height: 42px;
            padding: 0 1rem 0 3rem;
            border: 1px solid var(--gray-200);
            border-radius: 10px;
            font-size: 0.9375rem;
            background: var(--gray-50);
            transition: all 0.2s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .search-icon {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-400);
            font-size: 1rem;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .notification-btn {
            width: 42px;
            height: 42px;
            border-radius: 10px;
            background: var(--gray-50);
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-600);
            transition: all 0.2s ease;
            position: relative;
        }

        .notification-btn:hover {
            background: var(--gray-100);
            color: var(--dark);
        }

        .notification-badge {
            position: absolute;
            top: 8px;
            left: 8px;
            width: 8px;
            height: 8px;
            background: var(--danger);
            border-radius: 50%;
            border: 2px solid white;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.5rem 0.75rem;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .user-menu:hover {
            background: var(--gray-50);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.875rem;
        }

        .user-info {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .user-name {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--dark);
            line-height: 1.2;
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--gray-400);
        }

        /* Content Area */
        .content-area {
            padding: 2rem;
        }

        /* Page Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .page-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .page-title i {
            color: var(--primary);
            font-size: 1.75rem;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.9375rem;
            cursor: pointer;
            transition: all 0.2s ease;
            text-decoration: none;
            font-family: 'IBM Plex Sans Arabic', sans-serif;
        }

        .btn:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-secondary {
            background: var(--secondary);
        }

        .btn-secondary:hover {
            background: #4f46e5;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .btn-danger {
            background: var(--danger);
        }

        .btn-danger:hover {
            background: #dc2626;
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .btn-outline {
            background: white;
            color: var(--primary);
            border: 1.5px solid var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        /* Cards */
        .card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid var(--gray-200);
            margin-bottom: 1.5rem;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .card-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: var(--dark);
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            border: 1px solid var(--gray-200);
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), var(--primary-dark));
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.875rem;
            color: var(--gray-600);
            font-weight: 500;
        }

        .stat-change {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.75rem;
            font-weight: 600;
            margin-top: 0.5rem;
        }

        .stat-change.positive {
            color: var(--success);
        }

        .stat-change.negative {
            color: var(--danger);
        }

        /* Table */
        .table-container {
            overflow-x: auto;
            border-radius: 12px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        thead {
            background: var(--gray-50);
        }

        th {
            padding: 1rem;
            text-align: right;
            font-weight: 600;
            font-size: 0.875rem;
            color: var(--gray-700);
            border-bottom: 1px solid var(--gray-200);
        }

        th:first-child {
            border-top-right-radius: 12px;
        }

        th:last-child {
            border-top-left-radius: 12px;
        }

        td {
            padding: 1rem;
            border-bottom: 1px solid var(--gray-200);
            font-size: 0.9375rem;
        }

        tbody tr {
            transition: all 0.2s ease;
        }

        tbody tr:hover {
            background: var(--gray-50);
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            border-radius: 8px;
            font-size: 0.8125rem;
            font-weight: 600;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-weight: 500;
            border-right: 4px solid;
        }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-color: var(--success);
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-color: var(--danger);
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
            font-size: 0.9375rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--gray-200);
            border-radius: 10px;
            font-size: 0.9375rem;
            transition: all 0.2s ease;
            font-family: 'IBM Plex Sans Arabic', sans-serif;
            background: white;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        select.form-control {
            cursor: pointer;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-in {
            animation: fadeIn 0.3s ease;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(100%);
                width: 280px;
                max-width: 85vw;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .main-content {
                margin-right: 0;
            }

            .topbar {
                padding: 0 1rem;
            }

            .content-area {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .user-info {
                display: none;
            }

            /* Mobile Sidebar Menu */
            .sidebar-menu {
                padding: 1rem 0;
            }

            .menu-section-title {
                font-size: 0.875rem;
                padding: 0.75rem 1.25rem;
            }

            .menu-link {
                padding: 0.875rem 1.25rem;
                font-size: 0.9375rem;
            }

            .menu-icon {
                font-size: 1.125rem;
            }

            /* Mobile Toggle Button */
            .sidebar-toggle {
                display: flex !important;
                align-items: center;
                justify-content: center;
                width: 50px;
                height: 50px;
                border-radius: 50%;
                background: linear-gradient(135deg, var(--primary), var(--primary-dark));
                color: white;
                border: none;
                font-size: 1.25rem;
                cursor: pointer;
                box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
                transition: all 0.3s ease;
            }

            .sidebar-toggle:hover {
                transform: scale(1.05);
                box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
            }

            /* Mobile Backdrop */
            .sidebar-backdrop {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }

            .sidebar-backdrop.active {
                opacity: 1;
                visibility: visible;
            }
            
            /* تحسين النماذج على الجوال */
            .form-control,
            input[type="text"],
            input[type="number"],
            input[type="email"],
            input[type="password"],
            input[type="file"],
            textarea,
            select {
                font-size: 16px !important; /* يمنع zoom في iOS */
                width: 100% !important;
                min-height: 44px;
                -webkit-appearance: none;
                appearance: none;
            }
            
            /* تحسين الأزرار */
            button,
            .btn-primary,
            .btn-secondary,
            .btn {
                min-height: 44px;
                touch-action: manipulation;
                -webkit-tap-highlight-color: rgba(16, 185, 129, 0.2);
            }
            
            /* تحسين الجداول */
            table {
                display: block;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            
            /* تحسين Cards */
            .card {
                padding: 1rem !important;
            }
            
            /* تحسين Form Grid */
            .form-grid {
                grid-template-columns: 1fr !important;
            }
            
            /* تحسين العناوين */
            h1, h2, h3 {
                word-wrap: break-word;
            }
            
            /* تحسين الصور في الجداول */
            .table img {
                max-width: 60px;
                height: auto;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <div class="logo-icon">
                <i class="fas fa-leaf"></i>
            </div>
            <div class="logo-text">لُجين</div>
        </div>
        
        <nav class="sidebar-menu">
            <div class="menu-section">
                <div class="menu-section-title">الرئيسية</div>
                <div class="menu-item">
                    <a href="{{ route('admin.dashboard') }}" class="menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-chart-line"></i>
                        <span>لوحة التحكم</span>
                    </a>
                </div>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">المتجر</div>
                <div class="menu-item">
                    <a href="{{ route('admin.products.index') }}" class="menu-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-box"></i>
                        <span>المنتجات</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="{{ route('admin.categories.index') }}" class="menu-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-folder-tree"></i>
                        <span>التصنيفات</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="{{ route('admin.orders.index') }}" class="menu-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-shopping-cart"></i>
                        <span>الطلبات</span>
                        <span class="badge">{{ \App\Models\Order::where('status', 'pending')->count() }}</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="{{ route('admin.customers.index') }}" class="menu-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-users"></i>
                        <span>العملاء المسجلين</span>
                    </a>
                </div>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">المالية</div>
                <div class="menu-item">
                    <a href="{{ route('admin.payments.index') }}" class="menu-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-credit-card"></i>
                        <span>المدفوعات</span>
                    </a>
                </div>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">التسويق والتحليلات</div>
                <div class="menu-item">
                    <a href="{{ route('admin.analytics.index') }}" class="menu-link {{ request()->routeIs('admin.analytics.*') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-chart-bar"></i>
                        <span>التحليلات والإحصائيات</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="{{ route('admin.campaigns.index') }}" class="menu-link {{ request()->routeIs('admin.campaigns.*') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-paper-plane"></i>
                        <span>الحملات التسويقية</span>
                    </a>
                </div>
            </div>

            <div class="menu-section">
                <div class="menu-section-title">الإعدادات</div>
                <div class="menu-item">
                    <a href="{{ route('admin.settings.index') }}" class="menu-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <i class="menu-icon fas fa-cog"></i>
                        <span>الإعدادات</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="{{ route('home') }}" class="menu-link">
                        <i class="menu-icon fas fa-external-link-alt"></i>
                        <span>زيارة الموقع</span>
                    </a>
                </div>
                <div class="menu-item">
                    <a href="{{ route('logout') }}" class="menu-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="menu-icon fas fa-sign-out-alt"></i>
                        <span>تسجيل الخروج</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        </nav>
    </aside>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <header class="topbar">
            <!-- Mobile Sidebar Toggle -->
            <button class="sidebar-toggle" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Mobile Backdrop -->
            <div class="sidebar-backdrop" onclick="closeSidebar()"></div>

            <div class="search-container">
                <i class="search-icon fas fa-search"></i>
                <input type="text" class="search-input" placeholder="ابحث عن منتجات، طلبات، أو عملاء...">
            </div>
            
            <div class="topbar-actions">
                <button class="notification-btn">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge"></span>
                </button>
                
                <div class="user-menu">
                    <div class="user-info">
                        <div class="user-name">{{ auth()->user()->name }}</div>
                        <div class="user-role">مدير النظام</div>
                    </div>
                    <div class="user-avatar">
                        {{ mb_substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="content-area">
            @yield('content')
        </main>
    </div>

    <script>
    // Mobile Sidebar Toggle Functions
    function toggleSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const backdrop = document.querySelector('.sidebar-backdrop');

        if (sidebar && backdrop) {
            sidebar.classList.toggle('active');
            backdrop.classList.toggle('active');

            // Prevent body scroll when sidebar is open
            if (sidebar.classList.contains('active')) {
                document.body.style.overflow = 'hidden';
            } else {
                document.body.style.overflow = 'auto';
            }
        }
    }

    function closeSidebar() {
        const sidebar = document.querySelector('.sidebar');
        const backdrop = document.querySelector('.sidebar-backdrop');

        if (sidebar && backdrop) {
            sidebar.classList.remove('active');
            backdrop.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
    }

    // Auto-close sidebar when clicking outside on mobile
    document.addEventListener('click', function(e) {
        const sidebar = document.querySelector('.sidebar');
        const toggleBtn = document.querySelector('.sidebar-toggle');

        if (window.innerWidth <= 768 && sidebar && toggleBtn) {
            if (sidebar.classList.contains('active') &&
                !sidebar.contains(e.target) &&
                !toggleBtn.contains(e.target)) {
                closeSidebar();
            }
        }
    });

    // Close sidebar on window resize if mobile view
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            closeSidebar();
        }
    });

    // Initialize tooltips and other admin features
    document.addEventListener('DOMContentLoaded', function() {
        // Add loading animations for admin elements
        const adminCards = document.querySelectorAll('.stat-card, .menu-link');
        adminCards.forEach((card, index) => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';

            setTimeout(() => {
                card.style.transition = 'all 0.4s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
    </script>
</body>
</html>
