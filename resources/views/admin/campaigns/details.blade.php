@extends('layouts.admin')

@section('title', 'تفاصيل الحملة: ' . $campaign->name)

@section('content')
<div class="container-fluid py-4">
    <!-- العنوان والأزرار -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('admin.campaigns.index') }}" class="btn btn-outline-secondary btn-sm mb-2">
                        <i class="fas fa-arrow-right"></i> العودة للحملات
                    </a>
                    <h1 class="mb-0">📨 {{ $campaign->name }}</h1>
                    <p class="text-muted mb-0">تم الإنشاء: {{ $campaign->created_at->format('Y-m-d H:i') }}</p>
                </div>
                <div>
                    @switch($campaign->status)
                        @case('completed')
                            <span class="badge badge-success p-3" style="font-size: 1.1em;">مكتملة</span>
                            @break
                        @case('running')
                            <span class="badge badge-warning p-3" style="font-size: 1.1em;">قيد التشغيل</span>
                            @break
                        @case('paused')
                            <span class="badge badge-secondary p-3" style="font-size: 1.1em;">مجمدة</span>
                            @break
                        @case('scheduled')
                            <span class="badge badge-info p-3" style="font-size: 1.1em;">مجدولة</span>
                            @break
                        @default
                            <span class="badge badge-light p-3" style="font-size: 1.1em;">{{ $campaign->status }}</span>
                    @endswitch
                </div>
            </div>
        </div>
    </div>

    <!-- بطاقات الإحصائيات -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6 class="card-title"><i class="fas fa-users"></i> إجمالي المستلمين</h6>
                    <h2 class="mb-0">{{ number_format($campaign->total_recipients) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6 class="card-title"><i class="fas fa-paper-plane"></i> تم الإرسال</h6>
                    <h2 class="mb-0">{{ number_format($campaign->sent_count) }}</h2>
                    <small>{{ number_format($campaign->sent_count > 0 ? ($campaign->sent_count / $campaign->total_recipients) * 100 : 0, 1) }}%</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6 class="card-title"><i class="fas fa-check-double"></i> تم التوصيل</h6>
                    <h2 class="mb-0">{{ number_format($campaign->delivered_count) }}</h2>
                    <small>{{ number_format($campaign->success_rate, 1) }}%</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h6 class="card-title"><i class="fas fa-times-circle"></i> فشل</h6>
                    <h2 class="mb-0">{{ number_format($campaign->failed_count) }}</h2>
                    <small>{{ number_format($campaign->sent_count > 0 ? ($campaign->failed_count / $campaign->sent_count) * 100 : 0, 1) }}%</small>
                </div>
            </div>
        </div>
    </div>

    <!-- إحصائيات التفاعل -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-info">
                <div class="card-body text-center">
                    <i class="fas fa-envelope-open text-info fa-2x mb-2"></i>
                    <h6 class="text-muted">معدل الفتح</h6>
                    <h3 class="mb-0 text-info">{{ number_format($campaign->open_rate, 1) }}%</h3>
                    <small class="text-muted">{{ number_format($campaign->opened_count) }} فتح</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-primary">
                <div class="card-body text-center">
                    <i class="fas fa-mouse-pointer text-primary fa-2x mb-2"></i>
                    <h6 class="text-muted">معدل النقر</h6>
                    <h3 class="mb-0 text-primary">{{ number_format($campaign->click_rate, 1) }}%</h3>
                    <small class="text-muted">{{ number_format($campaign->clicked_count) }} نقرة</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-success">
                <div class="card-body text-center">
                    <i class="fas fa-shopping-cart text-success fa-2x mb-2"></i>
                    <h6 class="text-muted">معدل التحويل</h6>
                    <h3 class="mb-0 text-success">{{ number_format($campaign->conversion_rate, 1) }}%</h3>
                    <small class="text-muted">{{ number_format($campaign->converted_count) }} تحويل</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-warning">
                <div class="card-body text-center">
                    <i class="fas fa-chart-line text-warning fa-2x mb-2"></i>
                    <h6 class="text-muted">العائد على الاستثمار</h6>
                    <h3 class="mb-0 text-warning">{{ number_format($campaign->roi, 1) }}%</h3>
                    <small class="text-muted">ROI</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- معلومات الحملة -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-info-circle"></i> معلومات الحملة</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th width="40%">اسم الحملة:</th>
                                <td>{{ $campaign->name }}</td>
                            </tr>
                            <tr>
                                <th>نوع الحملة:</th>
                                <td>
                                    <span class="badge bg-secondary">{{ $campaign->type ?? 'عام' }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>الشريحة المستهدفة:</th>
                                <td>
                                    <span class="badge bg-info">{{ $campaign->segment_type ?? 'غير محدد' }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>القنوات:</th>
                                <td>
                                    @if($campaign->channels && is_array($campaign->channels))
                                        @foreach($campaign->channels as $channel)
                                            <span class="badge bg-primary me-1">{{ $channel }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-muted">غير محدد</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>تاريخ الإنشاء:</th>
                                <td>{{ $campaign->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                            @if($campaign->scheduled_at)
                            <tr>
                                <th>مجدولة في:</th>
                                <td>{{ $campaign->scheduled_at->format('Y-m-d H:i') }}</td>
                            </tr>
                            @endif
                            @if($campaign->sent_at)
                            <tr>
                                <th>تاريخ الإرسال:</th>
                                <td>{{ $campaign->sent_at->format('Y-m-d H:i') }}</td>
                            </tr>
                            @endif
                            @if($campaign->completed_at)
                            <tr>
                                <th>تاريخ الإكمال:</th>
                                <td>{{ $campaign->completed_at->format('Y-m-d H:i') }}</td>
                            </tr>
                            @endif
                            @if($campaign->creator)
                            <tr>
                                <th>أنشأها:</th>
                                <td>{{ $campaign->creator->name }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- محتوى الرسالة -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-comment-alt"></i> محتوى الرسالة</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-light border">
                        <p class="mb-0" style="white-space: pre-wrap;">{{ $campaign->message ?? 'لا توجد رسالة' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- الرسم البياني للأداء -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-chart-bar"></i> أداء الحملة</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h6 class="mb-3">مسار التحويل (Funnel)</h6>
                            <div class="mb-2">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>تم الإرسال</span>
                                    <span>{{ number_format($campaign->sent_count) }} (100%)</span>
                                </div>
                                <div class="progress" style="height: 30px;">
                                    <div class="progress-bar bg-primary" style="width: 100%"></div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>تم التوصيل</span>
                                    <span>{{ number_format($campaign->delivered_count) }} ({{ number_format($campaign->success_rate, 1) }}%)</span>
                                </div>
                                <div class="progress" style="height: 30px;">
                                    <div class="progress-bar bg-success" style="width: {{ $campaign->success_rate }}%"></div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>تم الفتح</span>
                                    <span>{{ number_format($campaign->opened_count) }} ({{ number_format($campaign->open_rate, 1) }}%)</span>
                                </div>
                                <div class="progress" style="height: 30px;">
                                    <div class="progress-bar bg-info" style="width: {{ $campaign->open_rate }}%"></div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>تم النقر</span>
                                    <span>{{ number_format($campaign->clicked_count) }} ({{ number_format($campaign->click_rate, 1) }}%)</span>
                                </div>
                                <div class="progress" style="height: 30px;">
                                    <div class="progress-bar bg-warning" style="width: {{ $campaign->click_rate }}%"></div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>تم التحويل</span>
                                    <span>{{ number_format($campaign->converted_count) }} ({{ number_format($campaign->conversion_rate, 1) }}%)</span>
                                </div>
                                <div class="progress" style="height: 30px;">
                                    <div class="progress-bar bg-success" style="width: {{ $campaign->conversion_rate }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- العملاء المستهدفين -->
    @if($campaign->targetCustomers && $campaign->targetCustomers->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-users"></i> العملاء المستهدفين ({{ $campaign->targetCustomers->count() }})</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>اسم العميل</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>الهاتف</th>
                                    <th>الحالة</th>
                                    <th>تاريخ الإرسال</th>
                                    <th>تاريخ التوصيل</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($campaign->targetCustomers->take(50) as $customer)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->phone }}</td>
                                    <td>
                                        @switch($customer->pivot->status)
                                            @case('delivered')
                                                <span class="badge badge-success">تم التوصيل</span>
                                                @break
                                            @case('sent')
                                                <span class="badge badge-info">تم الإرسال</span>
                                                @break
                                            @case('failed')
                                                <span class="badge badge-danger">فشل</span>
                                                @break
                                            @case('opened')
                                                <span class="badge badge-primary">تم الفتح</span>
                                                @break
                                            @case('clicked')
                                                <span class="badge badge-warning">تم النقر</span>
                                                @break
                                            @case('converted')
                                                <span class="badge badge-success">تم التحويل</span>
                                                @break
                                            @default
                                                <span class="badge badge-secondary">{{ $customer->pivot->status }}</span>
                                        @endswitch
                                    </td>
                                    <td>{{ $customer->pivot->sent_at ? \Carbon\Carbon::parse($customer->pivot->sent_at)->format('Y-m-d H:i') : '-' }}</td>
                                    <td>{{ $customer->pivot->delivered_at ? \Carbon\Carbon::parse($customer->pivot->delivered_at)->format('Y-m-d H:i') : '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($campaign->targetCustomers->count() > 50)
                        <p class="text-muted text-center mt-3">
                            <i class="fas fa-info-circle"></i> عرض أول 50 عميل من أصل {{ number_format($campaign->targetCustomers->count()) }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

