@extends('layouts.app')

@section('title', 'سلة التسوق')

@section('content')

<style>
/* Mobile-First Cart Page */
@media (max-width: 768px) {
    .container {
        padding: 1rem 0.75rem !important;
    }
    
    /* Header - Mobile */
    .container > div:first-child {
        padding: 1.5rem 1rem !important;
        margin-bottom: 1.5rem !important;
        border-radius: 12px !important;
    }
    
    .container > div:first-child h1 {
        font-size: 1.5rem !important;
        margin-bottom: 0.5rem !important;
    }
    
    .container > div:first-child p {
        font-size: 0.875rem !important;
    }
    
    /* Empty Cart - Mobile */
    .container > div:nth-child(2) {
        padding: 3rem 1rem !important;
    }
    
    .container > div:nth-child(2) i {
        font-size: 3.5rem !important;
        margin-bottom: 1rem !important;
    }
    
    .container > div:nth-child(2) h3 {
        font-size: 1.25rem !important;
        margin-bottom: 0.75rem !important;
    }
    
    .container > div:nth-child(2) p {
        font-size: 0.875rem !important;
        margin-bottom: 1.5rem !important;
    }
    
    .container > div:nth-child(2) .btn {
        padding: 0.875rem 1.5rem !important;
        font-size: 0.9375rem !important;
    }
    
    /* Cart Layout - Stack on Mobile */
    .container > div:nth-child(2) {
        grid-template-columns: 1fr !important;
        gap: 1.5rem !important;
    }
    
    /* Cart Items - Mobile */
    .container > div:nth-child(2) > div:first-child > div {
        padding: 1rem !important;
        margin-bottom: 1rem !important;
    }
    
    .container > div:nth-child(2) > div:first-child > div > div:first-child {
        flex-direction: column !important;
        gap: 1rem !important;
    }
    
    /* Product Image - Mobile */
    .container > div:nth-child(2) > div:first-child > div > div:first-child > div:first-child {
        width: 100% !important;
        height: 140px !important;
    }
    
    /* Product Info - Mobile */
    .container > div:nth-child(2) > div:first-child > div > div:first-child > div:nth-child(2) {
        width: 100% !important;
    }
    
    .container > div:nth-child(2) > div:first-child > div > div:first-child > div:nth-child(2) h3 {
        font-size: 1rem !important;
        margin-bottom: 0.5rem !important;
    }
    
    .container > div:nth-child(2) > div:first-child > div > div:first-child > div:nth-child(2) p {
        font-size: 0.875rem !important;
    }
    
    /* Quantity & Price - Mobile Stack */
    .container > div:nth-child(2) > div:first-child > div > div:first-child > div:nth-child(2) > div {
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 0.75rem !important;
    }
    
    /* Quantity Controls - Full Width */
    .container > div:nth-child(2) > div:first-child > div > div:first-child > div:nth-child(2) > div > div:first-child {
        width: 100% !important;
    }
    
    .container > div:nth-child(2) > div:first-child > div > div:first-child > div:nth-child(2) > div > div:first-child button,
    .container > div:nth-child(2) > div:first-child > div > div:first-child > div:nth-child(2) > div > div:first-child input {
        padding: 0.625rem !important;
    }
    
    /* Price - Mobile */
    .container > div:nth-child(2) > div:first-child > div > div:first-child > div:nth-child(2) > div > div:nth-child(2) span:first-child {
        font-size: 1.125rem !important;
    }
    
    /* Remove Button - Mobile */
    .container > div:nth-child(2) > div:first-child > div > div:last-child {
        margin-top: 1rem !important;
        flex-direction: row !important;
        justify-content: space-between !important;
    }
    
    .container > div:nth-child(2) > div:first-child > div > div:last-child button {
        padding: 0.5rem 1rem !important;
        font-size: 0.875rem !important;
    }
    
    /* Order Summary - Mobile */
    .container > div:nth-child(2) > div:last-child {
        position: sticky !important;
        bottom: 0 !important;
        width: 100% !important;
        border-radius: 12px 12px 0 0 !important;
        box-shadow: 0 -4px 12px rgba(0,0,0,0.1) !important;
    }
    
    .container > div:nth-child(2) > div:last-child h2 {
        font-size: 1.125rem !important;
        margin-bottom: 1rem !important;
    }
    
    .container > div:nth-child(2) > div:last-child > div {
        padding: 1rem !important;
    }
    
    .container > div:nth-child(2) > div:last-child .btn {
        padding: 0.875rem !important;
        font-size: 0.9375rem !important;
    }
}

/* Checkout Page - Mobile */
@media (max-width: 768px) {
    /* Checkout Grid - Stack */
    .checkout-grid {
        grid-template-columns: 1fr !important;
        gap: 1.5rem !important;
    }
    
    /* Form Inputs - Full Width */
    .checkout-grid input,
    .checkout-grid select,
    .checkout-grid textarea {
        font-size: 0.875rem !important;
        padding: 0.625rem 1rem !important;
    }
    
    /* Checkout Summary - Sticky Bottom */
    .checkout-summary {
        position: sticky !important;
        bottom: 0 !important;
        border-radius: 12px 12px 0 0 !important;
    }
}
</style>

<div class="container" style="padding-top: 2rem;">
    <!-- Header -->
    <div style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; padding: 2.5rem; border-radius: 20px; margin-bottom: 3rem; text-align: center; box-shadow: 0 10px 30px rgba(16,185,129,0.2);">
        <h1 style="font-size: 2.5rem; font-weight: 900; margin-bottom: 0.5rem;">
            <i class="fas fa-shopping-cart"></i> سلة التسوق
        </h1>
        <p style="font-size: 1rem; opacity: 0.9;">
            راجع منتجاتك قبل إتمام عملية الشراء
        </p>
    </div>

@if(empty($cart['items']))
    <div style="text-align: center; padding: 5rem 2rem; background: white; border-radius: 20px; box-shadow: var(--shadow-lg);">
        <i class="fas fa-shopping-cart" style="font-size: 6rem; color: var(--text-light); margin-bottom: 2rem; opacity: 0.5;"></i>
        <h3 style="font-size: 2rem; color: var(--text-dark); margin-bottom: 1rem;">
            {{ app()->getLocale() == 'ar' ? 'سلتك فارغة!' : 'Your Cart is Empty!' }}
        </h3>
        <p style="color: var(--text-light); margin-bottom: 2rem; font-size: 1.1rem;">
            {{ app()->getLocale() == 'ar' ? 'ابدأ بإضافة منتجات إلى سلتك' : 'Start adding products to your cart' }}
        </p>
        <a href="{{ route('products.index') }}" class="btn" style="padding: 1.25rem 3rem; font-size: 1.1rem;">
            <i class="fas fa-shopping-basket"></i>
            {{ app()->getLocale() == 'ar' ? 'تسوق الآن' : 'Shop Now' }}
        </a>
    </div>
@else
    <div style="display: grid; grid-template-columns: 1fr 400px; gap: 2rem; align-items: start;">
        <!-- Cart Items -->
        <div>
            @foreach($cart['items'] as $item)
            <div style="background: white; padding: 2rem; border-radius: 16px; box-shadow: var(--shadow-md); margin-bottom: 1.5rem; transition: all 0.3s ease;">
                <div style="display: flex; gap: 2rem; align-items: center;">
                    <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #f3f4f6, #e5e7eb); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 3rem; color: var(--primary-green); flex-shrink: 0;">
                        <i class="fas fa-box"></i>
                    </div>
                    
                    <div style="flex: 1;">
                        <h3 style="font-size: 1.4rem; font-weight: 800; color: var(--dark-green); margin-bottom: 0.5rem;">
                            {{ $item['product']->getName() }}
                        </h3>
                        <p style="color: var(--text-light); margin-bottom: 1rem;">
                            {{ $item['product']->category->getName() }}
                        </p>
                        
                        <div style="display: flex; align-items: center; gap: 2rem; flex-wrap: wrap;">
                            <div style="font-size: 1.5rem; font-weight: 800; color: var(--primary-green);">
                                {{ number_format($item['price'], 2) }} {{ app()->getLocale() == 'ar' ? 'ر.س' : 'SAR' }}
                            </div>
                            
                            <form action="{{ route('cart.update', $item['key']) }}" method="POST" style="display: flex; align-items: center; gap: 0.75rem;">
                                @csrf
                                @method('PATCH')
                                <button type="button" class="qty-btn" onclick="decrementQty(this)" style="position: relative; overflow: hidden;">
                                    <i class="fas fa-minus"></i>
                                    <div class="btn-ripple"></div>
                                </button>
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                                       class="qty-number" readonly style="border: 2px solid var(--border-color); padding: 0.5rem; border-radius: 8px; background: linear-gradient(135deg, rgba(16,185,129,0.05), rgba(16,185,129,0.02)); font-weight: 700; color: var(--primary);">
                                <button type="button" class="qty-btn" onclick="incrementQty(this)" style="position: relative; overflow: hidden;">
                                    <i class="fas fa-plus"></i>
                                    <div class="btn-ripple"></div>
                                </button>
                                <button type="submit" class="btn-outline btn" style="padding: 0.65rem 1.25rem;">
                                    <i class="fas fa-sync"></i>
                                    {{ app()->getLocale() == 'ar' ? 'تحديث' : 'Update' }}
                                </button>
                            </form>
                            
                            <form action="{{ route('cart.remove', $item['key']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-remove" style="background: linear-gradient(135deg, #dc3545, #c82333); padding: 0.65rem 1.25rem; position: relative; overflow: hidden;" onclick="removeFromCart(this)">
                                    <i class="fas fa-trash"></i>
                                    <span>{{ app()->getLocale() == 'ar' ? 'حذف' : 'Remove' }}</span>
                                    <div class="remove-ripple"></div>
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <div style="text-align: {{ app()->getLocale() == 'ar' ? 'left' : 'right' }}; min-width: 120px;">
                        <div style="font-size: 1.75rem; font-weight: 900; color: var(--dark-green);">
                            {{ number_format($item['line_total'], 2) }} {{ app()->getLocale() == 'ar' ? 'ر.س' : 'SAR' }}
                        </div>
                        <small style="color: var(--text-light);">
                            {{ app()->getLocale() == 'ar' ? 'الإجمالي' : 'Total' }}
                        </small>
                    </div>
                </div>
            </div>
            @endforeach
            
            <form action="{{ route('cart.clear') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn" style="background: linear-gradient(135deg, #6c757d, #5a6268);">
                    <i class="fas fa-trash-alt"></i>
                    {{ app()->getLocale() == 'ar' ? 'إفراغ السلة' : 'Clear Cart' }}
                </button>
            </form>
        </div>
        
        <!-- Order Summary -->
        <div style="background: white; padding: 2.5rem; border-radius: 20px; box-shadow: var(--shadow-xl); position: sticky; top: 100px;">
            <h3 style="font-size: 1.8rem; font-weight: 900; color: var(--dark-green); margin-bottom: 2rem; border-bottom: 3px solid var(--primary-green); padding-bottom: 1rem;">
                <i class="fas fa-receipt"></i>
                {{ app()->getLocale() == 'ar' ? 'ملخص الطلب' : 'Order Summary' }}
            </h3>
            
            <div style="margin-bottom: 2rem;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; font-size: 1.1rem;">
                    <span style="color: var(--text-light);">{{ app()->getLocale() == 'ar' ? 'المجموع الفرعي:' : 'Subtotal:' }}</span>
                    <span style="font-weight: 700;">{{ number_format($cart['subtotal'], 2) }} {{ app()->getLocale() == 'ar' ? 'ر.س' : 'SAR' }}</span>
                </div>
                
                <div style="display: flex; justify-content: space-between; margin-bottom: 1rem; font-size: 1.1rem;">
                    <span style="color: var(--text-light);">{{ app()->getLocale() == 'ar' ? 'الضريبة (15%):' : 'Tax (15%):' }}</span>
                    <span style="font-weight: 700;">{{ number_format($cart['tax'], 2) }} {{ app()->getLocale() == 'ar' ? 'ر.س' : 'SAR' }}</span>
                </div>
                
                <div style="border-top: 2px dashed var(--border-color); margin: 1.5rem 0; padding-top: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; font-size: 1.5rem; font-weight: 900; color: var(--primary-green);">
                        <span>{{ app()->getLocale() == 'ar' ? 'الإجمالي:' : 'Total:' }}</span>
                        <span>{{ number_format($cart['total'], 2) }} {{ app()->getLocale() == 'ar' ? 'ر.س' : 'SAR' }}</span>
                    </div>
                </div>
            </div>
            
            @auth
                <a href="{{ route('checkout.index') }}" class="btn btn-checkout" style="width: 100%; padding: 1.25rem; font-size: 1.1rem; justify-content: center; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); box-shadow: 0 8px 20px rgba(16,185,129,0.3); position: relative; overflow: hidden;" onclick="proceedToCheckout(this)">
                    <i class="fas fa-credit-card"></i>
                    <span>إتمام الطلب</span>
                    <div class="checkout-ripple"></div>
                </a>
            @else
                <!-- Alert Message -->
                <div style="background: linear-gradient(135deg, #fef3c7, #fde68a); border: 2px solid #f59e0b; border-radius: 12px; padding: 1.5rem; margin-bottom: 1.5rem;">
                    <div style="display: flex; align-items: start; gap: 1rem; margin-bottom: 1rem;">
                        <i class="fas fa-info-circle" style="font-size: 1.5rem; color: #d97706; margin-top: 0.125rem;"></i>
                        <div>
                            <h4 style="font-weight: 800; color: #92400e; font-size: 1rem; margin-bottom: 0.5rem;">يجب عليك تسجيل الدخول أولاً</h4>
                            <p style="font-size: 0.9375rem; color: #78350f; line-height: 1.6; margin-bottom: 0;">
                                لإتمام عملية الشراء وتتبع طلباتك، يجب عليك تسجيل الدخول أو إنشاء حساب جديد
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Login Button -->
                <a href="{{ route('login') }}" class="btn" style="width: 100%; padding: 1.25rem; font-size: 1.1rem; justify-content: center; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); box-shadow: 0 8px 20px rgba(16,185,129,0.3); margin-bottom: 1rem;">
                    <i class="fas fa-sign-in-alt"></i>
                    تسجيل الدخول
                </a>

                <!-- Register Button -->
                <a href="{{ route('register') }}" class="btn" style="width: 100%; padding: 1.25rem; font-size: 1.1rem; justify-content: center; background: linear-gradient(135deg, #3b82f6, #2563eb); box-shadow: 0 8px 20px rgba(59,130,246,0.3);">
                    <i class="fas fa-user-plus"></i>
                    إنشاء حساب جديد
                </a>

                <div style="text-align: center; margin-top: 1rem; padding: 1rem; background: var(--gray-50); border-radius: 8px;">
                    <p style="font-size: 0.8125rem; color: var(--gray-600); margin: 0;">
                        <i class="fas fa-shield-alt" style="color: var(--primary); margin-left: 0.25rem;"></i>
                        بياناتك آمنة ومحمية 100%
                    </p>
                </div>
            @endauth
            
            <a href="{{ route('products.index') }}" class="btn-outline btn" style="width: 100%; margin-top: 1rem; padding: 1rem; justify-content: center;">
                <i class="fas fa-arrow-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"></i>
                {{ app()->getLocale() == 'ar' ? 'متابعة التسوق' : 'Continue Shopping' }}
            </a>
        </div>
    </div>
@endif

<script>
// Enhanced quantity controls with animations
function incrementQty(btn) {
    const input = btn.previousElementSibling;
    const newValue = parseInt(input.value) + 1;

    // Animate button
    btn.style.transform = 'scale(0.9)';
    setTimeout(() => {
        btn.style.transform = 'scale(1)';
    }, 150);

    // Animate input
    input.style.transform = 'scale(1.1)';
    input.value = newValue;
    setTimeout(() => {
        input.style.transform = 'scale(1)';
    }, 200);

    // Update cart item total
    updateCartItemTotal(input.closest('.cart-item'));
}

function decrementQty(btn) {
    const input = btn.nextElementSibling;
    const currentValue = parseInt(input.value);

    if (currentValue > 1) {
        // Animate button
        btn.style.transform = 'scale(0.9)';
        setTimeout(() => {
            btn.style.transform = 'scale(1)';
        }, 150);

        // Animate input
        input.style.transform = 'scale(1.1)';
        input.value = currentValue - 1;
        setTimeout(() => {
            input.style.transform = 'scale(1)';
        }, 200);

        // Update cart item total
        updateCartItemTotal(input.closest('.cart-item'));
    }
}

// Remove item with animation
function removeFromCart(button) {
    const cartItem = button.closest('.cart-item') || button.closest('[style*="background: white"]');

    if (cartItem) {
        // Add fade out animation
        cartItem.style.transition = 'all 0.5s ease';
        cartItem.style.opacity = '0';
        cartItem.style.transform = 'translateX(-100%)';

        setTimeout(() => {
            cartItem.remove();
            updateCartTotals();
            showNotification('تم حذف المنتج من السلة', 'success');
        }, 500);
    }
}

// Animate checkout button
function proceedToCheckout(button) {
    // Add loading ripple effect
    const ripple = button.querySelector('.checkout-ripple');
    if (ripple) {
        ripple.style.animation = 'checkoutRipple 0.8s ease-out';
    }

    // Show loading state
    const originalContent = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> جاري المعالجة...';
    button.style.opacity = '0.8';

    // Simulate processing time
    setTimeout(() => {
        button.innerHTML = originalContent;
        button.style.opacity = '1';
    }, 1500);
}

// Update cart item total with animation
function updateCartItemTotal(cartItem) {
    const priceElement = cartItem.querySelector('[style*="font-size: 1.75rem"]');
    if (priceElement) {
        priceElement.style.transform = 'scale(1.1)';
        priceElement.style.color = 'var(--accent)';

        setTimeout(() => {
            priceElement.style.transform = 'scale(1)';
            priceElement.style.color = 'var(--dark-green)';
        }, 300);
    }
}

// Enhanced notification system for cart
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.style.cssText = `
        position: fixed;
        top: 120px;
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
    `;

    notification.innerHTML = `
        <div style="width: 24px; height: 24px; border-radius: 50%; background: rgba(255,255,255,0.2); display: flex; align-items: center; justify-content: center;">
            <i class="fas fa-${type === 'success' ? 'check' : 'exclamation'}" style="font-size: 12px;"></i>
        </div>
        <span>${message}</span>
    `;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Initialize cart page animations
document.addEventListener('DOMContentLoaded', function() {
    // Animate cart items on load
    const cartItems = document.querySelectorAll('[style*="background: white"]');
    cartItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateY(30px)';
        setTimeout(() => {
            item.style.transition = 'all 0.6s ease';
            item.style.opacity = '1';
            item.style.transform = 'translateY(0)';
        }, index * 150);
    });

    // Add hover effects to quantity buttons
    document.querySelectorAll('.qty-btn').forEach(btn => {
        btn.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1)';
            this.style.boxShadow = '0 4px 15px rgba(16, 185, 129, 0.3)';
        });
        btn.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
            this.style.boxShadow = 'none';
        });
    });
});

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

    @keyframes checkoutRipple {
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

    .remove-ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        transform: scale(0);
        animation: removeRipple 0.6s linear;
        pointer-events: none;
    }

    @keyframes removeRipple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }

    @keyframes ripple {
        to {
            transform: scale(4);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
</script>

<style>
/* تحسينات خاصة بصفحة السلة للهواتف المحمولة */
@media (max-width: 768px) {
    .container {
        padding: 0 1rem;
    }

    /* رأس السلة محسن للهواتف المحمولة */
    [style*="background: linear-gradient"] {
        padding: 2rem 1rem !important;
        margin-bottom: 2rem !important;
        margin-left: -1rem !important;
        margin-right: -1rem !important;
        border-radius: 0 !important;
    }

    [style*="background: linear-gradient"] h1 {
        font-size: 2rem !important;
    }

    [style*="background: linear-gradient"] p {
        font-size: 1rem !important;
    }

    /* تخطيط السلة محسن للهواتف المحمولة */
    [style*="display: grid; grid-template-columns: 1fr 400px"] {
        grid-template-columns: 1fr !important;
        gap: 2rem !important;
    }

    /* عناصر السلة محسنة للهواتف المحمولة */
    [style*="background: white; padding: 2rem"] {
        padding: 1.5rem !important;
        margin-bottom: 1.5rem !important;
    }

    [style*="display: flex; gap: 2rem; align-items: center"] {
        flex-direction: column !important;
        gap: 1.5rem !important;
        text-align: center !important;
    }

    [style*="width: 120px; height: 120px"] {
        width: 100px !important;
        height: 100px !important;
        font-size: 2.5rem !important;
    }

    [style*="flex: 1"] {
        text-align: center !important;
    }

    [style*="font-size: 1.4rem"] {
        font-size: 1.125rem !important;
    }

    /* عناصر التحكم في الكمية محسنة للهواتف المحمولة */
    [style*="display: flex; align-items: center; gap: 2rem; flex-wrap: wrap"] {
        flex-direction: column !important;
        gap: 1rem !important;
        align-items: center !important;
    }

    [style*="display: flex; align-items: center; gap: 0.75rem"] {
        justify-content: center !important;
        width: 100% !important;
    }

    .qty-btn {
        padding: 0.625rem !important;
        width: 40px !important;
        height: 40px !important;
    }

    .qty-number {
        width: 60px !important;
        height: 40px !important;
        font-size: 1rem !important;
    }

    /* أزرار السلة محسنة للهواتف المحمولة */
    [style*="display: flex; gap: 1rem; align-items: center; margin-bottom: 1rem"] {
        flex-direction: column !important;
        gap: 0.75rem !important;
    }

    /* ملخص الطلب محسن للهواتف المحمولة */
    [style*="background: white; padding: 2.5rem"] {
        padding: 1.5rem !important;
        margin-top: 1rem !important;
    }

    [style*="font-size: 1.8rem"] {
        font-size: 1.5rem !important;
    }

    [style*="display: flex; justify-content: space-between; margin-bottom: 1rem"] {
        font-size: 1rem !important;
    }

    [style*="display: flex; justify-content: space-between; font-size: 1.5rem"] {
        font-size: 1.25rem !important;
    }

    /* رسائل التنبيه محسنة للهواتف المحمولة */
    [style*="background: linear-gradient"] {
        padding: 1.5rem !important;
        margin-bottom: 1.5rem !important;
    }

    [style*="display: flex; align-items: start; gap: 1rem"] {
        flex-direction: column !important;
        text-align: center !important;
    }

    /* أزرار السلة محسنة للهواتف المحمولة */
    .btn {
        width: 100% !important;
        padding: 1rem !important;
        font-size: 1rem !important;
        margin-bottom: 0.75rem !important;
    }

    /* رسالة السلة الفارغة محسنة للهواتف المحمولة */
    [style*="text-align: center; padding: 5rem 2rem"] {
        padding: 4rem 1.5rem !important;
    }

    [style*="font-size: 6rem"] {
        font-size: 4rem !important;
    }

    [style*="font-size: 2rem"] {
        font-size: 1.5rem !important;
    }
}

@media (max-width: 480px) {
    .container {
        padding: 0 0.75rem;
    }

    /* رأس السلة محسن للشاشات الصغيرة */
    [style*="background: linear-gradient"] {
        padding: 1.5rem 0.75rem !important;
        margin: 0.5rem -0.75rem 1.5rem -0.75rem !important;
    }

    [style*="background: linear-gradient"] h1 {
        font-size: 1.75rem !important;
    }

    /* عناصر السلة محسنة للشاشات الصغيرة */
    [style*="background: white; padding: 1.5rem"] {
        padding: 1rem !important;
        margin-bottom: 1rem !important;
    }

    [style*="font-size: 1.125rem"] {
        font-size: 1rem !important;
    }

    /* عناصر التحكم محسنة للشاشات الصغيرة */
    .qty-btn {
        padding: 0.5rem !important;
        width: 35px !important;
        height: 35px !important;
    }

    .qty-number {
        width: 50px !important;
        height: 35px !important;
        font-size: 0.9375rem !important;
    }

    /* ملخص الطلب محسن للشاشات الصغيرة */
    [style*="background: white; padding: 1.5rem"] {
        padding: 1rem !important;
    }

    [style*="font-size: 1.5rem"] {
        font-size: 1.25rem !important;
    }

    /* رسالة السلة الفارغة محسنة للشاشات الصغيرة */
    [style*="text-align: center; padding: 4rem"] {
        padding: 3rem 1rem !important;
    }

    [style*="font-size: 4rem"] {
        font-size: 3rem !important;
    }

    [style*="font-size: 1.5rem"] {
        font-size: 1.25rem !important;
    }

    /* تحسينات خاصة بالسلة للشاشات الصغيرة */
    .cart-item {
        padding: 1rem !important;
        gap: 1rem !important;
    }

    .cart-item-image {
        width: 80px !important;
        height: 80px !important;
    }

    .cart-item-info h3 {
        font-size: 0.9375rem !important;
        line-height: 1.3 !important;
    }

    .cart-item-total {
        font-size: 1.125rem !important;
    }

    /* ملخص الطلب محسن للشاشات الصغيرة */
    [style*="background: white; padding: 1.5rem"] {
        padding: 1rem !important;
    }

    [style*="font-size: 1.5rem"] {
        font-size: 1.125rem !important;
    }

    [style*="font-size: 1.25rem"] {
        font-size: 1rem !important;
    }
}
</style>

@endsection

