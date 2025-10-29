@extends('layouts.app')

@section('content')
<div style="max-width: 800px; margin: 2rem auto; padding: 0 1rem;">
    <!-- Page Header -->
    <div style="background: linear-gradient(135deg, #10b981, #059669); color: white; border-radius: 16px; padding: 2rem; margin-bottom: 2rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h1 style="font-size: 1.75rem; font-weight: 700; margin-bottom: 0.5rem;">
                    <i class="fas fa-file-invoice"></i> فاتورة ضريبية
                </h1>
                <p style="opacity: 0.9; font-size: 0.95rem;">Simplified Tax Invoice</p>
            </div>
            <div style="text-align: left;">
                <div style="font-size: 1.5rem; font-weight: 700;">{{ $invoice->invoice_number }}</div>
                <div style="opacity: 0.9; font-size: 0.875rem;">{{ $invoice->invoice_date->format('Y-m-d') }}</div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div style="display: flex; gap: 1rem; margin-bottom: 2rem; flex-wrap: wrap;">
        <a href="{{ route('invoices.pdf', $invoice->id) }}" target="_blank" 
           style="flex: 1; min-width: 200px; display: flex; align-items: center; justify-content: center; gap: 0.5rem; background: linear-gradient(135deg, #3b82f6, #2563eb); color: white; padding: 1rem; border-radius: 12px; text-decoration: none; font-weight: 600; transition: all 0.3s; box-shadow: 0 2px 4px rgba(0,0,0,0.1);"
           onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.15)'"
           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.1)'">
            <i class="fas fa-eye"></i> عرض PDF
        </a>
        <a href="{{ route('invoices.download', $invoice->id) }}" 
           style="flex: 1; min-width: 200px; display: flex; align-items: center; justify-content: center; gap: 0.5rem; background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 1rem; border-radius: 12px; text-decoration: none; font-weight: 600; transition: all 0.3s; box-shadow: 0 2px 4px rgba(0,0,0,0.1);"
           onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 8px rgba(0,0,0,0.15)'"
           onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 4px rgba(0,0,0,0.1)'">
            <i class="fas fa-download"></i> تحميل PDF
        </a>
        <a href="{{ route('orders.show', $invoice->order_id) }}" 
           style="flex: 1; min-width: 200px; display: flex; align-items: center; justify-content: center; gap: 0.5rem; background: white; color: #4b5563; padding: 1rem; border-radius: 12px; text-decoration: none; font-weight: 600; border: 2px solid #e5e7eb; transition: all 0.3s;"
           onmouseover="this.style.borderColor='#10b981'; this.style.color='#10b981'"
           onmouseout="this.style.borderColor='#e5e7eb'; this.style.color='#4b5563'">
            <i class="fas fa-shopping-bag"></i> الطلب
        </a>
    </div>

    <!-- Invoice Details Card -->
    <div style="background: white; border-radius: 16px; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); margin-bottom: 2rem;">
        <!-- Seller Info -->
        <div style="border-bottom: 2px solid #f3f4f6; padding-bottom: 1.5rem; margin-bottom: 1.5rem;">
            <h2 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 1rem;">
                <i class="fas fa-building" style="color: #10b981;"></i> معلومات البائع
            </h2>
            <div style="display: grid; gap: 0.75rem;">
                <div style="display: flex; justify-content: space-between; padding: 0.5rem 0;">
                    <span style="color: #6b7280; font-weight: 600;">اسم المنشأة:</span>
                    <span style="color: #1f2937; font-weight: 700;">{{ $invoice->seller_name_ar }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 0.5rem 0;">
                    <span style="color: #6b7280; font-weight: 600;">الرقم الضريبي:</span>
                    <span style="color: #1f2937; font-weight: 700; font-family: monospace;">{{ $invoice->vat_number }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 0.5rem 0;">
                    <span style="color: #6b7280; font-weight: 600;">رقم السجل التجاري:</span>
                    <span style="color: #1f2937; font-weight: 700;">{{ $invoice->cr_number }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 0.5rem 0;">
                    <span style="color: #6b7280; font-weight: 600;">العنوان:</span>
                    <span style="color: #1f2937;">{{ $invoice->seller_address }}</span>
                </div>
            </div>
        </div>

        <!-- Invoice Info -->
        <div style="border-bottom: 2px solid #f3f4f6; padding-bottom: 1.5rem; margin-bottom: 1.5rem;">
            <h2 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 1rem;">
                <i class="fas fa-file-alt" style="color: #3b82f6;"></i> تفاصيل الفاتورة
            </h2>
            <div style="display: grid; gap: 0.75rem;">
                <div style="display: flex; justify-content: space-between; padding: 0.5rem 0;">
                    <span style="color: #6b7280; font-weight: 600;">رقم الفاتورة:</span>
                    <span style="color: #1f2937; font-weight: 700;">{{ $invoice->invoice_number }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 0.5rem 0;">
                    <span style="color: #6b7280; font-weight: 600;">التاريخ والوقت:</span>
                    <span style="color: #1f2937;">{{ $invoice->invoice_date->format('Y-m-d h:i A') }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; padding: 0.5rem 0;">
                    <span style="color: #6b7280; font-weight: 600;">UUID:</span>
                    <span style="color: #1f2937; font-size: 0.75rem; font-family: monospace;">{{ $invoice->uuid }}</span>
                </div>
            </div>
        </div>

        <!-- Line Items -->
        <div style="margin-bottom: 1.5rem;">
            <h2 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 1rem;">
                <i class="fas fa-list" style="color: #f59e0b;"></i> المنتجات
            </h2>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: linear-gradient(135deg, #f3f4f6, #e5e7eb);">
                            <th style="padding: 0.75rem; text-align: right; font-weight: 700; color: #4b5563;">#</th>
                            <th style="padding: 0.75rem; text-align: right; font-weight: 700; color: #4b5563;">المنتج</th>
                            <th style="padding: 0.75rem; text-align: right; font-weight: 700; color: #4b5563;">الكمية</th>
                            <th style="padding: 0.75rem; text-align: right; font-weight: 700; color: #4b5563;">السعر</th>
                            <th style="padding: 0.75rem; text-align: right; font-weight: 700; color: #4b5563;">الإجمالي</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->line_items as $index => $item)
                        <tr style="border-bottom: 1px solid #f3f4f6;">
                            <td style="padding: 0.75rem; color: #6b7280;">{{ $index + 1 }}</td>
                            <td style="padding: 0.75rem; color: #1f2937; font-weight: 600;">{{ $item['name'] }}</td>
                            <td style="padding: 0.75rem; color: #1f2937;">{{ $item['quantity'] }}</td>
                            <td style="padding: 0.75rem; color: #1f2937;">{{ number_format($item['unit_price'], 2) }} ر.س</td>
                            <td style="padding: 0.75rem; color: #1f2937; font-weight: 700;">{{ number_format($item['subtotal'], 2) }} ر.س</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Totals -->
        <div style="background: linear-gradient(135deg, #f9fafb, #f3f4f6); border-radius: 12px; padding: 1.5rem;">
            <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; font-size: 1rem;">
                <span style="color: #6b7280; font-weight: 600;">المجموع قبل الضريبة:</span>
                <span style="color: #1f2937; font-weight: 700;">{{ number_format($invoice->subtotal, 2) }} ر.س</span>
            </div>
            
            @if($invoice->discount_amount > 0)
            <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; font-size: 1rem;">
                <span style="color: #6b7280; font-weight: 600;">الخصم:</span>
                <span style="color: #dc2626; font-weight: 700;">- {{ number_format($invoice->discount_amount, 2) }} ر.س</span>
            </div>
            @endif
            
            @if($invoice->shipping_fee > 0)
            <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; font-size: 1rem;">
                <span style="color: #6b7280; font-weight: 600;">رسوم الشحن:</span>
                <span style="color: #1f2937; font-weight: 700;">{{ number_format($invoice->shipping_fee, 2) }} ر.س</span>
            </div>
            @endif
            
            <div style="display: flex; justify-content: space-between; padding: 0.5rem 0; font-size: 1rem;">
                <span style="color: #6b7280; font-weight: 600;">ضريبة القيمة المضافة (15%):</span>
                <span style="color: #1f2937; font-weight: 700;">{{ number_format($invoice->tax_amount, 2) }} ر.س</span>
            </div>
            
            <div style="border-top: 3px solid #10b981; margin-top: 1rem; padding-top: 1rem; display: flex; justify-content: space-between; font-size: 1.5rem;">
                <span style="color: #10b981; font-weight: 700;">الإجمالي النهائي:</span>
                <span style="color: #10b981; font-weight: 700;">{{ number_format($invoice->total_amount, 2) }} ر.س</span>
            </div>
        </div>
    </div>

    <!-- QR Code Card -->
    <div style="background: white; border-radius: 16px; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); text-align: center;">
        <h2 style="font-size: 1.25rem; font-weight: 700; color: #1f2937; margin-bottom: 1rem;">
            <i class="fas fa-qrcode" style="color: #10b981;"></i> رمز التحقق ZATCA
        </h2>
        <div style="display: inline-block; padding: 1.5rem; border: 3px solid #e5e7eb; border-radius: 16px; background: #f9fafb;">
            <img src="data:image/png;base64,{{ $invoice->qr_code_image }}" 
                 alt="QR Code" 
                 style="width: 200px; height: 200px; display: block;">
        </div>
        <p style="margin-top: 1rem; color: #6b7280; font-size: 0.95rem;">
            <i class="fas fa-info-circle"></i> امسح الرمز للتحقق من صحة الفاتورة
        </p>
    </div>
</div>
@endsection

