@extends('layouts.admin')

@section('title', 'إدارة المنتجات')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="fas fa-box"></i>
            إدارة المنتجات
        </h1>
        <p style="color: #6b7280; margin-top: 0.5rem; font-size: 0.95rem;">
            إدارة شاملة لجميع المنتجات في المتجر
        </p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="btn">
        <i class="fas fa-plus"></i> إضافة منتج جديد
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<!-- Statistics Cards -->
@php
    $totalProducts = \App\Models\Product::count();
    $activeProducts = \App\Models\Product::where('status', 'active')->count();
    $lowStockProducts = \App\Models\Product::where('stock', '<=', 10)->where('stock', '>', 0)->count();
    $outOfStockProducts = \App\Models\Product::where('stock', 0)->count();
@endphp

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <!-- إجمالي المنتجات -->
    <div class="stat-card" style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); color: white;">
        <div class="stat-icon">
            <i class="fas fa-box"></i>
        </div>
        <div class="stat-content">
            <h3 class="stat-value">{{ $totalProducts }}</h3>
            <p class="stat-label">إجمالي المنتجات</p>
        </div>
    </div>

    <!-- المنتجات النشطة -->
    <div class="stat-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white;">
        <div class="stat-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-content">
            <h3 class="stat-value">{{ $activeProducts }}</h3>
            <p class="stat-label">منتجات نشطة</p>
        </div>
    </div>

    <!-- مخزون منخفض -->
    <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white;">
        <div class="stat-icon">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <div class="stat-content">
            <h3 class="stat-value">{{ $lowStockProducts }}</h3>
            <p class="stat-label">مخزون منخفض</p>
        </div>
    </div>

    <!-- نفذت الكمية -->
    <div class="stat-card" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: white;">
        <div class="stat-icon">
            <i class="fas fa-times-circle"></i>
        </div>
        <div class="stat-content">
            <h3 class="stat-value">{{ $outOfStockProducts }}</h3>
            <p class="stat-label">نفذت الكمية</p>
        </div>
    </div>
</div>

<!-- Filters & Search -->
<div class="card" style="margin-bottom: 1.5rem; padding: 1.5rem;">
    <form method="GET" action="{{ route('admin.products.index') }}" id="filterForm">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; align-items: end;">
            <!-- بحث -->
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151; font-size: 0.9rem;">
                    <i class="fas fa-search"></i> البحث
                </label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="ابحث عن منتج..." 
                       class="form-control" 
                       style="width: 100%;">
            </div>

            <!-- الفئة -->
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151; font-size: 0.9rem;">
                    <i class="fas fa-folder"></i> الفئة
                </label>
                <select name="category" class="form-control" style="width: 100%;">
                    <option value="">جميع الفئات</option>
                    @foreach(\App\Models\Category::whereNull('parent_id')->get() as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name_ar }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- الحالة -->
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151; font-size: 0.9rem;">
                    <i class="fas fa-toggle-on"></i> الحالة
                </label>
                <select name="status" class="form-control" style="width: 100%;">
                    <option value="">جميع الحالات</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشط</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                    <option value="out_of_stock" {{ request('status') == 'out_of_stock' ? 'selected' : '' }}>نفذت الكمية</option>
                </select>
            </div>

            <!-- المخزون -->
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; color: #374151; font-size: 0.9rem;">
                    <i class="fas fa-warehouse"></i> المخزون
                </label>
                <select name="stock" class="form-control" style="width: 100%;">
                    <option value="">الكل</option>
                    <option value="low" {{ request('stock') == 'low' ? 'selected' : '' }}>منخفض (أقل من 10)</option>
                    <option value="out" {{ request('stock') == 'out' ? 'selected' : '' }}>نفذت الكمية</option>
                </select>
            </div>

            <!-- الأزرار -->
            <div style="display: flex; gap: 0.5rem;">
                <button type="submit" class="btn" style="flex: 1;">
                    <i class="fas fa-filter"></i> تطبيق
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary" style="flex: 1;">
                    <i class="fas fa-redo"></i> إعادة تعيين
                </a>
            </div>
        </div>
    </form>
</div>

<style>
.stat-card {
    padding: 1.5rem;
    border-radius: 16px;
    display: flex;
    align-items: center;
    gap: 1.25rem;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    transition: transform 0.2s, box-shadow 0.2s;
}

.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.stat-icon {
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.75rem;
}

.stat-content {
    flex: 1;
}

.stat-value {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
    line-height: 1;
}

.stat-label {
    font-size: 0.95rem;
    margin: 0.5rem 0 0 0;
    opacity: 0.9;
}

.form-control {
    padding: 0.625rem 0.875rem;
    border: 1px solid #d1d5db;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: all 0.2s;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(168, 85, 247, 0.1);
}
</style>

<!-- Products Table -->
<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>الصورة</th>
                    <th>اسم المنتج</th>
                    <th>التصنيف</th>
                    <th>السعر</th>
                    <th>المخزون</th>
                    <th>المميزات</th>
                    <th>الحالة</th>
                    <th style="text-align: center;">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td>
                        @if($product->image)
                            @if(str_starts_with($product->image, 'http'))
                                <img src="{{ $product->image }}" alt="{{ $product->name_ar }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 10px;">
                            @else
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name_ar }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 10px;">
                            @endif
                        @else
                        <div style="width: 50px; height: 50px; background: linear-gradient(135deg, #e5e7eb, #d1d5db); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-image" style="color: #9ca3af;"></i>
                        </div>
                        @endif
                    </td>
                    <td style="font-weight: 600;">{{ $product->name_ar }}</td>
                    <td>{{ $product->category->name_ar ?? '-' }}</td>
                    <td>
                        <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                            @if($product->sale_price && $product->sale_price < $product->price)
                                <span style="text-decoration: line-through; color: #9ca3af; font-size: 0.875rem;">{{ number_format($product->price, 2) }} ر.س</span>
                                <span style="font-weight: 700; color: #ef4444;">{{ number_format($product->sale_price, 2) }} ر.س</span>
                                <span class="badge badge-danger" style="font-size: 0.75rem;">خصم {{ $product->getDiscountPercentage() }}%</span>
                            @else
                                <span style="font-weight: 700; color: var(--primary);">{{ number_format($product->price, 2) }} ر.س</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <span class="badge {{ $product->stock > 10 ? 'badge-success' : ($product->stock > 0 ? 'badge-warning' : 'badge-danger') }}">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; flex-direction: column; gap: 0.25rem;">
                            @if($product->is_featured)
                                <span class="badge" style="background: #f59e0b; color: white; font-size: 0.75rem;">
                                    <i class="fas fa-star"></i> مميز
                                </span>
                            @endif
                            @if($product->is_special_offer)
                                <span class="badge" style="background: #ef4444; color: white; font-size: 0.75rem;">
                                    <i class="fas fa-fire"></i> عرض خاص
                                </span>
                            @endif
                            @if(!$product->is_featured && !$product->is_special_offer)
                                <span style="color: #9ca3af; font-size: 0.875rem;">-</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <span class="badge {{ $product->status === 'active' ? 'badge-success' : 'badge-danger' }}">
                            {{ $product->status === 'active' ? 'نشط' : 'غير نشط' }}
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <div style="display: flex; gap: 0.5rem; justify-content: center;">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-secondary" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنتج؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.875rem;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="padding: 3rem; text-align: center; color: #9ca3af;">
                        <i class="fas fa-box-open" style="font-size: 3rem; opacity: 0.3; display: block; margin-bottom: 1rem;"></i>
                        <p style="font-size: 1.125rem; margin-bottom: 1rem;">لا توجد منتجات حالياً</p>
                        <a href="{{ route('admin.products.create') }}" class="btn">
                            <i class="fas fa-plus"></i> إضافة منتج جديد
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
    <div style="margin-top: 2rem; display: flex; justify-content: center;">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection

