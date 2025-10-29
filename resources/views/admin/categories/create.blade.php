@extends('layouts.admin')

@section('title', 'إضافة تصنيف جديد')

@push('styles')
<style>
/* Mobile Compatibility for Admin Forms */
@media (max-width: 768px) {
    .container, .card {
        max-width: 100% !important;
        padding: 1rem !important;
    }
    
    .form-control,
    input[type="text"],
    input[type="file"],
    textarea,
    select {
        font-size: 16px !important;
        width: 100% !important;
        min-height: 44px;
    }
    
    button[type="submit"],
    .btn {
        min-height: 44px;
        width: 100% !important;
    }
}
</style>
@endpush

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">
                <i class="fas fa-folder-plus"></i>
                إضافة تصنيف جديد
            </h1>
            <p class="page-subtitle">أضف تصنيف جديد لتنظيم المنتجات</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn-secondary">
            <i class="fas fa-arrow-right"></i>
            <span>رجوع</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="card">
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-grid">
                <!-- Arabic Name -->
                <div class="form-group">
                    <label for="name_ar" class="form-label required">الاسم بالعربي</label>
                    <input type="text" 
                           id="name_ar" 
                           name="name_ar" 
                           value="{{ old('name_ar') }}" 
                           class="form-control @error('name_ar') error @enderror" 
                           required>
                    @error('name_ar')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- English Name -->
                <div class="form-group">
                    <label for="name_en" class="form-label required">الاسم بالإنجليزي</label>
                    <input type="text" 
                           id="name_en" 
                           name="name_en" 
                           value="{{ old('name_en') }}" 
                           class="form-control @error('name_en') error @enderror" 
                           required>
                    @error('name_en')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Parent Category -->
                <div class="form-group">
                    <label for="parent_id" class="form-label">التصنيف الرئيسي</label>
                    <select id="parent_id" name="parent_id" class="form-control">
                        <option value="">-- لا يوجد (تصنيف رئيسي) --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('parent_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name_ar }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Sort Order -->
                <div class="form-group">
                    <label for="sort_order" class="form-label">ترتيب العرض</label>
                    <input type="number" 
                           id="sort_order" 
                           name="sort_order" 
                           value="{{ old('sort_order', 0) }}" 
                           class="form-control" 
                           min="0">
                    @error('sort_order')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Arabic Description -->
                <div class="form-group full-width">
                    <label for="description_ar" class="form-label">الوصف بالعربي</label>
                    <textarea id="description_ar" 
                              name="description_ar" 
                              rows="4" 
                              class="form-control">{{ old('description_ar') }}</textarea>
                    @error('description_ar')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- English Description -->
                <div class="form-group full-width">
                    <label for="description_en" class="form-label">الوصف بالإنجليزي</label>
                    <textarea id="description_en" 
                              name="description_en" 
                              rows="4" 
                              class="form-control">{{ old('description_en') }}</textarea>
                    @error('description_en')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Image -->
                <div class="form-group">
                    <label for="image" class="form-label">صورة التصنيف</label>
                    <input type="file"
                           id="image"
                           name="image"
                           accept="image/*"
                           class="form-control">
                    <div style="margin-top: 0.5rem; display: flex; align-items: center; gap: 1rem;">
                        <small class="form-help">الحجم الموصى به: 400x400 بكسل، الحد الأقصى: 2 ميجابايت</small>
                        <!-- معاينة حجم الصورة -->
                        <div style="width: 40px; height: 40px; border: 2px dashed var(--gray-300); border-radius: 8px; display: flex; align-items: center; justify-content: center; background: var(--gray-50);">
                            <i class="fas fa-image" style="color: var(--gray-400); font-size: 1.25rem;"></i>
                        </div>
                    </div>
                    @error('image')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Is Active -->
                <div class="form-group">
                    <label class="checkbox-label">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1" 
                               {{ old('is_active', true) ? 'checked' : '' }}>
                        <span>التصنيف نشط</span>
                    </label>
                </div>
            </div>

            <!-- Submit Button -->
            <div style="display: flex; gap: 1rem; margin-top: 2rem; flex-wrap: wrap;">
                <button type="submit" class="btn-primary" style="flex: 1; min-width: 120px;">
                    <i class="fas fa-save"></i>
                    <span>حفظ التصنيف</span>
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn-secondary" style="flex: 1; min-width: 120px; text-align: center;">
                    <i class="fas fa-times"></i>
                    <span>إلغاء</span>
                </a>
            </div>
        </form>
    </div>
</div>

<style>
.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr !important;
        gap: 1rem !important;
    }
    
    .form-group.full-width {
        grid-column: 1;
    }
    
    .page-header {
        flex-direction: column !important;
        align-items: flex-start !important;
        gap: 1rem !important;
    }
    
    .btn-secondary,
    .btn-primary {
        width: 100% !important;
    }
    
    div[style*="display: flex"] {
        flex-direction: column !important;
    }
    
    div[style*="display: flex"] button,
    div[style*="display: flex"] a {
        width: 100% !important;
    }
}

.form-label.required::after {
    content: ' *';
    color: var(--danger);
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    font-weight: 500;
}

.checkbox-label input[type="checkbox"] {
    width: 18px;
    height: 18px;
    accent-color: var(--primary);
}
</style>
@endsection

