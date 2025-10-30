@extends('layouts.app')

@section('title', 'لُجين الزراعية')

@push('styles')
    @include('layouts.product-grid-styles')
    <style>
    /* ضمان تطبيق التنسيقات بشكل صحيح في الصفحة الرئيسية */
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

    /* تحسين عرض المنتجات في الصفحة الرئيسية */
    .container .product-grid-modern {
        margin: 0 !important;
        padding: 0 !important;
    }
    </style>
@endpush

@php
// دالة للحصول على تصميم احترافي للفئات
if (!function_exists('getCategoryDesign')) {
    function getCategoryDesign($categoryName, $index) {
        $categories = [
            'عسل' => [
                'icon' => 'fas fa-honey-pot',
                'gradient' => 'linear-gradient(135deg, #f59e0b, #d97706)',
                'color' => '#f59e0b'
            ],
            'بهارات' => [
                'icon' => 'fas fa-pepper-hot',
                'gradient' => 'linear-gradient(135deg, #ef4444, #dc2626)',
                'color' => '#ef4444'
            ],
            'عطارة' => [
                'icon' => 'fas fa-leaf',
                'gradient' => 'linear-gradient(135deg, #10b981, #059669)',
                'color' => '#10b981'
            ],
            'زيوت' => [
                'icon' => 'fas fa-oil-can',
                'gradient' => 'linear-gradient(135deg, #8b5cf6, #7c3aed)',
                'color' => '#8b5cf6'
            ],
            'تمور' => [
                'icon' => 'fas fa-apple-alt',
                'gradient' => 'linear-gradient(135deg, #92400e, #78350f)',
                'color' => '#92400e'
            ],
            'مكسرات' => [
                'icon' => 'fas fa-seedling',
                'gradient' => 'linear-gradient(135deg, #06b6d4, #0891b2)',
                'color' => '#06b6d4'
            ],
            'أعشاب' => [
                'icon' => 'fas fa-spa',
                'gradient' => 'linear-gradient(135deg, #10b981, #059669)',
                'color' => '#10b981'
            ]
        ];

        // البحث عن الفئة بالضبط أو البحث الجزئي
        foreach ($categories as $key => $design) {
            if (str_contains($categoryName, $key)) {
                return $design;
            }
        }

        // إذا لم نجد تطابق، نستخدم تصميم افتراضي بناءً على الفهرس
        $defaultDesigns = [
            ['icon' => 'fas fa-box', 'gradient' => 'linear-gradient(135deg, #6b7280, #4b5563)', 'color' => '#6b7280'],
            ['icon' => 'fas fa-cube', 'gradient' => 'linear-gradient(135deg, #8b5cf6, #7c3aed)', 'color' => '#8b5cf6'],
            ['icon' => 'fas fa-archive', 'gradient' => 'linear-gradient(135deg, #f59e0b, #d97706)', 'color' => '#f59e0b'],
            ['icon' => 'fas fa-database', 'gradient' => 'linear-gradient(135deg, #ef4444, #dc2626)', 'color' => '#ef4444']
        ];

        return $defaultDesigns[$index % count($defaultDesigns)];
    }
}
@endphp

@section('content')

<style>
/* تحسينات شاملة للتصميم */
.category-card:hover .explore-button {
    opacity: 1 !important;
}

/* تحسين عرض الفئات */
@media (max-width: 768px) {
    .category-card {
        min-width: auto !important;
    }
}

/* Mobile-First Hero Section */
@media (max-width: 768px) {
    .container {
        padding: 0 0.75rem !important;
    }
    
    .hero {
        min-height: 280px !important;
        padding: 1.5rem 1rem !important;
        margin-bottom: 1rem !important;
        border-radius: 16px !important;
    }
    
    .hero h1 {
        font-size: 1.375rem !important;
        margin-bottom: 0.5rem !important;
        line-height: 1.3 !important;
    }
    
    .hero p {
        font-size: 0.8125rem !important;
        margin-bottom: 1rem !important;
        line-height: 1.5 !important;
    }
    
    .hero .btn {
        font-size: 0.8125rem !important;
        padding: 0.75rem 1.25rem !important;
        min-height: 44px;
        gap: 0.5rem;
    }
    
    /* Mobile Features Grid */
    .features-grid {
        grid-template-columns: 1fr !important;
        gap: 1rem !important;
        padding: 0 !important;
    }
    
    .feature-card {
        padding: 1.25rem !important;
        font-size: 0.875rem !important;
    }
    
    /* Mobile Categories Scroll */
    .categories-section {
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch;
        padding: 0 0.75rem !important;
    }
    
    .categories-grid {
        display: flex !important;
        gap: 0.75rem !important;
        padding-bottom: 1rem !important;
    }
    
    .category-card {
        min-width: 140px !important;
        flex-shrink: 0 !important;
    }
    
    /* Mobile Products Grid */
    .products-grid {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 0.75rem !important;
    }
    
    .product-card {
        border-radius: 12px !important;
    }
    
    .product-card img {
        height: 140px !important;
    }
    
    .product-name {
        font-size: 0.8125rem !important;
        line-height: 1.3 !important;
        height: 34px !important;
        -webkit-line-clamp: 2 !important;
    }
    
    .product-price {
        font-size: 0.9375rem !important;
    }
    
    .product-add-btn {
        padding: 0.5rem !important;
        font-size: 0.8125rem !important;
    }
    
    /* Section Headers */
    .section-header h2 {
        font-size: 1.125rem !important;
    }
    
    .section-header a {
        font-size: 0.8125rem !important;
    }
    
    /* Container Padding */
    .container {
        padding-left: 0.75rem !important;
        padding-right: 0.75rem !important;
    }
}
</style>

<div class="container">
    <!-- Hero Section -->
    <section class="hero">
        <div class="container hero-content">
            <h1>🌱 لُجين الزراعية</h1>
            <p>متجرك الموثوق لأفضل المنتجات الزراعية - بذور عالية الجودة، أسمدة فعّالة، وأدوات احترافية</p>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="{{ route('shop.by-categories') }}" class="btn">
                    <i class="fas fa-th-large"></i>
                    تسوق حسب الفئات
                </a>
                <a href="{{ route('products.index') }}" class="btn" style="background: rgba(255, 255, 255, 0.2); color: white;">
                    <i class="fas fa-shopping-bag"></i>
                    جميع المنتجات
                </a>
                <a href="#" class="btn" style="background: rgba(255, 255, 255, 0.15); color: white; border: 2px solid rgba(255, 255, 255, 0.3);">
                    <i class="fas fa-phone"></i>
                    اتصل بنا
                </a>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section style="margin-bottom: 4rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
            <div style="background: white; padding: 2rem; border-radius: 16px; text-align: center; border: 1px solid var(--gray-200); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 24px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                <div style="width: 64px; height: 64px; margin: 0 auto 1rem; background: linear-gradient(135deg, var(--primary-light), rgba(16,185,129,0.2)); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-shipping-fast" style="font-size: 2rem; color: var(--primary);"></i>
                </div>
                <h3 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 0.5rem;">شحن سريع</h3>
                <p style="color: var(--gray-600); font-size: 0.9375rem;">توصيل سريع لجميع مناطق المملكة</p>
            </div>

            <div style="background: white; padding: 2rem; border-radius: 16px; text-align: center; border: 1px solid var(--gray-200); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 24px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                <div style="width: 64px; height: 64px; margin: 0 auto 1rem; background: linear-gradient(135deg, #dbeafe, rgba(59,130,246,0.2)); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-shield-alt" style="font-size: 2rem; color: #3b82f6;"></i>
                </div>
                <h3 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 0.5rem;">ضمان الجودة</h3>
                <p style="color: var(--gray-600); font-size: 0.9375rem;">منتجات أصلية ومضمونة 100%</p>
            </div>

            <div style="background: white; padding: 2rem; border-radius: 16px; text-align: center; border: 1px solid var(--gray-200); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 24px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                <div style="width: 64px; height: 64px; margin: 0 auto 1rem; background: linear-gradient(135deg, #fef3c7, rgba(245,158,11,0.2)); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-headset" style="font-size: 2rem; color: var(--accent);"></i>
                </div>
                <h3 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 0.5rem;">دعم فني</h3>
                <p style="color: var(--gray-600); font-size: 0.9375rem;">فريق دعم متاح على مدار الساعة</p>
            </div>

            <div style="background: white; padding: 2rem; border-radius: 16px; text-align: center; border: 1px solid var(--gray-200); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 24px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                <div style="width: 64px; height: 64px; margin: 0 auto 1rem; background: linear-gradient(135deg, #fce7f3, rgba(236,72,153,0.2)); border-radius: 16px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-tags" style="font-size: 2rem; color: #ec4899;"></i>
                </div>
                <h3 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 0.5rem;">أسعار تنافسية</h3>
                <p style="color: var(--gray-600); font-size: 0.9375rem;">أفضل الأسعار في السوق</p>
            </div>
        </div>
    </section>

    <!-- Categories with Sidebar -->
    <section style="margin-bottom: 4rem;">
        <!-- Sidebar -->
        <div id="categories-layout" style="display: grid; grid-template-columns: 300px 1fr; gap: 2rem; margin-bottom: 3rem;">
            <!-- Categories Sidebar -->
            <aside style="background: white; border-radius: 16px; padding: 1.5rem; box-shadow: 0 2px 12px rgba(0,0,0,0.06); height: fit-content; position: sticky; top: 100px;">
                <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--dark); margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-list" style="color: var(--primary);"></i>
                    الفئات
                </h3>
                <div style="display: flex; flex-direction: column; gap: 0.5rem;">
                    @foreach($categories as $cat)
                        @php
                            $catCount = $cat->products()->where('status', 'active')->count();
                            $catDesign = getCategoryDesign($cat->name_ar, $loop->index);
                        @endphp
                        <a href="{{ route('products.category', $cat->id) }}" style="display: flex; align-items: center; justify-content: space-between; padding: 0.875rem 1rem; background: var(--bg-gray); border-radius: 12px; text-decoration: none; color: var(--text-dark); transition: all 0.3s ease; border: 2px solid transparent;" onmouseover="this.style.background='linear-gradient(135deg, {{ $catDesign['color'] }}10, {{ $catDesign['color'] }}05)'; this.style.borderColor='{{ $catDesign['color'] }}30'; this.style.transform='translateX(-4px)'" onmouseout="this.style.background='var(--bg-gray)'; this.style.borderColor='transparent'; this.style.transform='translateX(0)'">
                            <span style="font-weight: 600; font-size: 0.9375rem;">{{ $cat->name_ar }}</span>
                            @if($catCount > 0)
                            <span style="background: {{ $catDesign['color'] }}; color: white; padding: 0.25rem 0.5rem; border-radius: 12px; font-size: 0.75rem; font-weight: 700; min-width: 24px; text-align: center;">{{ $catCount }}</span>
                            @endif
                        </a>
                    @endforeach
                    
                    <a href="{{ route('shop.by-categories') }}" style="margin-top: 0.5rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem; padding: 0.875rem; background: var(--primary); color: white; border-radius: 12px; text-decoration: none; font-weight: 600; transition: all 0.3s ease;" onmouseover="this.style.background='var(--primary-dark)'; this.style.transform='translateY(-2px)'" onmouseout="this.style.background='var(--primary)'; this.style.transform='translateY(0)'">
                        <span>عرض جميع الفئات</span>
                        <i class="fas fa-arrow-left" style="transform: scaleX(-1);"></i>
                    </a>
                </div>
            </aside>

            <!-- Categories Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.25rem;">
            @forelse($categories as $category)
            @php
                // تحديد لون وأيقونة وتدرج احترافي للفئة
                $categoryData = getCategoryDesign($category->name_ar, $loop->index);
                $productCount = $category->products()->where('status', 'active')->count();
            @endphp

            <a href="{{ route('products.category', $category->id) }}" class="category-card" style="position: relative; overflow: hidden;">
                <div class="category-card-inner" style="background: white; border-radius: 16px; padding: 1.5rem; text-decoration: none; text-align: center; border: 2px solid {{ $categoryData['color'] }}20; transition: all 0.3s ease; position: relative; height: 100%;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 8px 24px {{ $categoryData['color'] }}20'; this.style.borderColor='{{ $categoryData['color'] }}40'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(0,0,0,0.04)'; this.style.borderColor='{{ $categoryData['color'] }}20'">

                    <!-- شعار الفئة -->
                    <div class="category-logo" style="width: 80px; height: 80px; margin: 0 auto 1rem; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 16px {{ $categoryData['color'] }}20; transition: all 0.3s ease; position: relative;">
                        @php
                            // صور احترافية متنوعة ومميزة لكل فئة
                            $defaultImages = [
                                // اللحوم والمواشي
                                'لحوم' => 'https://images.unsplash.com/photo-1607623488235-e2e0c5c2e8e3?w=500&h=500&fit=crop&q=80',
                                'ماعز' => 'https://images.unsplash.com/photo-1589992693983-18628e8a7b48?w=500&h=500&fit=crop&q=80',
                                'عجل' => 'https://images.unsplash.com/photo-1560493676-04071c5f467b?w=500&h=500&fit=crop&q=80',
                                'خرفان' => 'https://images.unsplash.com/photo-1581093588401-fbb62a02f120?w=500&h=500&fit=crop&q=80',
                                'حاشي' => 'https://images.unsplash.com/photo-1591825349588-3e0e4de8d9aa?w=500&h=500&fit=crop&q=80',
                                'دجاج' => 'https://images.unsplash.com/photo-1548550023-2bdb3c5beed7?w=500&h=500&fit=crop&q=80',
                                
                                // الزراعة
                                'بذور' => 'https://images.unsplash.com/photo-1560493676-04071c5f467b?w=500&h=500&fit=crop&q=80',
                                'مزارع' => 'https://images.unsplash.com/photo-1625246333195-78d9c38ad449?w=500&h=500&fit=crop&q=80',
                                'زراعي' => 'https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=500&h=500&fit=crop&q=80',
                                
                                // الخضروات
                                'خضروات' => 'https://images.unsplash.com/photo-1597362925123-77861d3fbac7?w=500&h=500&fit=crop&q=80',
                                'طماطم' => 'https://images.unsplash.com/photo-1546094096-0df4bcaaa337?w=500&h=500&fit=crop&q=80',
                                'خس' => 'https://images.unsplash.com/photo-1622206151226-18ca2c9ab4a1?w=500&h=500&fit=crop&q=80',
                                'جزر' => 'https://images.unsplash.com/photo-1598170845058-32b9d6a5da37?w=500&h=500&fit=crop&q=80',
                                'بصل' => 'https://images.unsplash.com/photo-1618512496248-a07fe83aa8cb?w=500&h=500&fit=crop&q=80',
                                
                                // الفواكه
                                'فواكه' => 'https://images.unsplash.com/photo-1610832958506-aa56368176cf?w=500&h=500&fit=crop&q=80',
                                'تفاح' => 'https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?w=500&h=500&fit=crop&q=80',
                                'برتقال' => 'https://images.unsplash.com/photo-1547514701-42782101795e?w=500&h=500&fit=crop&q=80',
                                'عنب' => 'https://images.unsplash.com/photo-1596363505729-4190a9506133?w=500&h=500&fit=crop&q=80',
                                'تمر' => 'https://images.unsplash.com/photo-1577003833154-a2e07e90a8b3?w=500&h=500&fit=crop&q=80',
                                
                                // التوابل والبهارات
                                'بهارات' => 'https://images.unsplash.com/photo-1596040033229-a0b7e446fd27?w=500&h=500&fit=crop&q=80',
                                'كبسة' => 'https://images.unsplash.com/photo-1599909533947-e6c8e8e4de93?w=500&h=500&fit=crop&q=80',
                                'توابل' => 'https://images.unsplash.com/photo-1506368249639-73a05d6f6488?w=500&h=500&fit=crop&q=80',
                                
                                // منتجات الألبان
                                'سمن' => 'https://images.unsplash.com/photo-1628088062854-d1870b4553da?w=500&h=500&fit=crop&q=80',
                                'لبن' => 'https://images.unsplash.com/photo-1550583724-b2692b85b150?w=500&h=500&fit=crop&q=80',
                                'جبن' => 'https://images.unsplash.com/photo-1452195100486-9cc805987862?w=500&h=500&fit=crop&q=80',
                                'حليب' => 'https://images.unsplash.com/photo-1563636619-e9143da7973b?w=500&h=500&fit=crop&q=80',
                                
                                // أخرى
                                'عسل' => 'https://images.unsplash.com/photo-1587049352846-4a222e784794?w=500&h=500&fit=crop&q=80',
                                'زيت' => 'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=500&h=500&fit=crop&q=80',
                                'قمح' => 'https://images.unsplash.com/photo-1574943320219-553eb213f72d?w=500&h=500&fit=crop&q=80',
                                'أرز' => 'https://images.unsplash.com/photo-1586201375761-83865001e31c?w=500&h=500&fit=crop&q=80',
                            ];
                            
                            // منطق محسّن لعرض صورة التصنيف (أولوية للصورة المرفوعة)
                            $categoryImage = null;
                            
                            // 1. أولوية قصوى: الصورة المرفوعة من المسؤول
                            if ($category->image && !empty(trim($category->image))) {
                                $categoryImage = image_url($category->image);
                            }
                            
                            // 2. إذا لم توجد صورة مرفوعة، استخدم الصور الافتراضية الذكية
                            if (!$categoryImage) {
                                foreach ($defaultImages as $keyword => $image) {
                                    if (str_contains($category->name_ar, $keyword)) {
                                        $categoryImage = $image;
                                        break;
                                    }
                                }
                            }
                            
                            // 3. صورة افتراضية عامة كملاذ أخير
                            if (!$categoryImage) {
                                $categoryImage = 'https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=400&h=400&fit=crop';
                            }
                        @endphp
                        
                        <img 
                            src="{{ $categoryImage }}" 
                            alt="{{ $category->name_ar }}" 
                            style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);" 
                            onmouseover="this.style.transform='scale(1.1)'" 
                            onmouseout="this.style.transform='scale(1)'"
                            onerror="this.src='https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=400&h=400&fit=crop'"
                        >

                        <!-- شارة عدد المنتجات -->
                        <div class="product-count-badge" style="position: absolute; top: -8px; right: -8px; background: {{ $categoryData['color'] }}; color: white; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700; box-shadow: 0 4px 12px {{ $categoryData['color'] }}60; border: 3px solid white;">
                            {{ $productCount }}
                        </div>

                        <!-- تأثير الإشعاع الخارجي -->
                        <div style="position: absolute; inset: -8px; background: linear-gradient(135deg, {{ $categoryData['color'] }}30, transparent, {{ $categoryData['color'] }}30); opacity: 0; transition: opacity 0.4s; border-radius: 38px;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0'"></div>
                    </div>

                    <!-- معلومات الفئة -->
                    <div style="position: relative; z-index: 1;">
                        <h3 style="font-size: 1.0625rem; font-weight: 700; color: var(--dark); margin-bottom: 0.5rem; line-height: 1.3;">{{ $category->name_ar }}</h3>
                        <p style="color: var(--gray-600); font-size: 0.875rem; margin-bottom: 0.75rem; font-weight: 500;">
                            @if($productCount > 0)
                                {{ $productCount }} منتج
                            @else
                                <span style="color: var(--gray-400); font-style: italic; font-size: 0.8125rem;">لا توجد منتجات</span>
                            @endif
                        </p>

                        <!-- شريط التقدم -->
                        @if($productCount > 0)
                        <div class="progress-container" style="width: 100%; height: 4px; background: {{ $categoryData['color'] }}15; border-radius: 2px; margin-bottom: 0.75rem; overflow: hidden;">
                            <div class="progress-bar" style="width: {{ min($productCount * 5, 100) }}%; height: 100%; background: {{ $categoryData['gradient'] }}; border-radius: 2px;"></div>
                        </div>
                        @endif

                        <!-- زر الاستكشاف -->
                        <div class="explore-button" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; color: {{ $categoryData['color'] }}; font-weight: 600; font-size: 0.875rem; padding: 0.5rem 1rem; background: linear-gradient(135deg, {{ $categoryData['color'] }}10, {{ $categoryData['color'] }}05); border: 2px solid {{ $categoryData['color'] }}30; border-radius: 16px; transition: all 0.3s ease; opacity: 0;" onmouseover="this.style.opacity='1'; this.style.transform='translateY(-2px)'; this.style.background='linear-gradient(135deg, {{ $categoryData['color'] }}20, {{ $categoryData['color'] }}10)'; this.style.borderColor='{{ $categoryData['color'] }}';" onmouseout="this.style.opacity='0'; this.style.transform='translateY(0)'; this.style.background='linear-gradient(135deg, {{ $categoryData['color'] }}10, {{ $categoryData['color'] }}05)'; this.style.borderColor='{{ $categoryData['color'] }}30'">
                            <span>استكشف</span>
                            <i class="fas fa-arrow-left" style="transform: scaleX(-1); font-size: 0.8125rem;"></i>
                        </div>
                    </div>
                </div>
            </a>
            @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 4rem; background: white; border-radius: 20px; border: 2px solid var(--gray-200);">
                <div style="width: 100px; height: 100px; margin: 0 auto 1.5rem; background: linear-gradient(135deg, var(--gray-100), var(--gray-200)); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-folder-open" style="font-size: 3rem; color: var(--gray-400);"></i>
                </div>
                <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--dark); margin-bottom: 1rem;">لا توجد تصنيفات متاحة حالياً</h3>
                <p style="color: var(--gray-600); font-size: 1.125rem; margin-bottom: 2rem;">سيتم إضافة التصنيفات قريباً</p>
                <a href="{{ route('products.index') }}" class="btn" style="margin-top: 1rem; display: inline-flex;">
                    <i class="fas fa-box"></i>
                    عرض جميع المنتجات
                </a>
            </div>
            @endforelse
            </div>
        </div>

        <!-- قسم إضافي للفئات الشائعة -->
        <div style="margin-top: 3rem; text-align: center;">
            <div style="display: inline-flex; gap: 1rem; flex-wrap: wrap; justify-content: center;">
                <span style="background: linear-gradient(135deg, #f0fdf4, #dcfce7); color: var(--primary); padding: 0.75rem 1.5rem; border-radius: 25px; font-size: 0.9375rem; font-weight: 600; border: 1px solid var(--primary)20;">
                    <i class="fas fa-star"></i>
                    أكثر من 100 منتج زراعي
                </span>
                <span style="background: linear-gradient(135deg, #fef3c7, #fde68a); color: var(--accent); padding: 0.75rem 1.5rem; border-radius: 25px; font-size: 0.9375rem; font-weight: 600; border: 1px solid var(--accent)20;">
                    <i class="fas fa-truck"></i>
                    شحن مجاني للطلبات الكبيرة
                </span>
                <span style="background: linear-gradient(135deg, #fce7f3, #f9a8d4); color: #ec4899; padding: 0.75rem 1.5rem; border-radius: 25px; font-size: 0.9375rem; font-weight: 600; border: 1px solid #ec489920;">
                    <i class="fas fa-shield-alt"></i>
                    ضمان جودة المنتجات
                </span>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section style="margin-bottom: 4rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h2 style="font-size: 1.75rem; font-weight: 800; color: var(--dark); margin-bottom: 0.5rem;">
                    <i class="fas fa-star" style="color: var(--accent); margin-left: 0.5rem;"></i>
                    المنتجات المميزة
                </h2>
                <p style="color: var(--gray-600); font-size: 1rem;">
                    أفضل المنتجات الزراعية المختارة بعناية
                </p>
            </div>
            <a href="{{ route('products.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--primary); font-weight: 600; text-decoration: none;">
                عرض الكل
                <i class="fas fa-arrow-left" style="transform: scaleX(-1);"></i>
            </a>
        </div>

        <div class="product-grid-modern" style="display: grid !important; grid-template-columns: repeat(6, 1fr) !important; gap: 1.25rem !important; width: 100% !important;">
            @forelse($specialOfferProducts ?? [] as $product)
                <x-product-card :product="$product" />
            @empty
            <div style="grid-column: 1/-1; text-align: center; padding: 4rem;">
                <div style="width: 100px; height: 100px; margin: 0 auto 1.5rem; background: linear-gradient(135deg, var(--gray-100), var(--gray-200)); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-star" style="font-size: 3rem; color: var(--gray-400);"></i>
                </div>
                <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--dark); margin-bottom: 1rem;">لا توجد منتجات مميزة حالياً</h3>
                <p style="color: var(--gray-600); font-size: 1.125rem; margin-bottom: 2rem;">سيتم إضافة منتجات مميزة قريباً</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary" style="display: inline-flex;">
                    <i class="fas fa-th-large"></i>
                    <span>تصفح جميع المنتجات</span>
                </a>
            </div>
            @endforelse
        </div>


        <!-- زر عرض جميع المنتجات -->
        <div style="text-align: center; margin-top: 3rem;">
            <a href="{{ route('products.index') }}" class="btn btn-primary" style="padding: 1.25rem 3rem; font-size: 1.125rem; border-radius: 15px;">
                <i class="fas fa-th-large"></i>
                عرض جميع المنتجات
                <span style="margin-right: 0.5rem;">({{ $specialOfferProducts ? $specialOfferProducts->count() : 0 }} منتج بعروض خاصة)</span>
            </a>
        </div>
    </section>

    <!-- منتجات مخفضة تقليدية -->
    @if(isset($discountedProducts) && $discountedProducts->count() > 0)
    <section style="margin-bottom: 4rem;">
        <div style="text-align: center; margin-bottom: 3rem;">
            <h2 class="section-title" style="margin-bottom: 1rem;">
                <i class="fas fa-tag" style="color: #10b981;"></i>
                منتجات مخفضة
            </h2>
            <p style="font-size: 1.125rem; color: var(--gray-600); max-width: 600px; margin: 0 auto;">
                استفد من خصوماتنا المستمرة على أفضل المنتجات الزراعية
            </p>
        </div>

        <div class="product-grid-modern" style="display: grid !important; grid-template-columns: repeat(6, 1fr) !important; gap: 1.25rem !important; width: 100% !important;">
            @foreach($discountedProducts as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
    </section>
    @endif

    </section>

    <!-- CTA Section -->
    <section style="margin-top: 4rem; background: linear-gradient(135deg, #f0fdf4, #dcfce7); padding: 4rem 2rem; border-radius: 30px; text-align: center; position: relative; overflow: hidden;">
        <!-- خلفية متدرجة متحركة -->
        <div style="position: absolute; inset: 0; background: linear-gradient(45deg, rgba(16,185,129,0.05), rgba(34,197,94,0.05), rgba(16,185,129,0.05)); opacity: 0.8;"></div>
        <div style="position: absolute; top: -50%; right: -50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(16,185,129,0.1) 1px, transparent 1px); background-size: 50px 50px; animation: float 20s linear infinite;"></div>

        <div style="position: relative; z-index: 1;">
            <div style="width: 100px; height: 100px; margin: 0 auto 2rem; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 10px 30px rgba(16,185,129,0.3); position: relative;">
                <i class="fas fa-headset" style="font-size: 3rem; color: white;"></i>
                <!-- تأثير النبض -->
                <div style="position: absolute; inset: -10px; border: 2px solid var(--primary); border-radius: 50%; animation: pulse-ring 2s infinite;"></div>
            </div>

            <h2 style="font-size: 2.5rem; font-weight: 900; color: var(--dark); margin-bottom: 1.5rem; line-height: 1.2;">
                هل تحتاج مساعدة في اختيار المنتج المناسب؟
            </h2>
            <p style="font-size: 1.25rem; color: var(--gray-700); margin-bottom: 2.5rem; max-width: 600px; margin-left: auto; margin-right: auto; line-height: 1.6;">
                فريقنا المتخصص من المهندسين الزراعيين جاهز لمساعدتك في اختيار أفضل المنتجات لمزرعتك وحلولك الزراعية المثالية
            </p>

            <div style="display: flex; gap: 1.5rem; justify-content: center; flex-wrap: wrap; margin-bottom: 2rem;">
                <a href="tel:+966500000000" class="btn btn-primary" style="padding: 1.25rem 2.5rem; font-size: 1.125rem; border-radius: 15px; position: relative; overflow: hidden;">
                    <i class="fas fa-phone"></i>
                    اتصل بنا الآن
                    <div style="position: absolute; inset: 0; background: rgba(255,255,255,0.2); transform: scale(0); border-radius: 15px; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1)'" onmouseout="this.style.transform='scale(0)'"></div>
                </a>
                <a href="https://wa.me/966500000000" class="btn" style="background: #25D366; color: white; padding: 1.25rem 2.5rem; font-size: 1.125rem; border-radius: 15px; position: relative; overflow: hidden;">
                    <i class="fab fa-whatsapp"></i>
                    واتساب
                    <div style="position: absolute; inset: 0; background: rgba(255,255,255,0.2); transform: scale(0); border-radius: 15px; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1)'" onmouseout="this.style.transform='scale(0)'"></div>
                </a>
            </div>

            <!-- معلومات إضافية -->
            <div style="display: flex; justify-content: center; gap: 3rem; flex-wrap: wrap; margin-top: 2rem;">
                <div style="display: flex; align-items: center; gap: 0.75rem; background: rgba(255,255,255,0.8); padding: 1rem 1.5rem; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                    <i class="fas fa-clock" style="color: var(--primary); font-size: 1.5rem;"></i>
                    <div style="text-align: left;">
                        <div style="font-weight: 700; color: var(--dark); font-size: 1.125rem;">متاح 24/7</div>
                        <div style="font-size: 0.9375rem; color: var(--gray-600);">دعم فني على مدار الساعة</div>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 0.75rem; background: rgba(255,255,255,0.8); padding: 1rem 1.5rem; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                    <i class="fas fa-users" style="color: var(--primary); font-size: 1.5rem;"></i>
                    <div style="text-align: left;">
                        <div style="font-weight: 700; color: var(--dark); font-size: 1.125rem;">خبراء زراعيون</div>
                        <div style="font-size: 0.9375rem; color: var(--gray-600);">متخصصون في جميع المجالات</div>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 0.75rem; background: rgba(255,255,255,0.8); padding: 1rem 1.5rem; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                    <i class="fas fa-comments" style="color: var(--primary); font-size: 1.5rem;"></i>
                    <div style="text-align: left;">
                        <div style="font-weight: 700; color: var(--dark); font-size: 1.125rem;">استشارات مجانية</div>
                        <div style="font-size: 0.9375rem; color: var(--gray-600);">مساعدة في اختيار المنتجات</div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            @keyframes pulse-ring {
                0% {
                    transform: scale(0.33);
                    opacity: 1;
                }
                80%, 100% {
                    transform: scale(1.4);
                    opacity: 0;
                }
            }

            @keyframes float {
                0% { transform: translate(0, 0) rotate(0deg); }
                33% { transform: translate(30px, -30px) rotate(120deg); }
                66% { transform: translate(-20px, 20px) rotate(240deg); }
                100% { transform: translate(0, 0) rotate(360deg); }
            }
        <style>
            @keyframes categoryFloat {
                0% { transform: translate(0, 0) rotate(0deg); }
                33% { transform: translate(20px, -20px) rotate(120deg); }
                66% { transform: translate(-15px, 15px) rotate(240deg); }
                100% { transform: translate(0, 0) rotate(360deg); }
            }

            @keyframes progressShine {
                0% { left: -100%; }
                50% { left: 100%; }
                100% { left: -100%; }
            }

            /* تحسين تأثيرات الفئات */
            .category-card:hover .category-bg-animation {
                opacity: 0.6;
                animation-duration: 8s;
            }

            .category-card:hover .category-logo {
                transform: scale(1.05) rotate(2deg);
                box-shadow: 0 20px 50px {{ isset($categoryData) ? $categoryData['color'] : '#10b981' }}50;
            }

            .category-card:hover .product-count-badge {
                animation: badgePulse 0.6s ease-in-out;
            }

            @keyframes badgePulse {
                0%, 100% {
                    transform: scale(1);
                }
                50% {
                    transform: scale(1.1);
                }
            }

            .explore-button:hover .explore-ripple {
                transform: scale(1);
                opacity: 1;
            }

            /* تحسين شريط التقدم */
            .progress-bar {
                position: relative;
            }

            /* استجابة أفضل للأجهزة المحمولة */
            @media (max-width: 768px) {
                .category-logo {
                    width: 100px !important;
                    height: 100px !important;
                }

                .category-card-inner {
                    padding: 2rem !important;
                }

                .product-count-badge {
                    width: 28px !important;
                    height: 28px !important;
                    font-size: 0.6875rem !important;
                }
            }
        </style>
    </section>
</div>

<script>

// تشغيل المؤقت عند تحميل الصفحة (إزالة المؤقت الثابت)
document.addEventListener('DOMContentLoaded', function() {
    // يمكن إضافة دوال إضافية هنا إذا لزم الأمر
});

// دالة إضافة المنتج للسلة من الصفحة الرئيسية
function addToCart(productId) {
    // استخدام نفس دالة addToCart من layout
    if (typeof window.addToCart === 'function') {
        window.addToCart(productId);
    } else {
        showNotification('جاري الإضافة للسلة...', 'info');
    }
}
</script>
@endsection
