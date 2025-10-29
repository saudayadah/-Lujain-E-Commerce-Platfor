@extends('layouts.admin')

@section('title', 'إدارة العملاء')

@section('content')
<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">
            <i class="fas fa-users"></i>
            إدارة العملاء
        </h1>
        <p style="color: var(--gray-600); margin-top: 0.5rem;">عرض وإدارة جميع عملاء المتجر</p>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
</div>
@endif

<!-- Stats Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #3b82f6, #2563eb); color: white;">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-value">{{ $stats['total_customers'] }}</div>
        <div class="stat-label">إجمالي العملاء</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #10b981, #059669); color: white;">
            <i class="fas fa-user-check"></i>
        </div>
        <div class="stat-value">{{ $stats['active_customers'] }}</div>
        <div class="stat-label">عملاء نشطين (آخر 30 يوم)</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon" style="background: linear-gradient(135deg, #f59e0b, #d97706); color: white;">
            <i class="fas fa-user-plus"></i>
        </div>
        <div class="stat-value">{{ $stats['new_this_month'] }}</div>
        <div class="stat-label">عملاء جدد هذا الشهر</div>
    </div>
</div>

<!-- Filters & Search -->
<div class="card" style="margin-bottom: 1.5rem;">
    <form method="GET" action="{{ route('admin.customers.index') }}">
        <div style="display: grid; grid-template-columns: 1fr auto auto; gap: 1rem; align-items: end;">
            <!-- Search -->
            <div>
                <label class="form-label">بحث</label>
                <input type="text" name="search" class="form-input" placeholder="ابحث بالاسم، البريد الإلكتروني، أو الجوال..." value="{{ request('search') }}">
            </div>
            
            <!-- Sort -->
            <div>
                <label class="form-label">ترتيب</label>
                <select name="sort" class="form-input">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>الأحدث</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>الأقدم</option>
                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>الاسم</option>
                    <option value="orders" {{ request('sort') == 'orders' ? 'selected' : '' }}>عدد الطلبات</option>
                </select>
            </div>
            
            <button type="submit" class="btn">
                <i class="fas fa-search"></i> بحث
            </button>
        </div>
    </form>
</div>

<!-- Customers Table -->
<div class="card">
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>البريد الإلكتروني</th>
                    <th>الجوال</th>
                    <th>عدد الطلبات</th>
                    <th>تاريخ التسجيل</th>
                    <th style="text-align: center;">الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.875rem;">
                                {{ strtoupper(substr($customer->name, 0, 1)) }}
                            </div>
                            <strong>{{ $customer->name }}</strong>
                        </div>
                    </td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone ?? '-' }}</td>
                    <td>
                        <span class="badge badge-primary">{{ $customer->orders_count }}</span>
                    </td>
                    <td>{{ $customer->created_at->format('Y-m-d') }}</td>
                    <td style="text-align: center;">
                        <div style="display: flex; gap: 0.5rem; justify-content: center;">
                            <a href="{{ route('admin.customers.show', $customer) }}" class="btn btn-sm btn-secondary" title="عرض التفاصيل">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-sm btn-primary" title="تعديل">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد من حذف هذا العميل؟')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="حذف">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 3rem;">
                        <i class="fas fa-users" style="font-size: 3rem; color: var(--gray-300); margin-bottom: 1rem;"></i>
                        <p style="color: var(--gray-500);">لا يوجد عملاء</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($customers->hasPages())
    <div style="padding: 1rem; border-top: 1px solid var(--border-color);">
        {{ $customers->links() }}
    </div>
    @endif
</div>

@endsection

