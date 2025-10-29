@extends('layouts.admin')
@section('title', 'إدارة المدفوعات')
@section('content')
<div style="padding: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 900;">
            <i class="fas fa-money-check-alt" style="color: var(--primary); margin-left: 0.5rem;"></i>
            إدارة المدفوعات
        </h1>
        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('admin.payments.dashboard') }}" style="background: var(--primary); color: white; padding: 0.75rem 1.5rem; border-radius: 12px; text-decoration: none; font-weight: 700; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-chart-line"></i>
                لوحة المدفوعات
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div style="background: white; padding: 1.5rem; border-radius: 15px; margin-bottom: 2rem; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <form method="GET" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; align-items: end;">
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem;">الحالة</label>
                <select name="status" style="width: 100%; padding: 0.75rem; border: 2px solid var(--gray-200); border-radius: 10px; font-family: 'Tajawal', sans-serif;">
                    <option value="">الكل</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>مكتمل</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>معلق</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>فاشل</option>
                    <option value="refunded" {{ request('status') == 'refunded' ? 'selected' : '' }}>مسترجع</option>
                </select>
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem;">طريقة الدفع</label>
                <select name="payment_method" style="width: 100%; padding: 0.75rem; border: 2px solid var(--gray-200); border-radius: 10px; font-family: 'Tajawal', sans-serif;">
                    <option value="">الكل</option>
                    <option value="cod" {{ request('payment_method') == 'cod' ? 'selected' : '' }}>الدفع عند الاستلام</option>
                    <option value="moyasar" {{ request('payment_method') == 'moyasar' ? 'selected' : '' }}>ميسر</option>
                    <option value="applepay" {{ request('payment_method') == 'applepay' ? 'selected' : '' }}>Apple Pay</option>
                </select>
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem;">من تاريخ</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" style="width: 100%; padding: 0.75rem; border: 2px solid var(--gray-200); border-radius: 10px;">
            </div>
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600; font-size: 0.875rem;">إلى تاريخ</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" style="width: 100%; padding: 0.75rem; border: 2px solid var(--gray-200); border-radius: 10px;">
            </div>
            <div>
                <button type="submit" style="width: 100%; background: var(--primary); color: white; padding: 0.75rem; border: none; border-radius: 10px; font-weight: 700; cursor: pointer; font-family: 'Tajawal', sans-serif;">
                    <i class="fas fa-filter" style="margin-left: 0.5rem;"></i>
                    فلترة
                </button>
            </div>
        </form>
    </div>

    <!-- Payments Table -->
    <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 2px 15px rgba(0,0,0,0.05);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: linear-gradient(135deg, #f9fafb, #f3f4f6);">
                <tr>
                    <th style="padding: 1rem; text-align: right; font-weight: 800; color: var(--dark); border-bottom: 2px solid var(--gray-200);">رقم المعاملة</th>
                    <th style="padding: 1rem; text-align: right; font-weight: 800; color: var(--dark); border-bottom: 2px solid var(--gray-200);">رقم الطلب</th>
                    <th style="padding: 1rem; text-align: right; font-weight: 800; color: var(--dark); border-bottom: 2px solid var(--gray-200);">العميل</th>
                    <th style="padding: 1rem; text-align: right; font-weight: 800; color: var(--dark); border-bottom: 2px solid var(--gray-200);">المبلغ</th>
                    <th style="padding: 1rem; text-align: right; font-weight: 800; color: var(--dark); border-bottom: 2px solid var(--gray-200);">طريقة الدفع</th>
                    <th style="padding: 1rem; text-align: right; font-weight: 800; color: var(--dark); border-bottom: 2px solid var(--gray-200);">الحالة</th>
                    <th style="padding: 1rem; text-align: right; font-weight: 800; color: var(--dark); border-bottom: 2px solid var(--gray-200);">التاريخ</th>
                    <th style="padding: 1rem; text-align: center; font-weight: 800; color: var(--dark); border-bottom: 2px solid var(--gray-200);">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr style="border-bottom: 1px solid var(--gray-100); transition: background 0.2s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='white'">
                    <td style="padding: 1rem; font-weight: 600; color: var(--gray-700);">{{ $payment->transaction_id }}</td>
                    <td style="padding: 1rem;">
                        <a href="{{ route('admin.orders.show', $payment->order) }}" style="color: var(--primary); font-weight: 700; text-decoration: none;">
                            {{ $payment->order->order_number }}
                        </a>
                    </td>
                    <td style="padding: 1rem; font-weight: 600;">{{ $payment->order->user->name ?? 'ضيف' }}</td>
                    <td style="padding: 1rem; font-weight: 800; color: var(--primary);">{{ number_format($payment->amount, 2) }} ر.س</td>
                    <td style="padding: 1rem;">
                        @if($payment->payment_method === 'cod')
                            <span style="background: #fef3c7; color: #92400e; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.875rem; font-weight: 700;">
                                <i class="fas fa-hand-holding-usd" style="margin-left: 0.25rem;"></i> الدفع عند الاستلام
                            </span>
                        @elseif($payment->payment_method === 'moyasar')
                            <span style="background: #dbeafe; color: #1e40af; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.875rem; font-weight: 700;">
                                <i class="fas fa-credit-card" style="margin-left: 0.25rem;"></i> ميسر
                            </span>
                        @elseif($payment->payment_method === 'applepay')
                            <span style="background: #f3f4f6; color: #374151; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.875rem; font-weight: 700;">
                                <i class="fab fa-apple-pay" style="margin-left: 0.25rem;"></i> Apple Pay
                            </span>
                        @else
                            <span style="background: #f3f4f6; color: #6b7280; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.875rem; font-weight: 700;">{{ $payment->payment_method }}</span>
                        @endif
                    </td>
                    <td style="padding: 1rem;">
                        @if($payment->status === 'completed')
                            <span style="background: #d1fae5; color: #065f46; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.875rem; font-weight: 700;">
                                <i class="fas fa-check-circle" style="margin-left: 0.25rem;"></i> مكتمل
                            </span>
                        @elseif($payment->status === 'pending')
                            <span style="background: #fef3c7; color: #92400e; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.875rem; font-weight: 700;">
                                <i class="fas fa-clock" style="margin-left: 0.25rem;"></i> معلق
                            </span>
                        @elseif($payment->status === 'failed')
                            <span style="background: #fee2e2; color: #991b1b; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.875rem; font-weight: 700;">
                                <i class="fas fa-times-circle" style="margin-left: 0.25rem;"></i> فاشل
                            </span>
                        @elseif($payment->status === 'refunded')
                            <span style="background: #e0e7ff; color: #3730a3; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.875rem; font-weight: 700;">
                                <i class="fas fa-undo" style="margin-left: 0.25rem;"></i> مسترجع
                            </span>
                        @endif
                    </td>
                    <td style="padding: 1rem; color: var(--gray-600); font-size: 0.875rem;">{{ $payment->created_at->format('Y-m-d H:i') }}</td>
                    <td style="padding: 1rem; text-align: center;">
                        <a href="{{ route('admin.payments.show', $payment) }}" style="background: var(--primary); color: white; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; font-size: 0.875rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-eye"></i>
                            التفاصيل
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="padding: 3rem; text-align: center; color: var(--gray-500);">
                        <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; display: block; opacity: 0.3;"></i>
                        لا توجد مدفوعات
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="margin-top: 2rem;">
        {{ $payments->links() }}
    </div>
</div>
@endsection
