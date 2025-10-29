@extends('layouts.app')

@section('title', 'سلة التسوق')

@push('styles')
<style>
/* Mobile-First Cart Page */
@media (max-width: 768px) {
    .container {
        padding: 1rem 0.75rem !important;
        padding-top: 1.5rem !important;
    }
    
    .cart-layout-modern {
        grid-template-columns: 1fr !important;
        gap: 1.5rem !important;
    }
    
    .cart-items-modern {
        order: 1;
    }
    
    .cart-summary-modern {
        order: 2;
        position: sticky;
        bottom: 0;
        background: white;
        padding: 1.5rem !important;
        border-radius: 20px 20px 0 0;
        box-shadow: 0 -4px 20px rgba(0,0,0,0.1);
        z-index: 10;
    }
    
    .cart-item-modern {
        flex-direction: column !important;
        gap: 1rem !important;
    }
    
    .cart-item-image {
        width: 100% !important;
        max-width: 100% !important;
    }
    
    .cart-item-controls {
        flex-direction: column !important;
        gap: 1rem !important;
    }
    
    .quantity-control {
        width: 100% !important;
    }
    
    .cart-item-price {
        width: 100% !important;
        text-align: center !important;
    }
}
</style>
@endpush

@section('content')
<div class="container" style="padding-top: 2rem;">
    <!-- Header -->
    <div class="cart-header-modern">
        <h1><i class="fas fa-shopping-cart"></i> سلة التسوق</h1>
        <p class="cart-subtitle">راجع منتجاتك قبل الدفع</p>
    </div>

    @if(empty($cart['items']) || count($cart['items']) == 0)
        <!-- Empty Cart -->
        <div class="empty-cart-modern">
            <div class="empty-cart-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <h2>السلة فارغة</h2>
            <p>لا توجد منتجات في سلة التسوق الخاصة بك</p>
            <a href="{{ route('products.index') }}" class="btn-shopping">
                <i class="fas fa-arrow-left"></i>
                ابدأ التسوق
            </a>
        </div>
    @else
        <div class="cart-layout-modern">
            <!-- Cart Items -->
            <div class="cart-items-modern">
                <div class="cart-items-header">
                    <h2>المنتجات ({{ count($cart['items']) }})</h2>
                    <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف جميع المنتجات؟');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-clear-cart">
                            <i class="fas fa-trash"></i> مسح الكل
                        </button>
                    </form>
                </div>

                <div class="cart-items-list">
                    @foreach($cart['items'] as $key => $item)
                    <div class="cart-item-modern" data-cart-key="{{ $key }}">
                        <div class="cart-item-image">
                            @if(isset($item['product']) && $item['product']->image)
                                @if(str_starts_with($item['product']->image, 'http'))
                                    <img src="{{ $item['product']->image }}" alt="{{ $item['product']->name_ar }}">
                                @else
                                    <img src="{{ asset('storage/' . $item['product']->image) }}" alt="{{ $item['product']->name_ar }}">
                                @endif
                            @else
                                <div class="no-image">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                        </div>

                        <div class="cart-item-details">
                            <div class="cart-item-header">
                                <h3>
                                    <a href="{{ route('products.show', $item['product']->id ?? '#') }}">
                                        {{ $item['product']->name_ar ?? 'منتج' }}
                                    </a>
                                </h3>
                                <form action="{{ route('cart.remove', $key) }}" method="POST" class="remove-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-remove-item">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </form>
                            </div>

                            <p class="cart-item-category">
                                {{ $item['product']->category->name_ar ?? '' }}
                            </p>

                            <div class="cart-item-controls">
                                <div class="quantity-control">
                                    <form action="{{ route('cart.update', $key) }}" method="POST" class="quantity-form">
                                        @csrf
                                        @method('PATCH')
                                        <button type="button" class="qty-btn minus" onclick="updateQuantity(this, -1)">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="100" class="qty-input" readonly>
                                        <button type="button" class="qty-btn plus" onclick="updateQuantity(this, 1)">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </form>
                                </div>

                                <div class="cart-item-price">
                                    <span class="price-single">{{ number_format($item['price'], 2) }} ر.س</span>
                                    <span class="price-total">الإجمالي: {{ number_format($item['line_total'], 2) }} ر.س</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="cart-summary-modern">
                <div class="summary-card">
                    <h3>ملخص الطلب</h3>
                    
                    <div class="summary-row">
                        <span>المجموع الفرعي:</span>
                        <span>{{ number_format($cart['subtotal'], 2) }} ر.س</span>
                    </div>

                    @if(isset($cart['coupon']) && $cart['discount'] > 0)
                    <div class="summary-row discount-row">
                        <span>
                            <i class="fas fa-tag"></i> الخصم ({{ $cart['coupon']['code'] ?? '' }}):
                        </span>
                        <span class="discount-amount">-{{ number_format($cart['discount'], 2) }} ر.س</span>
                    </div>
                    @endif

                    <div class="summary-row">
                        <span>ضريبة القيمة المضافة (15%):</span>
                        <span>{{ number_format($cart['tax'], 2) }} ر.س</span>
                    </div>

                    <div class="summary-divider"></div>

                    <div class="summary-row total-row">
                        <span>الإجمالي:</span>
                        <span class="total-price">{{ number_format($cart['total'], 2) }} ر.س</span>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn-checkout">
                        <i class="fas fa-lock"></i>
                        إتمام الطلب
                    </a>

                    <a href="{{ route('products.index') }}" class="btn-continue-shopping">
                        <i class="fas fa-arrow-left"></i>
                        متابعة التسوق
                    </a>
                </div>

                <!-- Security Badge -->
                <div class="security-badge">
                    <i class="fas fa-shield-alt"></i>
                    <div>
                        <strong>شراء آمن</strong>
                        <p>نضمن حماية معلوماتك</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
.cart-header-modern {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    padding: 2.5rem;
    border-radius: 20px;
    text-align: center;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(16,185,129,0.2);
}

.cart-header-modern h1 {
    font-size: 2.5rem;
    font-weight: 900;
    margin-bottom: 0.5rem;
}

.cart-subtitle {
    font-size: 1.1rem;
    opacity: 0.95;
}

.empty-cart-modern {
    text-align: center;
    padding: 4rem 2rem;
    background: white;
    border-radius: 20px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.empty-cart-icon {
    font-size: 5rem;
    color: var(--gray-300);
    margin-bottom: 1.5rem;
}

.empty-cart-modern h2 {
    font-size: 1.75rem;
    color: var(--dark);
    margin-bottom: 0.5rem;
}

.empty-cart-modern p {
    color: var(--gray-600);
    margin-bottom: 2rem;
}

.btn-shopping {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem 2rem;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    text-decoration: none;
    border-radius: 12px;
    font-weight: 700;
    box-shadow: 0 4px 12px rgba(16,185,129,0.3);
    transition: all 0.3s;
}

.btn-shopping:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16,185,129,0.4);
}

.cart-layout-modern {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 2rem;
}

.cart-items-modern {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
}

.cart-items-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--gray-100);
}

.cart-items-header h2 {
    font-size: 1.5rem;
    color: var(--dark);
}

.btn-clear-cart {
    padding: 0.625rem 1.25rem;
    background: #fee2e2;
    color: #dc2626;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-clear-cart:hover {
    background: #fecaca;
}

.cart-items-list {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.cart-item-modern {
    display: grid;
    grid-template-columns: 120px 1fr;
    gap: 1.5rem;
    padding: 1.5rem;
    background: var(--gray-50);
    border-radius: 16px;
    border: 1px solid var(--gray-200);
    transition: all 0.3s;
}

.cart-item-modern:hover {
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    border-color: var(--primary);
}

.cart-item-image {
    width: 120px;
    height: 120px;
    border-radius: 12px;
    overflow: hidden;
    background: white;
    display: flex;
    align-items: center;
    justify-content: center;
}

.cart-item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-image {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--gray-100);
    color: var(--gray-400);
    font-size: 2rem;
}

.cart-item-details {
    flex: 1;
}

.cart-item-header {
    display: flex;
    justify-content: space-between;
    align-items: start;
    margin-bottom: 0.5rem;
}

.cart-item-header h3 {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--dark);
    margin: 0;
    flex: 1;
}

.cart-item-header h3 a {
    color: var(--dark);
    text-decoration: none;
    transition: color 0.2s;
}

.cart-item-header h3 a:hover {
    color: var(--primary);
}

.btn-remove-item {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    border: none;
    background: #fee2e2;
    color: #dc2626;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.btn-remove-item:hover {
    background: #fecaca;
}

.cart-item-category {
    font-size: 0.875rem;
    color: var(--gray-600);
    margin-bottom: 1rem;
}

.cart-item-controls {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 1rem;
    flex-wrap: wrap;
}

.quantity-control {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.quantity-form {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.qty-btn {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    border: 2px solid var(--gray-200);
    background: white;
    color: var(--dark);
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.qty-btn:hover {
    border-color: var(--primary);
    background: var(--primary);
    color: white;
}

.qty-input {
    width: 60px;
    text-align: center;
    padding: 0.5rem;
    border: 2px solid var(--gray-200);
    border-radius: 8px;
    font-weight: 700;
    font-size: 1rem;
}

.cart-item-price {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
}

.price-single {
    font-size: 0.875rem;
    color: var(--gray-600);
}

.price-total {
    font-size: 1.125rem;
    font-weight: 800;
    color: var(--primary);
}

.cart-summary-modern {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.summary-card {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    border: 1px solid var(--gray-200);
}

.summary-card h3 {
    font-size: 1.5rem;
    font-weight: 900;
    color: var(--dark);
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--primary);
}

.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    font-size: 1rem;
}

.summary-row span:first-child {
    color: var(--gray-700);
}

.summary-row span:last-child {
    font-weight: 700;
    color: var(--dark);
}

.discount-row {
    color: var(--primary);
}

.discount-amount {
    color: var(--primary);
}

.summary-divider {
    height: 1px;
    background: var(--gray-200);
    margin: 1rem 0;
}

.total-row {
    font-size: 1.25rem;
    padding-top: 1rem;
    border-top: 2px solid var(--gray-200);
}

.total-price {
    font-size: 1.5rem;
    color: var(--primary);
}

.btn-checkout {
    width: 100%;
    padding: 1rem;
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
    text-decoration: none;
    border-radius: 12px;
    font-weight: 700;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 1.5rem;
    box-shadow: 0 4px 12px rgba(16,185,129,0.3);
    transition: all 0.3s;
}

.btn-checkout:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(16,185,129,0.4);
}

.btn-continue-shopping {
    width: 100%;
    padding: 0.875rem;
    background: white;
    color: var(--primary);
    text-decoration: none;
    border: 2px solid var(--primary);
    border-radius: 12px;
    font-weight: 700;
    text-align: center;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    margin-top: 0.75rem;
    transition: all 0.3s;
}

.btn-continue-shopping:hover {
    background: var(--primary);
    color: white;
}

.security-badge {
    background: linear-gradient(135deg, #f0fdf4, #dcfce7);
    border: 1px solid var(--primary);
    border-radius: 16px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.security-badge i {
    font-size: 2rem;
    color: var(--primary);
}

.security-badge strong {
    display: block;
    color: var(--dark);
    margin-bottom: 0.25rem;
}

.security-badge p {
    margin: 0;
    font-size: 0.875rem;
    color: var(--gray-600);
}

@media (max-width: 1024px) {
    .cart-layout-modern {
        grid-template-columns: 1fr;
    }

    .cart-summary-modern {
        order: -1;
    }
}

@media (max-width: 768px) {
    .cart-item-modern {
        grid-template-columns: 100px 1fr;
        padding: 1rem;
    }

    .cart-item-image {
        width: 100px;
        height: 100px;
    }

    .cart-item-header h3 {
        font-size: 1rem;
    }
}
</style>

<script>
function updateQuantity(btn, change) {
    const form = btn.closest('.quantity-form');
    const input = form.querySelector('.qty-input');
    let value = parseInt(input.value) + change;
    
    if (value < 1) value = 1;
    if (value > 100) value = 100;
    
    input.value = value;
    
    // Submit form
    form.submit();
}
</script>

@endsection

