@extends('layouts.app')

@section('title', 'تم الطلب بنجاح')

@section('content')
<div class="container" style="padding-top: 3rem; padding-bottom: 4rem;">
    <div style="max-width: 700px; margin: 0 auto;">
        <!-- Success Animation -->
        <div style="text-align: center; margin-bottom: 3rem;">
            <div style="width: 140px; height: 140px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem; box-shadow: 0 12px 30px rgba(16,185,129,0.3); animation: successPulse 2s infinite;">
                <i class="fas fa-check" style="font-size: 4.5rem; color: white;"></i>
            </div>
            
            <h1 style="font-size: 2.5rem; font-weight: 900; color: var(--dark); margin-bottom: 1rem;">
                🎉 تم استلام طلبك بنجاح!
            </h1>
            
            <p style="font-size: 1.125rem; color: var(--gray-600); line-height: 1.8; margin-bottom: 0;">
                شكراً لك! تم استلام طلبك وجاري معالجته
            </p>
        </div>

        @if($order)
        <!-- Order Details -->
        <div style="background: white; padding: 2.5rem; border-radius: 20px; box-shadow: 0 8px 24px rgba(0,0,0,0.08); border: 2px solid var(--primary-light); margin-bottom: 2rem;">
            <!-- Order Number -->
            <div style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem; text-align: center;">
                <div style="font-size: 0.875rem; opacity: 0.9; margin-bottom: 0.5rem;">رقم الطلب</div>
                <div style="font-size: 2rem; font-weight: 900; letter-spacing: 2px;">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
            </div>

            <!-- Order Info -->
            <div style="display: grid; gap: 1.5rem; margin-bottom: 2rem;">
                <div style="display: flex; align-items: start; gap: 1rem; padding: 1.25rem; background: var(--gray-50); border-radius: 12px;">
                    <div style="width: 40px; height: 40px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fas fa-calendar" style="color: white;"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: 700; color: var(--dark); margin-bottom: 0.25rem;">تاريخ الطلب</div>
                        <div style="color: var(--gray-600);">{{ $order->created_at->format('Y-m-d h:i A') }}</div>
                    </div>
                </div>

                <div style="display: flex; align-items: start; gap: 1rem; padding: 1.25rem; background: var(--gray-50); border-radius: 12px;">
                    <div style="width: 40px; height: 40px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fas fa-money-bill-wave" style="color: white;"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: 700; color: var(--dark); margin-bottom: 0.25rem;">طريقة الدفع</div>
                        <div style="color: var(--gray-600);">
                            {{ $order->payment_method === 'cod' ? 'الدفع عند الاستلام' : 'الدفع الإلكتروني' }}
                        </div>
                    </div>
                </div>

                <div style="display: flex; align-items: start; gap: 1rem; padding: 1.25rem; background: var(--gray-50); border-radius: 12px;">
                    <div style="width: 40px; height: 40px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fas fa-box" style="color: white;"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: 700; color: var(--dark); margin-bottom: 0.25rem;">حالة الطلب</div>
                        <div>
                            <span style="background: var(--primary); color: white; padding: 0.375rem 0.875rem; border-radius: 20px; font-size: 0.875rem; font-weight: 700;">
                                قيد المعالجة
                            </span>
                        </div>
                    </div>
                </div>

                <div style="display: flex; align-items: start; gap: 1rem; padding: 1.25rem; background: var(--gray-50); border-radius: 12px;">
                    <div style="width: 40px; height: 40px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                        <i class="fas fa-dollar-sign" style="color: white;"></i>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-weight: 700; color: var(--dark); margin-bottom: 0.25rem;">إجمالي المبلغ</div>
                        <div style="color: var(--primary); font-size: 1.5rem; font-weight: 900;">
                            {{ number_format($order->total, 2) }} ر.س
                        </div>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div style="background: linear-gradient(135deg, #fef3c7, #fde68a); border: 2px solid #f59e0b; border-radius: 12px; padding: 1.5rem;">
                <div style="display: flex; align-items: start; gap: 1rem;">
                    <i class="fas fa-info-circle" style="font-size: 1.5rem; color: #d97706; margin-top: 0.125rem;"></i>
                    <div>
                        <h4 style="font-weight: 800; color: #92400e; font-size: 1rem; margin-bottom: 0.75rem;">ما التالي؟</h4>
                        <ul style="margin: 0; padding-right: 1.25rem; color: #78350f; line-height: 1.8;">
                            <li>سيتم التواصل معك خلال 24 ساعة لتأكيد الطلب</li>
                            <li>يمكنك متابعة حالة طلبك من قسم "طلباتي"</li>
                            <li>سيتم إشعارك عند شحن الطلب</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Action Buttons -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            @auth
            <a href="{{ route('profile.orders') }}" class="btn" style="padding: 1.25rem; font-size: 1.0625rem; justify-content: center; background: linear-gradient(135deg, var(--primary), var(--primary-dark));">
                <i class="fas fa-list"></i>
                طلباتي
            </a>
            @endauth
            
            <a href="{{ route('products.index') }}" class="btn" style="padding: 1.25rem; font-size: 1.0625rem; justify-content: center; background: linear-gradient(135deg, #3b82f6, #2563eb);">
                <i class="fas fa-shopping-basket"></i>
                متابعة التسوق
            </a>
        </div>

        <div style="text-align: center; margin-top: 2rem;">
            <a href="{{ route('home') }}" style="color: var(--gray-600); text-decoration: none; font-weight: 600; transition: all 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--gray-600)'">
                <i class="fas fa-home" style="margin-left: 0.25rem;"></i>
                العودة للرئيسية
            </a>
        </div>
    </div>
</div>

<style>
@keyframes successPulse {
    0%, 100% {
        transform: scale(1);
        box-shadow: 0 12px 30px rgba(16,185,129,0.3);
    }
    50% {
        transform: scale(1.05);
        box-shadow: 0 16px 40px rgba(16,185,129,0.4);
    }
}
</style>
@endsection
