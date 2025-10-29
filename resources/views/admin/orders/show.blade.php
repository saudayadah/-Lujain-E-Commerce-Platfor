@extends('layouts.admin')

@section('title', 'تفاصيل الطلب #' . str_pad($order->id, 6, '0', STR_PAD_LEFT))

@section('content')
<div style="padding: 2rem;">
    <!-- Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 0.5rem;">
                <a href="{{ route('admin.orders.index') }}" style="color: var(--gray-600); text-decoration: none; display: flex; align-items: center; gap: 0.5rem; font-weight: 600; transition: all 0.2s;" onmouseover="this.style.color='var(--primary-green)'" onmouseout="this.style.color='var(--gray-600)'">
                    <i class="fas fa-arrow-right"></i>
                    العودة للطلبات
                </a>
            </div>
            <h1 style="font-size: 2rem; font-weight: 900; color: var(--dark); display: flex; align-items: center; gap: 1rem;">
                <i class="fas fa-file-invoice" style="color: var(--primary-green);"></i>
                تفاصيل الطلب #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}
            </h1>
            <p style="color: var(--gray-600); margin-top: 0.5rem;">
                تاريخ الطلب: {{ $order->created_at->format('Y-m-d h:i A') }}
            </p>
        </div>
        <div style="display: flex; gap: 1rem;">
            <button onclick="window.print()" style="padding: 0.875rem 1.5rem; background: white; border: 2px solid var(--primary-green); color: var(--primary-green); border-radius: 12px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; transition: all 0.3s;" onmouseover="this.style.background='var(--primary-green)'; this.style.color='white'" onmouseout="this.style.background='white'; this.style.color='var(--primary-green)'">
                <i class="fas fa-print"></i>
                طباعة
            </button>
        </div>
    </div>

    @if(session('success'))
    <div style="background: linear-gradient(135deg, #d1fae5, #a7f3d0); border: 2px solid var(--primary-green); border-radius: 12px; padding: 1rem 1.5rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem;">
        <i class="fas fa-check-circle" style="color: var(--primary-green); font-size: 1.5rem;"></i>
        <span style="color: #065f46; font-weight: 600;">{{ session('success') }}</span>
    </div>
    @endif

    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
        <!-- Left Column -->
        <div style="display: flex; flex-direction: column; gap: 2rem;">
            <!-- Order Items -->
            <div style="background: white; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden;">
                <div style="background: linear-gradient(135deg, var(--primary-green), #059669); padding: 1.5rem; color: white;">
                    <h2 style="font-size: 1.25rem; font-weight: 800; display: flex; align-items: center; gap: 0.75rem; margin: 0;">
                        <i class="fas fa-shopping-bag"></i>
                        المنتجات ({{ $order->items->count() }})
                    </h2>
                </div>
                <div style="padding: 1.5rem;">
                    @foreach($order->items as $item)
                    <div style="display: flex; align-items: center; gap: 1.5rem; padding: 1.25rem; background: var(--gray-50); border-radius: 12px; margin-bottom: {{ $loop->last ? '0' : '1rem' }};">
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
                                <span><i class="fas fa-coins" style="color: var(--primary-green); margin-left: 0.25rem;"></i> السعر: {{ number_format($item->price, 2) }} ر.س</span>
                                <span><i class="fas fa-times" style="color: var(--gray-500); margin-left: 0.25rem;"></i> الكمية: {{ $item->quantity }}</span>
                            </div>
                        </div>
                        <div style="text-align: left; flex-shrink: 0;">
                            <div style="font-weight: 900; color: var(--primary-green); font-size: 1.25rem;">
                                {{ number_format($item->price * $item->quantity, 2) }} ر.س
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Shipping Address -->
            <div style="background: white; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden;">
                <div style="background: linear-gradient(135deg, #3b82f6, #2563eb); padding: 1.5rem; color: white;">
                    <h2 style="font-size: 1.25rem; font-weight: 800; display: flex; align-items: center; gap: 0.75rem; margin: 0;">
                        <i class="fas fa-map-marker-alt"></i>
                        عنوان التوصيل
                    </h2>
                </div>
                <div style="padding: 1.5rem;">
                    @php
                        $address = $order->shipping_address;
                    @endphp
                    <div style="display: grid; gap: 1rem;">
                        <div style="display: flex; align-items: start; gap: 1rem;">
                            <div style="width: 36px; height: 36px; background: #dbeafe; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-user" style="color: #3b82f6;"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600; color: var(--gray-700); font-size: 0.875rem; margin-bottom: 0.25rem;">الاسم</div>
                                <div style="font-weight: 700; color: var(--dark);">{{ $address['name'] ?? 'غير متوفر' }}</div>
                            </div>
                        </div>
                        <div style="display: flex; align-items: start; gap: 1rem;">
                            <div style="width: 36px; height: 36px; background: #dbeafe; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-phone" style="color: #3b82f6;"></i>
                            </div>
                            <div>
                                <div style="font-weight: 600; color: var(--gray-700); font-size: 0.875rem; margin-bottom: 0.25rem;">رقم الجوال</div>
                                <div style="font-weight: 700; color: var(--dark); direction: ltr; text-align: right;">{{ $address['phone'] ?? 'غير متوفر' }}</div>
                            </div>
                        </div>
                        <div style="display: flex; align-items: start; gap: 1rem;">
                            <div style="width: 36px; height: 36px; background: #dbeafe; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <i class="fas fa-home" style="color: #3b82f6;"></i>
                            </div>
                            <div style="flex: 1;">
                                <div style="font-weight: 600; color: var(--gray-700); font-size: 0.875rem; margin-bottom: 0.25rem;">العنوان</div>
                                <div style="font-weight: 700; color: var(--dark); line-height: 1.6;">{{ $address['address'] ?? 'غير متوفر' }}</div>
                            </div>
                        </div>
                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div style="display: flex; align-items: start; gap: 1rem;">
                                <div style="width: 36px; height: 36px; background: #dbeafe; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="fas fa-city" style="color: #3b82f6;"></i>
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: var(--gray-700); font-size: 0.875rem; margin-bottom: 0.25rem;">المدينة</div>
                                    <div style="font-weight: 700; color: var(--dark);">{{ $address['city'] ?? 'غير متوفر' }}</div>
                                </div>
                            </div>
                            <div style="display: flex; align-items: start; gap: 1rem;">
                                <div style="width: 36px; height: 36px; background: #dbeafe; border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                    <i class="fas fa-map" style="color: #3b82f6;"></i>
                                </div>
                                <div>
                                    <div style="font-weight: 600; color: var(--gray-700); font-size: 0.875rem; margin-bottom: 0.25rem;">المنطقة</div>
                                    <div style="font-weight: 700; color: var(--dark);">{{ $address['region'] ?? 'غير متوفر' }}</div>
                                </div>
                            </div>
                        </div>
                        @if(isset($address['latitude']) && isset($address['longitude']))
                        <div style="margin-top: 1rem; border-top: 1px solid var(--gray-200); padding-top: 1rem;">
                            <a href="https://www.google.com/maps?q={{ $address['latitude'] }},{{ $address['longitude'] }}" target="_blank" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.25rem; background: #3b82f6; color: white; text-decoration: none; border-radius: 8px; font-weight: 700; transition: all 0.3s;" onmouseover="this.style.background='#2563eb'" onmouseout="this.style.background='#3b82f6'">
                                <i class="fas fa-map-marked-alt"></i>
                                عرض الموقع على الخريطة
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            @if($order->notes)
            <!-- Notes -->
            <div style="background: white; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden;">
                <div style="background: linear-gradient(135deg, #f59e0b, #d97706); padding: 1.5rem; color: white;">
                    <h2 style="font-size: 1.25rem; font-weight: 800; display: flex; align-items: center; gap: 0.75rem; margin: 0;">
                        <i class="fas fa-sticky-note"></i>
                        ملاحظات العميل
                    </h2>
                </div>
                <div style="padding: 1.5rem;">
                    <p style="color: var(--dark); line-height: 1.8; margin: 0;">{{ $order->notes }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column -->
        <div style="display: flex; flex-direction: column; gap: 2rem;">
            <!-- Order Summary -->
            <div style="background: white; border-radius: 16px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); overflow: hidden; position: sticky; top: 2rem;">
                <div style="background: linear-gradient(135deg, var(--primary-green), #059669); padding: 1.5rem; color: white;">
                    <h2 style="font-size: 1.25rem; font-weight: 800; display: flex; align-items: center; gap: 0.75rem; margin: 0;">
                        <i class="fas fa-receipt"></i>
                        ملخص الطلب
                    </h2>
                </div>
                <div style="padding: 1.5rem;">
                    <!-- Status -->
                    <div style="margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--gray-200);">
                        <div style="font-weight: 600; color: var(--gray-700); font-size: 0.875rem; margin-bottom: 0.75rem;">حالة الطلب</div>
                        @php
                            $statusColors = [
                                'pending' => '#f59e0b',
                                'confirmed' => '#3b82f6',
                                'processing' => '#8b5cf6',
                                'shipped' => '#06b6d4',
                                'delivered' => '#10b981',
                                'cancelled' => '#ef4444',
                                'refunded' => '#6b7280'
                            ];
                            $statusLabels = [
                                'pending' => 'قيد الانتظار',
                                'confirmed' => 'مؤكد',
                                'processing' => 'قيد التجهيز',
                                'shipped' => 'تم الشحن',
                                'delivered' => 'تم التوصيل',
                                'cancelled' => 'ملغي',
                                'refunded' => 'مسترد'
                            ];
                        @endphp
                        <span style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; background: {{ $statusColors[$order->status] ?? '#6b7280' }}; color: white; border-radius: 20px; font-weight: 700; font-size: 0.9375rem;">
                            <i class="fas fa-circle" style="font-size: 0.5rem;"></i>
                            {{ $statusLabels[$order->status] ?? $order->status }}
                        </span>
                    </div>

                    <!-- Customer Info -->
                    <div style="margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--gray-200);">
                        <div style="font-weight: 600; color: var(--gray-700); font-size: 0.875rem; margin-bottom: 0.75rem;">معلومات العميل</div>
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
                            <i class="fas fa-user" style="color: var(--primary-green);"></i>
                            <span style="font-weight: 700; color: var(--dark);">{{ $order->user->name }}</span>
                        </div>
                        @if($order->user->phone)
                        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem;">
                            <i class="fas fa-phone" style="color: var(--primary-green);"></i>
                            <span style="font-weight: 600; color: var(--dark); direction: ltr; text-align: right;">{{ $order->user->phone }}</span>
                        </div>
                        @endif
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <i class="fas fa-envelope" style="color: var(--primary-green);"></i>
                            <span style="font-weight: 600; color: var(--dark); font-size: 0.875rem; word-break: break-all;">{{ $order->user->email }}</span>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div style="margin-bottom: 1.5rem; padding-bottom: 1.5rem; border-bottom: 1px solid var(--gray-200);">
                        <div style="font-weight: 600; color: var(--gray-700); font-size: 0.875rem; margin-bottom: 0.75rem;">طريقة الدفع</div>
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <i class="fas fa-{{ $order->payment_method === 'cod' ? 'hand-holding-usd' : 'credit-card' }}" style="color: var(--primary-green);"></i>
                            <span style="font-weight: 700; color: var(--dark);">
                                {{ $order->payment_method === 'cod' ? 'الدفع عند الاستلام' : 'الدفع الإلكتروني' }}
                            </span>
                        </div>
                    </div>

                    <!-- Price Breakdown -->
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <div style="display: flex; justify-content: space-between; color: var(--gray-700);">
                            <span>المجموع الفرعي:</span>
                            <span style="font-weight: 700;">{{ number_format($order->subtotal, 2) }} ر.س</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; color: var(--gray-700);">
                            <span>الضريبة (15%):</span>
                            <span style="font-weight: 700;">{{ number_format($order->tax, 2) }} ر.س</span>
                        </div>
                        <div style="border-top: 2px solid var(--gray-200); padding-top: 0.75rem; display: flex; justify-content: space-between; font-size: 1.25rem; font-weight: 900; color: var(--primary-green);">
                            <span>الإجمالي:</span>
                            <span>{{ number_format($order->total, 2) }} ر.س</span>
                        </div>
                    </div>

                    <!-- Update Status -->
                    <form method="POST" action="{{ route('admin.orders.update-status', $order) }}" style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--gray-200);">
                        @csrf
                        @method('PATCH')
                        <label style="display: block; margin-bottom: 0.75rem; font-weight: 700; color: var(--dark); font-size: 0.9375rem;">
                            تحديث حالة الطلب
                        </label>
                        <select name="status" style="width: 100%; padding: 0.75rem; border: 2px solid var(--gray-300); border-radius: 8px; font-weight: 600; margin-bottom: 1rem; cursor: pointer; font-family: 'IBM Plex Sans Arabic', sans-serif;">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>قيد الانتظار</option>
                            <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>مؤكد</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>قيد التجهيز</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>تم الشحن</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>تم التوصيل</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>ملغي</option>
                        </select>
                        <button type="submit" style="width: 100%; padding: 0.875rem; background: var(--primary-green); color: white; border: none; border-radius: 8px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: all 0.3s; font-family: 'IBM Plex Sans Arabic', sans-serif;" onmouseover="this.style.background='#059669'" onmouseout="this.style.background='var(--primary-green)'">
                            <i class="fas fa-check"></i>
                            تحديث الحالة
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

