@extends('layouts.app')
@section('title', 'سياسة الاسترجاع والاستبدال - لُجين الزراعية')
@section('content')
<div style="background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%); padding: 4rem 0 2rem;">
    <div class="container">
        <div style="text-align: center; max-width: 800px; margin: 0 auto;">
            <h1 style="font-size: 2.5rem; font-weight: 900; margin-bottom: 1rem;">سياسة الاسترجاع والاستبدال</h1>
            <p style="font-size: 1.25rem; color: var(--gray-600);">رضاك يهمنا - إرجاع واستبدال سهل</p>
        </div>
    </div>
</div>
<div class="container" style="padding: 4rem 0; max-width: 900px;">
    <div style="background: white; padding: 3rem; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.08);">
        <div style="background: linear-gradient(135deg, #dcfce7, #bbf7d0); padding: 2rem; border-radius: 15px; margin-bottom: 2.5rem; border: 2px solid var(--primary);">
            <h2 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1rem; color: var(--primary-dark); display: flex; align-items: center; gap: 0.75rem;">
                <i class="fas fa-clock"></i>
                ضمان استرجاع لمدة 7 أيام
            </h2>
            <p style="color: #065f46; line-height: 1.8; font-size: 1.05rem;">نوفر لك فترة 7 أيام من تاريخ استلام المنتج لإرجاعه أو استبداله إذا لم يكن مطابقاً للمواصفات أو في حالة وجود عيب.</p>
        </div>
        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 1.5rem; color: var(--primary);">
                <i class="fas fa-list-check" style="margin-left: 0.5rem;"></i>شروط الاسترجاع
            </h2>
            <ul style="list-style: none; padding: 0; display: flex; flex-direction: column; gap: 1rem;">
                <li style="display: flex; align-items: start; gap: 1rem; padding: 1.25rem; background: #f9fafb; border-radius: 12px; border-right: 3px solid var(--primary);">
                    <div style="width: 35px; height: 35px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: white; font-weight: bold;">1</div>
                    <span style="color: var(--gray-700); line-height: 1.8; font-weight: 500;">أن يكون المنتج في حالته الأصلية دون استخدام</span>
                </li>
                <li style="display: flex; align-items: start; gap: 1rem; padding: 1.25rem; background: #f9fafb; border-radius: 12px; border-right: 3px solid var(--primary);">
                    <div style="width: 35px; height: 35px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: white; font-weight: bold;">2</div>
                    <span style="color: var(--gray-700); line-height: 1.8; font-weight: 500;">الاحتفاظ بالعبوة والتغليف الأصلي</span>
                </li>
                <li style="display: flex; align-items: start; gap: 1rem; padding: 1.25rem; background: #f9fafb; border-radius: 12px; border-right: 3px solid var(--primary);">
                    <div style="width: 35px; height: 35px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: white; font-weight: bold;">3</div>
                    <span style="color: var(--gray-700); line-height: 1.8; font-weight: 500;">تقديم فاتورة الشراء أو رقم الطلب</span>
                </li>
                <li style="display: flex; align-items: start; gap: 1rem; padding: 1.25rem; background: #f9fafb; border-radius: 12px; border-right: 3px solid var(--primary);">
                    <div style="width: 35px; height: 35px; background: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; color: white; font-weight: bold;">4</div>
                    <span style="color: var(--gray-700); line-height: 1.8; font-weight: 500;">الإرجاع خلال 7 أيام من تاريخ الاستلام</span>
                </li>
            </ul>
        </div>
        <div style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.75rem; font-weight: 800; margin-bottom: 1rem; color: var(--primary);">
                <i class="fas fa-exchange-alt" style="margin-left: 0.5rem;"></i>خطوات الاسترجاع
            </h2>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div style="display: flex; align-items: start; gap: 1rem;">
                    <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);">
                        <i class="fas fa-phone" style="color: white;"></i>
                    </div>
                    <div style="flex: 1;">
                        <h3 style="font-weight: 700; font-size: 1.125rem; margin-bottom: 0.25rem;">اتصل بخدمة العملاء</h3>
                        <p style="color: var(--gray-600); line-height: 1.7;">تواصل معنا على +966 50 000 0000 أو عبر البريد الإلكتروني</p>
                    </div>
                </div>
                <div style="display: flex; align-items: start; gap: 1rem;">
                    <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);">
                        <i class="fas fa-box" style="color: white;"></i>
                    </div>
                    <div style="flex: 1;">
                        <h3 style="font-weight: 700; font-size: 1.125rem; margin-bottom: 0.25rem;">تجهيز المنتج</h3>
                        <p style="color: var(--gray-600); line-height: 1.7;">قم بتغليف المنتج بشكل جيد في العبوة الأصلية</p>
                    </div>
                </div>
                <div style="display: flex; align-items: start; gap: 1rem;">
                    <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 10px rgba(245, 158, 11, 0.3);">
                        <i class="fas fa-truck" style="color: white;"></i>
                    </div>
                    <div style="flex: 1;">
                        <h3 style="font-weight: 700; font-size: 1.125rem; margin-bottom: 0.25rem;">إرسال المنتج</h3>
                        <p style="color: var(--gray-600); line-height: 1.7;">سنقوم بترتيب استلام المنتج من عنوانك (مجاناً)</p>
                    </div>
                </div>
                <div style="display: flex; align-items: start; gap: 1rem;">
                    <div style="width: 45px; height: 45px; background: linear-gradient(135deg, #8b5cf6, #7c3aed); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 10px rgba(139, 92, 246, 0.3);">
                        <i class="fas fa-money-bill-wave" style="color: white;"></i>
                    </div>
                    <div style="flex: 1;">
                        <h3 style="font-weight: 700; font-size: 1.125rem; margin-bottom: 0.25rem;">استرداد المبلغ</h3>
                        <p style="color: var(--gray-600); line-height: 1.7;">سيتم استرداد المبلغ خلال 3-5 أيام عمل بعد فحص المنتج</p>
                    </div>
                </div>
            </div>
        </div>
        <div style="background: linear-gradient(135deg, #fef2f2, #fee2e2); padding: 2rem; border-radius: 15px; border-right: 4px solid #ef4444;">
            <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 1rem; color: #991b1b;">
                <i class="fas fa-times-circle" style="margin-left: 0.5rem;"></i>المنتجات المستثناة من الإرجاع
            </h3>
            <ul style="list-style: none; padding: 0; display: flex; flex-direction: column; gap: 0.5rem; color: #991b1b;">
                <li style="display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-ban" style="font-size: 0.875rem;"></i>
                    المنتجات سريعة التلف
                </li>
                <li style="display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-ban" style="font-size: 0.875rem;"></i>
                    المنتجات المستخدمة أو المفتوحة
                </li>
                <li style="display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fas fa-ban" style="font-size: 0.875rem;"></i>
                    المنتجات المخصصة حسب الطلب
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection
