@props(['product'])

<div class="product-card-modern" data-product-id="{{ $product->id }}">
    <div class="product-image-wrapper">
        @php
            $mainImage = $product->getMainImage();
        @endphp
        @if($mainImage)
            <img src="{{ image_url($mainImage) }}" alt="{{ $product->name_ar }}" class="product-image-main" loading="lazy" onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'product-image-placeholder\'><i class=\'fas fa-seedling\'></i></div>';">
        @else
            <div class="product-image-placeholder">
                <i class="fas fa-seedling"></i>
            </div>
        @endif
        
        <!-- Badges -->
        <div class="product-badges">
            @if($product->hasDiscount())
                <span class="badge badge-discount">
                    <i class="fas fa-tag"></i> {{ $product->getDiscountPercentage() }}%
                </span>
            @endif
            @if($product->is_featured)
                <span class="badge badge-featured">
                    <i class="fas fa-star"></i> مميز
                </span>
            @endif
            @if($product->is_special_offer)
                <span class="badge badge-offer">
                    <i class="fas fa-fire"></i> عرض خاص
                </span>
            @endif
        </div>

        <!-- Quick Actions Overlay -->
        <div class="product-overlay">
            <div class="product-overlay-actions">
                <button onclick="addToCart({{ $product->id }}, 1)" class="btn-overlay" @if($product->stock <= 0) disabled @endif title="أضف للسلة">
                    <i class="fas fa-shopping-cart"></i>
                </button>
                <a href="{{ route('products.show', $product) }}" class="btn-overlay" title="عرض التفاصيل">
                    <i class="fas fa-eye"></i>
                </a>
                @auth
                    <button onclick="toggleWishlist({{ $product->id }})" class="btn-overlay" title="أضف للمفضلة">
                        <i class="fas fa-heart"></i>
                    </button>
                @endauth
            </div>
        </div>
    </div>

    <div class="product-info-modern">
        <div class="product-category-badge">
            <i class="fas fa-tag"></i>
            {{ $product->category->name_ar ?? 'عام' }}
        </div>

        <h3 class="product-name-modern">
            <a href="{{ route('products.show', $product) }}">{{ $product->name_ar }}</a>
        </h3>

        <p class="product-description-modern">
            {{ \Str::limit($product->description_ar, 90) }}
        </p>

        <div class="product-price-modern">
            @if($product->hasDiscount())
                <span class="price-old">{{ number_format($product->price, 2) }} ر.س</span>
            @endif
            <span class="price-current">{{ number_format($product->getCurrentPrice(), 2) }} <small>ر.س</small></span>
        </div>

        <div class="product-meta">
            <span class="product-unit">
                <i class="fas fa-weight"></i> {{ $product->unit }}
            </span>
            @if($product->stock <= 0)
                <span class="stock-badge stock-out">
                    <i class="fas fa-times-circle"></i> غير متوفر
                </span>
            @elseif($product->stock <= $product->low_stock_alert)
                <span class="stock-badge stock-low">
                    <i class="fas fa-exclamation-triangle"></i> كمية محدودة
                </span>
            @else
                <span class="stock-badge stock-in">
                    <i class="fas fa-check-circle"></i> متوفر
                </span>
            @endif
        </div>

        <div class="product-actions-modern">
            <button class="btn-add-cart-modern" onclick="addToCart({{ $product->id }}, 1)" @if($product->stock <= 0) disabled @endif>
                <i class="fas fa-shopping-cart"></i>
                <span>أضف للسلة</span>
            </button>
        </div>
    </div>
</div>

<style>
.product-card-modern {
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    transition: all 0.25s ease;
    border: 1px solid #f3f4f6;
    position: relative;
    height: 100%;
    display: flex;
    flex-direction: column;
    max-width: 100%;
}

.product-card-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border-color: #e5e7eb;
}

.product-image-wrapper {
    position: relative;
    width: 100%;
    padding-top: 100% !important;
    overflow: hidden;
    background: #fafafa;
    aspect-ratio: 1 / 1 !important;
}

/* توحيد ارتفاع البطاقات */
.product-card-modern {
    min-height: 0;
    align-self: stretch;
}

.product-image-main {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    display: block;
    z-index: 1;
}

.product-card-modern:hover .product-image-main {
    transform: scale(1.05);
}

.product-image-placeholder {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
}

.product-image-placeholder i {
    font-size: 4rem;
    color: var(--primary);
    opacity: 0.5;
}

.product-badges {
    position: absolute;
    top: 8px;
    left: 8px;
    right: 8px;
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    z-index: 2;
}

.badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.6875rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: 3px;
    backdrop-filter: blur(10px);
    box-shadow: 0 1px 4px rgba(0,0,0,0.1);
}

.badge-discount {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
}

.badge-featured {
    background: linear-gradient(135deg, #fbbf24, #f59e0b);
    color: white;
}

.badge-offer {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.6);
    opacity: 0;
    transition: opacity 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 3;
}

.product-card-modern:hover .product-overlay {
    opacity: 1;
}

.product-overlay-actions {
    display: flex;
    gap: 12px;
}

.btn-overlay {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: white;
    border: none;
    color: var(--primary);
    font-size: 1.1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-overlay:hover {
    background: var(--primary);
    color: white;
    transform: scale(1.1);
}

.btn-overlay:disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.product-info-modern {
    padding: 0.875rem;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    justify-content: space-between;
}

.product-category-badge {
    font-size: 0.6875rem;
    color: var(--primary);
    font-weight: 600;
    margin-bottom: 0.375rem;
    display: inline-flex;
    align-items: center;
    gap: 3px;
}

.product-name-modern {
    margin: 0;
    font-size: 0.875rem;
    font-weight: 600;
    line-height: 1.4;
    min-height: 2.25rem;
    max-height: 2.25rem;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    color: #1f2937;
}

.product-name-modern a {
    color: var(--dark);
    text-decoration: none;
    transition: color 0.2s;
}

.product-name-modern a:hover {
    color: var(--primary);
}

.product-description-modern {
    font-size: 0.75rem;
    color: #6b7280;
    line-height: 1.4;
    margin-bottom: 0.5rem;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
    min-height: 1.05rem;
    max-height: 1.05rem;
}

.product-price-modern {
    display: flex;
    align-items: baseline;
    gap: 0.375rem;
    margin-bottom: 0.375rem;
}

.price-old {
    font-size: 0.6875rem;
    color: #9ca3af;
    text-decoration: line-through;
}

.price-current {
    font-size: 1rem;
    font-weight: 700;
    color: var(--primary);
}

.price-current small {
    font-size: 0.6875rem;
    font-weight: 500;
}

.product-meta {
    display: flex;
    align-items: center;
    gap: 0.375rem;
    margin-bottom: 0.5rem;
    flex-wrap: wrap;
    font-size: 0.6875rem;
}

.product-unit {
    color: #6b7280;
    display: flex;
    align-items: center;
    gap: 4px;
}

.stock-badge {
    display: inline-flex;
    align-items: center;
    gap: 3px;
    font-weight: 600;
    padding: 3px 8px;
    border-radius: 10px;
    font-size: 0.6875rem;
}

.stock-in {
    background: #dcfce7;
    color: #166534;
}

.stock-low {
    background: #fef3c7;
    color: #92400e;
}

.stock-out {
    background: #fee2e2;
    color: #991b1b;
}

.product-actions-modern {
    margin-top: auto;
}

.btn-add-cart-modern {
    width: 100%;
    padding: 0.625rem 0.875rem;
    background: var(--primary);
    color: white;
    border: none;
    border-radius: 6px;
    font-weight: 600;
    font-size: 0.8125rem;
    cursor: pointer;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.375rem;
}

.btn-add-cart-modern:hover:not(:disabled) {
    background: var(--primary-dark);
    transform: translateY(-1px);
}

.btn-add-cart-modern:disabled {
    background: #d1d5db;
    cursor: not-allowed;
    box-shadow: none;
}

/* Mobile Styles */
@media (max-width: 768px) {
    .product-card-modern {
        border-radius: 10px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    
    .product-image-wrapper {
        aspect-ratio: 1 / 1 !important;
        padding-top: 100% !important;
    }
    
    .product-info-modern {
        padding: 0.75rem;
        gap: 0.375rem;
    }
    
    .product-name-modern {
        font-size: 0.8125rem;
        min-height: 2.5rem;
        max-height: 2.5rem;
        line-height: 1.3;
        margin-bottom: 0.25rem;
    }
    
    .product-description-modern {
        font-size: 0.6875rem;
        margin-bottom: 0.5rem;
        min-height: 1.05rem;
        max-height: 1.05rem;
        display: none; /* إخفاء الوصف على الجوال لتوفير المساحة */
    }
    
    .price-current {
        font-size: 1rem;
        font-weight: 700;
    }
    
    .price-old {
        font-size: 0.75rem;
    }
    
    .product-meta {
        font-size: 0.6875rem;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }
    
    .btn-add-cart-modern {
        padding: 0.75rem;
        font-size: 0.8125rem;
        min-height: 44px;
        touch-action: manipulation;
    }
    
    .badge {
        padding: 4px 8px;
        font-size: 0.625rem;
    }
    
    .product-overlay-actions {
        gap: 8px;
    }
    
    .btn-overlay {
        width: 40px;
        height: 40px;
        font-size: 0.875rem;
        min-height: 44px;
        min-width: 44px;
    }
    
    .product-category-badge {
        font-size: 0.625rem;
        margin-bottom: 0.25rem;
    }
}

/* Very Small Mobile */
@media (max-width: 375px) {
    .product-name-modern {
        font-size: 0.75rem;
        min-height: 2.25rem;
        max-height: 2.25rem;
    }
    
    .price-current {
        font-size: 0.9375rem;
    }
    
    .btn-add-cart-modern {
        padding: 0.625rem;
        font-size: 0.75rem;
    }
}
</style>

