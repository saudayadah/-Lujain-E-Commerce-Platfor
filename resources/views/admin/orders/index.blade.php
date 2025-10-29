@extends('layouts.admin')

@section('title', 'إدارة الطلبات')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="fas fa-shopping-cart"></i>
            إدارة الطلبات
        </h1>
        @if(request('status') || request('payment_status'))
        <div style="margin-top: 0.75rem; display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap;">
            <span style="color: var(--gray-600); font-weight: 600; font-size: 0.875rem;">الفلاتر النشطة:</span>
            @if(request('status'))
            <span style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.375rem 0.875rem; background: linear-gradient(135deg, #f59e0b, #d97706); color: white; border-radius: 20px; font-size: 0.875rem; font-weight: 600;">
                <i class="fas fa-filter"></i>
                الحالة: {{ request('status') }}
                <a href="{{ route('admin.orders.index') }}" style="color: white; margin-right: 0.25rem;">
                    <i class="fas fa-times-circle"></i>
                </a>
            </span>
            @endif
            @if(request('payment_status'))
            <span style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.375rem 0.875rem; background: linear-gradient(135deg, #10b981, #059669); color: white; border-radius: 20px; font-size: 0.875rem; font-weight: 600;">
                <i class="fas fa-filter"></i>
                حالة الدفع: {{ request('payment_status') }}
                <a href="{{ route('admin.orders.index') }}" style="color: white; margin-right: 0.25rem;">
                    <i class="fas fa-times-circle"></i>
                </a>
            </span>
            @endif
            <a href="{{ route('admin.orders.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.375rem 0.875rem; background: var(--gray-200); color: var(--dark); border-radius: 20px; font-size: 0.875rem; font-weight: 600; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='var(--gray-300)'" onmouseout="this.style.background='var(--gray-200)'">
                <i class="fas fa-redo"></i>
                إعادة تعيين الفلاتر
            </a>
        </div>
        @endif
    </div>
    <div style="display: flex; gap: 0.75rem;">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline btn-sm">
            <i class="fas fa-arrow-right"></i> العودة للوحة التحكم
        </a>
    </div>
</div>

<!-- Quick Filters -->
<div class="card" style="margin-bottom: 1.5rem;">
    <div style="padding: 1.5rem;">
        <h3 style="font-weight: 700; color: var(--dark); margin-bottom: 1rem; font-size: 0.9375rem;">
            <i class="fas fa-sliders-h" style="color: var(--primary); margin-left: 0.25rem;"></i>
            فلترة سريعة
        </h3>
        <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
            <a href="{{ route('admin.orders.index') }}" class="btn {{ !request('status') && !request('payment_status') ? 'btn-primary' : 'btn-outline' }} btn-sm">
                <i class="fas fa-list"></i> جميع الطلبات
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="btn {{ request('status') == 'pending' ? 'btn-warning' : 'btn-outline' }} btn-sm">
                <i class="fas fa-clock"></i> قيد المراجعة
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'confirmed']) }}" class="btn {{ request('status') == 'confirmed' ? 'btn-info' : 'btn-outline' }} btn-sm">
                <i class="fas fa-check"></i> مؤكدة
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}" class="btn {{ request('status') == 'processing' ? 'btn-info' : 'btn-outline' }} btn-sm">
                <i class="fas fa-box"></i> قيد التجهيز
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'shipped']) }}" class="btn {{ request('status') == 'shipped' ? 'btn-info' : 'btn-outline' }} btn-sm">
                <i class="fas fa-truck"></i> تم الشحن
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'delivered']) }}" class="btn {{ request('status') == 'delivered' ? 'btn-success' : 'btn-outline' }} btn-sm">
                <i class="fas fa-check-double"></i> تم التوصيل
            </a>
            <a href="{{ route('admin.orders.index', ['payment_status' => 'paid']) }}" class="btn {{ request('payment_status') == 'paid' ? 'btn-success' : 'btn-outline' }} btn-sm">
                <i class="fas fa-dollar-sign"></i> مدفوعة
            </a>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>رقم الطلب</th>
                    <th>العميل</th>
                    <th>المبلغ</th>
                    <th>الحالة</th>
                    <th>التاريخ</th>
                    <th style="text-align: center;">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                @php
                    $statusConfig = [
                        'pending' => ['color' => '#f59e0b', 'bg' => '#fef3c7', 'icon' => 'fa-clock', 'label' => 'قيد الانتظار'],
                        'confirmed' => ['color' => '#3b82f6', 'bg' => '#dbeafe', 'icon' => 'fa-check-circle', 'label' => 'مؤكد'],
                        'processing' => ['color' => '#8b5cf6', 'bg' => '#e9d5ff', 'icon' => 'fa-cog fa-spin', 'label' => 'قيد التجهيز'],
                        'shipped' => ['color' => '#06b6d4', 'bg' => '#cffafe', 'icon' => 'fa-shipping-fast', 'label' => 'تم الشحن'],
                        'delivered' => ['color' => '#10b981', 'bg' => '#d1fae5', 'icon' => 'fa-check-double', 'label' => 'تم التوصيل'],
                        'cancelled' => ['color' => '#ef4444', 'bg' => '#fee2e2', 'icon' => 'fa-times-circle', 'label' => 'ملغي'],
                        'refunded' => ['color' => '#6b7280', 'bg' => '#f3f4f6', 'icon' => 'fa-undo', 'label' => 'مسترد']
                    ];
                    $config = $statusConfig[$order->status] ?? ['color' => '#6b7280', 'bg' => '#f3f4f6', 'icon' => 'fa-question', 'label' => $order->status];
                @endphp
                <tr style="transition: background 0.2s;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='white'">
                    <td style="font-weight: 700; color: var(--dark);">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-hashtag" style="color: var(--primary); font-size: 0.875rem;"></i>
                            {{ $order->order_number }}
                        </div>
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <div style="width: 35px; height: 35px; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 800; font-size: 0.875rem;">
                                {{ substr($order->user->name, 0, 1) }}
                            </div>
                            <div>
                                <div style="font-weight: 700; color: var(--dark);">{{ $order->user->name }}</div>
                                <div style="font-size: 0.75rem; color: var(--gray-600);">{{ $order->user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="font-weight: 800; color: var(--primary); font-size: 1.125rem;">{{ number_format($order->total, 2) }} ر.س</td>
                    <td>
                        <span style="display: inline-flex; align-items: center; gap: 0.5rem; background: {{ $config['bg'] }}; color: {{ $config['color'] }}; padding: 0.625rem 1.125rem; border-radius: 50px; font-weight: 800; font-size: 0.875rem; border: 2px solid {{ $config['color'] }}; box-shadow: 0 2px 8px {{ $config['color'] }}33;">
                            <i class="fas {{ $config['icon'] }}"></i>
                            {{ $config['label'] }}
                        </span>
                    </td>
                    <td style="color: var(--gray-600); font-weight: 600;">
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-calendar-alt" style="color: var(--primary); font-size: 0.875rem;"></i>
                            {{ $order->created_at->format('Y-m-d') }}
                        </div>
                        <div style="font-size: 0.75rem; color: var(--gray-500); margin-top: 0.25rem;">{{ $order->created_at->format('h:i A') }}</div>
                    </td>
                    <td style="text-align: center;">
                        <a href="{{ route('admin.orders.show', $order) }}" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.625rem 1.25rem; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; text-decoration: none; border-radius: 10px; font-weight: 700; font-size: 0.875rem; box-shadow: 0 3px 10px rgba(16, 185, 129, 0.3); transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 5px 15px rgba(16, 185, 129, 0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 3px 10px rgba(16, 185, 129, 0.3)'">
                            <i class="fas fa-eye"></i>
                            عرض
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="padding: 3rem; text-align: center; color: #9ca3af;">
                        <i class="fas fa-inbox" style="font-size: 3rem; opacity: 0.3; display: block; margin-bottom: 1rem;"></i>
                        <p style="font-size: 1.125rem;">لا توجد طلبات حالياً</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
