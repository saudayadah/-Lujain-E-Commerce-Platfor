@extends('layouts.app')

@section('title', '404')

@section('content')
<div style="text-align: center; padding: 5rem 2rem;">
    <h1 style="font-size: 5rem; font-weight: 900; color: var(--dark-green);">404</h1>
    <p style="font-size: 1.5rem; color: var(--text-light); margin-bottom: 2rem;">
        {{ app()->getLocale() == 'ar' ? 'الصفحة غير موجودة' : 'Page Not Found' }}
    </p>
    <a href="{{ route('home') }}" class="btn">
        <i class="fas fa-home"></i> {{ app()->getLocale() == 'ar' ? 'العودة للرئيسية' : 'Back to Home' }}
    </a>
</div>
@endsection

