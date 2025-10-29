@extends('layouts.app')
@section('title', 'سياسة الخصوصية - لُجين الزراعية')
@section('content')
<div style="background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%); padding: 4rem 0 2rem;">
    <div class="container">
        <div style="text-align: center; max-width: 800px; margin: 0 auto;">
            <h1 style="font-size: 2.5rem; font-weight: 900; margin-bottom: 1rem;">سياسة الخصوصية</h1>
            <p style="font-size: 1.25rem; color: var(--gray-600);">نحن نحترم خصوصيتك ونحمي بياناتك</p>
        </div>
    </div>
</div>
<div class="container" style="padding: 4rem 0; max-width: 900px;">
    <div style="background: white; padding: 3rem; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.08);">
        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 1rem; color: var(--primary);">
                <i class="fas fa-shield-alt" style="margin-left: 0.5rem;"></i>جمع المعلومات
            </h2>
            <p style="color: var(--gray-600); line-height: 1.9; font-size: 1.05rem;">نقوم بجمع المعلومات التي تقدمها لنا عند التسجيل في الموقع أو عند تقديم طلب. قد تشمل هذه المعلومات: الاسم، عنوان البريد الإلكتروني، رقم الهاتف، عنوان الشحن.</p>
        </div>
        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 1rem; color: var(--primary);">
                <i class="fas fa-database" style="margin-left: 0.5rem;"></i>استخدام المعلومات
            </h2>
            <p style="color: var(--gray-600); line-height: 1.9; font-size: 1.05rem; margin-bottom: 1rem;">نستخدم المعلومات التي نجمعها منك للأغراض التالية:</p>
            <ul style="list-style: none; padding: 0; display: flex; flex-direction: column; gap: 0.75rem;">
                <li style="display: flex; align-items: start; gap: 0.75rem; padding: 1rem; background: #f0fdf4; border-radius: 10px;">
                    <i class="fas fa-check-circle" style="color: var(--primary); margin-top: 0.25rem;"></i>
                    <span style="color: var(--gray-700); line-height: 1.7;">معالجة الطلبات وتسليم المنتجات</span>
                </li>
                <li style="display: flex; align-items: start; gap: 0.75rem; padding: 1rem; background: #f0fdf4; border-radius: 10px;">
                    <i class="fas fa-check-circle" style="color: var(--primary); margin-top: 0.25rem;"></i>
                    <span style="color: var(--gray-700); line-height: 1.7;">تحسين خدماتنا وتجربة المستخدم</span>
                </li>
                <li style="display: flex; align-items: start; gap: 0.75rem; padding: 1rem; background: #f0fdf4; border-radius: 10px;">
                    <i class="fas fa-check-circle" style="color: var(--primary); margin-top: 0.25rem;"></i>
                    <span style="color: var(--gray-700); line-height: 1.7;">إرسال إشعارات وعروض خاصة (يمكنك إلغاء الاشتراك في أي وقت)</span>
                </li>
                <li style="display: flex; align-items: start; gap: 0.75rem; padding: 1rem; background: #f0fdf4; border-radius: 10px;">
                    <i class="fas fa-check-circle" style="color: var(--primary); margin-top: 0.25rem;"></i>
                    <span style="color: var(--gray-700); line-height: 1.7;">التواصل معك بخصوص طلباتك</span>
                </li>
            </ul>
        </div>
        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 1rem; color: var(--primary);">
                <i class="fas fa-lock" style="margin-left: 0.5rem;"></i>حماية المعلومات
            </h2>
            <p style="color: var(--gray-600); line-height: 1.9; font-size: 1.05rem;">نحن نستخدم مجموعة متنوعة من الإجراءات الأمنية للحفاظ على سلامة معلوماتك الشخصية. جميع المعاملات المالية تتم عبر بوابة دفع آمنة ولا يتم تخزين معلومات بطاقتك الائتمانية على خوادمنا.</p>
        </div>
        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 1rem; color: var(--primary);">
                <i class="fas fa-share-alt" style="margin-left: 0.5rem;"></i>مشاركة المعلومات
            </h2>
            <p style="color: var(--gray-600); line-height: 1.9; font-size: 1.05rem;">نحن لا نبيع أو نؤجر أو نشارك معلوماتك الشخصية مع أطراف ثالثة لأغراض تسويقية. قد نشارك معلوماتك فقط مع شركات الشحن لتوصيل طلباتك.</p>
        </div>
        <div style="background: linear-gradient(135deg, #dbeafe, #e0f2fe); padding: 2rem; border-radius: 15px; border-right: 4px solid #3b82f6;">
            <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 1rem; color: #1e40af;">
                <i class="fas fa-info-circle" style="margin-left: 0.5rem;"></i>حقوقك
            </h3>
            <p style="color: #1e3a8a; line-height: 1.8;">يمكنك في أي وقت طلب الاطلاع على بياناتك أو تعديلها أو حذفها من خلال الاتصال بنا عبر صفحة اتصل بنا.</p>
        </div>
    </div>
</div>
@endsection
