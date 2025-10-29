@extends('layouts.app')

@section('title', 'تفاصيل الطلب #' . str_pad($order->id, 6, '0', STR_PAD_LEFT))

@section('content')
<div class="container" style="padding-top: 2rem; padding-bottom: 4rem;">
    <!-- Breadcrumb -->
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('profile.orders') }}" style="color: var(--gray-600); text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; font-weight: 600; transition: all 0.2s;" onmouseover="this.style.color='var(--primary)'" onmouseout="this.style.color='var(--gray-600)'">
            <i class="fas fa-arrow-right"></i>
            العودة لطلباتي
        </a>
    </div>

    <!-- Header -->
    <div style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white; padding: 2.5rem; border-radius: 20px; margin-bottom: 1.5rem; box-shadow: 0 10px 30px rgba(16,185,129,0.2);">
        <div style="display: flex; justify-content: space-between; align-items: start;">
            <div>
                <h1 style="font-size: 2rem; font-weight: 900; margin-bottom: 0.5rem;">
                    <i class="fas fa-receipt"></i> طلب #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
                </h1>
                <p style="opacity: 0.9;">تاريخ الطلب: {{ $order->created_at->format('Y-m-d h:i A') }}</p>
            </div>
            <div style="text-align: left;">
                <div style="font-size: 0.875rem; opacity: 0.9; margin-bottom: 0.25rem;">إجمالي المبلغ</div>
                <div style="font-size: 2rem; font-weight: 900;">{{ number_format($order->total, 2) }} ر.س</div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    @if($order->invoice)
    <div style="display: flex; gap: 1rem; margin-bottom: 3rem; flex-wrap: wrap;">
        <a href="{{ route('invoices.show', $order->invoice->id) }}" 
           style="flex: 1; min-width: 200px; display: flex; align-items: center; justify-content: center; gap: 0.75rem; background: white; color: var(--primary); padding: 1rem 1.5rem; border-radius: 12px; text-decoration: none; font-weight: 700; border: 2px solid var(--primary); transition: all 0.3s; box-shadow: 0 2px 8px rgba(16,185,129,0.1);"
           onmouseover="this.style.background='var(--primary)'; this.style.color='white'"
           onmouseout="this.style.background='white'; this.style.color='var(--primary)'">
            <i class="fas fa-file-invoice"></i> عرض الفاتورة الإلكترونية
        </a>
        <a href="{{ route('invoices.pdf', $order->invoice->id) }}" target="_blank"
           style="flex: 1; min-width: 200px; display: flex; align-items: center; justify-content: center; gap: 0.75rem; background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; padding: 1rem 1.5rem; border-radius: 12px; text-decoration: none; font-weight: 700; transition: all 0.3s; box-shadow: 0 2px 8px rgba(59,130,246,0.2);"
           onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(59,130,246,0.3)'"
           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(59,130,246,0.2)'">
            <i class="fas fa-eye"></i> عرض PDF
        </a>
        <a href="{{ route('invoices.download', $order->invoice->id) }}"
           style="flex: 1; min-width: 200px; display: flex; align-items: center; justify-content: center; gap: 0.75rem; background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 1rem 1.5rem; border-radius: 12px; text-decoration: none; font-weight: 700; transition: all 0.3s; box-shadow: 0 2px 8px rgba(16,185,129,0.2);"
           onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 12px rgba(16,185,129,0.3)'"
           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(16,185,129,0.2)'">
            <i class="fas fa-download"></i> تحميل الفاتورة
        </a>
    </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 400px; gap: 2rem; align-items: start;">
        <!-- Left Column -->
        <div style="display: flex; flex-direction: column; gap: 2rem;">
            <!-- Order Status Timeline -->
            <div style="background: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); padding: 2rem; border: 1px solid var(--gray-200);">
                <h2 style="font-size: 1.25rem; font-weight: 900; color: var(--dark); margin-bottom: 2rem; display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fas fa-truck" style="color: var(--primary);"></i>
                    تتبع حالة الطلب
                </h2>

                @php
                    $statuses = [
                        'pending' => ['label' => 'قيد الانتظار', 'icon' => 'clock', 'color' => '#f59e0b'],
                        'confirmed' => ['label' => 'مؤكد', 'icon' => 'check-circle', 'color' => '#3b82f6'],
                        'processing' => ['label' => 'قيد التجهيز', 'icon' => 'box', 'color' => '#8b5cf6'],
                        'shipped' => ['label' => 'تم الشحن', 'icon' => 'shipping-fast', 'color' => '#06b6d4'],
                        'delivered' => ['label' => 'تم التوصيل', 'icon' => 'check-double', 'color' => '#10b981'],
                    ];
                    $statusKeys = array_keys($statuses);
                    $currentIndex = array_search($order->status, $statusKeys);
                    if ($currentIndex === false) $currentIndex = 0;
                @endphp

                <div style="position: relative; padding: 1rem 0;">
                    @foreach($statuses as $key => $status)
                    @php
                        $index = array_search($key, $statusKeys);
                        $isActive = $index <= $currentIndex;
                        $isCurrent = $key === $order->status;
                    @endphp
                    <div style="display: flex; align-items: center; gap: 1.5rem; position: relative; z-index: 2; margin-bottom: {{ $loop->last ? '0' : '2rem' }};">
                        <div style="width: 48px; height: 48px; background: {{ $isActive ? $status['color'] : 'var(--gray-300)' }}; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 4px 12px {{ $isActive ? $status['color'].'40' : 'transparent' }}; transition: all 0.3s;">
                            <i class="fas fa-{{ $status['icon'] }}" style="font-size: 1.25rem; color: white;"></i>
                        </div>
                        <div style="flex: 1;">
                            <div style="font-weight: {{ $isCurrent ? '900' : '700' }}; color: {{ $isActive ? 'var(--dark)' : 'var(--gray-500)' }}; font-size: {{ $isCurrent ? '1.0625rem' : '1rem' }};">
                                {{ $status['label'] }}
                                @if($isCurrent)
                                <span style="background: {{ $status['color'] }}; color: white; padding: 0.25rem 0.625rem; border-radius: 12px; font-size: 0.75rem; margin-right: 0.5rem;">الحالة الحالية</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if(!$loop->last)
                    <div style="position: absolute; right: 23px; top: {{ ($index * 5) + 3 }}rem; width: 2px; height: 2rem; background: {{ $isActive ? $status['color'] : 'var(--gray-300)' }}; z-index: 1;"></div>
                    @endif
                    @endforeach
                </div>
            </div>

            <!-- Order Items -->
            <div style="background: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); padding: 2rem; border: 1px solid var(--gray-200);">
                <h2 style="font-size: 1.25rem; font-weight: 900; color: var(--dark); margin-bottom: 2rem; display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fas fa-shopping-bag" style="color: var(--primary);"></i>
                    المنتجات ({{ $order->items->count() }})
                </h2>

                <div style="display: grid; gap: 1rem;">
                    @foreach($order->items as $item)
                    <div style="display: flex; align-items: center; gap: 1.5rem; padding: 1.25rem; background: var(--gray-50); border-radius: 12px;">
                        <div style="width: 80px; height: 80px; background: white; border-radius: 12px; border: 2px solid var(--gray-200); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            @if($item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name_ar }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">
                            @else
                            <i class="fas fa-box" style="font-size: 2rem; color: var(--gray-400);"></i>
                            @endif
                        </div>
                        <div style="flex: 1;">
                            <h3 style="font-weight: 700; color: var(--dark); margin-bottom: 0.5rem; font-size: 1.0625rem;">
                                {{ $item->product->name_ar }}
                            </h3>
                            <div style="display: flex; gap: 2rem; color: var(--gray-600); font-size: 0.9375rem;">
                                <span><i class="fas fa-coins" style="color: var(--primary); margin-left: 0.25rem;"></i> {{ number_format($item->price, 2) }} ر.س</span>
                                <span><i class="fas fa-times" style="color: var(--gray-500); margin-left: 0.25rem;"></i> الكمية: {{ $item->quantity }}</span>
                            </div>
                        </div>
                        <div style="text-align: left; flex-shrink: 0;">
                            <div style="font-weight: 900; color: var(--primary); font-size: 1.25rem;">
                                {{ number_format($item->price * $item->quantity, 2) }} ر.س
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Shipping Address -->
            <div style="background: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); padding: 2rem; border: 1px solid var(--gray-200);">
                <h2 style="font-size: 1.25rem; font-weight: 900; color: var(--dark); margin-bottom: 2rem; display: flex; align-items: center; gap: 0.75rem;">
                    <i class="fas fa-map-marker-alt" style="color: var(--primary);"></i>
                    عنوان التوصيل
                </h2>

                @php
                    $address = $order->shipping_address;
                @endphp

                <div style="background: var(--gray-50); padding: 1.5rem; border-radius: 12px;">
                    <div style="display: grid; gap: 1rem;">
                        <div style="display: flex; align-items: start; gap: 1rem;">
                            <i class="fas fa-user" style="color: var(--primary); margin-top: 0.25rem;"></i>
                            <div>
                                <div style="font-weight: 600; color: var(--gray-700); font-size: 0.875rem; margin-bottom: 0.25rem;">الاسم</div>
                                <div style="font-weight: 700; color: var(--dark);">{{ $address['name'] ?? 'غير متوفر' }}</div>
                            </div>
                        </div>
                        <div style="display: flex; align-items: start; gap: 1rem;">
                            <i class="fas fa-phone" style="color: var(--primary); margin-top: 0.25rem;"></i>
                            <div>
                                <div style="font-weight: 600; color: var(--gray-700); font-size: 0.875rem; margin-bottom: 0.25rem;">رقم الجوال</div>
                                <div style="font-weight: 700; color: var(--dark); direction: ltr; text-align: right;">{{ $address['phone'] ?? 'غير متوفر' }}</div>
                            </div>
                        </div>
                        <div style="display: flex; align-items: start; gap: 1rem;">
                            <i class="fas fa-home" style="color: var(--primary); margin-top: 0.25rem;"></i>
                            <div style="flex: 1;">
                                <div style="font-weight: 600; color: var(--gray-700); font-size: 0.875rem; margin-bottom: 0.25rem;">العنوان الكامل</div>
                                <div style="font-weight: 700; color: var(--dark); line-height: 1.6;">
                                    {{ $address['address'] ?? 'غير متوفر' }}<br>
                                    {{ $address['city'] ?? '' }}، {{ $address['region'] ?? '' }}
                                </div>
                            </div>
                        </div>
                        @if(isset($address['latitude']) && isset($address['longitude']))
                        <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--gray-300);">
                            <a href="https://www.google.com/maps?q={{ $address['latitude'] }},{{ $address['longitude'] }}" target="_blank" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.25rem; background: var(--primary); color: white; text-decoration: none; border-radius: 8px; font-weight: 700; transition: all 0.3s;" onmouseover="this.style.background='var(--primary-dark)'" onmouseout="this.style.background='var(--primary)'">
                                <i class="fas fa-map-marked-alt"></i>
                                عرض الموقع على الخريطة
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div style="position: sticky; top: 2rem;">
            <!-- Order Summary -->
            <div style="background: white; border-radius: 16px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); padding: 2rem; border: 1px solid var(--gray-200); margin-bottom: 1.5rem;">
                <h2 style="font-size: 1.125rem; font-weight: 900; color: var(--dark); margin-bottom: 1.5rem;">
                    ملخص الطلب
                </h2>

                <div style="display: flex; flex-direction: column; gap: 0.75rem; padding-bottom: 1rem; margin-bottom: 1rem; border-bottom: 1px solid var(--gray-200);">
                    <div style="display: flex; justify-content: space-between; color: var(--gray-700);">
                        <span>المجموع الفرعي:</span>
                        <span style="font-weight: 700;">{{ number_format($order->subtotal, 2) }} ر.س</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; color: var(--gray-700);">
                        <span>الضريبة (15%):</span>
                        <span style="font-weight: 700;">{{ number_format($order->tax, 2) }} ر.س</span>
                    </div>
                </div>

                <div style="display: flex; justify-content: space-between; font-size: 1.25rem; font-weight: 900; color: var(--primary); margin-bottom: 1.5rem;">
                    <span>الإجمالي:</span>
                    <span>{{ number_format($order->total, 2) }} ر.س</span>
                </div>

                <div style="padding-top: 1rem; border-top: 1px solid var(--gray-200);">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
                        <i class="fas fa-{{ $order->payment_method === 'cod' ? 'hand-holding-usd' : 'credit-card' }}" style="color: var(--primary);"></i>
                        <span style="font-weight: 700; color: var(--dark);">
                            {{ $order->payment_method === 'cod' ? 'الدفع عند الاستلام' : 'الدفع الإلكتروني' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Help Box -->
            <div style="background: linear-gradient(135deg, #fef3c7, #fde68a); border: 2px solid #f59e0b; border-radius: 12px; padding: 1.5rem;">
                <div style="display: flex; align-items: start; gap: 1rem;">
                    <i class="fas fa-headset" style="font-size: 1.5rem; color: #d97706; margin-top: 0.125rem;"></i>
                    <div>
                        <h3 style="font-weight: 800; color: #92400e; font-size: 1rem; margin-bottom: 0.75rem;">هل تحتاج مساعدة؟</h3>
                        <p style="font-size: 0.9375rem; color: #78350f; line-height: 1.6; margin-bottom: 1rem;">
                            تواصل معنا في أي وقت وسنكون سعداء بمساعدتك
                        </p>
                        <a href="tel:+966500000000" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.25rem; background: #f59e0b; color: white; text-decoration: none; border-radius: 8px; font-weight: 700; transition: all 0.3s;" onmouseover="this.style.background='#d97706'" onmouseout="this.style.background='#f59e0b'">
                            <i class="fas fa-phone"></i>
                            اتصل بنا
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

