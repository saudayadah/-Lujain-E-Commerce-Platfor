@extends('layouts.admin')

@section('title', 'إعدادات الموقع')

@section('content')
<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-cog"></i>
        إعدادات الموقع
    </h1>
</div>

@if(session('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="alert alert-danger">
    <i class="fas fa-exclamation-triangle"></i>
    <ul style="margin: 0; padding-right: 20px;">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="settings-container">
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf

        <!-- قسم المظهر والصور -->
        <div class="card settings-section">
            <div class="settings-section-header">
                <h2><i class="fas fa-palette"></i> مظهر الموقع والصور</h2>
                <p>إدارة شعار الموقع والصور الرئيسية</p>
            </div>

            <div class="settings-grid">
                <!-- شعار الموقع -->
                <div class="image-upload-group">
                    <label class="form-label">
                        <i class="fas fa-image"></i> شعار الموقع (Logo)
                    </label>
                    <div class="image-preview-container">
                        @if(isset($settings['site_logo']) && $settings['site_logo']->value)
                            <img src="{{ asset('storage/' . $settings['site_logo']->value) }}" alt="شعار الموقع" class="image-preview" id="logo-preview">
                        @else
                            <div class="image-placeholder" id="logo-preview">
                                <i class="fas fa-image"></i>
                                <p>لا توجد صورة</p>
                            </div>
                        @endif
                    </div>
                    <input type="file" name="logo" id="logo" class="form-control" accept="image/*" onchange="previewImage(this, 'logo-preview')">
                    <small class="form-hint">الحجم الموصى به: 200x50 بكسل، الصيغ المدعومة: JPG, PNG, SVG</small>
                </div>

                <!-- أيقونة الموقع (Favicon) -->
                <div class="image-upload-group">
                    <label class="form-label">
                        <i class="fas fa-star"></i> أيقونة الموقع (Favicon)
                    </label>
                    <div class="image-preview-container small">
                        @if(isset($settings['site_favicon']) && $settings['site_favicon']->value)
                            <img src="{{ asset('storage/' . $settings['site_favicon']->value) }}" alt="أيقونة الموقع" class="image-preview" id="favicon-preview">
                        @else
                            <div class="image-placeholder" id="favicon-preview">
                                <i class="fas fa-star"></i>
                                <p>لا توجد أيقونة</p>
                            </div>
                        @endif
                    </div>
                    <input type="file" name="favicon" id="favicon" class="form-control" accept=".ico,.png" onchange="previewImage(this, 'favicon-preview')">
                    <small class="form-hint">الحجم الموصى به: 32x32 بكسل، الصيغ المدعومة: ICO, PNG</small>
                </div>

                <!-- صورة البانر الرئيسي -->
                <div class="image-upload-group full-width">
                    <label class="form-label">
                        <i class="fas fa-panorama"></i> صورة البانر الرئيسي (Hero Image)
                    </label>
                    <div class="image-preview-container wide">
                        @if(isset($settings['hero_image']) && $settings['hero_image']->value)
                            <img src="{{ asset('storage/' . $settings['hero_image']->value) }}" alt="صورة البانر" class="image-preview" id="hero-preview">
                        @else
                            <div class="image-placeholder" id="hero-preview">
                                <i class="fas fa-panorama"></i>
                                <p>لا توجد صورة بانر</p>
                            </div>
                        @endif
                    </div>
                    <input type="file" name="hero_image" id="hero_image" class="form-control" accept="image/*" onchange="previewImage(this, 'hero-preview')">
                    <small class="form-hint">الحجم الموصى به: 1920x600 بكسل، الصيغ المدعومة: JPG, PNG</small>
                </div>
            </div>
        </div>

        <!-- قسم معلومات الموقع -->
        <div class="card settings-section">
            <div class="settings-section-header">
                <h2><i class="fas fa-info-circle"></i> معلومات الموقع</h2>
                <p>البيانات الأساسية للموقع</p>
            </div>

            <div class="settings-grid">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-store"></i> اسم الموقع (عربي)
                    </label>
                    <input type="text" name="site_name_ar" value="{{ old('site_name_ar', $settings['site_name_ar']->value ?? 'لُجين للعسل والعطارة') }}" class="form-control" placeholder="لُجين للعسل والعطارة">
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-store"></i> اسم الموقع (إنجليزي)
                    </label>
                    <input type="text" name="site_name_en" value="{{ old('site_name_en', $settings['site_name_en']->value ?? 'Lujain Honey & Herbs') }}" class="form-control" placeholder="Lujain Honey & Herbs">
                </div>

                <div class="form-group full-width">
                    <label class="form-label">
                        <i class="fas fa-align-right"></i> وصف الموقع
                    </label>
                    <textarea name="site_description" class="form-control" rows="3" placeholder="وصف مختصر عن الموقع">{{ old('site_description', $settings['site_description']->value ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <!-- قسم معلومات التواصل -->
        <div class="card settings-section">
            <div class="settings-section-header">
                <h2><i class="fas fa-phone-alt"></i> معلومات التواصل</h2>
                <p>بيانات التواصل مع العملاء</p>
            </div>

            <div class="settings-grid">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-envelope"></i> البريد الإلكتروني
                    </label>
                    <input type="email" name="contact_email" value="{{ old('contact_email', $settings['contact_email']->value ?? '') }}" class="form-control" placeholder="info@lujain.sa">
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-phone"></i> رقم الهاتف
                    </label>
                    <input type="text" name="contact_phone" value="{{ old('contact_phone', $settings['contact_phone']->value ?? '') }}" class="form-control" placeholder="+966 50 123 4567">
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fab fa-whatsapp"></i> رقم الواتساب
                    </label>
                    <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $settings['whatsapp_number']->value ?? '') }}" class="form-control" placeholder="+966501234567">
                </div>

                <div class="form-group full-width">
                    <label class="form-label">
                        <i class="fas fa-map-marker-alt"></i> العنوان
                    </label>
                    <input type="text" name="contact_address" value="{{ old('contact_address', $settings['contact_address']->value ?? '') }}" class="form-control" placeholder="المملكة العربية السعودية">
                </div>
            </div>
        </div>

        <!-- قسم وسائل التواصل الاجتماعي -->
        <div class="card settings-section">
            <div class="settings-section-header">
                <h2><i class="fas fa-share-alt"></i> وسائل التواصل الاجتماعي</h2>
                <p>روابط حسابات التواصل الاجتماعي</p>
            </div>

            <div class="settings-grid">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fab fa-facebook"></i> فيسبوك
                    </label>
                    <input type="url" name="social_facebook" value="{{ old('social_facebook', $settings['social_facebook']->value ?? '') }}" class="form-control" placeholder="https://facebook.com/lujain">
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fab fa-twitter"></i> تويتر (X)
                    </label>
                    <input type="url" name="social_twitter" value="{{ old('social_twitter', $settings['social_twitter']->value ?? '') }}" class="form-control" placeholder="https://twitter.com/lujain">
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fab fa-instagram"></i> إنستغرام
                    </label>
                    <input type="url" name="social_instagram" value="{{ old('social_instagram', $settings['social_instagram']->value ?? '') }}" class="form-control" placeholder="https://instagram.com/lujain">
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fab fa-snapchat"></i> سناب شات
                    </label>
                    <input type="url" name="social_snapchat" value="{{ old('social_snapchat', $settings['social_snapchat']->value ?? '') }}" class="form-control" placeholder="https://snapchat.com/add/lujain">
                </div>
            </div>
        </div>

        <div class="settings-actions">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> حفظ جميع الإعدادات
            </button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-times"></i> إلغاء
            </a>
        </div>
    </form>
</div>

<style>
.settings-container {
    max-width: 1200px;
    margin: 0 auto;
}

.settings-section {
    margin-bottom: 2rem;
    background: white;
    border-radius: 15px;
    padding: 2rem;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.settings-section-header {
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--gray-200);
}

.settings-section-header h2 {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--dark);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.settings-section-header p {
    color: var(--gray-600);
    margin: 0;
    font-size: 0.9375rem;
}

.settings-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-label {
    font-weight: 600;
    color: var(--dark);
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.form-control {
    padding: 0.75rem 1rem;
    border: 2px solid var(--gray-200);
    border-radius: 10px;
    font-size: 1rem;
    transition: all 0.3s;
}

.form-control:focus {
    outline: none;
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
}

.form-hint {
    display: block;
    margin-top: 0.5rem;
    color: var(--gray-500);
    font-size: 0.8125rem;
}

/* تنسيق رفع الصور */
.image-upload-group {
    display: flex;
    flex-direction: column;
}

.image-upload-group.full-width {
    grid-column: 1 / -1;
}

.image-preview-container {
    width: 100%;
    height: 150px;
    border: 2px dashed var(--gray-300);
    border-radius: 10px;
    overflow: hidden;
    margin-bottom: 1rem;
    background: var(--gray-50);
    display: flex;
    align-items: center;
    justify-content: center;
}

.image-preview-container.small {
    width: 100px;
    height: 100px;
}

.image-preview-container.wide {
    height: 250px;
}

.image-preview {
    width: 100%;
    height: 100%;
    object-fit: contain;
    padding: 0.5rem;
}

.image-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: var(--gray-400);
    text-align: center;
    padding: 1rem;
}

.image-placeholder i {
    font-size: 3rem;
    margin-bottom: 0.5rem;
}

.image-placeholder p {
    margin: 0;
    font-size: 0.875rem;
}

.settings-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    padding: 1.5rem;
    background: white;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.btn {
    padding: 0.875rem 2rem;
    border-radius: 10px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s;
    border: none;
    cursor: pointer;
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
}

.btn-secondary {
    background: var(--gray-200);
    color: var(--dark);
}

.btn-secondary:hover {
    background: var(--gray-300);
}

.alert {
    padding: 1rem 1.5rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.alert-success {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #6ee7b7;
}

.alert-danger {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #fca5a5;
}

@media (max-width: 768px) {
    .settings-grid {
        grid-template-columns: 1fr;
    }
    
    .settings-section {
        padding: 1.5rem;
    }
    
    .settings-actions {
        flex-direction: column;
    }
    
    .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            if (preview.tagName === 'IMG') {
                preview.src = e.target.result;
            } else {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'image-preview';
                preview.replaceWith(img);
                img.id = previewId;
            }
        }
        
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
