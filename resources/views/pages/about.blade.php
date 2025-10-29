@extends('layouts.app')

@section('title', 'من نحن - لُجين الزراعية')

@section('content')
<div style="background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%); padding: 4rem 0 2rem;">
    <div class="container">
        <div style="text-align: center; max-width: 800px; margin: 0 auto;">
            <div style="display: inline-flex; align-items: center; gap: 1rem; background: white; padding: 1rem 2rem; border-radius: 50px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); margin-bottom: 2rem;">
                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-seedling" style="color: white; font-size: 1.5rem;"></i>
                </div>
                <h1 style="margin: 0; font-size: 2.5rem; font-weight: 900; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">من نحن</h1>
            </div>
            <p style="font-size: 1.25rem; color: var(--gray-600); line-height: 1.8;">تعرف على قصتنا ورؤيتنا في تقديم أفضل المنتجات الزراعية</p>
        </div>
    </div>
</div>

<div class="container" style="padding: 4rem 0;">
    <!-- Our Story -->
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; margin-bottom: 6rem;" class="responsive-grid">
        <div>
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.5rem;">
                <div style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--primary), var(--primary-light)); border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-book-open" style="color: white; font-size: 1.75rem;"></i>
                </div>
                <h2 style="margin: 0; font-size: 2rem; font-weight: 900;">قصتنا</h2>
            </div>
            <p style="color: var(--gray-600); font-size: 1.125rem; line-height: 1.9; margin-bottom: 1.5rem;">
                انطلقت <strong style="color: var(--primary);">مؤسسة لُجين الزراعية</strong> من رؤية واضحة: توفير أفضل المنتجات الزراعية للمزارعين والهواة في المملكة العربية السعودية.
            </p>
            <p style="color: var(--gray-600); font-size: 1.125rem; line-height: 1.9; margin-bottom: 1.5rem;">
                نؤمن بأن الزراعة هي أساس الحياة، ولذلك نسعى دائماً لتقديم منتجات عالية الجودة تساعد على تحقيق أفضل النتائج في مشاريعكم الزراعية.
            </p>
            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <div style="flex: 1; background: linear-gradient(135deg, #f0fdf4, #dcfce7); padding: 1.5rem; border-radius: 15px; border: 2px solid var(--primary-light);">
                    <div style="font-size: 2.5rem; font-weight: 900; color: var(--primary); margin-bottom: 0.5rem;">+5</div>
                    <div style="color: var(--gray-600); font-weight: 600;">سنوات خبرة</div>
                </div>
                <div style="flex: 1; background: linear-gradient(135deg, #fef3c7, #fde68a); padding: 1.5rem; border-radius: 15px; border: 2px solid #fbbf24;">
                    <div style="font-size: 2.5rem; font-weight: 900; color: #f59e0b; margin-bottom: 0.5rem;">+1000</div>
                    <div style="color: var(--gray-600); font-weight: 600;">عميل سعيد</div>
                </div>
            </div>
        </div>
        <div style="position: relative;">
            <div style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border-radius: 30px; padding: 3rem; color: white; box-shadow: 0 20px 60px rgba(16, 185, 129, 0.3);">
                <i class="fas fa-quote-right" style="font-size: 3rem; opacity: 0.2; margin-bottom: 1rem;"></i>
                <p style="font-size: 1.5rem; line-height: 1.8; margin-bottom: 2rem; font-weight: 500;">نسعى لأن نكون الخيار الأول لكل من يبحث عن التميز في المنتجات الزراعية</p>
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <div>
                        <div style="font-weight: 700; font-size: 1.125rem;">رؤيتنا</div>
                        <div style="opacity: 0.8; font-size: 0.875rem;">التميز في كل منتج</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Our Values -->
    <div style="text-align: center; margin-bottom: 4rem;">
        <h2 style="font-size: 2.5rem; font-weight: 900; margin-bottom: 1rem;">قيمنا</h2>
        <p style="color: var(--gray-600); font-size: 1.125rem; max-width: 700px; margin: 0 auto;">المبادئ التي نؤمن بها ونعمل على تحقيقها يومياً</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; margin-bottom: 6rem;">
        <div style="background: white; padding: 2.5rem; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); transition: transform 0.3s, box-shadow 0.3s; border: 2px solid transparent;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 20px 60px rgba(16, 185, 129, 0.2)'; this.style.borderColor='var(--primary)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 40px rgba(0,0,0,0.08)'; this.style.borderColor='transparent'">
            <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);">
                <i class="fas fa-gem" style="color: white; font-size: 2rem;"></i>
            </div>
            <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1rem; color: var(--dark);">الجودة</h3>
            <p style="color: var(--gray-600); line-height: 1.8; font-size: 1.05rem;">نحرص على تقديم منتجات عالية الجودة فقط، تم اختيارها بعناية فائقة</p>
        </div>

        <div style="background: white; padding: 2.5rem; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); transition: transform 0.3s, box-shadow 0.3s; border: 2px solid transparent;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 20px 60px rgba(59, 130, 246, 0.2)'; this.style.borderColor='#3b82f6'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 40px rgba(0,0,0,0.08)'; this.style.borderColor='transparent'">
            <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem; box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);">
                <i class="fas fa-handshake" style="color: white; font-size: 2rem;"></i>
            </div>
            <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1rem; color: var(--dark);">الثقة</h3>
            <p style="color: var(--gray-600); line-height: 1.8; font-size: 1.05rem;">نبني علاقات طويلة الأمد مع عملائنا مبنية على الثقة والمصداقية</p>
        </div>

        <div style="background: white; padding: 2.5rem; border-radius: 20px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); transition: transform 0.3s, box-shadow 0.3s; border: 2px solid transparent;" onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 20px 60px rgba(245, 158, 11, 0.2)'; this.style.borderColor='#f59e0b'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 40px rgba(0,0,0,0.08)'; this.style.borderColor='transparent'">
            <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 20px; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem; box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);">
                <i class="fas fa-shipping-fast" style="color: white; font-size: 2rem;"></i>
            </div>
            <h3 style="font-size: 1.5rem; font-weight: 800; margin-bottom: 1rem; color: var(--dark);">السرعة</h3>
            <p style="color: var(--gray-600); line-height: 1.8; font-size: 1.05rem;">نوصل منتجاتك بأسرع وقت ممكن لضمان رضاك الكامل</p>
        </div>
    </div>

    <!-- Call to Action -->
    <div style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border-radius: 30px; padding: 4rem 3rem; text-align: center; color: white; position: relative; overflow: hidden;">
        <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%; filter: blur(60px);"></div>
        <div style="position: absolute; bottom: -50px; left: -50px; width: 200px; height: 200px; background: rgba(255,255,255,0.1); border-radius: 50%; filter: blur(60px);"></div>
        <div style="position: relative; z-index: 1;">
            <i class="fas fa-shopping-bag" style="font-size: 4rem; margin-bottom: 1.5rem; opacity: 0.9;"></i>
            <h2 style="font-size: 2.5rem; font-weight: 900; margin-bottom: 1rem;">ابدأ تجربتك معنا الآن!</h2>
            <p style="font-size: 1.25rem; margin-bottom: 2.5rem; opacity: 0.9; max-width: 600px; margin-left: auto; margin-right: auto;">اكتشف مجموعتنا الواسعة من المنتجات الزراعية عالية الجودة</p>
            <a href="{{ route('products.index') }}" style="display: inline-flex; align-items: center; gap: 0.75rem; background: white; color: var(--primary); padding: 1.25rem 3rem; border-radius: 50px; text-decoration: none; font-weight: 800; font-size: 1.125rem; box-shadow: 0 10px 30px rgba(0,0,0,0.2); transition: all 0.3s;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 15px 40px rgba(0,0,0,0.3)'" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.2)'">
                <i class="fas fa-arrow-left"></i>
                تصفح المنتجات
            </a>
        </div>
    </div>
</div>

<style>
@media (max-width: 768px) {
    .responsive-grid {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endsection

