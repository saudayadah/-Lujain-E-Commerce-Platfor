@extends('layouts.admin')

@section('title', 'إدارة التصنيفات')

@section('content')
<div class="content-wrapper">
    <!-- Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">
                <i class="fas fa-folder-tree"></i>
                إدارة التصنيفات
            </h1>
            <p class="page-subtitle">إضافة وتعديل وحذف التصنيفات</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i>
            <span>إضافة تصنيف جديد</span>
        </a>
    </div>

    <!-- Alerts -->
    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
    @endif

    <!-- Categories Grid -->
    <div class="card">
        @if($categories->count() > 0)
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
            @foreach($categories as $category)
            <div style="background: linear-gradient(135deg, #f0fdf4, white); border: 2px solid #dcfce7; border-radius: 16px; padding: 1.5rem; transition: all 0.3s; position: relative;" onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 30px rgba(34, 197, 94, 0.2)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                <!-- Status Badge -->
                @if($category->is_active)
                <span style="position: absolute; top: 1rem; left: 1rem; background: #10b981; color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">
                    <i class="fas fa-check-circle"></i> نشط
                </span>
                @else
                <span style="position: absolute; top: 1rem; left: 1rem; background: #6b7280; color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.75rem; font-weight: 600;">
                    <i class="fas fa-times-circle"></i> غير نشط
                </span>
                @endif

                <!-- Category Image -->
                @if($category->image)
                <div style="margin-bottom: 1.5rem; text-align: center;">
                    <div style="display: inline-block; position: relative;">
                        <img src="{{ asset('storage/' . $category->image) }}"
                             alt="{{ $category->name_ar }}"
                             style="width: 100px; height: 100px; object-fit: cover; border-radius: 15px; border: 3px solid var(--primary); box-shadow: 0 6px 20px rgba(16, 185, 129, 0.2); transition: all 0.3s;" onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0 8px 25px rgba(16, 185, 129, 0.3)'" onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0 6px 20px rgba(16, 185, 129, 0.2)'">
                        <!-- تأثير الإشعاع -->
                        <div style="position: absolute; inset: -3px; background: linear-gradient(45deg, var(--primary), var(--primary-light)); border-radius: 15px; opacity: 0; transition: opacity 0.3s;" onmouseover="this.style.opacity='0.3'" onmouseout="this.style.opacity='0'"></div>
                    </div>
                </div>
                @endif

                <!-- Category Info -->
                <div style="margin-bottom: 1rem;">
                    <h3 style="font-size: 1.25rem; font-weight: 700; color: var(--dark); margin-bottom: 0.5rem;">
                        <i class="fas fa-folder" style="color: var(--primary);"></i> {{ $category->name_ar }}
                    </h3>
                    @if($category->name_en)
                    <p style="color: var(--gray-500); font-size: 0.875rem; margin-bottom: 0.5rem;">
                        {{ $category->name_en }}
                    </p>
                    @endif
                    <p style="color: var(--gray-600); font-size: 0.875rem;">
                        <i class="fas fa-box" style="margin-left: 0.25rem;"></i> {{ $category->products()->count() }} منتج
                    </p>
                    @if($category->parent)
                    <p style="color: var(--gray-500); font-size: 0.8125rem; margin-top: 0.5rem;">
                        <i class="fas fa-level-up-alt" style="margin-left: 0.25rem;"></i> تصنيف فرعي من: {{ $category->parent->name_ar }}
                    </p>
                    @endif
                </div>

                <!-- Actions -->
                <div style="display: flex; gap: 0.5rem; margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e5e7eb;">
                    <a href="{{ route('admin.categories.edit', $category) }}" style="flex: 1; padding: 0.5rem; background: #3b82f6; color: white; border-radius: 8px; text-decoration: none; text-align: center; font-weight: 600; font-size: 0.875rem; transition: all 0.2s;" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
                        <i class="fas fa-edit"></i> تعديل
                    </a>
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="flex: 1;" onsubmit="return confirm('هل أنت متأكد من حذف هذا التصنيف؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="width: 100%; padding: 0.5rem; background: #ef4444; color: white; border: none; border-radius: 8px; font-weight: 600; font-size: 0.875rem; cursor: pointer; transition: all 0.2s;" onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">
                            <i class="fas fa-trash"></i> حذف
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div style="text-align: center; padding: 4rem;">
            <i class="fas fa-folder-open" style="font-size: 5rem; color: var(--gray-400); margin-bottom: 1.5rem;"></i>
            <h3 style="font-size: 1.5rem; font-weight: 700; color: var(--dark); margin-bottom: 0.5rem;">لا توجد تصنيفات</h3>
            <p style="color: var(--gray-600); margin-bottom: 2rem;">ابدأ بإضافة تصنيف جديد لتنظيم منتجاتك</p>
            <a href="{{ route('admin.categories.create') }}" class="btn-primary" style="display: inline-flex;">
                <i class="fas fa-plus"></i>
                <span>إضافة تصنيف جديد</span>
            </a>
        </div>
        @endif
    </div>
</div>

<style>
.alert {
    padding: 1rem 1.5rem;
    border-radius: 12px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    font-weight: 500;
}

.alert-success {
    background: #d1fae5;
    color: #065f46;
    border: 1px solid #10b981;
}

.alert-danger {
    background: #fee2e2;
    color: #991b1b;
    border: 1px solid #ef4444;
}

.alert i {
    font-size: 1.25rem;
}
</style>
@endsection
