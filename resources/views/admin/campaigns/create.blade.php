@extends('layouts.admin')

@section('title', 'إنشاء حملة تسويقية جديدة')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">📨 إنشاء حملة تسويقية جديدة</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.campaigns.send') }}" method="POST">
                        @csrf

                        <!-- اسم الحملة -->
                        <div class="mb-3">
                            <label for="name" class="form-label">اسم الحملة *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- الشريحة المستهدفة -->
                        <div class="mb-3">
                            <label for="segment" class="form-label">الشريحة المستهدفة *</label>
                            <select class="form-select @error('segment') is-invalid @enderror" 
                                id="segment" name="segment" required onchange="updatePreview()">
                                <option value="">اختر الشريحة...</option>
                                @foreach($segments as $key => $label)
                                    <option value="{{ $key }}" {{ old('segment') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('segment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted d-block mt-1" id="segment-info"></small>
                        </div>

                        <!-- نوع الحملة (Quick Templates) -->
                        <div class="mb-3">
                            <label class="form-label">قوالب سريعة (اختياري)</label>
                            <div class="btn-group w-100" role="group">
                                <button type="button" class="btn btn-outline-primary" onclick="useTemplate('promotional')">
                                    🎁 ترويجية
                                </button>
                                <button type="button" class="btn btn-outline-success" onclick="useTemplate('welcome')">
                                    👋 ترحيب
                                </button>
                                <button type="button" class="btn btn-outline-warning" onclick="useTemplate('winback')">
                                    🔄 استعادة
                                </button>
                                <button type="button" class="btn btn-outline-info" onclick="useTemplate('vip')">
                                    👑 VIP
                                </button>
                            </div>
                        </div>

                        <!-- الرسالة -->
                        <div class="mb-3">
                            <label for="message" class="form-label">نص الرسالة *</label>
                            <textarea class="form-control @error('message') is-invalid @enderror" 
                                id="message" name="message" rows="6" required 
                                placeholder="اكتب رسالتك هنا... يمكنك استخدام {name} لاسم العميل">{{ old('message') }}</textarea>
                            @error('message')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                <strong>متغيرات متاحة:</strong> {name}, {first_name}, {email}, {phone}
                            </small>
                        </div>

                        <!-- معاينة الرسالة -->
                        <div class="mb-3">
                            <label class="form-label">معاينة الرسالة</label>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0">
                                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center" 
                                                style="width: 40px; height: 40px;">
                                                <i class="fab fa-whatsapp"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="bg-white p-3 rounded shadow-sm" style="max-width: 400px;">
                                                <p class="mb-0" id="message-preview" style="white-space: pre-wrap;">
                                                    اكتب رسالتك لمعاينتها...
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- قنوات الإرسال -->
                        <div class="mb-3">
                            <label class="form-label">قنوات الإرسال *</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="channels[]" value="whatsapp" 
                                    id="channel_whatsapp" {{ in_array('whatsapp', old('channels', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="channel_whatsapp">
                                    <i class="fab fa-whatsapp text-success"></i> WhatsApp
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="channels[]" value="sms" 
                                    id="channel_sms" {{ in_array('sms', old('channels', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="channel_sms">
                                    <i class="fas fa-sms text-primary"></i> SMS
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="channels[]" value="email" 
                                    id="channel_email" {{ in_array('email', old('channels', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="channel_email">
                                    <i class="fas fa-envelope text-info"></i> Email
                                </label>
                            </div>
                            @error('channels')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror>
                        </div>

                        <!-- أزرار الإجراءات -->
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.analytics.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-right"></i> رجوع
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> إرسال الحملة الآن
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// تحديث معاينة الرسالة
document.getElementById('message').addEventListener('input', function() {
    let message = this.value;
    message = message.replace(/{name}/g, 'أحمد محمد');
    message = message.replace(/{first_name}/g, 'أحمد');
    message = message.replace(/{email}/g, 'customer@example.com');
    message = message.replace(/{phone}/g, '0501234567');
    
    document.getElementById('message-preview').textContent = message || 'اكتب رسالتك لمعاينتها...';
});

// استخدام قالب جاهز
function useTemplate(type) {
    const templates = {
        promotional: "مرحباً {name}! 🎉\n\nعرض خاص لك على منتجاتنا المميزة\nخصم 15% باستخدام الكود: SPECIAL15\n\nاحصل عليه الآن من متجرنا 🌿\n" + "{{ url('/') }}",
        welcome: "مرحباً {name} في لُجين الزراعية! 🎉\n\nشكراً لك على طلبك الأول معنا!\n\nنحن سعداء بانضمامك لعائلتنا.\nاستمتع بمنتجاتنا الطبيعية 🌿",
        winback: "مرحباً {name}! 😊\n\nافتقدناك! نود أن نراك مجدداً في متجرنا.\n\nكهدية خاصة، احصل على خصم 15% على طلبك القادم\nاستخدم الكود: WELCOME15\n\nتسوق الآن 🌿",
        vip: "عزيزي {name} 👑\n\nكعميل VIP مميز، نقدم لك:\n\n✨ خصم 20% على جميع المنتجات\n\nهذا العرض حصري لك فقط!\nصالح حتى نهاية الأسبوع.\n\nشكراً لولائك 🌿"
    };
    
    document.getElementById('message').value = templates[type];
    document.getElementById('message').dispatchEvent(new Event('input'));
}

// تحديث معلومات الشريحة
function updatePreview() {
    const segment = document.getElementById('segment').value;
    const info = {
        vip: 'العملاء الذين أنفقوا أكثر من 5000 ر.س',
        active: 'العملاء الذين اشتروا خلال آخر 30 يوم',
        inactive: 'العملاء الذين لم يشتروا منذ 90 يوم',
        new: 'العملاء الذين قاموا بأول طلب خلال آخر 7 أيام',
        repeat: 'العملاء الذين لديهم طلبين أو أكثر',
        churn_risk: 'العملاء المعرضين للمغادرة (اشتروا منذ 60-120 يوم)',
        all: 'جميع العملاء الذين لديهم طلبات'
    };
    
    document.getElementById('segment-info').textContent = info[segment] || '';
}
</script>
@endsection

