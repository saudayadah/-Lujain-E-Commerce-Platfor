@extends('layouts.app')

@section('title', 'جميع المنتجات')

@push('styles')
    @include('layouts.product-grid-styles')
    <style>
    /* إجبار تطبيق الأنماط المحدثة - 6 منتجات في الصف على الشاشات الكبيرة */
    .product-grid-modern {
        display: grid !important;
        gap: 1.25rem !important;
        grid-template-columns: repeat(6, 1fr) !important;
        align-items: stretch !important;
    }
    
    .product-image-wrapper {
        padding-top: 100% !important;
        aspect-ratio: 1 / 1 !important;
    }
    
    /* Desktop Large (> 1400px) - 6 منتجات */
    @media (min-width: 1400px) {
        .product-grid-modern {
            grid-template-columns: repeat(6, 1fr) !important;
            gap: 1.25rem !important;
        }
    }
    
    /* Desktop (1200px - 1400px) - 6 منتجات */
    @media (min-width: 1200px) and (max-width: 1399px) {
        .product-grid-modern {
            grid-template-columns: repeat(6, 1fr) !important;
            gap: 1rem !important;
        }
    }
    
    /* Desktop Medium (992px - 1199px) - 4 منتجات */
    @media (min-width: 992px) and (max-width: 1199px) {
        .product-grid-modern {
            grid-template-columns: repeat(4, 1fr) !important;
            gap: 0.875rem !important;
        }
    }
    
    /* Tablet (768px - 991px) - 3 منتجات */
    @media (max-width: 991px) and (min-width: 768px) {
        .product-grid-modern {
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 0.75rem !important;
        }
    }
    
    /* Tablet Small (576px - 767px) - 3 منتجات */
    @media (max-width: 767px) and (min-width: 576px) {
        .product-grid-modern {
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 0.625rem !important;
        }
    }
    
    /* Mobile (max-width: 575px) - عمودين */
    @media (max-width: 575px) {
        .product-grid-modern {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 0.625rem !important;
        }
    }
    
    /* Very Small Mobile (max-width: 375px) - عمودين */
    @media (max-width: 375px) {
        .product-grid-modern {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 0.5rem !important;
        }
    }
    </style>
@endpush

@section('content')

<style>
/* Mobile-First Products Page */
@media (max-width: 768px) {
    .container {
        padding: 1rem 0.75rem !important;
    }
    
    /* Hero Header - Mobile */
    .container > div:first-of-type {
        padding: 1.5rem 1rem !important;
        margin-bottom: 1.5rem !important;
        border-radius: 12px !important;
    }
    
    .container > div:first-of-type h1 {
        font-size: 1.5rem !important;
        margin-bottom: 0.5rem !important;
    }
    
    .container > div:first-of-type p {
        font-size: 0.875rem !important;
    }
    
    /* Filters - Mobile Stack */
    .container > div:nth-of-type(2) {
        padding: 1rem !important;
        margin-bottom: 1.5rem !important;
    }
    
    .container > div:nth-of-type(2) form {
        grid-template-columns: 1fr !important;
        gap: 0.75rem !important;
    }
    
    .container > div:nth-of-type(2) form div,
    .container > div:nth-of-type(2) form button {
        width: 100% !important;
        min-width: auto !important;
    }
    
    .container > div:nth-of-type(2) form input,
    .container > div:nth-of-type(2) form select,
    .container > div:nth-of-type(2) form button {
        padding: 0.625rem 1rem !important;
        font-size: 0.875rem !important;
    }
    
    /* Products Grid - 2 Columns */
    .product-grid {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 0.75rem !important;
    }
    
    .product-card {
        border-radius: 12px !important;
    }
    
    .product-image {
        height: 140px !important;
    }
    
    .product-card > div:last-child {
        padding: 0.75rem !important;
    }
    
    .product-category {
        font-size: 0.6875rem !important;
        margin-bottom: 0.375rem !important;
    }
    
    .product-name {
        font-size: 0.8125rem !important;
        line-height: 1.3 !important;
        margin-bottom: 0.5rem !important;
        height: 34px !important;
        overflow: hidden !important;
        display: -webkit-box !important;
        -webkit-line-clamp: 2 !important;
        -webkit-box-orient: vertical !important;
    }
    
    .product-price-wrapper {
        margin-bottom: 0.5rem !important;
    }
    
    .product-price {
        font-size: 0.9375rem !important;
    }
    
    .product-old-price {
        font-size: 0.75rem !important;
    }
    
    .product-stock {
        font-size: 0.6875rem !important;
        margin-bottom: 0.5rem !important;
        padding: 0.25rem 0.5rem !important;
    }
    
    .product-add-btn,
    .product-view-btn {
        padding: 0.5rem !important;
        font-size: 0.8125rem !important;
    }
    
    .product-actions {
        gap: 0.375rem !important;
    }
    
    /* Pagination - Mobile */
    .pagination {
        flex-wrap: wrap !important;
        gap: 0.375rem !important;
    }
    
    .pagination a,
    .pagination span {
        min-width: 36px !important;
        height: 36px !important;
        font-size: 0.875rem !important;
        padding: 0.375rem !important;
    }
    
    /* Empty State - Mobile */
    .empty-state {
        padding: 2rem 1rem !important;
    }
    
    .empty-state i {
        font-size: 3rem !important;
        margin-bottom: 1rem !important;
    }
    
    .empty-state h3 {
        font-size: 1.125rem !important;
    }
    
    .empty-state p {
        font-size: 0.875rem !important;
    }
}
</style>

<div class="container" style="padding-top: 2rem;">
    <!-- Hero Header -->
    <div style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; padding: 3rem; border-radius: 20px; margin-bottom: 3rem; text-align: center; box-shadow: 0 10px 30px rgba(16,185,129,0.2);">
        <h1 style="font-size: 2.5rem; font-weight: 900; margin-bottom: 1rem;">
            <i class="fas fa-shopping-basket"></i> جميع المنتجات
        </h1>
        <p style="font-size: 1.2rem; opacity: 0.95;">
            اختر من بين مجموعتنا الواسعة من المنتجات الزراعية عالية الجودة
        </p>
        <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid rgba(255,255,255,0.2);">
            <span style="font-size: 1rem; opacity: 0.9;">
                <i class="fas fa-box"></i> {{ $products->total() }} منتج متاح
            </span>
        </div>
    </div>

    <!-- Filters & Search -->
    <div style="background: white; padding: 2rem; border-radius: 16px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); margin-bottom: 3rem; border: 1px solid var(--gray-200);">
        <form method="GET" action="{{ route('products.index') }}" style="display: grid; grid-template-columns: 1fr auto auto; gap: 1rem; align-items: end;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--dark); font-size: 0.9375rem;">
                    <i class="fas fa-search" style="color: var(--primary); margin-left: 0.25rem;"></i> البحث
                </label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="ابحث عن منتج..."
                       style="width: 100%; padding: 0.85rem 1.25rem; border: 2px solid var(--gray-200); border-radius: 10px; font-size: 1rem; transition: all 0.3s ease; font-weight: 500;"
                       onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 3px rgba(16,185,129,0.1)'"
                       onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
            </div>
            
            <div style="min-width: 220px;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--dark); font-size: 0.9375rem;">
                    <i class="fas fa-filter" style="color: var(--primary); margin-left: 0.25rem;"></i> التصنيف
                </label>
                <select name="category" onchange="this.form.submit()" style="width: 100%; padding: 0.85rem 1.25rem; border: 2px solid var(--gray-200); border-radius: 10px; font-size: 1rem; font-weight: 500; cursor: pointer; transition: all 0.3s ease;"
                        onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 3px rgba(16,185,129,0.1)'"
                        onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                    <option value="">كل التصنيفات</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name_ar }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <button type="submit" class="btn" style="padding: 0.85rem 2rem; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border: none; box-shadow: 0 4px 12px rgba(16,185,129,0.3); font-weight: 700;">
                <i class="fas fa-search"></i>
                بحث
            </button>
        </form>
    </div>

    <!-- Products Grid -->
    @if($products->count() > 0)
        <div class="product-grid-modern" style="display: grid !important; grid-template-columns: repeat(6, 1fr) !important; gap: 1.25rem !important; width: 100% !important;">
            @foreach($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div style="margin-top: 3rem; display: flex; justify-content: center;">
            {{ $products->appends(request()->query())->links() }}
        </div>
    @else
        <div style="text-align: center; padding: 4rem; background: white; border-radius: 16px; border: 1px solid var(--gray-200);">
            <i class="fas fa-inbox" style="font-size: 5rem; color: var(--gray-400); margin-bottom: 1.5rem;"></i>
            <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--dark); margin-bottom: 0.5rem;">لا توجد منتجات</h3>
            <p style="color: var(--gray-600); margin-bottom: 2rem;">جرب البحث بكلمات مختلفة أو غيّر التصنيف</p>
            <a href="{{ route('products.index') }}" class="btn" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-redo"></i>
                مسح البحث
            </a>
        </div>
    @endif
</div>

<style>
/* تحسينات خاصة بصفحة المنتجات للهواتف المحمولة */
@media (max-width: 768px) {
    .container {
        padding: 0 1rem;
    }

    /* رأس الصفحة محسن للهواتف المحمولة */
    [style*="background: linear-gradient"] {
        padding: 2rem 1rem !important;
        margin-bottom: 2rem !important;
    }

    [style*="background: linear-gradient"] h1 {
        font-size: 2rem !important;
    }

    [style*="background: linear-gradient"] p {
        font-size: 1rem !important;
    }

    /* نموذج الفلاتر محسن للهواتف المحمولة */
    [style*="display: grid; grid-template-columns: 1fr auto auto"] {
        grid-template-columns: 1fr !important;
        gap: 1.5rem !important;
    }

    /* الفلاتر محسنة للهواتف المحمولة */
    [style*="display: flex; gap: 1rem; align-items: end"] {
        flex-direction: column !important;
        gap: 1.5rem !important;
    }

    /* أزرار الفلاتر محسنة للهواتف المحمولة */
    [style*="display: flex; gap: 0.5rem; flex-wrap: wrap"] {
        gap: 0.75rem !important;
    }

    .filter-btn {
        padding: 0.75rem 1.25rem !important;
        font-size: 0.875rem !important;
        border-radius: 25px !important;
    }


    .product-image {
        height: 250px !important;
    }

    .product-info {
        padding: 1.5rem !important;
    }

    .product-title {
        font-size: 1.125rem !important;
        line-height: 1.4 !important;
    }

    .product-price {
        font-size: 1.5rem !important;
    }

    .product-actions {
        flex-direction: column !important;
        gap: 0.75rem !important;
    }

    .btn-add-cart {
        padding: 0.875rem !important;
        font-size: 0.9375rem !important;
    }

    /* رسالة عدم وجود منتجات محسنة للهواتف المحمولة */
    [style*="text-align: center; padding: 4rem"] {
        padding: 3rem 1.5rem !important;
    }

    [style*="text-align: center; padding: 4rem"] h3 {
        font-size: 1.5rem !important;
    }

    [style*="text-align: center; padding: 4rem"] p {
        font-size: 1rem !important;
        margin-bottom: 1.5rem !important;
    }
}

@media (max-width: 480px) {
    .container {
        padding: 0 0.75rem;
    }

    /* رأس الصفحة محسن للشاشات الصغيرة */
    [style*="background: linear-gradient"] {
        padding: 1.5rem 0.75rem !important;
        margin: 0.5rem !important;
        margin-bottom: 1.5rem !important;
    }

    [style*="background: linear-gradient"] h1 {
        font-size: 1.75rem !important;
    }

    [style*="background: linear-gradient"] p {
        font-size: 0.9375rem !important;
    }

    /* نموذج الفلاتر محسن للشاشات الصغيرة */
    [style*="display: grid; grid-template-columns: 1fr"] {
        gap: 1.25rem !important;
    }

    /* الفلاتر محسنة للشاشات الصغيرة */
    [style*="display: flex; gap: 1rem; align-items: end"] {
        gap: 1.25rem !important;
    }

    /* أزرار الفلاتر محسنة للشاشات الصغيرة */
    .filter-btn {
        padding: 0.625rem 1rem !important;
        font-size: 0.8125rem !important;
    }

    /* شبكة المنتجات محسنة للشاشات الصغيرة */
    .product-grid {
        gap: 1rem !important;
    }

    .product-card {
        border-radius: 12px !important;
    }

    .product-image {
        height: 200px !important;
    }

    .product-info {
        padding: 1.25rem !important;
    }

    .product-title {
        font-size: 1rem !important;
    }

    .product-price {
        font-size: 1.25rem !important;
    }

    /* رسالة عدم وجود منتجات محسنة للشاشات الصغيرة */
    [style*="text-align: center; padding: 3rem"] {
        padding: 2.5rem 1rem !important;
    }

    [style*="text-align: center; padding: 3rem"] h3 {
        font-size: 1.25rem !important;
    }
}
</style>

@endsection

