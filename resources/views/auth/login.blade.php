@extends('layouts.app')

@section('title', 'تسجيل الدخول')

@push('styles')
<style>
@media (max-width: 768px) {
    .container {
        padding: 1rem 0.75rem !important;
        padding-top: 1.5rem !important;
        padding-bottom: 3rem !important;
    }
    
    .container > div {
        max-width: 100% !important;
    }
    
    input[type="text"],
    input[type="password"],
    input[type="tel"] {
        font-size: 16px !important; /* يمنع zoom في iOS */
    }
}
</style>
@endpush

@section('content')
<div class="container" style="padding-top: 2rem; padding-bottom: 4rem;">
    <div style="max-width: 450px; margin: 0 auto;">
        <!-- Header -->
        <div style="text-align: center; margin-bottom: 2.5rem;">
            <div style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); width: 70px; height: 70px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; box-shadow: 0 8px 20px rgba(16,185,129,0.3);">
                <i class="fas fa-sign-in-alt" style="font-size: 1.75rem; color: white;"></i>
            </div>
            <h2 style="font-size: 1.75rem; font-weight: 900; color: var(--dark); margin-bottom: 0.5rem;">
                تسجيل الدخول
            </h2>
            <p style="color: var(--gray-600); font-size: 0.9375rem;">
                أهلاً بعودتك! 👋
            </p>
        </div>

        <!-- Form -->
        <div style="background: white; padding: 2rem; border-radius: 20px; box-shadow: 0 8px 24px rgba(0,0,0,0.08); border: 1px solid var(--gray-200);">
            @if($errors->any())
            <div style="background: #fee2e2; border: 2px solid #ef4444; border-radius: 12px; padding: 1rem; margin-bottom: 1.5rem;">
                <div style="display: flex; align-items: start; gap: 0.75rem;">
                    <i class="fas fa-exclamation-circle" style="color: #ef4444; font-size: 1.25rem; margin-top: 0.125rem;"></i>
                    <div>
                        <strong style="color: #991b1b; font-size: 0.9375rem;">{{ $errors->first() ?: 'البيانات غير صحيحة' }}</strong>
                    </div>
                </div>
            </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                
                <!-- Phone/Email -->
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--dark); font-size: 0.9375rem;">
                        <i class="fas fa-mobile-alt" style="color: var(--primary); margin-left: 0.25rem;"></i>
                        رقم الجوال
                    </label>
                    <input type="text" 
                           name="email" 
                           value="{{ old('email') }}" 
                           required 
                           autofocus
                           placeholder="مثال: 0512345678"
                           style="width: 100%; padding: 0.875rem 1rem; border: 2px solid var(--gray-200); border-radius: 12px; font-size: 1.0625rem; font-weight: 600; direction: ltr; text-align: left; transition: all 0.3s;"
                           onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 3px rgba(16,185,129,0.1)'"
                           onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                </div>
                
                <!-- Password -->
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--dark); font-size: 0.9375rem;">
                        <i class="fas fa-lock" style="color: var(--primary); margin-left: 0.25rem;"></i>
                        كلمة المرور
                    </label>
                    <div style="position: relative;">
                        <input type="password" 
                               name="password" 
                               id="password"
                               required
                               placeholder="أدخل كلمة المرور"
                               style="width: 100%; padding: 0.875rem 3rem 0.875rem 1rem; border: 2px solid var(--gray-200); border-radius: 12px; font-size: 1rem; font-weight: 500; transition: all 0.3s;"
                               onfocus="this.style.borderColor='var(--primary)'; this.style.boxShadow='0 0 0 3px rgba(16,185,129,0.1)'"
                               onblur="this.style.borderColor='var(--gray-200)'; this.style.boxShadow='none'">
                        <button type="button" onclick="togglePassword()" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); background: none; border: none; color: var(--gray-500); cursor: pointer; padding: 0.5rem;">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Remember & Forgot -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.75rem;">
                    <label style="display: flex; align-items: center; cursor: pointer;">
                        <input type="checkbox" name="remember" style="width: 18px; height: 18px; margin-left: 0.5rem; accent-color: var(--primary); cursor: pointer;">
                        <span style="color: var(--gray-700); font-weight: 600; font-size: 0.875rem;">تذكرني</span>
                    </label>
                    @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="color: var(--primary); font-weight: 600; text-decoration: none; font-size: 0.875rem; transition: all 0.2s;" onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                        نسيت كلمة المرور؟
                    </a>
                    @endif
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="btn" style="width: 100%; padding: 1.125rem; font-size: 1.125rem; font-weight: 800; justify-content: center; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); box-shadow: 0 8px 20px rgba(16,185,129,0.3); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 24px rgba(16,185,129,0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 20px rgba(16,185,129,0.3)'">
                    <i class="fas fa-sign-in-alt"></i>
                    تسجيل الدخول
                </button>
            </form>
        </div>

        <!-- Register Link -->
        <div style="text-align: center; margin-top: 2rem; padding: 1.5rem; background: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
            <p style="color: var(--gray-700); font-size: 0.9375rem; margin-bottom: 1rem;">
                ليس لديك حساب؟
            </p>
            <a href="{{ route('register') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.875rem 1.75rem; background: white; color: var(--primary); text-decoration: none; border-radius: 12px; font-weight: 700; border: 2px solid var(--primary); transition: all 0.3s;" onmouseover="this.style.background='var(--primary)'; this.style.color='white'" onmouseout="this.style.background='white'; this.style.color='var(--primary)'">
                <i class="fas fa-user-plus"></i>
                إنشاء حساب جديد
            </a>
        </div>

    </div>
</div>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}
</script>
@endsection
