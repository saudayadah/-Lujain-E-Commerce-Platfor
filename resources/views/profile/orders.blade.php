@extends('layouts.app')

@section('title', 'طلباتي')

@section('content')
<div class="container" style="padding-top: 2rem; padding-bottom: 4rem;">
    <!-- Header -->
    <div style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; padding: 2.5rem; border-radius: 20px; margin-bottom: 3rem; text-align: center; box-shadow: 0 10px 30px rgba(16,185,129,0.2);">
        <h1 style="font-size: 2rem; font-weight: 900; margin-bottom: 0.5rem;">
            <i class="fas fa-shopping-bag"></i> طلباتي
        </h1>
        <p style="opacity: 0.9;">تتبع جميع طلباتك ومشترياتك</p>
    </div>

    <div style="display: grid; grid-template-columns: 300px 1fr; gap: 2rem;">
        <!-- Sidebar -->
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <a href="{{ route('profile.index') }}" style="padding: 1rem 1.5rem; background: white; color: var(--dark); text-decoration: none; border-radius: 12px; font-weight: 700; display: flex; align-items: center; gap: 0.75rem; transition: all 0.3s; border: 2px solid var(--gray-200);" onmouseover="this.style.background='var(--gray-50)'" onmouseout="this.style.background='white'">
                <i class="fas fa-user"></i>
                معلومات الحساب
            </a>
            <a href="{{ route('profile.orders') }}" style="padding: 1rem 1.5rem; background: var(--primary); color: white; text-decoration: none; border-radius: 12px; font-weight: 700; display: flex; align-items: center; gap: 0.75rem; transition: all 0.3s;">
                <i class="fas fa-shopping-bag"></i>
                <span>طلباتي</span>
                @if($orders->total() > 0)
                <span style="margin-right: auto; background: rgba(255,255,255,0.3); color: white; padding: 0.25rem 0.625rem; border-radius: 20px; font-size: 0.75rem;">{{ $orders->total() }}</span>
                @endif
            </a>
        </div>

        <!-- Orders List -->
        <div>
            @if($orders->count() > 0)
                @foreach($orders as $order)
                @php
                    $statusConfig = [
                        'pending' => [
                            'color' => '#f59e0b',
                            'bg' => 'linear-gradient(135deg, #fef3c7, #fde68a)',
                            'icon' => 'fa-clock',
                            'label' => 'قيد الانتظار',
                            'border' => '#fbbf24'
                        ],
                        'confirmed' => [
                            'color' => '#3b82f6',
                            'bg' => 'linear-gradient(135deg, #dbeafe, #bfdbfe)',
                            'icon' => 'fa-check-circle',
                            'label' => 'مؤكد',
                            'border' => '#60a5fa'
                        ],
                        'processing' => [
                            'color' => '#8b5cf6',
                            'bg' => 'linear-gradient(135deg, #e9d5ff, #d8b4fe)',
                            'icon' => 'fa-cog fa-spin',
                            'label' => 'قيد التجهيز',
                            'border' => '#a78bfa'
                        ],
                        'shipped' => [
                            'color' => '#06b6d4',
                            'bg' => 'linear-gradient(135deg, #cffafe, #a5f3fc)',
                            'icon' => 'fa-shipping-fast',
                            'label' => 'تم الشحن',
                            'border' => '#22d3ee'
                        ],
                        'delivered' => [
                            'color' => '#10b981',
                            'bg' => 'linear-gradient(135deg, #d1fae5, #a7f3d0)',
                            'icon' => 'fa-check-double',
                            'label' => 'تم التوصيل',
                            'border' => '#34d399'
                        ],
                        'cancelled' => [
                            'color' => '#ef4444',
                            'bg' => 'linear-gradient(135deg, #fee2e2, #fecaca)',
                            'icon' => 'fa-times-circle',
                            'label' => 'ملغي',
                            'border' => '#f87171'
                        ],
                        'refunded' => [
                            'color' => '#6b7280',
                            'bg' => 'linear-gradient(135deg, #f3f4f6, #e5e7eb)',
                            'icon' => 'fa-undo',
                            'label' => 'مسترد',
                            'border' => '#9ca3af'
                        ]
                    ];
                    $config = $statusConfig[$order->status] ?? $statusConfig['pending'];
                @endphp
                <div style="background: white; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); margin-bottom: 1.5rem; overflow: hidden; border: 3px solid {{ $config['border'] }}; transition: all 0.3s;" onmouseover="this.style.boxShadow='0 8px 25px rgba(0,0,0,0.12)'; this.style.transform='translateY(-4px)'" onmouseout="this.style.boxShadow='0 4px 15px rgba(0,0,0,0.08)'; this.style.transform='translateY(0)'">
                    <!-- Order Header -->
                    <div style="background: {{ $config['bg'] }}; padding: 2rem; border-bottom: 2px solid {{ $config['border'] }};">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                <div style="width: 60px; height: 60px; background: {{ $config['color'] }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; box-shadow: 0 6px 15px rgba(0,0,0,0.15);">
                                    <i class="fas {{ $config['icon'] }}" style="color: white; font-size: 1.75rem;"></i>
                                </div>
                                <div>
                                    <h3 style="font-size: 1.25rem; font-weight: 900; color: {{ $config['color'] }}; margin-bottom: 0.25rem;">
                                        {{ $config['label'] }}
                                    </h3>
                                    <p style="color: var(--dark); font-size: 0.875rem; font-weight: 600;">
                                        طلب #{{ $order->order_number }}
                                    </p>
                                </div>
                            </div>
                            <div style="text-align: left;">
                                <div style="font-size: 0.875rem; color: var(--gray-700); margin-bottom: 0.25rem; font-weight: 600;">الإجمالي</div>
                                <div style="font-size: 2rem; font-weight: 900; color: {{ $config['color'] }};">{{ number_format($order->total, 2) }}</div>
                                <div style="font-size: 0.875rem; color: var(--gray-600); font-weight: 600;">ريال سعودي</div>
                            </div>
                        </div>
                        <div style="display: flex; gap: 1.5rem; flex-wrap: wrap; padding-top: 1rem; border-top: 2px dashed {{ $config['border'] }};">
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-calendar" style="color: {{ $config['color'] }};"></i>
                                <span style="color: var(--dark); font-weight: 600; font-size: 0.875rem;">{{ $order->created_at->format('Y-m-d h:i A') }}</span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-credit-card" style="color: {{ $config['color'] }};"></i>
                                <span style="color: var(--dark); font-weight: 600; font-size: 0.875rem;">
                                    @if($order->payment_method === 'cod')
                                        الدفع عند الاستلام
                                    @else
                                        دفع إلكتروني
                                    @endif
                                </span>
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <i class="fas fa-box" style="color: {{ $config['color'] }};"></i>
                                <span style="color: var(--dark); font-weight: 600; font-size: 0.875rem;">{{ $order->items->count() }} منتج</span>
                            </div>
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div style="padding: 1.5rem;">
                        <div style="display: grid; gap: 1rem; margin-bottom: 1.5rem;">
                            @foreach($order->items->take(3) as $item)
                            <div style="display: flex; align-items: center; gap: 1rem; padding: 1rem; background: var(--gray-50); border-radius: 12px;">
                                <div style="width: 60px; height: 60px; background: white; border-radius: 8px; border: 2px solid var(--gray-200); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    @if($item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name_ar }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 6px;">
                                    @else
                                    <i class="fas fa-box" style="font-size: 1.5rem; color: var(--gray-400);"></i>
                                    @endif
                                </div>
                                <div style="flex: 1;">
                                    <div style="font-weight: 700; color: var(--dark); margin-bottom: 0.25rem;">{{ $item->product->name_ar }}</div>
                                    <div style="color: var(--gray-600); font-size: 0.875rem;">
                                        الكمية: {{ $item->quantity }} × {{ number_format($item->price, 2) }} ر.س
                                    </div>
                                </div>
                                <div style="font-weight: 900; color: var(--primary);">
                                    {{ number_format($item->price * $item->quantity, 2) }} ر.س
                                </div>
                            </div>
                            @endforeach
                            
                            @if($order->items->count() > 3)
                            <div style="text-align: center; color: var(--gray-600); font-size: 0.875rem; padding: 0.5rem;">
                                <i class="fas fa-ellipsis-h"></i>
                                و {{ $order->items->count() - 3 }} منتجات أخرى
                            </div>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div style="display: flex; gap: 1rem; padding-top: 1rem; border-top: 1px solid var(--gray-200);">
                            <a href="{{ route('profile.orders.show', $order) }}" style="flex: 1; padding: 0.875rem; background: var(--primary); color: white; text-decoration: none; border-radius: 10px; font-weight: 700; text-align: center; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: all 0.3s;" onmouseover="this.style.background='var(--primary-dark)'" onmouseout="this.style.background='var(--primary)'">
                                <i class="fas fa-eye"></i>
                                عرض التفاصيل
                            </a>
                            <a href="{{ route('profile.orders.show', $order) }}" style="flex: 1; padding: 0.875rem; background: white; color: var(--primary); text-decoration: none; border-radius: 10px; font-weight: 700; text-align: center; border: 2px solid var(--primary); display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: all 0.3s;" onmouseover="this.style.background='var(--primary)'; this.style.color='white'" onmouseout="this.style.background='white'; this.style.color='var(--primary)'">
                                <i class="fas fa-truck"></i>
                                تتبع الطلب
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Pagination -->
                @if($orders->hasPages())
                <div style="margin-top: 2rem;">
                    {{ $orders->links() }}
                </div>
                @endif
            @else
                <!-- Empty State -->
                <div style="background: white; border-radius: 20px; padding: 4rem 2rem; text-align: center; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
                    <div style="width: 120px; height: 120px; background: var(--gray-100); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem;">
                        <i class="fas fa-shopping-bag" style="font-size: 3rem; color: var(--gray-400);"></i>
                    </div>
                    <h2 style="font-size: 1.5rem; font-weight: 900; color: var(--dark); margin-bottom: 1rem;">
                        لا توجد طلبات بعد
                    </h2>
                    <p style="color: var(--gray-600); font-size: 1.0625rem; margin-bottom: 2rem;">
                        ابدأ بتصفح منتجاتنا وقم بأول طلب لك
                    </p>
                    <a href="{{ route('products.index') }}" style="display: inline-flex; align-items: center; gap: 0.75rem; padding: 1rem 2rem; background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; text-decoration: none; border-radius: 12px; font-weight: 700; font-size: 1.0625rem; transition: all 0.3s; box-shadow: 0 4px 12px rgba(16,185,129,0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(16,185,129,0.4)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(16,185,129,0.3)'">
                        <i class="fas fa-shopping-basket"></i>
                        تصفح المنتجات
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

