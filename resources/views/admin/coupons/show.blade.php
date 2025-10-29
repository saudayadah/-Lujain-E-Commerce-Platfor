@extends('layouts.admin')

@section('title', 'تفاصيل الكوبون')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div>
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline btn-sm" style="margin-bottom: 1rem;">
            <i class="fas fa-arrow-right"></i> العودة للكوبونات
        </a>
        <h1 class="page-title">
            <i class="fas fa-ticket-alt"></i>
            تفاصيل الكوبون
        </h1>
    </div>
    <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-primary">
        <i class="fas fa-edit"></i> تعديل
    </a>
</div>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem;">
    <!-- Coupon Info Card -->
    <div>
        <div class="card">
            <div style="text-align: center; padding: 2rem 1rem;">
                <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #f59e0b, #d97706); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 2rem; margin: 0 auto 1rem;">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <code style="background: var(--primary-light); color: var(--primary); padding: 0.5rem 1rem; border-radius: 8px; font-weight: 700; font-size: 1.25rem; display: inline-block;">
                    {{ $coupon->code }}
                </code>
                
                <div style="margin-top: 1.5rem;">
                    @php
                        $status = $coupon->status;
                        $statusColors = [
                            'نشط' => 'success',
                            'منتهي' => 'danger',
                            'معطل' => 'secondary',
                            'لم يبدأ' => 'warning',
                            'مكتمل' => 'danger',
                        ];
                    @endphp
                    <span class="badge badge-{{ $statusColors[$status] ?? 'secondary' }}" style="padding: 0.5rem 1rem; font-size: 1rem;">
                        {{ $status }}
                    </span>
                </div>
            </div>
            
            <div style="border-top: 1px solid var(--border-color); padding: 1.5rem;">
                <h3 style="margin: 0 0 1rem 0;">معلومات الكوبون</h3>
                
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--gray-600);">النوع</span>
                        <strong>
                            @if($coupon->type === 'percentage')
                            نسبة مئوية
                            @else
                            مبلغ ثابت
                            @endif
                        </strong>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--gray-600);">القيمة</span>
                        <strong style="color: var(--primary); font-size: 1.25rem;">{{ $coupon->type_text }}</strong>
                    </div>
                    
                    @if($coupon->min_order_amount)
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--gray-600);">الحد الأدنى للطلب</span>
                        <strong>{{ number_format($coupon->min_order_amount, 2) }} ر.س</strong>
                    </div>
                    @endif
                    
                    @if($coupon->max_discount)
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--gray-600);">الحد الأقصى للخصم</span>
                        <strong>{{ number_format($coupon->max_discount, 2) }} ر.س</strong>
                    </div>
                    @endif
                    
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--gray-600);">الاستخدامات</span>
                        <strong>
                            {{ $coupon->usage_count }} / {{ $coupon->usage_limit ?? '∞' }}
                        </strong>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--gray-600);">لكل مستخدم</span>
                        <strong>{{ $coupon->per_user_limit }}</strong>
                    </div>
                    
                    @if($coupon->starts_at)
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--gray-600);">يبدأ</span>
                        <strong>{{ $coupon->starts_at->format('Y-m-d') }}</strong>
                    </div>
                    @endif
                    
                    @if($coupon->expires_at)
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--gray-600);">ينتهي</span>
                        <strong>{{ $coupon->expires_at->format('Y-m-d') }}</strong>
                    </div>
                    @endif
                    
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--gray-600);">تاريخ الإنشاء</span>
                        <strong>{{ $coupon->created_at->format('Y-m-d') }}</strong>
                    </div>
                </div>
                
                @if($coupon->description)
                <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color);">
                    <h4 style="margin: 0 0 0.5rem 0; color: var(--gray-600);">الوصف</h4>
                    <p style="margin: 0;">{{ $coupon->description }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Usage History -->
    <div>
        <div class="card">
            <h3 style="margin: 0 0 1.5rem 0;">
                <i class="fas fa-history"></i> سجل الاستخدام
            </h3>
            
            @if($coupon->users && $coupon->users->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @foreach($coupon->users as $user)
                <div style="border: 1px solid var(--border-color); border-radius: 8px; padding: 1rem;">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div>
                            <strong>{{ $user->name }}</strong>
                            <p style="color: var(--gray-500); font-size: 0.875rem; margin: 0.25rem 0 0 0;">
                                {{ $user->email }}
                            </p>
                            <p style="color: var(--gray-400); font-size: 0.875rem; margin: 0.25rem 0 0 0;">
                                {{ $user->pivot->created_at->format('Y-m-d h:i A') }}
                            </p>
                        </div>
                        <div style="text-align: left;">
                            <div style="color: var(--success); font-weight: 600; font-size: 1.125rem;">
                                -{{ number_format($user->pivot->discount_amount, 2) }} ر.س
                            </div>
                            @if($user->pivot->order_id)
                            <a href="{{ route('admin.orders.show', $user->pivot->order_id) }}" style="color: var(--primary); font-size: 0.875rem; text-decoration: none;">
                                <i class="fas fa-external-link-alt"></i> عرض الطلب
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div style="text-align: center; padding: 3rem;">
                <i class="fas fa-history" style="font-size: 3rem; color: var(--gray-300); margin-bottom: 1rem;"></i>
                <p style="color: var(--gray-500);">لم يتم استخدام هذا الكوبون بعد</p>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

