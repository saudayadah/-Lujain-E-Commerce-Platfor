@extends('layouts.app')

@section('title', 'تحقق من رقم الجوال')

@section('content')
<div style="min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 2rem; background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%);">
    <div style="width: 100%; max-width: 500px;">
        <div style="background: white; padding: 3rem; border-radius: 30px; box-shadow: 0 20px 60px rgba(0,0,0,0.1);">
            <!-- Header -->
            <div style="text-align: center; margin-bottom: 2.5rem;">
                <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);">
                    <i class="fas fa-mobile-alt" style="color: white; font-size: 2.5rem;"></i>
                </div>
                <h1 style="font-size: 2rem; font-weight: 900; margin-bottom: 0.5rem; color: var(--dark);">تحقق من رقم جوالك</h1>
                <p style="color: var(--gray-600); font-size: 1.05rem;">لحماية حسابك وتلقي إشعارات الطلبات</p>
            </div>

            @if(session('success'))
            <div style="background: linear-gradient(135deg, #d1fae5, #a7f3d0); color: #065f46; padding: 1.25rem; border-radius: 15px; margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem; border: 2px solid #10b981;">
                <i class="fas fa-check-circle" style="font-size: 1.5rem;"></i>
                <span style="font-weight: 600;">{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div style="background: linear-gradient(135deg, #fee2e2, #fecaca); color: #991b1b; padding: 1.25rem; border-radius: 15px; margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem; border: 2px solid #ef4444;">
                <i class="fas fa-exclamation-circle" style="font-size: 1.5rem;"></i>
                <span style="font-weight: 600;">{{ session('error') }}</span>
            </div>
            @endif

            @if(!session('success'))
            <!-- Step 1: Enter Phone -->
            <form action="{{ route('phone.send-code') }}" method="POST" id="phoneForm">
                @csrf
                <div style="margin-bottom: 2rem;">
                    <label style="display: block; margin-bottom: 0.75rem; font-weight: 700; color: var(--dark); font-size: 1.05rem;">
                        <i class="fas fa-phone" style="color: var(--primary); margin-left: 0.5rem;"></i>
                        رقم الجوال
                    </label>
                    <input type="tel" name="phone" value="{{ auth()->user()->phone }}" required 
                        pattern="[0-9]{10,15}"
                        placeholder="05XXXXXXXX"
                        style="width: 100%; padding: 1.25rem; border: 2px solid var(--gray-200); border-radius: 15px; font-size: 1.125rem; font-weight: 600; transition: all 0.3s; text-align: center; letter-spacing: 2px; font-family: 'Tajawal', sans-serif;"
                        onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 4px rgba(16, 185, 129, 0.1)'"
                        onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                    <small style="color: var(--gray-600); display: block; margin-top: 0.5rem; text-align: center;">
                        <i class="fas fa-info-circle"></i> أدخل رقم جوالك السعودي بدون 966 أو 0
                    </small>
                </div>

                <button type="submit" style="width: 100%; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; padding: 1.25rem; border: none; border-radius: 15px; font-size: 1.125rem; font-weight: 800; cursor: pointer; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3); transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 0.75rem; font-family: 'Tajawal', sans-serif;"
                    onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 12px 30px rgba(16, 185, 129, 0.4)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 20px rgba(16, 185, 129, 0.3)'">
                    <i class="fas fa-paper-plane"></i>
                    إرسال كود التحقق
                </button>
            </form>
            @else
            <!-- Step 2: Enter Code -->
            <form action="{{ route('phone.verify-code') }}" method="POST" id="verifyForm">
                @csrf
                <input type="hidden" name="phone" value="{{ request('phone') ?? auth()->user()->phone }}">
                
                <div style="margin-bottom: 2rem;">
                    <label style="display: block; margin-bottom: 0.75rem; font-weight: 700; color: var(--dark); font-size: 1.05rem; text-align: center;">
                        <i class="fas fa-key" style="color: var(--primary); margin-left: 0.5rem;"></i>
                        أدخل كود التحقق
                    </label>
                    <input type="text" name="code" required 
                        pattern="[0-9]{4}"
                        maxlength="4"
                        placeholder="----"
                        autofocus
                        style="width: 100%; padding: 1.5rem; border: 2px solid var(--gray-200); border-radius: 15px; font-size: 2rem; font-weight: 900; transition: all 0.3s; text-align: center; letter-spacing: 1rem; font-family: monospace;"
                        onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 4px rgba(16, 185, 129, 0.1)'"
                        onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4)">
                    
                    <div style="text-align: center; margin-top: 1rem;">
                        <div style="color: var(--gray-600); font-size: 0.95rem; margin-bottom: 1rem;">
                            <i class="fas fa-clock" style="margin-left: 0.25rem;"></i>
                            الكود صالح لمدة <strong id="timer" style="color: var(--primary);">5:00</strong> دقائق
                        </div>
                        <form action="{{ route('phone.resend') }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="phone" value="{{ request('phone') ?? auth()->user()->phone }}">
                            <button type="submit" id="resendBtn" disabled style="background: none; border: none; color: var(--gray-400); cursor: not-allowed; font-weight: 700; text-decoration: underline; font-family: 'Tajawal', sans-serif; font-size: 0.95rem;">
                                <i class="fas fa-redo" style="margin-left: 0.25rem;"></i>
                                إعادة إرسال الكود
                            </button>
                        </form>
                    </div>
                </div>

                <button type="submit" style="width: 100%; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; padding: 1.25rem; border: none; border-radius: 15px; font-size: 1.125rem; font-weight: 800; cursor: pointer; box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3); transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 0.75rem; font-family: 'Tajawal', sans-serif;"
                    onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 12px 30px rgba(16, 185, 129, 0.4)'"
                    onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 20px rgba(16, 185, 129, 0.3)'">
                    <i class="fas fa-check-circle"></i>
                    تحقق الآن
                </button>
            </form>

            <script>
                // Timer countdown
                let timeLeft = 300; // 5 minutes
                const timer = document.getElementById('timer');
                const resendBtn = document.getElementById('resendBtn');
                
                const countdown = setInterval(() => {
                    timeLeft--;
                    const minutes = Math.floor(timeLeft / 60);
                    const seconds = timeLeft % 60;
                    timer.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
                    
                    if (timeLeft <= 240) { // After 1 minute, enable resend
                        resendBtn.disabled = false;
                        resendBtn.style.color = 'var(--primary)';
                        resendBtn.style.cursor = 'pointer';
                    }
                    
                    if (timeLeft <= 0) {
                        clearInterval(countdown);
                        timer.textContent = 'انتهت الصلاحية';
                        timer.style.color = '#ef4444';
                    }
                }, 1000);
            </script>
            @endif

            <!-- Skip (Optional) -->
            <div style="text-align: center; margin-top: 2rem;">
                <a href="{{ route('home') }}" style="color: var(--gray-600); text-decoration: none; font-size: 0.95rem; font-weight: 600;">
                    <i class="fas fa-arrow-left" style="margin-left: 0.25rem;"></i>
                    تخطي الآن (يمكنك التحقق لاحقاً)
                </a>
            </div>
        </div>

        <!-- Info Box -->
        <div style="background: white; padding: 2rem; border-radius: 20px; margin-top: 1.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.08); border: 2px solid #dbeafe;">
            <h3 style="font-size: 1.125rem; font-weight: 800; margin-bottom: 1rem; color: #1e40af; display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-shield-alt"></i>
                لماذا التحقق؟
            </h3>
            <ul style="list-style: none; padding: 0; display: flex; flex-direction: column; gap: 0.75rem; color: #1e3a8a;">
                <li style="display: flex; align-items: start; gap: 0.75rem;">
                    <i class="fas fa-check-circle" style="color: var(--primary); margin-top: 0.25rem; flex-shrink: 0;"></i>
                    <span>حماية حسابك من الاختراق</span>
                </li>
                <li style="display: flex; align-items: start; gap: 0.75rem;">
                    <i class="fas fa-check-circle" style="color: var(--primary); margin-top: 0.25rem; flex-shrink: 0;"></i>
                    <span>تلقي إشعارات SMS عن طلباتك</span>
                </li>
                <li style="display: flex; align-items: start; gap: 0.75rem;">
                    <i class="fas fa-check-circle" style="color: var(--primary); margin-top: 0.25rem; flex-shrink: 0;"></i>
                    <span>استرجاع كلمة المرور بسهولة</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection

