@extends('layouts.app')

@section('title', 'حسابي')

@section('content')
<div class="container" style="padding-top: 2rem; padding-bottom: 4rem;">
    <!-- Header -->
    <div style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; padding: 2.5rem; border-radius: 20px; margin-bottom: 3rem; text-align: center; box-shadow: 0 10px 30px rgba(16,185,129,0.2);">
        <div style="width: 80px; height: 80px; background: rgba(255,255,255,0.2); border: 3px solid white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; font-size: 2rem;">
            <i class="fas fa-user"></i>
        </div>
        <h1 style="font-size: 2rem; font-weight: 900; margin-bottom: 0.5rem;">مرحباً، {{ $user->name }}</h1>
        <p style="opacity: 0.9;">{{ $user->email }}</p>
    </div>

    @if(session('success'))
    <div style="background: linear-gradient(135deg, #d1fae5, #a7f3d0); border: 2px solid var(--primary); border-radius: 12px; padding: 1rem 1.5rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem;">
        <i class="fas fa-check-circle" style="color: var(--primary); font-size: 1.5rem;"></i>
        <span style="color: #065f46; font-weight: 600;">{{ session('success') }}</span>
    </div>
    @endif

    <div style="display: grid; grid-template-columns: 300px 1fr; gap: 2rem;">
        <!-- Sidebar -->
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <a href="{{ route('profile.index') }}" style="padding: 1rem 1.5rem; background: var(--primary); color: white; text-decoration: none; border-radius: 12px; font-weight: 700; display: flex; align-items: center; gap: 0.75rem; transition: all 0.3s;">
                <i class="fas fa-user"></i>
                معلومات الحساب
            </a>
            <a href="{{ route('profile.orders') }}" style="padding: 1rem 1.5rem; background: white; color: var(--dark); text-decoration: none; border-radius: 12px; font-weight: 700; display: flex; align-items: center; gap: 0.75rem; transition: all 0.3s; border: 2px solid var(--gray-200);" onmouseover="this.style.background='var(--gray-50)'" onmouseout="this.style.background='white'">
                <i class="fas fa-shopping-bag"></i>
                <span>طلباتي</span>
                @if($orders->total() > 0)
                <span style="margin-right: auto; background: var(--primary); color: white; padding: 0.25rem 0.625rem; border-radius: 20px; font-size: 0.75rem;">{{ $orders->total() }}</span>
                @endif
            </a>
        </div>

        <!-- Main Content -->
        <div>
            <!-- User Info Card -->
            <div style="background: white; padding: 2.5rem; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid var(--gray-200); margin-bottom: 2rem;">
                <h2 style="font-size: 1.5rem; font-weight: 900; color: var(--dark); margin-bottom: 2rem; display: flex; align-items: center; gap: 0.75rem; padding-bottom: 1rem; border-bottom: 2px solid var(--primary);">
                    <i class="fas fa-id-card" style="color: var(--primary);"></i>
                    معلومات الحساب
                </h2>

                @if($errors->any() && !($errors->has('current_password') || $errors->has('password')))
                <div style="background: linear-gradient(135deg, #fee2e2, #fecaca); border: 2px solid #ef4444; border-radius: 12px; padding: 1rem 1.5rem; margin-bottom: 1.5rem;">
                    <div style="display: flex; align-items: start; gap: 0.75rem;">
                        <i class="fas fa-exclamation-circle" style="color: #dc2626; font-size: 1.25rem; margin-top: 0.125rem;"></i>
                        <div style="flex: 1;">
                            <div style="font-weight: 700; color: #991b1b; margin-bottom: 0.5rem;">يرجى تصحيح الأخطاء التالية:</div>
                            <ul style="margin: 0; padding-right: 1.25rem; color: #b91c1c;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div style="display: grid; gap: 1.5rem;">
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--dark); font-size: 0.9375rem;">
                                <i class="fas fa-user" style="color: var(--primary); margin-left: 0.25rem;"></i>
                                الاسم الكامل
                            </label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required style="width: 100%; padding: 0.875rem 1rem; border: 2px solid {{ $errors->has('name') ? '#ef4444' : 'var(--gray-200)' }}; border-radius: 12px; font-size: 1rem; font-weight: 500;">
                            @error('name')
                                <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                                    <i class="fas fa-times-circle"></i>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--dark); font-size: 0.9375rem;">
                                <i class="fas fa-phone" style="color: var(--primary); margin-left: 0.25rem;"></i>
                                رقم الجوال
                            </label>
                            <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}" style="width: 100%; padding: 0.875rem 1rem; border: 2px solid {{ $errors->has('phone') ? '#ef4444' : 'var(--gray-200)' }}; border-radius: 12px; font-size: 1rem; font-weight: 500; direction: ltr; text-align: left;">
                            @error('phone')
                                <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                                    <i class="fas fa-times-circle"></i>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--dark); font-size: 0.9375rem;">
                                <i class="fas fa-envelope" style="color: var(--primary); margin-left: 0.25rem;"></i>
                                البريد الإلكتروني
                            </label>
                            <input type="email" value="{{ $user->email }}" disabled style="width: 100%; padding: 0.875rem 1rem; border: 2px solid var(--gray-200); border-radius: 12px; font-size: 1rem; font-weight: 500; background: var(--gray-100); direction: ltr; text-align: left;">
                            <small style="display: block; margin-top: 0.5rem; color: var(--gray-600); font-size: 0.8125rem;">
                                <i class="fas fa-info-circle"></i>
                                لا يمكن تعديل البريد الإلكتروني
                            </small>
                        </div>

                        <button type="submit" style="padding: 1rem 2rem; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; border: none; border-radius: 12px; font-weight: 700; font-size: 1.0625rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.75rem; transition: all 0.3s; box-shadow: 0 4px 12px rgba(16,185,129,0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(16,185,129,0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(16,185,129,0.3)'">
                            <i class="fas fa-save"></i>
                            حفظ التغييرات
                        </button>
                    </div>
                </form>
            </div>

            <!-- Change Password Card -->
            <div style="background: white; padding: 2.5rem; border-radius: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border: 1px solid var(--gray-200);">
                <h2 style="font-size: 1.5rem; font-weight: 900; color: var(--dark); margin-bottom: 2rem; display: flex; align-items: center; gap: 0.75rem; padding-bottom: 1rem; border-bottom: 2px solid var(--primary);">
                    <i class="fas fa-lock" style="color: var(--primary);"></i>
                    تغيير كلمة المرور
                </h2>

                @if($errors->any() && ($errors->has('current_password') || $errors->has('password')))
                <div style="background: linear-gradient(135deg, #fee2e2, #fecaca); border: 2px solid #ef4444; border-radius: 12px; padding: 1rem 1.5rem; margin-bottom: 1.5rem;">
                    <div style="display: flex; align-items: start; gap: 0.75rem;">
                        <i class="fas fa-exclamation-circle" style="color: #dc2626; font-size: 1.25rem; margin-top: 0.125rem;"></i>
                        <div style="flex: 1;">
                            <div style="font-weight: 700; color: #991b1b; margin-bottom: 0.5rem;">خطأ في تغيير كلمة المرور:</div>
                            <ul style="margin: 0; padding-right: 1.25rem; color: #b91c1c;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif

                <form method="POST" action="{{ route('profile.password.update') }}">
                    @csrf
                    @method('PUT')

                    <div style="display: grid; gap: 1.5rem;">
                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--dark); font-size: 0.9375rem;">
                                <i class="fas fa-key" style="color: var(--primary); margin-left: 0.25rem;"></i>
                                كلمة المرور الحالية
                            </label>
                            <input type="password" name="current_password" required style="width: 100%; padding: 0.875rem 1rem; border: 2px solid {{ $errors->has('current_password') ? '#ef4444' : 'var(--gray-200)' }}; border-radius: 12px; font-size: 1rem; font-weight: 500;">
                            @error('current_password')
                                <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                                    <i class="fas fa-times-circle"></i>
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--dark); font-size: 0.9375rem;">
                                <i class="fas fa-lock" style="color: var(--primary); margin-left: 0.25rem;"></i>
                                كلمة المرور الجديدة
                            </label>
                            <input type="password" name="password" required minlength="8" style="width: 100%; padding: 0.875rem 1rem; border: 2px solid {{ $errors->has('password') ? '#ef4444' : 'var(--gray-200)' }}; border-radius: 12px; font-size: 1rem; font-weight: 500;">
                            @error('password')
                                <span style="color: #ef4444; font-size: 0.875rem; margin-top: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                                    <i class="fas fa-times-circle"></i>
                                    {{ $message }}
                                </span>
                            @enderror
                            <small style="display: block; margin-top: 0.5rem; color: var(--gray-600); font-size: 0.8125rem;">
                                <i class="fas fa-info-circle"></i>
                                يجب أن تحتوي كلمة المرور على 8 أحرف على الأقل
                            </small>
                        </div>

                        <div>
                            <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; color: var(--dark); font-size: 0.9375rem;">
                                <i class="fas fa-lock" style="color: var(--primary); margin-left: 0.25rem;"></i>
                                تأكيد كلمة المرور
                            </label>
                            <input type="password" name="password_confirmation" required style="width: 100%; padding: 0.875rem 1rem; border: 2px solid var(--gray-200); border-radius: 12px; font-size: 1rem; font-weight: 500;">
                        </div>

                        <button type="submit" style="padding: 1rem 2rem; background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; border: none; border-radius: 12px; font-weight: 700; font-size: 1.0625rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.75rem; transition: all 0.3s; box-shadow: 0 4px 12px rgba(59,130,246,0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(59,130,246,0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(59,130,246,0.3)'">
                            <i class="fas fa-shield-alt"></i>
                            تحديث كلمة المرور
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
