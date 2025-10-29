@extends('layouts.admin')

@section('title', 'إضافة كوبون جديد')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div>
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline btn-sm" style="margin-bottom: 1rem;">
            <i class="fas fa-arrow-right"></i> العودة للكوبونات
        </a>
        <h1 class="page-title">
            <i class="fas fa-ticket-alt"></i>
            إضافة كوبون جديد
        </h1>
    </div>
</div>

<div style="max-width: 900px;">
    <div class="card">
        <form action="{{ route('admin.coupons.store') }}" method="POST">
            @csrf
            
            <div style="display: grid; gap: 1.5rem;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <!-- Code -->
                    <div>
                        <label for="code" class="form-label">كود الكوبون <span style="color: var(--danger);">*</span></label>
                        <input type="text" id="code" name="code" class="form-input @error('code') is-invalid @enderror" value="{{ old('code') }}" placeholder="SUMMER2024" required style="text-transform: uppercase;">
                        @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small style="color: var(--gray-500); display: block; margin-top: 0.25rem;">
                            سيتم تحويله لأحرف كبيرة تلقائياً
                        </small>
                    </div>
                    
                    <!-- Type -->
                    <div>
                        <label for="type" class="form-label">نوع الخصم <span style="color: var(--danger);">*</span></label>
                        <select id="type" name="type" class="form-input @error('type') is-invalid @enderror" required onchange="toggleDiscountFields()">
                            <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>نسبة مئوية (%)</option>
                            <option value="fixed" {{ old('type') === 'fixed' ? 'selected' : '' }}>مبلغ ثابت (ر.س)</option>
                        </select>
                        @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.5rem;">
                    <!-- Value -->
                    <div>
                        <label for="value" class="form-label">قيمة الخصم <span style="color: var(--danger);">*</span></label>
                        <input type="number" id="value" name="value" class="form-input @error('value') is-invalid @enderror" value="{{ old('value') }}" step="0.01" min="0" required>
                        @error('value')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small id="valueHelp" style="color: var(--gray-500); display: block; margin-top: 0.25rem;">
                            مثال: 15 (أي 15%)
                        </small>
                    </div>
                    
                    <!-- Min Order Amount -->
                    <div>
                        <label for="min_order_amount" class="form-label">الحد الأدنى للطلب</label>
                        <input type="number" id="min_order_amount" name="min_order_amount" class="form-input @error('min_order_amount') is-invalid @enderror" value="{{ old('min_order_amount') }}" step="0.01" min="0" placeholder="0.00">
                        @error('min_order_amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small style="color: var(--gray-500); display: block; margin-top: 0.25rem;">
                            اختياري - بالريال
                        </small>
                    </div>
                    
                    <!-- Max Discount -->
                    <div id="maxDiscountField">
                        <label for="max_discount" class="form-label">الحد الأقصى للخصم</label>
                        <input type="number" id="max_discount" name="max_discount" class="form-input @error('max_discount') is-invalid @enderror" value="{{ old('max_discount') }}" step="0.01" min="0" placeholder="0.00">
                        @error('max_discount')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small style="color: var(--gray-500); display: block; margin-top: 0.25rem;">
                            للنسبة المئوية فقط
                        </small>
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <!-- Usage Limit -->
                    <div>
                        <label for="usage_limit" class="form-label">عدد الاستخدامات الكلي</label>
                        <input type="number" id="usage_limit" name="usage_limit" class="form-input @error('usage_limit') is-invalid @enderror" value="{{ old('usage_limit') }}" min="1" placeholder="غير محدود">
                        @error('usage_limit')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small style="color: var(--gray-500); display: block; margin-top: 0.25rem;">
                            اتركه فارغاً لعدد غير محدود
                        </small>
                    </div>
                    
                    <!-- Per User Limit -->
                    <div>
                        <label for="per_user_limit" class="form-label">عدد الاستخدامات لكل مستخدم <span style="color: var(--danger);">*</span></label>
                        <input type="number" id="per_user_limit" name="per_user_limit" class="form-input @error('per_user_limit') is-invalid @enderror" value="{{ old('per_user_limit', 1) }}" min="1" required>
                        @error('per_user_limit')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <!-- Starts At -->
                    <div>
                        <label for="starts_at" class="form-label">تاريخ البداية</label>
                        <input type="datetime-local" id="starts_at" name="starts_at" class="form-input @error('starts_at') is-invalid @enderror" value="{{ old('starts_at') }}">
                        @error('starts_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small style="color: var(--gray-500); display: block; margin-top: 0.25rem;">
                            اختياري - يبدأ فوراً إن لم يُحدد
                        </small>
                    </div>
                    
                    <!-- Expires At -->
                    <div>
                        <label for="expires_at" class="form-label">تاريخ الانتهاء</label>
                        <input type="datetime-local" id="expires_at" name="expires_at" class="form-input @error('expires_at') is-invalid @enderror" value="{{ old('expires_at') }}">
                        @error('expires_at')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small style="color: var(--gray-500); display: block; margin-top: 0.25rem;">
                            اختياري - لا ينتهي إن لم يُحدد
                        </small>
                    </div>
                </div>
                
                <!-- Description -->
                <div>
                    <label for="description" class="form-label">الوصف</label>
                    <textarea id="description" name="description" class="form-input @error('description') is-invalid @enderror" rows="3" placeholder="وصف مختصر للكوبون">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Is Active -->
                <div>
                    <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} style="width: 18px; height: 18px;">
                        <span class="form-label" style="margin: 0;">تفعيل الكوبون</span>
                    </label>
                    <small style="color: var(--gray-500); display: block; margin-top: 0.25rem;">
                        يمكن تعطيل الكوبون مؤقتاً دون حذفه
                    </small>
                </div>
            </div>
            
            <!-- Actions -->
            <div style="display: flex; gap: 1rem; justify-content: flex-start; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--border-color);">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> إنشاء الكوبون
                </button>
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function toggleDiscountFields() {
    const type = document.getElementById('type').value;
    const maxDiscountField = document.getElementById('maxDiscountField');
    const valueHelp = document.getElementById('valueHelp');
    
    if (type === 'percentage') {
        maxDiscountField.style.opacity = '1';
        maxDiscountField.querySelector('input').disabled = false;
        valueHelp.textContent = 'مثال: 15 (أي 15%)';
    } else {
        maxDiscountField.style.opacity = '0.5';
        maxDiscountField.querySelector('input').disabled = true;
        maxDiscountField.querySelector('input').value = '';
        valueHelp.textContent = 'مثال: 50 (أي 50 ر.س)';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', toggleDiscountFields);
</script>

@endsection

