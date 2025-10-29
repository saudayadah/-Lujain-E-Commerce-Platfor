@extends('layouts.admin')

@section('title', 'إدارة الكوبونات')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="fas fa-ticket-alt"></i>
            إدارة الكوبونات
        </h1>
        <p style="color: var(--gray-600); margin-top: 0.5rem;">إنشاء وإدارة كوبونات الخصم</p>
    </div>
    <a href="{{ route('admin.coupons.create') }}" class="btn">
        <i class="fas fa-plus"></i> إضافة كوبون جديد
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<!-- Coupons Table -->
<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>الكود</th>
                    <th>النوع</th>
                    <th>القيمة</th>
                    <th>الاستخدامات</th>
                    <th>الحالة</th>
                    <th>تاريخ الانتهاء</th>
                    <th style="text-align: center;">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($coupons as $coupon)
                <tr>
                    <td>
                        <code style="background: var(--primary-light); color: var(--primary); padding: 0.25rem 0.5rem; border-radius: 4px; font-weight: 600;">
                            {{ $coupon->code }}
                        </code>
                    </td>
                    <td>
                        @if($coupon->type === 'percentage')
                        <span class="badge badge-info">نسبة مئوية</span>
                        @else
                        <span class="badge badge-success">مبلغ ثابت</span>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $coupon->type_text }}</strong>
                    </td>
                    <td>
                        <span style="color: var(--gray-600);">
                            {{ $coupon->usage_count }} / {{ $coupon->usage_limit ?? '∞' }}
                        </span>
                        @if($coupon->usage_limit && $coupon->usage_count >= $coupon->usage_limit)
                        <span class="badge badge-danger" style="margin-right: 0.5rem;">مكتمل</span>
                        @endif
                    </td>
                    <td>
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
                        <span class="badge badge-{{ $statusColors[$status] ?? 'secondary' }}">
                            {{ $status }}
                        </span>
                    </td>
                    <td>
                        @if($coupon->expires_at)
                        {{ $coupon->expires_at->format('Y-m-d') }}
                        @else
                        <span style="color: var(--gray-400);">لا يوجد</span>
                        @endif
                    </td>
                    <td style="text-align: center;">
                        <div style="display: flex; gap: 0.5rem; justify-content: center;">
                            <a href="{{ route('admin.coupons.show', $coupon) }}" class="btn btn-sm btn-secondary" title="عرض التفاصيل">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-sm btn-primary" title="تعديل">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا الكوبون؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="حذف">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 3rem;">
                        <i class="fas fa-ticket-alt" style="font-size: 3rem; color: var(--gray-300); margin-bottom: 1rem;"></i>
                        <p style="color: var(--gray-500);">لا توجد كوبونات</p>
                        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary" style="margin-top: 1rem;">
                            <i class="fas fa-plus"></i> إنشاء أول كوبون
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($coupons->hasPages())
    <div style="padding: 1rem; border-top: 1px solid var(--border-color);">
        {{ $coupons->links() }}
    </div>
    @endif
</div>

@endsection

