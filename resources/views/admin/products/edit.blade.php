@extends('layouts.app')

@section('title', 'تعديل المنتج')

@section('content')
<div style="padding: 2rem;">
    <div style="max-width: 900px; margin: 0 auto;">
        
        <!-- Header -->
        <div style="margin-bottom: 2rem;">
            <a href="{{ route('admin.products.index') }}" style="color: var(--primary-green); text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; margin-bottom: 1rem; transition: all 0.3s;" onmouseover="this.style.gap='1rem'" onmouseout="this.style.gap='0.5rem'">
                <i class="fas fa-arrow-right"></i> العودة للمنتجات
            </a>
            <h1 style="font-size: 2rem; font-weight: 700; color: var(--dark-green);">
                <i class="fas fa-edit"></i> تعديل المنتج: {{ $product->name_ar }}
            </h1>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" style="background: white; border-radius: 20px; padding: 2.5rem; box-shadow: 0 10px 40px rgba(0,0,0,0.08);">
            @csrf
            @method('PUT')

            @if($errors->any())
            <div style="background: linear-gradient(135deg, #fee2e2, #fecaca); padding: 1rem 1.5rem; border-radius: 12px; margin-bottom: 2rem; border-right: 4px solid #dc2626;">
                <p style="font-weight: 600; color: #991b1b; margin-bottom: 0.5rem;">
                    <i class="fas fa-exclamation-circle"></i> يرجى تصحيح الأخطاء التالية:
                </p>
                <ul style="margin: 0; padding-right: 1.5rem; color: #991b1b;">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Arabic Name -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; color: var(--text-dark); margin-bottom: 0.5rem;">
                    <i class="fas fa-tag"></i> اسم المنتج (عربي) *
                </label>
                <input type="text" name="name_ar" value="{{ old('name_ar', $product->name_ar) }}" required 
                    style="width: 100%; padding: 0.875rem 1rem; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 1rem; transition: all 0.3s;"
                    onfocus="this.style.borderColor='var(--primary-green)'; this.style.boxShadow='0 0 0 3px rgba(34, 197, 94, 0.1)';"
                    onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
            </div>

            <!-- English Name -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; color: var(--text-dark); margin-bottom: 0.5rem;">
                    <i class="fas fa-tag"></i> اسم المنتج (English)
                </label>
                <input type="text" name="name_en" value="{{ old('name_en', $product->name_en) }}" 
                    style="width: 100%; padding: 0.875rem 1rem; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 1rem; transition: all 0.3s;"
                    onfocus="this.style.borderColor='var(--primary-green)'; this.style.boxShadow='0 0 0 3px rgba(34, 197, 94, 0.1)';"
                    onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
            </div>

            <!-- Category -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; color: var(--text-dark); margin-bottom: 0.5rem;">
                    <i class="fas fa-folder"></i> التصنيف *
                </label>
                <select name="category_id" required 
                    style="width: 100%; padding: 0.875rem 1rem; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 1rem; transition: all 0.3s;"
                    onfocus="this.style.borderColor='var(--primary-green)'; this.style.boxShadow='0 0 0 3px rgba(34, 197, 94, 0.1)';"
                    onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                    <option value="">اختر التصنيف</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name_ar }}
                    </option>
                    @endforeach
                </select>
            </div>

            <!-- Description AR -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; color: var(--text-dark); margin-bottom: 0.5rem;">
                    <i class="fas fa-align-right"></i> الوصف (عربي) *
                </label>
                <textarea name="description_ar" rows="4" required 
                    style="width: 100%; padding: 0.875rem 1rem; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 1rem; resize: vertical; transition: all 0.3s;"
                    onfocus="this.style.borderColor='var(--primary-green)'; this.style.boxShadow='0 0 0 3px rgba(34, 197, 94, 0.1)';"
                    onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">{{ old('description_ar', $product->description_ar) }}</textarea>
            </div>

            <!-- Description EN -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; color: var(--text-dark); margin-bottom: 0.5rem;">
                    <i class="fas fa-align-left"></i> الوصف (English)
                </label>
                <textarea name="description_en" rows="4" 
                    style="width: 100%; padding: 0.875rem 1rem; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 1rem; resize: vertical; transition: all 0.3s;"
                    onfocus="this.style.borderColor='var(--primary-green)'; this.style.boxShadow='0 0 0 3px rgba(34, 197, 94, 0.1)';"
                    onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">{{ old('description_en', $product->description_en) }}</textarea>
            </div>

            <!-- Price & Stock -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; font-weight: 600; color: var(--text-dark); margin-bottom: 0.5rem;">
                        <i class="fas fa-money-bill-wave"></i> السعر الأصلي (ر.س) *
                    </label>
                    <input type="number" name="price" step="0.01" min="0" value="{{ old('price', $product->price) }}" required 
                        style="width: 100%; padding: 0.875rem 1rem; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 1rem; transition: all 0.3s;"
                        onfocus="this.style.borderColor='var(--primary-green)'; this.style.boxShadow='0 0 0 3px rgba(34, 197, 94, 0.1)';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; color: var(--text-dark); margin-bottom: 0.5rem;">
                        <i class="fas fa-tag"></i> سعر البيع/الخصم (ر.س)
                    </label>
                    <input type="number" name="sale_price" step="0.01" min="0" value="{{ old('sale_price', $product->sale_price) }}" 
                        style="width: 100%; padding: 0.875rem 1rem; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 1rem; transition: all 0.3s;"
                        onfocus="this.style.borderColor='var(--primary-green)'; this.style.boxShadow='0 0 0 3px rgba(34, 197, 94, 0.1)';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                    <small style="color: #6b7280; font-size: 0.75rem; display: block; margin-top: 0.25rem;">
                        💡 اتركه فارغاً إذا لم يكن هناك خصم
                    </small>
                </div>
            </div>

            <!-- Stock & Unit -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; font-weight: 600; color: var(--text-dark); margin-bottom: 0.5rem;">
                        <i class="fas fa-boxes"></i> الكمية في المخزون *
                    </label>
                    <input type="number" name="stock" min="0" value="{{ old('stock', $product->stock) }}" required 
                        style="width: 100%; padding: 0.875rem 1rem; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 1rem; transition: all 0.3s;"
                        onfocus="this.style.borderColor='var(--primary-green)'; this.style.boxShadow='0 0 0 3px rgba(34, 197, 94, 0.1)';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                </div>
                <div>
                    <label style="display: block; font-weight: 600; color: var(--text-dark); margin-bottom: 0.5rem;">
                        <i class="fas fa-balance-scale"></i> الوحدة
                    </label>
                    <select name="unit" style="width: 100%; padding: 0.875rem 1rem; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 1rem;">
                        <option value="قطعة" {{ old('unit', $product->unit) == 'قطعة' ? 'selected' : '' }}>قطعة</option>
                        <option value="كيلو" {{ old('unit', $product->unit) == 'كيلو' ? 'selected' : '' }}>كيلو</option>
                        <option value="كرتون" {{ old('unit', $product->unit) == 'كرتون' ? 'selected' : '' }}>كرتون</option>
                        <option value="علبة" {{ old('unit', $product->unit) == 'علبة' ? 'selected' : '' }}>علبة</option>
                        <option value="حزمة" {{ old('unit', $product->unit) == 'حزمة' ? 'selected' : '' }}>حزمة</option>
                    </select>
                </div>
            </div>

            <!-- SKU & Weight -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
                <div>
                    <label style="display: block; font-weight: 600; color: var(--text-dark); margin-bottom: 0.5rem;">
                        <i class="fas fa-barcode"></i> رمز المنتج (SKU)
                    </label>
                    <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" 
                        placeholder="اتركه فارغاً للتوليد التلقائي"
                        style="width: 100%; padding: 0.875rem 1rem; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 1rem; transition: all 0.3s;"
                        onfocus="this.style.borderColor='var(--primary-green)'; this.style.boxShadow='0 0 0 3px rgba(34, 197, 94, 0.1)';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                    <small style="color: #6b7280; font-size: 0.875rem; margin-top: 0.25rem; display: block;">
                        <i class="fas fa-info-circle"></i> يجب أن يكون فريداً ومختلفاً عن باقي المنتجات
                    </small>
                </div>
                <div>
                    <label style="display: block; font-weight: 600; color: var(--text-dark); margin-bottom: 0.5rem;">
                        <i class="fas fa-weight"></i> الوزن (كجم)
                    </label>
                    <input type="number" name="weight" step="0.01" min="0" value="{{ old('weight', $product->attributes['weight'] ?? '') }}" 
                        style="width: 100%; padding: 0.875rem 1rem; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 1rem; transition: all 0.3s;"
                        onfocus="this.style.borderColor='var(--primary-green)'; this.style.boxShadow='0 0 0 3px rgba(34, 197, 94, 0.1)';"
                        onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                </div>
            </div>

            <!-- Current Image -->
            @if($product->image)
            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-weight: 600; color: var(--text-dark); margin-bottom: 0.5rem;">
                    الصورة الحالية:
                </label>
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name_ar }}" style="max-width: 200px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
            </div>
            @endif

            <!-- Image -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-weight: 600; color: var(--text-dark); margin-bottom: 0.5rem;">
                    <i class="fas fa-image"></i> تغيير صورة المنتج
                </label>
                <input type="file" name="image" accept="image/*" 
                    style="width: 100%; padding: 0.875rem 1rem; border: 2px dashed #e5e7eb; border-radius: 12px; font-size: 1rem; transition: all 0.3s; cursor: pointer;"
                    onchange="previewImage(event)"
                    onfocus="this.style.borderColor='var(--primary-green)';"
                    onblur="this.style.borderColor='#e5e7eb';">
                <div id="imagePreview" style="margin-top: 1rem; display: none;">
                    <img id="preview" style="max-width: 200px; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                </div>
            </div>

            <!-- Features Section -->
            <div style="background: linear-gradient(135deg, #f0fdf4, #dcfce7); padding: 1.5rem; border-radius: 12px; margin-bottom: 1.5rem; border-right: 4px solid var(--primary-green);">
                <h3 style="font-size: 1.125rem; font-weight: 700; color: var(--dark-green); margin-bottom: 1rem;">
                    <i class="fas fa-star"></i> مميزات المنتج
                </h3>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <label style="display: flex; align-items: center; cursor: pointer; user-select: none; background: white; padding: 1rem; border-radius: 8px;">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} 
                            style="width: 20px; height: 20px; margin-left: 0.75rem; cursor: pointer; accent-color: #f59e0b;">
                        <span style="font-weight: 600; color: var(--text-dark);">
                            <i class="fas fa-star" style="color: #f59e0b;"></i> منتج مميز
                        </span>
                    </label>

                    <label style="display: flex; align-items: center; cursor: pointer; user-select: none; background: white; padding: 1rem; border-radius: 8px;">
                        <input type="checkbox" name="is_special_offer" value="1" {{ old('is_special_offer', $product->is_special_offer) ? 'checked' : '' }} 
                            style="width: 20px; height: 20px; margin-left: 0.75rem; cursor: pointer; accent-color: #ef4444;">
                        <span style="font-weight: 600; color: var(--text-dark);">
                            <i class="fas fa-fire" style="color: #ef4444;"></i> عرض خاص
                        </span>
                    </label>
                </div>

                <div id="specialOfferFields" style="display: {{ old('is_special_offer', $product->is_special_offer) ? 'block' : 'none' }}; margin-top: 1rem; padding-top: 1rem; border-top: 2px dashed #d1d5db;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                        <div>
                            <label style="display: block; font-weight: 600; color: var(--text-dark); margin-bottom: 0.5rem; font-size: 0.875rem;">
                                <i class="fas fa-calendar-alt"></i> تاريخ بداية العرض
                            </label>
                            <input type="datetime-local" name="special_offer_start" value="{{ old('special_offer_start', $product->special_offer_start?->format('Y-m-d\TH:i')) }}" 
                                style="width: 100%; padding: 0.75rem; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 0.875rem;">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; color: var(--text-dark); margin-bottom: 0.5rem; font-size: 0.875rem;">
                                <i class="fas fa-calendar-times"></i> تاريخ نهاية العرض
                            </label>
                            <input type="datetime-local" name="special_offer_end" value="{{ old('special_offer_end', $product->special_offer_end?->format('Y-m-d\TH:i')) }}" 
                                style="width: 100%; padding: 0.75rem; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 0.875rem;">
                        </div>
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div>
                            <label style="display: block; font-weight: 600; color: var(--text-dark); margin-bottom: 0.5rem; font-size: 0.875rem;">
                                <i class="fas fa-tag"></i> نص البادج
                            </label>
                            <input type="text" name="badge_text" value="{{ old('badge_text', $product->badge_text) }}" placeholder="مثلاً: عرض العيد" 
                                style="width: 100%; padding: 0.75rem; border: 2px solid #e5e7eb; border-radius: 8px; font-size: 0.875rem;">
                        </div>
                        <div>
                            <label style="display: block; font-weight: 600; color: var(--text-dark); margin-bottom: 0.5rem; font-size: 0.875rem;">
                                <i class="fas fa-palette"></i> لون البادج
                            </label>
                            <input type="color" name="badge_color" value="{{ old('badge_color', $product->badge_color ?? '#ef4444') }}" 
                                style="width: 100%; height: 45px; padding: 0.25rem; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer;">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-weight: 600; color: var(--text-dark); margin-bottom: 0.5rem;">
                    <i class="fas fa-toggle-on"></i> حالة المنتج
                </label>
                <select name="status" required 
                    style="width: 100%; padding: 0.875rem 1rem; border: 2px solid #e5e7eb; border-radius: 12px; font-size: 1rem; transition: all 0.3s; background: #f9fafb;"
                    onfocus="this.style.borderColor='var(--primary-green)'; this.style.boxShadow='0 0 0 3px rgba(34, 197, 94, 0.1)';"
                    onblur="this.style.borderColor='#e5e7eb'; this.style.boxShadow='none';">
                    <option value="active" {{ old('status', $product->status) === 'active' ? 'selected' : '' }}>نشط</option>
                    <option value="inactive" {{ old('status', $product->status) === 'inactive' ? 'selected' : '' }}>غير نشط</option>
                </select>
            </div>

            <!-- Buttons -->
            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <a href="{{ route('admin.products.index') }}" 
                    style="padding: 0.875rem 2rem; background: #f3f4f6; color: var(--text-dark); border-radius: 12px; text-decoration: none; font-weight: 600; transition: all 0.3s;"
                    onmouseover="this.style.background='#e5e7eb'"
                    onmouseout="this.style.background='#f3f4f6'">
                    إلغاء
                </a>
                <button type="submit" class="btn" style="background: linear-gradient(135deg, var(--primary-green), var(--dark-green)); padding: 0.875rem 2.5rem;">
                    <i class="fas fa-save"></i> حفظ التعديلات
                </button>
            </div>
        </form>

    </div>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
}

// Toggle special offer fields
document.addEventListener('DOMContentLoaded', function() {
    const specialOfferCheckbox = document.querySelector('input[name="is_special_offer"]');
    const specialOfferFields = document.getElementById('specialOfferFields');
    
    if (specialOfferCheckbox) {
        specialOfferCheckbox.addEventListener('change', function() {
            specialOfferFields.style.display = this.checked ? 'block' : 'none';
        });
    }
});
</script>
@endsection

