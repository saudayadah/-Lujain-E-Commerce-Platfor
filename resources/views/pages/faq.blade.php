@extends('layouts.app')
@section('title', 'الأسئلة الشائعة - لُجين الزراعية')
@section('content')
<div style="background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%); padding: 4rem 0 2rem;">
    <div class="container">
        <div style="text-align: center; max-width: 800px; margin: 0 auto;">
            <h1 style="font-size: 2.5rem; font-weight: 900; margin-bottom: 1rem;">الأسئلة الشائعة</h1>
            <p style="font-size: 1.25rem; color: var(--gray-600);">إجابات سريعة على أكثر الأسئلة شيوعاً</p>
        </div>
    </div>
</div>
<div class="container" style="padding: 4rem 0; max-width: 900px;">
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <div style="background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; border: 2px solid transparent; transition: all 0.3s;" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='transparent'">
            <div style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); padding: 2rem; color: white;">
                <h3 style="font-size: 1.5rem; font-weight: 800; display: flex; align-items: center; gap: 1rem;">
                    <i class="fas fa-shipping-fast"></i>
                    كم يستغرق توصيل الطلب؟
                </h3>
            </div>
            <div style="padding: 2rem;">
                <p style="color: var(--gray-600); line-height: 1.9; font-size: 1.05rem;">نوصل لك خلال 24 ساعة في الرياض، و2-3 أيام في المدن الرئيسية، و3-5 أيام في باقي المناطق.</p>
            </div>
        </div>
        <div style="background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; border: 2px solid transparent; transition: all 0.3s;" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='transparent'">
            <div style="background: linear-gradient(135deg, #3b82f6, #2563eb); padding: 2rem; color: white;">
                <h3 style="font-size: 1.5rem; font-weight: 800; display: flex; align-items: center; gap: 1rem;">
                    <i class="fas fa-credit-card"></i>
                    ما هي طرق الدفع المتاحة؟
                </h3>
            </div>
            <div style="padding: 2rem;">
                <p style="color: var(--gray-600); line-height: 1.9; font-size: 1.05rem; margin-bottom: 1rem;">نوفر لك عدة خيارات للدفع:</p>
                <ul style="list-style: none; padding: 0; display: flex; flex-direction: column; gap: 0.75rem;">
                    <li style="display: flex; align-items: center; gap: 0.75rem; color: var(--gray-700); font-weight: 600;">
                        <i class="fas fa-check-circle" style="color: var(--primary);"></i>
                        الدفع عند الاستلام (COD)
                    </li>
                    <li style="display: flex; align-items: center; gap: 0.75rem; color: var(--gray-700); font-weight: 600;">
                        <i class="fas fa-check-circle" style="color: var(--primary);"></i>
                        مدى، فيزا، ماستركارد
                    </li>
                    <li style="display: flex; align-items: center; gap: 0.75rem; color: var(--gray-700); font-weight: 600;">
                        <i class="fas fa-check-circle" style="color: var(--primary);"></i>
                        Apple Pay
                    </li>
                </ul>
            </div>
        </div>
        <div style="background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; border: 2px solid transparent; transition: all 0.3s;" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='transparent'">
            <div style="background: linear-gradient(135deg, #f59e0b, #d97706); padding: 2rem; color: white;">
                <h3 style="font-size: 1.5rem; font-weight: 800; display: flex; align-items: center; gap: 1rem;">
                    <i class="fas fa-undo-alt"></i>
                    هل يمكنني إرجاع المنتج؟
                </h3>
            </div>
            <div style="padding: 2rem;">
                <p style="color: var(--gray-600); line-height: 1.9; font-size: 1.05rem;">نعم، يمكنك إرجاع المنتج خلال 7 أيام من تاريخ الاستلام إذا كان في حالته الأصلية. راجع <a href="{{ route('pages.refund') }}" style="color: var(--primary); font-weight: 700;">سياسة الاسترجاع</a> للمزيد من التفاصيل.</p>
            </div>
        </div>
        <div style="background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; border: 2px solid transparent; transition: all 0.3s;" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='transparent'">
            <div style="background: linear-gradient(135deg, #8b5cf6, #7c3aed); padding: 2rem; color: white;">
                <h3 style="font-size: 1.5rem; font-weight: 800; display: flex; align-items: center; gap: 1rem;">
                    <i class="fas fa-shield-alt"></i>
                    هل منتجاتكم أصلية؟
                </h3>
            </div>
            <div style="padding: 2rem;">
                <p style="color: var(--gray-600); line-height: 1.9; font-size: 1.05rem;">نعم، جميع منتجاتنا أصلية 100% ونحصل عليها من موردين معتمدين. نضمن لك أعلى جودة ممكنة.</p>
            </div>
        </div>
        <div style="background: white; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); overflow: hidden; border: 2px solid transparent; transition: all 0.3s;" onmouseover="this.style.borderColor='var(--primary)'" onmouseout="this.style.borderColor='transparent'">
            <div style="background: linear-gradient(135deg, #ec4899, #db2777); padding: 2rem; color: white;">
                <h3 style="font-size: 1.5rem; font-weight: 800; display: flex; align-items: center; gap: 1rem;">
                    <i class="fas fa-headset"></i>
                    كيف يمكنني التواصل معكم؟
                </h3>
            </div>
            <div style="padding: 2rem;">
                <p style="color: var(--gray-600); line-height: 1.9; font-size: 1.05rem; margin-bottom: 1rem;">يمكنك التواصل معنا بعدة طرق:</p>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; background: #f9fafb; border-radius: 10px;">
                        <i class="fas fa-phone" style="color: var(--primary);"></i>
                        <span><strong>الهاتف:</strong> +966 50 000 0000</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; background: #f9fafb; border-radius: 10px;">
                        <i class="fas fa-envelope" style="color: var(--primary);"></i>
                        <span><strong>البريد:</strong> info@lujaiin.sa</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; background: #f9fafb; border-radius: 10px;">
                        <i class="fab fa-whatsapp" style="color: #25D366;"></i>
                        <span><strong>واتساب:</strong> متاح</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div style="margin-top: 4rem; text-align: center; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); padding: 3rem; border-radius: 30px; color: white;">
        <i class="fas fa-question-circle" style="font-size: 3.5rem; margin-bottom: 1rem; opacity: 0.9;"></i>
        <h2 style="font-size: 2rem; font-weight: 900; margin-bottom: 1rem;">لم تجد إجابة لسؤالك؟</h2>
        <p style="font-size: 1.125rem; margin-bottom: 2rem; opacity: 0.9;">تواصل معنا وسنكون سعداء بمساعدتك</p>
        <a href="{{ route('pages.contact') }}" style="display: inline-flex; align-items: center; gap: 0.75rem; background: white; color: var(--primary); padding: 1.25rem 3rem; border-radius: 50px; text-decoration: none; font-weight: 800; font-size: 1.125rem; box-shadow: 0 10px 30px rgba(0,0,0,0.2); transition: all 0.3s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
            <i class="fas fa-paper-plane"></i>
            اتصل بنا الآن
        </a>
    </div>
</div>
@endsection
