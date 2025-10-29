@extends('layouts.admin')
@section('title', 'تفاصيل المعاملة')
@section('content')
<div style="padding: 2rem;">
    <a href="{{ route('admin.payments.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--primary); text-decoration: none; font-weight: 700; margin-bottom: 2rem;">
        <i class="fas fa-arrow-right"></i>
        العودة للمدفوعات
    </a>

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <!-- Payment Details -->
        <div style="background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
            <h2 style="font-size: 1.75rem; font-weight: 900; margin-bottom: 2rem; display: flex; align-items: center; gap: 0.75rem;">
                <i class="fas fa-receipt" style="color: var(--primary);"></i>
                تفاصيل المعاملة
            </h2>

            <div style="display: grid; gap: 1.5rem;">
                <div>
                    <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.25rem;">رقم المعاملة</div>
                    <div style="font-size: 1.25rem; font-weight: 700;">{{ $payment->transaction_id }}</div>
                </div>
                <div>
                    <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.25rem;">رقم الطلب</div>
                    <a href="{{ route('admin.orders.show', $payment->order) }}" style="font-size: 1.25rem; font-weight: 700; color: var(--primary); text-decoration: none;">
                        {{ $payment->order->order_number }}
                    </a>
                </div>
                <div>
                    <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.25rem;">العميل</div>
                    <div style="font-size: 1.25rem; font-weight: 700;">{{ $payment->order->user->name ?? 'ضيف' }}</div>
                </div>
                <div>
                    <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.25rem;">المبلغ</div>
                    <div style="font-size: 2rem; font-weight: 900; color: var(--primary);">{{ number_format($payment->amount, 2) }} ر.س</div>
                </div>
                @if($payment->refund_amount)
                <div style="background: #fef2f2; padding: 1.5rem; border-radius: 12px; border-right: 4px solid #ef4444;">
                    <div style="font-size: 0.875rem; color: #991b1b; margin-bottom: 0.25rem; font-weight: 600;">مبلغ الاسترجاع</div>
                    <div style="font-size: 1.5rem; font-weight: 900; color: #ef4444;">{{ number_format($payment->refund_amount, 2) }} ر.س</div>
                    @if($payment->refund_reason)
                    <div style="font-size: 0.875rem; color: #7f1d1d; margin-top: 0.75rem;">
                        <strong>السبب:</strong> {{ $payment->refund_reason }}
                    </div>
                    @endif
                    <div style="font-size: 0.75rem; color: #7f1d1d; margin-top: 0.5rem;">
                        {{ $payment->refunded_at?->format('Y-m-d H:i') }}
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Actions & Status -->
        <div>
            <div style="background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); margin-bottom: 1.5rem;">
                <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 1.5rem;">الإجراءات</h3>
                @if($payment->status === 'completed' && !$payment->refunded_at)
                <button onclick="document.getElementById('refundModal').style.display='flex'" style="width: 100%; background: linear-gradient(135deg, #ef4444, #dc2626); color: white; padding: 1rem; border: none; border-radius: 12px; font-weight: 700; cursor: pointer; font-family: 'Tajawal', sans-serif; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3);">
                    <i class="fas fa-undo" style="margin-left: 0.5rem;"></i>
                    استرجاع المبلغ
                </button>
                @elseif($payment->status === 'refunded')
                <div style="background: #e0e7ff; color: #3730a3; padding: 1rem; border-radius: 12px; text-align: center; font-weight: 700;">
                    <i class="fas fa-check-circle" style="margin-left: 0.5rem;"></i>
                    تم الاسترجاع
                </div>
                @endif
            </div>

            <div style="background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 1.5rem;">معلومات إضافية</h3>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <div>
                        <div style="font-size: 0.875rem; color: var(--gray-600);">طريقة الدفع</div>
                        <div style="font-weight: 700; margin-top: 0.25rem;">
                            @if($payment->payment_method === 'cod')
                                الدفع عند الاستلام
                            @elseif($payment->payment_method === 'moyasar')
                                ميسر
                            @elseif($payment->payment_method === 'applepay')
                                Apple Pay
                            @else
                                {{ $payment->payment_method }}
                            @endif
                        </div>
                    </div>
                    <div>
                        <div style="font-size: 0.875rem; color: var(--gray-600);">الحالة</div>
                        <div style="font-weight: 700; margin-top: 0.25rem;">
                            @if($payment->status === 'completed')
                                <span style="color: #10b981;">✅ مكتمل</span>
                            @elseif($payment->status === 'pending')
                                <span style="color: #f59e0b;">⏳ معلق</span>
                            @elseif($payment->status === 'failed')
                                <span style="color: #ef4444;">❌ فاشل</span>
                            @elseif($payment->status === 'refunded')
                                <span style="color: #6366f1;">🔄 مسترجع</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <div style="font-size: 0.875rem; color: var(--gray-600);">تاريخ الإنشاء</div>
                        <div style="font-weight: 700; margin-top: 0.25rem;">{{ $payment->created_at->format('Y-m-d H:i:s') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Refund Modal -->
<div id="refundModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 10000; align-items: center; justify-content: center;" onclick="if(event.target === this) this.style.display='none'">
    <div style="background: white; padding: 2.5rem; border-radius: 20px; max-width: 500px; width: 90%; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
        <h3 style="font-size: 1.75rem; font-weight: 900; margin-bottom: 1.5rem; color: var(--dark);">
            <i class="fas fa-undo" style="color: #ef4444; margin-left: 0.5rem;"></i>
            استرجاع المبلغ
        </h3>
        <form action="{{ route('admin.payments.refund', $payment) }}" method="POST">
            @csrf
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--dark);">المبلغ</label>
                <input type="number" name="amount" step="0.01" max="{{ $payment->amount }}" value="{{ $payment->amount }}" required style="width: 100%; padding: 1rem; border: 2px solid var(--gray-200); border-radius: 12px; font-size: 1rem; font-family: 'Tajawal', sans-serif;">
                <div style="font-size: 0.875rem; color: var(--gray-600); margin-top: 0.5rem;">الحد الأقصى: {{ number_format($payment->amount, 2) }} ر.س</div>
            </div>
            <div style="margin-bottom: 2rem;">
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--dark);">سبب الاسترجاع</label>
                <textarea name="reason" required rows="4" style="width: 100%; padding: 1rem; border: 2px solid var(--gray-200); border-radius: 12px; font-size: 1rem; resize: vertical; font-family: 'Tajawal', sans-serif;" placeholder="اكتب سبب الاسترجاع..."></textarea>
            </div>
            <div style="display: flex; gap: 1rem;">
                <button type="button" onclick="document.getElementById('refundModal').style.display='none'" style="flex: 1; background: var(--gray-100); color: var(--gray-700); padding: 1rem; border: none; border-radius: 12px; font-weight: 700; cursor: pointer; font-family: 'Tajawal', sans-serif; transition: all 0.3s;" onmouseover="this.style.background='var(--gray-200)'" onmouseout="this.style.background='var(--gray-100)'">
                    إلغاء
                </button>
                <button type="submit" style="flex: 1; background: linear-gradient(135deg, #ef4444, #dc2626); color: white; padding: 1rem; border: none; border-radius: 12px; font-weight: 700; cursor: pointer; font-family: 'Tajawal', sans-serif; box-shadow: 0 4px 15px rgba(239, 68, 68, 0.3); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(239, 68, 68, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(239, 68, 68, 0.3)'">
                    <i class="fas fa-check" style="margin-left: 0.5rem;"></i>
                    تأكيد الاسترجاع
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

