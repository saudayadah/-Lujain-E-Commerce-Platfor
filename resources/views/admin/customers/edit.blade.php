@extends('layouts.admin')

@section('title', 'تعديل بيانات العميل')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div>
        <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-outline btn-sm" style="margin-bottom: 1rem;">
            <i class="fas fa-arrow-right"></i> العودة للتفاصيل
        </a>
        <h1 class="page-title">
            <i class="fas fa-user-edit"></i>
            تعديل بيانات العميل
        </h1>
    </div>
</div>

<div style="max-width: 800px;">
    <div class="card">
        <form action="{{ route('admin.customers.update', $customer) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div style="display: grid; gap: 1.5rem;">
                <!-- Name -->
                <div>
                    <label for="name" class="form-label">الاسم <span style="color: var(--danger);">*</span></label>
                    <input type="text" id="name" name="name" class="form-input @error('name') is-invalid @enderror" value="{{ old('name', $customer->name) }}" required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Email -->
                <div>
                    <label for="email" class="form-label">البريد الإلكتروني <span style="color: var(--danger);">*</span></label>
                    <input type="email" id="email" name="email" class="form-input @error('email') is-invalid @enderror" value="{{ old('email', $customer->email) }}" required>
                    @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Phone -->
                <div>
                    <label for="phone" class="form-label">رقم الجوال</label>
                    <input type="text" id="phone" name="phone" class="form-input @error('phone') is-invalid @enderror" value="{{ old('phone', $customer->phone) }}" placeholder="+966xxxxxxxxx">
                    @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- Address -->
                <div>
                    <label for="address" class="form-label">العنوان</label>
                    <textarea id="address" name="address" class="form-input @error('address') is-invalid @enderror" rows="3" placeholder="العنوان الكامل">{{ old('address', $customer->address) }}</textarea>
                    @error('address')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <!-- City -->
                <div>
                    <label for="city" class="form-label">المدينة</label>
                    <input type="text" id="city" name="city" class="form-input @error('city') is-invalid @enderror" value="{{ old('city', $customer->city) }}">
                    @error('city')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            
            <!-- Actions -->
            <div style="display: flex; gap: 1rem; justify-content: flex-start; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid var(--border-color);">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> حفظ التغييرات
                </button>
                <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-outline">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

