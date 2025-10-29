@extends('layouts.admin')

@section('title', 'الحملات التسويقية')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">📨 الحملات التسويقية</h1>
                <div class="btn-group">
                    <a href="{{ route('admin.campaigns.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> إنشاء حملة جديدة
                    </a>
                    <a href="{{ route('admin.analytics.index') }}" class="btn btn-secondary">
                        <i class="fas fa-chart-bar"></i> التحليلات
                    </a>
                </div>
            </div>
        </div>
    </div>

    @if($campaigns->count() > 0)
        <!-- إحصائيات الحملات -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h6 class="card-title">إجمالي الحملات</h6>
                        <h2 class="mb-0">{{ $campaigns->total() }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h6 class="card-title">حملات مكتملة</h6>
                        <h2 class="mb-0">{{ $campaigns->where('status', 'completed')->count() }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-white">
                    <div class="card-body">
                        <h6 class="card-title">حملات قيد التشغيل</h6>
                        <h2 class="mb-0">{{ $campaigns->where('status', 'running')->count() }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h6 class="card-title">حملات مجمدة</h6>
                        <h2 class="mb-0">{{ $campaigns->where('status', 'paused')->count() }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- جدول الحملات -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">جميع الحملات التسويقية</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>اسم الحملة</th>
                                        <th>الحالة</th>
                                        <th>الشريحة المستهدفة</th>
                                        <th>القنوات</th>
                                        <th>المستلمين</th>
                                        <th>تم الإرسال</th>
                                        <th>فشل</th>
                                        <th>نسبة النجاح</th>
                                        <th>تاريخ الإنشاء</th>
                                        <th>الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($campaigns as $campaign)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <a href="{{ route('admin.campaigns.details', $campaign->id) }}">
                                                {{ $campaign->name }}
                                            </a>
                                        </td>
                                        <td>
                                            @switch($campaign->status)
                                                @case('completed')
                                                    <span class="badge badge-success">مكتملة</span>
                                                    @break
                                                @case('running')
                                                    <span class="badge badge-warning">قيد التشغيل</span>
                                                    @break
                                                @case('paused')
                                                    <span class="badge badge-secondary">مجمدة</span>
                                                    @break
                                                @default
                                                    <span class="badge badge-info">مجدولة</span>
                                            @endswitch
                                        </td>
                                        <td>{{ $campaign->segment }}</td>
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
                                        <td>{{ $campaign->created_at->diffForHumans() }}</td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.campaigns.details', $campaign->id) }}"
                                                   class="btn btn-outline-info">
                                                    <i class="fas fa-eye"></i> عرض
                                                </a>
                                                @if($campaign->status !== 'completed')
                                                    <button class="btn btn-outline-warning" onclick="pauseCampaign({{ $campaign->id }})">
                                                        <i class="fas fa-pause"></i> إيقاف
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $campaigns->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- رسالة عدم وجود حملات -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-paper-plane fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">لا توجد حملات تسويقية بعد</h4>
                        <p class="text-muted mb-4">ابدأ في إنشاء حملاتك التسويقية الأولى للوصول إلى عملائك</p>
                        <a href="{{ route('admin.campaigns.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> إنشاء أول حملة تسويقية
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
function pauseCampaign(campaignId) {
    if (confirm('هل أنت متأكد من إيقاف هذه الحملة؟')) {
        // إضافة منطق إيقاف الحملة هنا
        alert('سيتم إيقاف الحملة قريباً');
    }
}
</script>
@endsection
