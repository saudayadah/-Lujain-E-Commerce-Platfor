@extends('layouts.admin')

@section('title', 'عرض شريحة العملاء')

@section('content')
<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="mb-0">{{ $segmentStats['count'] }} عميل في شريحة "{{ $segmentType }}"</h1>
                <div class="btn-group">
                    <a href="{{ route('admin.analytics.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-right"></i> رجوع
                    </a>
                    <a href="{{ route('admin.analytics.export', $segmentType) }}" class="btn btn-success">
                        <i class="fas fa-file-excel"></i> تصدير Excel
                    </a>
                    <a href="{{ route('admin.campaigns.create') }}?segment={{ $segmentType }}" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> إرسال حملة
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- إحصائيات الشريحة -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted mb-2">عدد العملاء</h6>
                    <h2 class="mb-0">{{ number_format($segmentStats['count']) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted mb-2">إجمالي الإيرادات</h6>
                    <h2 class="mb-0">{{ number_format($segmentStats['total_revenue'], 2) }} ر.س</h2>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h6 class="text-muted mb-2">متوسط الطلبات</h6>
                    <h2 class="mb-0">{{ number_format($segmentStats['average_orders'], 1) }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- قائمة العملاء -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">قائمة العملاء</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>الاسم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>الهاتف</th>
                                    <th>عدد الطلبات</th>
                                    <th>إجمالي الإنفاق</th>
                                    <th>آخر طلب</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $customer)
                                <tr>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>{{ $customer->orders()->count() }}</td>
                                    <td>{{ number_format($customer->orders()->where('payment_status', 'paid')->sum('total'), 2) }} ر.س</td>
                                    <td>{{ $customer->orders()->latest()->first()?->created_at?->diffForHumans() }}</td>
                                    <td>
                                        <a href="{{ route('admin.analytics.customer', $customer->id) }}" 
                                           class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> عرض
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

