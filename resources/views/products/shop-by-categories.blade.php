@extends('layouts.app')

@section('title', 'تسوق حسب الفئات - لُجين الزراعية')

@section('content')
<div class="container">
    <!-- Hero Section -->
    <div class="shop-categories-hero">
        <div class="hero-content">
            <h1 class="hero-title">
                <i class="fas fa-th-large"></i>
                تسوق حسب الفئات
            </h1>
            <p class="hero-subtitle">
                اكتشف منتجاتنا المتنوعة مرتبة حسب الفئات لتسهيل عملية التسوق
            </p>
        </div>
    </div>

    <!-- Categories Grid -->
    <div class="categories-grid">
        @foreach($categories as $category)
            @php
                $productCount = $category->products()->count();
                
                // صور احترافية من Unsplash - مختلفة لكل فئة
                $defaultImages = [
                    // العسل والعسليات
                    'عسل' => 'https://images.unsplash.com/photo-1587049352846-4a222e784794?w=500&h=500&fit=crop&q=80',
                    'سدر' => 'https://images.unsplash.com/photo-1558642452-9d2a7deb7f62?w=500&h=500&fit=crop&q=80',
                    'طلح' => 'https://images.unsplash.com/photo-1516714435131-44d6b64dc6a2?w=500&h=500&fit=crop&q=80',
                    'سمر' => 'https://images.unsplash.com/photo-1471943311424-646960669fbd?w=500&h=500&fit=crop&q=80',
                    'شوكة' => 'https://images.unsplash.com/photo-1485963631004-f2f00b1d6606?w=500&h=500&fit=crop&q=80',
                    'مانوكا' => 'https://images.unsplash.com/photo-1615485500704-8e990f9900f7?w=500&h=500&fit=crop&q=80',
                    
                    // البهارات والتوابل
                    'بهارات' => 'https://images.unsplash.com/photo-1596040033229-a0b7e446fd27?w=500&h=500&fit=crop&q=80',
                    'كبسة' => 'https://images.unsplash.com/photo-1599909533947-e6c8e8e4de93?w=500&h=500&fit=crop&q=80',
                    'مندي' => 'https://images.unsplash.com/photo-1506368249639-73a05d6f6488?w=500&h=500&fit=crop&q=80',
                    'كمون' => 'https://images.unsplash.com/photo-1599909533932-7f9dc0b3e7a5?w=500&h=500&fit=crop&q=80',
                    'كركم' => 'https://images.unsplash.com/photo-1615485500704-8e990f9900f7?w=500&h=500&fit=crop&q=80',
                    'فلفل' => 'https://images.unsplash.com/photo-1583454110551-21f2fa2afe61?w=500&h=500&fit=crop&q=80',
                    'قرفة' => 'https://images.unsplash.com/photo-1599909533932-7f9dc0b3e7a5?w=500&h=500&fit=crop&q=80',
                    'زنجبيل' => 'https://images.unsplash.com/photo-1599599810769-bcde5a160d32?w=500&h=500&fit=crop&q=80',
                    'توابل' => 'https://images.unsplash.com/photo-1596040033229-a0b7e446fd27?w=500&h=500&fit=crop&q=80',
                    
                    // العطارة والأعشاب
                    'عطارة' => 'https://images.unsplash.com/photo-1564594985645-4427c90b8c1c?w=500&h=500&fit=crop&q=80',
                    'أعشاب' => 'https://images.unsplash.com/photo-1592324163323-de570aeb34ca?w=500&h=500&fit=crop&q=80',
                    'بابونج' => 'https://images.unsplash.com/photo-1564594985645-4427c90b8c1c?w=500&h=500&fit=crop&q=80',
                    'يانسون' => 'https://images.unsplash.com/photo-1584362917165-526a968579e8?w=500&h=500&fit=crop&q=80',
                    'زعتر' => 'https://images.unsplash.com/photo-1592324163323-de570aeb34ca?w=500&h=500&fit=crop&q=80',
                    'مرمرية' => 'https://images.unsplash.com/photo-1609156842154-3d2e7d88b1de?w=500&h=500&fit=crop&q=80',
                    'حبة سوداء' => 'https://images.unsplash.com/photo-1595855759920-86582396756e?w=500&h=500&fit=crop&q=80',
                    'حلبة' => 'https://images.unsplash.com/photo-1599909533932-7f9dc0b3e7a5?w=500&h=500&fit=crop&q=80',
                    'شمر' => 'https://images.unsplash.com/photo-1609156842154-3d2e7d88b1de?w=500&h=500&fit=crop&q=80',
                    
                    // الزيوت الطبيعية
                    'زيت' => 'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=500&h=500&fit=crop&q=80',
                    'زيتون' => 'https://images.unsplash.com/photo-1474979266404-7eaacbcd87c5?w=500&h=500&fit=crop&q=80',
                    'جوز الهند' => 'https://images.unsplash.com/photo-1608571423902-eed4a5ad8108?w=500&h=500&fit=crop&q=80',
                    'سمن' => 'https://images.unsplash.com/photo-1628088062854-d1870b4553da?w=500&h=500&fit=crop&q=80',
                    
                    // التمور والفواكه المجففة
                    'تمر' => 'https://images.unsplash.com/photo-1577003833154-a2e07e90a8b3?w=500&h=500&fit=crop&q=80',
                    'تمور' => 'https://images.unsplash.com/photo-1609406029959-eaf6e67c6818?w=500&h=500&fit=crop&q=80',
                    'سكري' => 'https://images.unsplash.com/photo-1609406029959-eaf6e67c6818?w=500&h=500&fit=crop&q=80',
                    'عجوة' => 'https://images.unsplash.com/photo-1577003833154-a2e07e90a8b3?w=500&h=500&fit=crop&q=80',
                    'مشمش' => 'https://images.unsplash.com/photo-1623065422902-30a2d299bbe4?w=500&h=500&fit=crop&q=80',
                    'تين' => 'https://images.unsplash.com/photo-1610222441928-d57ef6b51fb5?w=500&h=500&fit=crop&q=80',
                    'زبيب' => 'https://images.unsplash.com/photo-1596363505729-4190a9506133?w=500&h=500&fit=crop&q=80',
                    'فواكه' => 'https://images.unsplash.com/photo-1610832958506-aa56368176cf?w=500&h=500&fit=crop&q=80',
                    
                    // المكسرات
                    'مكسرات' => 'https://images.unsplash.com/photo-1508747703725-719777637510?w=500&h=500&fit=crop&q=80',
                    'لوز' => 'https://images.unsplash.com/photo-1508747703725-719777637510?w=500&h=500&fit=crop&q=80',
                    'كاجو' => 'https://images.unsplash.com/photo-1585072364506-386b1a82b3a3?w=500&h=500&fit=crop&q=80',
                    'فستق' => 'https://images.unsplash.com/photo-1599599810769-bcde5a160d32?w=500&h=500&fit=crop&q=80',
                    'جوز' => 'https://images.unsplash.com/photo-1622103920150-a00d3c29b7aa?w=500&h=500&fit=crop&q=80',
                    'بندق' => 'https://images.unsplash.com/photo-1618912352794-9e5ab8f1e812?w=500&h=500&fit=crop&q=80',
                ];
                
                // منطق محسّن لعرض صورة التصنيف
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

            <!-- Main Category -->
            <div class="category-section">
                <div class="category-header">
                    <div class="category-icon-wrapper" style="overflow: hidden; border-radius: 20px;">
                        <img src="{{ $categoryImage }}" alt="{{ $category->name_ar }}" 
                             style="width: 100%; height: 100%; object-fit: cover;" 
                             onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=400&h=400&fit=crop'">
                    </div>
                    <div class="category-info">
                        <h2 class="category-title">{{ $category->name_ar }}</h2>
                        <p class="category-description">{{ $category->description_ar ?? 'اكتشف مجموعة متنوعة من المنتجات في هذه الفئة' }}</p>
                        <div class="category-stats">
                            <span class="product-count">
                                <i class="fas fa-box"></i>
                                {{ $productCount }} منتج
                            </span>
                        </div>
                    </div>
                    <a href="{{ route('products.category', $category->id) }}" class="category-link">
                        <i class="fas fa-arrow-left"></i>
                        تصفح الفئة
                    </a>
                </div>

                @if($category->children->count() > 0)
                    <!-- Subcategories -->
                    <div class="subcategories-grid">
                        <div class="subcategory-item main-category">
                            <a href="{{ route('products.category', $category->id) }}" class="subcategory-link">
                                <div class="subcategory-icon" style="overflow: hidden; border-radius: 12px;">
                                    <img src="{{ $categoryImage }}" alt="{{ $category->name_ar }}" 
                                         style="width: 100%; height: 100%; object-fit: cover;" 
                                         onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=400&h=400&fit=crop'">
                                </div>
                                <div class="subcategory-info">
                                    <h3>جميع {{ $category->name_ar }}</h3>
                                    <p>{{ $productCount }} منتج</p>
                                </div>
                                <i class="fas fa-arrow-left subcategory-arrow"></i>
                            </a>
                        </div>

                        @foreach($category->children as $subcategory)
                            @php
                                $subProductCount = $subcategory->products()->count();
                                
                                // منطق محسّن لصورة الفئة الفرعية
                                $subCategoryImage = null;
                                
                                // 1. الصورة المرفوعة للفئة الفرعية
                                if ($subcategory->image && !empty(trim($subcategory->image))) {
                                    $subCategoryImage = image_url($subcategory->image);
                                }
                                
                                // 2. الصور الافتراضية بناءً على الاسم
                                if (!$subCategoryImage) {
                                    foreach ($defaultImages as $keyword => $image) {
                                        if (str_contains($subcategory->name_ar, $keyword)) {
                                            $subCategoryImage = $image;
                                            break;
                                        }
                                    }
                                }
                                
                                // 3. صورة الفئة الرئيسية كملاذ
                                if (!$subCategoryImage) {
                                    $subCategoryImage = $categoryImage;
                                }
                            @endphp
                            <div class="subcategory-item">
                                <a href="{{ route('products.category', $subcategory->id) }}" class="subcategory-link">
                                    <div class="subcategory-icon" style="overflow: hidden; border-radius: 12px;">
                                        <img src="{{ $subCategoryImage }}" alt="{{ $subcategory->name_ar }}" 
                                             style="width: 100%; height: 100%; object-fit: cover;" 
                                             onerror="this.onerror=null;this.src='https://images.unsplash.com/photo-1464226184884-fa280b87c399?w=400&h=400&fit=crop'">
                                    </div>
                                    <div class="subcategory-info">
                                        <h3>{{ $subcategory->name_ar }}</h3>
                                        <p>{{ $subProductCount }} منتج</p>
                                    </div>
                                    <i class="fas fa-arrow-left subcategory-arrow"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Call to Action -->
    <div class="categories-cta">
        <div class="cta-content">
            <h2>لا تجد ما تبحث عنه؟</h2>
            <p>تصفح جميع منتجاتنا أو تواصل معنا للحصول على المساعدة</p>
            <div class="cta-buttons">
                <a href="{{ route('products.index') }}" class="btn btn-primary">
                    <i class="fas fa-box"></i>
                    جميع المنتجات
                </a>
                <a href="{{ route('pages.contact') }}" class="btn btn-secondary">
                    <i class="fas fa-phone-alt"></i>
                    تواصل معنا
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
.shop-categories-hero {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    color: white;
    padding: 4rem 0;
    border-radius: 25px;
    margin-bottom: 3rem;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.shop-categories-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
    background-size: 50px 50px;
    animation: moveGrid 20s linear infinite;
}

@keyframes moveGrid {
    0% { transform: translate(0, 0); }
    100% { transform: translate(50px, 50px); }
}

.hero-title {
    font-size: 3rem;
    font-weight: 900;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1rem;
    text-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
}

.hero-title i {
    color: rgba(255, 255, 255, 0.9);
}

.hero-subtitle {
    font-size: 1.25rem;
    opacity: 0.9;
    max-width: 600px;
    margin: 0 auto;
    font-weight: 500;
}

.categories-grid {
    display: grid;
    gap: 3rem;
    margin-bottom: 4rem;
}

.category-section {
    background: white;
    border-radius: 20px;
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.08);
    border: 1px solid rgba(16, 185, 129, 0.1);
    overflow: hidden;
    transition: all 0.4s ease;
}

.category-section:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 45px rgba(16, 185, 129, 0.15);
    border-color: rgba(16, 185, 129, 0.3);
}

.category-header {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.05), rgba(16, 185, 129, 0.02));
    padding: 2rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
    border-bottom: 1px solid rgba(16, 185, 129, 0.1);
}

.category-icon-wrapper {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    border-radius: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 2rem;
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
    flex-shrink: 0;
}

.category-info {
    flex: 1;
}

.category-title {
    font-size: 1.75rem;
    font-weight: 800;
    color: var(--dark);
    margin-bottom: 0.5rem;
}

.category-description {
    color: var(--gray-600);
    margin-bottom: 1rem;
    line-height: 1.6;
}

.category-stats {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.product-count {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--primary);
    font-weight: 600;
    font-size: 0.875rem;
}

.category-link {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 12px;
    text-decoration: none;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.category-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
}

.subcategories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    padding: 2rem;
}

.subcategory-item {
    background: rgba(248, 250, 252, 0.8);
    border-radius: 15px;
    transition: all 0.3s ease;
    border: 1px solid rgba(16, 185, 129, 0.1);
}

.subcategory-item:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.15);
    background: white;
}

.subcategory-item.main-category {
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.1), rgba(16, 185, 129, 0.05));
    border: 2px solid rgba(16, 185, 129, 0.2);
}

.subcategory-link {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1.5rem;
    text-decoration: none;
    color: inherit;
    height: 100%;
}

.subcategory-icon {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(16, 185, 129, 0.1));
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary);
    font-size: 1.5rem;
    flex-shrink: 0;
}

.subcategory-info {
    flex: 1;
}

.subcategory-info h3 {
    font-size: 1.25rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.25rem;
}

.subcategory-info p {
    color: var(--gray-600);
    font-size: 0.875rem;
    margin: 0;
}

.subcategory-arrow {
    color: var(--primary);
    font-size: 1.25rem;
    transition: transform 0.3s ease;
}

.subcategory-link:hover .subcategory-arrow {
    transform: translateX(-5px);
}

.categories-cta {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
    border-radius: 20px;
    padding: 3rem;
    text-align: center;
    border: 1px solid rgba(16, 185, 129, 0.1);
}

.cta-content h2 {
    font-size: 2rem;
    font-weight: 800;
    color: var(--dark);
    margin-bottom: 1rem;
}

.cta-content p {
    color: var(--gray-600);
    font-size: 1.125rem;
    margin-bottom: 2rem;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
}

.cta-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
}

.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 2rem;
    border-radius: 12px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    font-size: 1rem;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.4);
}

.btn-secondary {
    background: white;
    color: var(--primary);
    border: 2px solid var(--primary);
}

.btn-secondary:hover {
    background: var(--primary);
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(16, 185, 129, 0.2);
}

/* Responsive Design */
@media (max-width: 768px) {
    .shop-categories-hero {
        padding: 3rem 0;
        border-radius: 20px;
    }

    .hero-title {
        font-size: 2.25rem;
        flex-direction: column;
        gap: 0.5rem;
    }

    .hero-subtitle {
        font-size: 1.125rem;
    }

    .category-header {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
        padding: 1.5rem;
    }

    .category-icon-wrapper {
        width: 70px;
        height: 70px;
        font-size: 1.75rem;
    }

    .category-title {
        font-size: 1.5rem;
    }

    .subcategories-grid {
        grid-template-columns: 1fr;
        padding: 1.5rem;
        gap: 1rem;
    }

    .subcategory-link {
        padding: 1.25rem;
    }

    .subcategory-icon {
        width: 50px;
        height: 50px;
        font-size: 1.25rem;
    }

    .categories-cta {
        padding: 2rem 1.5rem;
    }

    .cta-content h2 {
        font-size: 1.75rem;
    }

    .cta-buttons {
        flex-direction: column;
        align-items: center;
    }

    .btn {
        width: 100%;
        max-width: 250px;
        justify-content: center;
    }
}

@media (max-width: 480px) {
    .hero-title {
        font-size: 2rem;
    }

    .hero-subtitle {
        font-size: 1rem;
    }

    .category-header {
        padding: 1rem;
    }

    .category-icon-wrapper {
        width: 60px;
        height: 60px;
        font-size: 1.5rem;
    }

    .category-title {
        font-size: 1.25rem;
    }

    .subcategories-grid {
        padding: 1rem;
    }

    .subcategory-link {
        padding: 1rem;
    }
}
</style>
