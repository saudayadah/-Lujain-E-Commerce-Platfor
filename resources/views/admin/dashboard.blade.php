@extends('layouts.admin')

@section('title', 'لوحة التحكم')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="fas fa-chart-line"></i>
            لوحة التحكم
        </h1>
        <p style="color: var(--gray-600); margin-top: 0.5rem;">مرحباً بك، إليك نظرة عامة على متجرك</p>
    </div>
    <div style="display: flex; gap: 0.75rem;">
        <a href="{{ route('admin.orders.index', ['export' => 'pdf']) }}" class="btn btn-outline btn-sm">
            <i class="fas fa-download"></i> تصدير التقرير
        </a>
        <a href="{{ route('admin.products.create') }}" class="btn btn-sm">
            <i class="fas fa-plus"></i> إضافة منتج
        </a>
    </div>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <a href="{{ route('admin.orders.index', ['payment_status' => 'paid']) }}" class="stat-card" style="text-decoration: none; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 24px rgba(0,0,0,0.12)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'">
        <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #059669); color: white;">
            <i class="fas fa-dollar-sign"></i>
        </div>
        <div class="stat-value">{{ number_format($stats['total_revenue'], 0) }}</div>
        <div class="stat-label">إجمالي المبيعات (ر.س)</div>
        <div class="stat-change positive">
            <i class="fas fa-arrow-up"></i>
            <span>انقر لعرض الطلبات المدفوعة</span>
        </div>
    </a>

    <a href="{{ route('admin.orders.index') }}" class="stat-card" style="text-decoration: none; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 24px rgba(0,0,0,0.12)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'">
        <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white;">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <div class="stat-value">{{ $stats['total_orders'] }}</div>
        <div class="stat-label">إجمالي الطلبات</div>
        <div class="stat-change positive">
            <i class="fas fa-arrow-left"></i>
            <span>انقر لعرض جميع الطلبات</span>
        </div>
    </a>

    <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="stat-card" style="text-decoration: none; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 24px rgba(0,0,0,0.12)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'">
        <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white;">
            <i class="fas fa-clock"></i>
        </div>
        <div class="stat-value">{{ $stats['pending_orders'] }}</div>
        <div class="stat-label">طلبات قيد المراجعة</div>
        <div class="stat-change" style="color: var(--warning);">
            <i class="fas fa-exclamation-circle"></i>
            <span>تحتاج إلى مراجعة</span>
        </div>
    </a>

    <a href="{{ route('admin.products.index') }}" class="stat-card" style="text-decoration: none; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 24px rgba(0,0,0,0.12)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'">
        <div class="stat-icon" style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); color: white;">
            <i class="fas fa-box"></i>
        </div>
        <div class="stat-value">{{ $stats['total_products'] }}</div>
        <div class="stat-label">المنتجات المتاحة</div>
        <div class="stat-change positive">
            <i class="fas fa-arrow-left"></i>
            <span>انقر لعرض جميع المنتجات</span>
        </div>
    </a>

    <a href="{{ route('admin.customers.index') }}" class="stat-card" style="text-decoration: none; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 24px rgba(0,0,0,0.12)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'">
        <div class="stat-icon" style="background: linear-gradient(135deg, #ec4899, #db2777); color: white;">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-value">{{ $stats['total_customers'] }}</div>
        <div class="stat-label">العملاء المسجلين</div>
        <div class="stat-change positive">
            <i class="fas fa-arrow-left"></i>
            <span>انقر لعرض جميع العملاء</span>
        </div>
    </a>

    <a href="{{ route('admin.payments.dashboard') }}" class="stat-card" style="text-decoration: none; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 24px rgba(0,0,0,0.12)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'">
        <div class="stat-icon" style="background: linear-gradient(135deg, #6366f1, #4f46e5); color: white;">
            <i class="fas fa-credit-card"></i>
        </div>
        <div class="stat-value">{{ number_format(\App\Models\Payment::where('status', 'completed')->count()) }}</div>
        <div class="stat-label">المدفوعات الناجحة</div>
        <div class="stat-change positive">
            <i class="fas fa-arrow-left"></i>
            <span>لوحة المدفوعات</span>
        </div>
    </a>
</div>

<!-- Quick Actions -->
<div class="card" style="margin-bottom: 2rem;">
    <div class="card-header">
        <h2 class="card-title">
            <i class="fas fa-bolt" style="color: var(--primary); margin-left: 0.5rem;"></i>
            إجراءات سريعة
        </h2>
    </div>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
        <a href="{{ route('admin.products.create') }}" class="btn">
            <i class="fas fa-plus-circle"></i> إضافة منتج
        </a>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
            <i class="fas fa-list"></i> عرض الطلبات
        </a>
        <a href="{{ route('admin.categories.index') }}" class="btn-outline btn">
            <i class="fas fa-folder"></i> إدارة التصنيفات
        </a>
        <a href="{{ route('admin.settings.index') }}" class="btn-outline btn">
            <i class="fas fa-cog"></i> الإعدادات
        </a>
    </div>
</div>

<!-- Recent Orders & Low Stock -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 1.5rem;">
    <!-- Recent Orders -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-shopping-bag" style="color: var(--primary); margin-left: 0.5rem;"></i>
                أحدث الطلبات
            </h3>
            <a href="{{ route('admin.orders.index') }}" style="color: var(--primary); font-size: 0.875rem; font-weight: 600; text-decoration: none;">
                عرض الكل <i class="fas fa-arrow-left"></i>
            </a>
        </div>
        
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            @forelse($recentOrders as $order)
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: var(--gray-50); border-radius: 12px; transition: all 0.2s ease;" onmouseover="this.style.background='var(--gray-100)'" onmouseout="this.style.background='var(--gray-50)'">
                <div>
                    <div style="font-weight: 600; color: var(--dark); margin-bottom: 0.25rem;">#{{ $order->order_number }}</div>
                    <div style="font-size: 0.875rem; color: var(--gray-600);">{{ $order->created_at->diffForHumans() }}</div>
                </div>
                <div style="text-align: left;">
                    <div style="font-weight: 700; color: var(--primary); margin-bottom: 0.25rem;">{{ number_format($order->total, 2) }} ر.س</div>
                    <span class="badge badge-success" style="font-size: 0.75rem;">مكتمل</span>
                </div>
            </div>
            @empty
            <div style="text-align: center; padding: 3rem 1rem; color: var(--gray-400);">
                <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;"></i>
                <p>لا توجد طلبات حالياً</p>
            </div>
            @endforelse
        </div>
    </div>
    
    <!-- Low Stock Products -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-exclamation-triangle" style="color: var(--warning); margin-left: 0.5rem;"></i>
                تنبيهات المخزون
            </h3>
            <a href="{{ route('admin.products.index') }}" style="color: var(--primary); font-size: 0.875rem; font-weight: 600; text-decoration: none;">
                عرض الكل <i class="fas fa-arrow-left"></i>
            </a>
        </div>
        
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            @forelse($lowStockProducts as $product)
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: #fef3c7; border-radius: 12px; border-right: 3px solid var(--warning);">
                <div>
                    <div style="font-weight: 600; color: var(--dark); margin-bottom: 0.25rem;">{{ $product->getName() }}</div>
                    <div style="font-size: 0.875rem; color: var(--gray-600);">{{ $product->sku ?? 'لا يوجد SKU' }}</div>
                </div>
                <div>
                    <span class="badge badge-warning">{{ $product->stock }} متبقي</span>
                </div>
            </div>
            @empty
            <div style="text-align: center; padding: 3rem 1rem; color: var(--gray-400);">
                <i class="fas fa-check-circle" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5; color: var(--success);"></i>
                <p>جميع المنتجات متوفرة</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Top Products (if you want to add later) -->
<div class="card" style="margin-top: 2rem;">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-fire" style="color: var(--danger); margin-left: 0.5rem;"></i>
            المنتجات الأكثر مبيعاً
        </h3>
    </div>
    
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>المنتج</th>
                    <th>السعر</th>
                    <th>المبيعات</th>
                    <th>الإيرادات</th>
                </tr>
            </thead>
            <tbody>
                @for($i = 0; $i < 5; $i++)
                <tr>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 40px; height: 40px; background: var(--gray-100); border-radius: 8px;"></div>
                            <div>
                                <div style="font-weight: 600;">منتج تجريبي {{ $i + 1 }}</div>
                                <div style="font-size: 0.875rem; color: var(--gray-600);">تصنيف عام</div>
                            </div>
                        </div>
                    </td>
                    <td style="font-weight: 600;">{{ number_format(rand(50, 500), 2) }} ر.س</td>
                    <td><span class="badge badge-info">{{ rand(10, 100) }} قطعة</span></td>
                    <td style="font-weight: 700; color: var(--primary);">{{ number_format(rand(500, 10000), 2) }} ر.س</td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>
@endsection
