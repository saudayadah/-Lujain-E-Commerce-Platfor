@extends('layouts.admin')

@section('title', 'تحليلات العملاء والحملات')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">📊 تحليلات العملاء والحملات التسويقية</h1>
        </div>
    </div>

    <!-- إحصائيات عامة -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h6 class="card-title">إجمالي العملاء</h6>
                    <h2 class="mb-0">{{ number_format($stats['total_customers']) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h6 class="card-title">إجمالي الطلبات</h6>
                    <h2 class="mb-0">{{ number_format($stats['total_orders']) }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <h6 class="card-title">إجمالي الإيرادات</h6>
                    <h2 class="mb-0">{{ number_format($stats['total_revenue'], 2) }} ر.س</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h6 class="card-title">متوسط قيمة الطلب</h6>
                    <h2 class="mb-0">{{ number_format($stats['average_order_value'], 2) }} ر.س</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- شرائح العملاء -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">🎯 شرائح العملاء للاستهداف</h5>
                    <a href="{{ route('admin.campaigns.create') }}" class="btn btn-primary">
                        <i class="fas fa-paper-plane"></i> إنشاء حملة جديدة
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- VIP -->
                        <div class="col-md-4 mb-3">
                            <div class="card border-warning">
                                <div class="card-body">
                                    <h6 class="card-title">👑 عملاء VIP</h6>
                                    <h3 class="text-warning">{{ $stats['vip_customers'] }}</h3>
                                    <p class="text-muted small mb-2">العملاء الذين أنفقوا أكثر من 5000 ر.س</p>
                                    <div class="btn-group btn-group-sm w-100" role="group">
                                        <a href="{{ route('admin.analytics.segment', 'vip') }}" class="btn btn-outline-warning">
                                            عرض القائمة
                                        </a>
                                        <button type="button" class="btn btn-warning text-white" onclick="quickCampaign('vip', 'vip')">
                                            إرسال حملة
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- نشطين -->
                        <div class="col-md-4 mb-3">
                            <div class="card border-success">
                                <div class="card-body">
                                    <h6 class="card-title">✅ عملاء نشطين</h6>
                                    <h3 class="text-success">{{ $stats['active_customers'] }}</h3>
                                    <p class="text-muted small mb-2">اشتروا خلال آخر 30 يوم</p>
                                    <div class="btn-group btn-group-sm w-100" role="group">
                                        <a href="{{ route('admin.analytics.segment', 'active') }}" class="btn btn-outline-success">
                                            عرض القائمة
                                        </a>
                                        <button type="button" class="btn btn-success" onclick="quickCampaign('active', 'promotional')">
                                            إرسال حملة
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- خاملين -->
                        <div class="col-md-4 mb-3">
                            <div class="card border-danger">
                                <div class="card-body">
                                    <h6 class="card-title">😴 عملاء خاملين</h6>
                                    <h3 class="text-danger">{{ $stats['inactive_customers'] }}</h3>
                                    <p class="text-muted small mb-2">لم يشتروا منذ 90 يوم</p>
                                    <div class="btn-group btn-group-sm w-100" role="group">
                                        <a href="{{ route('admin.analytics.segment', 'inactive') }}" class="btn btn-outline-danger">
                                            عرض القائمة
                                        </a>
                                        <button type="button" class="btn btn-danger" onclick="quickCampaign('inactive', 'winback')">
                                            استعادة العملاء
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- جدد -->
                        <div class="col-md-4 mb-3">
                            <div class="card border-info">
                                <div class="card-body">
                                    <h6 class="card-title">🆕 عملاء جدد</h6>
                                    <h3 class="text-info">{{ $stats['new_customers'] }}</h3>
                                    <p class="text-muted small mb-2">أول طلب خلال آخر 7 أيام</p>
                                    <div class="btn-group btn-group-sm w-100" role="group">
                                        <a href="{{ route('admin.analytics.segment', 'new') }}" class="btn btn-outline-info">
                                            عرض القائمة
                                        </a>
                                        <button type="button" class="btn btn-info" onclick="quickCampaign('new', 'welcome')">
                                            رسالة ترحيب
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- متكررين -->
                        <div class="col-md-4 mb-3">
                            <div class="card border-primary">
                                <div class="card-body">
                                    <h6 class="card-title">🔄 عملاء متكررين</h6>
                                    <h3 class="text-primary">{{ $stats['repeat_customers'] }}</h3>
                                    <p class="text-muted small mb-2">لديهم طلبين أو أكثر</p>
                                    <div class="btn-group btn-group-sm w-100" role="group">
                                        <a href="{{ route('admin.analytics.segment', 'repeat') }}" class="btn btn-outline-primary">
                                            عرض القائمة
                                        </a>
                                        <button type="button" class="btn btn-primary" onclick="quickCampaign('repeat', 'promotional')">
                                            إرسال حملة
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- معرضين للمغادرة -->
                        <div class="col-md-4 mb-3">
                            <div class="card border-dark">
                                <div class="card-body">
                                    <h6 class="card-title">⚠️ معرضين للمغادرة</h6>
                                    <h3 class="text-dark">{{ $stats['churn_risk_customers'] }}</h3>
                                    <p class="text-muted small mb-2">اشتروا منذ 60-120 يوم</p>
                                    <div class="btn-group btn-group-sm w-100" role="group">
                                        <a href="{{ route('admin.analytics.segment', 'churn_risk') }}" class="btn btn-outline-dark">
                                            عرض القائمة
                                        </a>
                                        <button type="button" class="btn btn-dark" onclick="quickCampaign('churn_risk', 'winback')">
                                            استعادة العملاء
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- أفضل 10 عملاء -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">🏆 أفضل 10 عملاء</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>الاسم</th>
                                    <th>عدد الطلبات</th>
                                    <th>إجمالي الإنفاق</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topCustomers as $index => $customer)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <a href="{{ route('admin.analytics.customer', $customer->id) }}">
                                            {{ $customer->name }}
                                        </a>
                                    </td>
                                    <td>{{ $customer->orders_count }}</td>
                                    <td>{{ number_format($customer->total_spent, 2) }} ر.س</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- إحصائيات الحملات -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">📨 إحصائيات الحملات</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>إجمالي الحملات</span>
                            <strong>{{ $campaignStats['total_campaigns'] }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>حملات مكتملة</span>
                            <strong class="text-success">{{ $campaignStats['completed_campaigns'] }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>حملات مجدولة</span>
                            <strong class="text-warning">{{ $campaignStats['scheduled_campaigns'] }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>إجمالي الرسائل المرسلة</span>
                            <strong class="text-info">{{ number_format($campaignStats['total_sent_messages']) }}</strong>
                        </li>
                    </ul>
                    
                    <div class="mt-3">
                        <a href="{{ route('admin.campaigns.index') }}" class="btn btn-outline-primary w-100">
                            عرض جميع الحملات
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- آخر الحملات -->
    @if($recentCampaigns->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">📧 آخر الحملات</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>اسم الحملة</th>
                                    <th>القنوات</th>
                                    <th>المستلمين</th>
                                    <th>تم الإرسال</th>
                                    <th>فشل</th>
                                    <th>نسبة النجاح</th>
                                    <th>التاريخ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentCampaigns as $campaign)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.campaigns.details', $campaign->id) }}">
                                            {{ $campaign->name }}
                                        </a>
                                    </td>
                                    <td>
                                        @foreach($campaign->channels as $channel)
                                            <span class="badge bg-secondary">{{ $channel }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ $campaign->total_recipients }}</td>
                                    <td class="text-success">{{ $campaign->sent_count }}</td>
                                    <td class="text-danger">{{ $campaign->failed_count }}</td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar bg-success" role="progressbar" 
                                                style="width: {{ $campaign->success_rate }}%">
                                                {{ number_format($campaign->success_rate, 1) }}%
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $campaign->sent_at?->diffForHumans() ?? 'مجدولة' }}</td>
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

<script>
function quickCampaign(segment, type) {
    if (!confirm(`هل تريد إرسال حملة ${type} لشريحة ${segment}؟`)) {
        return;
    }

    fetch('{{ route("admin.campaigns.quick") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ segment, type })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(`تم إرسال الحملة بنجاح!\nأرسلت: ${data.results.sent}\nفشلت: ${data.results.failed}`);
            location.reload();
        } else {
            alert('فشل إرسال الحملة');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('حدث خطأ أثناء إرسال الحملة');
    });
}
</script>
@endsection

