@extends('layouts.app')

@section('title', 'قائمة الرغبات')

@section('content')
<div style="max-width: 1200px; margin: 2rem auto; padding: 0 1rem;">
    <!-- Page Header -->
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">
            <i class="fas fa-heart" style="color: var(--danger);"></i> قائمة الرغبات
        </h1>
        <p style="color: var(--gray-600);">المنتجات المفضلة لديك</p>
    </div>

    @if(session('success'))
    <div style="background: #d1fae5; border: 1px solid #6ee7b7; color: #065f46; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    @if(session('info'))
    <div style="background: #dbeafe; border: 1px solid #93c5fd; color: #1e40af; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
        <i class="fas fa-info-circle"></i> {{ session('info') }}
    </div>
    @endif

    @if($wishlists->count() > 0)
    <!-- Actions Bar -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; padding: 1rem; background: white; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <span style="color: var(--gray-600);">
            <strong>{{ $wishlists->count() }}</strong> منتج في قائمة الرغبات
        </span>
        <form action="{{ route('wishlist.move-all-to-cart') }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-primary" style="display: flex; align-items: center; gap: 0.5rem;">
                <i class="fas fa-shopping-cart"></i> نقل الكل للسلة
            </button>
        </form>
    </div>

    <!-- Wishlist Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 1.5rem;">
        @foreach($wishlists as $wishlist)
        @php $product = $wishlist->product; @endphp
        @if($product)
        <div style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: all 0.3s; position: relative;">
            <!-- Product Image -->
            <a href="{{ route('products.show', $product) }}" style="display: block; position: relative; padding-top: 100%; overflow: hidden; background: var(--gray-100);">
                @if($product->images && count($product->images) > 0)
                <img src="{{ asset('storage/' . $product->images[0]) }}" alt="{{ $product->name }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                @else
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; color: var(--gray-400);">
                    <i class="fas fa-image" style="font-size: 3rem;"></i>
                </div>
                @endif
                
                <!-- Stock Badge -->
                @if(!$product->isInStock())
                <span style="position: absolute; top: 10px; right: 10px; background: var(--danger); color: white; padding: 0.25rem 0.75rem; border-radius: 6px; font-size: 0.875rem; font-weight: 600;">
                    نفذ المخزون
                </span>
                @endif
            </a>
            
            <!-- Remove Button -->
            <form action="{{ route('wishlist.destroy', $wishlist) }}" method="POST" style="position: absolute; top: 10px; left: 10px;">
                @csrf
                @method('DELETE')
                <button type="submit" style="width: 36px; height: 36px; background: white; border: none; border-radius: 50%; cursor: pointer; box-shadow: 0 2px 4px rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: center; color: var(--danger); transition: all 0.3s;" onmouseover="this.style.background='var(--danger)'; this.style.color='white';" onmouseout="this.style.background='white'; this.style.color='var(--danger)';">
                    <i class="fas fa-trash"></i>
                </button>
            </form>
            
            <!-- Product Info -->
            <div style="padding: 1rem;">
                <a href="{{ route('products.show', $product) }}" style="text-decoration: none; color: inherit;">
                    <h3 style="font-size: 1rem; font-weight: 600; margin: 0 0 0.5rem 0; color: var(--gray-900); display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        {{ $product->name }}
                    </h3>
                </a>
                
                @if($product->category)
                <p style="color: var(--gray-500); font-size: 0.875rem; margin: 0 0 0.75rem 0;">
                    {{ $product->category->name }}
                </p>
                @endif
                
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                    @if($product->discount_price)
                    <div>
                        <span style="font-size: 1.25rem; font-weight: 700; color: var(--danger);">
                            {{ number_format($product->discount_price, 2) }} ر.س
                        </span>
                        <span style="font-size: 0.875rem; color: var(--gray-400); text-decoration: line-through; display: block;">
                            {{ number_format($product->regular_price, 2) }} ر.س
                        </span>
                    </div>
                    @else
                    <span style="font-size: 1.25rem; font-weight: 700; color: var(--primary);">
                        {{ number_format($product->regular_price, 2) }} ر.س
                    </span>
                    @endif
                </div>
                
                <!-- Add to Cart Button -->
                @if($product->isInStock())
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" style="width: 100%; padding: 0.75rem; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 0.5rem;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(16, 185, 129, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                        <i class="fas fa-cart-plus"></i> أضف للسلة
                    </button>
                </form>
                @else
                <button disabled style="width: 100%; padding: 0.75rem; background: var(--gray-200); color: var(--gray-500); border: none; border-radius: 8px; font-weight: 600; cursor: not-allowed;">
                    غير متوفر
                </button>
                @endif
            </div>
        </div>
        @endif
        @endforeach
    </div>
    @else
    <!-- Empty State -->
    <div style="text-align: center; padding: 4rem 1rem; background: white; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <i class="fas fa-heart" style="font-size: 5rem; color: var(--gray-300); margin-bottom: 1.5rem;"></i>
        <h2 style="font-size: 1.5rem; font-weight: 700; color: var(--gray-900); margin-bottom: 0.5rem;">
            قائمة الرغبات فارغة
        </h2>
        <p style="color: var(--gray-600); margin-bottom: 2rem;">
            لم تقم بإضافة أي منتجات لقائمة الرغبات بعد
        </p>
        <a href="{{ route('products.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; text-decoration: none; border-radius: 8px; font-weight: 600; transition: all 0.3s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(16, 185, 129, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none';">
            <i class="fas fa-shopping-bag"></i> تصفح المنتجات
        </a>
    </div>
    @endif
</div>

<style>
:root {
    --primary: #10b981;
    --primary-dark: #059669;
    --danger: #ef4444;
    --gray-100: #f3f4f6;
    --gray-200: #e5e7eb;
    --gray-300: #d1d5db;
    --gray-400: #9ca3af;
    --gray-500: #6b7280;
    --gray-600: #4b5563;
    --gray-900: #111827;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
    display: inline-block;
}

.btn-primary {
    background: linear-gradient(135deg, var(--primary), var(--primary-dark));
    color: white;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}
</style>

@endsection

