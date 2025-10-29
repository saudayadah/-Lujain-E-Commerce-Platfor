@extends('layouts.admin')
@section('title', 'لوحة المدفوعات')
@section('content')
<div style="padding: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 style="font-size: 2rem; font-weight: 900; color: var(--dark); margin-bottom: 0.5rem;">
                <i class="fas fa-credit-card" style="color: var(--primary); margin-left: 0.5rem;"></i>
                لوحة المدفوعات
            </h1>
            <p style="color: var(--gray-600);">إحصائيات وتقارير المدفوعات الشاملة</p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('admin.payments.index') }}" style="background: white; border: 2px solid var(--primary); color: var(--primary); padding: 0.75rem 1.5rem; border-radius: 12px; text-decoration: none; font-weight: 700; transition: all 0.3s; display: flex; align-items: center; gap: 0.5rem;" onmouseover="this.style.background='var(--primary)'; this.style.color='white'" onmouseout="this.style.background='white'; this.style.color='var(--primary)'">
                <i class="fas fa-list"></i>
                جميع المدفوعات
            </a>
            <a href="{{ route('admin.payments.export') }}" style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 0.75rem 1.5rem; border-radius: 12px; text-decoration: none; font-weight: 700; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3); display: flex; align-items: center; gap: 0.5rem;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
                <i class="fas fa-download"></i>
                تصدير التقرير
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 3rem;">
        <div style="background: linear-gradient(135deg, #10b981, #059669); padding: 2rem; border-radius: 20px; color: white; box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 1rem;">
                <div>
                    <div style="font-size: 0.875rem; opacity: 0.9; margin-bottom: 0.5rem;">إجمالي الإيرادات</div>
                    <div style="font-size: 2.5rem; font-weight: 900;">{{ number_format($stats['total_revenue'], 2) }}</div>
                    <div style="font-size: 0.875rem; opacity: 0.8;">ريال سعودي</div>
                </div>
                <div style="width: 60px; height: 60px; background: rgba(255,255,255,0.2); border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-coins" style="font-size: 2rem;"></i>
                </div>
            </div>
        </div>

        <div style="background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border: 2px solid #dbeafe;">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.5rem;">إيرادات اليوم</div>
                    <div style="font-size: 2rem; font-weight: 900; color: #3b82f6;">{{ number_format($stats['today_revenue'], 2) }}</div>
                    <div style="font-size: 0.875rem; color: var(--gray-600);">ريال</div>
                </div>
                <div style="width: 55px; height: 55px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white;">
                    <i class="fas fa-calendar-day" style="font-size: 1.5rem;"></i>
                </div>
            </div>
        </div>

        <div style="background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border: 2px solid #fef3c7;">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.5rem;">إيرادات الشهر</div>
                    <div style="font-size: 2rem; font-weight: 900; color: #f59e0b;">{{ number_format($stats['this_month_revenue'], 2) }}</div>
                    <div style="font-size: 0.875rem; color: var(--gray-600);">ريال</div>
                </div>
                <div style="width: 55px; height: 55px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white;">
                    <i class="fas fa-calendar-alt" style="font-size: 1.5rem;"></i>
                </div>
            </div>
        </div>

        <div style="background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); border: 2px solid #e0e7ff;">
            <div style="display: flex; justify-content: space-between; align-items: start;">
                <div>
                    <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.5rem;">نسبة النجاح</div>
                    <div style="font-size: 2rem; font-weight: 900; color: #6366f1;">{{ number_format($stats['success_rate'], 1) }}%</div>
                    <div style="font-size: 0.875rem; color: var(--gray-600);">من {{ $stats['total_transactions'] }} معاملة</div>
                </div>
                <div style="width: 55px; height: 55px; background: linear-gradient(135deg, #6366f1, #4f46e5); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: white;">
                    <i class="fas fa-chart-line" style="font-size: 1.5rem;"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment Methods Distribution -->
    <div style="background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); margin-bottom: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1.5rem; color: var(--dark);">
            <i class="fas fa-chart-pie" style="color: var(--primary); margin-left: 0.5rem;"></i>
            توزيع طرق الدفع
        </h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
            @foreach($paymentMethodsStats as $method)
            <div style="background: linear-gradient(135deg, #f9fafb, #f3f4f6); padding: 1.5rem; border-radius: 15px; border-right: 4px solid var(--primary);">
                <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.5rem; font-weight: 600;">
                    @if($method->payment_method === 'cod')
                        <i class="fas fa-hand-holding-usd" style="margin-left: 0.5rem;"></i> الدفع عند الاستلام
                    @elseif($method->payment_method === 'moyasar')
                        <i class="fas fa-credit-card" style="margin-left: 0.5rem;"></i> ميسر
                    @elseif($method->payment_method === 'applepay')
                        <i class="fab fa-apple-pay" style="margin-left: 0.5rem;"></i> Apple Pay
                    @else
                        {{ $method->payment_method }}
                    @endif
                </div>
                <div style="font-size: 1.75rem; font-weight: 900; color: var(--primary); margin-bottom: 0.25rem;">{{ number_format($method->total, 0) }}</div>
                <div style="font-size: 0.875rem; color: var(--gray-600);">{{ $method->count }} معاملة</div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Quick Stats -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div style="background: white; padding: 1.75rem; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.06); border-right: 4px solid #10b981;">
            <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.5rem; font-weight: 600;">المدفوعات الناجحة</div>
            <div style="font-size: 2rem; font-weight: 900; color: #10b981;">{{ $stats['successful_payments'] }}</div>
        </div>
        <div style="background: white; padding: 1.75rem; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.06); border-right: 4px solid #ef4444;">
            <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.5rem; font-weight: 600;">المدفوعات الفاشلة</div>
            <div style="font-size: 2rem; font-weight: 900; color: #ef4444;">{{ $stats['failed_payments'] }}</div>
        </div>
        <div style="background: white; padding: 1.75rem; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.06); border-right: 4px solid #f59e0b;">
            <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.5rem; font-weight: 600;">المدفوعات المعلقة</div>
            <div style="font-size: 2rem; font-weight: 900; color: #f59e0b;">{{ $stats['pending_payments'] }}</div>
        </div>
        <div style="background: white; padding: 1.75rem; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.06); border-right: 4px solid #8b5cf6;">
            <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.5rem; font-weight: 600;">متوسط قيمة المعاملة</div>
            <div style="font-size: 2rem; font-weight: 900; color: #8b5cf6;">{{ number_format($stats['avg_transaction_value'], 0) }} ر.س</div>
        </div>
    </div>
</div>
@endsection
