@extends('layouts.app')
@section('title', 'الشروط والأحكام - لُجين الزراعية')
@section('content')
<div style="background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%); padding: 4rem 0 2rem;">
    <div class="container">
        <div style="text-align: center; max-width: 800px; margin: 0 auto;">
            <h1 style="font-size: 2.5rem; font-weight: 900; margin-bottom: 1rem;">الشروط والأحكام</h1>
            <p style="font-size: 1.25rem; color: var(--gray-600);">شروط استخدام متجرنا الإلكتروني</p>
        </div>
    </div>
</div>
<div class="container" style="padding: 4rem 0; max-width: 900px;">
    <div style="background: white; padding: 3rem; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.08);">
        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 1rem; color: var(--primary);">
                <i class="fas fa-shopping-cart" style="margin-left: 0.5rem;"></i>شروط الشراء
            </h2>
            <p style="color: var(--gray-600); line-height: 1.9; font-size: 1.05rem;">باستخدامك لهذا الموقع، فإنك توافق على الالتزام بهذه الشروط والأحكام. يجب أن تكون بالغاً من العمر 18 عاماً على الأقل لإجراء عمليات الشراء على موقعنا.</p>
        </div>
        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 1rem; color: var(--primary);">
                <i class="fas fa-tags" style="margin-left: 0.5rem;"></i>الأسعار والدفع
            </h2>
            <ul style="list-style: none; padding: 0; display: flex; flex-direction: column; gap: 0.75rem;">
                <li style="display: flex; align-items: start; gap: 0.75rem; padding: 1rem; background: #f0fdf4; border-radius: 10px;">
                    <i class="fas fa-check-circle" style="color: var(--primary); margin-top: 0.25rem;"></i>
                    <span style="color: var(--gray-700); line-height: 1.7;">جميع الأسعار مدرجة بالريال السعودي وتشمل ضريبة القيمة المضافة</span>
                </li>
                <li style="display: flex; align-items: start; gap: 0.75rem; padding: 1rem; background: #f0fdf4; border-radius: 10px;">
                    <i class="fas fa-check-circle" style="color: var(--primary); margin-top: 0.25rem;"></i>
                    <span style="color: var(--gray-700); line-height: 1.7;">نحتفظ بالحق في تغيير الأسعار في أي وقت</span>
                </li>
                <li style="display: flex; align-items: start; gap: 0.75rem; padding: 1rem; background: #f0fdf4; border-radius: 10px;">
                    <i class="fas fa-check-circle" style="color: var(--primary); margin-top: 0.25rem;"></i>
                    <span style="color: var(--gray-700); line-height: 1.7;">الدفع عند الاستلام أو عبر بطاقات مدى، فيزا، ماستركارد، أو Apple Pay</span>
                </li>
            </ul>
        </div>
        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 1rem; color: var(--primary);">
                <i class="fas fa-box" style="margin-left: 0.5rem;"></i>توفر المنتجات
            </h2>
            <p style="color: var(--gray-600); line-height: 1.9; font-size: 1.05rem;">نبذل قصارى جهدنا لضمان توفر جميع المنتجات المعروضة. في حالة نفاد المخزون، سنقوم بإبلاغك فوراً وتقديم بديل مناسب أو استرداد كامل المبلغ.</p>
        </div>
        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 1rem; color: var(--primary);">
                <i class="fas fa-ban" style="margin-left: 0.5rem;"></i>إلغاء الطلبات
            </h2>
            <p style="color: var(--gray-600); line-height: 1.9; font-size: 1.05rem;">يمكنك إلغاء طلبك قبل شحنه دون أي رسوم. بعد الشحن، يُرجى الاطلاع على سياسة الاسترجاع الخاصة بنا.</p>
        </div>
        <div style="background: linear-gradient(135deg, #fef3c7, #fde68a); padding: 2rem; border-radius: 15px; border-right: 4px solid #f59e0b;">
            <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 1rem; color: #92400e;">
                <i class="fas fa-exclamation-triangle" style="margin-left: 0.5rem;"></i>تنبيه مهم
            </h3>
            <p style="color: #78350f; line-height: 1.8;">نحتفظ بالحق في رفض أو إلغاء أي طلب في حالة الاشتباه بنشاط احتيالي أو انتهاك للشروط والأحكام.</p>
        </div>
    </div>
</div>
@endsection
