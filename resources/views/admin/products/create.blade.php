@extends('layouts.admin')

@section('title', 'إضافة منتج جديد')

@push('styles')
<style>
/* Mobile Compatibility for Admin Forms */
@media (max-width: 768px) {
    .container, .card {
        max-width: 100% !important;
        padding: 1rem !important;
    }
    
    /* Forms Layout */
    div[style*="grid-template-columns"],
    .mobile-single-col {
        grid-template-columns: 1fr !important;
        gap: 1rem !important;
    }
    
    /* Form Controls */
    .form-control,
    input[type="text"],
    input[type="number"],
    input[type="file"],
    textarea,
    select {
        font-size: 16px !important; /* يمنع zoom في iOS */
        width: 100% !important;
        min-height: 44px;
    }
    
    /* Buttons */
    button[type="submit"],
    .btn {
        min-height: 44px;
        width: 100% !important;
        margin-bottom: 1rem;
    }
    
    /* Image Preview */
    #imagesPreview {
        grid-template-columns: repeat(2, 1fr) !important;
    }
    
    #imagesPreview img {
        width: 100%;
        height: auto;
    }
    
    /* Labels */
    .form-label {
        font-size: 0.875rem !important;
        margin-bottom: 0.5rem !important;
    }
}
</style>
@endpush

@section('content')
<div style="margin-bottom: 1.5rem;">
    <a href="{{ route('admin.products.index') }}" style="color: var(--primary); text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; font-weight: 600;">
        <i class="fas fa-arrow-right"></i> العودة للمنتجات
    </a>
</div>

<div class="page-header">
    <h1 class="page-title">
        <i class="fas fa-plus-circle"></i>
        إضافة منتج جديد
    </h1>
</div>

<div class="card" style="max-width: 900px; margin: 0 auto;">
    <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
        @csrf

        @if($errors->any())
        <div class="alert alert-error">
            <div>
                <i class="fas fa-exclamation-circle"></i>
                <strong>يرجى تصحيح الأخطاء التالية:</strong>
            </div>
            <ul style="margin: 0.5rem 0 0 0; padding-right: 1.5rem;">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="form-group">
            <label class="form-label">
                <i class="fas fa-tag"></i> اسم المنتج (عربي) *
            </label>
            <input type="text" name="name_ar" value="{{ old('name_ar') }}" required class="form-control">
        </div>

        <div class="form-group">
            <label class="form-label">
                <i class="fas fa-tag"></i> اسم المنتج (English)
            </label>
            <input type="text" name="name_en" value="{{ old('name_en') }}" class="form-control">
        </div>

        <div class="form-group">
            <label class="form-label">
                <i class="fas fa-folder"></i> التصنيف *
            </label>
            <select name="category_id" required class="form-control">
                <option value="">اختر التصنيف</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name_ar }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label class="form-label">
                <i class="fas fa-align-right"></i> الوصف (عربي) *
            </label>
            <textarea name="description_ar" rows="4" required class="form-control">{{ old('description_ar') }}</textarea>
        </div>

        <div class="form-group">
            <label class="form-label">
                <i class="fas fa-align-left"></i> الوصف (English)
            </label>
            <textarea name="description_en" rows="4" class="form-control">{{ old('description_en') }}</textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-money-bill-wave"></i> السعر (ر.س) *
                </label>
                <input type="number" name="price" step="0.01" min="0" value="{{ old('price') }}" required class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-tag"></i> سعر البيع (ر.س)
                </label>
                <input type="number" name="sale_price" step="0.01" min="0" value="{{ old('sale_price') }}" class="form-control">
                <small style="color: #6b7280; font-size: 0.875rem; margin-top: 0.25rem; display: block;">
                    <i class="fas fa-info-circle"></i> اتركه فارغاً إذا لم يكن هناك عرض خاص
                </small>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-boxes"></i> الكمية في المخزون *
                </label>
                <input type="number" name="stock" min="0" value="{{ old('stock', 0) }}" required class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-bell"></i> تنبيه المخزون المنخفض
                </label>
                <input type="number" name="low_stock_alert" min="0" value="{{ old('low_stock_alert', 5) }}" class="form-control">
                <small style="color: #6b7280; font-size: 0.875rem; margin-top: 0.25rem; display: block;">
                    <i class="fas fa-info-circle"></i> سيتم التنبيه عندما يصل المخزون لهذا الرقم أو أقل
                </small>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-balance-scale"></i> الوحدة
                </label>
                <select name="unit" class="form-control">
                    <option value="قطعة" {{ old('unit') == 'قطعة' ? 'selected' : '' }}>قطعة</option>
                    <option value="كيلو" {{ old('unit') == 'كيلو' ? 'selected' : '' }}>كيلو</option>
                    <option value="كرتون" {{ old('unit') == 'كرتون' ? 'selected' : '' }}>كرتون</option>
                    <option value="علبة" {{ old('unit') == 'علبة' ? 'selected' : '' }}>علبة</option>
                    <option value="حزمة" {{ old('unit') == 'حزمة' ? 'selected' : '' }}>حزمة</option>
                    <option value="أخرى" {{ old('unit') == 'أخرى' ? 'selected' : '' }}>أخرى</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-star"></i> الحالة
                </label>
                <select name="status" class="form-control" required>
                    <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>نشط</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-barcode"></i> رمز المنتج (SKU)
                </label>
                <input type="text" name="sku" value="{{ old('sku') }}" class="form-control" placeholder="اتركه فارغاً للتوليد التلقائي">
                <small style="color: #6b7280; font-size: 0.875rem; margin-top: 0.25rem; display: block;">
                    <i class="fas fa-info-circle"></i> إذا تركته فارغاً، سيتم توليد رمز فريد تلقائياً
                </small>
            </div>
            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-weight"></i> الوزن (كجم)
                </label>
                <input type="number" name="weight" step="0.01" min="0" value="{{ old('weight') }}" class="form-control">
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">
                <i class="fas fa-images"></i> صور المنتج (يمكنك اختيار عدة صور)
            </label>
            <input type="file" name="images[]" accept="image/*" multiple class="form-control" onchange="previewImages(event)">
            <div id="imagesPreview" style="margin-top: 1rem; display: none; gap: 1rem; flex-wrap: wrap;">
                <!-- معاينة الصور ستظهر هنا -->
            </div>
            <small style="color: #6b7280; font-size: 0.875rem; margin-top: 0.25rem; display: block;">
                <i class="fas fa-info-circle"></i> يمكنك اختيار عدة صور. الحد الأقصى لحجم الملف: 2 ميجابايت لكل صورة
            </small>
        </div>

        <!-- Features Section -->
        <div style="background: linear-gradient(135deg, #f0fdf4, #dcfce7); padding: 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; border-right: 4px solid var(--primary);">
            <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--primary); margin-bottom: 1rem;">
                <i class="fas fa-star"></i> مميزات المنتج
            </h3>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <label style="display: flex; align-items: center; cursor: pointer; user-select: none; background: white; padding: 1rem; border-radius: 8px;">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} 
                        style="width: 20px; height: 20px; margin-left: 0.75rem; cursor: pointer; accent-color: #f59e0b;">
                    <span style="font-weight: 600; color: var(--text-dark);">
                        <i class="fas fa-star" style="color: #f59e0b;"></i> منتج مميز
                    </span>
                </label>

                <label style="display: flex; align-items: center; cursor: pointer; user-select: none; background: white; padding: 1rem; border-radius: 8px;">
                    <input type="checkbox" name="is_special_offer" value="1" {{ old('is_special_offer') ? 'checked' : '' }} 
                        id="specialOfferCheckbox"
                        style="width: 20px; height: 20px; margin-left: 0.75rem; cursor: pointer; accent-color: #ef4444;">
                    <span style="font-weight: 600; color: var(--text-dark);">
                        <i class="fas fa-fire" style="color: #ef4444;"></i> عرض خاص
                    </span>
                </label>
            </div>

            <div id="specialOfferFields" style="display: {{ old('is_special_offer') ? 'block' : 'none' }}; margin-top: 1rem; padding-top: 1rem; border-top: 2px dashed #d1d5db;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; font-weight: 600; color: var(--text-dark); margin-bottom: 0.5rem; font-size: 0.875rem;">
                            <i class="fas fa-calendar-alt"></i> تاريخ بداية العرض
                        </label>
                        <input type="datetime-local" name="special_offer_start" value="{{ old('special_offer_start') }}" 
                            style="width: 100%; padding: 0.75rem; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 0.875rem;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; color: var(--text-dark); margin-bottom: 0.5rem; font-size: 0.875rem;">
                            <i class="fas fa-calendar-times"></i> تاريخ نهاية العرض
                        </label>
                        <input type="datetime-local" name="special_offer_end" value="{{ old('special_offer_end') }}" 
                            style="width: 100%; padding: 0.75rem; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 0.875rem;">
                    </div>
                </div>
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <label style="display: block; font-weight: 600; color: var(--text-dark); margin-bottom: 0.5rem; font-size: 0.875rem;">
                            <i class="fas fa-tag"></i> نص البادج
                        </label>
                        <input type="text" name="badge_text" value="{{ old('badge_text') }}" placeholder="مثلاً: عرض العيد" 
                            style="width: 100%; padding: 0.75rem; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 0.875rem;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; color: var(--text-dark); margin-bottom: 0.5rem; font-size: 0.875rem;">
                            <i class="fas fa-palette"></i> لون البادج
                        </label>
                        <input type="color" name="badge_color" value="{{ old('badge_color', '#ef4444') }}" 
                            style="width: 100%; height: 45px; padding: 0.25rem; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer;">
                    </div>
                </div>
            </div>
        </div>

        <div style="display: flex; gap: 1rem; justify-content: flex-end; margin-top: 2rem;">
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline">
                إلغاء
            </a>
            <button type="submit" class="btn">
                <i class="fas fa-save"></i> حفظ المنتج
            </button>
        </div>
    </form>
</div>

<script>
function previewImages(event) {
    const files = event.target.files;
    const previewContainer = document.getElementById('imagesPreview');

    previewContainer.innerHTML = '';
    previewContainer.style.display = 'flex';

    Array.from(files).forEach((file, index) => {
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgContainer = document.createElement('div');
                imgContainer.style.cssText = `
                    position: relative;
                    display: inline-block;
                    margin: 0.5rem;
                `;

                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.cssText = `
                    width: 100px;
                    height: 100px;
                    object-fit: cover;
                    border-radius: 8px;
                    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                `;

                const removeBtn = document.createElement('button');
                removeBtn.innerHTML = '×';
                removeBtn.type = 'button';
                removeBtn.style.cssText = `
                    position: absolute;
                    top: -5px;
                    right: -5px;
                    background: #ef4444;
                    color: white;
                    border: none;
                    border-radius: 50%;
                    width: 24px;
                    height: 24px;
                    font-size: 16px;
                    cursor: pointer;
                    display: none;
                `;

                imgContainer.appendChild(img);
                imgContainer.appendChild(removeBtn);
                previewContainer.appendChild(imgContainer);

                // Show remove button on hover
                imgContainer.addEventListener('mouseenter', () => {
                    removeBtn.style.display = 'block';
                });

                imgContainer.addEventListener('mouseleave', () => {
                    removeBtn.style.display = 'none';
                });

                removeBtn.addEventListener('click', () => {
                    imgContainer.remove();
                    if (previewContainer.children.length === 0) {
                        previewContainer.style.display = 'none';
                    }
                });
            }
            reader.readAsDataURL(file);
        }
    });
}

// Toggle special offer fields
document.addEventListener('DOMContentLoaded', function() {
    const specialOfferCheckbox = document.getElementById('specialOfferCheckbox');
    const specialOfferFields = document.getElementById('specialOfferFields');
    
    if (specialOfferCheckbox) {
        specialOfferCheckbox.addEventListener('change', function() {
            specialOfferFields.style.display = this.checked ? 'block' : 'none';
        });
    }
});
</script>
@endsection
