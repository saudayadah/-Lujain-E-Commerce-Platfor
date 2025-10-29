@extends('layouts.admin')

@section('title', 'تفاصيل العميل - ' . $customer->name)

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-outline btn-sm" style="margin-bottom: 1rem;">
            <i class="fas fa-arrow-right"></i> العودة للعملاء
        </a>
        <h1 class="page-title">
            <i class="fas fa-user"></i>
            تفاصيل العميل
        </h1>
    </div>
    <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-primary">
        <i class="fas fa-edit"></i> تعديل البيانات
    </a>
</div>

@if(session('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 1.5rem;">
    <!-- Customer Info -->
    <div>
        <div class="card">
            <div style="text-align: center; padding: 2rem 1rem;">
                <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 2rem; margin: 0 auto 1rem;">
                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                </div>
                <h2 style="margin: 0 0 0.5rem 0;">{{ $customer->name }}</h2>
                <p style="color: var(--gray-500); margin-bottom: 1rem;">عميل منذ {{ $customer->created_at->diffForHumans() }}</p>
                
                <div style="display: flex; flex-direction: column; gap: 0.75rem; text-align: right; margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-color);">
                    <div>
                        <i class="fas fa-envelope" style="color: var(--primary); width: 20px;"></i>
                        <span>{{ $customer->email }}</span>
                    </div>
                    @if($customer->phone)
                    <div>
                        <i class="fas fa-phone" style="color: var(--primary); width: 20px;"></i>
                        <span>{{ $customer->phone }}</span>
                    </div>
                    @endif
                    @if($customer->address)
                    <div>
                        <i class="fas fa-map-marker-alt" style="color: var(--primary); width: 20px;"></i>
                        <span>{{ $customer->address }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Stats -->
        <div class="card" style="margin-top: 1.5rem;">
            <h3 style="margin: 0 0 1rem 0; padding-bottom: 1rem; border-bottom: 1px solid var(--border-color);">
                <i class="fas fa-chart-bar"></i> الإحصائيات
            </h3>
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="color: var(--gray-600);">إجمالي الطلبات</span>
                    <strong style="font-size: 1.25rem; color: var(--primary);">{{ $stats['total_orders'] }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="color: var(--gray-600);">إجمالي المشتريات</span>
                    <strong style="font-size: 1.25rem; color: var(--success);">{{ number_format($stats['total_spent'], 2) }} ر.س</strong>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="color: var(--gray-600);">طلبات قيد الانتظار</span>
                    <strong style="font-size: 1.25rem; color: var(--warning);">{{ $stats['pending_orders'] }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="color: var(--gray-600);">طلبات مكتملة</span>
                    <strong style="font-size: 1.25rem; color: var(--success);">{{ $stats['completed_orders'] }}</strong>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Orders History -->
    <div>
        <div class="card">
            <h3 style="margin: 0 0 1.5rem 0;">
                <i class="fas fa-shopping-bag"></i> سجل الطلبات
            </h3>
            
            @if($customer->orders->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @foreach($customer->orders as $order)
                <div style="border: 1px solid var(--border-color); border-radius: 8px; padding: 1rem;">
                    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 0.75rem;">
                        <div>
                            <a href="{{ route('admin.orders.show', $order) }}" style="font-weight: 600; color: var(--primary); text-decoration: none;">
                                {{ $order->order_number }}
                            </a>
                            <p style="color: var(--gray-500); font-size: 0.875rem; margin: 0.25rem 0 0 0;">
                                {{ $order->created_at->format('Y-m-d h:i A') }}
                            </p>
                        </div>
                        <div style="text-align: left;">
                            @php
                                $statusColors = [
                                    'pending' => 'warning',
                                    'confirmed' => 'info',
                                    'processing' => 'primary',
                                    'shipped' => 'secondary',
                                    'delivered' => 'success',
                                    'cancelled' => 'danger',
                                ];
                                $statusLabels = [
                                    'pending' => 'قيد الانتظار',
                                    'confirmed' => 'مؤكد',
                                    'processing' => 'قيد التجهيز',
                                    'shipped' => 'تم الشحن',
                                    'delivered' => 'تم التوصيل',
                                    'cancelled' => 'ملغي',
                                ];
                            @endphp
                            <span class="badge badge-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                {{ $statusLabels[$order->status] ?? $order->status }}
                            </span>
                        </div>
                    </div>
                    
                    <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 0.75rem; border-top: 1px solid var(--border-color);">
                        <span style="color: var(--gray-600);">{{ $order->items->count() }} منتج</span>
                        <strong style="color: var(--success); font-size: 1.125rem;">{{ number_format($order->total, 2) }} ر.س</strong>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div style="text-align: center; padding: 3rem;">
                <i class="fas fa-shopping-bag" style="font-size: 3rem; color: var(--gray-300); margin-bottom: 1rem;"></i>
                <p style="color: var(--gray-500);">لا توجد طلبات بعد</p>
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

