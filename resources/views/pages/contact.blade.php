@extends('layouts.app')

@section('title', 'اتصل بنا - لُجين الزراعية')

@section('content')
<div style="background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%); padding: 4rem 0 2rem;">
    <div class="container">
        <div style="text-align: center; max-width: 800px; margin: 0 auto;">
            <div style="display: inline-flex; align-items: center; gap: 1rem; background: white; padding: 1rem 2rem; border-radius: 50px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); margin-bottom: 2rem;">
                <div style="width: 50px; height: 50px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-envelope" style="color: white; font-size: 1.5rem;"></i>
                </div>
                <h1 style="margin: 0; font-size: 2.5rem; font-weight: 900; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">اتصل بنا</h1>
            </div>
            <p style="font-size: 1.25rem; color: var(--gray-600); line-height: 1.8;">نحن هنا للإجابة على استفساراتك ومساعدتك</p>
        </div>
    </div>
</div>

<div class="container" style="padding: 4rem 0;">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem;" class="responsive-grid">
        <!-- Contact Info -->
        <div>
            <h2 style="font-size: 2rem; font-weight: 900; margin-bottom: 2rem;">تواصل معنا مباشرة</h2>
            
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <a href="tel:+966500000000" style="display: flex; align-items: center; gap: 1.5rem; background: white; padding: 2rem; border-radius: 20px; text-decoration: none; box-shadow: 0 10px 30px rgba(0,0,0,0.08); transition: all 0.3s; border: 2px solid transparent;" onmouseover="this.style.transform='translateX(-10px)'; this.style.borderColor='var(--primary)'; this.style.boxShadow='0 15px 40px rgba(16, 185, 129, 0.15)'" onmouseout="this.style.transform='translateX(0)'; this.style.borderColor='transparent'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.08)'">
                    <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 18px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);">
                        <i class="fas fa-phone" style="color: white; font-size: 1.75rem;"></i>
                    </div>
                    <div>
                        <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.25rem; font-weight: 600;">اتصل بنا</div>
                        <div style="font-size: 1.5rem; font-weight: 900; color: var(--dark); direction: ltr; text-align: right;">+966 50 000 0000</div>
                    </div>
                </a>

                <a href="mailto:info@lujaiin.sa" style="display: flex; align-items: center; gap: 1.5rem; background: white; padding: 2rem; border-radius: 20px; text-decoration: none; box-shadow: 0 10px 30px rgba(0,0,0,0.08); transition: all 0.3s; border: 2px solid transparent;" onmouseover="this.style.transform='translateX(-10px)'; this.style.borderColor='#3b82f6'; this.style.boxShadow='0 15px 40px rgba(59, 130, 246, 0.15)'" onmouseout="this.style.transform='translateX(0)'; this.style.borderColor='transparent'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.08)'">
                    <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #3b82f6, #2563eb); border-radius: 18px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3);">
                        <i class="fas fa-envelope" style="color: white; font-size: 1.75rem;"></i>
                    </div>
                    <div>
                        <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.25rem; font-weight: 600;">راسلنا</div>
                        <div style="font-size: 1.5rem; font-weight: 900; color: var(--dark);">info@lujaiin.sa</div>
                    </div>
                </a>

                <div style="display: flex; align-items: center; gap: 1.5rem; background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.08); border: 2px solid transparent;">
                    <div style="width: 70px; height: 70px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 18px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 8px 20px rgba(245, 158, 11, 0.3);">
                        <i class="fas fa-map-marker-alt" style="color: white; font-size: 1.75rem;"></i>
                    </div>
                    <div>
                        <div style="font-size: 0.875rem; color: var(--gray-600); margin-bottom: 0.25rem; font-weight: 600;">موقعنا</div>
                        <div style="font-size: 1.25rem; font-weight: 900; color: var(--dark); line-height: 1.5;">الرياض، المملكة العربية السعودية</div>
                    </div>
                </div>
            </div>

            <div style="margin-top: 3rem; background: linear-gradient(135deg, #f0fdf4, #dcfce7); padding: 2rem; border-radius: 20px; border: 2px solid var(--primary-light);">
                <h3 style="font-size: 1.25rem; font-weight: 800; margin-bottom: 1rem; color: var(--primary-dark);">
                    <i class="fas fa-clock" style="margin-left: 0.5rem;"></i>
                    أوقات العمل
                </h3>
                <div style="display: flex; flex-direction: column; gap: 0.75rem; color: var(--gray-700); font-weight: 600;">
                    <div style="display: flex; justify-content: space-between;">
                        <span>السبت - الخميس:</span>
                        <span>9:00 ص - 9:00 م</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span>الجمعة:</span>
                        <span>4:00 م - 10:00 م</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Form -->
        <div style="background: white; padding: 3rem; border-radius: 30px; box-shadow: 0 20px 60px rgba(0,0,0,0.1);">
            <h2 style="font-size: 2rem; font-weight: 900; margin-bottom: 0.5rem;">أرسل لنا رسالة</h2>
            <p style="color: var(--gray-600); margin-bottom: 2.5rem; font-size: 1.05rem;">سنرد عليك في أقرب وقت ممكن</p>

            @if(session('success'))
            <div style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 1.25rem 1.5rem; border-radius: 15px; margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);">
                <i class="fas fa-check-circle" style="font-size: 1.5rem;"></i>
                <span style="font-weight: 600;">{{ session('success') }}</span>
            </div>
            @endif

            <form action="{{ route('pages.contact.submit') }}" method="POST" style="display: flex; flex-direction: column; gap: 1.5rem;">
                @csrf
                
                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--dark); font-size: 0.95rem;">الاسم الكامل *</label>
                    <input type="text" name="name" required style="width: 100%; padding: 1rem 1.25rem; border: 2px solid var(--gray-200); border-radius: 12px; font-size: 1rem; transition: all 0.3s; font-family: 'Tajawal', sans-serif;" onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 3px rgba(16, 185, 129, 0.1)'" onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--dark); font-size: 0.95rem;">البريد الإلكتروني *</label>
                    <input type="email" name="email" required style="width: 100%; padding: 1rem 1.25rem; border: 2px solid var(--gray-200); border-radius: 12px; font-size: 1rem; transition: all 0.3s; font-family: 'Tajawal', sans-serif;" onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 3px rgba(16, 185, 129, 0.1)'" onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--dark); font-size: 0.95rem;">رقم الجوال</label>
                    <input type="tel" name="phone" style="width: 100%; padding: 1rem 1.25rem; border: 2px solid var(--gray-200); border-radius: 12px; font-size: 1rem; transition: all 0.3s; font-family: 'Tajawal', sans-serif;" onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 3px rgba(16, 185, 129, 0.1)'" onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'" placeholder="05XXXXXXXX">
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--dark); font-size: 0.95rem;">الموضوع *</label>
                    <input type="text" name="subject" required style="width: 100%; padding: 1rem 1.25rem; border: 2px solid var(--gray-200); border-radius: 12px; font-size: 1rem; transition: all 0.3s; font-family: 'Tajawal', sans-serif;" onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 3px rgba(16, 185, 129, 0.1)'" onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--dark); font-size: 0.95rem;">الرسالة *</label>
                    <textarea name="message" required rows="5" style="width: 100%; padding: 1rem 1.25rem; border: 2px solid var(--gray-200); border-radius: 12px; font-size: 1rem; resize: vertical; transition: all 0.3s; font-family: 'Tajawal', sans-serif;" onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 3px rgba(16, 185, 129, 0.1)'" onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'"></textarea>
                </div>

                <button type="submit" style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; padding: 1.25rem 2rem; border: none; border-radius: 15px; font-size: 1.125rem; font-weight: 800; cursor: pointer; transition: all 0.3s; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3); display: flex; align-items: center; justify-content: center; gap: 0.75rem; font-family: 'Tajawal', sans-serif;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 12px 30px rgba(16, 185, 129, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 20px rgba(16, 185, 129, 0.3)'">
                    <i class="fas fa-paper-plane"></i>
                    إرسال الرسالة
                </button>
            </form>
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

