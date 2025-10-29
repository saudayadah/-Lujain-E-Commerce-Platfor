@extends('layouts.admin')

@section('title', 'تحليل العميل: ' . $customer->name)

@section('content')
<div class="container-fluid py-4">
    <!-- العنوان -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('admin.customers.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                        <i class="fas fa-arrow-right"></i> العودة للعملاء
                    </a>
                    <h1 class="mb-0">👤 {{ $customer->name }}</h1>
                    <p class="text-muted mb-0">عضو منذ: {{ $customer->created_at->diffForHumans() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- بطاقات الإحصائيات -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6 class="card-title"><i class="fas fa-shopping-cart"></i> إجمالي الطلبات</h6>
                    <h2 class="mb-0">{{ $analytics['total_orders'] ?? 0 }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6 class="card-title"><i class="fas fa-money-bill-wave"></i> إجمالي الإنفاق</h6>
                    <h2 class="mb-0">{{ number_format($analytics['total_spent'] ?? 0, 2) }} ر.س</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6 class="card-title"><i class="fas fa-chart-line"></i> متوسط قيمة الطلب</h6>
                    <h2 class="mb-0">{{ number_format($analytics['average_order_value'] ?? 0, 2) }} ر.س</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6 class="card-title"><i class="fas fa-calendar-alt"></i> آخر طلب</h6>
                    <h2 class="mb-0">{{ $analytics['days_since_last_order'] ?? '-' }}</h2>
                    <small>يوم</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- معلومات العميل -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-user"></i> معلومات العميل</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th width="40%">الاسم:</th>
                                <td>{{ $customer->name }}</td>
                            </tr>
                            <tr>
                                <th>البريد الإلكتروني:</th>
                                <td>{{ $customer->email }}</td>
                            </tr>
                            <tr>
                                <th>الهاتف:</th>
                                <td>{{ $customer->phone ?? 'غير محدد' }}</td>
                            </tr>
                            <tr>
                                <th>تاريخ التسجيل:</th>
                                <td>{{ $customer->created_at->format('Y-m-d') }}</td>
                            </tr>
                            <tr>
                                <th>الحالة:</th>
                                <td>
                                    @if(($analytics['is_active'] ?? false))
                                        <span class="badge badge-success">نشط</span>
                                    @else
                                        <span class="badge badge-secondary">غير نشط</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>الشريحة:</th>
                                <td>
                                    @if(($analytics['is_vip'] ?? false))
                                        <span class="badge badge-warning">VIP</span>
                                    @elseif(($analytics['is_repeat_customer'] ?? false))
                                        <span class="badge badge-primary">عميل متكرر</span>
                                    @elseif(($analytics['is_new_customer'] ?? false))
                                        <span class="badge badge-info">عميل جديد</span>
                                    @else
                                        <span class="badge badge-secondary">عادي</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- تحليلات إضافية -->
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-pie"></i> تحليلات إضافية</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <strong>معدل التحويل:</strong>
                            <span class="float-end">{{ number_format($analytics['conversion_rate'] ?? 0, 1) }}%</span>
                        </li>
                        <li class="mb-2">
                            <strong>معدل الإلغاء:</strong>
                            <span class="float-end">{{ number_format($analytics['cancellation_rate'] ?? 0, 1) }}%</span>
                        </li>
                        <li class="mb-2">
                            <strong>القيمة الدائمة (LTV):</strong>
                            <span class="float-end">{{ number_format($analytics['lifetime_value'] ?? 0, 2) }} ر.س</span>
                        </li>
                        <li class="mb-2">
                            <strong>احتمال الشراء مرة أخرى:</strong>
                            <span class="float-end">{{ number_format($analytics['churn_probability'] ?? 0, 1) }}%</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- الطلبات -->
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-shopping-bag"></i> سجل الطلبات</h5>
                </div>
                <div class="card-body">
                    @if($orders && $orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#رقم الطلب</th>
                                        <th>التاريخ</th>
                                        <th>المنتجات</th>
                                        <th>المبلغ</th>
                                        <th>حالة الدفع</th>
                                        <th>حالة الطلب</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order->id) }}">
                                                #{{ $order->id }}
                                            </a>
                                        </td>
                                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <small>{{ $order->items->count() }} منتج</small>
                                        </td>
                                        <td>{{ number_format($order->total, 2) }} ر.س</td>
                                        <td>
                                            @switch($order->payment_status)
                                                @case('paid')
                                                    <span class="badge badge-success">مدفوع</span>
                                                    @break
                                                @case('pending')
                                                    <span class="badge badge-warning">معلق</span>
                                                    @break
                                                @case('failed')
                                                    <span class="badge badge-danger">فشل</span>
                                                    @break
                                                @default
                                                    <span class="badge badge-secondary">{{ $order->payment_status }}</span>
                                            @endswitch
                                        </td>
                                        <td>
                                            @switch($order->status)
                                                @case('delivered')
                                                    <span class="badge badge-success">تم التوصيل</span>
                                                    @break
                                                @case('shipped')
                                                    <span class="badge badge-info">قيد الشحن</span>
                                                    @break
                                                @case('processing')
                                                    <span class="badge badge-warning">قيد المعالجة</span>
                                                    @break
                                                @case('cancelled')
                                                    <span class="badge badge-danger">ملغى</span>
                                                    @break
                                                @default
                                                    <span class="badge badge-secondary">{{ $order->status }}</span>
                                            @endswitch
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-shopping-cart fa-3x text-muted mb-3"></i>
                            <p class="text-muted">لا توجد طلبات لهذا العميل بعد</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- المنتجات المشتراة -->
    @if($orders && $orders->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-box"></i> المنتجات المشتراة</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>المنتج</th>
                                    <th>عدد مرات الشراء</th>
                                    <th>إجمالي الكمية</th>
                                    <th>إجمالي المبلغ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $products = [];
                                    foreach($orders as $order) {
                                        foreach($order->items as $item) {
                                            $productId = $item->product_id;
                                            if(!isset($products[$productId])) {
                                                $products[$productId] = [
                                                    'name' => $item->product->name_ar ?? 'منتج محذوف',
                                                    'count' => 0,
                                                    'quantity' => 0,
                                                    'total' => 0
                                                ];
                                            }
                                            $products[$productId]['count']++;
                                            $products[$productId]['quantity'] += $item->quantity;
                                            $products[$productId]['total'] += $item->quantity * $item->price;
                                        }
                                    }
                                    arsort($products);
                                @endphp
                                @foreach(array_slice($products, 0, 10) as $product)
                                <tr>
                                    <td>{{ $product['name'] }}</td>
                                    <td>{{ $product['count'] }} مرة</td>
                                    <td>{{ $product['quantity'] }}</td>
                                    <td>{{ number_format($product['total'], 2) }} ر.س</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

