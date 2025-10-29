@extends('layouts.app')

@section('title', $category->name_ar)

@push('styles')
    @include('layouts.product-grid-styles')
    <style>
    /* ضمان تطبيق التنسيقات بشكل صحيح في صفحة الفئات */
    .product-grid-modern {
        display: grid !important;
        gap: 1.25rem !important;
        width: 100% !important;
        align-items: stretch !important;
        grid-template-columns: repeat(6, 1fr) !important;
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
    @media (min-width: 768px) and (max-width: 991px) {
        .product-grid-modern {
            grid-template-columns: repeat(3, 1fr) !important;
            gap: 0.75rem !important;
        }
    }

    /* Tablet Small (576px - 767px) - 3 منتجات */
    @media (min-width: 576px) and (max-width: 767px) {
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
/* Mobile-First Category Page */
@media (max-width: 768px) {
    .container {
        padding: 1rem 0.75rem !important;
    }
    
    /* Breadcrumb - Mobile */
    nav.mb-6 {
        margin-bottom: 1rem !important;
        font-size: 0.75rem !important;
    }
    
    /* Category Header - Mobile */
    .bg-white.rounded-xl.shadow-sm.p-6 {
        padding: 1.25rem !important;
        margin-bottom: 1.5rem !important;
        border-radius: 12px !important;
    }
    
    .text-3xl {
        font-size: 1.375rem !important;
    }
    
    .text-lg {
        font-size: 0.9375rem !important;
    }
    
    /* Two Column Layout - Stack on Mobile */
    .lg\\:grid {
        display: block !important;
    }
    
    /* Sidebar - Hide on Mobile, Show as Modal */
    aside.lg\\:col-span-1 {
        display: none !important;
    }
    
    /* Main Content - Full Width */
    .lg\\:col-span-3 {
        width: 100% !important;
    }
    
    /* Sort & View - Mobile */
    .flex.justify-between.items-center {
        flex-wrap: wrap !important;
        gap: 0.75rem !important;
        padding: 0.75rem !important;
        margin-bottom: 1rem !important;
    }
    
    .flex.justify-between.items-center > div {
        flex: 1 1 100% !important;
    }
    
    .form-select {
        width: 100% !important;
        padding: 0.625rem 1rem !important;
        font-size: 0.875rem !important;
    }
    
    /* View Toggle Buttons - Mobile */
    .flex.items-center.space-x-2 {
        justify-content: center !important;
        width: 100% !important;
    }
    
    /* Products Grid - 2 Columns */
    #productsContainer {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 0.75rem !important;
    }
    
    .product-card {
        border-radius: 12px !important;
    }
    
    .relative.h-48 {
        height: 140px !important;
    }
    
    .p-4 {
        padding: 0.75rem !important;
    }
    
    .text-lg.font-bold {
        font-size: 0.8125rem !important;
        line-height: 1.3 !important;
    }
    
    .text-sm {
        font-size: 0.6875rem !important;
    }
    
    .text-xl {
        font-size: 0.9375rem !important;
    }
    
    .py-2.px-4 {
        padding: 0.5rem 0.75rem !important;
        font-size: 0.8125rem !important;
    }
    
    .p-2 {
        padding: 0.5rem !important;
    }
    
    /* Mobile Filter Button */
    .mobile-filter-btn {
        display: block !important;
        width: 100%;
        background: var(--primary);
        color: white;
        border: none;
        border-radius: 10px;
        padding: 0.75rem;
        font-size: 0.9375rem;
        font-weight: 600;
        margin-bottom: 1rem;
        cursor: pointer;
    }
    
    /* Empty State - Mobile */
    .bg-white.rounded-xl.shadow-sm.p-8.text-center {
        padding: 2rem 1rem !important;
    }
    
    .text-6xl {
        font-size: 3rem !important;
    }
    
    .text-2xl {
        font-size: 1.125rem !important;
    }
    
    /* Pagination - Mobile */
    .pagination {
        flex-wrap: wrap !important;
        gap: 0.375rem !important;
    }
}

/* Desktop Only */
@media (min-width: 769px) {
    .mobile-filter-btn {
        display: none !important;
    }
}
</style>
<div class="container" style="padding: 2rem 1.5rem; max-width: 1400px; margin: 0 auto;">
    
    <!-- Breadcrumb -->
    <nav style="margin-bottom: 1.5rem;">
        <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap; font-size: 0.875rem;">
            <a href="{{ route('home') }}" style="color: var(--primary); text-decoration: none;">الرئيسية</a>
            <span style="color: var(--gray-400);">/</span>
            <a href="{{ route('shop.by-categories') }}" style="color: var(--primary); text-decoration: none;">التصنيفات</a>
            <span style="color: var(--gray-400);">/</span>
            <span style="color: var(--dark); font-weight: 600;">{{ $category->name_ar }}</span>
        </div>
    </nav>

    <!-- Page Title -->
    <div style="background: white; padding: 2rem; border-radius: 12px; margin-bottom: 2rem; border: 1px solid var(--gray-200);">
        <h1 style="font-size: 2rem; font-weight: 800; color: var(--dark); margin-bottom: 0.5rem;">
            {{ $category->name_ar }}
        </h1>
        @if($category->description_ar)
        <p style="color: var(--gray-600); margin-bottom: 1rem;">{{ $category->description_ar }}</p>
        @endif
        <div style="color: var(--gray-500); font-size: 0.875rem;">
            <span>{{ $products->total() }} منتج متاح</span>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 260px 1fr; gap: 2rem;">
        
        <!-- Filters Sidebar -->
        <aside style="background: white; padding: 1.5rem; border-radius: 12px; border: 1px solid var(--gray-200); height: fit-content; position: sticky; top: 7rem;">
            
            <h3 style="font-size: 1rem; font-weight: 700; margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 2px solid var(--gray-200);">
                الفلاتر
            </h3>

            <!-- Price -->
            <div style="margin-bottom: 1.5rem;">
                <h4 style="font-size: 0.875rem; font-weight: 600; margin-bottom: 0.75rem;">السعر</h4>
                <input type="range" id="priceRange" min="{{ $minPrice ?? 0 }}" max="{{ $maxPrice ?? 1000 }}" 
                       value="{{ request('max_price', $maxPrice ?? 1000) }}" 
                       style="width: 100%; accent-color: var(--primary);">
                <div style="display: flex; justify-content: space-between; font-size: 0.75rem; color: var(--gray-500); margin-top: 0.5rem;">
                        <span>{{ $minPrice ?? 0 }} ر.س</span>
                        <span id="priceValue">{{ request('max_price', $maxPrice ?? 1000) }} ر.س</span>
                </div>
            </div>

            <!-- Subcategories -->
            @if($category->children->count() > 0)
            <div style="margin-bottom: 1.5rem;">
                <h4 style="font-size: 0.875rem; font-weight: 600; margin-bottom: 0.75rem;">التصنيفات الفرعية</h4>
                    @foreach($category->children as $subcategory)
                <label style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.5rem; cursor: pointer; font-size: 0.875rem;">
                    <input type="checkbox" value="{{ $subcategory->id }}" class="subcategory-filter" style="accent-color: var(--primary);">
                    <span>{{ $subcategory->name_ar }}</span>
                    </label>
                    @endforeach
            </div>
            @endif

            <!-- In Stock -->
            <div style="margin-bottom: 1.5rem;">
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.875rem;">
                    <input type="checkbox" id="inStockOnly" {{ request('in_stock') ? 'checked' : '' }} style="accent-color: var(--primary);">
                    <span>المتوفر فقط</span>
                    </label>
            </div>

            <!-- Clear -->
            <button id="clearFilters" style="width: 100%; padding: 0.75rem; background: var(--gray-100); border: none; border-radius: 8px; cursor: pointer; font-weight: 600; font-size: 0.875rem;">
                مسح الفلاتر
            </button>
        </aside>

        <!-- Products Area -->
        <div>
            
            <!-- Sort Bar -->
            <div style="background: white; padding: 1rem 1.5rem; border-radius: 12px; border: 1px solid var(--gray-200); margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <label style="font-size: 0.875rem; font-weight: 600; color: var(--gray-700);">ترتيب:</label>
                    <select id="sortSelect" style="padding: 0.5rem 1rem; border: 1px solid var(--gray-300); border-radius: 8px; font-size: 0.875rem; cursor: pointer;">
                        <option value="newest" {{ request('sort') == 'newest' || !request('sort') ? 'selected' : '' }}>الأحدث</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>السعر: الأقل</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>السعر: الأعلى</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>الاسم</option>
                    </select>
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <span style="font-size: 0.875rem; color: var(--gray-600);">عرض:</span>
                    <button id="gridView" class="view-btn active" onclick="switchView('grid')" style="width: 36px; height: 36px; border: 1px solid var(--gray-300); background: white; border-radius: 6px; cursor: pointer;">
                        <i class="fas fa-th"></i>
                    </button>
                    <button id="listView" class="view-btn" onclick="switchView('list')" style="width: 36px; height: 36px; border: 1px solid var(--gray-300); background: white; border-radius: 6px; cursor: pointer;">
                        <i class="fas fa-list"></i>
                    </button>
                </div>
            </div>

            <!-- Products Grid -->
            @if($products->count() > 0)
            <div id="productsContainer" class="product-grid-modern" style="display: grid !important; grid-template-columns: repeat(6, 1fr) !important; gap: 1.25rem !important; width: 100% !important;">
                @foreach($products as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>

            <!-- Pagination -->
            <div style="margin-top: 2rem; display: flex; justify-content: center;">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            
            @else
            <div style="background: white; padding: 4rem 2rem; text-align: center; border-radius: 12px; border: 1px solid var(--gray-200);">
                <i class="fas fa-inbox" style="font-size: 4rem; color: var(--gray-300); margin-bottom: 1rem;"></i>
                <h3 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">لا توجد منتجات</h3>
                <p style="color: var(--gray-600); margin-bottom: 1.5rem;">جرب تصفح تصنيفات أخرى</p>
                <a href="{{ route('shop.by-categories') }}" style="display: inline-block; padding: 0.75rem 2rem; background: var(--primary); color: white; text-decoration: none; border-radius: 8px; font-weight: 600;">
                    تصفح التصنيفات
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
/* Hover Effects */
.product-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.1);
    border-color: var(--primary);
}

.view-btn.active {
    background: var(--primary) !important;
    color: white !important;
    border-color: var(--primary) !important;
}

button:disabled {
    background: var(--gray-400) !important;
    cursor: not-allowed !important;
    opacity: 0.6;
}


/* Responsive */
@media (max-width: 1024px) {
    .container > div {
        grid-template-columns: 1fr !important;
    }

    aside {
        position: static !important;
        margin-bottom: 1.5rem;
    }
}
</style>

<script>
// Sort
document.getElementById('sortSelect')?.addEventListener('change', function() {
    const url = new URL(window.location.href);
    url.searchParams.set('sort', this.value);
    window.location.href = url.toString();
});

// View Toggle
function switchView(view) {
    const container = document.getElementById('productsContainer');
    const gridBtn = document.getElementById('gridView');
    const listBtn = document.getElementById('listView');
    
    if (view === 'list') {
        container.classList.add('list-view');
        listBtn.classList.add('active');
        gridBtn.classList.remove('active');
    } else {
        container.classList.remove('list-view');
        gridBtn.classList.add('active');
        listBtn.classList.remove('active');
    }
    
    localStorage.setItem('view', view);
}

// Restore View
const savedView = localStorage.getItem('view');
if (savedView === 'list') switchView('list');

// Price Range
document.getElementById('priceRange')?.addEventListener('input', function() {
    document.getElementById('priceValue').textContent = this.value + ' ر.س';
});

document.getElementById('priceRange')?.addEventListener('change', function() {
    const url = new URL(window.location.href);
    url.searchParams.set('max_price', this.value);
    window.location.href = url.toString();
});

// In Stock Filter
document.getElementById('inStockOnly')?.addEventListener('change', function() {
    const url = new URL(window.location.href);
    if (this.checked) {
        url.searchParams.set('in_stock', '1');
    } else {
        url.searchParams.delete('in_stock');
    }
    window.location.href = url.toString();
});

// Subcategories
document.querySelectorAll('.subcategory-filter').forEach(cb => {
    cb.addEventListener('change', function() {
        const url = new URL(window.location.href);
        const checked = Array.from(document.querySelectorAll('.subcategory-filter:checked')).map(c => c.value);
        if (checked.length > 0) {
            url.searchParams.set('subcategories', checked.join(','));
        } else {
            url.searchParams.delete('subcategories');
        }
        window.location.href = url.toString();
    });
});

// Clear Filters
document.getElementById('clearFilters')?.addEventListener('click', function() {
    window.location.href = window.location.pathname;
});
</script>
@endsection
