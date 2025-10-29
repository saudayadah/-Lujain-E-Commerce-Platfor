@extends('layouts.app')

@section('title', app()->getLocale() == 'ar' ? 'تم إلغاء الطلب' : 'Order Cancelled')

@section('content')
<div style="text-align: center; padding: 5rem 2rem; background: white; border-radius: 20px; box-shadow: var(--shadow-xl);">
    <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #ffc107, #ff9800); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem;">
        <i class="fas fa-exclamation-triangle" style="font-size: 4rem; color: white;"></i>
    </div>
    
    <h1 style="font-size: 2.5rem; font-weight: 900; color: var(--dark-green); margin-bottom: 1rem;">
        {{ app()->getLocale() == 'ar' ? 'تم إلغاء الطلب' : 'Order Cancelled' }}
    </h1>
    
    <p style="font-size: 1.2rem; color: var(--text-light); margin-bottom: 3rem;">
        {{ app()->getLocale() == 'ar' ? 'تم إلغاء عملية الدفع. يمكنك المحاولة مرة أخرى.' : 'Payment was cancelled. You can try again.' }}
    </p>
    
    <div style="display: flex; gap: 1rem; justify-content: center;">
        <a href="{{ route('cart.index') }}" class="btn">
            <i class="fas fa-shopping-cart"></i> {{ app()->getLocale() == 'ar' ? 'العودة للسلة' : 'Back to Cart' }}
        </a>
        <a href="{{ route('products.index') }}" class="btn-outline btn">
            <i class="fas fa-shopping-basket"></i> {{ app()->getLocale() == 'ar' ? 'متابعة التسوق' : 'Continue Shopping' }}
        </a>
    </div>
</div>
@endsection

