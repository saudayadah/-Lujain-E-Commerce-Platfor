@extends('layouts.app')

@section('title', $product->name_ar)

@section('content')

<style>
/* Mobile-First Product Details Page */
@media (max-width: 768px) {
    .container {
        padding: 1rem 0.75rem !important;
        max-width: 100%;
    }
    
    /* تحسين النصوص على الجوال */
    h1 {
        font-size: 1.375rem !important;
        line-height: 1.3 !important;
        margin-bottom: 0.75rem !important;
    }
    
    h2 {
        font-size: 1.125rem !important;
    }
    
    /* تحسين الأزرار */
    .btn {
        min-height: 44px;
        padding: 0.875rem 1.5rem !important;
        font-size: 0.875rem !important;
        touch-action: manipulation;
    }
    
    /* تحسين حقول الإدخال */
    input[type="number"],
    input[type="text"],
    select {
        font-size: 16px !important; /* يمنع zoom في iOS */
        min-height: 44px;
    }
    
    /* Breadcrumb - Mobile */
    nav {
        margin-bottom: 1rem !important;
        font-size: 0.75rem !important;
        flex-wrap: wrap !important;
    }
    
    /* Product Grid - Stack on Mobile */
    .container > div:nth-of-type(2) {
        grid-template-columns: 1fr !important;
        gap: 1.5rem !important;
        margin-bottom: 2rem !important;
    }
    
    /* Main Image - Mobile */
    #mainImageContainer {
        border-radius: 12px !important;
    }
    
    /* Thumbnails - Horizontal Scroll */
    .thumbnail {
        width: 60px !important;
        height: 60px !important;
    }
    
    /* Product Info - Mobile */
    .container > div:nth-of-type(2) > div:last-child > * {
        margin-bottom: 1rem !important;
    }
    
    /* Category Badge */
    .product-category {
        font-size: 0.75rem !important;
        padding: 0.375rem 0.75rem !important;
    }
    
    /* Product Title */
    h1 {
        font-size: 1.375rem !important;
        line-height: 1.3 !important;
        margin-bottom: 0.75rem !important;
    }
    
    /* Price Section */
    .container > div:nth-of-type(2) > div:last-child > div:nth-of-type(3) {
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 0.75rem !important;
    }
    
    /* Stock Badge */
    .container > div:nth-of-type(2) > div:last-child > div:nth-of-type(3) > div {
        font-size: 0.8125rem !important;
        padding: 0.5rem 1rem !important;
    }
    
    /* Quantity & Add to Cart */
    .container > div:nth-of-type(2) > div:last-child > div:nth-of-type(4) {
        flex-direction: column !important;
        gap: 0.75rem !important;
    }
    
    .container > div:nth-of-type(2) > div:last-child > div:nth-of-type(4) > div:first-child {
        width: 100% !important;
    }
    
    .container > div:nth-of-type(2) > div:last-child > div:nth-of-type(4) button {
        width: 100% !important;
        padding: 0.875rem !important;
        font-size: 0.9375rem !important;
    }
    
    /* Specifications Table */
    table {
        font-size: 0.875rem !important;
    }
    
    table th,
    table td {
        padding: 0.625rem !important;
    }
    
    /* Related Products */
    .container > div:last-child > div > div {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 0.75rem !important;
    }
    
    .product-card {
        border-radius: 12px !important;
    }
    
    .product-card img {
        height: 140px !important;
    }
    
    .product-card > div {
        padding: 0.75rem !important;
    }
    
    .product-name {
        font-size: 0.8125rem !important;
        line-height: 1.3 !important;
    }
    
    .product-price {
        font-size: 0.9375rem !important;
    }
    
    /* Section Titles */
    h2, h3 {
        font-size: 1.125rem !important;
    }
    
    /* Tabs - Stack on Mobile */
    .tabs-container {
        flex-direction: column !important;
    }
    
    .tab-button {
        width: 100% !important;
        text-align: right !important;
    }
}
</style>

<div class="container" style="padding-top: 2rem;">
    <!-- Breadcrumb -->
    <nav style="margin-bottom: 2rem; display: flex; align-items: center; gap: 0.5rem; font-size: 0.9375rem; color: var(--gray-600);">
        <a href="{{ route('home') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">الرئيسية</a>
        <i class="fas fa-chevron-left" style="font-size: 0.75rem;"></i>
        <a href="{{ route('products.index') }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">المنتجات</a>
        <i class="fas fa-chevron-left" style="font-size: 0.75rem;"></i>
        <a href="{{ route('products.category', $product->category) }}" style="color: var(--primary); text-decoration: none; font-weight: 600;">{{ $product->category->name_ar }}</a>
        <i class="fas fa-chevron-left" style="font-size: 0.75rem;"></i>
        <span style="color: var(--gray-500);">{{ $product->name_ar }}</span>
    </nav>

    <!-- Product Details Section -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin-bottom: 4rem;">
        <!-- Product Images -->
        <div>
            @php
                $allImages = $product->getAllImages();
            @endphp

            @if(count($allImages) > 0)
            <div style="position: relative;">
                <!-- Main Image -->
                <div id="mainImageContainer" style="border-radius: 20px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 1px solid var(--gray-200); margin-bottom: 1rem;">
                    @php
                        $firstImage = $allImages[0];
                    @endphp
                    @if(str_starts_with($firstImage, 'http'))
                        <img id="mainImage" src="{{ $firstImage }}" alt="{{ $product->name_ar }}" style="width: 100%; height: auto; display: block;" loading="lazy">
                    @else
                        <img id="mainImage" src="{{ asset('storage/' . $firstImage) }}" alt="{{ $product->name_ar }}" style="width: 100%; height: auto; display: block;" loading="lazy">
                    @endif
                </div>

                <!-- Thumbnail Images -->
                @if(count($allImages) > 1)
                <div style="display: flex; gap: 0.75rem; overflow-x: auto; padding: 0.5rem 0;">
                    @foreach($allImages as $index => $image)
                    <div class="thumbnail-container" style="flex-shrink: 0;">
                        @php
                            $imgSrc = str_starts_with($image, 'http') ? $image : asset('storage/' . $image);
                        @endphp
                        <img src="{{ $imgSrc }}"
                             alt="{{ $product->name_ar }} - صورة {{ $index + 1 }}"
                             class="thumbnail {{ $index === 0 ? 'active' : '' }}"
                             style="width: 80px; height: 80px; object-fit: cover; border-radius: 12px; cursor: pointer; border: 3px solid {{ $index === 0 ? 'var(--primary)' : 'var(--gray-200)' }}; transition: all 0.3s;"
                             onclick="changeMainImage('{{ $imgSrc }}', this)">
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            @else
            <div style="background: linear-gradient(135deg, var(--gray-100), var(--gray-200)); border-radius: 20px; padding: 4rem; display: flex; align-items: center; justify-content: center; min-height: 500px; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                <i class="fas fa-image" style="font-size: 8rem; color: var(--gray-400);"></i>
            </div>
            @endif
        </div>
        
        <!-- Product Info -->
        <div>
            <!-- Category Badge -->
            <div style="display: inline-flex; align-items: center; gap: 0.5rem; background: var(--primary-light); color: var(--primary-dark); padding: 0.5rem 1rem; border-radius: 50px; font-weight: 700; font-size: 0.875rem; margin-bottom: 1.5rem;">
                <i class="fas fa-tag"></i>
                <span>{{ $product->category->name_ar }}</span>
            </div>
            
            <!-- Product Title -->
            <h1 style="font-size: 2.5rem; font-weight: 900; color: var(--dark); margin-bottom: 1rem; line-height: 1.2;">
                {{ $product->name_ar }}
            </h1>
            
            @if($product->name_en && $product->name_en != $product->name_ar)
            <p style="font-size: 1.125rem; color: var(--gray-600); margin-bottom: 1.5rem;">{{ $product->name_en }}</p>
            @endif
            
            <!-- Price Section -->
            <div style="background: linear-gradient(135deg, #f0fdf4, #dcfce7); padding: 2rem; border-radius: 16px; margin-bottom: 2rem; border: 2px solid var(--primary-light);">
                @if($product->hasDiscount())
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <span style="font-size: 1.5rem; color: var(--gray-500); text-decoration: line-through; font-weight: 600;">
                        {{ number_format($product->price, 2) }} ر.س
                    </span>
                    <span style="background: #ef4444; color: white; padding: 0.375rem 0.75rem; border-radius: 8px; font-size: 0.875rem; font-weight: 700;">
                        خصم {{ $product->getDiscountPercentage() }}%
                    </span>
                </div>
                @endif
                <div style="font-size: 3rem; font-weight: 900; color: var(--primary); margin-bottom: 0.5rem;">
                    {{ number_format($product->getCurrentPrice(), 2) }} <span style="font-size: 1.5rem;">ر.س</span>
                </div>
                <p style="color: var(--gray-700); font-size: 1rem; font-weight: 600;">
                    <i class="fas fa-weight" style="color: var(--primary); margin-left: 0.25rem;"></i> {{ $product->unit }}
                </p>
            </div>
            
            <!-- Stock Status -->
            @if($product->isInStock())
            <div style="display: flex; align-items: center; gap: 1rem; padding: 1.25rem; background: #d1fae5; border-radius: 12px; margin-bottom: 2rem; border: 2px solid var(--primary);">
                <i class="fas fa-check-circle" style="font-size: 2rem; color: var(--primary);"></i>
                <div>
                    <div style="color: var(--primary-dark); font-weight: 700; font-size: 1.125rem;">متوفر في المخزون</div>
                    <div style="color: var(--primary-dark); font-size: 0.875rem; margin-top: 0.25rem;">{{ $product->stock }} {{ $product->unit }} متاح</div>
                </div>
            </div>
            @else
            <div style="display: flex; align-items: center; gap: 1rem; padding: 1.25rem; background: #fee2e2; border-radius: 12px; margin-bottom: 2rem; border: 2px solid #ef4444;">
                <i class="fas fa-times-circle" style="font-size: 2rem; color: #ef4444;"></i>
                <div>
                    <div style="color: #991b1b; font-weight: 700; font-size: 1.125rem;">غير متوفر حالياً</div>
                    <div style="color: #991b1b; font-size: 0.875rem; margin-top: 0.25rem;">سيتوفر قريباً</div>
                </div>
            </div>
            @endif
            
            <!-- Add to Cart Form -->
            @if($product->isInStock())
            <form action="{{ route('cart.add') }}" method="POST" style="margin-bottom: 2rem;">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                
                <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 1.5rem;">
                    <label style="font-weight: 700; color: var(--dark); font-size: 1rem;">الكمية:</label>
                    <div style="display: flex; align-items: center; border: 2px solid var(--gray-200); border-radius: 12px; overflow: hidden;">
                        <button type="button" onclick="this.nextElementSibling.stepDown()" style="padding: 0.75rem 1.25rem; background: var(--gray-100); border: none; cursor: pointer; font-size: 1.25rem; font-weight: 700; color: var(--primary); transition: all 0.2s;" onmouseover="this.style.background='var(--primary)'; this.style.color='white'" onmouseout="this.style.background='var(--gray-100)'; this.style.color='var(--primary)'">
                            <i class="fas fa-minus"></i>
                        </button>
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock }}" 
                               style="width: 80px; text-align: center; padding: 0.75rem; border: none; font-size: 1.25rem; font-weight: 700; color: var(--dark);">
                        <button type="button" onclick="this.previousElementSibling.stepUp()" style="padding: 0.75rem 1.25rem; background: var(--gray-100); border: none; cursor: pointer; font-size: 1.25rem; font-weight: 700; color: var(--primary); transition: all 0.2s;" onmouseover="this.style.background='var(--primary)'; this.style.color='white'" onmouseout="this.style.background='var(--gray-100)'; this.style.color='var(--primary)'">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-add-cart-enhanced" style="width: 100%; padding: 1.25rem; font-size: 1.25rem; font-weight: 700; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); box-shadow: 0 8px 20px rgba(16,185,129,0.3); position: relative; overflow: hidden;" onclick="addToCartWithAnimation({{ $product->id }}, this)">
                    <i class="fas fa-shopping-cart"></i>
                    <span>أضف إلى السلة</span>
                    <div class="cart-ripple"></div>
                    <div class="cart-success" id="success-{{ $product->id }}" style="display: none;">
                        <i class="fas fa-check"></i>
                    </div>
                </button>
            </form>
            @endif
            
            <!-- Product Features -->
            <div style="background: white; padding: 1.5rem; border-radius: 12px; border: 1px solid var(--gray-200);">
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem;">
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-shipping-fast" style="font-size: 1.5rem; color: var(--primary);"></i>
                        <div>
                            <div style="font-weight: 700; font-size: 0.875rem; color: var(--dark);">شحن سريع</div>
                            <div style="font-size: 0.75rem; color: var(--gray-600);">توصيل سريع</div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-shield-alt" style="font-size: 1.5rem; color: var(--primary);"></i>
                        <div>
                            <div style="font-weight: 700; font-size: 0.875rem; color: var(--dark);">ضمان الجودة</div>
                            <div style="font-size: 0.75rem; color: var(--gray-600);">منتج أصلي</div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-undo" style="font-size: 1.5rem; color: var(--primary);"></i>
                        <div>
                            <div style="font-weight: 700; font-size: 0.875rem; color: var(--dark);">إرجاع مجاني</div>
                            <div style="font-size: 0.75rem; color: var(--gray-600);">خلال 7 أيام</div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fas fa-headset" style="font-size: 1.5rem; color: var(--primary);"></i>
                        <div>
                            <div style="font-weight: 700; font-size: 0.875rem; color: var(--dark);">دعم فني</div>
                            <div style="font-size: 0.75rem; color: var(--gray-600);">على مدار الساعة</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Product Description -->
    <div style="background: white; padding: 3rem; border-radius: 20px; margin-bottom: 4rem; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid var(--gray-200);">
        <h2 style="font-size: 2rem; font-weight: 900; color: var(--dark); margin-bottom: 2rem; padding-bottom: 1rem; border-bottom: 2px solid var(--primary);">
            <i class="fas fa-info-circle" style="color: var(--primary); margin-left: 0.5rem;"></i>
            وصف المنتج
        </h2>
        <div style="line-height: 2; color: var(--gray-700); font-size: 1.0625rem;">
            {{ $product->description_ar ?? 'لا يوجد وصف متاح لهذا المنتج.' }}
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <section style="margin-bottom: 4rem;">
        <h2 style="font-size: 2rem; font-weight: 900; color: var(--dark); margin-bottom: 2rem; text-align: center;">
            <i class="fas fa-layer-group" style="color: var(--primary);"></i> منتجات مشابهة
        </h2>
        
        <div class="product-grid" style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));">
            @foreach($relatedProducts as $related)
            <div class="product-card">
                <div style="position: relative;">
                    @if($related->image)
                    <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name_ar }}" class="product-image">
                    @else
                    <div class="product-image" style="display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, var(--gray-100), var(--gray-200));">
                        <i class="fas fa-image" style="font-size: 3rem; color: var(--gray-400);"></i>
                    </div>
                    @endif
                </div>
                <div class="product-info">
                    <div class="product-category">
                        <i class="fas fa-tag" style="margin-left: 0.5rem;"></i>
                        {{ $related->category->name_ar ?? 'عام' }}
                    </div>
                    <h3 class="product-title">{{ $related->name_ar }}</h3>
                    <div class="product-price">{{ number_format($related->getCurrentPrice(), 2) }} ر.س</div>
                    <a href="{{ route('products.show', $related) }}" class="btn-add-cart" style="display: flex; align-items: center; justify-content: center; text-decoration: none;">
                        <i class="fas fa-eye"></i> عرض التفاصيل
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif
</div>

<script>
// Enhanced Add to Cart with Animation
function addToCartWithAnimation(productId, button) {
    const originalContent = button.innerHTML;
    const successDiv = document.getElementById(`success-${productId}`);

    // Show loading state
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري الإضافة...';
    button.disabled = true;
    button.style.opacity = '0.8';

    // Create ripple effect
    const ripple = button.querySelector('.cart-ripple');
    if (ripple) {
        ripple.style.animation = 'cartRipple 0.6s ease-out';
    }

    // Simulate API call (replace with actual add to cart logic)
    setTimeout(() => {
        // Show success state
        if (successDiv) {
            successDiv.style.display = 'flex';
        }
        button.innerHTML = '<i class="fas fa-check"></i> تمت الإضافة!';
        button.style.background = 'linear-gradient(135deg, #10b981, #059669)';

        // Reset after 2 seconds
        setTimeout(() => {
            button.innerHTML = originalContent;
            button.disabled = false;
            button.style.opacity = '1';
            button.style.background = '';
            if (successDiv) {
                successDiv.style.display = 'none';
            }
        }, 2000);

        // Show notification
        showNotification('تم إضافة المنتج للسلة بنجاح!', 'success');
    }, 1000);
}

// Enhanced button hover effects
document.addEventListener('DOMContentLoaded', function() {
    // Add ripple effect to all buttons
    document.querySelectorAll('.btn').forEach(button => {
        button.addEventListener('click', function(e) {
            if (!this.querySelector('.btn-ripple')) {
                const ripple = document.createElement('div');
                ripple.className = 'btn-ripple';
                ripple.style.cssText = `
                    position: absolute;
                    border-radius: 50%;
                    background: rgba(255,255,255,0.3);
                    transform: scale(0);
                    animation: ripple 0.6s linear;
                    pointer-events: none;
                `;
                this.appendChild(ripple);

                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.width = ripple.style.height = size + 'px';
                ripple.style.left = x + 'px';
                ripple.style.top = y + 'px';
            }
        });
    });

    // Enhanced product image hover effects
    document.querySelectorAll('.product-image').forEach(img => {
        img.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.05) rotate(1deg)';
        });
        img.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1) rotate(0deg)';
        });
    });
});

// Enhanced notification system
function showNotification(message, type = 'success', duration = 3000) {
    // Remove existing notifications
    document.querySelectorAll('.custom-notification').forEach(n => n.remove());

    const notification = document.createElement('div');
    notification.className = 'custom-notification';
    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        background: ${type === 'success' ? 'linear-gradient(135deg, var(--primary), var(--primary-dark))' : 'linear-gradient(135deg, #ef4444, #dc2626)'};
        color: white;
        padding: 1.25rem 2rem;
        border-radius: 16px;
        font-weight: 700;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        z-index: 10000;
        display: flex;
        align-items: center;
        gap: 1rem;
        animation: slideInRight 0.3s ease;
        max-width: 400px;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.2);
    `;

    notification.innerHTML = `
        <div style="width: 24px; height: 24px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}" style="font-size: 12px;"></i>
        </div>
        <span>${message}</span>
        <button onclick="this.parentElement.remove()" style="background: none; border: none; color: white; cursor: pointer; padding: 0.25rem; margin-left: auto;">
            <i class="fas fa-times"></i>
        </button>
    `;

    document.body.appendChild(notification);

    // Auto remove after duration
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, duration);
}

// Add CSS animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }

    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

    @keyframes cartRipple {
        0% {
            transform: scale(0);
            opacity: 1;
        }
        100% {
            transform: scale(4);
            opacity: 0;
        }
    }

    .btn-ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.3);
        transform: scale(0);
        animation: ripple 0.6s linear;
        pointer-events: none;
    }

    .cart-success {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 60px;
        height: 60px;
        background: #10b981;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        animation: successPulse 0.6s ease;
    }

    @keyframes successPulse {
        0% {
            transform: translate(-50%, -50%) scale(0);
            opacity: 0;
        }
        50% {
            transform: translate(-50%, -50%) scale(1.2);
            opacity: 1;
        }
        100% {
            transform: translate(-50%, -50%) scale(1);
            opacity: 1;
        }
    }
`;
document.head.appendChild(style);

function changeMainImage(newSrc, thumbnail) {
    // تغيير الصورة الرئيسية مع تأثير انتقالي
    const mainImage = document.getElementById('mainImage');
    mainImage.style.opacity = '0';

    setTimeout(() => {
        mainImage.src = newSrc;
        mainImage.style.opacity = '1';
    }, 150);

    // تحديث الحدود للصور المصغرة
    document.querySelectorAll('.thumbnail').forEach(thumb => {
        thumb.style.borderColor = 'var(--gray-200)';
        thumb.style.transform = 'scale(1)';
    });

    thumbnail.style.borderColor = 'var(--primary)';
    thumbnail.style.transform = 'scale(1.05)';
}
</script>

<style>
/* Smooth scrolling for thumbnail container */
.thumbnail-container::-webkit-scrollbar {
    height: 6px;
}

.thumbnail-container::-webkit-scrollbar-track {
    background: var(--gray-100);
    border-radius: 3px;
}

.thumbnail-container::-webkit-scrollbar-thumb {
    background: var(--primary);
    border-radius: 3px;
}

.thumbnail-container::-webkit-scrollbar-thumb:hover {
    background: var(--primary-dark);
}

/* Animation for image change */
#mainImage {
    transition: opacity 0.3s ease;
}

.product-grid {
    display: grid;
    gap: 2rem;
}

.product-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    border: 1px solid var(--gray-200);
    overflow: hidden;
    transition: all 0.3s;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.product-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.product-info {
    padding: 1.5rem;
}

.product-category {
    color: var(--primary);
    font-size: 0.875rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    text-align: right;
    direction: rtl;
}

.product-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.5rem;
}

.product-price {
    font-size: 1.25rem;
    font-weight: 900;
    color: var(--primary);
    margin-bottom: 1rem;
}

.btn-add-cart {
    background: var(--primary);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.2s;
    width: 100%;
}

.btn-add-cart:hover {
    background: var(--primary-dark);
}
</style>
@endsection
