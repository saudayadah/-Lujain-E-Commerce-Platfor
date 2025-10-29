@extends('layouts.app')
@section('title', 'الشحن والتوصيل - لُجين الزراعية')
@section('content')
<div style="background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%); padding: 4rem 0 2rem;">
    <div class="container">
        <div style="text-align: center; max-width: 800px; margin: 0 auto;">
            <h1 style="font-size: 2.5rem; font-weight: 900; margin-bottom: 1rem;">الشحن والتوصيل</h1>
            <p style="font-size: 1.25rem; color: var(--gray-600);">نوصل لك أينما كنت في المملكة</p>
        </div>
    </div>
</div>
<div class="container" style="padding: 4rem 0; max-width: 900px;">
    <div style="background: white; padding: 3rem; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.08);">
        <div style="background: linear-gradient(135deg, #dcfce7, #bbf7d0); padding: 2.5rem; border-radius: 20px; margin-bottom: 3rem; text-align: center; border: 2px solid var(--primary);">
            <i class="fas fa-shipping-fast" style="font-size: 4rem; color: var(--primary); margin-bottom: 1rem;"></i>
            <h2 style="font-size: 2rem; font-weight: 900; margin-bottom: 0.5rem; color: var(--primary-dark);">شحن مجاني</h2>
            <p style="font-size: 1.25rem; color: #065f46; line-height: 1.8;">على جميع الطلبات فوق 200 ريال</p>
        </div>
        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 1.5rem; color: var(--primary);">
                <i class="fas fa-truck" style="margin-left: 0.5rem;"></i>مناطق التوصيل
            </h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                <div style="background: linear-gradient(135deg, #f0fdf4, #dcfce7); padding: 1.75rem; border-radius: 15px; border: 2px solid var(--primary-light);">
                    <i class="fas fa-map-marked-alt" style="font-size: 2rem; color: var(--primary); margin-bottom: 1rem;"></i>
                    <h3 style="font-weight: 800; font-size: 1.25rem; margin-bottom: 0.5rem;">الرياض</h3>
                    <p style="color: var(--gray-600);">التوصيل خلال 24 ساعة</p>
                </div>
                <div style="background: linear-gradient(135deg, #dbeafe, #bfdbfe); padding: 1.75rem; border-radius: 15px; border: 2px solid #93c5fd;">
                    <i class="fas fa-city" style="font-size: 2rem; color: #3b82f6; margin-bottom: 1rem;"></i>
                    <h3 style="font-weight: 800; font-size: 1.25rem; margin-bottom: 0.5rem;">المدن الرئيسية</h3>
                    <p style="color: var(--gray-600);">التوصيل خلال 2-3 أيام</p>
                </div>
                <div style="background: linear-gradient(135deg, #fef3c7, #fde68a); padding: 1.75rem; border-radius: 15px; border: 2px solid #fbbf24;">
                    <i class="fas fa-globe-asia" style="font-size: 2rem; color: #f59e0b; margin-bottom: 1rem;"></i>
                    <h3 style="font-weight: 800; font-size: 1.25rem; margin-bottom: 0.5rem;">باقي المناطق</h3>
                    <p style="color: var(--gray-600);">التوصيل خلال 3-5 أيام</p>
                </div>
            </div>
        </div>
        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 1.5rem; color: var(--primary);">
                <i class="fas fa-dollar-sign" style="margin-left: 0.5rem;"></i>رسوم الشحن
            </h2>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1.5rem; background: #f9fafb; border-radius: 12px; border-right: 3px solid var(--primary);">
                    <span style="font-weight: 700; color: var(--dark);">الطلبات فوق 200 ريال</span>
                    <span style="font-weight: 900; font-size: 1.25rem; color: var(--primary);">مجاناً</span>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1.5rem; background: #f9fafb; border-radius: 12px; border-right: 3px solid #3b82f6;">
                    <span style="font-weight: 700; color: var(--dark);">الطلبات أقل من 200 ريال</span>
                    <span style="font-weight: 900; font-size: 1.25rem; color: #3b82f6;">30 ريال</span>
                </div>
            </div>
        </div>
        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 1.5rem; color: var(--primary);">
                <i class="fas fa-clipboard-list" style="margin-left: 0.5rem;"></i>تتبع طلبك
            </h2>
            <p style="color: var(--gray-600); line-height: 1.9; font-size: 1.05rem; margin-bottom: 1.5rem;">يمكنك تتبع حالة طلبك في أي وقت من خلال:</p>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
                <div style="display: flex; align-items: center; gap: 1rem; padding: 1.25rem; background: linear-gradient(135deg, #f0fdf4, #dcfce7); border-radius: 12px;">
                    <i class="fas fa-user-circle" style="font-size: 2rem; color: var(--primary);"></i>
                    <span style="font-weight: 600; color: var(--gray-700);">حسابي</span>
                </div>
                <div style="display: flex; align-items: center; gap: 1rem; padding: 1.25rem; background: linear-gradient(135deg, #dbeafe, #bfdbfe); border-radius: 12px;">
                    <i class="fas fa-envelope-open-text" style="font-size: 2rem; color: #3b82f6;"></i>
                    <span style="font-weight: 600; color: var(--gray-700);">البريد الإلكتروني</span>
                </div>
                <div style="display: flex; align-items: center; gap: 1rem; padding: 1.25rem; background: linear-gradient(135deg, #fef3c7, #fde68a); border-radius: 12px;">
                    <i class="fas fa-sms" style="font-size: 2rem; color: #f59e0b;"></i>
                    <span style="font-weight: 600; color: var(--gray-700);">رسائل SMS</span>
                </div>
            </div>
        </div>
        <div style="background: linear-gradient(135deg, #e0e7ff, #c7d2fe); padding: 2rem; border-radius: 15px; border-right: 4px solid #6366f1;">
            <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 1rem; color: #3730a3;">
                <i class="fas fa-info-circle" style="margin-left: 0.5rem;"></i>ملاحظات هامة
            </h3>
            <ul style="list-style: none; padding: 0; display: flex; flex-direction: column; gap: 0.75rem; color: #3730a3;">
                <li style="display: flex; align-items: start; gap: 0.5rem;">
                    <i class="fas fa-check" style="margin-top: 0.25rem; flex-shrink: 0;"></i>
                    <span>يرجى التأكد من صحة عنوان الشحن ورقم الجوال</span>
                </li>
                <li style="display: flex; align-items: start; gap: 0.5rem;">
                    <i class="fas fa-check" style="margin-top: 0.25rem; flex-shrink: 0;"></i>
                    <span>سيتم الاتصال بك قبل التوصيل لتحديد الوقت المناسب</span>
                </li>
                <li style="display: flex; align-items: start; gap: 0.5rem;">
                    <i class="fas fa-check" style="margin-top: 0.25rem; flex-shrink: 0;"></i>
                    <span>في حالة عدم تواجدك، سيتم ترك إشعار لإعادة التوصيل</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
